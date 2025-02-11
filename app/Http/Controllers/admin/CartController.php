<?php

namespace App\Http\Controllers\admin;

use App\Events\OrderPlaced;
use App\Models\TransactionHistory;
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

    public function buyNow(Request $request)
    {
        if (!auth()->check()) {
            session()->put('url.intended', route('carts.thanh-toan'));
            return response()->json([
                'success' => false,
            ]);
        }

        $productId = $request->product_id;
        $quantity = $request->qty ?? 1;

        $product = SgoProduct::find($productId);
        if (!$product) return back();

        if ($quantity > $product->quantity) return response()->json(['success' => false, 'message' => 'Số lượng trong kho không đủ!']);

        session()->put('buy_now', [
            'id'    => $product->id,
            'name' => $product->name,
            'qty' => $quantity,
            'price' => $this->calculateProductPrice($product),
            'image' => $product->image,
        ]);

        return response()->json(['success' => true]);
    }

    public function InfoPayment()
    {
        if (!auth()->check()) {
            session()->put('url.intended', url()->current());
            return redirect(route('auth.login'));
        }

        $title = "Thanh toán";

        if (! session()->has('buy_now')) {
            if (Cart::instance('shopping')->count() <= 0) return back();
            $carts = Cart::instance('shopping')->content();

            $total = $this->sumCarts();
        } else {
            $carts = [(object) session()->get('buy_now')];
            $total = $carts[0]->price * $carts[0]->qty;
        }


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

            // Kiểm tra số lượng sản phẩm có đủ không
            $checkResult = $this->checkProductAvailability($product, $requestedQty, $cartItem);
            if (!$checkResult['status']) {
                return response()->json($checkResult);
            }

            // Tính giá sản phẩm sau giảm giá
            $price = $this->calculateProductPrice($product);

            // Thêm vào giỏ hàng
            if ($cartItem) {
                Cart::instance('shopping')->update($cartItem->rowId, $cartItem->qty + $requestedQty);
            } else {
                Cart::instance('shopping')->add([
                    'id' => $product->id,
                    'name' => $product->name,
                    'qty' => $requestedQty,
                    'price' => $price,
                    'options' => [
                        'image' => $product->image,
                        'slug' => $product->slug,
                        'catalogue' => $product->category->name
                    ]
                ]);
            }

            $carts = Cart::instance('shopping');
            return response()->json([
                'status' => true,
                'message' => 'Thêm giỏ hàng thành công.',
                'carts' => $carts->content(),
                'count' => $carts->count(),
                'total' => strtok($carts->subTotal(), '.')
            ]);
        }
    }

    private function checkProductAvailability($product, $requestedQty, $cartItem)
    {
        if ($requestedQty > $product->quantity) {
            return ['status' => false, 'message' => 'Số lượng sản phẩm không đủ!'];
        }

        if ($cartItem && ($cartItem->qty + $requestedQty) > $product->quantity) {
            return ['status' => false, 'message' => 'Số lượng sản phẩm không đủ!'];
        }

        return ['status' => true];
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

    private function calculateProductPrice($product)
    {
        // Kiểm tra giảm giá tùy chỉnh
        if (hasCustomDiscount($product->discount_start_date, $product->discount_end_date, $product->discount_value)) {
            return calculateAmount($product->price, $product->discount_value, $product->discount_type !== 'amount');
        }

        // Kiểm tra giảm giá chương trình khuyến mãi
        if (hasDiscount($product->promotion)) {
            return calculateAmount($product->price, $product->promotion->discount);
        }

        return $product->price; // Không có giảm giá, sử dụng giá gốc
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

    public function switchPaymentMethod(Request $request)
    {
        if (! session()->has('buy_now')) {
            if (Cart::instance('shopping')->count() <= 0) return url('/');
        }

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
                'payment_method' => 'required|in:cod,bacs,currency,transfer_payment',
                'type' => 'nullable'
            ]
        );

        if ($credentials->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $credentials->errors(),
            ], 422);
        }

        $credentials = $credentials->validated();

        $credentials['address'] = $this->buildFullAddress($request);
        $credentials['total_price'] = $this->calculateTotalPrice();
        $credentials['code'] = $this->generateOrderCode();
        $credentials['user_id'] = auth()->id();

        switch ($credentials['payment_method']) {
            case 'cod':
                return $this->codPayment($credentials);
            case 'bacs':
                return $this->bacsPayment($credentials);
            case 'currency':
            case 'transfer_payment':
                // return $this
        }
    }

    private function codPayment($credentials)
    {
        try {
            DB::beginTransaction();

            $order =  $this->checkout($credentials);

            DB::commit();

            return response()->json(['success' => true, 'payment_method' => 'cod', 'redirect' => route('carts.order-success', $order->code)]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function checkout($credentials)
    {

        $order = SgoOrder::create($credentials);

        $items = $this->mapCartItems();

        $order->products()->attach($items);

        if (!session()->has('buy_now'))  Cart::instance('shopping')->destroy();

        event(new OrderPlaced($order));

        return $order;

        // try {
        //     DB::beginTransaction();

        //     $credentials['address'] = $this->buildFullAddress($request);
        //     $credentials['total_price'] = $this->calculateTotalPrice();
        //     $credentials['code'] = $this->generateOrderCode();
        //     $credentials['user_id'] = auth()->id();

        //     if ($request->payment_method == 'transfer_payment') {
        //         return $this->bacsPayment();
        //     }

        //     if ($request->payment_method == 'bacs' || $request->payment_method == 'currency') {
        //         return $this->paymentBacs($credentials);
        //     }



        //     DB::commit();

        //     // return response()->json([
        //     //     'status' => true,
        //     //     'redirect' => route('carts.order-success', $order->code),
        //     // ]);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json([
        //         'success' => false,
        //         'message' => $e->getMessage(),
        //     ], 500);
        // }
    }

    private function bacsPayment($credentials)
    {
        try {
            DB::beginTransaction();

            $order =  $this->checkout($credentials);

            DB::commit();

            return response()->json(['success' => true, 'payment_method' => 'transfer_payment', 'redirect' => route('carts.order-success', $order->code)]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function genQrCode(Request $request)
    {

        $bank = $request->qrData['bank_code']; // Mã ngân hàng (VD: Agribank)
        $account = $request->qrData['account_number']; // Số tài khoản nhận tiền
        $amount = $request->qrData['total_price']; // Số tiền cần thanh toán (tùy chọn)
        $content = 'THANH TOAN DON HANG ' . $request->qrData['code']; // Nội dung chuyển khoản

        $qrUrl = "https://img.vietqr.io/image/{$bank}-{$account}-compact.png?amount={$amount}&addInfo={$content}";

        return response()->json(['success' => true, 'qrCode' => $qrUrl]);
    }

    public function confirmbacsPayment($credentials)
    {
        try {
            DB::beginTransaction();

            $order =  $this->checkout($credentials);

            DB::commit();

            return response()->json(['success' => true, 'payment_method' => 'transfer_payment', 'redirect' => route('carts.order-success', $order->code)]);
        } catch (\Throwable $th) {
            DB::rollBack();
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
        if (session()->has('buy_now')) {
            $cart = session()->get('buy_now');

            return $cart['price'] * $cart['qty'];
        }
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
        $order = SgoOrder::query()->where('code', request('code'))->with('products')->firstOrFail();

        // Lấy thông tin tài khoản ngân hàng
        $accountDetails = ConfigPayment::query()->where('type', 'bacs')->first();


        return view('frontends.pages.order-success', compact('order', 'accountDetails'));
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

    private function paymentBacs($values)
    {
        $total = $values['payment_method'] == 'currency' ? $values['total_price'] * (1 - ConfigPayment::query()->select('payment_percentage')->where('id', 3)->first()->payment_percentage / 100) : $values['total_price'];

        $values['payment_status'] = $values['payment_method'] == 'currency' ? 2 : 1;

        $values['deposit_amount'] = $values['payment_method'] == 'currency' ? $total : 0;

        $values['status'] = 'confirmed';

        session()->flash('payment_data', $values);

        session()->flash('total', $total);

        return $this->payOs($total, $values['code'], route('carts.thanh-toan'));
    }

    private function payOs($total, $code, $cancelUrl, $returnUrl = null)
    {
        $clientId = env('PAYOS_CLIENT_ID');
        $apiKey = env('PAYOS_API_KEY');
        $checksumKey = env('PAYOS_CHECKSUM_KEY');

        // Dữ liệu yêu cầu
        $data = [
            "orderCode" => (int) generateRandomNumber(length: 8),
            "amount" => $total,
            "description" => 'DON HANG ' . $code,

            "cancelUrl" => $cancelUrl,
            "returnUrl" => $returnUrl ?? route('carts.payment-request'),
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
                'line' => $e->getLine(),
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
        try {
            DB::beginTransaction();

            $order = SgoOrder::create(session()->get('payment_data'));

            $items = $this->mapCartItems();

            $order->products()->attach($items);

            $existOrder = TransactionHistory::query()->where('sgo_order_id', $order->id)->exists();

            TransactionHistory::create([
                'sgo_order_id' => $order->id,
                'transaction_amount' => session('total'),
                'transaction_notes' => formatName($order->fullname)  . ' CHUYEN KHOAN <strong class="text-danger">LAN ' . $existOrder ? 2 : 1 . '</strong>',
            ]);

            Cart::instance('shopping')->destroy();

            event(new OrderPlaced($order));

            // Cache::put('payment_success', 'Thanh toán thành công', 120);

            DB::commit();

            return redirect()->route('carts.order-success', $order->code);
        } catch (\Exception $e) {
            Log::info('Error: ' . $e->getMessage());

            DB::rollBack();
        }
    }

    public function handleRemainingPayment(Request $request)
    {
        $order = SgoOrder::query()->where('code', $request->code)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin đơn hàng!'
            ]);
        }

        $total = $order->total_price - $order->deposit_amount;

        $cancelUrl = $request->headers->get('referer');

        $returnUrl = route('carts.order-updated-successfully');

        session()->flash('code', $order->code);

        return $this->payOs($total, $order->code, $cancelUrl, $returnUrl);
    }

    public function orderUpdatedSuccessfully()
    {
        $order = SgoOrder::query()->where('code', session('code'))->first();

        $existOrder = TransactionHistory::query()->where('sgo_order_id', $order->id)->exists();

        TransactionHistory::create([
            'sgo_order_id' => $order->id,
            'transaction_amount' => $order->total_price - $order->deposit_amount,
            'transaction_notes' => (string) formatName($order->fullname)  . ' CHUYEN KHOAN <strong class="text-danger">LAN ' . $existOrder ? 2 : 1 . '</strong>'
        ]);

        $order->payment_status = 1;
        $order->deposit_amount = $order->total_price;

        $order->save();



        return redirect()->route('carts.order.lookup', $order->code);
    }

    // public function lookup($code = null)
    // {
    //     $order = SgoOrder::query()->with('products')->where('code', $code)->first();

    //     return view('frontends.pages.order-lookup', compact('order'));
    // }

    public function lookup($code)
    {
        $order = SgoOrder::query()->with('products')->where('code', $code)->firstOrFail();

        return view('frontends.pages.order-detail', compact('order'));
    }
}
