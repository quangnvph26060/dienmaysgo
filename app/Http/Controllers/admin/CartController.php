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
        $carts = session()->get('cart')['shopping'];
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

    public function delItemCart($id)
    {
        if (!$id) {
            return redirect()->back(['status' => 'errors']);
        }
        Log::info('xóa');
        $cart = session()->get('cart');
        $lastDeletedProduct = null;
        if (isset($cart['shopping'])) {
            foreach ($cart['shopping'] as $key => $item) {
                if ($item->id == $id) {

                    if (count($cart['shopping']) == 1) {
                        // Lưu thông tin sản phẩm cuối cùng vào session để khôi phục
                        $lastDeletedProduct = $item;
                        session()->put('last_deleted_product', $item);
                    }

                    unset($cart['shopping'][$key]);
                    break;
                }
            }
            Log::info($lastDeletedProduct);
            session()->put('cart', $cart);
            $count = count($cart['shopping']);
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa sản phẩm thành công',
                'count' => $count,
                'lastDeletedProduct' => $lastDeletedProduct
            ]);
        }
        return response()->json(['status' => 'error', 'message' => 'Giỏ hàng không tồn tại']);
    }
    public function addToCart(Request $request)
    {
        if ($request->ajax()) {

            $product = SgoProduct::findOrFail($request->id);

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
                        'image' => $product->image
                    ]
                ]);
            }

            $carts = Cart::instance('shopping');

            return response()->json([
                'status' => true,
                'message' => 'Thêm giỏ hàng thành công.',
                'carts' => $carts->content(),
                'count' => $carts->count(),
                'total' => $carts->subTotal()
            ]);
        }
    }
    public function updateQtyCart($id, $qty)
    {
        if (!$id) {
            return redirect()->back()->withErrors(['status' => 'errors', 'message' => "Không tìm thấy sản phẩm"]);
        }

        $product = SgoProduct::where('id', $id)->first();

        if (!$product) {
            return redirect()->back()->withErrors(['status' => 'errors', 'message' => "Không tìm thấy sản phẩm"]);
        }
        if ($product->quantity < $qty) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sản phẩm vượt quá'
            ]);
        }

        $cart = session()->get('cart');

        if (isset($cart['shopping'])) {
            foreach ($cart['shopping'] as $key => $item) {
                if ($item->id == $id) {
                    $item->qty = $qty;
                    break;
                }
            }

            session()->put('cart', $cart);
            $count = count($cart['shopping']);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật sản phẩm thành công',
                'count' => $count,
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Giỏ hàng không tồn tại']);
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
