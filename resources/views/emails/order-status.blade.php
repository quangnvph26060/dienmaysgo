<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo Trạng Thái Đơn Hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .product-list {
            margin-top: 20px;
            border-top: 2px solid #f0f0f0;
            padding-top: 20px;
        }

        .product-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-list th,
        .product-list td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .product-list th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .footer {
            background-color: #f0f0f0;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            color: #666;
            border-radius: 0 0 8px 8px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .cancel-reason {
            color: #e74c3c;
            font-weight: bold;
        }

        .badge {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 12px;
            display: inline-block;
            margin-top: 10px;
        }

        .badge.success {
            background-color: #28a745;
            color: white;
        }

        .badge.cancel {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h2>Thông Báo Trạng Thái Đơn Hàng</h2>
        </div>

        <div class="content">
            <p>Chào <strong>{{ $order->fullname }}</strong>,</p>

            <p>Đơn hàng của bạn đã {{ $order->status == 'confirmed' ? 'được' : 'bị' }}
                <strong>{{ $order->status == 'confirmed' ? 'xác nhận' : 'hủy' }}</strong>.
            </p>

            @if ($order->status == 'confirmed')
                <p>Chúng tôi vui mừng thông báo rằng đơn hàng của bạn đã được xác nhận và sẽ được giao đến bạn trong
                    thời gian sớm nhất. Dưới đây là thông tin chi tiết của đơn hàng:</p>

                <p><strong>Thông tin người đặt:</strong></p>
                <p><strong>Họ tên:</strong> {{ $order->fullname }}<br>
                    <strong>Số điện thoại:</strong> {{ $order->phone }}<br>
                    <strong>Email:</strong> {{ $order->email }}<br>
                    <strong>Địa chỉ:</strong> {{ $order->address }}<br>
                    <strong>Ghi chú:</strong> {{ $order->notes }}
                </p>

                <div class="product-list">
                    <p><strong>Danh sách sản phẩm:</strong></p>
                    <table>
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Giá trị</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)
                                <tr>
                                    <td>{{ $product->pivot->p_name }}</td>
                                    <td>{{ number_format($product->pivot->p_price) }} VND <small>x
                                            {{ $product->pivot->p_qty }}</small></td>
                                    <td>{{ number_format($product->pivot->p_price * $product->pivot->p_qty) }} VND
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <p><strong>Tổng tiền đơn hàng:</strong> {{ number_format($order->total_price) }} VND</p>

                <span class="badge success">Đơn hàng đã được xác nhận</span>
            @elseif($order->status == 'cancelled')
                <p>Rất tiếc, đơn hàng của bạn đã bị hủy vì lý do dưới đây:</p>
                <p class="cancel-reason">{{ $order->reason }}</p>
                <span class="badge cancel">Đơn hàng đã bị hủy</span>
            @endif
        </div>

        <div class="footer">
            <p>Để biết thêm thông tin hoặc giải quyết bất kỳ vấn đề nào, vui lòng liên hệ với chúng tôi qua:</p>
            <p><strong>Chủ đầu tư:</strong> Công ty ABC XYZ</p>
            <p><strong>Email:</strong> <a href="mailto:info@abcxyz.com">info@abcxyz.com</a></p>
            <p><strong>Điện thoại:</strong> 1900-1234</p>
            <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn!</p>
        </div>
    </div>

</body>

</html>
