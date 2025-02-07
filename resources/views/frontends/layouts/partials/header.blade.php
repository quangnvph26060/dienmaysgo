<div class="header-wrapper">
    <div id="top-bar" class="header-top hide-for-sticky nav-dark hide-for-medium">
        <div class="flex-row container">
            <div class="flex-col hide-for-medium flex-left">
                <ul class="nav nav-left medium-nav-center nav-small nav-divided"></ul>
            </div>

            <div class="flex-col hide-for-medium flex-center">
                <ul class="nav nav-center nav-small nav-divided"></ul>
            </div>


            <div class="flex-col hide-for-medium flex-right">
                <ul class="nav top-bar-nav nav-right nav-small nav-divided">
                    {{-- <li id="menu-item-2010"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2010 menu-item-design-default">
                        <a href="{{ route('carts.order.lookup') }}" class="nav-top-link">Tra cứu đơn hàng</a>
                    </li> --}}
                    <li id="menu-item-2011"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2011 menu-item-design-default">
                        <a href="{{ route('introduce', 'gioi-thieu') }}" class="nav-top-link">Giới
                            thiệu</a>
                    </li>
                    <li id="menu-item-2008"
                        class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2008 menu-item-design-default">
                        <a href="{{ route('news.list') }}" class="nav-top-link">Tin tức</a>
                    </li>
                    <li id="menu-item-2010"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2010 menu-item-design-default">
                        <a href="{{ route('contact') }}" class="nav-top-link">Liên hệ</a>
                    </li>
                    <li id="menu-item-2010"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2010 menu-item-design-default">
                        @if (auth()->check())
                            <div class="dropdown-info-container">
                                <a href="javascript:void(0)" class="dropdown-toggle">
                                    Hi! {{ auth()->user()->name }}
                                </a>
                                <div class="dropdown-info">
                                    <a href="{{ route('auth.profile') }}">Thông tin</a>
                                    <a href="{{ route('auth.logout') }}">Đăng xuất</a>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('auth.login') }}" class="nav-top-link">Đăng nhập</a>
                        @endif
                    </li>


                </ul>
            </div>

        </div>
    </div>

    <div id="masthead" class="header-main">

        <div class="header-inner flex-row container logo-left medium-logo-center" role="navigation">



            <!-- Logo -->
            <div id="logo" class="flex-col logo">
                <!-- Header logo -->
                <a href="{{ url('/') }}" title="{{ request()->getHost() }}" rel="home">
                    <img width="820" height="222" src="{{ showImage($settings->path) }}"
                        class="header_logo header-logo" alt="" />
                    <img width="820" height="222" src="{{ showImage($settings->path) }}" class="header-logo-dark"
                        alt="{{ request()->getHost() }}" />
                </a>
            </div>

            <!-- Mobile Left Elements -->
            <div class="flex-col show-for-medium flex-left">
                <ul class="mobile-nav nav nav-left">
                    <li class="nav-icon has-icon">
                        <div class="header-button">
                            <a href="#" data-open="#main-menu" data-pos="left" data-bg="main-menu-overlay"
                                data-color="" class="icon primary button round is-small" aria-label="Menu"
                                aria-controls="main-menu" aria-expanded="false">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Left Elements -->
            <div class="flex-col hide-for-medium flex-left flex-grow">
                <ul class="header-nav header-nav-main nav nav-left nav-uppercase">
                    <li class="header-search-form search-form html relative has-icon">
                        <div class="header-search-form-wrapper">
                            <div class="searchform-wrapper ux-search-box relative form-flat is-normal">
                                <form role="search" method="get" class="searchform" action="{{ url('/') }}">
                                    <div class="flex-row relative">
                                        <div class="flex-col flex-grow">
                                            <label class="screen-reader-text"
                                                for="woocommerce-product-search-field-0">Search for:</label>
                                            <input type="search" id="woocommerce-product-search-field-0"
                                                class="search-field mb-0" placeholder="Nhập từ khóa tìm kiếm..."
                                                value="{{ request()->s }}" name="s" />
                                        </div>
                                        <div class="flex-col">
                                            <button type="submit" value="Search"
                                                class="ux-search-submit submit-button secondary button icon mb-0"
                                                aria-label="Submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="live-search-results text-left z-top"></div>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Right Elements -->
            <div class="flex-col hide-for-medium flex-right">
                <ul class="header-nav header-nav-main nav nav-right nav-uppercase">
                    <li class="html header-button-1">
                        <div class="header-button">
                            <a href="tel:{{ $settings->phone }}" class="button primary" style="border-radius: 99px">
                                <span>Hotline: {{ $settings->phone }}</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Mobile Right Elements -->
            <div class="flex-col  flex-right">
                <ul class="mobile-nav nav nav-right">
                    <li class="cart-item has-icon">
                        <div class="header-button">
                            <a href="{{ route('carts.list') }}"
                                class="header-cart-link off-canvas-toggle nav-top-link icon primary button circle is-small"
                                data-open="#cart-popup" data-class="off-canvas-cart" title="Cart"
                                data-pos="right">
                                <i class="fas fa-shopping-cart"
                                    data-icon-label="{{ Cart::instance('shopping')->count() }}"> </i>
                            </a>
                        </div>

                        <!-- Cart Sidebar Popup -->
                        <div id="cart-popup" class="mfp-hide widget_shopping_cart">
                            <div class="cart-popup-inner inner-padding">
                                <div class="cart-popup-title text-center">
                                    <h4 class="uppercase">Cart</h4>
                                    <div class="is-divider"></div>
                                </div>
                                <div class="widget_shopping_cart_content">
                                    <ul class="woocommerce-mini-cart cart_list product_list_widget">
                                        @foreach (Cart::instance('shopping')->content() as $cart)
                                            <li class="woocommerce-mini-cart-item mini_cart_item">

                                                @if (!request()->routeIs('carts.thanh-toan'))
                                                    <a class="remove remove_from_cart_button"
                                                        data-row-id="{{ $cart->rowId }}"
                                                        data-product_id="{{ $cart->id }}">×</a>
                                                @endif


                                                <a href="{{ route('products.detail', $cart->options->slug) }}">
                                                    <img width="300" height="300"
                                                        src="{{ showImage($cart->options->image) }}"
                                                        data-src="{{ showImage($cart->options->image) }}"
                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail lazy-load-active"
                                                        alt="" decoding="async" fetchpriority="high"
                                                        sizes="(max-width: 300px) 100vw, 300px" />{{ $cart->name }}
                                                </a>
                                                <span class="quantity">{{ $cart->qty }} ×
                                                    <span class="woocommerce-Price-amount amount"><bdi>{{ formatAmount($cart->price) }}<span
                                                                class="woocommerce-Price-currencySymbol">₫</span></bdi></span></span>
                                                <p class="sum_total" style="display: none">
                                                    {{ formatAmount($cart->subtotal) }}</p>
                                            </li>
                                        @endforeach


                                    </ul>

                                    <p class="woocommerce-mini-cart__total total">
                                        <strong>Subtotal:</strong>
                                        <span class="woocommerce-Price-amount amount"><bdi>{{ number_format((float) str_replace([',', '.'], ['', '.'], Cart::instance('shopping')->subTotal()), 0, ',', '.') }}<span
                                                    class="woocommerce-Price-currencySymbol">&#8363;</span></bdi></span>
                                    </p>

                                    <p class="woocommerce-mini-cart__buttons buttons" id="cart-links">
                                        <a href="{{ route('carts.list') }}" class="button wc-forward">Xem giỏ
                                            hàng</a>

                                        <a href="{{ route('carts.thanh-toan') }}"
                                            class="button checkout wc-forward
                                                @if (Cart::instance('shopping')->count() <= 0) d-none @endif">
                                            Thanh toán
                                        </a>

                                    </p>
                                </div>
                                <div class="cart-sidebar-content relative"></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>


        </div>


        <div class="header-search-form-wrapper" id="header-search" style="padding: 0 15px; display: none;">
            <div class="searchform-wrapper ux-search-box relative form-flat is-normal">
                <form role="search" method="get" class="searchform" action="{{ url('/') }}">
                    <div class="flex-row relative">
                        <div class="flex-col flex-grow">
                            <label class="screen-reader-text" for="woocommerce-product-search-field-0">Search
                                for:</label>
                            <input type="search" id="woocommerce-product-search-field-0"
                                class="search-field mb-0" placeholder="Nhập từ khóa tìm kiếm..."
                                value="{{ request()->s }}" name="s" />
                        </div>
                        <div class="flex-col">
                            <button type="submit" value="Search"
                                class="ux-search-submit submit-button secondary button icon mb-0"
                                aria-label="Submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="live-search-results text-left z-top"></div>
                </form>
            </div>
        </div>

    </div>


    <div class="header-bg-container fill">
        <div class="header-bg-image fill"></div>
        <div class="header-bg-color fill"></div>
    </div>
</div>
