@extends('backend.layouts.master')

@section('content')
<div class="content">
    <!-- Bảng danh sách danh mục -->
    <div class="row">
        <!-- Bảng danh sách -->
        <div class="col-md-8">
            <div class="category-list">
                <table class="table table-striped table-hover" id="originTable">
                    <thead>
                        <tr>
                            <th>Nhiên liệu</th>
                            <th>Mô tả</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Form sửa/xóa -->
        <div class="col-md-4">
            <div id="formContainer" class="card">
                <div class="card-header">
                    <span id="formTitle">Thêm mới nhiên liệu</span>
                </div>
                <div class="card-body">
                    <form id="fuelForm">
                        @csrf
                        <input type="hidden" id="itemId" name="id">

                        <div class="mb-3">
                            <label for="fuelName" class="form-label">Tên nhiên liệu</label>
                            <input type="text" class="form-control" id="fuelName" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="fuelDescription" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="fuelDescription" name="description" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitButton">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    td a{
        padding: 8px 11px !important;
        border-radius: 5px;
        color: white;
        display: inline-block;
    }
    .edit{
        background: #ffc107;
        margin: 0px 15px;
    }
    .delete{
        background: #dc3545;
        padding: 8px 12px !important;
    }
</style>
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet"> --}}
@endpush

@push('scripts')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> --}}
<!-- Bao gồm SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
   $(document).ready(function () {
    let table = $('#originTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('admin.fuel.index') }}',
    columns: [
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
        {
            data: 'id',
            name: 'action',
            render: function (data) {
                return `
                    <div style="display:flex">
                        <a href="javascript:void(0)" class="edit btn btn-warning btn-sm" data-id="${data}"><i class="fas fa-edit" title="Sửa"></i></a>
                        <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="${data}"><i class="fas fa-trash" title="Xóa"></i></a>
                    </div>`;
            },
            orderable: false,
            searchable: false,
        },
    ],
    columnDefs: [
        { width: '25%', targets: 0 }, // Cột Name chiếm 30% độ rộng bảng
        { width: '55%', targets: 1 }, // Cột Description chiếm 50%
        { width: '20%', targets: 2 }, // Cột Action chiếm 20%
    ],
    pagingType: "full_numbers", // Kiểu phân trang
    language: {
        paginate: {
            previous: '&laquo;', // Nút trước
            next: '&raquo;'      // Nút sau
        },
        lengthMenu: "Hiển thị _MENU_ mục mỗi trang",
        zeroRecords: "Không tìm thấy dữ liệu",
        info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
        infoEmpty: "Không có dữ liệu để hiển thị",
        infoFiltered: "(lọc từ _MAX_ mục)"
    },
    dom: '<"row"<"col-md-6"l><"col-md-6"f>>t<"row"<"col-md-6"i><"col-md-6"p>>',
    lengthMenu: [10, 25, 50, 100],  // Menu lựa chọn số lượng mục hiển thị mỗi trang
});


    // Reset form về trạng thái thêm mới
    function resetForm() {
        $('#fuelForm')[0].reset();
        $('#itemId').val('');
        $('#formTitle').text('Thêm mới nhiên liệu');
        $('#submitButton').text('Thêm mới');
    }

    // Xử lý thêm hoặc sửa
    $('#fuelForm').submit(function (e) {
        e.preventDefault();
        const id = $('#itemId').val();
        const url = id
            ? `{{ route('admin.fuel.update', ':id') }}`.replace(':id', id)
            : '{{ route('admin.fuel.store') }}';
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            success: function () {
                table.ajax.reload();
                resetForm();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });
    });

    // Load dữ liệu vào form sửa
    $('#originTable').on('click', '.edit', function () {
        const id = $(this).data('id');
        $.ajax({
            url: `{{ route('admin.fuel.edit', ':id') }}`.replace(':id', id),
            method: 'GET',
            success: function (data) {
                $('#formTitle').text('Sửa nhiên liệu');
                $('#submitButton').text('Cập nhật');
                $('#itemId').val(data.id);
                $('#fuelName').val(data.name);
                $('#fuelDescription').val(data.description);
            },
        });
    });

    // Khi form được reset (nút Thêm mới được click)
    $('#resetButton').click(function () {
        resetForm();
    });

    //xóa
    $('#originTable').off('click', '.delete');

// Gắn sự kiện xóa với SweetAlert2
    $('#originTable').on('click', '.delete', function () {
        const id = $(this).data('id'); // Lấy id từ nút delete

        // Hiển thị hộp thoại xác nhận SweetAlert2
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: 'Hành động này không thể hoàn tác!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Nếu người dùng xác nhận
                $.ajax({
                    url: `{{ route('admin.fuel.delete', ':id') }}`.replace(':id', id),
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // CSRF token bảo vệ
                    },
                    success: function (response) {
                        Swal.fire({
                            title: 'Thành công!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reload DataTable sau khi đóng thông báo
                            table.ajax.reload();
                            resetForm();
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Đã có lỗi xảy ra!',
                            text: 'Vui lòng thử lại.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
});


</script>
@endpush
