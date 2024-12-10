@extends('backend.layouts.master')
@section('title', 'Thêm mới sản phẩm')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card">
        <div class="card-header  d-flex justify-content-between ">
            <h4 class="card-title">Chỉnh sửa sản phẩm {{ $product->name }}</h4>
            <div class="card-tools">
                <a href="{{ route('admin.product.index') }}" class="btn btn-primary">Danh sách sản phẩm</a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.product.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <ul class="nav nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button"
                    role="tab" aria-controls="info" aria-selected="true">
                    Thông tin sản phẩm
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button"
                    role="tab" aria-controls="seo" aria-selected="false">
                    Cấu hình SEO
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="album-tab" data-bs-toggle="tab" data-bs-target="#album" type="button"
                    role="tab" aria-controls="album" aria-selected="false">
                    Ảnh album
                </button>
            </li>
        </ul>

        <div class="row">
            <div class="col-lg-9">
                <div class="tab-content" id="productTabsContent">
                    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Cột bên trái -->
                                    <div class="col-lg-6 add_product">
                                        <!-- Tên sản phẩm -->
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Tên sản phẩm</label>
                                            <input value="{{ $product->name }}" type="text" class="form-control"
                                                name="name" id="name" placeholder="Nhập tên sản phẩm">
                                        </div>
                                        <!-- Giá -->

                                        <!-- Giá khuyến mãi-->

                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="quantity" class="form-label">Số lượng</label>
                                            <input value="{{ $product->quantity }}" type="number" class="form-control"
                                                name="quantity" id="quantity" placeholder="Nhập giá sản phẩm">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="price" class="form-label">Giá bán</label>
                                            <input value="{{ $product->price ?? 0 }}" type="number" class="form-control"
                                                name="price" id="price" placeholder="Nhập giá bán sản phẩm">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="import_price" class="form-label">Giá nhập</label>
                                            <input value="{{ $product->import_price ?? 0 }}" type="number"
                                                class="form-control" name="import_price" id="import_price"
                                                placeholder="Nhập giá nhập sản phẩm">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description_short" class="form-label">Mô tả phụ</label>
                                            <textarea id="description_short" class="form-control" name="description_short" rows="10">{!! $product->description_short !!}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Mô tả</label>
                                            <textarea id="description" class="form-control" name="description" rows="10">{!! $product->description !!}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="title_seo" class="form-label">Tiêu đề SEO</label>
                                    <input value="{{ $product->title_seo }}" type="text" class="form-control"
                                        name="title_seo" id="title_seo" placeholder="Nhập tiêu đề SEO">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description_seo" class="form-label">Mô tả SEO</label>

                                    <textarea style="resize: vertical;" name="description_seo" id="description_seo" cols="30" rows="6"
                                        placeholder="Nhập mô tả SEO" class="form-control">{!! $product->description_seo !!}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="keyword_seo" class="form-label">Từ khóa SEO</label>
                                    <input value="{{ $product->keyword_seo }}" type="text" name="keyword_seo"
                                        id="keyword_seo" class="form-control @error('keyword_seo') is-invalid @enderror"
                                        value="" placeholder="Nhập từ khóa SEO">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="album" role="tabpanel" aria-labelledby="album-tab">
                        <div class="form-group mb-3">
                            <div class="input-images pb-3"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-3">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh mục</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <select class="form-select" name="category_id" id="category_id">
                                @foreach ($categories as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ $product->category_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Xuất xứ</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-3">
                            <select class="form-select" name="origin_id" id="origin_id">
                                @foreach ($origins as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ $product->origin_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Nhiên liệu</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-3">
                            <select class="form-select" name="fuel_id" id="fue_id">
                                @foreach ($fuels as $id => $name)
                                    <option value="{{ $id }}" {{ $product->fuel_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Khuyến mãi</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-3">
                            <select class="form-select" name="promotions_id" id="promotions_id">
                                @foreach ($promotions as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ $product->promotions_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ảnh đại diện</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-0">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="" id="image_main"
                                class="img-fluid w-100 mb-3">
                            <a href="#" id="select_main_image" style="text-decoration: underline">Chọn ảnh
                                tiêu biểu</a>

                            <input type="file" name="image" id="image" class="form-control"
                                style="display: none">
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>




    </form>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-fileinput/js/fileinput.min.js"></script>

    <script src="{{ asset('backend/assets/js/image-uploader.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

    <script src="{{ asset('ckfinder_php_3.7.0/ckfinder/ckfinder.js') }}"></script>

    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    <script>
        $(document).ready(function() {

            // @if (isset($images))
            //     let preloaded = @json($images);
            // @else
            //     let preloaded = [];
            // @endif

            const preloaded = @json(
                $images->map(function ($image) {
                    return [
                        'src' => asset('storage/' . $image->image), // Đường dẫn ảnh
                        'id' => $image->id, // ID của ảnh
                    ];
                }));

            console.log(preloaded);
            // return;
            $('.input-images').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'images',
                preloadedInputName: 'old',
                maxSize: 2 * 1024 * 1024,
                maxFiles: 15,
            });

            CKEDITOR.replace('description', {
                filebrowserImageUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form',
            });

            CKEDITOR.replace('description_short', {
                filebrowserImageUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form',
            });

            $('#select_main_image').click(function(e) {
                e.preventDefault();
                $('#image').click();
            });

            $('#image').change(function() {
                const file = $(this)[0].files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_main').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            });

            const input = document.querySelector('#keyword_seo');
            const tagify = new Tagify(input, {
                whitelist: [
                    "Mua hàng online giá rẻ",
                    "Bán hàng trực tuyến",
                    "Mua sắm tiện lợi",
                    "Ưu đãi hôm nay",
                    "Khuyến mãi hấp dẫn",
                    'Hàng chính hãng',
                    'Thanh toán an toàn',
                    'Công nghệ tiên tiến'
                ],
                dropdown: {
                    maxItems: 10,
                    classname: "tags-look",
                    enabled: 0,
                    closeOnSelect: false
                }
            });

            tagify.on('add', () => {
                adjustTagifyHeight(tagify.DOM.scope);
            });

            function adjustTagifyHeight(scopeElement) {
                if (scopeElement) {
                    scopeElement.style.height = "auto"; // Reset chiều cao
                    scopeElement.style.height = scopeElement.scrollHeight + "px"; // Điều chỉnh theo nội dung
                }
            }
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('backend/assets/css/image-uploader.min.css') }}">

    <style>
        .upload-text:hover {
            cursor: pointer;
        }
    </style>
@endpush
