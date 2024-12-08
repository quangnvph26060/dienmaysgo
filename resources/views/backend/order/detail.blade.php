@extends('backend.layouts.master')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.order.index') }}">Danh sách đơn hàng</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4 class="text-center mb-sm-0 font-size-18">Chi tiết hóa đơn số {{ $order->code }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-center text-primary"><b>Thông tin khách hàng</b></h5>
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <th scope="row"><i class="fas fa-user"></i> Tên khách hàng</th>
                                            <td>
                                                <div class="nowrap">{{ $order->first_name . ', ' . $order->last_name }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fas fa-phone"></i> Số điện thoại</th>
                                            <td>
                                                <div class="nowrap">{{ $order->phone }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fas fa-envelope"></i> Email</th>
                                            <td>
                                                <div class="nowrap">{{ $order->email }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fa-solid fa-building"></i> Tên công ty</th>
                                            <td>
                                                <div class="nowrap">{{ $order->company_name ?? '' }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fas fa-map-marker-alt"></i> Địa chỉ nhận</th>
                                            <td>
                                                <div class="nowrap">
                                                    {{ $order->address . ', ' . $order->city . ', ' . $order->country }}
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-center text-primary"><b>Thông tin đơn hàng</b></h5>
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <th scope="row"><i class="fas fa-receipt"></i> Mã đơn hàng</th>
                                            <td>
                                                <div class="nowrap">{{ $order->code }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fas fa-box-open"></i> Sản phẩm</th>
                                            <td>
                                                @foreach ($order->orderDetails as $item)
                                                    <div class="d-flex justify-content-between nowrap">
                                                        <span>{{ $item->product_name }} x{{ $item->quantity }}</span>
                                                        <span>{{ number_format($item->price * $item->quantity) }}
                                                            VND</span>
                                                    </div>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fas fa-money-bill-wave"></i> Tổng tiền</th>
                                            <td>
                                                <div class="nowrap">{{ number_format($order->total_price) }} VND</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fa-brands fa-cc-mastercard"></i> Phương thức thanh
                                                toán
                                            </th>
                                            <td>
                                                <div class="nowrap">{{ $order->payment_method ?? '' }} </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fas fa-hand-holding-usd"></i> Trạng thái</th>
                                            <td>
                                                <select id="orderStatusDropdown" class="form-control">
                                                    <option value="pending"
                                                        {{ $order->status == 'pending' ? 'selected' : '' }}>Đang chờ
                                                    </option>
                                                    <option value="completed"
                                                        {{ $order->status == 'completed' ? 'selected' : '' }}>Đã hoàn thành
                                                    </option>
                                                    <option value="cancelled"
                                                        {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row"><i class="fas fa-barcode"></i> Mã bưu điện</th>
                                            <td>
                                                <div class="nowrap">{{ $order->postcode }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fa-regular fa-note-sticky"></i> Ghi chú</th>
                                            <td>
                                                <div class="nowrap">{{ $order->notes }}</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="{{ route('admin.order.index') }}" class="btn btn-primary w-md">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#orderStatusDropdown').change(function() {
                const orderId = {{ $order->id }}; // Replace with dynamic order ID
                const newStatus = $(this).val();

                $.ajax({
                    url: '{{ route('admin.order.updateOrderStatus') }}', // Sử dụng route Laravel
                    method: 'POST',
                    data: {
                        id: orderId,
                        order_status: newStatus,
                        _token: '{{ csrf_token() }}' // CSRF token để bảo mật
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Thành công',
                                text: 'Trạng thái đơn hàng đã được cập nhật!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Thất bại',
                                text: response.message ||
                                    'Có lỗi xảy ra khi cập nhật trạng thái.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Lỗi',
                            text: 'Không thể cập nhật trạng thái đơn hàng. Vui lòng thử lại.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endsection

<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
    }

    .card-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        background: linear-gradient(135deg, #6f42c1, #007bff);
    }

    .card-body {
        padding: 2rem;
        background-color: #f8f9fa;
    }

    .table th,
    .table td {
        vertical-align: middle;
        padding: 1rem;
        font-size: 1rem;
    }

    .table th {
        background-color: #e9ecef;
        font-weight: bold;
        color: #495057;
    }

    .table-hover tbody tr:hover {
        background-color: #dee2e6;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        transform: translateY(-2px);
    }

    .text-primary {
        color: #007bff !important;
    }

    .nowrap {
        white-space: nowrap;
        display: flex;
        justify-content: space-between;
    }
</style>
