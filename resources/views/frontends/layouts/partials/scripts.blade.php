<script src="{{ asset('frontends/assets/js/chunk.countup.js') }}"></script>
<script src="{{ asset('frontends/assets/js/chunk.sticky-sidebar.js') }}"></script>
<script src="{{ asset('frontends/assets/js/chunk.tooltips.js') }}"></script>
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
<script src="{{ asset('frontends/assets/js/custom.js') }}"></script>

<script>
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
    });

    const cartResponse = (carts) => {
        let _html = ''; // Biến để lưu HTML

        // Duyệt qua tất cả các sản phẩm trong giỏ hàng
        jQuery.each(carts, function(index, cart) {
            _html += `
            <li class="woocommerce-mini-cart-item mini_cart_item">
                <a href="https://dienmaysgo.com/gio-hang/?remove_item=${cart.rowId}" class="remove remove_from_cart_button">×</a>
                <a href="https://dienmaysgo.com/may-phat-dien-chay-xang-elemax-sv2800/">
                    <img
                        width="300"
                        height="300"
                        src="https://dienmaysgo.com/wp-content/uploads/2023/01/may-phat-dien-elemax-sv2800-1-300x300.jpg"
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
                        <bdi>${cart.price}₫</bdi>
                    </span>
                </span>
            </li>
        `;
        });

        // Gắn HTML vào danh sách sản phẩm trong giỏ hàng
        jQuery('.cart_list.product_list_widget').html(_html);
    };

    $(document).on('click', '.remove_from_cart_button', function(e) {
        e.preventDefault();

        // Lấy `rowId` từ thuộc tính của nút
        let rowId = $(this).data('row-id');
        let parentElement = $(this).closest('li');

        console.log(rowId);


        // Gọi API xóa sản phẩm

    });
</script>
@stack('scripts')
