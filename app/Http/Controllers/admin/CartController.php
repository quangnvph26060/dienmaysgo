<?php

namespace App\Http\Controllers\admin;

use App\Events\OrderPlaced;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConfigPayment;
use App\Models\SgoOrder;
use App\Models\SgoProduct;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

        if (Cart::instance('shopping')->count() <= 0) return back();

        $title = "Thanh toán";
        $carts = Cart::instance('shopping')->content();
        $total = $this->sumCarts();

        $province = Cache::rememberForever('province',  function () {
            return DB::table('province')->pluck('name', 'province_id')->toArray();
        });

        $payments  = ConfigPayment::query()->where('published', 1)->get();

        return view('frontends.pages.payment', compact('title', 'carts', 'total', 'province', 'payments'));
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

            $product = SgoProduct::with('promotion')->find($request->productId);

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
                    'price' =>  hasDiscount($product->promotion) ? calculateAmount($product->price, $product->promotion->discount) : $product->price,
                    'options' => [
                        'image' => $product->image,
                        'slug' => $product->slug,
                    ]
                ]);
            }
            // $product->price
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
        if (Cart::instance('shopping')->count() <= 0) return url('/');

        $credentials = Validator::make(
            $request->all(),
            [
                'fullname' => 'required|min:2|max:28',
                'phone' => ['required', 'regex:/^(0[1-9]{1}[0-9]{8}|(\+84|84)[1-9]{1}[0-9]{8})$/'],
                'province' => 'required|exists:province,province_id',
                'district' => 'required|exists:district,district_id',
                'ward' => 'required|exists:wards,wards_id',
                'address' => 'nullable|max:28',
                'email' => 'required|email',
                'notes' => 'nullable|max:100',
                'payment_method' => 'required|in:cod,bacs,currency'
            ]
        );

        if ($credentials->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $credentials->errors(),
            ], 422);
        }

        $credentials = $credentials->validated();

        try {
            DB::beginTransaction();

            $credentials['address'] = $this->buildFullAddress($request);
            $credentials['total_price'] = $this->calculateTotalPrice();
            $credentials['code'] = $this->generateOrderCode();

            if ($request->payment_method == 'bacs' || $request->payment_method == 'currency') {
                return $this->paymentBacs($credentials);
            }

            $order = SgoOrder::create($credentials);

            $items = $this->mapCartItems();

            $order->products()->attach($items);

            Cart::instance('shopping')->destroy();

            event(new OrderPlaced($order));

            Cache::put('payment_success', 'Thanh toán thành công', 120);

            DB::commit();

            return response()->json([
                'status' => true,
                'redirect' => route('carts.order-success', $order->code),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function buildFullAddress(Request $request)
    {
        $addressParts = [
            DB::table('province')->select('name')->where('province_id', $request->province)->first()->name,
            DB::table('district')->select('name')->where('district_id', $request->district)->first()->name,
            DB::table('wards')->select('name')->where('wards_id', $request->ward)->first()->name,
            $request->address,
        ];

        return implode(', ', array_filter($addressParts));
    }


    private function calculateTotalPrice()
    {
        return floatval(str_replace(',', '', Cart::instance('shopping')->subtotal()));
    }

    private function generateOrderCode()
    {
        return generateRandomString();
    }

    private function mapCartItems()
    {
        $items = [];
        Cart::instance('shopping')->content()->each(function ($item) use (&$items) {
            $items[$item->id] = [
                'p_name' => $item->name,
                'p_image' => $item->options['image'],
                'p_price' => $item->price,
                'p_qty' => $item->qty,
            ];
        });
        return $items;
    }

    public function orderSuccess($code)
    {
        if (! Cache::get('payment_success')) return redirect()->route('home');

        $order = SgoOrder::query()->where('code', request('code'))->with('products')->firstOrFail();

        return view('frontends.pages.order-success', compact('order'));
    }

    public function getDistricts(Request $request)
    {
        $provinceId = $request->input('province_id');

        $districts = DB::table('district')->where('province_id', $provinceId)->pluck('name', 'district_id');

        return response()->json(['districts' => $districts]);
    }

    public function getWards(Request $request)
    {
        $districtId = $request->input('district_id');

        $wards = DB::table('wards')->where('district_id', $districtId)->pluck('name', 'wards_id');

        return response()->json(['wards' => $wards]);
    }

    private function paymentBacs($data)
    {
        $clientId = env('PAYOS_CLIENT_ID');
        $apiKey = env('PAYOS_API_KEY');
        $checksumKey = env('PAYOS_CHECKSUM_KEY');

        $total = $data['payment_method'] == 'currency' ? $data['total_price'] * (1 - ConfigPayment::query()->select('payment_percentage')->where('id', 3)->first()->payment_percentage / 100) : $data['total_price'];

        $data['payment_status'] = $data['payment_method'] == 'currency' ? 2 : 1;

        $data['deposit_amount'] = $data['payment_method'] == 'currency' ? $total : 0;

        $data['status'] = 'confirmed';

        session()->flash('payment_data', $data);
        // Dữ liệu yêu cầu
        $data = [
            "orderCode" => (int) generateRandomNumber(8),
            "amount" => $total,
            "description" => formatName($data['fullname'])  . ' CHUYEN KHOAN',

            "cancelUrl" => route('carts.thanh-toan'),
            "returnUrl" => route('carts.payment-request'),
            "expiredAt" => time() + 3600 // Hết hạn trong 1 giờ
        ];

        $data['signature'] = $this->createSignatureOfPaymentRequest($checksumKey, $data);

        $client = new Client();

        try {
            $response = $client->post('https://api-merchant.payos.vn/v2/payment-requests', [
                'headers' => [
                    'x-client-id' => $clientId,
                    'x-api-key' => $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $data
            ]);


            $responseBody = json_decode($response->getBody(), true);

            if (isset($responseBody['data']['checkoutUrl'])) {

                $paymentLink = $responseBody['data']['checkoutUrl'];
                return response()->json(['status' => true, 'paymentUrl' => $paymentLink]);
            }

            return response()->json([
                'success' => $responseBody,
                'status_code' => $response->getStatusCode(),
            ], $response->getStatusCode());
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function createSignatureOfPaymentRequest($checksumKey, $obj)
    {
        $dataStr = "amount={$obj["amount"]}&cancelUrl={$obj["cancelUrl"]}&description={$obj["description"]}&orderCode={$obj["orderCode"]}&returnUrl={$obj["returnUrl"]}";
        $signature = hash_hmac("sha256", $dataStr, $checksumKey);

        return $signature;
    }

    public function paymentRequest()
    {
        $order = SgoOrder::create(session()->get('payment_data'));

        $items = $this->mapCartItems();

        $order->products()->attach($items);

        Cart::instance('shopping')->destroy();

        event(new OrderPlaced($order));

        Cache::put('payment_success', 'Thanh toán thành công', 120);

        return redirect()->route('carts.order-success', $order->code);
    }
}
