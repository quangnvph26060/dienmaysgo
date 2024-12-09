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
                <li class="nav-item active">
                    <a href="{{ route('admin.dashboard') }}" class="collapsed" >
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.order.index') }}">
                        <i class="fas fa-sign"></i>
                        <p>Đơn hàng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#product">
                        <i class="fas fa-pen-square"></i>
                        <p>Sản phẩm</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="product">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.product.index') }}">
                                    <span class="sub-item">Danh sách sản phẩm</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.product.add') }}">
                                    <span class="sub-item">Thêm mới sản phẩm</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#base">
                        <i class="fas fa-pen-square"></i>
                        <p>Danh mục</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.category.index') }}">
                                    <span class="sub-item">Danh sách danh mục</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.category.create') }}">
                                    <span class="sub-item">Thêm mới danh mục</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#origin">
                        <i class="fas fa-pen-square"></i>
                        <p>Xuất xứ</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="origin">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.origin.index') }}">
                                    <span class="sub-item">Danh sách xuất xứ</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.origin.create') }}">
                                    <span class="sub-item">Thêm mới xuất xứ</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#promotion">
                        <i class="fas fa-pen-square"></i>
                        <p>Khuyến mãi</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="promotion">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.promotion.index') }}">
                                    <span class="sub-item">Danh sách khuyến mãi</span>
                                </a>
                            </li>
                            <li>
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
                            <li>
                                <a href="{{ route('admin.news.index') }}">
                                    <span class="sub-item">Danh sách bài viết</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.news.create') }}">
                                    <span class="sub-item">Thêm bài viết</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#home">
                        <i class="fas fa-newspaper"></i>
                        <p>Cấu hình page</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="home">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.home.index') }}">
                                    <span class="sub-item">Danh sách </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.home.create') }}">
                                    <span class="sub-item">Thêm</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
