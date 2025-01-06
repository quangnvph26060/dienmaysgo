@extends('frontends.layouts.master')

@section('content')
    <div id="content" class="content-area page-wrapper" role="main">
        <div class="row row-main">
            <div class="large-12 col">
                <div class="col-inner">
                    <div class="woocommerce">
                        <div class="woocommerce-notices-wrapper"></div>
                        <div class="woocommerce-notices-wrapper"></div>
                        <form name="checkout" method="post" class="checkout woocommerce-checkout"
                            action="" enctype="multipart/form-data">
                            <div class="row pt-0">
                                <div class="large-7 col">
                                    <div id="customer_details">
                                        <div class="clear">
                                            <wc-order-attribution-inputs></wc-order-attribution-inputs>
                                            <div class="woocommerce-billing-fields">
                                                <h3>Billing details</h3>

                                                <div class="woocommerce-billing-fields__field-wrapper">
                                                    <p class="form-row form-row-first validate-required"
                                                        id="billing_first_name_field" data-priority="10">
                                                        <label for="billing_first_name" class="">First name&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text" name="billing_first_name"
                                                                id="billing_first_name" placeholder="" value="đạt"
                                                                aria-required="true" autocomplete="given-name" /></span>
                                                    </p>
                                                    <p class="form-row form-row-last validate-required"
                                                        id="billing_last_name_field" data-priority="20">
                                                        <label for="billing_last_name" class="">Last name&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text" name="billing_last_name"
                                                                id="billing_last_name" placeholder="" value="nguyễn"
                                                                aria-required="true" autocomplete="family-name" /></span>
                                                    </p>


                                                    <p class="form-row address-field form-row-first validate-required"
                                                        id="billing_address_1_field" data-priority="50">
                                                        <label for="billing_address_1" class="">Street
                                                            address&nbsp;<abbr class="required"
                                                                title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text" name="billing_address_1"
                                                                id="billing_address_1"
                                                                placeholder="House number and street name"
                                                                value="Trịnh Văn Bô" aria-required="true"
                                                                autocomplete="address-line1" /></span>
                                                    </p>
                                                    <p class="form-row address-field form-row-last"
                                                        id="billing_address_2_field" data-priority="60">
                                                        <label for="billing_address_2" class="">Apartment, suite,
                                                            unit, etc.&nbsp;<span
                                                                class="optional">(optional)</span></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text" name="billing_address_2"
                                                                id="billing_address_2"
                                                                placeholder="Apartment, suite, unit, etc. (optional)"
                                                                value="" autocomplete="address-line2" /></span>
                                                    </p>

                                                    <p class="form-row form-row-wide address-field validate-required"
                                                        id="billing_city_field" data-priority="70">
                                                        <label for="billing_city" class="">Town / City&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text" name="billing_city" id="billing_city"
                                                                placeholder="" value="Trịnh Văn Bô" aria-required="true"
                                                                autocomplete="address-level2" /></span>
                                                    </p>

                                                    <p class="form-row form-row-wide address-field validate-state"
                                                        id="billing_state_field" style="display: none">
                                                        <label for="billing_state" class="">State /
                                                            County&nbsp;<span
                                                                class="optional">(optional)</span></label><span
                                                            class="woocommerce-input-wrapper"><input type="hidden"
                                                                class="hidden" name="billing_state" id="billing_state"
                                                                value="" autocomplete="address-level1"
                                                                placeholder="" readonly="readonly"
                                                                data-input-classes="" /></span>
                                                    </p>

                                                    <p class="form-row form-row-wide validate-required validate-phone"
                                                        id="billing_phone_field" data-priority="100">
                                                        <label for="billing_phone" class="">Phone&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="tel"
                                                                class="input-text" name="billing_phone"
                                                                id="billing_phone" placeholder="" value="+84964305701"
                                                                aria-required="true" autocomplete="tel" /></span>
                                                    </p>

                                                    <p class="form-row form-row-wide validate-required validate-email"
                                                        id="billing_email_field" data-priority="110">
                                                        <label for="billing_email" class="">Email address&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="email"
                                                                class="input-text" name="billing_email"
                                                                id="billing_email" placeholder=""
                                                                value="datntph36687@fpt.edu.vn" aria-required="true"
                                                                autocomplete="email username" /></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clear">
                                            <div class="woocommerce-shipping-fields"></div>
                                            <div class="woocommerce-additional-fields">
                                                <h3>Additional information</h3>

                                                <div class="woocommerce-additional-fields__field-wrapper">
                                                    <p class="form-row notes" id="order_comments_field" data-priority="">
                                                        <label for="order_comments" class="">Order notes&nbsp;<span
                                                                class="optional">(optional)</span></label><span
                                                            class="woocommerce-input-wrapper">
                                                            <textarea name="order_comments" class="input-text" id="order_comments"
                                                                placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="large-5 col">
                                    <div class="col-inner has-border">
                                        <div class="checkout-sidebar sm-touch-scroll">
                                            <h3 id="order_review_heading">Your order</h3>

                                            <div id="order_review" class="woocommerce-checkout-review-order">
                                                <table class="shop_table woocommerce-checkout-review-order-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="product-name">Product</th>
                                                            <th class="product-total">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="cart_item">
                                                            <td class="product-name">
                                                                Máy Phát Điện Chạy Xăng Elemax
                                                                SH1900&nbsp;
                                                                <strong class="product-quantity">&times;&nbsp;1</strong>
                                                            </td>
                                                            <td class="product-total">
                                                                <span class="woocommerce-Price-amount amount"><bdi>11.800.000<span
                                                                            class="woocommerce-Price-currencySymbol">&#8363;</span></bdi></span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="cart-subtotal">
                                                            <th>Subtotal</th>
                                                            <td>
                                                                <span class="woocommerce-Price-amount amount"><bdi>11.800.000<span
                                                                            class="woocommerce-Price-currencySymbol">&#8363;</span></bdi></span>
                                                            </td>
                                                        </tr>

                                                        <tr class="order-total">
                                                            <th>Total</th>
                                                            <td>
                                                                <strong><span
                                                                        class="woocommerce-Price-amount amount"><bdi>11.800.000<span
                                                                                class="woocommerce-Price-currencySymbol">&#8363;</span></bdi></span></strong>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <div id="payment" class="woocommerce-checkout-payment">
                                                    <ul class="wc_payment_methods payment_methods methods">
                                                        <li class="wc_payment_method payment_method_bacs">
                                                            <input id="payment_method_bacs" type="radio"
                                                                class="input-radio" name="payment_method" value="bacs"
                                                                checked="checked" data-order_button_text="" />

                                                            <label for="payment_method_bacs">
                                                                Chuyển khoản ngân hàng
                                                            </label>
                                                            <div class="payment_box payment_method_bacs">
                                                                <p>
                                                                    Thực hiện thanh toán vào tài khoản ngân
                                                                    hàng của chúng tôi. Vui lòng sử dụng Mã
                                                                    đơn hàng của bạn trong phần Nội dung
                                                                    thanh toán. Đơn hàng sẽ được giao sau
                                                                    khi tiền đã chuyển. Thông tin chuyển
                                                                    khoản: Số tài khoản: 19134495685011 –
                                                                    Techcombank Hà Thành / CTK: Công ty CP
                                                                    Công nghệ và truyền thông Web89 Việt Nam
                                                                </p>
                                                            </div>
                                                        </li>
                                                        <li class="wc_payment_method payment_method_alepay">
                                                            <input id="payment_method_alepay" type="radio"
                                                                class="input-radio" name="payment_method" value="alepay"
                                                                data-order_button_text="" />

                                                            <label for="payment_method_alepay">
                                                                Thanh toán qua ngân lượng
                                                            </label>
                                                            <div class="payment_box payment_method_alepay"
                                                                style="display: none">
                                                                <p>Chọn một phương thức</p>

                                                                <!--<div id="custom_input">
                <p class="form-row form-row-wide">
                  <label style="font-weight: normal;"><input type="checkbox" name="isCardLink"  /> Ghi nhớ thông tin thẻ cho các lần thanh toán tiếp theo</label>
                </p>
              </div>-->

                                                                <div id="custom_input">
                                                                    <p class="form-row form-row-wide">
                                                                        <label style="font-weight: normal"><input
                                                                                type="radio" value="1"
                                                                                name="payment_alepay" checked />
                                                                            Thanh toán bằng thẻ quốc tế</label>
                                                                    </p>
                                                                    <p class="form-row form-row-wide">
                                                                        <label style="font-weight: normal"><input
                                                                                type="radio" value="2"
                                                                                name="payment_alepay" />
                                                                            Thanh toán trả góp</label>
                                                                    </p>
                                                                    <p class="form-row form-row-wide">
                                                                        <label style="font-weight: normal"><input
                                                                                type="radio" value="4"
                                                                                name="payment_alepay" />
                                                                            Thanh toán bằng thẻ ATM/IB</label>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="form-row place-order">
                                                        <noscript>
                                                            Since your browser does not support
                                                            JavaScript, or it is disabled, please ensure
                                                            you click the <em>Update Totals</em> button
                                                            before placing your order. You may be
                                                            charged more than the amount stated above if
                                                            you fail to do so. <br /><button type="submit"
                                                                class="button alt"
                                                                name="woocommerce_checkout_update_totals"
                                                                value="Update totals">
                                                                Update totals
                                                            </button>
                                                        </noscript>

                                                        <div class="woocommerce-terms-and-conditions-wrapper"></div>

                                                        <button type="submit" class="button alt"
                                                            name="woocommerce_checkout_place_order" id="place_order"
                                                            value="Place order" data-value="Place order">
                                                            Place order
                                                        </button>
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
