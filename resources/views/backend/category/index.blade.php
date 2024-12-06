@extends('backend.layouts.master')

@section('content')
<div class="content">
    <!-- Bảng danh sách danh mục -->
    <div class="category-list">
        <table class="table table-striped table-hover" id="categoryTable">
            <thead>
                <tr>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Danh mục cha</th>
                    <th>Hành động</th>
                </tr>
            </thead>
        </table>
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
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> --}}

<script type="text/javascript">
    $(document).ready(function () {
        $('#categoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.category.index') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description', render: function(data, type, row) {
                    return data;  // Không cần xử lý thêm, vì dữ liệu đã là HTML
                }},
                { data: 'parent_name', name: 'parent_name', title: 'Danh mục cha' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            columnDefs: [
                { width: '20%', targets: 0 }, // Cột Name chiếm 20% độ rộng bảng
                { width: '45%', targets: 1 }, // Cột Description chiếm 30%
                { width: '20%', targets: 2 }, // Cột Category Parent ID chiếm 25%
                { width: '15%', targets: 3 }  // Cột Actions chiếm 25%
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
            lengthMenu: [10, 25, 50, 100],
        });
    });
</script>
@endpush
