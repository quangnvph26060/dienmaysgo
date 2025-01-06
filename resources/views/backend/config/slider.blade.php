@extends('backend.layouts.master')

@section('content')
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.config.index') }}">Cấu hình chung</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.config.config-payment') }}">Cấu hình thanh toán</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.config.config-slider') }}">Cấu hình trình chiếu</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.config.config-filter') }}">Cấu hình lọc</a>
        </li>
    </ul>
    <div class="card">


        <div class="card-body">
            <form action="{{ route('admin.config.handle-submit-slider') }}" method="post" id="handleSubmit"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="input-images pb-3"></div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend/assets/js/image-uploader.min.js') }}"></script>
    <script>
        const preloaded = @json($images);


        $('.input-images').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'images',
            preloadedInputName: 'old',
            maxSize: 2 * 1024 * 1024,
            maxFiles: 15,
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/image-uploader.min.css') }}">
@endpush
