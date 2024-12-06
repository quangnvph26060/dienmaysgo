<div class="mfp-bg off-canvas undefined off-canvas-right mfp-ready" style="display: none"></div>

<div class="mfp-wrap off-canvas off-canvas-right" tabindex="-1" style="display: none" id="cart-popup">
    <div class="mfp-container mfp-s-ready mfp-inline-holder">
        <div class="mfp-content off-canvas-cart">
            <div id="cart-popup" class="widget_shopping_cart">
                <div class="cart-popup-inner inner-padding">
                    <div class="cart-popup-title text-center">
                        <h4 class="uppercase">Cart</h4>
                        <div class="is-divider"></div>
                    </div>

                    <div class="widget_shopping_cart_content">
                        <ul class="woocommerce-mini-cart cart_list product_list_widget">

                            @foreach (Cart::instance('shopping')->content() as $cart)
                                <li class="woocommerce-mini-cart-item mini_cart_item">
                                    <a href="https://dienmaysgo.com/gio-hang/?remove_item=9c3b1830513cc3b8fc4b76635d32e692&amp;_wpnonce=a80326973f"
                                        class="remove remove_from_cart_button" data-row-id="{{ $cart->rowId }}">×</a>
                                    <a href="https://dienmaysgo.com/may-phat-dien-chay-xang-elemax-sv2800/">
                                        <img width="300" height="300"
                                            src="https://dienmaysgo.com/wp-content/uploads/2023/01/may-phat-dien-elemax-sv2800-1-300x300.jpg"
                                            data-src="https://dienmaysgo.com/wp-content/uploads/2023/01/may-phat-dien-elemax-sv2800-1-300x300.jpg"
                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail lazy-load-active"
                                            alt="" decoding="async" fetchpriority="high"
                                            sizes="(max-width: 300px) 100vw, 300px" />{{$cart->name}}
                                    </a>
                                    <span class="quantity">{{$cart->qty}} ×
                                        <span class="woocommerce-Price-amount amount"><bdi>{{ formatAmount($cart->price)}}<span
                                                    class="woocommerce-Price-currencySymbol">₫</span></bdi></span></span>
                                </li>
                            @endforeach
                        </ul>

                        <p class="woocommerce-mini-cart__total total">
                            <strong>Subtotal:</strong>
                            <span class="woocommerce-Price-amount amount"><bdi><span class="total">{{ Cart::instance('shopping')->subTotal() }}</span><span
                                        class="woocommerce-Price-currencySymbol">₫</span></bdi></span>
                        </p>

                        <p class="woocommerce-mini-cart__buttons buttons">
                            <a href="https://dienmaysgo.com/gio-hang/" class="button wc-forward">View cart</a><a
                                href="https://dienmaysgo.com/thanh-toan/"
                                class="button checkout wc-forward">Checkout</a>
                        </p>
                    </div>
                    <div class="cart-sidebar-content relative"></div>
                </div>
            </div>
        </div>
        <div class="mfp-preloader">Loading...</div>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>
