@extends('backend.layouts.master')
@section('title', 'Cấu hình thanh toán')

@section('content')
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.config.index') }}">Cấu hình chung</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.config.config-payment') }}">Cấu hình thanh toán</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.config.config-slider') }}">Cấu hình trình chiếu</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.config.config-filter') }}">Cấu hình bộ lọc</a>
        </li>
    </ul>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Phương thức thanh toán</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 20%">Phương thức</th>
                        <th style="width: 10%">Đã bật</th>
                        <th>Mô tả</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($configPayments as $item)
                        <tr>
                            <td data-resource="{{ $item }}" class="text-primary" style="cursor: pointer">
                                {{ $item->name }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input handleChecked" type="checkbox"
                                        id="flexSwitchCheckChecked" @checked($item->published)>
                                </div>
                            </td>
                            <td>
                                {{ $item->description ?? '_________' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post" id="handleSubmit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật phương thức thanh toán</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <small class="text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="name">Mô tả</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                            <small class="text-danger"></small>
                        </div>

                        <div class="form-group">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="published" id="published">
                                <label for="">Trạng thái</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary btn-sm">Lưu thay đổi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('body').on('click', '.text-primary', function() {

                const resource = $(this).data('resource')

                $('#handleSubmit').attr('data-id', resource.id)

                $.each(resource, (key, value) => {

                    $(`input[name="${key}"], textarea[name="${key}"]`).val(value);

                })

                if (resource.id == 3) {

                    let _html =
                        `
                            <div class="form-group">
                                <label for="payment_percentage">% trả trước</label>
                                <input type="number" name="payment_percentage" id="payment_percentage" value="${parseInt(resource.payment_percentage)}" class="form-control">
                            </div>
                        `;

                    $('input[name="payment_percentage"]').length == 0 ? $('textarea[name="description"]')
                        .closest('.form-group').append(_html) : ''

                } else {
                    $('input[name="payment_percentage"]').closest('.form-group').remove();
                }

                let checked = resource.published;

                $('input[name="published"]').attr('checked', checked);

                $('#exampleModal').modal('show');
            })

            $(document).on('change', '.handleChecked', function() {
                const $checkbox = $(this);
                const resource = $(this).closest('tr').find('.text-primary').data('resource');
                const initialChecked = $checkbox.prop('checked');

                const id = resource.id;

                $.ajax({
                    url: `{{ route('admin.config.handle-change-publish-payment') }}`,
                    method: 'PUT',
                    data: {
                        id
                    },
                    success: function(response) {
                        resource.published = response.published;

                    },
                    error: function(error) {

                        $checkbox.prop('checked', !initialChecked);
                    }
                })

            })

            $('#handleSubmit').on('submit', function(e) {
                e.preventDefault();

                let form = $(this).serializeArray();

                form.push({
                    name: 'id',
                    value: $(this).attr('data-id')
                })

                $.ajax({
                    url: "{{ route('admin.config.config-payment') }}",
                    method: 'POST',
                    data: form,
                    success: function(response) {
                        location.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.errors.length == 0) return false;
                        $(`input, textarea`).next()
                            .text('');

                        $.each(error.responseJSON.errors, function(key, value) {
                            $(`input[name="${key}"], textarea[name="${key}"]`).next()
                                .text(value)
                        })
                    }
                })
            })
        });
    </script>
@endpush
