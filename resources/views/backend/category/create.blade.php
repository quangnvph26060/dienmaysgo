@extends('backend.layouts.master')

@section('title', 'Thêm mới danh mục')

<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.min.css" rel="stylesheet">
@section('content')
    <div class="card">
        <div class="card-body">
            <form
                action="{{ isset($category) ? route('admin.category.update', $category->id) : route('admin.category.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Danh mục -->
                <h5 class="section-title">Thông tin Danh mục {{ isset($category) ? ' : ' . $category->name : '' }}</h5>
                <div class="row">

                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Nhập tên danh mục"
                                value="{{ old('name', $category->name ?? '') }}" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_parent_id" class="form-label">Danh mục cha</label>
                            <select class="form-select @error('category_parent_id') is-invalid @enderror"
                                id="category_parent_id" name="category_parent_id">
                                <option value="">----- Chọn danh mục cha -----</option>
                                @if ($parentCategories->isNotEmpty())
                                    @foreach ($parentCategories as $parentCategory)
                                        <option @selected($parentCategory->id == old('category_parent_id', $category->category_parent_id ?? '')) value="{{ $parentCategory->id }}">
                                            {{ str_repeat('-', $parentCategory->level) . $parentCategory->name }}</option>
                                        {{-- <option @selected($parentCategory->id == old('category_parent_id', $category->category_parent_id ?? '')) value="{{ $parentCategory->id }}">
                                            {{ $parentCategory->name }}</option>
                                        @if ($parentCategory->childrens->isNotEmpty())
                                            @foreach ($parentCategory->childrens as $children)
                                                <option @selected($children->id == old('category_parent_id', $category->category_parent_id ?? '')) value="{{ $children->id }}">--
                                                    {{ $children->name }}</option>
                                                @if ($children->childrens->isNotEmpty())
                                                    @foreach ($children->childrens as $item)
                                                        <option @selected($item->id == old('category_parent_id', $category->category_parent_id ?? '')) value="{{ $item->id }}">
                                                            ---- {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif --}}
                                    @endforeach
                                @endif
                            </select>
                        </div>



                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả chi tiết</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" placeholder="Nhập mô tả">{{ old('description', $category->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh danh mục</label>
                            <input type="file" id="image" name="logo" class="form-control d-none"
                                accept="image/*">
                            <div id="preview-frame"
                                style="cursor: pointer; border: 1px solid #ccc; padding: 20px; text-align: center;">
                                <p class="text-muted">Click here to select an image</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description_short" class="form-label">Mô tả hình ảnh</label>
                            <textarea class="form-control @error('description_short') is-invalid @enderror" name="description_short" rows="3"
                                placeholder="Nhập mô tả">{{ old('description_short', $category->description_short ?? '') }}</textarea>
                            @error('description_short')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- SEO -->
                <h5 class="section-title">Tối ưu SEO</h5>
                <div class="mb-3">
                    <label for="title_seo" class="form-label">Tiêu đề SEO</label>
                    <input type="text" class="form-control @error('title_seo') is-invalid @enderror" id="title_seo"
                        name="title_seo" placeholder="Nhập tiêu đề SEO"
                        value="{{ old('title_seo', $category->title_seo ?? '') }}" />
                    @error('title_seo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description_seo" class="form-label">Mô tả SEO</label>
                    <textarea class="form-control @error('description_seo') is-invalid @enderror" id="description_seo"
                        name="description_seo" rows="2" placeholder="Nhập mô tả SEO">{{ old('description_seo', $category->description_seo ?? '') }}</textarea>
                    @error('description_seo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keyword_seo" class="form-label">Từ khóa SEO</label>
                    <input type="text" class="form-control @error('keyword_seo') is-invalid @enderror" id="keyword_seo"
                        name="keyword_seo" placeholder="Nhập từ khóa SEO"
                        value="{{ old('keyword_seo', $category->keyword_seo ?? '') }}" />
                    @error('keyword_seo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end">

                    <button type="submit" class="btn btn-success">{{ isset($category) ? 'Cập nhật' : 'Lưu' }}</button>
                </div>
            </form>


        </div>
    </div>
@endsection

@push('styles')
    <style>
        .cke_notifications_area {
            display: none;
        }

        .error {
            color: red;
        }

        .selectize-control {
            border: 0px !important;
            padding: 0px !important;
        }

        .selectize-input {
            padding: 10px 12px !important;
            border: 2px solid #ebedf2 !important;
            border-radius: 5px !important;
            border-top: 1px solid #ebedf2 !important;
        }

        /* Phần danh mục */
        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            padding-top: 20px;
            margin-bottom: 15px;
            padding: 10px;
            color: #fff;
            text-align: center;
        }

        .section-title+.section-title {
            color: #FF9800
        }

        .section-title:nth-of-type(1) {
            background-color: #4CAF50;
        }

        /* Nền cam cho SEO */
        .section-title:nth-of-type(2) {
            margin-top: 20px;
            background-color: #695aec;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .btn {
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }

        #preview-frame {
            width: 100%;
            height: 300px;
            border: 2px dashed #ddd;
            display: flex;
            border-radius: 10px;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin-top: 10px;
        }

        #preview-frame img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        label {
            font-weight: 600;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

    <script src="{{ asset('ckfinder_php_3.7.0/ckfinder/ckfinder.js') }}"></script>
    <script>
        $('#category_parent_id').select2({
            placeholder: 'Chọn danh mục',
            allowClear: true,
            minimumInputLength: 0 // Không cần nhập ký tự để hiển thị dữ liệu
        });

        document.addEventListener("DOMContentLoaded", function() {
            const imageInput = document.getElementById('image');
            const previewFrame = document.getElementById('preview-frame');

            // Khi click vào khung preview, kích hoạt input file
            previewFrame.addEventListener('click', () => {
                imageInput.click();
            });

            // Khi chọn file, hiển thị ảnh
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewFrame.innerHTML =
                            `<img src="${e.target.result ?? 1}" alt="Selected Image" style="max-width: 100%; height: auto;">`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewFrame.innerHTML = '<p class="text-muted">Click here to select an image</p>';
                }
            });

            // Nếu có ảnh được chọn sẵn (ví dụ: từ trước khi tải lại trang), hiển thị ảnh
            const currentImageSrc =
                '{{ old('image', showImage($category->logo ?? '')) }}'; // Thay đổi này theo cách bạn lấy ảnh cũ từ server
            if (currentImageSrc) {
                previewFrame.innerHTML =
                    `<img src="${currentImageSrc}" alt="Selected Image" style="max-width: 100%; height: auto;">`;
            }
        });
    </script>
    <script>

        $(document).ready(function() {
            $('#keyword_seo').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    };
                },
                plugins: ['remove_button'],
                onKeyDown: function(e) {
                    if (e.key === ' ') {
                        e.preventDefault();
                        var value = this.$control_input.val().trim();
                        if (value) {
                            this.addItem(value);
                            this.$control_input.val('');
                        }
                    }
                }
            });
            CKEDITOR.replace('description', {
                filebrowserImageUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form',
            });

        });
    </script>
@endpush
