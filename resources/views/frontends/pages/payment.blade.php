@extends('frontends.layouts.master')
@section('title', 'Thanh toán')
@section('content')


    <div id="content" class="content-area page-wrapper" role="main">
        <div class="row row-main">
            <div class="large-12 col">
                <div class="col-inner">

                    <div class="woocommerce">
                        <div class="woocommerce-notices-wrapper"></div>
                        <div class="woocommerce-notices-wrapper"></div>
                        <form name="checkout" id="billingForm" method="post" class="checkout woocommerce-checkout "
                            action="#" enctype="multipart/form-data" novalidate="novalidate"
                            data-gtm-form-interact-id="0">

                            <div class="row pt-0 ">
                                <div class="large-7 col  ">

                                    <div id="customer_details">
                                        <div class="clear">

                                            <div class="woocommerce-billing-fields">

                                                <h3 style="padding-top: 0 !important">Chi tiết thanh toán</h3>

                                                <div class="woocommerce-billing-fields__field-wrapper">
                                                    <di style="display: flex; gap: 5px">
                                                        <p class="form-row  validate-required" id="fullname_field"
                                                            data-priority="10" style="width: 50%">
                                                            <label for="fullname" class="">Họ và tên&nbsp;
                                                                <abbr class="required" title="required">*</abbr>
                                                            </label>
                                                            <span class="woocommerce-input-wrapper">
                                                                <input type="text" class="input-text " name="fullname"
                                                                    id="fullname" placeholder=""
                                                                    value="{{ auth()->user()->name }}" aria-required="true"
                                                                    autocomplete="given-name">
                                                                <small></small>
                                                            </span>
                                                        </p>

                                                        <p class="form-row form-row-wide validate-required validate-phone"
                                                            id="billing_phone_field" data-priority="100" style="width: 50%">
                                                            <label for="phone" class="">Số điện thoại&nbsp;
                                                                <abbr class="required" title="required">*</abbr>
                                                            </label>
                                                            <span class="woocommerce-input-wrapper">
                                                                <input type="tel" class="input-text" name="phone"
                                                                    id="phone" placeholder=""
                                                                    value="{{ auth()->user()->phone }}" aria-required="true"
                                                                    autocomplete="tel"
                                                                    pattern="^(0[1-9]{1}[0-9]{8}|(\+84|84)[1-9]{1}[0-9]{8})$"
                                                                    title="Số điện thoại không đúng định dạng" />
                                                                <small></small>
                                                            </span>
                                                        </p>
                                                    </di>

                                                    <div style="display: flex; gap: 5px" id="address_field">
                                                        <p class="form-row  validate-required" id="province_field"
                                                            data-priority="10" style="width: 33%">
                                                            <label for="province" class="">Tỉnh thành&nbsp;
                                                                <abbr class="required" title="required">*</abbr>
                                                            </label>
                                                            <span class="woocommerce-input-wrapper">
                                                                <select name="province" id="province"
                                                                    data-url="{{ route('carts.api.districts') }}">
                                                                    <option value="" selected>--- Chọn tỉnh thành ---
                                                                    </option>
                                                                    @foreach ($province as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <small></small>
                                                            </span>
                                                        </p>

                                                        <p class="form-row  validate-required" id="district_field"
                                                            data-priority="10" style="width: 33%">
                                                            <label for="district" class="">Quận/Huyện&nbsp;
                                                                <abbr class="required" title="required">*</abbr>
                                                            </label>
                                                            <span class="woocommerce-input-wrapper">
                                                                <select name="district" id="district"
                                                                    data-url="{{ route('carts.api.wards') }}">
                                                                    <option value="" selected>--- Chọn quận/huyện ---
                                                                    </option>
                                                                </select>
                                                                <small></small>
                                                            </span>
                                                        </p>

                                                        <p class="form-row  validate-required" id="ward_field"
                                                            data-priority="10" style="width: 33%">
                                                            <label for="ward" class="">Phường/Xã&nbsp;
                                                                <abbr class="required" title="required">*</abbr>
                                                            </label>
                                                            <span class="woocommerce-input-wrapper">
                                                                <select name="ward" id="ward">
                                                                    <option value="" selected>--- Chọn phường/xã ---
                                                                    </option>
                                                                </select>
                                                                <small></small>
                                                            </span>
                                                        </p>
                                                    </div>

                                                    <p class="form-row address-field validate-required "
                                                        id="billing_address_1_field" data-priority="50">
                                                        <label for="billing_address_1" class="">Địa chỉ
                                                            &nbsp;
                                                            <abbr class="required" title="required">*</abbr>
                                                        </label>
                                                        <span class="woocommerce-input-wrapper">
                                                            <input type="text" class="input-text " name="address"
                                                                id="address" value="" aria-required="true"
                                                                autocomplete="address-line1">
                                                            <small></small>
                                                        </span>
                                                    </p>

                                                    <p class="form-row form-row-wide validate-required validate-email"
                                                        id="email_field" data-priority="110">
                                                        <label for="email" class="">Email&nbsp;
                                                            <abbr class="required" title="required">*</abbr>
                                                        </label>
                                                        <span class="woocommerce-input-wrapper">
                                                            <input type="email" class="input-text " name="email"
                                                                id="email" placeholder=""
                                                                value="{{ auth()->user()->email }}" aria-required="true"
                                                                autocomplete="email username">
                                                            <small></small>
                                                        </span>
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
                                                    <p class="form-row notes" id="note_field" data-priority="">
                                                        <label for="note" class="">Ghi chú đơn
                                                            hàng&nbsp;<span class="optional">(tùy chọn)</span></label><span
                                                            class="woocommerce-input-wrapper">
                                                            <textarea name="notes" class="input-text " id="note" placeholder="Ghi chú đơn hàng" rows="2"
                                                                cols="5"></textarea>
                                                            <small></small>
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
                                                        @forelse ($carts as $item)
                                                            <tr class="cart_item">
                                                                <td class="product-name" style="width: 70%">
                                                                    {{ $item->name }} &nbsp; <strong
                                                                        class="product-quantity">×&nbsp;
                                                                        {{ $item->qty }}</strong> </td>
                                                                <td class="product-total">
                                                                    <span class="woocommerce-Price-amount amount"><bdi>{{ number_format($item->price * $item->qty, 0, '', '.') }}
                                                                            <span
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
                                                                            class="woocommerce-Price-currencySymbol">
                                                                            ₫</span></bdi></span>
                                                            </td>
                                                        </tr>

                                                    </tfoot>
                                                </table>

                                                <div id="payment" class="woocommerce-checkout-payment">
                                                    <h3 id="order_review_heading">Phương thức thanh toán</h3>

                                                    <ul class="wc_payment_methods payment_methods methods">
                                                        {{-- <input type="radio" class="input-radio" name="payment_method"
                                                            value="transfer_payment"> --}}
                                                        @php($statusValue = ['cod', 'bacs'])
                                                        @foreach ($payments as $item)
                                                            {{-- {{ $item }} --}}
                                                            @php($value = $statusValue[$item->id - 1])

                                                            <li class="wc_payment_method payment_method_alepay">
                                                                <input type="radio" class="input-radio"
                                                                    @checked($loop->first) name="payment_method"
                                                                    value="{{ $value }}">

                                                                <label for="payment_method_alepay">
                                                                    {{ $item->name }}
                                                                </label>

                                                                <small
                                                                    style="display: block; margin-left: 10px">{!! $item->description !!}
                                                                </small>
                                                            </li>
                                                        @endforeach

                                                    </ul>

                                                    <div class="form-row place-order">

                                                        <button type="submit" class="button alt"
                                                            name="woocommerce_checkout_place_order" id="place_order"
                                                            value="Place order" data-value="Place order">
                                                            Đặt hàng</button>

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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {

            // Ẩn tất cả các đoạn text trong thẻ <p> ban đầu
            $('.wc_payment_methods .wc_payment_method small').hide();

            // Xử lý khi chọn input
            $('.wc_payment_methods .wc_payment_method input').on('change', function() {
                // Ẩn tất cả các đoạn text <p>
                $('.wc_payment_methods .wc_payment_method small').hide();

                // Hiện đoạn text <p> tương ứng với input được chọn
                $(this).closest('li').find('small').show();
            });

            // Kích hoạt text <p> mặc định ban đầu (nếu có input được checked sẵn)
            $('.wc_payment_methods .wc_payment_method input:checked').closest('li').find('small').show();

            $('#billingForm').on('submit', function(e) {

                e.preventDefault();

                let formData = $(this).serializeArray();

                $.ajax({
                    url: '{{ route('carts.checkout') }}',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.success) window.location.href = response.redirect

                        // switch (response.payment_method) {
                        //     case 'cod':
                        //         window.location.href = response.redirect
                        //     case 'bacs':
                        //         $('#qrImage').attr('src', response.qrCode);
                        //         $('#qrPopup').css('display', 'flex');
                        //         break;
                        // }

                    },
                    error: function(xhr) {
                        if (xhr.status == 422) {
                            $('input, textarea, select').css('border',
                                '1px solid blue').siblings('small').html('');

                            $.each(xhr.responseJSON.errors, (key, value) => {
                                $(`input[name=${key}], textarea[name=${key}], select[name=${key}`)
                                    .css('border', '1px solid red').siblings('small')
                                    .css('color', 'red')
                                    .html(value)
                            })

                        } else {
                            alert('Đã có lỗi xảy ra. vui lòng thực hiện lại sau!');
                        }

                    },
                });
            });


            $('#province').change(function() {
                var provinceId = $(this).val();
                var districtSelect = $('#district');
                districtSelect.empty().append('<option value="" selected>--- Chọn quận/huyện ---</option>');

                if (provinceId) {
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'GET',
                        data: {
                            province_id: provinceId
                        },
                        success: function(data) {
                            $.each(data.districts, function(key, value) {
                                districtSelect.append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        },
                        error: function() {
                            alert('Không thể lấy dữ liệu quận/huyện.');
                        }
                    });
                }
            });

            $('#district').change(function() {
                var districtId = $(this).val();
                var wardSelect = $('#ward');
                wardSelect.empty().append('<option value="" selected>--- Chọn phường/xã ---</option>');

                if (districtId) {
                    $.ajax({
                        url: $('#district').data('url'),
                        type: 'GET',
                        data: {
                            district_id: districtId
                        },
                        success: function(data) {
                            $.each(data.wards, function(key, value) {
                                wardSelect.append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        },
                        error: function(err) {
                            alert('Không thể lấy dữ liệu phường/xã.');
                        }
                    });
                }
            });
        });
    </script>
@endsection

@push('styles')
    <style>
        bdi {
            font-size: 15px;
        }

        .popup-buttons {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-complete {
            background: #28a745;
            color: white;
            padding: 0px 15px !important;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 0 !important;
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
            padding: 0px 15px !important;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-complete:hover {
            background: #218838;
        }

        .btn-cancel:hover {
            background: #c82333;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
            /* Ẩn mặc định */
        }

        .popup .popup-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .popup-overlay .popup-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            position: relative;
            width: 400px;
        }

        .popup-content img {
            max-width: 100%;
            height: auto;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
@endpush
