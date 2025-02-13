@extends('frontends.layouts.master')

@section('title', $category ? $category->name : 'Sản phẩm')
@section('description', $category->description_seo ?? '')
@section('keywords', $category->keyword_seo ?? '')
@section('og_title', $category ? $category->name : '')
@section('og_description', $category->description_seo ?? '')

@section('content')
    @include('components.breadcrumb_V2', ['category' => $category ?? null])
    <div class="shop-page-title category-page-title page-title" style="display: none">
        <div class="page-title-inner flex-row medium-flex-wrap container">
            <div class="flex-col flex-grow medium-text-center">
                <h1 class="shop-page-title is-xlarge">Máy phát điện</h1>
                <div class="category-filtering category-filter-row show-for-medium">
                    <a href="#" data-open="#shop-sidebar" data-visible-after="true" data-pos="left"
                        class="filter-button uppercase plain">
                        <i class="bi bi-sliders"></i>
                        <strong>Lọc sản phẩm</strong>
                    </a>
                    <div class="inline-block"></div>
                </div>
            </div>
            <div class="flex-col medium-text-center"></div>
        </div>
    </div>
    <form id="filterForm">
        <div class="row category-page-row">
            <div class="col large-3 hide-for-medium">
                <div id="shop-sidebar" class="sidebar-inner col-inner">

                    @if (!empty($attributes))
                        @foreach ($attributes as $attribute)
                            @if ($attribute->attribute->attributeValues->isNotEmpty())
                                <aside class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav">
                                    <span class="widget-title shop-sidebar">{{ $attribute->title }}</span>
                                    <div class="is-divider small"></div>
                                    @foreach ($attribute->attribute->attributeValues as $item)
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div class="d-flex">
                                                <input type="checkbox" name="attr[]" value="{{ $item->id }}"
                                                    onchange="submitFormWithDelay()" id="{{ $item->id }}">
                                                <label for="{{ $item->id }}">{{ $item->value }}</label>
                                            </div>
                                            <small>({{ $item->products_count }})</small>
                                        </div>
                                    @endforeach
                                </aside>
                            @endif
                        @endforeach
                    @endif


                    @if (!empty($brands) && !empty($brands['data']))
                        <aside class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav">
                            <span class="widget-title shop-sidebar">{{ $brands['title'] }}</span>
                            <div class="is-divider small"></div>
                            @foreach ($brands['data'] as $brand)
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div class="d-flex">
                                        <input type="checkbox" name="brand[]" value="{{ $brand['id'] }}"
                                            onchange="submitFormWithDelay()">
                                        <label>{{ $brand['name'] }}</label>
                                    </div>
                                    <small>({{ $brand['products_count'] }})</small>
                                </div>
                            @endforeach
                        </aside>
                    @endif


                    {{-- @if (!empty($priceOptions))
                        <span class="widget-title shop-sidebar">{{ $priceFilter->title }}</span>
                        <select name="price_range" id="price_range" onchange="submitFormWithDelay()">
                            <option value="">Tất cả</option>
                            @foreach ($priceOptions as $priceRange)
                                <option value="{{ $priceRange }}"
                                    {{ request('price_range') == $priceRange ? 'selected' : '' }}>
                                    {{ $priceRange }} VNĐ
                                </option>
                            @endforeach
                        </select>
                    @endif --}}


                    @if (!empty($priceOptions))
                        <aside class="widget woocommerce widget_layered_nav woocommerce-widget-layered-nav">
                            <span class="widget-title shop-sidebar">{{ $priceFilter->title }}</span>
                            <div class="is-divider small"></div>
                            <div>
                                <label class="d-flex">
                                    <input type="checkbox" name="price_range" value=""
                                        onchange="submitFormWithDelay()"
                                        {{ request('price_range') == '' ? 'checked' : '' }}>
                                    Tất cả
                                </label>
                            </div>
                            @foreach ($priceOptions as $priceRange)
                                <div>
                                    <label class="d-flex">
                                        <input type="checkbox" name="price_range" value="{{ $priceRange }}"
                                            onchange="submitFormWithDelay()"
                                            {{ request('price_range') == $priceRange ? 'checked' : '' }}>
                                        {{ $priceRange }} VNĐ
                                    </label>
                                </div>
                            @endforeach
                        </aside>
                    @endif


                </div>
            </div>

            <div class="col large-9">
                <div class="shop-container">
                    <div class="title_page">
                        <h1>{{ $category->name ?? 'Kết quả tìm kiếm ' . '"' . request()->s . '"' }}</h1>
                    </div>


                    <div class="sortbypttuan410">

                        <div class="range-check">
                            <input class="pt-checkbox" onchange="submitFormWithDelay()" type="checkbox" value="price-desc"
                                id="price-desc" name="orderby" />
                            <label for="price-desc">Giá giảm dần</label>
                        </div>

                        <div class="range-check">
                            <input class="pt-checkbox" onchange="submitFormWithDelay()" type="checkbox" value="price"
                                id="price" name="orderby" />
                            <label for="price">Giá tăng dần</label>
                        </div>

                        <div class="range-check">
                            <input class="pt-checkbox" onchange="submitFormWithDelay()" type="checkbox" value="date"
                                id="date" name="orderby" />
                            <label for="date">Mới nhất</label>
                        </div>

                        <div class="range-check">
                            <input class="pt-checkbox" onchange="submitFormWithDelay()" type="checkbox" value="old-product"
                                id="old-product" name="orderby" />
                            <label for="old-product">Cũ nhất</label>
                        </div>
                    </div>

                    @isset($category)
                        <div class="term-description" style="margin-top: 30px">
                            {!! $category->description !!}
                        </div>
                    @endisset

                    <div class="woocommerce-notices-wrapper"></div>
                    <div
                        class="products row row-small large-columns-4 medium-columns-3 small-columns-2 has-equal-box-heights equalize-box">

                        <x-products :products="$products" />

                    </div>
                    <!-- row -->
                    <div class="container">
                        <div class="pagination">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
                <!-- shop container -->
            </div>
        </div>
    </form>
