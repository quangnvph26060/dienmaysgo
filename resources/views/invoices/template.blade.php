<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .info {
            margin-bottom: 20px;
        }

        .info .title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>HÓA ĐƠN THANH TOÁN</h1>
            <p>Mã đơn hàng: {{ $order->code }}</p>
            <p>Ngày đặt hàng: {{ $order->created_at->format('d/m/Y') }}</p>
        </div>

        <!-- Thông tin người đặt hàng -->
        <div class="info">
            <div class="title">Thông tin người đặt hàng</div>
            <p><strong>Họ và tên:</strong> {{ $order->fullname }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="info">
            <div class="title">Danh sách sản phẩm</div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->pivot->p_name }}</td>
                            <td>{{ number_format($product->pivot->p_price, 0, ',', '.') }}₫
                                <small>x{{ $product->pivot->p_qty }}</small>
                            </td>
                            <td>{{ number_format($product->pivot->p_qty * $product->pivot->p_price, 0, ',', '.') }}₫
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Tổng cộng:</strong> {{ number_format($order->total_price, 0, ',', '.') }}₫</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Cảm ơn quý khách đã đặt hàng!</p>
        </div>
    </div>
</body>

</html>
