<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <meta property="fb:app_id" content="1234567890" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('og_title')" />
    <meta property="og:description" content="@yield('og_description')" />
    <meta property="og:site_name" content="{{ $settings->company_name ?? env('APP_NAME') }}" />
    <meta property="og:image" content="@yield('og_image', showImage($settings->path))" />

    @include('frontends.layouts.partials.styles')

</head>

<body>
    <div id="wrapper">

        <div class="loading-api">
            <div id="loading-overlay" class="loading-overlay">
                <div class="loading-spinner">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <p class="loading-text">Đang tải dữ liệu...</p>
            </div>
        </div>

        <header id="header" class="header has-sticky sticky-jump">
            @include('frontends.layouts.partials.header')
        </header>

        {{-- @include('frontends.layouts.partials.popup-cart') --}}

        <main id="main" class="">
            @yield('content')
        </main>

        <footer id="footer" class="footer-wrapper">
            @include('frontends.layouts.partials.footer')
        </footer>

    </div>


    <div id="main-menu" class="mobile-sidebar no-scrollbar mfp-hide mobile-sidebar-slide mobile-sidebar-levels-1"
        data-levels="1">
        @include('frontends.layouts.partials.mobile-sidebar')
    </div>

    <!-- if gom all in one show -->
    <div id="button-contact-vr" class="">
        @include('frontends.layouts.partials.btn-contacts')
        <!-- end v3 class gom-all-in-one -->
    </div>


    @include('frontends.layouts.partials.global')


    @include('frontends.layouts.partials.scripts')


</body>

</html>
