@extends('frontends.layouts.master')
@section('title',$title)
@section('content')
    <div id="content" class="content-area page-wrapper" role="main">
        <div class="row row-main">
            <div class="large-12 col">
                <div class="col-inner">



                    <div class="woocommerce">
                        <div class="woocommerce-notices-wrapper"></div>
                        <div class="woocommerce-notices-wrapper"></div>
                        <form name="checkout" method="post" class="checkout woocommerce-checkout "
                            action="#" enctype="multipart/form-data"
                            novalidate="novalidate" data-gtm-form-interact-id="0">

                            <div class="row pt-0 ">
                                <div class="large-7 col  ">


                                    <div id="customer_details">
                                        <div class="clear">

                                            <div class="woocommerce-billing-fields">

                                                <h3>Chi tiết thanh toán</h3>



                                                <div class="woocommerce-billing-fields__field-wrapper">
                                                    <p class="form-row form-row-first validate-required"
                                                        id="billing_first_name_field" data-priority="10"><label
                                                            for="billing_first_name" class="">Họ&nbsp;<abbr class="required"
                                                                title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_first_name"
                                                                id="billing_first_name" placeholder="" value=""
                                                                aria-required="true" autocomplete="given-name"></span>
                                                    </p>
                                                    <p class="form-row form-row-last validate-required"
                                                        id="billing_last_name_field" data-priority="20"><label
                                                            for="billing_last_name" class="">Tên&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_last_name"
                                                                id="billing_last_name" placeholder="" value=""
                                                                aria-required="true" autocomplete="family-name"></span>
                                                    </p>



                                                    <p class="form-row address-field validate-required form-row-first"
                                                        id="billing_address_1_field" data-priority="50"><label
                                                            for="billing_address_1" class="">Địa chỉ
                                                            &nbsp;<abbr class="required"
                                                                title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_address_1"
                                                                id="billing_address_1"
                                                                placeholder="House number and street name" value=""
                                                                aria-required="true" autocomplete="address-line1"
                                                                data-placeholder="House number and street name"></span>
                                                    </p>
                                                    <p class="form-row address-field form-row-last"
                                                        id="billing_address_2_field" data-priority="60"><label
                                                            for="billing_address_2" class="">Apartment, suite,
                                                            unit, etc.&nbsp;<span
                                                                class="optional">(optional)</span></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_address_2"
                                                                id="billing_address_2"
                                                                placeholder="Apartment, suite, unit, etc. (optional)"
                                                                value="" autocomplete="address-line2"
                                                                data-placeholder="Apartment, suite, unit, etc. (optional)"></span>
                                                    </p>
                                                    {{-- <p class="form-row address-field validate-postcode form-row-wide"
                                                        id="billing_postcode_field" data-priority="65"
                                                        data-o_class="form-row form-row-wide address-field validate-postcode">
                                                        <label for="billing_postcode" class="">Postcode /
                                                            ZIP&nbsp;<span class="optional">(optional)</span></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_postcode"
                                                                id="billing_postcode" placeholder="" value=""
                                                                autocomplete="postal-code"></span>
                                                    </p>
                                                    <p class="form-row address-field validate-required form-row-wide"
                                                        id="billing_city_field" data-priority="70"
                                                        data-o_class="form-row form-row-wide address-field validate-required">
                                                        <label for="billing_city" class="">Town /
                                                            City&nbsp;<abbr class="required"
                                                                title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_city" id="billing_city"
                                                                placeholder="" value="" aria-required="true"
                                                                autocomplete="address-level2"></span>
                                                    </p> --}}
                                                    <p class="form-row address-field validate-state form-row-wide"
                                                        id="billing_state_field" style="display: none"
                                                        data-o_class="form-row form-row-wide address-field validate-state">
                                                        <label for="billing_state" class="">State /
                                                            County&nbsp;<span
                                                                class="optional">(optional)</span></label><span
                                                            class="woocommerce-input-wrapper"><input type="hidden"
                                                                id="billing_state" name="billing_state"
                                                                data-input-classes="" class="hidden"></span>
                                                    </p>
                                                    <p class="form-row form-row-wide validate-required validate-phone"
                                                        id="billing_phone_field" data-priority="100"><label
                                                            for="billing_phone" class="">Số điện thoại&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="tel"
                                                                class="input-text " name="billing_phone"
                                                                id="billing_phone" placeholder="" value=""
                                                                aria-required="true" autocomplete="tel"></span></p>
                                                    <p class="form-row form-row-wide validate-required validate-email"
                                                        id="billing_email_field" data-priority="110"><label
                                                            for="billing_email" class="">Email
                                                            &nbsp;<abbr class="required"
                                                                title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="email"
                                                                class="input-text " name="billing_email"
                                                                id="billing_email" placeholder="" value=""
                                                                aria-required="true" autocomplete="email username"></span>
                                                    </p>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="clear">
                                            <div class="woocommerce-shipping-fields">
                                            </div>
                                            <div class="woocommerce-additional-fields">



                                                <h3>Thông tin bổ sung</h3>


                                                <div class="woocommerce-additional-fields__field-wrapper">
                                                    <p class="form-row notes" id="order_comments_field" data-priority="">
                                                        <label for="order_comments" class="">Ghi chú đơn hàng&nbsp;<span
                                                                class="optional">(tùy chọn)</span></label><span
                                                            class="woocommerce-input-wrapper">
                                                            <textarea name="order_comments" class="input-text " id="order_comments"
                                                                placeholder="Ghi chú đơn hàng" rows="2" cols="5"></textarea>
                                                        </span></p>
                                                </div>


                                            </div>
                                        </div>
                                    </div>



                                </div>

                                <div class="large-5 col">

                                    <div class="col-inner has-border">
                                        <div class="checkout-sidebar sm-touch-scroll">


                                            <h3 id="order_review_heading">Đơn hàng của bạn</h3>


                                            <div id="order_review" class="woocommerce-checkout-review-order">
                                                <table class="shop_table woocommerce-checkout-review-order-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="product-name">Sản phẩm</th>
                                                            <th class="product-total">Tổng cộng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    {{-- @dd($carts) --}}
                                                        @forelse ($carts as $item)
                                                            <tr class="cart_item">
                                                                <td class="product-name">
                                                                    {{ $item->name }} &nbsp; <strong
                                                                        class="product-quantity">×&nbsp; {{ $item->qty }}</strong> </td>
                                                                <td class="product-total">
                                                                    <span class="woocommerce-Price-amount amount"><bdi>{{ number_format($item->price * $item->qty , 0, '', '.') }}                                                                        <span
                                                                                class="woocommerce-Price-currencySymbol">₫</span></bdi></span>
                                                                </td>
                                                            </tr>
                                                        @empty

                                                        @endforelse

                                                    </tbody>
                                                    <tfoot>

                                                        <tr class="cart-subtotal">
                                                            <th>Tổng cộng</th>
                                                            <td><span class="woocommerce-Price-amount amount"><bdi>{{ number_format($total, 0, '', '.') }}<span
                                                                            class="woocommerce-Price-currencySymbol">₫</span></bdi></span>
                                                            </td>
                                                        </tr>






                                                        <tr class="order-total">
                                                            <th>Tổng cộng</th>
                                                            <td><strong><span
                                                                        class="woocommerce-Price-amount amount"><bdi>{{ number_format($total, 0, '', '.') }}<span
                                                                                class="woocommerce-Price-currencySymbol">₫</span></bdi></span></strong>
                                                            </td>
                                                        </tr>


                                                    </tfoot>
                                                </table>

                                                <div id="payment" class="woocommerce-checkout-payment">
                                                    <ul class="wc_payment_methods payment_methods methods">
                                                        <li class="wc_payment_method payment_method_bacs">
                                                            <input id="payment_method_bacs" type="radio"
                                                                class="input-radio" name="payment_method" value="bacs"
                                                                checked="checked" data-order_button_text="">

                                                            <label for="payment_method_bacs">
                                                                Chuyển khoản ngân hàng </label>
                                                            <div class="payment_box payment_method_bacs"
                                                                style="display: none;">
                                                                <p>Thực hiện thanh toán vào tài khoản ngân hàng của
                                                                    chúng tôi. Vui lòng sử dụng Mã đơn hàng của bạn
                                                                    trong phần Nội dung thanh toán. Đơn hàng sẽ được
                                                                    giao sau khi tiền đã chuyển. Thông tin chuyển khoản:
                                                                    Số tài khoản: 19134495685011 – Techcombank Hà Thành
                                                                    / CTK: Công ty CP Công nghệ và truyền thông Web89
                                                                    Việt Nam</p>
                                                            </div>
                                                        </li>
                                                        <li class="wc_payment_method payment_method_alepay">
                                                            <input id="payment_method_alepay" type="radio"
                                                                class="input-radio" name="payment_method" value="alepay"
                                                                data-order_button_text=""
                                                                data-gtm-form-interact-field-id="0">

                                                            <label for="payment_method_alepay">
                                                                Thanh toán qua ngân lượng </label>
                                                            <div class="payment_box payment_method_alepay" style="">
                                                                <p>Chọn một phương thức</p>

                                                                <!--<div id="custom_input">
                                <p class="form-row form-row-wide">
                                <label style="font-weight: normal;"><input type="checkbox" name="isCardLink"  /> Ghi nhớ thông tin thẻ cho các lần thanh toán tiếp theo</label>
                                </p>
                            </div>-->

                                                                <div id="custom_input">
                                                                    <p class="form-row form-row-wide">
                                                                        <label style="font-weight: normal;"><input
                                                                                type="radio" value="1"
                                                                                name="payment_alepay" checked=""
                                                                                data-gtm-form-interact-field-id="2">
                                                                            Thanh toán bằng thẻ quốc tế</label>
                                                                    </p>
                                                                    <p class="form-row form-row-wide">
                                                                        <label style="font-weight: normal;"><input
                                                                                type="radio" value="2"
                                                                                name="payment_alepay"
                                                                                data-gtm-form-interact-field-id="1">
                                                                            Thanh toán trả góp</label>
                                                                    </p>
                                                                    <p class="form-row form-row-wide">
                                                                        <label style="font-weight: normal;"><input
                                                                                type="radio" value="4"
                                                                                name="payment_alepay"> Thanh toán bằng
                                                                            thẻ ATM/IB</label>
                                                                    </p>
                                                                </div>

                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="form-row place-order">
                                                        <noscript>
                                                            Since your browser does not support JavaScript, or it is
                                                            disabled, please ensure you click the <em>Update Totals</em>
                                                            button before placing your order. You may be charged more
                                                            than the amount stated above if you fail to do so.
                                                            <br /><button type="submit" class="button alt"
                                                                name="woocommerce_checkout_update_totals"
                                                                value="Update totals">Update totals</button>
                                                        </noscript>

                                                        <div class="woocommerce-terms-and-conditions-wrapper">

                                                        </div>


                                                        <button type="submit" class="button alt"
                                                            name="woocommerce_checkout_place_order" id="place_order"
                                                            value="Place order" data-value="Place order">
                                                            Đặt hàng</button>


                                                        <input type="hidden" id="woocommerce-process-checkout-nonce"
                                                            name="woocommerce-process-checkout-nonce"
                                                            value="c144c737da"><input type="hidden"
                                                            name="_wp_http_referer" value="/?wc-ajax=update_order_review">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="woocommerce-privacy-policy-text"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
