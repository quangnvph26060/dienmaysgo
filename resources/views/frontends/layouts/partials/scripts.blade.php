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
<script src="{{ asset('frontends/assets/js/toastr.min.js') }}"></script>


<script>
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
    });

    function formatAmount(amount) {
    // Chuyển đổi giá trị thành chuỗi và thêm dấu phân cách hàng nghìn bằng dấu chấm
        let formattedAmount = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        return formattedAmount;
    }


    const cartResponse = (carts) => {
        let _html = ''; // Biến để lưu HTML

        // Duyệt qua tất cả các sản phẩm trong giỏ hàng
        let total = 0;
        jQuery.each(carts, function(index, cart) {
            _html += `
            <li class="woocommerce-mini-cart-item mini_cart_item">
                <a class="remove remove_from_cart_button" data-row-id="${cart.id}" data-product_id="${cart.id}">×</a>
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
                        <bdi>${formatAmount(cart.price)}₫</bdi>
                    </span>
                    <p class="sum_total" style="display: none">${formatAmount(cart.subtotal)}</p>
                </span>
            </li>
        `;
        total += cart.price * cart.qty; // Tính t��ng tiền
        });

        // Gắn HTML vào danh sách sản phẩm trong giỏ hàng
        jQuery('.cart_list.product_list_widget').html(_html);
        jQuery('.total_cart').html(formatCurrency(total));
    };

    const addToCart = () => {
        jQuery(document).ready(function() {
            jQuery(document).on('click', '.add-to-cart', function() {
                const id = jQuery(this).data('id');


                jQuery.ajax({
                    url: "{{ route('carts.add-to-cart') }}",
                    type: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        if (response.status) {

                            toastr.success(response.message);
                            jQuery('.cart-count').html(response.count)
                            cartResponse(response.carts)

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
            const productId = jQuery(this).data('product_id');
            const csrfToken = jQuery('meta[name="csrf-token"]').attr('content'); // Lấy CSRF token

            // Tìm phần tử <li> chứa sản phẩm cần xóa
            const row = jQuery(this).closest('li');
            console.log(row); // Kiểm tra phần tử chứa sản phẩm

            // Thêm lớp "loading" cho nút xóa để hiển thị trạng thái xử lý
            jQuery(this).addClass("loading");

            // Xây dựng URL cho yêu cầu AJAX
            var url = "{{ route('carts.del-to-cart', ['id' => ':id']) }}".replace(':id', productId);

            // Gửi yêu cầu AJAX xóa sản phẩm khỏi giỏ hàng
            jQuery.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: csrfToken, // CSRF token
                    id: productId, // ID sản phẩm
                },
                success: function(response) {
                    // Nếu xóa thành công
                    if (response.status) {
                        toastr.success(response.message); // Hiển thị thông báo thành công

                        // Xóa sản phẩm khỏi giỏ hàng
                        row.remove();

                        // Cập nhật lại giá trị tổng giỏ hàng
                        updateTotalPrice(); // Truyền giá trị tổng mới từ server
                    } else {
                        toastr.error(response.message); // Hiển thị thông báo lỗi nếu có
                    }
                },
                error: function(xhr) {
                    // Nếu có lỗi trong quá trình gửi yêu cầu
                    toastr.error('Có lỗi xảy ra! Vui lòng thử lại.');
                },
                complete: function() {
                    // Xóa lớp "loading" sau khi xử lý xong
                    jQuery(this).removeClass("loading");
                }
            });
        });

        // Cập nhật giá trị tổng giỏ hàng
        function updateTotalPrice() {
                let prices = [];

                // Lấy giá trị từ các phần tử có class 'quantity-price-sum'
                document.querySelectorAll(".sum_total").forEach(element => {
                    prices.push(element.textContent.trim());
                });

                // Chuyển đổi các giá trị này thành số và tính tổng
                let numericValues = prices.map(value => {
                    return parseInt(value.split('.')[0].replace(/[^\d]/g, ''));
                });
                console.log(prices);
                let total = numericValues.reduce((sum, current) => sum + current, 0);
                console.log(total);
                // Cập nhật giá trị tổng vào các phần tử có class 'price-product-total'
                document.querySelectorAll('.total_cart').forEach(element => {
                    element.innerHTML = `${formatCurrency(total)}`;
                });
    }

        // Hàm định dạng tiền tệ
        function formatCurrency(amount) {
            const formattedAmount = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return formattedAmount; // Định dạng tiền Việt Nam
        }
    });

</script>

@stack('scripts')
