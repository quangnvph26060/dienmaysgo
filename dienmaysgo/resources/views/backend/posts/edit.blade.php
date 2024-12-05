@extends('backend.catalogues.create')

@section('title', $title)

@section('content')
    <form action="{{ route('admin.posts.update', $post) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">{{ $title }}</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-primary"><i
                                    class="fas fa-list me-2"></i>Danh
                                sách</a>
                        </div>
                    </div>


                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="title">Tiêu đề</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        value="{{ old('title', $post->title) }}">
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="title">Thẻ</label>
                                    <select name="tags[]" class="sa-select2 form-select" multiple id="tags">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tags', $oldTags)))>
                                                {{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="excerpt">Mô tả ngắn</label>
                                    <input type="text" name="excerpt" id="excerpt" class="form-control"
                                        value="{{ old('excerpt', $post->excerpt) }}">

                                    @error('excerpt')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="meta_keywords">Từ khóa seo</label>
                                    <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"
                                        value="{{ old('meta_keywords', $post->meta_keywords) }}">
                                    @error('meta_keywords')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="meta_description">Mô tả seo</label>
                                    <textarea name="meta_description" id="meta_description" cols="30" rows="5" class="form-control">{{ old('meta_description', $post->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="content">Nội dung</label>
                                    <textarea name="content" id="content" cols="30" rows="10" class="summernote" placeholder="content">{{ old('content', $post->content) }}</textarea>
                                    @error('content')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Xác nhận</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ảnh tiêu biểu</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <img src="{{ showImage( $post->featured_image ) }}" class="img-fluid" id="show_featured_image"
                                style="max-height: 240px; cursor: pointer" alt=""
                                onclick="document.getElementById('featured_image').click();">
                            <input type="file" name="featured_image" id="featured_image" class="form-control file-input"
                                accept="image/*" onchange="previewImage(event, 'show_featured_image')">
                            @error('featured_image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Xuất bản</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <select name="is_published" id="is_published" class="form-select">
                                <option value="1" @selected(old('is_published', $post->is_published == 1))>Xuất bản</option>
                                <option value="0" @selected(old('is_published', $post->is_published == 0))>Không xuất bản</option>
                            </select>
                            @error('is_published')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection

@push('scripts')
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/selectize.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/select2.js') }}"></script>
    <script src="{{ asset('backend/assets/js/summernote-bs4.min.js') }}"></script>
    <script>
        $('.summernote').summernote({
            height: '350px'
        });

        $(document).ready(function() {

            $('.sa-select2').select2();


            $('#meta_keywords').selectize({
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
        })
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/assets/css/selectize.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/summernote-bs4.min.css') }}">
@endpush
