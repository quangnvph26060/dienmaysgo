@extends('frontends.layouts.master')

@section('content')

@php
//   $carts =  Cart::instance('shopping')->content();
//   dd($carts);
// Cart::instance('shopping')->destroy();
@endphp

    <div id="content" role="main" class="content-area">



        @foreach ($catalogues as $catalogue)
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
                                        <b></b><span class="section-title-main">{{ $catalogue->name }}</span>
                                        <span class="hdevvn-show-cats">

                                            @foreach ($catalogue->childrens->take(5) as $child)
                                                <li class="hdevvn_cats">
                                                    <a
                                                        href="{{ route('products.list', $child->slug) }}">{{ $child->name }}</a>
                                                </li>
                                            @endforeach
                                        </span><b></b><a href="{{ route('products.list', $catalogue->slug) }}"
                                            target="">Xem
                                            thêm<i class="icon-angle-right"></i></a>
                                    </h2>
                                </div>
                                <!-- .section-title -->

                                <div class="row equalize-box large-columns-5 medium-columns-3 small-columns-2 row-collapse">
                                    @foreach ($catalogue->products as $product)
                                        <x-product-item :product="$product" />
                                    @endforeach
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
    <script src="{{ asset('frontends/assets/js/toastr.min.js') }}"></script>
    <script>
        addToCart();
    </script>
@endpush


@push('styles')
    <link rel="stylesheet" href="{{ asset('frontends/assets/css/toastr.min.css') }}">
    <style>
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

        #gap-848292812 {
            padding-top: 30px;
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
