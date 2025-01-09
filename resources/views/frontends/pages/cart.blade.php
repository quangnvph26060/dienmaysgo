@extends('frontends.layouts.master')
@section('title', $title)
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
                                <form class="woocommerce-cart-form" action="" method="post">
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
                                                                data-row-id="{{ $item->rowId }}">&times;</a>
                                                        </td>

                                                        <td class="product-thumbnail">
                                                            <a
                                                                href="{{ route('products.detail', $item->options['slug']) }}"><img
                                                                    fetchpriority="high" decoding="async" width="300"
                                                                    height="300"
                                                                    src="{{ asset('storage/' . $item->options->image) }}"
                                                                    data-src="{{ asset('storage/' . $item->options->image) }}"
                                                                    class="lazy-load attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                    alt="" srcset=""
                                                                    data-srcset="{{ asset('storage/' . $item->options->image) }}"
                                                                    sizes="(max-width: 300px) 100vw, 300px" /></a>
                                                        </td>

                                                        <td class="product-name" data-title="Sản phẩm">
                                                            <a
                                                                href="{{ route('products.detail', $item->options['slug']) }}">{{ $item->name }}
                                                            </a>
                                                            <div class="show-for-small mobile-product-price">
                                                                <span class="mobile-product-price__qty">{{ $item->qty }}
                                                                    x
                                                                </span>
                                                                <span class="woocommerce-Price-amount amount"><bdi>{{ formatAmount($item->price) }}<span
                                                                            class="woocommerce-Price-currencySymbol">&#8363;</span></bdi></span>
                                                            </div>
                                                        </td>

                                                        <td class="product-price" data-title="Price">
                                                            <span class="woocommerce-Price-amount amount"><bdi>{{ formatAmount($item->price) }}
                                                                    <span
                                                                        class="woocommerce-Price-currencySymbol">&#8363;</span></bdi></span>
                                                        </td>

                                                        <td class="product-quantity" data-title="Quantity">
                                                            <div data-rowId="{{ $item->rowId }}"
                                                                class="quantity buttons_added form-flat">
                                                                <input type="button" value="-"
                                                                    class="minus button is-form" />

                                                                <input data-price="{{ $item->price }}"
                                                                    data-id="{{ $item->id }}" type="number"
                                                                    class="input-text qty text quantity_product"
                                                                    step="1" min="1" max=""
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
                                                    <tr>
                                                        <td colspan="6" class="actions clear">
                                                            Chưa có sản phẩm trong giỏ hàng
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <div class="continue-shopping pull-left text-left">
                                            <a class="button-continue-shopping button primary is-outline"
                                                href="{{ route('home') }}">
                                                &#8592;&nbsp;Tiếp tục mua sắm
                                            </a>
                                        </div>
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
                                                        class="woocommerce-Price-amount amount price-product-total">{{ strtok(Cart::instance('shopping')->subTotal(), '.') }}
                                                        ₫</span>
                                                </td>
                                            </tr>

                                        </table>

                                        <div class="wc-proceed-to-checkout">
                                            <a href="{{ Cart::instance('shopping')->count() <= 0 ? 'javascript:void(0)' : route('carts.thanh-toan') }}"
                                                class="checkout-button button alt wc-forward"
                                                @if (Cart::instance('shopping')->count() <= 0) style="pointer-events: none; opacity: 0.5;" @endif>
                                                Tiến hành thanh toán
                                            </a>

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
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".quantity_product").forEach(element => {
                let price = element.getAttribute("data-price");
                let qty = element.value;
                let priceElement = document.querySelector(`.quantity-price-${price}`);
                let totalPrice = parseInt(price) * parseInt(qty);
                priceElement.innerHTML = `${formatCurrency(totalPrice)}`;
            });

            jQuery(document).on('click', '.plus, .minus', function(e) {
                e.preventDefault();


                var quantityDiv = jQuery(this).closest('.quantity');


                var rowId = quantityDiv.data('rowid');


                var type = jQuery(this).hasClass('plus') ? 'plus' : 'minus';


                jQuery.ajax({
                    url: "{{ route('carts.update-to-cart', ':id') }}".replace(':id', rowId),
                    method: "POST",
                    data: {
                        type: type
                    },
                    success: function(response) {
                        if (response.status) {
                            cartItem(response);
                            cartResponse(response);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            jQuery(document).on('click', '.btn-remove-product', function(e) {
                e.preventDefault();

                const rowId = jQuery(this).data('row-id');
                const $tr = jQuery(this).closest('tr');

                jQuery.ajax({
                    url: "{{ route('carts.del-to-cart', ':id') }}".replace(':id', rowId),
                    type: 'POST',
                    data: {
                        rowId
                    },
                    success: function(response) {


                        if (response.status) {
                            toastr.success(response.message);

                            $tr.fadeOut(300, function() {
                                jQuery(this)
                                    .remove();
                            });


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
                        jQuery(this).removeClass('loading');
                    }
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
