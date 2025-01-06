@extends('backend.layouts.master')

@section('breadcrumbs')
    @include('components.breadcrumb', [
        'redirect' => ['title' => 'Thuộc tính', 'route' => route('admin.attributes.index')],
        'page' => 'Giá trị thuộc tính',
    ])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <form action="{{ route('admin.attribute-values.store') }}" method="post" id="handleSubmit">
                    <div class="card-header">
                        <h3 class="card-title">Thêm mới</h3>
                    </div>

                    <div class="card-body">
                        <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">

                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" class="form-control" name="value" value="{{ old('value') }}">
                            <small class="text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug <code>Nếu không nhập, giá trị sẽ tự động lấy theo tên</code></label>
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
                        <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm " id="btn-cancel">Hủy</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="table-responsive">
                <table id="myTable" class="display" style="width:100%">
                    <thead>
                        <th><input type="checkbox" /></th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th>Slug</th>
                    </thead>


                </table>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    @include('backend.attribute-value.columns')

    <script>
        $(document).on('click', '.btn-edit', function() {
            const resourceData = $(this).data('resource');

            $.each(resourceData, function(key, value) {
                // Gán giá trị cho các input
                $(`input[name="${key}"]`).val(value);
                // Nếu có textarea
                if ($(`textarea[name="${key}"]`).length) {
                    $(`textarea[name="${key}"]`).val(value);
                }
            });

            $('.card-title').html('Cập nhật')

            $('#handleSubmit').attr('action', "{{ route('admin.attribute-values.update', ':attribute_value') }}"
                .replace(':attribute_value', resourceData.id))
        });

        $(document).ready(function() {

            $('#btn-cancel').on('click', function() {
                $('.card-title').html('Thêm mới')
                $('#handleSubmit')[0].reset();
                $('input, textarea').siblings('small').html('');
                $('#handleSubmit').attr('action', "{{ route('admin.attribute-values.store') }}")
            })

            const api = '{{ route('admin.attribute-values.index') }}?slug={{ request('slug') }}'

            dataTables(api, columns, 'AttributeValue')
            handleDestroy()

            $('#handleSubmit').on('submit', function(e) {
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
                        $('#handleSubmit').attr('action', "{{ route('admin.attribute-values.store') }}")
                        $('#handleSubmit')[0].reset();

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

        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endpush
