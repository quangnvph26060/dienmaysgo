@extends('frontends.layouts.master')


@section('content')
    @include('components.breadcrumb_V2', compact('product'))
    <main id="main" class="">
        <div class="shop-container">
            <div class="container">
                <div class="woocommerce-notices-wrapper"></div>
            </div>
            <div id="product-1113"
                class="product type-product post-1113 status-publish first instock product_cat-may-phat-dien-elemax has-post-thumbnail shipping-taxable purchasable product-type-simple">
                <div class="row content-row row-divided row-large row-reverse">
                    {{-- <div id="product-sidebar" class="col large-3 hide-for-medium shop-sidebar"></div> --}}
                    <div class="col large-12">
                        <div class="product-main">
                            <div class="row">
                                <div class="large-6 col">
                                    <div class="product-images relative mb-half has-hover woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images"
                                        data-columns="4">
                                        <!-- Badge container -->
                                        <div class="badge-container is-larger absolute left top z-1"></div>

                                        <!-- Wishlist button -->
                                        @if ($product->price)
                                            <div class="image-tools absolute top show-on-hover right z-3">
                                                <div class="wishlist-icon">
                                                    <button data-id="{{ $product->id }}"
                                                        class="wishlist-button button is-outline circle icon add-to-cart"
                                                        aria-label="Wishlist">
                                                        <i class="icon-shopping-cart"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif


                                        <!-- Main image -->
                                        <figure
                                            class="woocommerce-product-gallery__wrapper product-gallery-slider slider slider-nav-small mb-half">
                                            <div class="woocommerce-product-gallery__image slide first">
                                                <a href="{{ asset('storage/' . $product->image) }}"
                                                    data-lightbox="product-gallery"
                                                    data-title="Máy phát điện Elemax SV2800">
                                                    <img id="main-image" width="458" height="458"
                                                        src="{{ asset('storage/' . $product->image) }}" alt=""
                                                        title="{{ $product->slug }}" decoding="async" fetchpriority="high"
                                                        sizes="(max-width: 458px) 100vw, 458px" />
                                                </a>
                                            </div>
                                        </figure>

                                        <!-- Gallery images -->
                                        <div class="product-gallery-thumbnails swiper-container">
                                            <div class="swiper-wrapper">
                                                @php
                                                    $images = array_merge(
                                                        [$product->image],
                                                        $product->images->pluck('image')->toArray() ?? [],
                                                    );
                                                @endphp
                                                {{-- @if ($product->images->isNotEmpty()) --}}
                                                @foreach ($images as $index => $image)
                                                    <div class="swiper-slide">
                                                        <img class="gallery-thumb" src="{{ asset('storage/' . $image) }}"
                                                            data-large-src="{{ asset('storage/' . $image) }}"
                                                            alt="Thumbnail {{ $index + 1 }}" />
                                                    </div>
                                                @endforeach
                                                {{-- @else
                                                @endif --}}
                                                <!-- Add more thumbnails as needed -->
                                            </div>
                                            <!-- Navigation buttons -->
                                        </div>
                                    </div>
                                </div>

                                <div class="product-info summary entry-summary col col-fit product-summary form-flat">
                                    <h1 class="product-title product_title entry-title" style="margin-bottom: 5px">
                                        {{ $product->name }}
                                    </h1>

                                    <p style="margin-bottom: 0; font-size: .8rem">
                                        Thương hiệu: {{ implode(' | ', $product->brands->pluck('name')->toArray()) }}

                                    </p>

                                    <hr>

                                    @if ($product->price > 0)
                                        <div class="price-wrapper">
                                            <p class="price product-page-price">
                                                <span class="woocommerce-Price-amount amount" style="display: block;">

                                                    @if (hasDiscount($product->promotion))
                                                        <bdi style=" font-size: 25px">{{ formatAmount(calculateAmount($product->price, $product->promotion->discount)) }}
                                                            ₫
                                                        </bdi>

                                                        <del
                                                            style="font-size: 14px;color: black !important;font-weight: 500; margin: 0 10px">
                                                            {{ formatAmount($product->price) }}
                                                            ₫
                                                        </del>

                                                        <span
                                                            style="color: black; font-size: 14px; font-weight: 500">-{{ number_format($product->promotion->discount, 0) }}%</span>
                                                    @else
                                                        <bdi>{{ formatAmount($product->price) }}
                                                            ₫
                                                        </bdi>
                                                    @endif

                                                </span>
                                            </p>
                                        </div>
                                    @endif




                                    @if ($product->price)

                                        <div style="margin-bottom: 10px">

                                            @if ($product->tags)
                                                <div style="display: flex; align-items: center; font-size: .8rem">
                                                    <p class="status" style="margin: 0">Tags: </p>
                                                    <p class="" style="margin: 0 0 0 60px">
                                                        {{ formatString($product->tags) }}</p>
                                                </div>
                                            @endif


                                            <div class="product_meta">
                                                <span class="posted_in" style="font-size: .8rem">Danh mục:
                                                    <a style="margin: 0 0 0 25px"
                                                        href="{{ route('products.list', $product->category->slug) }}"
                                                        rel="tag">{{ $product->category->name }}</a></span>
                                            </div>

                                            <div style="display: flex; align-items: center; font-size: .8rem">
                                                <p class="status" style="margin: 0">Trạng thái: </p>
                                                <p class="stock in-stock" style="margin: 0 0 0 30px">
                                                    {{ $product->quantity == 0 ? 'Hết hàng' : 'Còn hàng' }}</p>
                                            </div>
                                        </div>

                                        <form class="cart" action="" method="post" enctype="multipart/form-data">
                                            <div class="sticky-add-to-cart-wrapper">
                                                <div class="sticky-add-to-cart">
                                                    <div class="sticky-add-to-cart__product">
                                                        <img src="{{ showImage($product->image) }}" alt=""
                                                            class="sticky-add-to-cart-img" />
                                                        <div class="product-title-small hide-for-small">
                                                            <strong>{{ $product->name }}</strong>
                                                        </div>
                                                        @if ($product->price > 0)
                                                            <div class="price-wrapper">
                                                                <p class="price product-page-price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        @if (hasDiscount($product->promotion))
                                                                            <bdi>{{ formatAmount(calculateAmount($product->price, $product->promotion->discount)) }}
                                                                                ₫
                                                                            </bdi>
                                                                            <del
                                                                                style="font-size: 14px;color: black !important;font-weight: 500;">
                                                                                {{ formatAmount($product->price) }}
                                                                                ₫
                                                                            </del>
                                                                        @else
                                                                            <bdi>{{ formatAmount($product->price) }}
                                                                                ₫
                                                                            </bdi>
                                                                        @endif
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if ($product->price > 0)
                                                        <div class="quantity buttons_added form-flat">
                                                            <label class="screen-reader-text" for="quantity_674f195d66f6f">
                                                                {{ $product->name }}
                                                            </label>

                                                            <input type="button" value="-"
                                                                class="minus button is-form" />
                                                            <input type="number" id="quantity_674f195d66f6f"
                                                                class="input-text qty text" step="1" min="1"
                                                                name="quantity" value="1" title="Qty" size="4"
                                                                placeholder="" inputmode="numeric" />
                                                            <input type="button" value="+"
                                                                class="plus button is-form" />
                                                        </div>

                                                        <button type="button" name="add-to-cart"
                                                            data-product-id="{{ $product->id }}"
                                                            class="single_add_to_cart_button button alt"
                                                            style="margin-right: 5px">
                                                            Thêm giỏ hàng
                                                        </button>
                                                    @endif


                                                    <a href="{{ route('contact', ['product' => $product->slug]) }}"
                                                        class="single_add_to_cart_button button alt"
                                                        style="background: #ec1c24 !important; padding-left: 40px; padding-right: 40px; padding-bottom: 1px;">Liên
                                                        hệ <span class="bi bi-telephone"
                                                            style="margin-left: 3px"></span></a>
                                                </div>
                                            </div>

                                        </form>
                                    @endif

                                    <div class="hotline-box">
                                        <p class="meta-title">
                                            {{ $settings->introduct_title }}
                                        </p>
                                        <div class="hotline-content">
                                            <div>
                                                <i class="bi bi-telephone-fill"></i> Hotline:
                                            </div>
                                            <div>
                                                @foreach ($settings->introduction['phone'] ?? [] as $key => $item)
                                                    <p>
                                                        <span class="hotline-number">{{ $item }}</span>
                                                        <span
                                                            class="hotline-region">{{ $settings->introduction['facility'][$key] ?? '' }}</span>
                                                    </p>
                                                @endforeach

                                            </div>

                                        </div>
                                    </div>

                                    <div class="Service-freeship">
                                        <p><i class="bi bi-car-front"></i>Miễn phí giao hàng trong nội thành Hà Nội và
                                            nội
                                            thành TP. Hồ Chí Minh.</p>
                                        <p><i class="bi bi-hand-index-thumb"></i>Hàng Chính Hãng</p>
                                        <p><i class="bi bi-shield-check"></i>Bảo hành chính hãng, có người đến tận nhà.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-footer">
                            <div class="woocommerce-tabs wc-tabs-wrapper container tabbed-content">
                                <ul class="tabs wc-tabs product-tabs small-nav-collapse nav nav-uppercase nav-tabs nav-normal nav-left"
                                    role="tablist">
                                    <li class="description_tab active" id="tab-title-description" role="presentation">
                                        <a href="#tab-description" role="tab" aria-selected="true"
                                            aria-controls="tab-description">
                                            Mô tả chi tiết
                                        </a>
                                    </li>
                                    <li class="additional_information_tab" id="tab-title-additional_information"
                                        role="presentation">
                                        <a href="#tab-additional_information" role="tab" aria-selected="false"
                                            aria-controls="tab-additional_information" tabindex="-1">
                                            Thông số kỹ thuật
                                        </a>
                                    </li>
                                    {{-- <li class="reviews_tab" id="tab-title-reviews" role="presentation">
                                    <a href="#tab-reviews" role="tab" aria-selected="false" aria-controls="tab-reviews"
                                        tabindex="-1">
                                        Bình luận &amp; đánh giá
                                    </a>
                                </li> --}}
                                </ul>
                                <div class="tab-panels">
                                    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content active"
                                        id="tab-description" role="tabpanel" aria-labelledby="tab-title-description">
                                        {!! $product->description !!}
                                    </div>
                                    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--additional_information panel entry-content"
                                        id="tab-additional_information" role="tabpanel"
                                        aria-labelledby="tab-title-additional_information">
                                        {!! $product->description_short !!}

                                    </div>

                                </div>
                            </div>

                            <div class="related related-products-wrapper product-section">
                                <h3
                                    class="product-section-title container-width product-section-title-related pt-half pb-half uppercase">
                                    Sản phẩm liên quan
                                </h3>

                                <div class="row has-equal-box-heights equalize-box large-columns-4 medium-columns-3 small-columns-2 row-small slider row-slider slider-nav-reveal slider-nav-push"
                                    data-flickity-options='{"imagesLoaded": true, "groupCells": "100%", "dragThreshold" : 5, "cellAlign": "left","wrapAround": true,"prevNextButtons": true,"percentPosition": true,"pageDots": false, "rightToLeft": false, "autoPlay" : false}'>


                                    <x-products :products="$relatedProducts" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- shop container -->
    </main>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raty/2.7.1/jquery.raty.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontends/assets/js/toastr.min.js') }}"></script>

    <script>
        jQuery(function() {

            const images = document.querySelectorAll('.woocommerce-Tabs-panel img');

            images.forEach(img => {
                // Lấy giá trị alt của từng ảnh
                const altText = img.alt;

                // Tạo thẻ div để hiển thị alt
                const altDiv = document.createElement('div');
                altDiv.classList.add('image-alt');
                altDiv.textContent = altText;

                // Thêm thẻ altDiv bên dưới ảnh
                img.parentElement.appendChild(altDiv);
            });
        });

        jQuery.noConflict();

        addToCart();

        jQuery(document).ready(function($) {
            $("#star-rating").raty({
                starType: "i",
                scoreName: "rating",
            });
        });

        lightbox.option({
            resizeDuration: 200, // Thời gian chuyển đổi
            wrapAround: true, // Lặp lại danh sách ảnh
            alwaysShowNavOnTouchDevices: true, // Hiển thị nút điều hướng trên thiết bị cảm ứng
        });

        document.addEventListener("DOMContentLoaded", () => {
            const swiper = new Swiper(".swiper-container", {
                slidesPerView: 5, // Hiển thị 4 ảnh
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    // Responsive settings
                    640: {
                        slidesPerView: 5,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 5,
                        spaceBetween: 15,
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 20,
                    },
                },
            });

            // Thay đổi ảnh chính khi bấm vào gallery
            const mainImage = document.getElementById("main-image");
            const thumbnails = document.querySelectorAll(".gallery-thumb");

            thumbnails.forEach((thumb) => {
                thumb.addEventListener("click", () => {
                    const largeSrc = thumb.getAttribute("data-large-src");
                    mainImage.src = largeSrc;
                    mainImage.parentElement.href = largeSrc; // Update lightbox link
                });
            });
        });
    </script>

    <script>
        jQuery(document).ready(function() {
            jQuery(document).on('click', '.single_add_to_cart_button', function() {
                const id = jQuery(this).data('product-id'); // Lấy ID sản phẩm từ data attribute
                const quantity = jQuery('#quantity_674f195d66f6f').val(); // Lấy số lượng từ input

                jQuery.ajax({
                    url: "{{ route('carts.add-to-cart') }}", // Route xử lý giỏ hàng
                    type: 'POST',
                    data: {
                        productId: id,
                        qty: quantity, // Truyền số lượng
                        _token: "{{ csrf_token() }}" // Token bảo mật
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message); // Hiển thị thông báo thành công

                            cartResponse(response); // Cập nhật giao diện giỏ hàng
                        } else {
                            toastr.error(response.message); // Hiển thị lỗi từ server
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Có lỗi xảy ra! Vui lòng thử lại.'); // Thông báo lỗi chung
                    }
                });
            });
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/raty/2.7.1/jquery.raty.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        .Service-freeship {
            padding: 10px;
            margin-top: 15px;
            border: 1px solid #ddd;
        }

        .Service-freeship p {
            margin: 0;
            font-size: .8rem;
        }

        .Service-freeship p i {
            color: #ec1c24;
            margin-right: 10px;
        }

        #main-image {
            height: 400px;
        }

        .hotline-box {
            border: 1px solid #ddd;
            padding: 10px;
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin-top: 10px;
        }

        .meta-title {
            text-align: center;
            font-weight: bold;
            font-size: .8rem;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 6px;
        }

        .hotline-content {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .hotline-content p {
            margin: 0;
            font-size: .8rem;
            color: #333;
            line-height: 2
        }

        .hotline-number {
            color: red;
            font-weight: bold;
            margin-right: 10px;
        }

        .hotline-region {
            color: #333;
        }

        .image-alt {
            text-align: center;
            margin-top: 10px;
            font-style: italic;
            color: #555;
            background: rgba(128, 128, 128, .3)
        }

        .has-equal-box-heights .box-image {
            padding-top: 10% !important;
        }

        div#star-rating i {
            font-size: 2rem;
            /* Kích thước sao */
            color: #ccc;
            /* Màu sao mặc định */
        }

        div#star-rating i {
            color: #f5c518;
            /* Màu sao khi được chọn */

            cursor: pointer;
        }

        div#star-rating i.hover {
            color: #ffa726;
            /* Màu sao khi hover */
        }

        .header-cart .cart-link {
            position: relative;
            color: #333;
            /* Màu biểu tượng */
            text-decoration: none;
        }

        .header-cart .cart-link:hover {
            color: #000;
            /* Màu biểu tượng khi hover */
        }

        .header-cart .cart-count {
            text-align: center;
            transform: translate(-70%, -50%);
            background-color: #dc3545;
            /* Màu nền badge */
            color: #fff;
            font-size: 0.75rem;
            font-weight: bold;
            padding: 0.1rem 0.3rem;
            border-radius: 50%;
            visibility: visible;
            /* Luôn hiển thị */
            opacity: 1;
            /* Đảm bảo không bị mờ */
            transition: all 0.2s ease-in-out;
            /* Hiệu ứng khi hover */
        }

        .product-gallery-thumbnails {
            margin-top: 10px;
            gap: 10px;
        }

        .gallery-thumb {
            width: 100px;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid gray;

            transition: border 0.3s ease;
        }

        .gallery-thumb:hover {
            border: 2px solid #0071e3;
        }

        .product-gallery-thumbnails {
            width: 100%;
            max-width: 500px;
            /* margin: auto; */
        }

        .swiper-slide {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            width: auto;
            /* Điều chỉnh tự động */
        }

        .swiper-container {
            width: 100%;
            max-width: 600px;
            /* Giới hạn chiều rộng */
            /* margin: 10px auto; */
            overflow: hidden;
        }

        .mfp-content.open {
            display: block;
            /* Hiển thị popup */
            right: 0;
            /* Trượt vào từ bên phải */
            transition: left 0.3s ease;
        }

        #section_1960688269 {
            padding-top: 30px;
            padding-bottom: 30px;
        }

        #section_1960688269 .ux-shape-divider--top svg {
            height: 150px;
            --divider-top-width: 100%;
        }

        #section_1960688269 .ux-shape-divider--bottom svg {
            height: 150px;
            --divider-width: 100%;
        }
    </style>
@endpush
