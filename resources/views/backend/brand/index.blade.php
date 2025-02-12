@extends('backend.layouts.master')
@section('title', 'Danh sách thương hiệu')

@section('content')
    <div>
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <form action="{{ route('admin.brands.store') }}" method="post" id="myForm">
                        <div class="card-header">
                            <h3 class="card-title">Thêm mới</h3>
                        </div>

                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">Tên thương hiệu</label>
                                <input type="text" placeholder="Tên thương hiệu" class="form-control" name="name">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug <code>Nếu không nhập, giá trị
                                        sẽ tự
                                        động lấy theo tên</code></label>
                                <input type="text" class="form-control" name="slug">
                                <small class="text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label for="description">Mô tả ngắn <code>Tối đa 28 ký tự, tối thiểu 5 ký tự</code></label>
                                <textarea name="description" id="description" cols="30" rows="3" class="form-control"></textarea>
                                <small class="text-danger"></small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Thêm thuộc tính</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm " id="btn-cancel">Hủy</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-7">
                <div class="table-responsive">
                    <table id="myTable" class="display" style="width:100%">
                        <thead>
                            <th><input type="checkbox" id="selectAll" /></th>
                            <th>Tên</th>
                            <th>Slug</th>
                            <th>Mô tả</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    @include('backend.brand.columns')

    <script>
        $(document).ready(function() {
            $('#btn-cancel').on('click', function() {
                $('.card-title').html('Thêm mới')
                $('#myForm')[0].reset();
                $('input').siblings('small').html('');
                $('#myForm').attr('action',
                    "{{ route('admin.brands.store') }}")
            })

            const api = '{{ route('admin.brands.index') }}'
            dataTables(api, columns, 'Brand')

            handleDestroy()

            $('#myForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this).serialize();

                const method = $('.card-title').html() == 'Cập nhật' ? 'PUT' : 'POST';

                $.ajax({
                    url: $(this).attr('action'),
                    method: method,
                    data: form,
                    success: function(response) {
                        $('#myTable').DataTable().ajax.reload();
                        $('input, textarea').siblings('small').html('');
                        $('.card-title').html('Thêm mới')
                        $('#myForm').attr('action',
                            "{{ route('admin.brands.store') }}")
                        $('#myForm')[0].reset();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status == 422) {
                            $('input, textarea').siblings('small').html('');

                            $.each(jqXHR.responseJSON.errors, function(key, value) {
                                $(`input[name="${key}"], textarea[name="${key}"]`)
                                    .siblings('small').html(value)
                            })
                            return
                        }

                        alert('Đã có lỗi xảy ra! Vui lòng thực hiện lại sau.')
                    }

                })

            })

            $(document).on('click', '.btn-edit', function() {
                const resourceData = $(this).data('resource');

                $.each(resourceData, function(key, value) {
                    $(`input[name="${key}"]`).val(value);

                    if ($(`textarea[name="${key}"]`).length) {
                        $(`textarea[name="${key}"]`).val(value);
                    }
                });

                $('.card-title').html('Cập nhật')

                $('#myForm').attr('action',
                    "{{ route('admin.brands.update', ':brand') }}"
                    .replace(':brand', resourceData.id))
            });


        })
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endpush
