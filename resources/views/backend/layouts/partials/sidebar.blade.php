<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="white">
            <a target="_blank" style="width: 90%;" href="https://sgomedia.vn/" class="logo">
                <img src="{{ asset('backend/SGO VIET NAM (1000 x 375 px).png') }}" alt="navbar brand"
                    class="navbar-brand img-fluid" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ activeMenu('admin.dashboard') }}">
                    <a href="{{ route('admin.dashboard') }}" class="collapsed">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#order">
                        <i class="fas fa-receipt"></i>
                        <p>Đơn hàng</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="order">
                        <ul class="nav nav-collapse">
                            <li class="nav-item {{ activeMenu('admin.order.index') }}">
                                <a href="{{ route('admin.order.index') }}">
                                    <span class="sub-item">Danh sách đơn hàng</span>
                                </a>
                            </li>
                            <li class="nav-item {{ activeMenu('admin.order.transfer-history') }}">
                                <a href="{{ route('admin.order.transfer-history') }}">
                                    <span class="sub-item">Lịch sử chuyển khoản</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#product">
                        <i class="fas fa-box-open"></i>
                        <p>Sản phẩm</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="product">
                        <ul class="nav nav-collapse">
                            <li class="nav-item {{ activeMenu('admin.product.index') }}">
                                <a href="{{ route('admin.product.index') }}">
                                    <span class="sub-item">Danh sách sản phẩm</span>
                                </a>
                            </li>
                            <li class="nav-item {{ activeMenu('admin.category.index') }}">
                                <a href="{{ route('admin.category.index') }}">
                                    <span class="sub-item">Danh sách danh mục</span>
                                </a>
                            </li>
                            <li class="nav-item {{ activeMenu('admin.attributes.index') }}">
                                <a href="{{ route('admin.attributes.index') }}">
                                    <span class="sub-item">Danh sách thuộc tính</span>
                                </a>
                            </li>
                            <li class="nav-item {{ activeMenu('admin.brands.index') }}">
                                <a href="{{ route('admin.brands.index') }}">
                                    <span class="sub-item">Danh sách thương hiệu</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#promotion">
                        <i class="fab fa-salesforce"></i>
                        <p>Khuyến mãi</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="promotion">
                        <ul class="nav nav-collapse">
                            <li class="nav-item {{ activeMenu('admin.promotion.index') }}">
                                <a href="{{ route('admin.promotion.index') }}">
                                    <span class="sub-item">Danh sách khuyến mãi</span>
                                </a>
                            </li>
                            <li class="nav-item {{ activeMenu('admin.promotion.create') }}">
                                <a href="{{ route('admin.promotion.create') }}">
                                    <span class="sub-item">Thêm mới khuyến mãi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#news">
                        <i class="fas fa-newspaper"></i>
                        <p>Bài viết</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="news">
                        <ul class="nav nav-collapse">
                            <li class="nav-item {{ activeMenu('admin.news.index') }}">
                                <a href="{{ route('admin.news.index') }}">
                                    <span class="sub-item">Danh sách bài viết</span>
                                </a>
                            </li>
                            <li class="nav-item {{ activeMenu('admin.news.create') }}">
                                <a href="{{ route('admin.news.create') }}">
                                    <span class="sub-item">Thêm bài viết</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#home">
                        <i class="fas fa-newspaper"></i>
                        <p>Cấu hình page</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="home">
                        <ul class="nav nav-collapse">
                            <li class="nav-item {{ activeMenu('admin.home.index') }}">
                                <a href="{{ route('admin.home.index') }}">
                                    <span class="sub-item">Danh sách </span>
                                </a>
                            </li>
                            <li class="nav-item {{ activeMenu('admin.home.create') }}">
                                <a href="{{ route('admin.home.create') }}">
                                    <span class="sub-item">Thêm</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#marketing">
                        <i class="fas fa-users"></i>
                        <p>Marketing</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="marketing">
                        <ul class="nav nav-collapse">
                            <li class="nav-item {{ activeMenu('admin.marketing.history-search') }}">
                                <a href="{{ route('admin.marketing.history-search') }}">
                                    <span class="sub-item">Danh sách từ khóa tìm kiếm</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item  {{ activeMenu('admin.config.index') }}">
                    <a href="{{ route('admin.config.index') }}">
                        <i class="fas fa-cogs"></i>
                        <p>Cấu hình</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
