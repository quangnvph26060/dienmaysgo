@extends('backend.layouts.master')
@section('title', 'Danh sách đơn hàng')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Danh sách đơn hàng</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="display" style="width:100%">
                    <thead>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Giá</th>
                        <th>Trạng thái</th>
                        <th style="text-align: center">Hành động</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal hiển thị chi tiết đơn hàng -->
    <div class="modal fade" id="productDetailsModal" tabindex="-1" aria-labelledby="productDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailsModalLabel">Chi tiết đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody id="productDetailsList">
                            <!-- Dữ liệu sản phẩm sẽ được chèn vào đây -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.order.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'full_address',
                        name: 'full_address'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                scrollX: true,
            });

            // Xác nhận xóa đơn hàng
            $(document).on('click', '.delete-order-btn', function() {
                let url = $(this).data('url');
                Swal.fire({
                    title: 'Xác nhận',
                    text: "Bạn có chắc chắn muốn xóa đơn hàng này?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Không'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function(response) {
                                if (response.status) {
                                    table.ajax.reload();
                                    Swal.fire({
                                        icon: "success",
                                        title: response.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: response.message
                                    });
                                }
                            }
                        });
                    }
                });
            });

            // Khi nhấn vào nút Chi tiết sản phẩm
            // $(document).on('click', '.detail-product-btn', function() {
            //     var orderId = $(this).data('id');

            //     // Lấy chi tiết đơn hàng~ của đơn hàng
            //     $.ajax({
            //         url: '{{ route('admin.order.detail', ['id' => '__orderId__']) }}'.replace(
            //             '__orderId__', orderId),
            //         type: 'GET',
            //         success: function(response) {
            //             if (response.status) {
            //                 var productDetailsHtml = '';
            //                 response.data.forEach(function(item) {
            //                     function number_format(number, decimals = 0, dec_point =
            //                         '.', thousands_sep = ',') {
            //                         var i, j, kw, kd, km;
            //                         decimals = decimals || 0;
            //                         if (isNaN(number) || number == null) return number;
            //                         number = number.toString().replace(",", "").replace(
            //                             " ", "");
            //                         kw = number.indexOf(".");
            //                         if (kw >= 0) {
            //                             kd = number.substring(kw + 1, kw + 1 +
            //                             decimals);
            //                             number = number.substring(0, kw);
            //                         } else {
            //                             kd = "";
            //                         }
            //                         number = number.replace(/\B(?=(\d{3})+(?!\d))/g,
            //                             thousands_sep);
            //                         return number + (decimals ? dec_point + kd : "");
            //                     }

            //                     productDetailsHtml += '<tr><td>' + item.product_name +
            //                         '</td><td>' + number_format(item.quantity) +
            //                         '</td><td>' + number_format(item.price) +
            //                         ' VND</td><td>' + number_format(item.quantity * item
            //                             .price) + ' VND</td></tr>';

            //                 });
            //                 $('#productDetailsList').html(productDetailsHtml);
            //                 $('#productDetailsModal').modal('show');
            //             } else {
            //                 Swal.fire({
            //                     icon: 'error',
            //                     title: 'Lỗi',
            //                     text: 'Không thể lấy chi tiết đơn hàng.'
            //                 });
            //             }
            //         }
            //     });
            // });
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
@endpush
