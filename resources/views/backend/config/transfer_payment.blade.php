@extends('backend.layouts.master')
@section('title', 'Cấu hình thanh toán')

@section('content')

    <form action="{{ route('admin.config.config-transfer-payment') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-body">

                <div class="form-group mb-3">
                    <label for="" class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control" name="name" value="{{ $config->name }}">
                </div>

                <div class="form-group mb-3">
                    <label for="" class="form-label">Mô tả</label>
                    <textarea name="description" id="" cols="30" rows="3" class="form-control">{{ $config->description }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Tên tài khoản</th>
                                <th>Số tài khoản</th>
                                <th>Tên ngân hàng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($config->account_details['account_name'] as $keys => $account_name)
                                <tr>
                                    <td style="width: 25%">
                                        <input class="form-control" type="text" name="account_details[account_name][]"
                                            value="{{ $account_name }}">
                                    </td>
                                    <td style="width: 30%">
                                        <input class="form-control" type="text" name="account_details[account_number][]"
                                            value="{{ $config->account_details['account_number'][$keys] }}">
                                    </td>
                                    <td>
                                        <select class="form-control select-bank" name="account_details[bank_code][]">
                                            @foreach ($banks as $key => $item)
                                                <option @selected($key == $config->account_details['bank_code'][$keys]) value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="width: 11%">
                                        <button class="btn btn-danger btn-sm btn-delete">Xóa</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <button type="button" class="btn btn-success btn-sm">+ Thêm tài khoản</button>
                                </td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>

        <button class="btn btn-primary btn-sm">Lưu thay đổi</button>
    </form>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        var banks = @json($banks);

        function generateBankOptions(selectedBin = '') {
            let options = `<option value="" selected disabled>Chọn ngân hàng</option>`;
            Object.entries(banks).forEach(([bin, name]) => {
                let selected = (bin === selectedBin) ? 'selected' : '';
                options += `<option value="${bin}" ${selected}>${name}</option>`;
            });
            return options;
        }

        initSelect2();
        updateBankOptions()

        function initSelect2() {
            $(".select-bank").select2({
                placeholder: "Chọn ngân hàng",
                allowClear: true,
                width: '100%',
            }).on('change', function() {
                updateBankOptions();
            });
        }

        function updateBankOptions() {
            $(".select-bank").each(function() {
                let selectedValue = $(this).val();
                $(".select-bank").not(this).each(function() {
                    $(this).find(`option[value="${selectedValue}"]`).prop('disabled', true);
                });
            });
        }

        $(".btn-success").click(function() {
            let newRow = `
        <tr>
            <td style="width: 25%"><input class="form-control" type="text" name="account_details[account_name][]"></td>
            <td style="width: 30%"><input class="form-control" type="text" name="account_details[account_number][]"></td>
            <td>
                <select class="form-control select-bank" name="account_details[bank_code][]">
                    ${generateBankOptions()}
                </select>
            </td>
            <td style="width: 11%">
                <button class="btn btn-danger btn-sm btn-delete">Xóa</button>
            </td>
        </tr>
    `;
            $("tbody").append(newRow);
            initSelect2();
        });

        $(document).on("click", ".btn-delete", function() {
            if ($("tbody tr").length > 1) {
                $(this).closest("tr").remove();
                updateBankOptions();
            } else {
                alert("Phải có ít nhất một hàng!");
            }
        });
    </script>
@endpush
