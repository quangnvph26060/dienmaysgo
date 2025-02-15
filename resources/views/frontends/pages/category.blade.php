@extends('frontends.layouts.master')

@section('content')
    @include('components.breadcrumb_V2', [
        'name' => 'Danh sách danh mục',
    ])
    <div class="category-container">
        @foreach ($cataloguesMenu as $catalogue)
            <div class="category">
                <h3> <img width="22" src="{{ showImage($catalogue->logo) }}" alt="{{ $catalogue->name }}"
                        style="margin-right: 5px"><a
                        href="{{ route('products.detail', $catalogue->slug) }}">{{ $catalogue->name }}</a></h3>
                @if ($catalogue->childrens->isNotEmpty())
                    @foreach ($catalogue->childrens as $child)
                        <ul class="sub-category">
                            <li>
                                <img width="22" src="{{ showImage($child->logo) }}" alt="{{ $child->name }}"
                                    style="margin-right: 5px">
                                <a class="main-category"
                                    href="{{ route('products.detail', $child->slug) }}">{{ $child->name }}</a>
                                <ul class="sub-category-level">
                                    @if ($child->childrens->isNotEmpty())
                                        @foreach ($child->childrens as $c)
                                            <li style="display: flex; align-items: center">
                                                <img width="22" src="{{ showImage($c->logo) }}"
                                                    alt="{{ $c->name }}" style="margin-right: 5px">
                                                <a href="{{ route('products.detail', $c->slug) }}">{{ $c->name }}</a>
                                            </li>
                                        @endforeach
                                    @endif

                                </ul>
                            </li>
                        </ul>
                    @endforeach
                @endif

            </div>
        @endforeach

    </div>
@endsection

@push('styles')
    <style>
        .category-container {
            width: 80%;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .category h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
            display: flex;
            align-items: center;
            background-color: #e0e0e0;
            padding: 8px 0;
            border-radius: 4px
        }

        .category h3::before {
            content: url('icon.png');
            /* Replace with an icon or emoji */
            margin-right: 10px;
        }

        .sub-category {
            padding-left: 20px;
            list-style-type: none;
        }

        .sub-category>li {
            margin-bottom: 10px;
        }

        .main-category {
            font-weight: bold;
            font-size: 14px;
            color: #444;
            margin-bottom: 15px;
            display: inline-block;
        }

        .sub-category-level {
            list-style-type: none;
            margin: 0;
            padding-left: 20px;
            display: grid !important;
            grid-template-columns: repeat(4, 1fr);
            /* 4 cột với kích thước bằng nhau */
            gap: 10px;
            /* Khoảng cách giữa các mục */
        }

        .sub-category-level li {
            margin-bottom: 0;
        }

        .sub-category-level li a {
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            color: #333
        }

        .sub-category-level li a:hover {
            color: #ec1c24;
        }
    </style>
@endpush
