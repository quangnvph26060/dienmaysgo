@extends('frontends.layouts.master')
@section('title',$title)
@section('content')
    <div id="content" class="content-area page-wrapper cart_none" style="display: none;" role="main">
        <div class="row row-main">
            <div class="large-12 col">
                <div class="col-inner">
                    <div class="woocommerce">
                        <div class="woocommerce-notices-wrapper" id="lastDeletedProduct">

                                {{-- @php
                                    $lastDeletedProduct = $lastDeletedProduct;
                                @endphp
                                <div class="woocommerce-message message-wrapper" role="alert">
                                    <div class="message-container container success-color medium-text-center">
                                        <i class="icon-checkmark"></i>
                                        “{{ $lastDeletedProduct->name }}” đã bị xóa.
                                        <a href="{{ route('carts.restore', ['rowId' => $lastDeletedProduct->rowId]) }}" class="restore-item">
                                            Undo?
                                        </a>

                                    </div>
                                </div> --}}

                            <div class="woocommerce-info message-wrapper">
                                <div class="message-container container medium-text-center">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">
                                            Giỏ hàng của bạn hiện đang trống.
                                        </font>
                                    </font>
                                </div>
                            </div>
                        </div>
                        <div class="woocommerce">
                            <div class="text-center pt pb">
                                <div class="woocommerce-notices-wrapper"></div>
                                <div class="wc-empty-cart-message"></div>
                                <p class="return-to-shop">
                                    <a class="button primary wc-backward" href="{{ route('home') }}">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">
                                                Quay lại cửa hàng
                                            </font>
                                        </font>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="cart-footer-content after-cart-content relative">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="content" class="content-area page-wrapper cart_have" role="main">
        <div class="row row-main">
            <div class="large-12 col">
                <div class="col-inner">
                    <div class="woocommerce">
                        <div class="woocommerce-notices-wrapper"></div>
                        <div class="woocommerce row row-large row-divided">
                            <div class="col large-7 pb-0">
                                <form class="woocommerce-cart-form" action="https://dienmaysgo.com/gio-hang/"
                                    method="post">
                                    <div class="cart-wrapper sm-touch-scroll">
                                        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="product-name" colspan="3">
                                                        Sản phẩm
                                                    </th>
                                                    <th class="product-price">Giá</th>
                                                    <th class="product-quantity white-space-nowrap">Số lượng</th>
                                                    <th class="product-subtotal white-space-nowrap">Tổng cộng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($carts as $item)
                                                    <tr class="woocommerce-cart-form__cart-item cart_item"
                                                        data-row-id="{{ $item->id }}">
                                                        <td class="product-remove">
                                                            <a class="remove btn-remove-product"
                                                                aria-label="Remove this item"
                                                                data-product_id="{{ $item->id }}">&times;</a>
                                                        </td>

                                                        <td class="product-thumbnail">
                                                            <a
                                                                href="https://dienmaysgo.com/may-phat-dien-chay-xang-elemax-sh1900/"><img
                                                                    fetchpriority="high" decoding="async" width="300"
                                                                    height="300"
                                                                    src="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20300%20300%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E"
                                                                    data-src="https://dienmaysgo.com/wp-content/uploads/2023/01/may-phat-dien-chay-xang-1-6kva-elemax-sh1900-300x300.jpg"
                                                                    class="lazy-load attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                    alt="" srcset=""
                                                                    data-srcset="https://dienmaysgo.com/wp-content/uploads/2023/01/may-phat-dien-chay-xang-1-6kva-elemax-sh1900-300x300.jpg 300w, https://dienmaysgo.com/wp-content/uploads/2023/01/may-phat-dien-chay-xang-1-6kva-elemax-sh1900-100x100.jpg 100w, https://dienmaysgo.com/wp-content/uploads/2023/01/may-phat-dien-chay-xang-1-6kva-elemax-sh1900-600x600.jpg 600w, https://dienmaysgo.com/wp-content/uploads/2023/01/may-phat-dien-chay-xang-1-6kva-elemax-sh1900-150x150.jpg 150w, https://dienmaysgo.com/wp-content/uploads/2023/01/may-phat-dien-chay-xang-1-6kva-elemax-sh1900.jpg 680w"
                                                                    sizes="(max-width: 300px) 100vw, 300px" /></a>
                                                        </td>

                                                        <td class="product-name" data-title="Sản phẩm">
                                                            <a
                                                                href="https://dienmaysgo.com/may-phat-dien-chay-xang-elemax-sh1900/">{{ $item->name }}
                                                            </a>
                                                            {{-- <div class="show-for-small mobile-product-price">
                                                                <span class="mobile-product-price__qty">1 x
                                                                </span>
                                                                <span class="woocommerce-Price-amount amount"><bdi>11.800.000<span
                                                                            class="woocommerce-Price-currencySymbol">&#8363;</span></bdi></span>
                                                            </div> --}}
                                                        </td>

                                                        <td class="product-price" data-title="Price">
                                                            <span class="woocommerce-Price-amount amount"><bdi>{{ formatAmount($item->price) }}
                                                                    <span
                                                                        class="woocommerce-Price-currencySymbol">&#8363;</span></bdi></span>
                                                        </td>

                                                        <td class="product-quantity" data-title="Quantity">
                                                            <div class="quantity buttons_added form-flat">
                                                                <input type="button" value="-"
                                                                    class="minus button is-form" />
                                                                {{-- <label class="screen-reader-text"
                                                                    for="quantity_674fdef6c0aaa">Máy Phát Điện Chạy Xăng
                                                                    Elemax
                                                                    SH1900
                                                                    quantity</label> --}}
                                                                <input data-price="{{ $item->price }}"
                                                                    data-id="{{ $item->id }}" type="number"
                                                                    id=""
                                                                    class="input-text qty text quantity_product"
                                                                    step="1" min="0" max=""
                                                                    name="cart[b59c67bf196a4758191e42f76670ceba][qty]"
                                                                    value="{{ $item->qty }}" title="Qty"
                                                                    size="4" placeholder="" inputmode="numeric" />
                                                                <input type="button" value="+"
                                                                    class="plus button is-form" />
                                                            </div>
                                                        </td>

                                                        <td class="product-subtotal" data-title="Subtotal">
                                                            <span
                                                                class="woocommerce-Price-amount amount quantity-price-{{ $item->price }} quantity-price-sum">{{ formatAmount($item->price) }}
                                                                ₫</span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse

                                                <tr>
                                                    <td colspan="6" class="actions clear">
                                                        <div class="continue-shopping pull-left text-left">
                                                            <a class="button-continue-shopping button primary is-outline"
                                                                href="{{ route('home') }}">
                                                                &#8592;&nbsp;Tiếp tục mua sắm
                                                            </a>
                                                        </div>

                                                        {{-- <button type="submit" class="button primary mt-0 pull-left small"
                                                            name="update_cart" value="Update cart">
                                                            Cập nhật giỏ hàng
                                                        </button> --}}

                                                        <input type="hidden" id="woocommerce-cart-nonce"
                                                            name="woocommerce-cart-nonce" value="a80326973f" /><input
                                                            type="hidden" name="_wp_http_referer" value="/gio-hang/" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>

                            <div class="cart-collaterals large-5 col pb-0">
                                <div class="cart-sidebar col-inner">
                                    <div class="cart_totals calculated_shipping">
                                        <table cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="product-name" colspan="2">
                                                        Tổng số giỏ hàng
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>

                                        <h2>Cart totals</h2>

                                        <table cellspacing="0" class="shop_table shop_table_responsive">
                                            <tr class="cart-subtotal">
                                                <th>Tổng cộng</th>
                                                <td data-title="Subtotal">
                                                    <span
                                                        class="woocommerce-Price-amount amount price-product-total"></span>
                                                </td>
                                            </tr>

                                            <tr class="order-total">
                                                <th>Tổng cộng</th>
                                                <td data-title="Total">
                                                    <strong><span
                                                            class="woocommerce-Price-amount amount price-product-total"></span></strong>
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="wc-proceed-to-checkout">
                                            <a href="{{ route('carts.thanh-toan') }}"
                                                class="checkout-button button alt wc-forward">
                                                Tiến hành thanh toán</a>
                                        </div>
                                    </div>
                                    <div class="cart-sidebar-content relative"></div>
                                </div>
                            </div>
                        </div>

                        <div class="cart-footer-content after-cart-content relative"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
     const csrfToken = "{{ csrf_token() }}";


        function formatCurrency(amount) {
            const formattedAmount = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            return formattedAmount + " ₫";
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".quantity_product").forEach(element => {
                let price = element.getAttribute("data-price");
                let qty = element.value;
                let priceElement = document.querySelector(`.quantity-price-${price}`);
                let totalPrice = parseInt(price) * parseInt(qty);
                priceElement.innerHTML = `${formatCurrency(totalPrice)}`;
            });


            function updateTotalPrice() {
                let prices = [];

                // Lấy giá trị từ các phần tử có class 'quantity-price-sum'
                document.querySelectorAll(".quantity-price-sum").forEach(element => {
                    prices.push(element.textContent.trim());
                });

                // Chuyển đổi các giá trị này thành số và tính tổng
                let numericValues = prices.map(value => {
                    return parseInt(value.replace(/[^\d]/g, ''));
                });

                let total = numericValues.reduce((sum, current) => sum + current, 0);

                // Cập nhật giá trị tổng vào các phần tử có class 'price-product-total'
                document.querySelectorAll('.price-product-total').forEach(element => {
                    element.innerHTML = `${formatCurrency(total)}`;
                });
            }


            updateTotalPrice();

            function updateCartDisplay() {
                const cartNone = document.querySelector(".cart_none");
                const cartHave = document.querySelector(".cart_have");

                if (cartNone && cartHave) {
                    if (document.querySelectorAll(".quantity-price-sum").length === 0) {
                        cartNone.style.display = "block";
                        cartHave.style.display = "none";
                    } else {
                        cartNone.style.display = "none";
                        cartHave.style.display = "block";
                    }
                } else {
                    console.error("Phần tử cart_none hoặc cart_have không tồn tại trong DOM.");
                }
            }

            // Gọi hàm khi cần cập nhật trạng thái
            updateCartDisplay();





            document.querySelectorAll(".plus").forEach(button => {
                button.addEventListener("click", function() {
                    let input = this.previousElementSibling;
                    if (input && input.type === "number") {
                        let currentValue = parseInt(input.value) + 1 || 0;
                        let price = parseFloat(input.getAttribute("data-price")) || 0;
                        let totalPrice = currentValue * price;
                        let priceElement = document.querySelector(`.quantity-price-${price}`);
                        priceElement.innerHTML = `${formatCurrency(totalPrice)}`;
                        let csrfToken = document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content');
                        let productId = input.getAttribute("data-id");

                        var url =
                            "{{ route('carts.update-to-cart', ['id' => ':id', 'qty' => ':qty']) }}"
                            .replace(':id', productId).replace(':qty', currentValue);
                        updateProduct(url, currentValue, csrfToken);

                    }
                });
            });

            function updateProduct(url, qty, csrfToken) {
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Đã xảy ra lỗi khi gửi yêu cầu.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            updateTotalPrice();
                            updateCartDisplay();
                            toastr.success(data.message);
                            jQuery('.cart-count').html(data.count)
                        } else {
                            toastr.success(data.message);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
            document.querySelectorAll(".minus").forEach(button => {
                button.addEventListener("click", function() {
                    let input = this.nextElementSibling;
                    if (input && input.type === "number") {
                        let price = parseFloat(input.getAttribute("data-price")) || 0;
                        let currentValue = parseInt(input.value) - 1 || 0;
                        let priceElement = document.querySelector(`.quantity-price-${price}`);

                        if (currentValue === -1) {
                            return;
                            priceElement.innerHTML = `${formatCurrency(priceElement.textContent)}`;

                        } else {
                            let cleanPrice = priceElement.textContent.replace(/[^\d]/g, '');
                            let priceValue = parseInt(cleanPrice);
                            let resultPrice = priceValue - price;
                            priceElement.innerHTML = `${formatCurrency(resultPrice)}`;

                            let csrfToken = document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content');
                            let productId = input.getAttribute("data-id");

                            var url =
                                "{{ route('carts.update-to-cart', ['id' => ':id', 'qty' => ':qty']) }}"
                                .replace(':id', productId).replace(':qty', currentValue);
                            updateProduct(url, currentValue, csrfToken);
                        }


                    }
                });
            });
            document.querySelectorAll("input[type='number']").forEach(input => {
                input.addEventListener("change", function() {
                    let currentValue = parseInt(this.value) || 0;
                    let price = parseFloat(this.getAttribute("data-price")) || 0;
                    let id = this.getAttribute("data-id");
                    let totalPrice = currentValue * price;
                    let priceElement = document.querySelector(`.quantity-price-${price}`);
                    priceElement.innerHTML = `${formatCurrency(totalPrice)}`;
                    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content');
                    var url =
                        "{{ route('carts.update-to-cart', ['id' => ':id', 'qty' => ':qty']) }}"
                        .replace(':id', id).replace(':qty', currentValue);
                    updateProduct(url, currentValue, csrfToken);

                });
            });

            document.querySelectorAll(".remove").forEach(button => {
                button.addEventListener("click", function(event) {
                    event.preventDefault(); // Ngừng hành động mặc định của thẻ <a>

                    let productId = this.getAttribute("data-product_id");
                    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content');
                    let row = document.querySelector(`tr[data-row-id='${productId}']`);
                    var url = "{{ route('carts.del-to-cart', ['id' => ':id']) }}".replace(':id',
                        productId);


                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Đã xảy ra lỗi khi gửi yêu cầu.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.status === 'success') {
                                row.remove();
                                updateTotalPrice();
                                updateCartDisplay();
                                toastr.success(data.message);
                                jQuery('.cart-count').html(data.count)
                                if (data.lastDeletedProduct) {
                                    let lastDeletedProduct = document.querySelector('#lastDeletedProduct');
                                    console.log(data.lastDeletedProduct);
                                    const lastProduct = data.lastDeletedProduct;
                                    const restoreUrl = "{{ route('carts.restore') }}";
                                    lastDeletedProduct.innerHTML = `
                                    <div class="woocommerce-message message-wrapper" role="alert">
                                        <div class="message-container container success-color medium-text-center" style="display:flex">
                                            <i class="icon-checkmark"></i>
                                            “${lastProduct.name}” đã bị xóa.
                                            <form action="${restoreUrl}" method="POST" class="restore-form">
                                                <input type="hidden" name="_token" value="${csrfToken}">
                                                <input type="hidden" name="rowId" value="${lastProduct.rowId}">
                                                <button type="submit" >
                                                    Undo?
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                        <div class="woocommerce-info message-wrapper">
                                            <div class="message-container container medium-text-center">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">
                                                        Giỏ hàng của bạn hiện đang trống.
                                                    </font>
                                                </font>
                                            </div>
                                        </div>
                                        `;
                                }

                            }
                        })
                        .catch(error => {
                            console.error(error);
                        });
                });
            });
        });
    </script>
@endpush
<style scoped>
    .white-space-nowrap {
        white-space: nowrap;
    }
</style>
