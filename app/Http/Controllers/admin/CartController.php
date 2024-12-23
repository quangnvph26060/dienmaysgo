<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SgoProduct;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function list()
    {
        $title = 'Đơn hàng';
        $carts = Cart::instance('shopping')->content();
        $deletedItem = session()->get('last_deleted_product');
        Log::info($carts);
        return view('frontends.pages.cart', compact('carts', 'title'));
    }

    public function InfoPayment()
    {
        $title = "Thanh toán";
        $carts = Cart::instance('shopping')->content();
        $total = $this->sumCarts();
        return view('frontends.pages.payment', compact('title', 'carts', 'total'));
    }

    public function delItemCart($rowId)
    {

        Cart::instance('shopping')->remove($rowId);

        $carts = Cart::instance('shopping');

        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công.',
            'carts' => $carts->content(),
            'count' => $carts->count(),
            'total' =>  strtok($carts->subTotal(), '.')
        ]);
    }

    public function addToCart(Request $request)
    {
        if ($request->ajax()) {

            $product = SgoProduct::find($request->productId);

            $cartItem = Cart::instance('shopping')->search(function ($data) use ($product) {
                return $data->id === $product->id;
            })->first();

            $requestedQty = $request->qty ?? 1;

            if ($requestedQty > $product->quantity) {
                return response()->json([
                    'status' => false,
                    'message' => 'Số lượng sản phẩm không đủ!'
                ]);
            }

            if ($cartItem) {

                if (($cartItem->qty + $requestedQty) > $product->quantity) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Số lượng sản phẩm không đủ!'
                    ]);
                }
                Cart::instance('shopping')->update($cartItem->rowId, $cartItem->qty + $requestedQty);
            } else {
                Cart::instance('shopping')->add([
                    'id' => $product->id,
                    'name' => $product->name,
                    'qty' => $requestedQty,
                    'price' => $product->price,
                    'options' => [
                        'image' => $product->image,
                        'slug' => $product->slug,
                    ]
                ]);
            }

            $carts = Cart::instance('shopping');

            return response()->json([
                'status' => true,
                'message' => 'Thêm giỏ hàng thành công.',
                'carts' => $carts->content(),
                'count' => $carts->count(),
                'total' =>  strtok($carts->subTotal(), '.')
            ]);
        }
    }

    public function updateQtyCart($id)
    {
        if (request()->ajax()) {
            if (!$id) {
                return response()->json([
                    'message' => "ID sản phẩm không hợp lệ.",
                ], 400);
            }

            $cartItem = Cart::instance('shopping')->get($id);

            if (!$cartItem) {
                return response()->json([
                    'message' => "Sản phẩm không tồn tại trong giỏ hàng.",
                ], 404);
            }

            $product = SgoProduct::find($cartItem->id);


            $currentQuantity = $cartItem->qty;

            $newQuantity = $currentQuantity;

            if (request()->type == 'minus') {
                // Giảm số lượng sản phẩm
                if ($currentQuantity > 1) { // Đảm bảo số lượng không giảm xuống dưới 1
                    $newQuantity = $currentQuantity - 1;
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => "Số lượng sản phẩm không thể nhỏ hơn 1.",
                    ]);
                }
            } else {
                // Tăng số lượng sản phẩm
                if ($currentQuantity < $product->quantity) { // Kiểm tra số lượng tồn kho
                    $newQuantity = $currentQuantity + 1;
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => "Số lượng sản phẩm trong kho không đủ.",
                    ]);
                }
            }

            Cart::instance('shopping')->update($id, $newQuantity);

            $carts = Cart::instance('shopping');

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật giỏ hàng thành công.',
                'carts' => $carts->content(),
                'count' => $carts->count(),
                'total' =>  strtok($carts->subTotal(), '.')
            ]);
        }

        return response()->json([
            'message' => "Yêu cầu không hợp lệ.",
        ], 400);
    }


    public function sumCarts()
    {
        $carts = session()->get('cart')['shopping'] ?? [];
        $total = 0;

        foreach ($carts as $item) {
            $total += $item->subtotal;
        }
        return $total;
    }

    public function restore()
    {
        // Lấy thông tin sản phẩm cuối cùng đã xóa từ session
        $lastProduct = session()->get('last_deleted_product');

        // Kiểm tra xem thông tin sản phẩm có tồn tại không
        if ($lastProduct) {
            // Thêm sản phẩm vào giỏ hàng
            Cart::instance('shopping')->add([
                'id' => $lastProduct->id, // Truy cập mảng thay vì đối tượng
                'name' => $lastProduct->name,
                'qty' => $lastProduct->qty,
                'price' => $lastProduct->price,
                'options' => [
                    'image' => $lastProduct->image ?? null, // Kiểm tra nếu key tồn tại
                ],
            ]);

            // Xóa sản phẩm đã khôi phục khỏi session
            session()->forget('last_deleted_product');

            // Ghi log để kiểm tra


            return redirect()->back()->with('success', 'Khôi phục sản phẩm thành công');
        }

        // Nếu không có sản phẩm nào để khôi phục
        return redirect()->back()->with('error', 'Không có sản phẩm nào để khôi phục');
    }

    public function checkout(Request $request)
    {
        Log::info($request->all());
        $validatedData = $request->validate([
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_address_1' => 'required|string|max:255',
            'billing_phone' => 'required|string|max:15',
            'billing_email' => 'required|email|max:255',
        ]);

        // Thực hiện xử lý dữ liệu
        // Billing::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Thông tin đã được gửi thành công!',
        ]);
    }
}
