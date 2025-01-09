@extends('backend.layouts.master')

@section('title', 'Thêm mới bài viết')
@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ isset($new) ? route('admin.news.update', $new->id) : route('admin.news.store') }}"
            enctype="multipart/form-data" method="POST">
            @csrf
            <h5 class="section-title">Thông tin bài viết{{ isset($new)  ? ' : '.$new->titles : ''}}</h5>
            <div class="row ">
                <!-- Form Inputs -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" id="title" name="title"
                            class="form-control @error('title') is-invalid @enderror" placeholder="Enter post title"
                            value="{{ old('title', $new->title ?? '') }}">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        <textarea id="content" name="content"
                            class="form-control @error('content') is-invalid @enderror" rows="5"
                            placeholder="Enter content">{{ old('content', $new->content ?? '') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3" style="text-align: center;display: flex;
                            flex-direction: column;
                            align-items: center;">
                        <label for="image" class="form-label">Ảnh</label>
                        <input type="file" id="image" name="image" class="form-control d-none" accept="image/*">
                        <div id="preview-frame"
                            style="cursor: pointer; border: 1px solid #ccc; padding: 20px; text-align: center;">
                            <p class="text-muted">Click here to select an image</p>
                        </div>
                        @error('image')
                        <div class="invalid-feedback" style="display: inline-block; font-weight: 600">{{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3" >
                        <label for="is_published" class="form-label">Trạng thái</label>
                        <select id="is_published" name="is_published" class="form-select">
                            <option value="1" {{ old('is_published', $new->is_published ?? '') == 1 ? 'selected' : ''
                                }}>Active</option>
                            <option value="0" {{ old('is_published', $new->is_published ?? '') == 0 ? 'selected' : ''
                                }}>Enabled</option>
                        </select>

                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <h5 class="section-title" style="background: #695aec">Thông tin SEO</h5>
                    <div class="mb-3">
                        <label for="title_seo" class="form-label">Tiêu đề SEO</label>
                        <input type="text" id="title_seo" name="title_seo"
                            class="form-control @error('title_seo') is-invalid @enderror" placeholder="Enter SEO title"
                            value="{{ old('title_seo', $new->title_seo ?? '') }}">
                        @error('title_seo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description_seo" class="form-label"> Nội dung SEO </label>
                        <textarea id="description_seo" name="description_seo"
                            class="form-control @error('description_seo') is-invalid @enderror" rows="3"
                            placeholder="Enter SEO description">{{ old('description_seo', $new->description_seo ?? '') }}</textarea>
                        @error('description_seo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keyword_seo" class="form-label">Từ khóa SEO</label>
                        <input type="text" id="keyword_seo" name="keyword_seo"
                            class="form-control @error('keyword_seo') is-invalid @enderror"
                            placeholder="Enter SEO keywords" value="{{ old('keyword_seo', $new->keyword_seo ?? '') }}">
                        @error('keyword_seo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end">

                    <button type="submit" class="btn btn-success">{{ isset($new) ? 'Cập nhật' : 'Lưu' }}</button>
                </div>
        </form>

    </div>

</div>
</div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.min.css" rel="stylesheet">
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
        height: 240px;
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<script src="{{ asset('ckfinder_php_3.7.0/ckfinder/ckfinder.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const imageInput = document.getElementById('image');
    const previewFrame = document.getElementById('preview-frame');

    // Khi click vào khung preview, kích hoạt input file
    previewFrame.addEventListener('click', () => {
        imageInput.click();
    });

    // Khi chọn file, hiển thị ảnh
    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewFrame.innerHTML = `<img src="${e.target.result}" alt="Selected Image" style="max-width: 100%; height: auto;">`;
            };
            reader.readAsDataURL(file);
        } else {
            previewFrame.innerHTML = '<p class="text-muted">Click here to select an image</p>';
        }
    });

    // Nếu có ảnh được chọn sẵn (ví dụ: từ trước khi tải lại trang), hiển thị ảnh
    const currentImageSrc = '{{ old("image", asset("storage/" . ($new->image ?? ""))) }}'; // Thay đổi này theo cách bạn lấy ảnh cũ từ server
    if (currentImageSrc) {
        previewFrame.innerHTML = `<img src="${currentImageSrc}" alt="Selected Image" style="max-width: 100%; height: auto;">`;
    }
});
</script>

<script>
    var $jq = jQuery.noConflict();
    $jq(document).ready(function() {
        $jq('#keyword_seo').selectize({
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

        CKEDITOR.replace('content', {
                filebrowserImageUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form',
            });
    });
</script>
@endpush
