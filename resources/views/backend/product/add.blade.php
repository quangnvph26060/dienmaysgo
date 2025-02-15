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
        <div class="card-header  d-flex justify-content-between align-items-center">
            <h3 class="card-title m-0">Thêm sản phẩm</h3>
            <div class="card-tools">
                <a href="{{ route('admin.product.index') }}" class="btn btn-primary">Danh sách sản phẩm</a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <ul class="nav nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button"
                    role="tab" aria-controls="info" aria-selected="true">
                    Thông tin sản phẩm
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="parameters-tab" data-bs-toggle="tab" data-bs-target="#parameters"
                    type="button" role="tab" aria-controls="parameters" aria-selected="false">
                    Thông số kỹ thuật
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button"
                    role="tab" aria-controls="seo" aria-selected="false">
                    Cấu hình SEO
                </button>
            </li>
            {{-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="attribute-tab" data-bs-toggle="tab" data-bs-target="#attribute" type="button"
                    role="tab" aria-controls="attribute" aria-selected="false">
                    Thuộc tính
                </button>
            </li> --}}
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
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Nhập tên sản phẩm" value="{{ old('name') }}">

                                            <b id="slug-link" class="text-primary"><small>{{ env('APP_URL') }}/</small></b>
                                        </div>
                                        <!-- Giá -->

                                        <!-- Giá khuyến mãi-->

                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group mb-3">
                                            <label for="quantity" class="form-label">Số lượng</label>
                                            <input type="number" class="form-control" name="quantity" id="quantity"
                                                placeholder="Nhập số lượng" value="{{ old('quantity') }}">

                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group mb-3">
                                            <label for="fake_import_price" class="form-label">Giá nhập</label>
                                            <input type="text" class="form-control" id="fake_import_price"
                                                placeholder="Giá nhập sản phẩm" value="{{ old('import_price') }}">
                                            <input type="hidden" name="import_price" value="{{ old('import_price') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group mb-3">
                                            <label for="module" class="form-label">Module</label>
                                            <input type="text" class="form-control" name="module" id="module"
                                                placeholder="Nhập module" value="{{ old('module') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group mb-3">
                                            <label for="price" class="form-label">Giá bán</label>
                                            <input type="text" class="form-control" id="fake_price"
                                                placeholder="Giá bán sản phẩm" value="{{ old('price') }}">
                                            <input type="hidden" name="price" value="{{ old('price') }}">
                                        </div>
                                    </div>


                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="discount-type" class="form-label">Chọn loại giảm giá:</label>
                                            <select id="discount-type" class="form-select" name="discount_type">
                                                <option value="amount" @selected(old('discount_type') == 'amount')>Giảm tiền</option>
                                                <option value="percentage" @selected(old('discount_type') == 'percentage')>Giảm theo %
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="discount_value" class="form-label">Nhập giá trị giảm:</label>
                                            <input value="0" type="text" id="fake_discount_value"
                                                class="form-control" placeholder="Nhập số tiền hoặc %">

                                            <input value="0" type="hidden" name="discount_value">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="start-date" class="form-label">Ngày bắt đầu:</label>
                                            <input type="date" id="start-date"
                                                value="{{ old('discount_start_date') }}" class="form-control"
                                                name="discount_start_date">
                                        </div>
                                    </div>


                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="end-date" class="form-label">Ngày kết thúc:</label>
                                            <input type="date" value="{{ old('discount_end_date') }}" id="end-date"
                                                class="form-control" name="discount_end_date">
                                        </div>
                                    </div>


                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <label for="brand" class="form-label">Thương hiệu</label>
                                            <select id="mySelectBrand" class="form-select" style="width: 100%;"
                                                name="brand_id">
                                                @foreach ($brands as $id => $brand)
                                                    <option value="{{ $id }}" @selected($id == old('brand_id', 23))>
                                                        {{ $brand }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">Thuộc tính</label>
                                            <select id="mySelect" multiple="multiple" class="form-select"
                                                style="width: 100%;" name="attribute_id[]">
                                                @foreach ($attributes as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>

                                            <div id="additional-selects" class="mt-3 row">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Mô tả chi tiết</label>
                                            <textarea id="description" class="form-control" name="description" rows="10">{!! old('description') !!}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="tags" class="form-label">Tags</label>
                                            <input type="text" class="form-control" name="tags" id="tags"
                                                placeholder="tags sản phẩm" value="{{ old('tags') }}">
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
                                    <input type="text" class="form-control" name="title_seo" id="title_seo"
                                        placeholder="Nhập tiêu đề SEO" value="{{ old('title_seo') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description_seo" class="form-label">Mô tả SEO</label>

                                    <textarea style="resize: vertical;" name="description_seo" id="description_seo" cols="30" rows="6"
                                        placeholder="Nhập mô tả SEO" class="form-control"> {{ old('description_seo') }}
                                    </textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="keyword_seo" class="form-label">Từ khóa SEO</label>
                                    <input type="text" name="keyword_seo" id="keyword_seo" class="form-control"
                                        value="{{ old('keyword_seo') }}" placeholder="Nhập từ khóa SEO">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="parameters" role="tabpanel" aria-labelledby="parameters-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea id="description_short" class="form-control" name="description_short" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="tab-pane fade" id="attribute" role="tabpanel" aria-labelledby="attribute-tab">
                        <div class="card">
                            <div class="card-body">

                            </div>
                        </div>
                    </div> --}}
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
                                <option value="">--- Chọn danh mục ---</option>
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                        <option @selected($category->id == old('category_id', $category->category_parent_id ?? '')) value="{{ $category->id }}">
                                            {{ $category->name }}</option>
                                        @if ($category->childrens->isNotEmpty())
                                            @foreach ($category->childrens as $children)
                                                <option @selected($children->id == old('category_id', $category->category_parent_id ?? '')) value="{{ $children->id }}">-
                                                    {{ $children->name }}</option>
                                                @if ($children->childrens->isNotEmpty())
                                                    @foreach ($children->childrens as $item)
                                                        <option @selected($item->id == old('category_id', $category->category_parent_id ?? '')) value="{{ $item->id }}">
                                                            -- {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
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
                            <select class="form-select" name="promotions_id" id="promotions_id" disabled>
                                <option value="">Chọn chương trình</option>
                                @foreach ($promotions as $id => $name)
                                    <option value="{{ $id }}" @selected($id == old('promotions_id'))>{{ $name }}
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
                            <img src="" alt="" id="image_main" class="img-fluid w-100 mb-3">
                            <a href="#" id="select_main_image" style="text-decoration: underline">Chọn ảnh
                                tiêu biểu</a>

                            <input type="file" name="image" id="image" class="form-control"
                                style="display: none">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Album ảnh</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-images pb-3"></div>
                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
            $("#name, #category_id").on("input change", function() {
                let name = $("#name").val().trim();
                let category = $('#category_id').find(':selected').val() !== "" ? $('#category_id').find(
                    ':selected').text().trim().replace(/^[-\s]+/, "") : ""; // Xóa "-" đầu tiên
                updateSlug(name, category);
            });

            function generateSlug(text) {
                return text.toLowerCase()
                    .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // Loại bỏ dấu tiếng Việt
                    .replace(/đ/g, "d").replace(/Đ/g, "D") // Chuyển `đ` -> `d`
                    .replace(/[^a-z0-9 -]/g, "") // Xóa ký tự đặc biệt
                    .replace(/\s+/g, "-") // Thay khoảng trắng bằng dấu `-`
                    .replace(/-+/g, "-") // Xóa dấu `-` dư thừa
                    .trim(); // Xóa khoảng trắng đầu cuối
            }

            function updateSlug(name, category) {
                if (!name) return;

                let baseUrl = "{{ env('APP_URL') }}";
                let categorySlug = category ? generateSlug(category) + "/" : "";
                let productSlug = generateSlug(name);

                $("#slug-link small").text(`${baseUrl}/${categorySlug}${productSlug}`);
            }
        });

        $(document).ready(function() {

            $('#fake_price').on('change', function() {

                if ($(this).val() <= 0) {
                    $('#promotions_id').prop('disabled', true);
                } else {
                    $('#promotions_id').prop('disabled', false);
                }

            })

            $('#category_id').select2({
                placeholder: "Chọn một mục",
                allowClear: true
            });

            $('#mySelectBrand').select2({
                placeholder: 'Chọn một tùy chọn',
                allowClear: true
            });

            $('#mySelect').on('select2:select', function(e) {
                const selectedId = e.params.data.id;
                const selectedText = e.params.data.text;

                $.ajax({
                    url: "{{ route('admin.product.changeSelect') }}",
                    method: "POST",
                    data: {
                        selectedId
                    },
                    success: function(response) {
                        let optionsHtml = '<option value="">Chọn giá trị</option>';
                        $.each(response, function(id, value) {
                            optionsHtml += `<option value="${id}">${value}</option>`;
                        });

                        const newSelectHtml = `
                             <div class="col-lg-4 mb-3" id="select-wrapper-${selectedId}">
                                <label for="select-${selectedId}">${selectedText}</label>
                                <select name="attribute_value_id[]" id="select-${selectedId}" class="form-select" style="width: 100%;">
                                    ${optionsHtml}
                                </select>
                            </div>
                        `;

                        $('#additional-selects').append(newSelectHtml);
                    }
                })
            })

            $('#mySelect').select2({
                placeholder: 'Chọn một tùy chọn',
                allowClear: true
            });

            $('#mySelect').on('select2:unselect', function(e) {
                const unselectedId = e.params.data.id;

                $(`#select-wrapper-${unselectedId}`).remove();
            });

            let preloaded = [];

            $('.input-images').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'images',
                preloadedInputName: 'old',
                maxSize: 2 * 1024 * 1024,
                maxFiles: 15,
            });

            $(".upload-text").find("span").remove();

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

            const tags = document.querySelector('#tags');
            const tagsTagify = new Tagify(tags, {
                dropdown: {
                    maxItems: 10,
                    classname: "tags-look",
                    enabled: 0,
                    closeOnSelect: false
                }
            });

            tagsTagify.on('add', () => {
                adjustTagifyHeight(tagsTagify.DOM.scope);
            });

            function adjustTagifyHeight(scopeElement) {
                if (scopeElement) {
                    scopeElement.style.height = "auto"; // Reset chiều cao
                    scopeElement.style.height = scopeElement.scrollHeight + "px"; // Điều chỉnh theo nội dung
                }
            }

            formatDataInput('fake_price');
            formatDataInput('fake_import_price');
            formatDataInput('fake_discount_value');
        });
    </script>
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('backend/assets/css/image-uploader.min.css') }}">

    <style>
        .image-uploader .uploaded .uploaded-image {
            width: calc(49.666667% - 1rem);
            padding-bottom: calc(49.666667% - 1rem);
        }

        .tagify {
            height: auto !important;
        }

        .upload-text:hover {
            cursor: pointer;
        }
    </style>
@endpush
