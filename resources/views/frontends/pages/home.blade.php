@extends('frontends.layouts.master')

@section('title', $settings->title_seo)
@section('description', $settings->description_seo)
@section('keywords', $settings->keywords_seo)
@section('og_title', $settings->title_seo ?? env('APP_NAME'))
@section('og_description', $settings->description_seo)


@section('content')
    <div class="row container">
        <nav class="large-2">
            <p class="block button-home-nav"><i class="fas fa-bars" style="color: #EC1C24; font-size: 20px"></i>DANH MỤC SẢN
                PHẨM</p>
            <div class="home-nav">
                <div class="menu">
                    @foreach ($cataloguesMenu->take(6) as $item)
                        <div class="menu-item @if ($item->childrens->isNotEmpty()) has-child @endif">
                            {{-- <i class="fas fa-home" style="margin-right: 5px"></i> --}}
                            <img width="22" src="{{ showImage($item->logo) }}" alt="">
                            <a style="text-transform: uppercase;" href="{{ route('products.detail', $item->slug) }}">
                                {{ $item->name }}</a>
                            <!-- Mũi tên cấp 1 -->
                            <div class="popup">
                                <div class="submenu">
                                    @if ($item->childrens->isNotEmpty())
                                        @foreach ($item->childrens as $child)
                                            <div class="submenu-item">
                                                <a href="{{ route('products.detail', $child->slug) }}">
                                                    {{ $child->name }}
                                                </a>
                                                <!-- Mũi tên cấp 2 -->
                                                <ul style="margin-left: 16px">
                                                    @include('frontends.layouts.partials.menu-item', [
                                                        'item' => $child,
                                                    ])
                                                </ul>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="" style="text-align: center; margin-top: 5px">
                        <a href="{{ route('products.list-category') }}">Xem tất cả danh mục</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="large-10">
            <div class="swiper">
                <div class="swiper-wrapper">

                    @foreach ($images as $image)
                        <div class="swiper-slide">
                            <picture style="height: 100%">
                                <!-- Nếu trình duyệt hỗ trợ WebP, nó sẽ tải ảnh WebP -->
                                <source srcset="{{ showImage($image, 'webp') }}" type="image/webp">
                                <!-- Nếu trình duyệt không hỗ trợ WebP, nó sẽ tải ảnh chuẩn -->
                                <img class="lazyload" data-src="{{ showImage($image) }}" src="{{ asset('backend/assets/img/image-default.jpg') }}"
                                    srcset="{{ resizeImage(showImage($image), 480) }} 480w,
                                        {{ resizeImage(showImage($image), 768) }} 768w,
                                        {{ resizeImage(showImage($image), 1200) }} 1200w"
                                    sizes="(max-width: 600px) 480px, (max-width: 1200px) 768px, 1200px" alt="Mô tả hình ảnh"
                                    loading="lazy">
                            </picture>
                        </div>
                    @endforeach
                    <!-- Thêm nhiều slide nếu cần -->
                </div>

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
                                                @foreach ($catalogue['childrens']->take(4) as $child)
                                                    <li class="hdevvn_cats">
                                                        <a
                                                            href="{{ route('products.detail', $child->slug) }}">{{ $child->name }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </span><b></b><a href="{{ route('products.detail', $catalogue['parent']->slug) }}"
                                            target="">Xem
                                            thêm<i class="fas fa-angle-right" style="margin-left: 5px"></i>
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
        .row.container {
            position: relative;
        }

        .button-home-nav {
            box-shadow:
                2px 0 5px rgba(0, 0, 0, 0.3),
                /* Bóng ở bên phải */
                -2px 0 5px rgba(0, 0, 0, 0.3);
            /* Bóng ở bên trái */
        }

        .menu {

            padding: 10px 0 10px 10px;
            width: 100%;
            color: black !important;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }

        .menu .menu-item:hover {
            background-color: #EC1C24
        }

        .menu .menu-item:hover>a,
        .menu .menu-item:hover>img {
            color: #ffffff !important;
            -webkit-filter: brightness(0) invert(1);
            filter: brightness(0) invert(1);
        }

        .submenu-item>a {
            font-weight: bold;
        }

        .submenu-item>a:hover,
        .submenu-item ul li:hover a {
            color: #EC1C24 !important;
        }

        .submenu-item ul li {
            margin-bottom: 0;
        }

        .submenu-item ul {
            list-style-type: disc;
            /* Kiểu dấu chấm */
            color: rgba(0, 0, 0, 0.5);
            /* Màu sắc nhạt (điều chỉnh giá trị alpha để làm nhạt) */
        }

        .menu .menu-item a {
            display: inline-block;
            line-height: 0 !important;
            color: black;
        }


        .menu .menu-item {
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: flex;
            gap: 15px;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
        }


        .menu .menu-item a {
            font-size: .9rem !important;
        }

        .menu .menu-item:hover,
        .menu .menu-item:hover>a,
        {
        color: #ffffff !important;
        }

        .popup {
            background-color: #ffffff;
            display: none;
            position: absolute;
            left: 251.9px;
            /* Đẩy popup ra ngoài menu */
            top: 0px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 100;
            /* white-space: nowrap; */
            width: 964px;
            bottom: 0;
            min-height: 273px;
            overflow-y: auto;
        }


        .menu-item.has-child:hover .popup {
            display: flex;
            flex-direction: column;
            /* Sắp xếp theo cột cho danh mục cấp 2 */
        }

        .submenu {
            display: flex;
            flex-wrap: wrap;
            /* Cho phép xuống dòng */
        }

        .submenu-item {
            padding: 5px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: relative;
            color: black
                /* Để định vị popup cấp 3 */
        }

        .submenu-item a {
            margin-bottom: 20px;
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
        {
        opacity: 0;
        transform: translateY(-10px);
        /* Ban đầu dịch lên trên */
        transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .menu-item:hover .popup,
        {
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
            min-height: unset;
            height: 100%;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            list-style: none;
            padding: 0;
            z-index: 1;
        }

        @media(max-width:867px) {
            .large-2 {
                display: none;
            }

            .large-10 {
                flex-basis: 100%;
                max-width: 100%;
            }

            .swiper {
                max-height: 245px;
            }
        }

        @media screen and (min-width: 850px) {
            .large-10 {
                flex-basis: 80.333333%;
                max-width: 80.333333%;
            }

            .large-2 {
                flex-basis: 19.666667%;
                max-width: 19.666667%;
            }
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            width: 100%;
            /* Đảm bảo hình ảnh chiếm toàn bộ chiều rộng của slide */
            /* Đảm bảo tỉ lệ khung hình */
            height: 100%;

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
