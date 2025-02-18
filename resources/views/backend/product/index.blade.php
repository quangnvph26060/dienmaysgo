@extends('backend.layouts.master')

@section('title', 'Danh sách sản phẩm')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Danh sách sản phẩm</h4>
            <div class="card-tools">
                {{-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Import
                </button> --}}
                <a href="{{ route('admin.product.add') }}" class="btn btn-primary btn-sm">Thêm mới sản phẩm (+)</a>
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="table-responsive"> --}}
                <table id="myTable" class="display" style="width:100%">
                    <thead>
                        <th></th>
                        <th><input type="checkbox" id="selectAll" /></th>
                        <th>TÊN</th>
                        <th>SỐ LƯỢNG</th>
                        <th>GIÁ NHẬP (VND)</th>
                        <th>GIÁ BÁN (VND)</th>
                        <th>DANH MỤC</th>
                        <th>LƯỢT XEM</th>
                    </thead>
                </table>
            {{-- </div> --}}
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.product.import-data') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="file" id="file" class="form-control" required>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    @include('backend.product.columns')

    <script>
        function extractPrice(priceString) {
            return priceString.split(' ')[0];
        }

        $(document).on('input', '#price, #discount_value', function() {
            let value = $(this).val().replace(/\D/g, ''); // Chỉ lấy số
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Thêm dấu .
            $(this).val(value);
        });

        function format(d) {
            // Tạo một thẻ div tạm để xử lý chuỗi HTML
            // var tempDiv = $('<div>').html(d.name);
            // var nameText = tempDiv.find('strong').text();
            let price = extractPrice(d.price);
            let imgae = "{{ env('APP_URL') }}" + '/storage/' + d.image


            return `
                <form id="editProductForm" enctype="multipart/form-data">
                    <div class="row">

                        <div class="mb-3 col-2">
                            <label for="image" class="form-label">Ảnh danh mục</label>
                            <img class="img-fluid img-thumbnail w-100" id="show_image" style="cursor: pointer"
                            src="${imgae}" alt=""
                            onclick="document.getElementById('logo').click();">
                            <input type="file" name="image" id="logo" class="form-control d-none"
                                accept="image/*" onchange="previewImage(event, 'show_image')">
                        </div>

                        <div class="col-10">
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label for="name" class="form-label">Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control" id="name" value="${d.name}">
                                </div>
                                <div class="mb-3 col-3">
                                    <label for="price" class="form-label">Giá</label>
                                    <input type="text" name="price" class="form-control" id="price" value="${price}">
                                </div>
                                <div class="mb-3 col-3">
                                    <label for="quantity" class="form-label">Số lượng</label>
                                    <input type="number" name="quantity" class="form-control" id="quantity" value="${d.quantity}">
                                </div>
                                <div class="mb-3 col-3">
                                    <label for="discount_value" class="form-label">Giảm giá</label>
                                    <input type="text" class="form-control" name="discount_value" id="discount_value" value="${parseFloat(d.discount_value).toLocaleString('vi-VN')}">
                                </div>
                                <div class="mb-3 col-3">
                                    <label for="discount_type" class="form-label">Loại giảm giá</label>
                                    <select class="form-select" id="discount_type" name="discount_type">
                                        <option value="percentage" ${d.discount_type === 'percentage' ? 'selected' : ''}>Giảm %</option>
                                        <option value="amount" ${d.discount_type === 'amount' ? 'selected' : ''}>Giảm tiền</option>
                                    </select>

                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                                    <button type="button" class="btn btn-secondary btn-sm" id="cancelEditBtn">Hủy</button>
                                </div>
                            </div>
                        </div>


                    </div>

                </form>
            `;
        }


        $(document).ready(function() {
            const api = '{{ route('admin.product.index') }}'

            dataTables(api, columns, 'SgoProduct', false, true)

            handleDestroy()

            // $(document).on('click', '.fas.fa-pen-alt', function() {
            //     // Đặt lại các ô khác về trạng thái ban đầu
            //     $('.price-input').each(function() {
            //         const originalPrice = $(this).val() + ' VND';
            //         const penIcon = '<i class="fas fa-pen-alt ms-2 pointer"></i>';
            //         $(this).closest('td').html(originalPrice + penIcon);
            //     });

            //     let id = $(this).data('id');

            //     // Lấy giá trị của giá sản phẩm
            //     const currentPrice = $(this).closest('td').text().trim().replace(' VND', '');

            //     // Tạo ô input cho giá sản phẩm
            //     const inputField =
            //         `<input type="text" class="form-control price-input" data-id="${id}" inputmode="numeric" value="${currentPrice}" />`;

            //     // Thay thế giá trị hiện tại bằng ô input
            //     $(this).closest('td').html(inputField);

            //     // Đặt focus vào ô input
            //     $(this).closest('td').find('.price-input').focus();
            // });

            function formattedNumber(number) {
                return parseInt(number.replaceAll('.', ''), 10);
            }


            $(document).on({
                input: function() {
                    let input = $(this);
                    let value = input.val().replace(/\D/g, ''); // Loại bỏ tất cả ký tự không phải số
                    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Thêm dấu chấm định dạng
                    input.val(value); // Gán lại giá trị đã định dạng
                },
                keydown: function(e) {
                    if (e.key === 'Enter') {
                        const input = $(this);
                        const newPrice = input.val().trim(); // Lấy giá trị mới từ ô input
                        const productId = input.data('id'); // Giả sử `tr` có data-id là id của sản phẩm

                        // Gọi API để cập nhật giá
                        $.ajax({
                            url: "{{ route('admin.product.handle-change-price', ':id') }}"
                                .replace(
                                    ':id',
                                    productId), // Thay bằng URL API của bạn
                            type: 'POST',
                            data: {
                                price: formattedNumber(newPrice)
                            },
                            success: function(response) {
                                if (response.status) {
                                    // Cập nhật lại giá trị trong ô
                                    const penIcon =
                                        `<i class="fas fa-pen-alt ms-2 pointer" data-id="${productId}"></i>`;
                                    input.closest('td').html(response.price + penIcon);
                                } else {
                                    alert('Cập nhật giá không thành công!');
                                    alert(response.message)
                                    const penIcon =
                                        `<i class="fas fa-pen-alt ms-2 pointer" data-id="${productId}"></i>`;
                                    input.closest('td').html(response.price + penIcon);
                                }
                            },
                            error: function() {
                                alert('Có lỗi xảy ra khi cập nhật giá!');
                            }
                        });
                    }
                }
            }, '.price-input');
        })
    </script>
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        .img-thumbnail {}

        .select2 {
            width: 265px !important;
        }

        #attributeFilter,
        #attributeValueFilter {
            padding: 0.3rem 1rem !important;
        }
    </style>
@endpush
