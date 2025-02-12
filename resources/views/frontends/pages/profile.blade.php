@extends('frontends.layouts.master')
@section('title', 'Thông tin cá nhân')
@section('content')
    @include('components.breadcrumb_V2', [
        'name' => 'Thông tin cá nhân',
    ])
    <div class="profile-container">
        <!-- Tabs Section -->
        <div class="tabs">
            <button class="active" data-tab="info"><i class="far fa-user"></i> Thông tin cá nhân</button>
            <button data-tab="orders"><i class="fa-solid fa-file-invoice"></i> Đơn hàng</button>
            <button data-tab="password"><i class="fas fa-lock"></i> Đổi mật khẩu</button>
        </div>

        <!-- Content Section -->
        <div class="content">
            <div id="info" class="tab-content active">
                <div class="action-header">
                    <h2>Thông tin cá nhân</h2>
                    <a href="{{ route('auth.logout') }}">Đăng xuất</a>
                </div>

                <form action="" method="post" class="profile-form">
                    <!-- Tên đăng nhập -->
                    <div class="d-flex">
                        <div class="form-group">
                            <label for="name">Tên đăng nhập</label>
                            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}"
                                placeholder="Nhập tên đăng nhập">
                        </div>

                        <!-- Số điện thoại -->
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại"
                                value="{{ auth()->user()->phone }}">
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Nhập email"
                            value="{{ auth()->user()->email }}">
                    </div>

                    <!-- Địa chỉ -->
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" name="address" placeholder="Nhập địa chỉ"
                            value="{{ auth()->user()->address }}">
                    </div>

                    <!-- Nút lưu -->
                    <div class="form-group">
                        <button type="submit" class="btn-save">Lưu thông tin</button>
                    </div>
                </form>
            </div>
            <div id="orders" class="tab-content">
                <h2>Đơn hàng</h2>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Thông tin người nhận</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td data-label="Mã đơn hàng">
                                    <div><a href="{{ route('carts.order-detail', $order->code) }}">{{ $order->code }}</a>
                                    </div>
                                </td>
                                <td data-label="Thông tin người nhận">
                                    <div>
                                        <p>{{ $order->fullname }}</p>
                                        <p>{{ $order->email }}</p>
                                        <p>{{ $order->phone }}</p>
                                    </div>
                                </td>
                                <td data-label="Tổng tiền">
                                    <div>{{ formatAmount($order->total_price) }} VND</div>
                                </td>
                                <td data-label="Trạng thái">
                                    <div>{!! statusColor($order->status) !!}</div>
                                </td>
                                <td data-label="Ngày đặt">
                                    <div>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Chưa có đơn hàng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $orders->links() }}
                </div>

            </div>


            <div id="password" class="tab-content">
                <h2>Đổi mật khẩu</h2>

                <form id="change-password-form">
                    <!-- Mật khẩu cũ -->
                    <div class="form-group">
                        <label for="current-password">Mật khẩu cũ <small><code>* Nếu đăng nhập bằng google thì mật khẩu
                                    chính là email của bạn trong lần đổi đầu tiên.</code></small></label>
                        <input type="password" id="current-password" name="current_password" class="form-control"
                            placeholder="Nhập mật khẩu cũ" required>
                    </div>

                    <div class="d-flex">
                        <!-- Mật khẩu mới -->
                        <div class="form-group">
                            <label for="new-password">Mật khẩu mới</label>
                            <input type="password" id="new-password" name="password" class="form-control"
                                placeholder="Nhập mật khẩu mới" required {{-- minlength="8" --}}>
                        </div>

                        <!-- Nhập lại mật khẩu -->
                        <div class="form-group">
                            <label for="confirm-password">Nhập lại mật khẩu mới</label>
                            <input type="password" id="confirm-password" name="confirm_password" class="form-control"
                                placeholder="Nhập lại mật khẩu mới" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-save">Đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.tabs button');
            const contents = document.querySelectorAll('.tab-content');

            // Lấy tab được lưu từ localStorage hoặc mặc định là tab đầu tiên
            const savedTab = localStorage.getItem('activeTab') || tabs[0].getAttribute('data-tab');

            // Đặt trạng thái ban đầu cho tabs và nội dung
            tabs.forEach(tab => {
                if (tab.getAttribute('data-tab') === savedTab) {
                    tab.classList.add('active');
                } else {
                    tab.classList.remove('active');
                }
            });

            contents.forEach(content => {
                if (content.id === savedTab) {
                    content.classList.add('active');
                } else {
                    content.classList.remove('active');
                }
            });

            // Xử lý sự kiện click trên tabs
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Xóa class active khỏi tất cả các tabs và nội dung
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(content => content.classList.remove('active'));

                    // Thêm class active cho tab được chọn
                    tab.classList.add('active');

                    // Hiển thị nội dung tương ứng
                    const targetTab = tab.getAttribute('data-tab');
                    document.getElementById(targetTab).classList.add('active');

                    // Lưu tab hiện tại vào localStorage
                    localStorage.setItem('activeTab', targetTab);
                });
            });
        });

        var loadingOverlay = document.getElementById('loading-overlay');
        document.querySelector('.profile-form').addEventListener('submit', function(e) {
            e.preventDefault();
            loadingOverlay.style.display = 'flex';
            const data = new FormData(this)
            const api = "{{ route('auth.handle-change-info') }}"
            fetch(api, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: data
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector('.dropdown-info-container .dropdown-toggle').innerText = data
                            .username

                        toastr.success(data.message)
                    } else {
                        toastr.error(data.message)
                    }
                })
                .catch(error => console.error('Error:', error)).finally(() => {
                    loadingOverlay.style.display = 'none';
                });
        })

        document.getElementById('change-password-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const currentPassword = document.getElementById('current-password').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (newPassword !== confirmPassword) {
                alert('Mật khẩu mới và nhập lại mật khẩu không khớp.');
                return;
            }

            loadingOverlay.style.display = 'flex';

            // Gửi yêu cầu đổi mật khẩu
            const api = '{{ route('auth.handle-change-password') }}'; // Thay bằng route API của bạn
            const data = {
                current_password: currentPassword,
                password: newPassword,
                confirm_password: confirmPassword,
            };

            fetch(api, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                    },
                    body: JSON.stringify(data),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        toastr.success(data.message)
                        document.querySelector('#change-password-form').reset();
                    } else {
                        toastr.error(data.message)
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra, vui lòng thử lại sau.');
                }).catch(error => console.error('Error:', error)).finally(() => {
                    loadingOverlay.style.display = 'none';
                });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Media query cho các màn hình có chiều rộng tối đa 768px (ví dụ như điện thoại) */
        @media (max-width: 768px) {
            .tabs button i {
                display: none;
            }

            .profile-container {
                flex-direction: column;
                width: 100%;
                margin: 20px;
            }

            .tabs {
                width: 100% !important;
                display: flex !important;
                flex-direction: row !important;
                justify-content: space-around;
            }

            .tabs button {
                width: auto;
                padding: 10px;
            }

            .content {
                width: 100% !important;
                padding: 10px !important;
            }

            .d-flex .form-group {
                width: 100%;
            }

            .tabs button {
                padding: 12px 15px;
                font-size: 14px;
            }

            .action-header h2 {
                margin-bottom: 0 !important;
                /* flex-direction: column;
                                                                                                                                                                        text-align: center; */
            }

            .profile-form {
                width: 100%;
                padding: 15px;
            }

            .orders-table {
                display: block;
                width: 100%;
            }

            .orders-table thead {
                display: none;
            }

            .orders-table tbody {
                display: block;
            }

            .orders-table tr {
                display: flex;
                flex-wrap: wrap;
                margin-bottom: 10px;
                padding: 10px;
                background-color: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 5px;
            }

            .orders-table td {
                display: flex;
                justify-content: space-between;
                width: 100%;
                padding: 10px;
                text-align: left;
                border-bottom: 1px solid #ddd;
                font-size: 14px;
            }

            .orders-table td::before {
                content: attr(data-label);
                font-weight: bold;
                margin-right: 10px;
                color: #333;
                flex: 0 0 30%;
            }

            .orders-table td div {
                flex: 1;
            }

            .badge {
                margin-left: 0 !important;
            }

        }

        /* Media query cho các màn hình có chiều rộng tối đa 480px (ví dụ như điện thoại nhỏ) */
        @media (max-width: 480px) {
            .tabs button {
                font-size: 12px;
                padding: 8px;
            }

            .content h2 {
                font-size: 18px;
            }

            .profile-form input {
                font-size: 12px;
            }

            .form-group label {
                font-size: 12px;
            }
        }

        .badge {
            display: inline;
            margin-left: 10px;
            padding: 5px 10px;
            font-size: .6rem;
            font-weight: 600;
            text-align: center;
            border-radius: 5px;
            color: #fff !important;
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

        .orders-table p {
            margin: 0;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
            text-align: left;
        }

        .orders-table thead th {
            background-color: #f4f4f4;
            padding: 10px;
            border-bottom: 2px solid #ddd;
        }

        .orders-table tbody td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .orders-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
        }

        .status.completed {
            background-color: #28a745;
            /* Xanh hoàn tất */
        }

        .status.pending {
            background-color: #ffc107;
            /* Vàng đang xử lý */
            color: #000;
        }

        .status.cancelled {
            background-color: #dc3545;
            /* Đỏ đã hủy */
        }

        .d-flex .form-group {
            width: 50%;
        }

        .d-flex {
            display: flex;
            gap: 5px
        }

        .profile-form {
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007BFF;
        }

        .btn-save {
            display: inline-block;
            margin-top: 10px;
            font-size: 14px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-save:hover {
            background-color: #0056b3;
        }

        .action-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
            /* Đảm bảo không xuống dòng */
            gap: 10px;
            /* Khoảng cách giữa các phần tử */
            width: 100%;
        }

        .action-header a {
            padding: 8px;
            white-space: nowrap;
            /* Ngăn nội dung xuống dòng */
            font-size: 14px;
            text-decoration: none;
            color: black;
            border: 1px solid black;
            border-radius: 5px;
            line-height: 1.4;
            transition: .3s ease-in
        }


        .profile-container {
            margin: 20px auto 40px auto !important;
            display: flex;
            justify-content: space-between;
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
        }

        .tabs {
            width: 25%;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
            display: flex;
            flex-direction: column;
            border-radius: 5px;
            height: 100%;

        }

        .tabs button {
            padding: 8px;
            text-align: left;
            background: none;
            border: none;
            border-bottom: 1px solid #d6d6d6;
            cursor: pointer;
            color: black;
            transition: background 0.3s;
            margin-right: 0;
            transition: .3s ease-in
        }

        .tabs button i {
            /* margin-right: 5px; */
            margin: 0 10px
        }

        .tabs button:hover,
        .tabs button.active,
        .action-header a:hover {
            background-color: #ec1c24;
            color: #fff;
            transition: .3s ease-in;
        }

        .tabs button:last-child {
            border-bottom: none;
        }

        .content {
            width: 70%;
            padding: 20px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        .content .tab-content {
            display: none;
            animation: fadeIn 0.3s;
        }

        .content .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .content h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .content p {
            line-height: 1.6;
        }
    </style>
@endpush
