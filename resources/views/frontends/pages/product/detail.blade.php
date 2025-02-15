@extends('frontends.layouts.master')

@section('title', $product->name)
@section('description', $product->description_seo)
@section('keywords', formatString($product->keyword_seo))
@section('og_title', $product->name)
@section('og_description', $product->description_seo)

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
                    <div class="large-12">
                        <div class="product-main">
                            <div class="row">
                                <div class="large-6 col">
                                    <div class="product-images relative mb-half has-hover woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images"
                                        data-columns="4">
                                        <!-- Badge container -->
                                        <div class="badge-container is-larger absolute left top z-1"></div>

                                        <!-- Main image -->
                                        <figure
                                            class="woocommerce-product-gallery__wrapper product-gallery-slider slider slider-nav-small mb-half">
                                            <div class="woocommerce-product-gallery__image slide first">
                                                <a href="{{ asset('storage/' . $product->image) }}"
                                                    data-lightbox="product-gallery" data-title="{{ $product->name }}">
                                                    <img id="main-image" width="500" height="500"
                                                        src="{{ asset('storage/' . $product->image) }}" alt=""
                                                        title="{{ $product->slug }}" decoding="async" fetchpriority="high"
                                                        sizes="(max-width: 500px) 100vw, 500px" />
                                                </a>
                                            </div>
                                        </figure>

                                        <!-- Gallery images -->
                                        @php
                                            $images = array_merge(
                                                [$product->image],
                                                $product->images->pluck('image')->toArray() ?? [],
                                            );
                                        @endphp
                                        @if (count($images) > 1)
                                            <div class="product-gallery-thumbnails swiper-container">
                                                <div class="swiper-wrapper">

                                                    {{-- @if ($product->images->isNotEmpty()) --}}
                                                    @foreach ($images as $index => $image)
                                                        <div class="swiper-slide">
                                                            <img class="gallery-thumb"
                                                                src="{{ asset('storage/' . $image) }}"
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
                                        @endif

                                    </div>
                                </div>

                                <div class="product-info summary entry-summary col col-fit product-summary form-flat">
                                    <h1 class="product-title product_title entry-title"
                                        style="margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                                        {{ $product->name }}
                                        @if (auth()->guard('admin')->check())
                                            <span class="edit-icon"> <a target="_bank"
                                                    href="{{ route('admin.product.detail', $product->id) }}">✏️ </a></span>
                                        @endif
                                    </h1>


                                    <div class="product-details">
                                        @if ($product->module)
                                            <div class="detail-item"><span class="label">Module:</span> <span
                                                    class="value">{{ $product->module }}</span>
                                            </div>
                                        @endif
                                        @if ($product->brand)
                                            <div class="detail-item"><span class="label">Thương hiệu:</span> <span
                                                    class="value">{{ $product->brand->name }}</span>
                                            </div>
                                        @endif
                                        @if ($product->category)
                                            <div class="detail-item"><span class="label">Danh mục:</span>
                                                <span class="value">
                                                    <a href="{{ route('products.detail', $product->category->slug) }}"
                                                        rel="tag">{{ $product->category->name }}</a>
                                                </span>
                                            </div>
                                        @endif

                                        @foreach ($product->attributes as $attribute)
                                            <div class="detail-item"><span class="label">{{ $attribute->name }}:</span>
                                                @php
                                                    $value = $product->attributeValues
                                                        ->where('id', $attribute->pivot->attribute_value_id)
                                                        ->first();
                                                @endphp

                                                <span class="value">{{ $value ? $value->value : 'Không có' }}</span>
                                            </div>
                                        @endforeach
                                    </div>



                                    <hr>

                                    @if ($product->price > 0)
                                        <div class="price-wrapper">
                                            <p class="price product-page-price">
                                                <span class="woocommerce-Price-amount amount" style="display: block;">
                                                    @if (hasCustomDiscount($product->discount_start_date, $product->discount_end_date, $product->discount_value))
                                                        @if (is_null($product->discount_end_date))
                                                            <bdi style=" font-size: 25px">{{ formatAmount(calculateAmount($product->price, $product->discount_value, $product->discount_type !== 'amount')) }}
                                                                ₫
                                                            </bdi>

                                                            <del
                                                                style="font-size: 14px;color: black !important;font-weight: 500; margin: 0 10px">
                                                                {{ formatAmount($product->price) }}
                                                                ₫
                                                            </del>

                                                            <span
                                                                style="color: black; font-size: 14px; font-weight: 500">-{{ number_format(calculateDiscountPercentage($product->price, $product->discount_value, $product->discount_type), 0) }}%</span>
                                                        @else
                                                            <div class="flash-sale">
                                                                <!-- Giá và thông tin giảm giá -->
                                                                <div class="price-info">
                                                                    <div class="current-price">
                                                                        {{ formatAmount(calculateAmount($product->price, $product->discount_value, $product->discount_type !== 'amount')) }}
                                                                        đ</div>
                                                                    <div class="discount-info">
                                                                        <span
                                                                            class="discount">-{{ number_format(calculateDiscountPercentage($product->price, $product->discount_value, $product->discount_type), 0) }}%</span>
                                                                        <span class="original-price">
                                                                            {{ formatAmount($product->price) }} đ</span>
                                                                    </div>
                                                                </div>

                                                                <!-- Thời gian đếm ngược -->
                                                                <div class="countdown">
                                                                    <div class="countdown-label">Kết thúc sau</div>
                                                                    <div>
                                                                        <span class="time-box" id="hours">00 giờ</span>
                                                                        <span class="time-box" id="minutes">00 phút</span>
                                                                        <span class="time-box" id="seconds">00 giây</span>
                                                                    </div>
                                                                    <div class="stock">Còn <span
                                                                            style="color: white;">{{ $product->quantity }}</span>
                                                                        Chiếc</div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @else
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
                                                    @endif

                                                </span>
                                            </p>
                                        </div>
                                    @endif

                                    @if ($product->price)

                                        <form class="cart" action="" method="post" enctype="multipart/form-data">
                                            <div class="sticky-add-to-cart-wrapper">
                                                <div class="sticky-add-to-cartt">
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
                                                                name="quantity" value="1" title="Qty"
                                                                size="4" placeholder="" inputmode="numeric" />
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

                                                    <a href="#" id="buy_now"
                                                        class="single_add_to_cart_buttonn button alt btn-contact"
                                                        style="background: #ec1c24 !important; padding-left: 40px; padding-right: 40px; padding-bottom: 1px;"></span>Mua
                                                        ngay</a>
                                                </div>
                                            </div>

                                        </form>
                                    @endif

                                    <div class="hotline-box">
                                        <p class="meta-title">
                                            {{ $settings->introduct_title }}
                                        </p>
                                        <div class="hotline-content">
                                            <!-- Nhóm Hotline -->
                                            <div class="hotline-group">
                                                <div>
                                                    <i class="bi bi-telephone-fill"></i> Hotline:
                                                </div>
                                                <div>
                                                    @foreach ($settings->introduction['phone'] ?? [] as $key => $item)
                                                        <p class="hotline-item">
                                                            <span
                                                                class="hotline-region">{{ $settings->introduction['facility'][$key] ?? '' }}</span>
                                                            <a href="tel:{{ $item }}"
                                                                class="hotline-number">{{ $item }}</a>
                                                        </p>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <!-- Nhóm Địa chỉ -->
                                            <div class="address-group">
                                                <div>
                                                    <i class="bi bi-geo-alt-fill"></i> Địa chỉ:
                                                </div>
                                                <div>
                                                    @foreach ($settings->introduction['address'] ?? [] as $address)
                                                        <p class="address-item">
                                                            <span class="address-detail">{{ $address }}</span>
                                                        </p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    @if ($settings->support)
                                        <div class="Service-freeship">
                                            @foreach ($settings->support['icon'] ?? [] as $key => $icon)
                                                <p><i class="{{ $icon }}"></i>
                                                    {{ $settings->support['content'][$key] ?? '' }}</p>
                                            @endforeach
                                        </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                        <div class="product-footer">
                            <div class="woocommerce-tabs wc-tabs-wrapper container tabbed-content">
                                <ul class="tabs wc-tabs product-tabs small-nav-collapse nav nav-uppercase nav-tabs nav-normal nav-left"
                                    role="tablist">
                                    <li class="additional_information_tab active" id="tab-title-additional_information"
                                        role="presentation">
                                        <a href="#tab-additional_information" role="tab" aria-selected="false"
                                            aria-controls="tab-additional_information" tabindex="-1">
                                            Thông số kỹ thuật
                                        </a>
                                    </li>
                                    <li class="description_tab" id="tab-title-description" role="presentation">
                                        <a href="#tab-description" role="tab" aria-selected="true"
                                            aria-controls="tab-description">
                                            Mô tả chi tiết
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-panels">
                                    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--additional_information panel entry-content active"
                                        id="tab-additional_information" role="tabpanel"
                                        aria-labelledby="tab-title-additional_information">
                                        {!! $product->description_short !!}
                                    </div>
                                    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content "
                                        id="tab-description" role="tabpanel" aria-labelledby="tab-title-description">
                                        {!! $product->description !!}
                                    </div>


                                </div>

                                <div style="margin-top: 10px">

                                    @if ($product->tags)
                                        <div style="display: flex; align-items: center; font-size: .8rem">
                                            <p class="status" style="margin: 0"><strong>Tags: </strong></p>
                                            <p class="" style="margin: 0 0 0 10px">
                                                {{ formatString($product->tags) }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>



                            <div class="related related-products-wrapper product-section">
                                <h3
                                    class="product-section-title container-width product-section-title-related pt-half pb-half uppercase">
                                    Sản phẩm liên quan
                                </h3>

                                <div class="row has-equal-box-heights equalize-box large-columns-5 medium-columns-4 small-columns-2 row-small slider row-slider slider-nav-reveal slider-nav-push"
                                    data-flickity-options='{"imagesLoaded": true, "groupCells": "100%", "dragThreshold" : 5, "cellAlign": "left","wrapAround": true,"prevNextButtons": false,"percentPosition": true,"pageDots": false, "rightToLeft": false, "autoPlay" : true}'>


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

        document.querySelector('#buy_now')?.addEventListener('click', function(e) {
            e.preventDefault();

            let productId = "{{ $product->id }}";
            let quantity = document.querySelector('.input-text').value

            fetch("{{ route('carts.buy-now') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            "content") // Bảo vệ CSRF
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        qty: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "{{ route('carts.thanh-toan') }}"
                    } else {
                        if (data.message) {
                            alert(data.message)
                        } else {
                            window.location.href = "{{ route('auth.login') }}"
                        }
                    }
                })
                .catch(error => console.error("Error:", error));
        })

        document.addEventListener("DOMContentLoaded", () => {
            const swiper = new Swiper(".swiper-container", {
                slidesPerView: 4, // Hiển thị 4 ảnh
                spaceBetween: 10, // Khoảng cách giữa các ảnh
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
                        slidesPerView: 4,
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

    @if ($product->discount_end_date && \Carbon\Carbon::parse($product->discount_end_date)->gt(now()))
        <script>
            var endTime = new Date("{{ $product->discount_end_date }}").getTime();

            function updateCountdown() {
                var now = new Date().getTime();

                var timeLeft = endTime - now;

                if (timeLeft > 0) {
                    var hours = Math.floor(timeLeft / (1000 * 60 * 60));
                    var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    document.getElementById("hours").innerHTML = hours + " giờ";
                    document.getElementById("minutes").innerHTML = minutes + " phút";
                    document.getElementById("seconds").innerHTML = seconds + " giây";
                } else {
                    document.getElementById("hours").innerHTML = "00 giờ";
                    document.getElementById("minutes").innerHTML = "00 phút";
                    document.getElementById("seconds").innerHTML = "00 giây";
                }
            }

            updateCountdown(); // Gọi lần đầu để cập nhật ngay lập tức
            setInterval(updateCountdown, 1000); // Cập nhật mỗi giây
        </script>
    @endif

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

        document.addEventListener("DOMContentLoaded", function() {
            let productId = "{{ $product->id }}";

            window.addEventListener("beforeunload", function() {

                // Thay vì dùng URL trực tiếp, dùng route helper để tạo đúng URL
                fetch("{{ route('products.end-view') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}" // Thêm CSRF token nếu cần
                    },
                    body: JSON.stringify({
                        product_id: productId,
                    })
                }).then(response => {
                    if (!response.ok) {
                        console.error('Error sending end view data');
                    }
                }).catch(error => {
                    console.error('Fetch error: ', error);
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
        .edit-icon {
            font-size: 18px;
            color: gray;
            cursor: pointer;
            transition: color 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;

        }

        .edit-icon:hover {
            transform: scale(1.2);
            transition: all 0.3s ease-in-out;
        }

        .hotline-item {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            /* Khoảng cách giữa hai phần */
        }

        .lb-dataContainer {
            display: none !important;
        }

        .large-6.col {
            padding: 0 0px 30px;
        }

        .flash-sale {
            background-color: #d32f2f;
            color: white;
            padding: 10px;
            border-radius: 8px;
            width: 550px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
        }

        .price-info {
            display: flex;
            flex-direction: column;
        }

        .current-price {
            font-size: 24px;
            font-weight: bold;
        }

        .discount-info {
            font-size: 14px;
            margin-top: 5px;
        }

        .discount {
            background: white;
            color: #d32f2f;
            padding: 2px 4px;
            border-radius: 4px;
            font-weight: bold;
            margin-right: 5px;
        }

        .original-price {
            text-decoration: line-through;
            opacity: 0.8;
            margin-right: 5px;
        }

        .countdown {
            text-align: right;
        }

        .countdown-label {
            font-size: 12px;
        }

        .time-box {
            display: inline-block;
            background: white;
            color: #d32f2f;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
        }

        .stock {
            font-weight: bold;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            #tab-additional_information table {
                width: 100% !important;
            }

            .flash-sale {
                width: 100%;
            }
        }

        .product-details {
            display: flex;
            flex-direction: column;
            max-width: 400px;
            /* Điều chỉnh theo nhu cầu */
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .label {
            font-weight: bold;
            min-width: 120px;
            /* Đảm bảo các label có cùng chiều rộng */
            white-space: nowrap;
            /* Không xuống dòng */
        }

        .value {
            flex-grow: 1;
            text-align: left;
        }

        .Service-freeship {
            padding: 10px;
            margin-top: 20px;
            border: 1px solid #ddd;
        }

        .Service-freeship p {
            margin: 0;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }

        .Service-freeship p i {
            color: #ec1c24;
            margin-right: 10px;
            min-width: 20px;
            /* Đảm bảo icon có độ rộng cố định */
            text-align: center;
        }


        form.cart {
            margin-top: 15px;
            margin-bottom: 15px !important;
        }

        #main-image {
            width: 100%;
            max-width: 500px;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            /* Giữ hình ảnh luôn đầy đủ */
        }

        .hotline-box {
            border: 1px solid #ddd;
            padding: 10px;
            font-family: Arial, sans-serif;
            background-color: #fff;
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
            flex-direction: column;
            /* Chuyển về hiển thị dọc */
            gap: 10px;
        }

        .hotline-group,
        .address-group {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .hotline-group p,
        .address-group p {
            margin: 0;
            font-size: .8rem;
            color: #333;
            line-height: 2;
        }

        .hotline-number {
            color: red;
            font-weight: bold;
            margin-right: 10px;
            white-space: nowrap;
            /* Không xuống dòng */
        }

        .hotline-region {
            color: #333;
            flex: 1;
            white-space: nowrap;
        }

        .address-item {
            margin-left: 25px;
            /* Canh lề đồng bộ với hotline */
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
