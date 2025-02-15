<div class="sidebar-menu no-scrollbar">
    <ul class="nav nav-sidebar nav-vertical nav-uppercase nav-slide" data-tab="1">
        <li class="header-search-form search-form html relative has-icon">
            <div class="header-search-form-wrapper">
                <div class="searchform-wrapper ux-search-box relative form-flat is-normal">
                    <form role="search" method="get" class="searchform" action="{{ url('/') }}">
                        <div class="flex-row relative">
                            <div class="flex-col flex-grow">
                                <label class="screen-reader-text" for="woocommerce-product-search-field-2">Search
                                    for:</label>
                                <input type="search" id="woocommerce-product-search-field-2" class="search-field mb-0"
                                    placeholder="Nhập từ khóa tìm kiếm..." value="" name="s" />
                                <input type="hidden" name="post_type" value="product" />
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
        <li
            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-21 current_page_item menu-item-1080">
            <a href="{{ route('home') }}" aria-current="page">Trang chủ</a>
        </li>

        @foreach ($cataloguesMenu as $item)
            <li
                class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-1606">
                <a href="{{ route('products.detail', $item->slug) }}">{{ $item->name }}</a>
                <ul class="sub-menu nav-sidebar-ul children">

                    @if ($item->childrens->isNotEmpty())
                        @foreach ($item->childrens as $child)
                            <li
                                class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-1607">
                                <div class="menu-header">
                                    <a href="{{ route('products.detail', $child->slug) }}">{{ $child->name }}</a>
                                    <!-- Dấu cộng -->
                                    @if ($child->childrens->isNotEmpty())
                                    <button class="toggle-submenu-item">+</button>
                                    @endif
                                </div>
                                <ul class="sub-menu-item nav-sidebar-ul" style="display: none;">
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
