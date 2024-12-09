<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SgoProduct;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function list()
    {
        $title = 'Đơn hàng';
        $carts = session()->get('cart')['shopping'];
        return view('frontends.pages.cart',compact('carts','title'));
    }

    public function InfoPayment(){
        $title = "Thanh toán";
        return view('frontends.pages.payment',compact('title'));
    }

    public function delItemCart($id){
        if(!$id){
            return redirect()->back(['status'=>'errors']);
        }
        $cart = session()->get('cart');

        if (isset($cart['shopping'])) {
            foreach ($cart['shopping'] as $key => $item) {
                if ($item->id == $id) {
                    unset($cart['shopping'][$key]);
                    break;
                }
            }
    
           session()->put('cart', $cart);
           $count = count($cart['shopping']);
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa sản phẩm thành công',
                'count' => $count,
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
    public function updateQtyCart($id, $qty) {
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
    
}
