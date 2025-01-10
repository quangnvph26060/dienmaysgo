@extends('frontends.layouts.master')

@section('title', 'Đặt hàng thông công')
{{-- @section('description', $news->description_seo)
@section('keywords', $news->keyword_seo)
@section('og_title', $news->name)
@section('og_description', $news->description_seo) --}}

@section('content')
    <div class="body-order">
        <div class="order-success">
            <div class="success-icon">
                <i class="checkmark">✔</i>
            </div>
            <h1>Cảm ơn bạn đã đặt hàng!</h1>
            <p class="order-message">
                Đơn hàng của bạn đã được xác nhận và đang được xử lý.
            </p>

            <div class="order-details">
                <div class="info-section">
                    <!-- Thông tin người nhận -->
                    <div class="customer-info">
                        <h2>Thông tin người nhận</h2>
                        <p><strong>Họ tên:</strong> {{ $order->fullname }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                        <p>
                            <strong>Địa chỉ:</strong> {{ $order->address }}
                        </p>
                        <p>
                            <strong>Email:</strong> {{ $order->email }}
                        </p>

                    </div>
                    <!-- Thông tin đơn hàng -->
                    <div class="order-info">
                        <h2>Thông tin đơn hàng</h2>
                        <p><strong>Mã đơn hàng:</strong> #{{ $order->code }}</p>
                        <p><strong>Ngày đặt hàng:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}
                        </p>
                        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VND
                            @if ($order->payment_method == 'currency')
                                <small style="color: red">(đã trả {{ formatAmount($order->deposit_amount) }} VND)</small>
                            @endif
                        </p>
                        <p>
                            <strong>Phương thức thanh toán:</strong>
                            @if ($order->payment_method == 'cod')
                                COD (Thanh toán khi nhận hàng)
                            @elseif($order->payment_method == 'bacs')
                                Thanh toán chuyển khoản
                            @else
                                Thanh toán đặt cọc
                            @endif
                        </p>
                    </div>


                </div>

                <h2>Sản phẩm đã đặt</h2>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $item)
                            <tr>
                                <td>
                                    <img src="{{ showImage($item->pivot->p_image) }}" alt="{{ $item->pivot->p_name }}" />
                                </td>
                                <td>{{ $item->pivot->p_name }}</td>
                                <td>{{ number_format($item->pivot->p_price, 0, ',', '.') }} VND</td>
                                <td>x{{ $item->pivot->p_qty }}</td>
                                <td>{{ number_format($item->pivot->p_price * $item->pivot->p_qty, 0, ',', '.') }} VND</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="action-buttons">
                <a href="{{ url('/') }}" class="btn btn-secondary">Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* styles.css */
        .body-order {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .order-success {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 900px;
            width: 100%;
        }

        .success-icon {
            font-size: 50px;
            color: #4caf50;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #4caf50;
        }

        .order-message {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .order-details {
            text-align: left;
            margin-top: 20px;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
        }

        .order-info,
        .customer-info {
            width: 48%;
        }

        .order-info h2,
        .customer-info h2 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 2px solid #4caf50;
            display: inline-block;
            padding-bottom: 5px;
        }

        .order-info p,
        .customer-info p {
            font-size: 14px;
            line-height: 1.6;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .product-table th {
            background-color: #4caf50;
            color: #fff;
        }

        .product-table td img {
            width: 80px;
            height: auto;
            border-radius: 5px;
        }

        .action-buttons {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            color: #fff;
            background-color: #4caf50;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049 !important;
            color: white !important;
        }

        .btn-secondary {
            background-color: #666;
        }

        .btn-secondary:hover {
            background-color: #555;
        }
    </style>
@endpush
