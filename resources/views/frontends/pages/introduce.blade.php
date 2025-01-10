@extends('frontends.layouts.master')

@section('title', $title)
{{-- @section('description', $news->description_seo)
@section('keywords', $news->keyword_seo)
@section('og_title', $news->name)
@section('og_description', $news->description_seo) --}}

@section('content')
    <div id="content" role="main" class="content-area">
        <div id="page-header-415093479" class="page-header-wrapper">
            <div class="page-title dark featured-title">
                <div class="page-title-bg">
                    <div class="title-bg fill bg-fill" data-parallax-container=".page-title" data-parallax-background
                        data-parallax="-"></div>
                    <div class="title-overlay fill"></div>
                </div>

                <div class="page-title-inner container align-center flex-row medium-flex-wrap">
                    <div class="title-wrapper flex-col text-left medium-text-center">
                        <h1 class="entry-title mb-0">{{ $title }}</h1>
                    </div>
                    <div class="title-content flex-col flex-right text-right medium-text-center">
                        <div class="title-breadcrumbs pb-half pt-half">
                            <nav class="woocommerce-breadcrumb breadcrumbs">
                                <a href="{{ url('/') }}">Home</a>
                                <span class="divider">&#47;</span> {{ $title }}
                            </nav>
                        </div>
                    </div>
                </div>

                <style>
                    #page-header-415093479 .featured-title {
                        background-color: #1e73be;
                    }
                </style>
            </div>
        </div>

        <section class="section" id="section_2085143750">
            <div class="bg section-bg fill bg-fill bg-loaded"></div>

            <div class="section-content relative">
                <div class="row" id="row-611813157">
                    <div id="col-874962407" class="col small-12 large-12">
                        <div class="col-inner">

                            {!! $introduce->content !!}
                        </div>
                    </div>
                </div>
            </div>

            <style>
                #section_2085143750 {
                    padding-top: 30px;
                    padding-bottom: 30px;
                }

                #section_2085143750 .ux-shape-divider--top svg {
                    height: 150px;
                    --divider-top-width: 100%;
                }

                #section_2085143750 .ux-shape-divider--bottom svg {
                    height: 150px;
                    --divider-width: 100%;
                }
            </style>
        </section>
    </div>
@endsection
