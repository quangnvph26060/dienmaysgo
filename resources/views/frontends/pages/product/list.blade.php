@extends('frontends.layouts.master')

@section('content')
    <div class="row category-page-row">
        <div class="col large-3 hide-for-medium">
            <div id="shop-sidebar" class="sidebar-inner col-inner">
                <aside id="woocommerce_layered_nav-2"
                    class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav">
                    <span class="widget-title shop-sidebar">Nhiên liệu sử dụng</span>
                    <div class="is-divider small"></div>
                    <ul class="woocommerce-widget-layered-nav-list">

                        @foreach ($fuels as $key => $count)
                            <li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term">
                                <a rel="nofollow" href="?filter_nhien-lieu={{ $key }}">{{ $key }}</a>
                                <span class="count">({{ $count }})</span>
                            </li>
                        @endforeach
                    </ul>
                </aside>
            </div>
        </div>

        <div class="col large-9">
            <div class="shop-container">
                <div class="title_page">
                    <h1>{{ $category->name ?? 'Kết quả tìm kiếm' . '"' . request()->s . '"' }}</h1>
                </div>
                <div class="sortbypttuan410">
                    <div class="titlesort">Ưu tiên xem:</div>
                    <form id="pricedesc">
                        @if (request('s'))
                            <input type="hidden" name="s" value="{{ request('s') }}">
                        @endif
                        @if (request('filter_nhien-lieu'))
                            <input type="hidden" name="filter_nhien-lieu" value="{{ request('filter_nhien-lieu') }}">
                        @endif
                        <div class="range-check">
                            <input class="pt-checkbox" @checked(request()->orderby == 'price-desc') type="checkbox" value="price-desc"
                                id="price-desc" name="orderby" onChange="this.form.submit()" />
                            <label for="price-desc">Giá giảm dần</label>
                        </div>
                    </form>
                    <form id="pricesmall">
                        @if (request('s'))
                            <input type="hidden" name="s" value="{{ request('s') }}">
                        @endif
                        @if (request('filter_nhien-lieu'))
                            <input type="hidden" name="filter_nhien-lieu" value="{{ request('filter_nhien-lieu') }}">
                        @endif
                        <div class="range-check">
                            <input class="pt-checkbox" @checked(request()->orderby == 'price') type="checkbox" value="price"
                                id="price" name="orderby" onChange="this.form.submit()" />
                            <label for="price">Giá tăng dần</label>
                        </div>
                    </form>
                    <form id="datecheck">
                        @if (request('s'))
                            <input type="hidden" name="s" value="{{ request('s') }}">
                        @endif
                        @if (request('filter_nhien-lieu'))
                            <input type="hidden" name="filter_nhien-lieu" value="{{ request('filter_nhien-lieu') }}">
                        @endif
                        <div class="range-check">
                            <input class="pt-checkbox" @checked(request()->orderby == 'date') type="checkbox" value="date"
                                id="date" name="orderby" onChange="this.form.submit()" />
                            <label for="date">Mới nhất</label>
                        </div>
                    </form>
                    <form id="oldproduct">
                        @if (request('s'))
                            <input type="hidden" name="s" value="{{ request('s') }}">
                        @endif
                        @if (request('filter_nhien-lieu'))
                            <input type="hidden" name="filter_nhien-lieu" value="{{ request('filter_nhien-lieu') }}">
                        @endif
                        <div class="range-check">
                            <input class="pt-checkbox" @checked(request()->orderby == 'old-product') type="checkbox" value="old-product"
                                id="old-product" name="orderby" onChange="this.form.submit()" />
                            <label for="old-product">Cũ nhất</label>
                        </div>
                    </form>
                </div>
                @isset($category)
                    <div class="term-description" style="margin-top: 30px">
                        {!! $category->description !!}
                    </div>
                @endisset

                <div class="woocommerce-notices-wrapper"></div>
                <div
                    class="products row row-small large-columns-4 medium-columns-3 small-columns-2 has-equal-box-heights equalize-box">

                    @if ($products->isNotEmpty())
                        @foreach ($products as $product)
                            <x-product-item :product="$product" />
                        @endforeach
                    @endif
                </div>
                <!-- row -->
                <div class="container">
                    {{ $products->links('vendor.pagination.custom') }}
                </div>
            </div>
            <!-- shop container -->
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        addToCart();
    </script>
@endpush

@push('styles')
    <style>
        .has-equal-box-heights .box-image {
            padding-top: 0;
            margin-top: 15px;
        }
    </style>
@endpush
