@extends('backend.layouts.master')

@section('title', 'Danh sách danh mục')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Danh sách danh mục</h4>
            <div class="card-tools">
                <a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-sm">Thêm mới (+)</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="display" style="width:100%">
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
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.category.index') }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function(data, type, row) {
                            return data;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'parent_name',
                        name: 'parent_name',
                        title: 'Danh mục cha'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                "createdRow": function(row, data, dataIndex) {
                    $(row).attr('data-id', data.id); // Gán data-id bằng giá trị id của sản phẩm
                },
                "drawCallback": function() {
                    // Khởi tạo SortableJS mỗi khi DataTables vẽ lại bảng
                    new Sortable(document.querySelector('#myTable tbody'), {
                        handle: 'td', // Vùng kéo thả
                        onEnd: function(evt) {
                            var order = [];
                            $('#myTable tbody tr').each(function() {
                                order.push($(this).data('id'));
                            });

                            // Gửi yêu cầu cập nhật thứ tự lên server
                            updateOrderInDatabase(order);
                        }
                    });
                },
                order: [],
            });

            function updateOrderInDatabase(order) {
                console.log(order);

            }
        });
    </script>
@endpush
