<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trạng thái đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .email-header h1 {
            color: #333;
        }

        .email-body {
            color: #555;
        }

        .email-body h2 {
            color: #333;
        }

        .email-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .order-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .order-details th,
        .order-details td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .order-details th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Trạng thái đơn đơn hàng đã thay đổi</h1>
        </div>
        <div class="email-body">
            <h2>Kính gửi {{ $customerName }},</h2>
            <p>Cảm ơn bạn đã đặt hàng! Đơn hàng <strong>#{{ $orderNumber }}</strong> của bạn đã
                {{ $order->status == 1 ? 'được xác nhận' : 'bị từ chối' }}. Dưới đây là thông tin chi tiết về đơn hàng
                của bạn:</p>

            <table class="order-details">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderItems as $item)
                        <tr>
                            <td>{{ $item['product_name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'], 0) }} VND</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><strong>Tổng cộng</strong></td>
                        <td><strong>{{ number_format($totalAmount) }} VND</strong></td>
                    </tr>
                </tfoot>
            </table>

            {{-- <a href="{{ $orderDetailsUrl }}" class="button">Xem chi tiết đơn hàng</a> --}}
        </div>
        <div class="email-footer">
            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email <a
                    href="mailto:support@example.com">{{ env('MAIL_FROM_ADDRESS') }}</a>.</p>
            <p>Cảm ơn bạn đã mua sắm cùng chúng tôi!</p>
        </div>
    </div>
</body>

</html>
