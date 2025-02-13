@extends('backend.layouts.master')

@section('title', 'Cấu hình bộ lọc')


@section('content')
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.config.index') }}">Cấu hình chung</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.config.config-payment') }}">Cấu hình thanh toán</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.config.config-slider') }}">Cấu hình trình chiếu</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.config.config-filter') }}">Cấu hình bộ lọc</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.config.config-support') }}">Thông tin hỗ trợ</a>
        </li>
    </ul>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-content-center">
            <h4 class="card-title">Cấu hình lọc</h4>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Thêm lọc
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="display" style="width:100%">
                    <thead>
                        <th><input type="checkbox" id="selectAll" /></th>
                        <th>TIÊU ĐỀ</th>
                        <th>BỘ LỌC</th>
                        <th>GIÁ TRỊ</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="" id="handleSubmit">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm bộ lọc</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="filter_type">Chọn kiểu lọc</label>
                            <select id="filter_type" name="filter_type" class="form-control">
                                <option value="brand">Thương hiệu</option>
                                <option value="attribute">Thuộc tính</option>
                                <option value="price">Giá</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Tiêu đề</label>
                            <input type="text" id="title" name="title" class="form-control">
                        </div>

                        <div id="attribute-section" class="filter-options" style="display: none;">
                            <div class="form-group">
                                <label for="attribute_id">Chọn thuộc tính muốn lọc</label>
                                <select id="attribute_id" name="attribute_id" class="form-control">
                                    <option value="">Chọn thuộc tính</option>
                                    @foreach ($attributes as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="price-section" style="display: none;">
                            <div class="form-group">
                                <label for="attribute_id" class="form-label">Chọn giá muốn lọc</label>

                                <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Ví dụ: 10-20, 30-50, ..."></i>

                                <input type="text" class="form-control" name="option_price">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary btn-sm">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {

            const columns = [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'filter_type',
                    name: 'filter_type',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'attribute_id',
                    name: 'attribute_id',
                    orderable: false,
                    searchable: false
                }
            ]

            const api = '{{ route('admin.config.config-filter') }}'

            function updateOrderInDatabase(order) {
                console.log(13);
            }

            dataTables(api, columns, 'configFilter', false, false, true)

            handleDestroy()

            // Khi thay đổi kiểu lọc (brand hoặc attribute)
            $('#filter_type').on('change', function() {
                var selectedType = $(this).val();

                if (selectedType === 'attribute') {
                    // Hiện phần "Thuộc tính", ẩn phần "Thương hiệu"
                    $('#attribute-section').show();
                    $('#price-section').hide();
                    $('#brand-section').hide();
                } else if (selectedType == 'brand') {
                    // Hiện phần "Thương hiệu", ẩn phần "Thuộc tính"
                    $('#brand-section').show();
                    $('#attribute-section').hide();
                } else {
                    $('#price-section').show();
                    $('#attribute-section').hide();
                }
            });

            // Mặc định khi load trang, nếu chọn 'brand' sẽ hiển thị phần "Thương hiệu"
            if ($('#filter_type').val() === 'attribute') {
                $('#attribute-section').show();
                $('#brand-section').hide();
            } else {
                $('#attribute-section').hide();
                $('#brand-section').show();
            }

            $('#handleSubmit').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var data = form.serialize();

                $.post(url, data, function(response) {
                    $('#exampleModal').modal('hide');
                    $('#myTable').DataTable().ajax.reload();
                }).fail(function(xhr) {
                    alert('Có lỗi xảy ra!');
                });
            });

            $('button[data-bs-toggle="modal"]').on('click', function() {
                $('#exampleModalLabel').html('Thêm bộ lọc')
                $('#handleSubmit').trigger('reset');
                $('#filter_type').trigger('change');
                $('#handleSubmit').attr('action', '')
                $('.modal').modal('show');
            });

            $(document).on('click', '.btn-edit', function() {
                const resource = $(this).data('resource');

                $.each(resource, function(key, value) {

                    $(`input[name=${key}]`).val(value);

                    if (key == 'filter_type') {
                        $(`select[name=${key}]`).val(value).trigger('change')
                    }

                    if (key == 'attribute_id') {
                        $('#attribute_id').val(value)
                    }
                })

                $('#exampleModalLabel').html('Cập nhật bộ lọc')

                $('#handleSubmit').attr('action', '{{ route('admin.config.config-filter-update', ':id') }}'
                    .replace(':id', resource.id));

                $('.modal').modal('show');
            })
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endpush
