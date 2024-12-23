<script src="{{ asset('frontends/assets/js/chunk.countup.js') }}"></script>
<script src="{{ asset('frontends/assets/js/chunk.sticky-sidebar.js') }}"></script>
<script src="{{ asset('frontends/assets/js/chunk.tooltips.js') }}"></script>
<script src="{{ asset('frontends/assets/js/chunk.vendors-popups.js') }}"></script>
<script src="{{ asset('frontends/assets/js/chunk.vendors-slider.js') }}"></script>
<script src="{{ asset('frontends/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/jquery.blockUI.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/add-to-cart.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/js.cookie.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/woocommerce.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/hooks.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/i18n.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/contact-form-7.js') }}"></script>
<script src="{{ asset('frontends/assets/js/wp-polyfill.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/hoverIntent.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/flatsome.js') }}"></script>
<script src="{{ asset('frontends/assets/js/flatsome-instant-page.js') }}"></script>
<script src="{{ asset('frontends/assets/js/sourcebuster.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/order-attribution.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/flatsome-lazy-load.js') }}"></script>
<script src="{{ asset('frontends/assets/js/woocommerce.js') }}"></script>
<script src="{{ asset('frontends/assets/js/jquery.selectBox.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/jquery.prettyPhoto.min.js') }}"></script>
<script src="{{ asset('frontends/assets/js/jquery.yith-wcwl.min.js') }}"></script>
{{-- <script src="{{ asset('frontends/assets/js/custom.js') }}"></script> --}}
<script src="{{ asset('frontends/assets/js/toastr.min.js') }}"></script>