@endsection


@push('scripts')
    <script>
        document.querySelectorAll('input[type="checkbox"][name="price_range"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // Nếu checkbox này được chọn, bỏ chọn tất cả các checkbox khác
                if (this.checked) {
                    document.querySelectorAll('input[type="checkbox"][name="price_range"]').forEach(
                        function(otherCheckbox) {
                            if (otherCheckbox !== checkbox) {
                                otherCheckbox.checked = false;
                            }
                        });
                }
            });
        });

        addToCart();

        var loadingOverlay = document.getElementById('loading-overlay');

        window.onload = function() {

            document.addEventListener('click', function(event) {
                const paginationLinks = document.querySelectorAll('.pagination a.page-number');

                // Kiểm tra nếu sự kiện xảy ra trên một liên kết trong phân trang
                if ([...paginationLinks].includes(event.target) || event.target.closest('a.page-number')) {
                    event.preventDefault(); // Ngăn tải lại trang
                    loadingOverlay.style.display = 'flex';

                    // Lấy URL từ thuộc tính href của liên kết
                    const url = event.target.closest('a.page-number').getAttribute(
                        'href'); // Sử dụng closest để lấy thẻ a
                    if (url) {
                        // Lấy tham số 's' từ URL hiện tại (nếu có)
                        const urlParams = new URLSearchParams(window.location.search);
                        const searchKeyword = urlParams.get('s');

                        // Tạo URL mới bao gồm cả tham số 's' nếu có
                        const updatedUrl = new URL(url, window.location.origin);
                        if (searchKeyword) {
                            updatedUrl.searchParams.set('s', searchKeyword); // Thêm 's' vào query string
                        }

                        // Gửi request AJAX
                        fetch(updatedUrl.toString(), {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Cập nhật sản phẩm
                                document.querySelector('.products').innerHTML = data.html;

                                // Cập nhật phân trang
                                document.querySelector('.pagination').innerHTML = data.pagination;
                            })
                            .catch(error => console.log(error))
                            .finally(() => {
                                // Ẩn loading overlay
                                loadingOverlay.style.display = 'none';
                            });
                    }
                }
            });


            document.querySelectorAll('.sortbypttuan410 input[type="checkbox"]').forEach(input => {
                input.addEventListener('change', (event) => {
                    // Bỏ chọn tất cả checkbox khác
                    document.querySelectorAll('.sortbypttuan410 input[type="checkbox"]').forEach(
                        checkbox => {
                            if (checkbox !== event.target) {
                                checkbox.checked = false;
                            }
                        });
                });
            });
        };


        let timeout;

        function submitFormWithDelay() {
            const loadingOverlay = document.getElementById('loading-overlay');

            loadingOverlay.style.display = 'flex';
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const form = document.getElementById('filterForm');
                const formData = new FormData(form);
                const params = new URLSearchParams();

                // Chuyển FormData thành query string
                for (const [key, value] of formData.entries()) {
                    params.append(key, value);
                }

                // Lấy giá trị của 's' từ URL hiện tại
                const urlParams = new URLSearchParams(window.location.search);
                const searchKeyword = urlParams.get('s');
                if (searchKeyword) {
                    params.append('s', searchKeyword); // Thêm tham số 's' vào params
                }

                // Gửi request qua URL với query string
                fetch('{{ route('products.filter-product', $category->slug ?? '') }}?' + params.toString(), {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('.pagination').innerHTML = data.pagination;
                        document.querySelector('.products').innerHTML = data.html;
                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        // Ẩn loading overlay
                        loadingOverlay.style.display = 'none';
                    });
            }, 500);
        }
    </script>
@endpush

@push('styles')
    <style>
        .d-flex {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .col.large-3.hide-for-medium {
            padding-left: 0 !important;
        }

        @media (max-width: 768px) {
            .shop-page-title.category-page-title.page-title {
                display: block !important;
            }

            .title_page {
                display: none;
            }
        }

        .has-equal-box-heights .box-image {
            padding-top: 0;
            margin-top: 15px;
        }

        label {
            margin-bottom: 0 !important;
        }
    </style>
@endpush
