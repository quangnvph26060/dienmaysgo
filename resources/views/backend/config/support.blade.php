@extends('backend.layouts.master')

@section('title', 'Thông tin hỗ trợ')

@section('content')
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.config.index') }}">Cấu hình chung</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.config.config-payment') }}">Cấu hình thanh toán</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.config.config-slider') }}">Cấu hình slider</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.config.config-filter') }}">Cấu hình bộ lọc</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.config.config-support') }}">Thông tin hỗ trợ</a>
        </li>
    </ul>

    <form action="{{ route('admin.config.update-support') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div id="icon-container">

                    @forelse ($config->support['icon'] ?? [] as $key => $icon)
                        <div class="row form-group">
                            <div class="col-4">
                                <input type="text" value="{{ $icon }}" class="form-control icon-picker"
                                    name="support[icon][]" placeholder="Chọn icon" />
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control" name="support[content][]"
                                    value="{{ $config->support['content'][$key] ?? '' }}" placeholder="Nội dung" />
                            </div>
                            @if ($loop->first)
                                <button id="add-btn" type="button" class="btn btn-success btn-sm col-1">+</button>
                            @else
                                <button type="button" class="remove-btn btn btn-danger btn-sm col-1">-</button>
                            @endif
                        </div>
                    @empty
                        <div class="row form-group">
                            <div class="col-4">
                                <input type="text" class="form-control icon-picker"
                                    name="support[icon][]" placeholder="Chọn icon" />
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control" name="support[content][]"
                                    placeholder="Nội dung" />
                            </div>

                            <button id="add-btn" type="button" class="btn btn-success btn-sm col-1">+</button>

                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="mb-3">
                    <label for="">Tiêu đề</label>
                    <input type="text" name="introduct_title" class="form-control"
                        value="{{ $config->introduct_title }}">
                </div>

                <div id="input-container">

                    @forelse ($config->introduction['phone'] ?? [] as $key => $phone)
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <input type="text" name="introduction[phone][]" class="form-control"
                                    value="{{ $phone }}" placeholder="Số điện thoại">
                            </div>

                            <div class="col-lg-5 mb-3">
                                <input type="text" name="introduction[facility][]" class="form-control"
                                    value="{{ $config->introduction['facility'][$key] ?? '' }}" placeholder="Cơ sở">
                            </div>

                            <div class="col-lg-1 mb-3">
                                @if ($key > 0)
                                    <button type="button" class="btn  btn-danger remove-row btn-sm">-</button>
                                @else
                                    <button type="button" class="btn  btn-success add-row btn-sm">+</button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <input type="text" name="introduction[phone][]" class="form-control" value=""
                                    placeholder="Số điện thoại">
                            </div>

                            <div class="col-lg-5 mb-3">
                                <input type="text" name="introduction[facility][]" class="form-control" value=""
                                    placeholder="Cơ sở">
                            </div>

                            <div class="col-lg-1 mb-3">
                                <button type="button" class="btn btn-sm btn-success add-row">+</button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>


        <button class="btn btn-primary">Lưu thay đổi</button>
    </form>
@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/js/fontawesome-iconpicker.min.js">
    </script>
    <script>
        $('.add-row').click(function() {
            var newRow = `
            <div class="row">
                <div class="col-lg-6 mb-3">
                        <input type="text" name="introduction[phone][]" class="form-control" value="" placeholder="Số điện thoại">
                </div>
                <div class="col-lg-5 mb-3">
                        <input type="text" name="introduction[facility][]" class="form-control" value="" placeholder="Cơ sở">
                </div>
                <div class="col-lg-1 mb-3">
                        <button type="button" class="btn btn-sm btn-danger remove-row">-</button>
                </div>
            </div>
        `;
            $('#input-container').append(newRow);
        });

        // Xử lý nút "-" để xóa dòng input
        $(document).on('click', '.remove-row', function() {
            $(this).closest('.row').remove();
        });

        $(".icon-picker").iconpicker();

        // Khi bấm "Thêm"
        $("#add-btn").click(function() {
            let newRow = `
        <div class="row form-group">
            <div class="col-4">
                <input name="support[icon][]" type="text" class="form-control icon-picker" placeholder="Chọn icon" />
            </div>
            <div class="col-7">
                <input type="text" name="support[content][]" class="form-control" placeholder="Nội dung" />
            </div>
            <button class="remove-btn btn btn-danger btn-sm col-1">-</button>
        </div>
    `;

            $("#icon-container").append(newRow);

            // Khởi tạo Icon Picker cho input mới
            $(".icon-picker").iconpicker();
        });

        // Khi bấm "-" để xóa
        $(document).on("click", ".remove-btn", function() {
            $(this).closest(".form-group").remove();
        });
    </script>
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/css/fontawesome-iconpicker.min.css"
        rel="stylesheet" />

    <style>
        .iconpicker-popover.popover {
            z-index: 1000;
            width: 333px !important;
        }

        .fade:not(.show) {
            opacity: 1 !important;
        }
    </style>
@endpush
