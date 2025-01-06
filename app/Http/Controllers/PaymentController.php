<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function createPaymentRequest()
    {
        // Lấy thông tin từ môi trường hoặc cấu hình
        $clientId = env('PAYOS_CLIENT_ID');
        $apiKey = env('PAYOS_API_KEY');
        $checksumKey = env('PAYOS_CHECKSUM_KEY');

        // Dữ liệu yêu cầu
        $data = [
            "orderCode" => 4634235647565423,
            "amount" => 200000,
            "description" => "VQRIO123",

            "cancelUrl" => "https://your-cancel-url.com",
            "returnUrl" => "https://your-success-url.com",
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

    /**
     * Tạo chữ ký cho yêu cầu thanh toán
     */
    public function createSignatureOfPaymentRequest($checksumKey, $obj)
    {
        $dataStr = "amount={$obj["amount"]}&cancelUrl={$obj["cancelUrl"]}&description={$obj["description"]}&orderCode={$obj["orderCode"]}&returnUrl={$obj["returnUrl"]}";
        $signature = hash_hmac("sha256", $dataStr, $checksumKey);

        return $signature;
    }
}
