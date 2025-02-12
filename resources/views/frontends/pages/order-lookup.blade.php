@extends('frontends.layouts.master')

@section('content')
    <div class="container-group">
        <h1>Tra cứu đơn hàng</h1>

        <!-- Form nhập mã đơn hàng -->
        <div class="form-group">
            <input type="text" id="orderInput" placeholder="Nhập mã đơn hàng" required
                value="{{ request()->segment(2) ?? '' }}">
            <button type="button" id="searchButton"><i class="fas fa-search"></i></button>
        </div>

        @empty($order)
            <p style="margin-bottom: 0; text-align: center">Không tìm thấy đơn hàng.</p>
        @else
            <!-- Thông tin đơn hàng -->
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
            <table>
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
                            <td style="width: 5%">{{ $loop->iteration }}</td>
                            <td>{{ $product->pivot->p_name }}</td>
                            <td style="width: 10%">{{ $product->pivot->p_qty }}</td>
                            <td>{{ formatAmount($product->pivot->p_price) }}</td>
                            <td>{{ formatAmount($product->pivot->p_price * $product->pivot->p_qty) }} VND</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @endempty
    </div>
@endsection

@push('styles')
    <style>
        @media (max-width: 768px) {
            .container-group {
                padding: 15px;
            }

            h1 {
                font-size: 1.5em;
            }

            .form-group {
               display: flex;
            }

            .form-group input {
                border-radius: 5px;
            }

            .form-group button {
                border-radius: 5px;
                padding: 0 15px
            }

            .row-group {
                flex-direction: column;
            }

            .col-group {
                margin-bottom: 15px;
            }

            table th,
            table td {
                font-size: 0.9em;
                padding: 8px;
            }

            table th {
                font-size: 1em;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.2em;
            }

            .form-group input {
                font-size: 0.9em;
            }

            .form-group button {
                font-size: 0.5em;
            }

            table th,
            table td {
                font-size: 0.5em;
                padding: 6px;
            }
        }

        code {
            color: red
        }

        .container-group {
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
        }

        .form-group {
            display: flex;
            margin-bottom: 20px;
        }

        .form-group input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            outline: none;
        }

        .form-group button {
            border: none;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
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

        /* Kiểu dáng cụ thể cho từng trạng thái */
        .bg-warning {
            background-color: #ffc107;
            /* Màu vàng */
            color: #212529;
        }

        .bg-primary {
            background-color: #007bff;
            /* Màu xanh dương */
            color: #fff;
        }

        .bg-success {
            background-color: #28a745;
            /* Màu xanh lá */
            color: #fff;
        }

        .bg-danger {
            background-color: #dc3545;
            /* Màu đỏ */
            color: #fff;
        }

        /* Thêm hiệu ứng hover (tùy chọn) */
        .badge:hover {
            opacity: 0.9;
            cursor: default;
        }

        .badge.warning {
            background-color: #ffc107;
        }

        .badge.danger {
            background-color: #dc3545;
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

@push('scripts')
    <script>
        // Lấy phần tử input và button
        const orderInput = document.getElementById('orderInput');
        const searchButton = document.getElementById('searchButton');

        // Lắng nghe sự kiện click trên button
        searchButton.addEventListener('click', () => {
            const orderCode = orderInput.value.trim(); // Lấy giá trị mã đơn hàng
            if (orderCode) {
                // Chuyển hướng đến URL chứa mã đơn hàng
                window.location.href = `/order-lookup/${orderCode}`;
            } else {
                alert('Vui lòng nhập mã đơn hàng!');
            }
        });

        // Lắng nghe sự kiện "Enter" trong input
        orderInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                searchButton.click(); // Gọi click button
            }
        });

        document.querySelector('.fa-qrcode')?.addEventListener('click', function() {
            const url = "{{ route('carts.handle-remaining-payment') }}";
            const code = document.querySelector('#orderInput').value;

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
