@extends('frontends.layouts.master')

@section('title', $order->code)
{{-- @section('description', $news->description_seo)
@section('keywords', $news->keyword_seo)
@section('og_title', $news->name)
@section('og_description', $news->description_seo) --}}

@section('content')
    @include('components.breadcrumb_V2', [
        'title' => 'Thông tin cá nhân',
        'name' => $order->code,
        'redirect' => route('auth.profile'),
    ])

    <div class="container-group">
        <div class="row-group">
            <!-- Thông tin người đặt hàng -->
            <div class="col-group">
                <h3>Thông tin người đặt hàng</h3>
                <ul class="list-group">
                    <li><strong>Tên:</strong> {{ $order->fullname }}</li>
                    <li><strong>Email:</strong> {{ $order->email }}</li>
                    <li><strong>Số điện thoại:</strong> {{ $order->phone }}</li>
                    <li><strong>Địa chỉ:</strong> {{ $order->address }}</li>
                </ul>
            </div>

            <!-- Thông tin đơn hàng -->
            <div class="col-group">
                <h3 style="display: inline; margin-right: 10px">Thông tin đơn hàng</h3>
                <small>({{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }})</small>
                <ul class="list-group">
                    <li><strong>Mã đơn hàng:</strong> {{ $order->code }}</li>
                    <li><strong>Trạng thái:</strong>
                        {!! statusColor($order->status) !!}
                    </li>
                    <li><strong>Hình thức:</strong> {!! paymentMethods($order->payment_method) !!}
                        @if ($order->payment_method == 'currency' && $order->total_price != $order->deposit_amount)
                            <code>Đã trả trước {{ formatAmount($order->deposit_amount) }} </code>
                            <i class="fas fa-qrcode fa-lg" style="margin-left: 10px; cursor: pointer;"></i>
                        @endif
                    </li>
                    <li><strong>Tổng tiền:</strong> {{ formatAmount($order->total_price) }} VND</li>
                </ul>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <h3>Danh sách sản phẩm</h3>
        <table id="product-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                    <tr>
                        <td data-label="STT">{{ $loop->iteration }}</td>
                        <td data-label="Tên sản phẩm">{{ $product->pivot->p_name }}</td>
                        <td data-label="Số lượng">{{ $product->pivot->p_qty }}</td>
                        <td data-label="Đơn giá">{{ formatAmount($product->pivot->p_price) }}</td>
                        <td data-label="Thành tiền">{{ formatAmount($product->pivot->p_price * $product->pivot->p_qty) }}
                            VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelector('.fa-qrcode')?.addEventListener('click', function() {
            const url = "{{ route('carts.handle-remaining-payment') }}";
            const code = "{{ $order->code }}";

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        code
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        alert(response.message);
                    }
                    return response.json();
                })
                .then(data => window.location.href = data.paymentUrl)
                .catch(error => console.error('Error:', error));
        });
    </script>
@endpush

@push('styles')
    <style>
        @media (max-width: 768px) {
            table {
                display: block;
                width: 100%;
            }

            table thead {
                display: none;
                /* Ẩn header khi ở dạng responsive */
            }

            table,
            table tbody,
            table tr,
            table td {
                display: block;
                width: 100%;
            }

            table td {
                position: relative;
                padding-left: 50%;
                /* Thêm khoảng cách để có chỗ cho label */
                display: flex;
                justify-content: space-between;
            }

            table td::before {
                content: attr(data-label);
                font-weight: bold;
            }

            .container-group {
                padding: 15px;
            }

            h1 {
                font-size: 1.5em;
            }

            table th,
            table td {
                font-size: 0.9em;
                padding: 8px;
            }

            table th {
                font-size: 1em;
            }

            .row-group {
                flex-direction: column;
            }

            .col-group {
                flex: 1;
                background: #f1f1f1;
                border-radius: 5px;
                padding: 15px;
                margin-bottom: 20px;
            }

            .list-group {
                list-style: none;
                padding: 0;
            }

            .list-group li {
                padding: 8px 0;
                border-bottom: 1px solid #ddd;
            }

            .list-group li:last-child {
                border-bottom: none;
            }

            /* Điều chỉnh kiểu cho các nhóm badge */
            .badge {
                font-size: 0.8rem;
                padding: 4px 8px;
                margin-left: 10px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.2em;
            }

            table th,
            table td {
                font-size: 0.8em;
                padding: 6px;
            }

            /* Tăng chiều rộng của bảng khi trên mobile */
            table th,
            table td {
                padding: 6px 8px;
            }

            /* Các cột thông tin người đặt hàng */
            .list-group li {
                font-size: 0.9em;
                padding: 10px 0;
            }

            /* Thiết kế bảng với 2 cột */
            table {
                width: 100%;
                border-collapse: collapse;
                overflow-x: auto;
            }

            table th,
            table td {
                text-align: left;
                padding: 10px;
                border: 1px solid #ddd;
            }

            table th {
                background-color: #007bff;
                color: #fff;
            }

            /* Bảng ở dạng cột dọc */
            .orders-table td {
                display: flex;
                justify-content: space-between;
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            .orders-table td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #333;
                flex: 0 0 40%;
                padding-right: 10px;
            }

            /* Hiệu ứng hover cho các bảng */
            .badge:hover {
                opacity: 0.9;
                cursor: pointer;
            }
        }

        .container-group {
            max-width: 1200px;
            margin: 10px auto 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
        }

        .row-group {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .col-group {
            flex: 1;
            background: #f1f1f1;
            border-radius: 5px;
            padding: 15px;
        }

        .col-group h3 {
            margin-bottom: 10px;
            color: #007bff;
        }

        .list-group {
            list-style: none;
            padding: 0;
        }

        .list-group li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        .list-group li:last-child {
            border-bottom: none;
        }

        /* Kiểu dáng badge */
        .badge {
            display: inline;
            padding: 5px 10px;
            border-radius: 5px;
            color: #fff;
            font-size: 0.9em;
        }

        .badge {
            margin-left: 10px;
            padding: 5px 10px;
            font-size: .6rem;
            font-weight: 600;
            text-align: center;
            border-radius: 5px;
            color: #fff;
            text-transform: capitalize;
            white-space: nowrap;
        }

        /* Kiểu dáng cho từng trạng thái */
        .bg-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .bg-primary {
            background-color: #007bff;
            color: #fff;
        }

        .bg-success {
            background-color: #28a745;
            color: #fff;
        }

        .bg-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .badge:hover {
            opacity: 0.9;
            cursor: default;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
@endpush
