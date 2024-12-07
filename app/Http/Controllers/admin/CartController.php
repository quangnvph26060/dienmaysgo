<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SgoProduct;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function list() {}

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
}
