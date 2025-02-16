@extends('backend.layouts.master')

@section('title', 'Danh sách danh mục')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Danh sách danh mục</h4>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Vị trí hiển thị
                </button>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thay đổi vị trí hiện thị của các danh mục cha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-striped" id="change-location">
                        <thead>
                            <tr>
                                <th>Tên danh mục</th>
                                <th>Vị trí</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-table">
                            @foreach ($parents as $item)
                                <tr data-id="{{ $item['id'] }}">
                                    <td>{{ $item['name'] }}</td>
                                    <td class="location">{{ $item['location'] ?? '---' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
            var sortable = new Sortable(document.getElementById("sortable-table"), {
                animation: 150,
                onEnd: function() {
                    let order = [];
                    $("#sortable-table tr").each(function(index) {
                        order.push($(this).data("id"));

                        // Cập nhật số thứ tự hiển thị trên giao diện
                        $(this).find(".location").text(index + 1);
                    });

                    // Gửi AJAX request cập nhật thứ tự
                    $.ajax({
                        url: "{{ route('admin.changeOrder') }}",
                        type: "POST",
                        data: {
                            order: order,
                            model: 'SgoCategory',
                        },
                        success: function(response) {
                            console.log("Cập nhật thành công:", response);
                        },
                        error: function(error) {
                            console.error("Lỗi:", error);
                        }
                    });
                }
            });
        });


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

            dataTables(api, columns, 'SgoCategory', false, false)

            handleDestroy()
        });
    </script>
@endpush
