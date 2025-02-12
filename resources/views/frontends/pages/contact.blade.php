@extends('frontends.layouts.master')

@section('title', 'Liên hệ')
{{-- @section('description', $news->description_seo)
@section('keywords', $news->keyword_seo)
@section('og_title', $news->name)
@section('og_description', $news->description_seo) --}}

@section('content')
    <div id="content" role="main" class="content-area">
        <div id="page-header-1001269792" class="page-header-wrapper">
            <div class="page-title dark featured-title">
                <div class="page-title-bg">
                    <div class="title-bg fill bg-fill" data-parallax-container=".page-title" data-parallax-background
                        data-parallax="-"></div>
                    <div class="title-overlay fill"></div>
                </div>

                <div class="page-title-inner container align-center flex-row medium-flex-wrap">
                    <div class="title-wrapper flex-col text-left medium-text-center">
                        <h1 class="entry-title mb-0">Liên hệ</h1>
                    </div>
                    <div class="title-content flex-col flex-right text-right medium-text-center">
                        <div class="title-breadcrumbs pb-half pt-half">
                            <nav class="woocommerce-breadcrumb breadcrumbs">
                                <a href="{{ url('/') }}">Home</a>
                                <span class="divider">&#47;</span> Liên hệ
                            </nav>
                        </div>
                    </div>
                </div>

                <style>
                    #page-header-1001269792 .featured-title {
                        background-color: #1e73be;
                    }
                </style>
            </div>
        </div>

        <section class="section" id="section_109244052">
            <div class="bg section-bg fill bg-fill bg-loaded"></div>

            <div class="section-content relative">
                <div class="row" id="row-330176352">
                    <div id="col-1091670975" class="col medium-6 small-12 large-6">
                        <div class="col-inner">
                            <ul style="list-style: none">
                                <li>
                                    <p style="margin: 0; display: flex;"><strong style="width: 16%">Địa chỉ:</strong>
                                        <span>{{ $settings->address }}</span>
                                    </p>
                                </li>
                                <li>
                                    <strong>Kho hàng:</strong> {{ $settings->warehouse }}
                                </li>
                                <li><strong>Điện thoại:</strong> {{ $settings->phone }}</li>
                                <li>
                                    <strong>Email:</strong>
                                    <a href="_wp_link_placeholder" data-wplink-edit="true">{{ $settings->email }}</a>
                                </li>
                            </ul>

                            <hr>

                            <div class="wpcf7 no-js" id="wpcf7-f2452-p23-o1" lang="vi" dir="ltr">
                                <div class="screen-reader-response">
                                    <p role="status" aria-live="polite" aria-atomic="true"></p>
                                    <ul></ul>
                                </div>
                                <form action="{{ route('post-contact') }}" method="post" class="wpcf7-form init"
                                    aria-label="Form liên hệ" novalidate="novalidate" data-status="init">
                                    @csrf
                                    <p>
                                        <label>
                                            Họ và tên<br />
                                            <span class="wpcf7-form-control-wrap" data-name="name">
                                                <input size="40" maxlength="400"
                                                    class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                    autocomplete="name" aria-required="true" aria-invalid="false"
                                                    type="text" name="name" />
                                                <span class="wpcf7-not-valid-tip"></span>
                                            </span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            Địa chỉ Email<br />
                                            <span class="wpcf7-form-control-wrap" data-name="email">
                                                <input size="40" maxlength="400"
                                                    class="wpcf7-form-control wpcf7-email wpcf7-validates-as-required wpcf7-text wpcf7-validates-as-email"
                                                    autocomplete="email" aria-required="true" aria-invalid="false"
                                                    type="email" name="email" />
                                                <span class="wpcf7-not-valid-tip"></span>
                                            </span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            Tiêu đề<br />
                                            <span class="wpcf7-form-control-wrap" data-name="subject">
                                                <input size="40" maxlength="400"
                                                    class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                    aria-required="true" aria-invalid="false" type="text" name="subject"
                                                    placeholder="Tên sản phẩm"
                                                    value="@isset($product){{ $product->name }}@endisset" />
                                                <span class="wpcf7-not-valid-tip"></span>
                                            </span>
                                        </label>
                                    </p>

                                    <p>
                                        <label>
                                            Tin nhắn của bạn (không bắt buộc)<br />
                                            <span class="wpcf7-form-control-wrap" data-name="message">
                                                <textarea cols="40" rows="10" maxlength="2000" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false"
                                                    name="message"></textarea>
                                            </span>
                                        </label>
                                    </p>
                                    <p>
                                        <input class="wpcf7-form-control wpcf7-submit has-spinner" type="submit"
                                            value="Gửi" />
                                    </p>
                                    <div class="wpcf7-response-output"></div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div id="col-2005453375" class="col medium-6 small-12 large-6">
                        <div class="col-inner">
                            {!! $settings->map !!}
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .success {
                    border: 1px solid rgb(60, 60, 167) !important;
                    display: block !important;
                }

                .error {
                    border: 1px solid rgb(163, 40, 40) !important;
                    display: block !important;
                }

                #section_109244052 {
                    padding-top: 30px;
                    padding-bottom: 30px;
                }

                #section_109244052 .ux-shape-divider--top svg {
                    height: 150px;
                    --divider-top-width: 100%;
                }

                #section_109244052 .ux-shape-divider--bottom svg {
                    height: 150px;
                    --divider-width: 100%;
                }
            </style>
        </section>
    </div>
@endsection

@push('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}
    <script>
        // console.log(jQuery('.js-container'));
        jQuery(document).ready(function() {
            jQuery('.wpcf7-form.init').on('submit', function(e) {
                e.preventDefault();

                let formData = jQuery(this).serializeArray();

                jQuery('input, textarea').removeClass('error').addClass('success').siblings('span').css(
                    'display', 'none')

                jQuery.ajax({
                    'url': jQuery(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: (response) => {

                        jQuery('.wpcf7-response-output').removeClass('error').addClass(
                            'success').html(response.message);

                        jQuery(this)[0].reset();
                    },
                    error: (error) => {
                        console.log(error);

                        if (error.status == 422) {
                            jQuery.each(error.responseJSON.invalid_fields, (key, value) => {
                                jQuery(`input[name="${key}"], textarea[name="${key}"]`)
                                    .removeClass('success')
                                    .addClass('error').siblings('span').css('display',
                                        'block').html(value);
                            })
                        }

                        jQuery('.wpcf7-response-output').removeClass('success').addClass(
                            'error').html(error
                            .responseJSON.message)


                    }
                })

            })
        })
    </script>
@endpush
