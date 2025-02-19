<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                        <i class="fa fa-search search-icon"></i>
                    </button>
                </div>
                <input type="text" placeholder="Search ..." class="form-control" />
            </div>
        </nav>

        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                    aria-expanded="false" aria-haspopup="true">
                    <i class="fa fa-search"></i>
                </a>
                <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                        <div class="input-group">
                            <input type="text" placeholder="Search ..." class="form-control" />
                        </div>
                    </form>
                </ul>
            </li>
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-envelope"></i>
                </a>
                <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                    <li>
                        <div class="dropdown-title d-flex justify-content-between align-items-center">
                            Lịch sử chuyển khoản
                            {{-- <a href="#" class="small">Mark all as read</a> --}}
                        </div>
                    </li>
                    <li>
                        <div class="message-notif-scroll scrollbar-outer">
                            <div class="notif-center px-3">
                                @foreach ($ransferHistory as $item)
                                    <a href="#" class="text-light">
                                        <div class="notif-content" style="background-color: rgba(0, 128, 0, .4)">
                                            <span class="subject">{!! $item->transaction_notes !!}</span>
                                            <span class="subject">+ {{ formatAmount($item->transaction_amount) }}
                                                VND</span>
                                            <span class="time">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="see-all" href="{{ route('admin.order.transfer-history') }}">Xem tất cả<i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="notification"> {{ $todayOrdersCount }}</span>
                </a>
                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                    <li>
                        <div class="dropdown-title">
                            Bạn có {{ $todayOrdersCount }} đơn hàng mới hôm nay
                        </div>
                    </li>
                    <li>
                        <div class="notif-scroll scrollbar-outer">
                            <div class="notif-center">

                                @foreach ($groupedOrders as $timeGroup => $orders)
                                    <small class="ms-3">{{ $timeGroup }}</small>
                                    @foreach ($orders as $order)
                                        <a href="{{ route('admin.order.detail', $order->id) }}">
                                            <div class="notif-icon">
                                                {{-- <i class="fa fa-comment"></i> --}}
                                                <img width="22" src="{{ showImage($order->user->avatar) }}"
                                                    alt="">
                                            </div>
                                            <div class="notif-content">
                                                <span class="block">
                                                    {{ $order->user->name }} đặt hàng
                                                </span>
                                                <span class="time">
                                                    {{ $order->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                @endforeach

                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="see-all" href="{{ route('admin.order.index') }}">Xem tất cả thông báo<i
                                class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fas fa-layer-group"></i>
                </a>
                <div class="dropdown-menu quick-actions animated fadeIn">
                    <div class="quick-actions-header">
                        <span class="title mb-1">Quick Actions</span>
                        <span class="subtitle op-7">Shortcuts</span>
                    </div>
                    <div class="quick-actions-scroll scrollbar-outer">
                        <div class="quick-actions-items">
                            <div class="row m-0">
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-danger rounded-circle">
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                        <span class="text">Calendar</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-warning rounded-circle">
                                            <i class="fas fa-map"></i>
                                        </div>
                                        <span class="text">Maps</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-info rounded-circle">
                                            <i class="fas fa-file-excel"></i>
                                        </div>
                                        <span class="text">Reports</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-success rounded-circle">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <span class="text">Emails</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-primary rounded-circle">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                        <span class="text">Invoice</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-secondary rounded-circle">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <span class="text">Payments</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li> --}}

            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                    aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="{{ showImage(Auth::guard('admin')->user()->avatar) }}" alt="..."
                            class="avatar-img rounded-circle" />
                    </div>
                    <span class="profile-username">
                        <span class="op-7">Hi,</span>
                        <span class="fw-bold">{{ Auth::guard('admin')->user()->name }}</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    <img src="{{ showImage(Auth::guard('admin')->user()->image) }}"
                                        alt="image profile" class="avatar-img rounded" />
                                </div>
                                <div class="u-text">
                                    <h4>{{ Auth::guard('admin')->user()->name }}</h4>
                                    <p class="text-muted">{{ Auth::guard('admin')->user()->email }}</p>
                                    <a
                                        href="{{ route('admin.getUserInfor', ['id' => Auth::guard('admin')->user()->id]) }}">View
                                        Profile</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