<script>
    const BASE_URL = "{{ url('/') }}";

    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
    });

    if (typeof formatCurrency === 'undefined') {
        function formatCurrency(amount) {
            const formattedAmount = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            return formattedAmount + " ₫";
        }
    }

    function formatAmount(amount) {
        // Chuyển đổi giá trị thành chuỗi và thêm dấu phân cách hàng nghìn bằng dấu chấm
        let formattedAmount = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        return formattedAmount;
    }


    const cartResponse = (data) => {
        let _html = ''; // Biến để lưu HTML

        // Duyệt qua tất cả các sản phẩm trong giỏ hàng
        let total = 0;
        jQuery.each(data.carts, function(index, cart) {
            _html += `
            <li class="woocommerce-mini-cart-item mini_cart_item">
                <a class="remove remove_from_cart_button" data-row-id="${cart.rowId}" data-product_id="${cart.id}">×</a>
                <a href="${BASE_URL + '/san-pham/' + cart.options['slug']}">
                    <img
                        width="300"
                        height="300"
                        src="${BASE_URL + '/storage/' + cart.options.image}"
                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                        alt="${cart.name}"
                        decoding="async"
                        fetchpriority="high"
                        sizes="(max-width: 300px) 100vw, 300px"
                    />
                    ${cart.name}
                </a>
                <span class="quantity">
                    ${cart.qty} ×
                    <span class="woocommerce-Price-amount amount">
                        <bdi>${formatAmount(cart.price)}₫</bdi>
                    </span>
                    <p class="sum_total" style="display: none">${formatAmount(cart.subtotal)}</p>
                </span>
            </li>
        `;
            total += cart.price * cart.qty;
        });




        var count = data.count;



        jQuery('.icon-shopping-bag').attr('data-icon-label', count);

        jQuery('.woocommerce-mini-cart.cart_list.product_list_widget').html(_html);

        jQuery('.woocommerce-mini-cart__total .woocommerce-Price-amount.amount bdi').html(formatCurrency(total));

        jQuery('.woocommerce-mini-cart__buttons.buttons .checkout').css('display', 'block')

        if (data.count == 0) {
            jQuery('.woocommerce-mini-cart__buttons.buttons .checkout').css('display', 'none');
        }
    };


    const cartItem = function(data) {
        let _html = '';

        jQuery.each(data.carts, function(index, cart) {
            _html += `
                <tr
                    class="woocommerce-cart-form__cart-item cart_item"
                    data-row-id="${cart.rowId}">
                    <td class="product-remove">
                        <a
                            class="remove btn-remove-product"
                            aria-label="Remove this item"
                            data-product_id="${ cart.id }" data-row-id="${cart.rowId}"
                            >&times;</a
                        >
                    </td>

                    <td class="product-thumbnail">
                        <a href="${BASE_URL + '/san-pham/' + cart.options['slug']}"
                            ><img
                                fetchpriority="high"
                                decoding="async"
                                width="300"
                                height="300"
                                src="${BASE_URL + '/storage/' + cart.options.image}"
                                data-src="${BASE_URL + '/storage/' + cart.options.image}"
                                class="lazy-load attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                alt=""
                                srcset=""
                                data-srcset="${BASE_URL + '/storage/' + cart.options.image}"
                                sizes="(max-width: 300px) 100vw, 300px"
                        /></a>
                    </td>

                    <td class="product-name" data-title="Sản phẩm">
                        <a href="${BASE_URL + '/san-pham/' + cart.options['slug']}"
                            >${ cart.name }
                        </a>

                        <div class="show-for-small mobile-product-price">
                            <span class="mobile-product-price__qty">${cart.qty} x </span>
                            <span class="woocommerce-Price-amount amount"
                                ><bdi
                                    >${formatAmount(cart.price)}<span class="woocommerce-Price-currencySymbol"
                                        >&#8363;</span
                                    ></bdi
                                ></span
                            >
                        </div>

                    </td>

                    <td class="product-price" data-title="Price">
                        <span class="woocommerce-Price-amount amount"
                            ><bdi
                                >${formatAmount(cart.price)}
                                <span class="woocommerce-Price-currencySymbol"
                                    >&#8363;</span
                                ></bdi
                            ></span
                        >
                    </td>

                    <td class="product-quantity" data-title="Quantity">
                        <div
                            data-rowId="${ cart.rowId }"
                            class="quantity buttons_added form-flat"
                        >

                            <input type="button" value="-" class="minus button is-form" />

                            <input
                                type="number"
                                data-id="${ cart.id }" type="number"
                                class="input-text qty text quantity_product"
                                step="1"
                                min="1"
                                max=""
                                value="${ cart.qty }"
                                title="Qty"
                                size="4"
                                placeholder=""
                                inputmode="numeric"
                            />
                            <input type="button" value="+" class="plus button is-form" />
                        </div>
                    </td>

                    <td class="product-subtotal" data-title="Subtotal">
                        <span
                            class="woocommerce-Price-amount amount quantity-price-${ cart.price * cart.qty } quantity-price-sum"
                            >${formatAmount(cart.price * cart.qty)} ₫</span
                        >
                    </td>
                </tr>

            `;
        })

        jQuery('.woocommerce-cart-form__contents tbody').html(_html);


        jQuery('span.woocommerce-Price-amount.price-product-total').html(data.total + ' ₫');

        if (data.count <= 0) {
            jQuery('.checkout-button').on('click', function(e) {
                e.preventDefault(); // Ngừng sự kiện click
                // Có thể thêm thông báo lỗi hoặc cảnh báo nếu cần
            });
        }


    }


    const addToCart = () => {
        jQuery(document).ready(function() {
            jQuery(document).on('click', '.add-to-cart', function() {
                const productId = jQuery(this).data('id');


                jQuery.ajax({
                    url: "{{ route('carts.add-to-cart') }}",
                    type: 'POST',
                    data: {
                        productId,
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            cartResponse(response)
                            // jQuery('#cart-links').css('display', 'inline-block')
                            // jQuery('.woocommerce-Price-amount.amount bdi').html(response.total)
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Có lỗi xảy ra! Vui lòng thử lại.');
                    }
                });

            });
        });
    }


    jQuery(document).ready(function() {
        // Lắng nghe sự kiện click vào nút xóa sản phẩm trong giỏ hàng
        jQuery(document).on('click', '.remove_from_cart_button', function(event) {
            event.preventDefault(); // Ngừng hành động mặc định của thẻ <a>
            const rowId = jQuery(this).data('row-id');

            const row = jQuery(this).closest('li');

            jQuery(this).addClass("loading");

            var url = "{{ route('carts.del-to-cart', ':id') }}".replace(':id', rowId);

            jQuery.ajax({
                url: url,
                type: 'POST',
                data: {
                    rowId
                },
                success: function(response) {


                    if (response.status) {
                        toastr.success(response.message);

                        row.remove();

                        cartResponse(response);
                        cartItem(response);

                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('Có lỗi xảy ra! Vui lòng thử lại.');
                },
                complete: function() {

                    jQuery(this).removeClass("loading");
                }
            });
        });


    });
</script>

@stack('scripts')
