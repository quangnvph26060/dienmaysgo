<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('frontends.layouts.partials.styles')

</head>

<body>
    <div id="wrapper">

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
