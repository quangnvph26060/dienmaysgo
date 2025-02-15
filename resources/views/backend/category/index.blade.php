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
                            <th><input type="checkbox" id="selectAll" /></th>
                            <th>Tên danh mục</th>
                            <th>Danh mục cha</th>
                            <th>Mô tả</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

    <style>
        #attributeFilter,
        #attributeValueFilter {
            display: none !important
        }

        .select2 {
            width: 265px !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            const api = '{{ route('admin.category.index') }}'

            const columns = [{
                    data: "checkbox",
                    name: "checkbox",
                    orderable: false,
                    searchable: false,
                    width: "5px",
                    className: "text-center"
                },
                {
                    data: 'name',
                    name: 'name'
                },

                {
                    data: 'parent_name',
                    name: 'parent_name',
                    title: 'Danh mục cha'
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
            ];

            dataTables(api, columns, 'SgoProduct', false, false)

            handleDestroy()
        });
    </script>
@endpush
