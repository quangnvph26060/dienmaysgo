@if ($products->isNotEmpty())
    @foreach ($products as $product)
        <div class="col">
            <div class="col-inner">
                <div class="product-small box has-hover box-normal box-text-bottom">
                    <div class="box-image">
                        <div class="image-zoom image-cover" style="padding-top: 100%">
                            <a href="{{ route('products.detail', $product->slug) }}" aria-label="{{ $product->name }}">
                                <img fetchpriority="high" decoding="async" width="680" height="680"
                                    src="{{ showImage($product->image) }}" data-src="{{ showImage($product->image) }}"
                                    class="lazy-load attachment-original size-original" alt="{{ showImage($product->image) }}"
                                    sizes="(max-width: 680px) 100vw, 680px" />
                            </a>
                        </div>


                        @if ($product->price > 0)
                            <div class="image-tools is-small top right show-on-hover">
                                <div class="wishlist-icon">
                                    <button data-id="{{ $product->id }}"
                                        class="wishlist-button button is-outline circle icon add-to-cart"
                                        aria-label="Wishlist">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                    <div class="wishlist-popup dark">
                                        <div
                                            class="yith-wcwl-add-to-wishlist add-to-wishlist-2189 wishlist-fragment on-first-load">
                                            <!-- ADD TO WISHLIST -->

                                            <div class="yith-wcwl-add-button">
                                                <i class="yith-wcwl-icon fa fa-heart-o"></i>
                                                <span>Thêm giỏ hàng</span>
                                                </a>
                                            </div>

                                            <!-- COUNT TEXT -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div
                            class="image-tools grid-tools text-center hide-for-small bottom hover-slide-in show-on-hover">
                        </div>
                    </div>

                    <div class="box-text text-left">
                        <div class="title-wrapper">
                            <p class="name product-title woocommerce-loop-product__title">
                                <a href="{{ route('products.detail', $product->slug) }}"
                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link">{{ $product->name }}
                                </a>
                            </p>
                        </div>
                        <div class="price-wrapper">
                            <span class="price">
                                <span class="woocommerce-Price-amount amount">
                                    @if ($product->price > 0)
                                        @if (hasDiscount($product->promotion))
                                            <bdi>{{ formatAmount(calculateAmount($product->price, $product->promotion->discount)) }}
                                                <span class="woocommerce-Price-currencySymbol">&#8363;</span>
                                            </bdi>
                                            <del>
                                                <bdi class="original-price">{{ formatAmount($product->price) }}
                                                    <span class="woocommerce-Price-currencySymbol">&#8363;</span>
                                                </bdi>
                                            </del>
                                        @else
                                            <bdi>{{ formatAmount($product->price) }}
                                                <span class="woocommerce-Price-currencySymbol">&#8363;</span>
                                            </bdi>
                                        @endif
                                    @else
                                        <a href="{{ route('contact', ['product' => $product->slug]) }}"
                                            class="single_add_to_cart_button button alt"
                                            style="background: #ec1c24 !important; padding-left: 40px; padding-right: 40px; padding-bottom: 1px; margin-top: 0; width: 100%">Liên
                                            hệ <span class="bi bi-telephone" style="margin-left: 3px"></span></a>
                                    @endif
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif


