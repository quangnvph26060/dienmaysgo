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
        <div class="card-header  d-flex justify-content-between">
            <h4 class="card-title">Thêm sản phẩm</h4>
            <div class="card-tools">
                <a href="{{ route('admin.product.index') }}" class="btn btn-primary btn-sm">Danh sách sản phẩm</a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Cột bên trái -->
                    <div class="col-lg-6 add_product">
                        <!-- Tên sản phẩm -->
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Nhập tên sản phẩm">
                        </div>
                        <!-- Giá -->
                        <div class="form-group mb-3">
                            <label for="quantity" class="form-label">Số lượng</label>
                            <input type="number" class="form-control" name="quantity" id="quantity"
                                placeholder="Nhập giá sản phẩm">
                        </div>
                        <!-- Giá khuyến mãi-->
                        <div class="form-group mb-3">
                            <label for="price" class="form-label">Giá</label>
                            <input type="number" class="form-control" name="price" id="price"
                                placeholder="Nhập giá khuyến mãi sản phẩm">
                        </div>
                        <div class="form-group mb-3">
                            <label for="promotions_id" class="form-label">Chương trình khuyến mãi</label>
                            <select class="form-select" name="promotions_id" id="promotions_id">
                                <option value="">Chọn chương trình</option>
                                @foreach ($promotions as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Cột bên phải -->
                    <div class="col-lg-6 add_product">

                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select class="form-select" name="category_id" id="category_id">
                                <option value="">Chọn danh mục</option>
                                @foreach ($categories as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="origin_id" class="form-label">Xuất xứ</label>
                            <select class="form-select" name="origin_id" id="origin_id">
                                <option value="">Chọn xuất xứ</option>
                                @foreach ($origins as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fuel_id" class="form-label">Nhiên liệu</label>
                            <select class="form-select" name="fuel_id" id="fue_id">
                                <option value="">Chọn nhiên liệu</option>
                                @foreach ($fuels as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Ảnh đại diện sản phẩm</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                max="1">
                        </div>
                    </div>
                    <!-- Mô tả -->
                    <div class="col-lg-12">
                        <label for="description_short" class="form-label">Mô tả phụ</label>
                        <textarea id="description_short" class="form-control" name="description_short" rows="10"></textarea>
                    </div>
                    <div class="col-lg-12">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea id="description" class="form-control" name="description" rows="10"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-3">
                        <label for="title_seo" class="form-label">Tiêu đề SEO</label>
                        <input type="text" class="form-control" name="title_seo" id="title_seo"
                            placeholder="Nhập tiêu đề SEO">
                    </div>
                    <div class="form-group mb-3">
                        <label for="description_seo" class="form-label">Mô tả SEO</label>
                        <input type="text" class="form-control" name="description_seo" id="description_seo"
                            placeholder="Nhập mô tả SEO">
                    </div>
                    <div class="form-group mb-3">
                        <label for="keyword_seo" class="form-label">Từ khóa SEO</label>
                        <input type="text" class="form-control" name="keyword_seo" id="keyword_seo"
                            placeholder="Nhập từ khóa SEO">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-fileinput/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#image").fileinput({
                showPreview: true, // Hiển thị ảnh preview
                allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif', 'jfif'], // Định dạng file chấp nhận
                maxFileSize: 2000, // Kích thước file tối đa (KB)
                browseLabel: 'Chọn ảnh', // Nhãn cho nút chọn ảnh
                removeLabel: 'Xóa ảnh', // Nhãn cho nút xóa ảnh
                uploadLabel: 'Tải lên', // Nhãn cho nút tải lên
                showRemove: true, // Hiển thị nút xóa
                showUpload: false, // Ẩn nút upload (nếu bạn không cần)
                previewFileType: 'image', // Đảm bảo chỉ hiển thị file ảnh
                browseIcon: '<i class="fas fa-folder-open"></i>', // Icon cho nút chọn file
                removeIcon: '<i class="fas fa-trash"></i>'
            });
        });
    </script>
@endpush

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css" />
    <style>
        .bootstrap-datetimepicker-widget {
            font-size: 0.875rem;
            /* Giảm kích thước font */
            max-width: 300px;
            /* Giới hạn chiều rộng */
        }

        .modal-backdrop.show {
            z-index: 1001 !important;
        }
    </style>
@endpush
