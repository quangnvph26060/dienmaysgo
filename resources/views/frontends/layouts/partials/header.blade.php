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
                    <li id="menu-item-2011"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2011 menu-item-design-default">
                        <a href="https://dienmaysgo.com/gioi-thieu/" class="nav-top-link">Giới thiệu</a>
                    </li>
                    <li id="menu-item-2008"
                        class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-2008 menu-item-design-default">
                        <a href="https://dienmaysgo.com/category/tin-tuc/" class="nav-top-link">Tin tức</a>
                    </li>
                    <li id="menu-item-2010"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2010 menu-item-design-default">
                        <a href="https://dienmaysgo.com/lien-he/" class="nav-top-link">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="masthead" class="header-main hide-for-sticky">
        <div class="header-inner flex-row container logo-left medium-logo-center" role="navigation">
            <!-- Logo -->
            <div id="logo" class="flex-col logo">
                <!-- Header logo -->
                <a href="https://dienmaysgo.com/" title="dienmaysgo.com" rel="home">
                    <img width="1020" height="422"
                        src="https://dienmaysgo.com/wp-content/uploads/2023/05/dienmaysgo-1024x424.png"
                        class="header_logo header-logo" alt="dienmaysgo.com" /><img width="1020" height="422"
                        src="https://dienmaysgo.com/wp-content/uploads/2023/05/dienmaysgo-1024x424.png"
                        class="header-logo-dark" alt="dienmaysgo.com" /></a>
            </div>

            <!-- Mobile Left Elements -->
            <div class="flex-col show-for-medium flex-left">
                <ul class="mobile-nav nav nav-left">
                    <li class="nav-icon has-icon">
                        <div class="header-button">
                            <a href="#" data-open="#main-menu" data-pos="left" data-bg="main-menu-overlay"
                                data-color="" class="icon primary button round is-small" aria-label="Menu"
                                aria-controls="main-menu" aria-expanded="false">
                                <i class="icon-menu"></i>
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
                                <form role="search" method="get" class="searchform" action="https://dienmaysgo.com/">
                                    <div class="flex-row relative">
                                        <div class="flex-col flex-grow">
                                            <label class="screen-reader-text"
                                                for="woocommerce-product-search-field-0">Search for:</label>
                                            <input type="search" id="woocommerce-product-search-field-0"
                                                class="search-field mb-0" placeholder="Nhập từ khóa tìm kiếm..."
                                                value="" name="s" />
                                            <input type="hidden" name="post_type" value="product" />
                                        </div>
                                        <div class="flex-col">
                                            <button type="submit" value="Search"
                                                class="ux-search-submit submit-button secondary button icon mb-0"
                                                aria-label="Submit">
                                                <i class="icon-search"></i>
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
                    <li class="header-cart relative">
                        <a href="" class="cart-link position-relative">
                            <i class="bi bi-cart3" style="font-size: 1.5rem"></i>
                            <span class="cart-count rounded-pill bg-danger"> {{\Cart::instance('shopping')->count()}} </span>
                        </a>
                    </li>
                    <li class="html header-button-1">
                        <div class="header-button">
                            <a href="tel:0914379989" class="button primary" style="border-radius: 99px">
                                <span>Hotline: 0914379989</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Mobile Right Elements -->
            <div class="flex-col show-for-medium flex-right">
                <ul class="mobile-nav nav nav-right">
                    <li class="cart-item has-icon">
                        <div class="header-button">
                            <a href="https://dienmaysgo.com/gio-hang/"
                                class="header-cart-link off-canvas-toggle nav-top-link icon primary button circle is-small"
                                data-open="#cart-popup" data-class="off-canvas-cart" title="Cart"
                                data-pos="right">
                                <i class="icon-shopping-bag" data-icon-label="0"> </i>
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
                                    <p class="woocommerce-mini-cart__empty-message">
                                        No products in the cart.
                                    </p>
                                </div>
                                <div class="cart-sidebar-content relative"></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wide-nav" class="header-bottom wide-nav nav-dark flex-has-center">
        <div class="flex-row container">
            <div class="flex-col hide-for-medium flex-center">
                <ul class="nav header-nav header-bottom-nav nav-center nav-uppercase">
                    <li id="menu-item-1080"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-21 current_page_item menu-item-1080 active menu-item-design-default">
                        <a href="https://dienmaysgo.com/" aria-current="page" class="nav-top-link">Trang chủ</a>
                    </li>


                    @foreach ($cataloguesMenu as $item)
                        <li
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-1606 menu-item-design-default has-dropdown">
                            <a href="https://dienmaysgo.com/may-phat-dien/" class="nav-top-link"
                                aria-expanded="false" aria-haspopup="menu">{{ $item->name }}<i
                                    class="icon-angle-down"></i></a>
                            <ul class="sub-menu nav-dropdown nav-dropdown-default">

                                @if ($item->childrens->isNotEmpty())
                                    @foreach ($item->childrens as $child)
                                        <li id="menu-item-1607"
                                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-1607 nav-dropdown-col">
                                            <a
                                                href="https://dienmaysgo.com/may-phat-dien-elemax/">{{ $child->name }}</a>
                                            <ul class="sub-menu nav-column nav-dropdown-default">
                                                @include('frontends.layouts.partials.menu-item', [
                                                    'item' => $child,
                                                ])
                                            </ul>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex-col show-for-medium flex-grow">
                <ul class="nav header-bottom-nav nav-center mobile-nav nav-uppercase">
                    <li class="header-search-form search-form html relative has-icon">
                        <div class="header-search-form-wrapper">
                            <div class="searchform-wrapper ux-search-box relative form-flat is-normal">
                                <form role="search" method="get" class="searchform"
                                    action="https://dienmaysgo.com/">
                                    <div class="flex-row relative">
                                        <div class="flex-col flex-grow">
                                            <label class="screen-reader-text"
                                                for="woocommerce-product-search-field-1">Search for:</label>
                                            <input type="search" id="woocommerce-product-search-field-1"
                                                class="search-field mb-0" placeholder="Nhập từ khóa tìm kiếm..."
                                                value="" name="s" />
                                            <input type="hidden" name="post_type" value="product" />
                                        </div>
                                        <div class="flex-col">
                                            <button type="submit" value="Search"
                                                class="ux-search-submit submit-button secondary button icon mb-0"
                                                aria-label="Submit">
                                                <i class="icon-search"></i>
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
        </div>
    </div>

    <div class="header-bg-container fill">
        <div class="header-bg-image fill"></div>
        <div class="header-bg-color fill"></div>
    </div>
</div>
