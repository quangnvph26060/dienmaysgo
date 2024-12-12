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
                                    <a class="remove remove_from_cart_button" data-row-id="{{ $cart->rowId }}"
                                        data-product_id="{{ $cart->id }}">×</a>
                                    <a href="{{ route('products.detail', $cart->options->slug) }}">
                                        <img width="300" height="300" src="{{ showImage($cart->options->image) }}"
                                            data-src="{{ showImage($cart->options->image) }}"
                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail lazy-load-active"
                                            alt="" decoding="async" fetchpriority="high"
                                            sizes="(max-width: 300px) 100vw, 300px" />{{ $cart->name }}
                                    </a>
                                    <span class="quantity">{{ $cart->qty }} ×
                                        <span class="woocommerce-Price-amount amount"><bdi>{{ formatAmount($cart->price) }}<span
                                                    class="woocommerce-Price-currencySymbol">₫</span></bdi></span></span>
                                    <p class="sum_total" style="display: none">{{ formatAmount($cart->subtotal) }}</p>
                                </li>
                            @endforeach
                        </ul>

                        <p class="woocommerce-mini-cart__total total">
                            <strong>Tổng cộng:</strong>
                            <span class="woocommerce-Price-amount amount"><bdi><span
                                        class="total_cart">{{ number_format((float) str_replace([',', '.'], ['', '.'], Cart::instance('shopping')->subTotal()), 0, ',', '.') }}
                                    </span><span class="woocommerce-Price-currencySymbol">₫</span></bdi></span>
                        </p>


                        <p class="woocommerce-mini-cart__buttons buttons" id="cart-links">
                            <a href="{{ route('carts.list') }}" class="button wc-forward">Xem giỏ hàng</a>

                            <a href="https://dienmaysgo.com/thanh-toan/"
                                class="button checkout wc-forward
                                @if (Cart::instance('shopping')->count() <= 0) d-none @endif">
                                Thanh toán
                            </a>

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

<style>
    .remove.loading {
        position: relative;
        pointer-events: none;
        /* Ngăn người dùng nhấn thêm lần nữa */
    }

    .remove.loading::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 20px;
        height: 20px;
        border: 2px solid rgba(0, 0, 0, 0.2);
        border-top: 2px solid #000;
        /* Màu của vòng xoay */
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }

    @keyframes spin {
        from {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        to {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }
</style>

<script>
    function updateTotalPrice() {
        let prices = [];

        // Lấy giá trị từ các phần tử có class 'quantity-price-sum'
        document.querySelectorAll(".sum_total").forEach(element => {
            prices.push(element.textContent.trim());
        });

        // Chuyển đổi các giá trị này thành số và tính tổng
        let numericValues = prices.map(value => {
            return parseInt(value.replace(/[^\d]/g, ''));
        });

        let total = numericValues.reduce((sum, current) => sum + current, 0);

        // Cập nhật giá trị tổng vào các phần tử có class 'price-product-total'
        document.querySelectorAll('.total_cart').forEach(element => {
            element.innerHTML = `${formatCurrency(total)}`;
        });
    }

    // document.querySelectorAll(".remove").forEach(button => {
    //     button.addEventListener("click", function(event) {
    //         event.preventDefault(); // Ngừng hành động mặc định của thẻ <a>

    //         let productId = this.getAttribute("data-product_id");
    //         let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    //         let row = event.target.closest('li');
    //         this.classList.add("loading");

    //         var url = "{{ route('carts.del-to-cart', ['id' => ':id']) }}".replace(':id', productId);
    //         fetch(url, {
    //                 method: 'POST',
    //                 headers: {
    //                     'Content-Type': 'application/json',
    //                     'X-CSRF-TOKEN': csrfToken
    //                 },
    //             })
    //             .then(response => {
    //                 if (!response.ok) {
    //                     throw new Error('Đã xảy ra lỗi khi gửi yêu cầu.');
    //                 }
    //                 return response.json();
    //             })
    //             .then(data => {
    //                 if (data.status === 'success') {
    //                     row.remove();
    //                     updateTotalPrice();
    //                 }
    //             })
    //             .catch(error => {
    //                 console.error(error);
    //             })
    //             .finally(() => {
    //                 // Xóa lớp xoay sau khi xử lý xong
    //                 this.classList.remove("loading");
    //             });
    //     });
    // });

    function formatCurrency(amount) {
        const formattedAmount = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        return formattedAmount;
    }
</script>
