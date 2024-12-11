@extends('frontends.layouts.master')


@section('content')

<main id="main" class="">
    <div class="shop-container">
        <div class="container">
            <div class="woocommerce-notices-wrapper"></div>
        </div>
        <div id="product-1113"
            class="product type-product post-1113 status-publish first instock product_cat-may-phat-dien-elemax has-post-thumbnail shipping-taxable purchasable product-type-simple">
            <div class="row content-row row-divided row-large row-reverse">
                <div id="product-sidebar" class="col large-3 hide-for-medium shop-sidebar"></div>

                <div class="col large-9">
                    <div class="product-main">
                        <div class="row">
                            <div class="large-5 col">
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
                                            <a href="{{ asset('storage/'.$product->image) }}"
                                                data-lightbox="product-gallery"
                                                data-title="Máy phát điện Elemax SV2800">
                                                <img id="main-image" width="458" height="458"
                                                    src="{{ asset('storage/'.$product->image) }}" alt=""
                                                    title="{{ $product->slug}}" decoding="async" fetchpriority="high"
                                                    sizes="(max-width: 458px) 100vw, 458px" />
                                            </a>
                                        </div>
                                    </figure>

                                    <!-- Gallery images -->
                                    <div class="product-gallery-thumbnails swiper-container">
                                        <div class="swiper-wrapper">
                                            @if($product->images->isNotEmpty())
                                                @foreach($product->images as $index => $image)
                                                <div class="swiper-slide">
                                                    <img class="gallery-thumb"
                                                        src="{{ asset('storage/' . $image->image) }}"
                                                        data-large-src="{{ asset('storage/' . $image->image) }}"
                                                        alt="Thumbnail {{ $index + 1 }}" />
                                                </div>
                                                @endforeach
                                            @else

                                            @endif
                                            <!-- Add more thumbnails as needed -->
                                        </div>
                                        <!-- Navigation buttons -->
                                    </div>
                                </div>
                            </div>

                            <div class="product-info summary entry-summary col col-fit product-summary form-flat">
                                <h1 class="product-title product_title entry-title">
                                    {{ $product->name }}
                                </h1>

                                <div class="price-wrapper">
                                    <p class="price product-page-price">
                                        <span class="woocommerce-Price-amount amount"
                                            style="display: block; margin: 20px 0;">
                                            @if ($product->price)
                                            @if (hasDiscount($product->promotion))
                                            <bdi>{{ formatAmount(calculateAmount($product->price,
                                                $product->promotion->discount)) }}
                                                <span class="woocommerce-Price-currencySymbol">&#8363;</span>
                                            </bdi>
                                            <del style="font-size: 14px;color: black !important;font-weight: 500;">
                                                {{ formatAmount($product->price) }}
                                                <span class="woocommerce-Price-currencySymbol">&#8363;</span>
                                            </del>
                                            @else
                                            <bdi>{{ formatAmount($product->price) }}
                                                <span class="woocommerce-Price-currencySymbol">&#8363;</span>
                                            </bdi>
                                            @endif
                                            @else
                                            <a href="" class="contact">Liên hệ <span class="bi bi-telephone"
                                                    style="margin-left: 3px"></span></a>
                                            @endif
                                        </span>
                                    </p>
                                </div>
                                <div class="product-short-description">
                                    {!! $product->description_short !!}
                                </div>
                                <section class="section" id="section_1960688269">
                                    <div class="bg section-bg fill bg-fill bg-loaded"></div>

                                    <div class="section-content relative">
                                        <div class="row" id="row-2038915585">
                                            <div id="col-454331129" class="col small-12 large-12">
                                                <div class="col-inner">
                                                    <p>
                                                        <em><strong>Lưu ý:</strong> Giá bán sản phẩm
                                                            mang tính chất tham khảo, vui lòng liên hệ
                                                            trực tiếp để được có giá tốt nhất với số
                                                            lượng hàng trong kho. Xin cảm ơn!</em>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </section>


                                @if ($product->price)
                                <p class="stock in-stock">Còn hàng</p>
                                <form class="cart" action="" method="post" enctype="multipart/form-data">
                                    <div class="sticky-add-to-cart-wrapper">
                                        <div class="sticky-add-to-cart">
                                            <div class="sticky-add-to-cart__product">
                                                <img src="{{ showImage($product->image) }}" alt=""
                                                    class="sticky-add-to-cart-img" />
                                                <div class="product-title-small hide-for-small">
                                                    <strong>{{ $product->name }}</strong>
                                                </div>
                                                <div class="price-wrapper">
                                                    <p class="price product-page-price">
                                                        <span class="woocommerce-Price-amount amount"><bdi>{{
                                                                number_format($product->price, 0, ',', '.') }}<span
                                                                    class="woocommerce-Price-currencySymbol">&#8363;</span></bdi></span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="quantity buttons_added form-flat">
                                                <input type="button" value="-" class="minus button is-form" />
                                                <label class="screen-reader-text" for="quantity_674f195d66f6f">
                                                    {{ $product->name }}</label>
                                                <input type="number" id="quantity_674f195d66f6f"
                                                    class="input-text qty text" step="1" min="1" max="" name="quantity"
                                                    value="1" title="Qty" size="4" placeholder="" inputmode="numeric" />
                                                <input type="button" value="+" class="plus button is-form" />
                                            </div>

                                            <button type="submit" name="add-to-cart" value="1113"
                                                class="single_add_to_cart_button button alt">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @endif


                                <div class="product_meta">
                                    <span class="posted_in">Danh mục:
                                        <a href="{{ route('products.list', $product->category->slug) }}" rel="tag">{{
                                            $product->category->name }}</a></span>
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
                                        Thông tin chi tiết
                                    </a>
                                </li>
                                <li class="additional_information_tab" id="tab-title-additional_information"
                                    role="presentation">
                                    <a href="#tab-additional_information" role="tab" aria-selected="false"
                                        aria-controls="tab-additional_information" tabindex="-1">
                                        Thông tin bổ sung
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
                                    <table class="woocommerce-product-attributes shop_attributes"
                                        aria-label="Product Details">
                                        <tr
                                            class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_xuat-xu">
                                            <th class="woocommerce-product-attributes-item__label" scope="row">
                                                Xuất xứ
                                            </th>
                                            <td class="woocommerce-product-attributes-item__value">
                                                <p>
                                                    <a href="https://dienmaysgo.com/xuat-xu/nhat-ban/" rel="tag">Nhật
                                                        Bản</a>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                {{-- <div
                                    class="woocommerce-Tabs-panel woocommerce-Tabs-panel--reviews panel entry-content"
                                    id="tab-reviews" role="tabpanel" aria-labelledby="tab-title-reviews">
                                    <div id="reviews" class="woocommerce-Reviews row">
                                        <div id="comments" class="col large-12">
                                            <h3 class="woocommerce-Reviews-title normal">
                                                Đánh giá
                                            </h3>

                                        </div>

                                        <div id="review_form_wrapper" class="large-12 col">
                                            <div id="review_form" class="col-inner">
                                                <div class="review-form-inner has-border">
                                                    <div id="respond" class="comment-respond">
                                                        <h3 id="reply-title" class="comment-reply-title">
                                                            Sản phẩm &ldquo;{{ $product->name }}&rdquo;
                                                            <small><a rel="nofollow" id="cancel-comment-reply-link"
                                                                    href="/may-phat-dien-chay-xang-elemax-sv2800/#respond"
                                                                    style="display: none">Hủy</a></small>
                                                        </h3>
                                                        <form action="https://dienmaysgo.com/wp-comments-post.php"
                                                            method="post" id="commentform" class="comment-form"
                                                            novalidate>
                                                            <div class="comment-form-rating">
                                                                <label for="rating">Đánh giá của bạn&nbsp;<span
                                                                        class="required">*</span></label>
                                                                <div id="star-rating"></div>
                                                                <input type="hidden" id="rating-value" name="rating" />
                                                            </div>
                                                            <p class="comment-form-comment">
                                                                <label for="comment">Bình luận của bạn&nbsp;<span
                                                                        class="required">*</span></label>
                                                                <textarea id="comment" name="comment" cols="45" rows="8"
                                                                    required></textarea>
                                                            </p>
                                                            <p class="comment-form-author">
                                                                <label for="author">Tên&nbsp;<span
                                                                        class="required">*</span></label><input
                                                                    id="author" name="author" type="text" value=""
                                                                    size="30" required />
                                                            </p>
                                                            <p class="comment-form-email">
                                                                <label for="email">Email&nbsp;<span
                                                                        class="required">*</span></label><input
                                                                    id="email" name="email" type="email" value=""
                                                                    size="30" required />
                                                            </p>

                                                            <p class="form-submit">
                                                                <input name="submit" type="submit" id="submit"
                                                                    class="submit" value="Submit" />
                                                                <input type="hidden" name="comment_post_ID" value="1113"
                                                                    id="comment_post_ID" />
                                                                <input type="hidden" name="comment_parent"
                                                                    id="comment_parent" value="0" />
                                                            </p>
                                                            <p style="display: none">
                                                                <input type="hidden" id="akismet_comment_nonce"
                                                                    name="akismet_comment_nonce" value="e93fbc0b00" />
                                                            </p>
                                                            <p style="display: none !important"
                                                                class="akismet-fields-container" data-prefix="ak_">
                                                                <label>&#916;
                                                                    <textarea name="ak_hp_textarea" cols="45" rows="8"
                                                                        maxlength="100"></textarea>
                                                                </label><input type="hidden" id="ak_js_1" name="ak_js"
                                                                    value="115" />
                                                                <script>
                                                                    document
                                                                            .getElementById("ak_js_1")
                                                                            .setAttribute(
                                                                                "value",
                                                                                new Date().getTime()
                                                                            );
                                                                </script>
                                                            </p>
                                                        </form>
                                                    </div>
                                                    <!-- #respond -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <div class="related related-products-wrapper product-section">
                            <h3
                                class="product-section-title container-width product-section-title-related pt-half pb-half uppercase">
                                Sản phẩm liên quan
                            </h3>

                            <div class="row has-equal-box-heights equalize-box large-columns-4 medium-columns-3 small-columns-2 row-small slider row-slider slider-nav-reveal slider-nav-push"
                                data-flickity-options='{"imagesLoaded": true, "groupCells": "100%", "dragThreshold" : 5, "cellAlign": "left","wrapAround": true,"prevNextButtons": true,"percentPosition": true,"pageDots": false, "rightToLeft": false, "autoPlay" : false}'>

                                @foreach ($relatedProducts as $item)
                                <x-product-item :product="$item" />
                                @endforeach
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
                slidesPerView: 4, // Hiển thị 4 ảnh
                spaceBetween: 10, // Khoảng cách giữa các ảnh
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                // breakpoints: {
                //   // Responsive settings
                //   640: {
                //     slidesPerView: 4,
                //     spaceBetween: 10,
                //   },
                //   768: {
                //     slidesPerView: 4,
                //     spaceBetween: 15,
                //   },
                //   1024: {
                //     slidesPerView: 5,
                //     spaceBetween: 20,
                //   },
                // },
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

        document
            .querySelector(".cart-link")
            .addEventListener("click", function(e) {
                e.preventDefault();
                const popup = document.querySelector(".mfp-content");

                // Hiển thị popup với animation

                setTimeout(() => {
                    popup.classList.add("open");
                    document.querySelector("#cart-popup").style.display = "block"; // Đảm bảo nó hiện trước
                    document.querySelector(".mfp-bg").style.display = "block";
                }, 300); // Thêm một chút thời gian để áp dụng hiệu ứng trượt
            });

        // Tùy chọn: Đóng popup
        document
            .querySelector(".mfp-container")
            .addEventListener("click", function() {
                const popup = document.querySelector(".mfp-content");
                popup.classList.remove("open");
                setTimeout(() => {
                    document.querySelector("#cart-popup").style.display =
                        "none"; // Ẩn sau khi hiệu ứng hoàn tất
                    document.querySelector(".mfp-bg").style.display = "none";
                }, 300);
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
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border 0.3s ease;
    }

    .gallery-thumb:hover {
        border: 2px solid #0071e3;
    }

    .product-gallery-thumbnails {
        width: 100%;
        max-width: 500px;
        margin: auto;
    }

    .swiper-slide {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        width: auto;
        /* Điều chỉnh tự động */
    }

    .gallery-thumb {
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border 0.3s ease;
    }

    .gallery-thumb:hover {
        border: 2px solid #0071e3;
    }

    .swiper-container {
        width: 100%;
        max-width: 600px;
        /* Giới hạn chiều rộng */
        margin: auto;
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
