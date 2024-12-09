@extends('frontends.layouts.master')

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
                                <a href="{{url('/')}}">Home</a>
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
                            <ul>
                                <li>
                                    Địa chỉ: {{$settings->address}}
                                </li>
                                <li>
                                    Kho hàng: {{ $settings->warehouse }}
                                </li>
                                <li>Điện thoại: {{ $settings->phone }}</li>
                                <li>
                                    Email:
                                    <a href="_wp_link_placeholder" data-wplink-edit="true">{{ $settings->email}}</a>
                                </li>
                            </ul>

                            <div class="wpcf7 no-js" id="wpcf7-f2452-p23-o1" lang="vi" dir="ltr">
                                <div class="screen-reader-response">
                                    <p role="status" aria-live="polite" aria-atomic="true"></p>
                                    <ul></ul>
                                </div>
                                <form action="/lien-he/#wpcf7-f2452-p23-o1" method="post" class="wpcf7-form init"
                                    aria-label="Form liên hệ" novalidate="novalidate" data-status="init">
                                    <div style="display: none">
                                        <input type="hidden" name="_wpcf7" value="2452" />
                                        <input type="hidden" name="_wpcf7_version" value="5.9.8" />
                                        <input type="hidden" name="_wpcf7_locale" value="vi" />
                                        <input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f2452-p23-o1" />
                                        <input type="hidden" name="_wpcf7_container_post" value="23" />
                                        <input type="hidden" name="_wpcf7_posted_data_hash" value="" />
                                    </div>
                                    <p>
                                        <label>
                                            Your name<br />
                                            <span class="wpcf7-form-control-wrap" data-name="your-name"><input
                                                    size="40" maxlength="400"
                                                    class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                    autocomplete="name" aria-required="true" aria-invalid="false"
                                                    value="" type="text" name="your-name" /></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            Your email<br />
                                            <span class="wpcf7-form-control-wrap" data-name="your-email"><input
                                                    size="40" maxlength="400"
                                                    class="wpcf7-form-control wpcf7-email wpcf7-validates-as-required wpcf7-text wpcf7-validates-as-email"
                                                    autocomplete="email" aria-required="true" aria-invalid="false"
                                                    value="" type="email" name="your-email" /></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            Tiêu đề:<br />
                                            <span class="wpcf7-form-control-wrap" data-name="your-subject"><input
                                                    size="40" maxlength="400"
                                                    class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                    aria-required="true" aria-invalid="false" value="" type="text"
                                                    name="your-subject" /></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            Your message (không bắt buộc)<br />
                                            <span class="wpcf7-form-control-wrap" data-name="your-message">
                                                <textarea cols="40" rows="10" maxlength="2000" class="wpcf7-form-control wpcf7-textarea"
                                                    aria-invalid="false" name="your-message"></textarea>
                                            </span>
                                        </label>
                                    </p>
                                    <p>
                                        <input class="wpcf7-form-control wpcf7-submit has-spinner" type="submit"
                                            value="Gửi" />
                                    </p>
                                    <p style="display: none !important" class="akismet-fields-container"
                                        data-prefix="_wpcf7_ak_">
                                        <label>&#916;
                                            <textarea name="_wpcf7_ak_hp_textarea" cols="45" rows="8" maxlength="100"></textarea>
                                        </label><input type="hidden" id="ak_js_1" name="_wpcf7_ak_js"
                                            value="136" />
                                        <script>
                                            document
                                                .getElementById("ak_js_1")
                                                .setAttribute("value", new Date().getTime());
                                        </script>
                                    </p>
                                    <div class="wpcf7-response-output" aria-hidden="true"></div>
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
