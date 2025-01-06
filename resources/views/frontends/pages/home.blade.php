@extends('frontends.layouts.master')

@section('content')
    <div class="row container">
        <nav class="large-2">
            <p class="block button-home-nav"><i class="icon-menu" style="color: #9f2323; font-size: 20px"></i>Danh
                sách danh mục</p>
            <div class="home-nav">
                <div class="menu">
                    @foreach ($cataloguesMenu as $item)
                        <div class="menu-item">
                            <a href="{{ route('products.list', $item->slug) }}"> {{ $item->name }}</a>
                            @if ($item->childrens->isNotEmpty())
                                <span class="arrow">&#9654;</span>
                            @endif
                            <!-- Mũi tên cấp 1 -->
                            <div class="popup">
                                <div class="submenu">
                                    @if ($item->childrens->isNotEmpty())
                                        @foreach ($item->childrens as $child)
                                            <div class="submenu-item">
                                                <a href="{{ route('products.list', $child->slug) }}">
                                                    {{ $child->name }}
                                                </a>
                                                @if ($child->childrens->isNotEmpty())
                                                    <span class="arrow">&#9654;</span>
                                                @endif
                                                <!-- Mũi tên cấp 2 -->
                                                <div class="popup-level-3">
                                                    @include('frontends.layouts.partials.menu-item', [
                                                        'item' => $child,
                                                    ])
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </nav>

        <div class="large-10">
            <div class="swiper">
                <div class="swiper-wrapper">

                    @foreach ($images as $image)
                        <div class="swiper-slide">
                            <img src="{{ showImage($image) }}" alt="{{ showImage($image) }}">
                        </div>
                    @endforeach
                    <!-- Thêm nhiều slide nếu cần -->
                </div>
                <!-- Thêm nút điều hướng (nếu cần) -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <!-- Thêm phân trang (nếu cần) -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>

    <div id="content" role="main" class="content-area">
        @foreach ($data as $catalogue)
            @if ($catalogue['products']->isEmpty())
                @continue
            @endif

            <section class="section danh-muc-section">
                <div class="bg section-bg fill bg-fill bg-loaded"></div>

                <div class="section-content relative">
                    <div class="row" id="row-2095685915">
                        <div class="col small-12 large-12">
                            <div class="col-inner">
                                <div id="gap-848292812" class="gap-element clearfix" style="display: block; height: auto">

                                </div>

                                <div class="container section-title-container">
                                    <h2 class="section-title section-title-normal">
                                        <b></b><span class="section-title-main">{{ $catalogue['parent']->name }}</span>
                                        <span class="hdevvn-show-cats">
                                            @if ($catalogue['childrens']->isNotEmpty())
                                                @foreach ($catalogue['childrens']->take(5) as $child)
                                                    <li class="hdevvn_cats">
                                                        <a
                                                            href="{{ route('products.list', $child->slug) }}">{{ $child->name }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </span><b></b><a href="{{ route('products.list', $catalogue['parent']->slug) }}"
                                            target="">Xem
                                            thêm<i class="icon-angle-right"></i></a>
                                    </h2>
                                </div>
                                <!-- .section-title -->

                                <div class="row equalize-box large-columns-5 medium-columns-3 small-columns-2 row-collapse">

                                    <x-products :products="$catalogue['products']" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>

                </style>
            </section>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontends/assets/js/toastr.min.js') }}"></script>
    <script>
        addToCart();
    </script>

    <script>
        const swiper = new Swiper('.swiper', {
            loop: true, // Bật vòng lặp
            autoplay: {
                delay: 3000, // Thời gian chờ giữa các slide
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
@endpush


@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('frontends/assets/css/toastr.min.css') }}">
    <style>
        .button-home-nav {
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
        }

        .home-nav {
            display: flex;
            font-family: Arial, sans-serif;
            margin: 0;
            height: 38vh;
        }

        .menu {
            width: 100%;
            color: black !important;
            position: relative;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
        }

        .menu .menu-item a {
            color: black !important;
        }

        .menu-item {
            padding: 10px;
            cursor: pointer;
            position: relative;
            transition: background-color 0.3s ease;
        }

        .menu-item:hover {
            background-color: #EC1C24;
        }

        .menu .menu-item:hover>a,
        .popup .submenu .submenu-item:hover>a {
            color: #ffffff !important;
        }

        .popup {
            display: none;
            position: absolute;
            left: 260px;
            /* Đẩy popup ra ngoài menu */
            top: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 100;
            white-space: nowrap;
        }


        .menu-item:hover .popup {
            display: flex;
            flex-direction: column;
            /* Sắp xếp theo cột cho danh mục cấp 2 */
        }

        .submenu {
            /* display: flex; */
            flex-wrap: wrap;
            /* Cho phép xuống dòng */
        }

        .submenu-item {
            border: 1px solid #EC1C24;

            border-bottom: none;

            padding: 10px 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: relative;
            background: #ffffff;
            color: black
                /* Để định vị popup cấp 3 */
        }

        .submenu-item:last-child {
            border-bottom: 1px solid #EC1C24;
        }


        .submenu-item:hover {
            background-color: #EC1C24;
            color: white;
        }

        .popup-level-3 {
            display: none;
            position: absolute;
            top: 0;
            left: 100%;
            /* Đẩy submenu cấp 3 sang bên phải ngang hàng với cấp 2 */
            z-index: 2;
            white-space: nowrap;
        }

        .submenu-item:hover .popup-level-3 {
            display: block;
            /* Hiện submenu cấp 3 khi hover vào danh mục cấp 2 */
        }

        .popup-level-3 .submenu-item:hover {
            background-color: #EC1C24;
        }

        .arrow {
            /* float: right; */
            margin-left: 8px;
            font-size: 12px;
            color: black;
            transition: transform 0.3s ease;
            display: inline-block;
            /* Để đảm bảo mũi tên nằm trong dòng với văn bản */
        }

        /* Xoay mũi tên khi hover vào menu-item hoặc mũi tên */
        .menu-item:hover>.arrow,
        .submenu-item:hover>.arrow,
        .menu-item:hover .submenu-item:hover>.arrow {
            transform: rotate(90deg);
            /* Xoay mũi tên khi hover */
            color: white;
        }

        @keyframes fadeSlideIn {
            0% {
                opacity: 0;
                transform: translateY(-10px);
                /* Dịch lên trên */
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .popup,
        .popup-level-3 {
            opacity: 0;
            transform: translateY(-10px);
            /* Ban đầu dịch lên trên */
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .menu-item:hover .popup,
        .submenu-item:hover .popup-level-3 {
            opacity: 1;
            /* Hiện popup */
            transform: translateY(0);
            /* Dịch về đúng vị trí */
            animation: fadeSlideIn 0.3s ease;
            /* Áp dụng animation */
        }

        /* CSS cho slider */
        .swiper {
            width: 100%;
            height: 45vh;
            /* Chiều cao slider */
        }

        @media(max-width:768px) {
            .swiper {
                height: 30vh;
            }
        }

        @media screen and (min-width: 850px) {
            .large-10 {
                flex-basis: 78.333333%;
                max-width: 78.333333%;
            }

            .large-2 {
                flex-basis: 21.666667%;
                max-width: 21.666667%;
            }
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        img {
            width: 100%;
            /* Đảm bảo hình ảnh chiếm toàn bộ chiều rộng của slide */
            height: 100%;
            /* Đảm bảo tỉ lệ khung hình */
        }

        #section_1222005858 {
            padding-top: 0px;
            padding-bottom: 0px;
        }

        #section_1222005858 .ux-shape-divider--top svg {
            height: 150px;
            --divider-top-width: 100%;
        }

        #section_1222005858 .ux-shape-divider--bottom svg {
            height: 150px;
            --divider-width: 100%;
        }


        #section_1407667100 {
            padding-top: 0px;
            padding-bottom: 0px;
        }

        #section_1407667100 .ux-shape-divider--top svg {
            height: 150px;
            --divider-top-width: 100%;
        }

        #section_1407667100 .ux-shape-divider--bottom svg {
            height: 150px;
            --divider-width: 100%;
        }

        #section_1595699534 {
            padding-top: 0px;
            padding-bottom: 0px;
        }

        #section_1595699534 .ux-shape-divider--top svg {
            height: 150px;
            --divider-top-width: 100%;
        }

        #section_1595699534 .ux-shape-divider--bottom svg {
            height: 150px;
            --divider-width: 100%;
        }
    </style>
@endpush
