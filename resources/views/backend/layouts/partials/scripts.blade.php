<!-- Fonts and icons -->
<script src="{{ asset('backend/assets/js/plugin/webfont/webfont.min.js') }}"></script>
<script>
    WebFont.load({
        google: {
            families: ["Public Sans:300,400,500,600,700"]
        },
        custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["{{ asset('backend/assets/css/fonts.min.css') }}"],
        },
        active: function() {
            sessionStorage.fonts = true;
        },
    });
</script>
<!--   Core JS Files   -->

<script src="{{ asset('backend/assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/core/bootstrap.min.js') }}"></script>


<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<!-- jQuery Scrollbar -->
<script src="{{ asset('backend/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('backend/assets/js/plugin/chart.js/chart.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('backend/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Chart Circle -->
<script src="{{ asset('backend/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('backend/assets/js/plugin/datatables/datatables.min.js') }}"></script>

<!-- Bootstrap Notify -->
<script src="{{ asset('backend/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('backend/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/plugin/jsvectormap/world.js') }}"></script>

<!-- Sweet Alert -->
{{-- <script src="{{ asset('backend/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script> --}}

<!-- Kaiadmin JS -->
<script src="{{ asset('backend/assets/js/kaiadmin.min.js') }}"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="{{ asset('backend/assets/js/setting-demo.js') }}"></script>
{{-- <script src="{{ asset('backend/assets/js/demo.js') }}"></script> --}}

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy tất cả các menu con (các thẻ <a> bên trong .nav-item)
        let currentMenuItem = document.querySelector(".nav-item .active");

        if (currentMenuItem) {
            // Tìm phần tử cha có class "has-children"
            let parentCollapse = currentMenuItem.closest(".collapse");

            if (parentCollapse) {
                // Mở menu cha bằng cách thêm class "show"
                parentCollapse.classList.add("show");

                // Mở mũi tên caret nếu có
                let parentNavItem = parentCollapse.closest(".nav-item");
                if (parentNavItem) {
                    parentNavItem.querySelector("[data-bs-toggle='collapse']")?.classList.remove("collapsed");
                }
            }
        }
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    const dataTables = (api, columns, model, filterDate = false, productFilter = false, sortable = false, column =
        'id') => {


        let params = localStorage.getItem("params") || null; // Lấy giá trị của 'params'

        if (params && window.location.href !== "{{ env('APP_URL') }}/admin/product") {
            localStorage.removeItem("params"); // Xóa params khỏi localStorage
        }


        const table = $('#myTable').DataTable({ // Định nghĩa biến table
            processing: true,
            serverSide: true,
            ajax: {
                url: api,
                data: function(d) {
                    d.startDate = $('#startDate').val() || null;
                    d.endDate = $('#endDate').val() || null;
                    d.catalogue = $('#catalogueFilter').val() || params;
                    d.attributeId = $('#attributeFilter').val() || null;
                    d.attributeValueId = $('#attributeValueFilter').val() || null;
                }
            },
            columns: columns,
            "createdRow": function(row, data, dataIndex) {
                $(row).attr('data-id', data.id); // Gán data-id bằng giá trị id của sản phẩm
            },
            "drawCallback": function() {
                // Kiểm tra xem có cần khởi tạo sortable hay không
                if (sortable) {
                    // Khởi tạo SortableJS mỗi khi DataTables vẽ lại bảng
                    new Sortable(document.querySelector('#myTable tbody'), {
                        handle: 'td', // Vùng kéo thả
                        onEnd: function(evt) {
                            var order = [];
                            $('#myTable tbody tr').each(function() {
                                order.push($(this).data('id'));
                            });

                            // Gửi yêu cầu cập nhật thứ tự lên server
                            updateOrderInDatabase(order, model);
                        }
                    });
                }
            },
            order: [],
        });

        $(document).on('click', '#cancelEditBtn', function() {
            // Đóng form mà không lưu thay đổi
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            row.child.hide();
        });

        $(document).on('submit', '#editProductForm', function(e) {
            e.preventDefault();

            let formDataArray = new FormData(this)

            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let productData = row.data();

            formDataArray.append('id', productData.id);

            $.ajax({
                url: '{{ route('admin.product.modify-product') }}',
                type: 'POST',
                data: formDataArray,
                processData: false, // Không xử lý dữ liệu (quan trọng khi gửi file)
                contentType: false, // Không đặt Content-Type mặc định
                success: function(response) {
                    if (response.success) {
                        table.draw();
                    } else {
                        alert(response.message)
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });

        });


        table.on('requestChild.dt', function(e, row) {
            row.child(format(row.data())).show();
        });

        table.on('click', 'td.dt-control', function(e) {
            let tr = e.target.closest('tr');
            let row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
            } else {
                // Open this row
                row.child(format(row.data())).show();
            }
        });

        function updateOrderInDatabase(order, model) {
            $.ajax({
                url: '{{ route('admin.changeOrder') }}',
                method: 'POST',
                data: {
                    order: order,
                    model: model,
                },
                success: function(response) {
                    console.log('Cập nhật thứ tự thành công');
                },
                error: function(error) {
                    console.log('Có lỗi xảy ra:', error);
                }
            });
        }


        $('label[for="dt-length-0"]').remove();

        const targetDiv = $('.dt-layout-cell.dt-layout-start');

        let _html = `
        <div id="actionDiv" style="display: none;">
            <div class="d-flex">
                <select id="actionSelect" class="form-select">
                    <option value="">-- Chọn hành động --</option>
                    <option value="delete">Xóa</option>
                </select>
                <button id="applyAction" class="btn btn-outline-danger btn-sm">Apply</button>
            </div>
        </div>
    `;

        targetDiv.after(_html);

        if (filterDate) {
            const lengthContainer = document.querySelector('.dt-length');

            if (lengthContainer) {
                // Tạo input filter
                const filterHtml = `
                    <div class="date-filter ml-2 d-flex align-items-center">
                        <input type="date" id="startDate" class="form-control d-inline-block w-auto" placeholder="Start Date">
                        <input type="date" id="endDate" class="form-control d-inline-block w-auto ms-2" placeholder="End Date">
                        <button id="filterBtn" class="btn btn-primary ms-2 btn-sm"><i class="fa-solid fa-filter"></i></button>
                        <button id="resetBtn" class="btn btn-secondary ms-2 btn-sm">Reset</button>
                    </div>
                `;

                // Thêm sau `.dt-length`
                lengthContainer.insertAdjacentHTML('afterend', filterHtml);

                $('#filterBtn').on('click', function() {
                    const startDate = $('#startDate').val();
                    const endDate = $('#endDate').val();

                    if (startDate && endDate && endDate < startDate) {
                        alert('Ngày kết thúc không thể nhỏ hơn ngày bắt đầu!');
                        return;
                    }

                    // Nếu cả hai trường rỗng, không làm gì cả
                    if (!startDate && !endDate) {
                        alert('Vui lòng nhập Start Date và End Date để lọc!');
                        return;
                    }

                    table.draw();
                });

                $('#resetBtn').on('click', function() {
                    if ($('#startDate').val() || $('#endDate').val()) {
                        $('#startDate').val('');
                        $('#endDate').val('');
                        table.draw();
                    }
                });
            }
        }

        if (productFilter) {
            const lengthContainer = document.querySelector('.dt-length');

            if (lengthContainer) {
                const catalogueFilterHtml = `
                <div class="catalogue-filter ms-2 d-flex align-items-center">
                    <select id="catalogueFilter" class="form-control w-auto">
                        <option value="">Chọn danh mục</option> <!-- Dữ liệu mặc định "Chọn danh mục" -->
                    </select>
                </div>

                <div class="attribute-filter ms-2 d-flex align-items-center">
                    <select id="attributeFilter" class="form-control w-auto">
                        <option value="">Chọn thuộc tính</option>
                    </select>
                    <select id="attributeValueFilter" class="form-control w-auto d-none ms-2">
                        <option value="">Chọn giá trị</option>
                    </select>
                </div>

                <button id="resetCatalogueBtn" class="btn btn-secondary ms-2 btn-sm">Reset</button>
            `;

                lengthContainer.insertAdjacentHTML('afterend', catalogueFilterHtml);

                // Initialize Select2 với dữ liệu mặc định
                $('#catalogueFilter').select2({
                    placeholder: 'Chọn danh mục',
                    allowClear: true,
                    minimumInputLength: 0 // Không cần nhập ký tự để hiển thị dữ liệu
                });

                // Gọi API một lần để lấy tất cả danh mục và thêm vào Select2
                $.ajax({
                    url: "{{ route('admin.product.categories.index') }}", // API lấy danh mục
                    dataType: 'json',
                    success: function(data) {

                        let $select = $('#catalogueFilter');
                        $select.empty(); // Xóa dữ liệu cũ

                        $select.append(
                            '<option value="">Chọn danh mục</option>'); // Thêm option mặc định

                        data.forEach(item => {
                            let prefix = '-'.repeat(item.level);
                            let option =
                                `<option ${item.id == params ? 'selected' : ''} value="${item.id}">${prefix} ${item.name}</option>`;
                            $select.append(option); // Thêm từng option vào select
                        });

                    }
                });


                $.ajax({
                    url: "{{ route('admin.product.attributes.index') }}",
                    dataType: 'json',
                    success: function(data) {
                        let $select = $('#attributeFilter');
                        $select.empty().append('<option value="">Chọn thuộc tính</option>');
                        data.forEach(attr => {
                            $select.append(`<option value="${attr.id}">${attr.name}</option>`);
                        });
                    }
                });

                $('#attributeFilter').on('change', function() {
                    let attributeId = $(this).val();
                    let $valueSelect = $('#attributeValueFilter');

                    if (!attributeId) {
                        $valueSelect.addClass('d-none').empty();
                        return;
                    }

                    $.ajax({
                        url: `{{ url('/admin/product/attributes') }}/${attributeId}/values`,
                        dataType: 'json',
                        success: function(data) {
                            $valueSelect.removeClass('d-none').empty().append(
                                '<option value="">Chọn giá trị</option>');
                            data.forEach(value => {
                                $valueSelect.append(
                                    `<option value="${value.id}">${value.value}</option>`
                                );
                            });
                        }
                    });
                });

                // function removeQueryParam(param) {
                //     let url = new URL(window.location.href);
                //     url.searchParams.delete(param);

                //     // Cập nhật URL mà không load lại trang
                //     window.history.replaceState({}, document.title, url.pathname + url.search);

                //     // Cập nhật lại giá trị params
                //     let urlParams = new URLSearchParams(window.location.search);
                //     params = urlParams.get('params') || null;

                // }


                $('#catalogueFilter').on('change', function() {
                    localStorage.removeItem("params");
                    params = null;
                });


                // Khi chọn catalogue, filter bảng
                $('#catalogueFilter,#attributeFilter, #attributeValueFilter').on('change', function() {
                    table.draw();
                });

                // Reset filter
                $('#resetCatalogueBtn').on('click', function() {

                    if ($('#catalogueFilter').val() == '' && $('#attributeFilter').val() == '')
                        return false;

                    // Reset các select2
                    $('#catalogueFilter').val('').trigger(
                        'change'); // Cập nhật lại giá trị của Select2 và trigger sự kiện
                    $('#attributeFilter').val('').trigger(
                        'change'); // Cập nhật lại giá trị của Select2 và trigger sự kiện

                    // Ẩn ô chọn giá trị thuộc tính
                    $('#attributeValueFilter').addClass('d-none').empty();

                    // Reset bảng dữ liệu
                    table.draw();
                });

            }
        }


        $('#myTable thead input[type="checkbox"]').on('click', function() {
            const isChecked = $(this).prop('checked');
            $('#myTable tbody input[type="checkbox"]').prop('checked', isChecked);
            toggleActionDiv();
        });

        $('#myTable tbody').on('click', 'input[type="checkbox"]', function() {
            const allChecked = $('#myTable tbody input[type="checkbox"]').length === $(
                '#myTable tbody input[type="checkbox"]:checked').length;
            $('#myTable thead input[type="checkbox"]').prop('checked', allChecked);
            toggleActionDiv();
        });

        $('#applyAction').on('click', function() {
            const selectedAction = $('#actionSelect').val();

            if (!selectedAction) return;

            const selectedIds = $('.row-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedAction === 'delete') {
                $.ajax({
                    url: "{{ route('admin.delete.items') }}",
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        model: model,
                        column: column
                    },
                    success: function(response) {
                        alert('Xóa thành công!');
                        table.ajax
                            .reload(); // Sử dụng biến table thay vì gọi lại $('#myTable').DataTable()
                        $('input[type="checkbox"]').prop('checked', false);
                        toggleActionDiv();
                    },
                    error: function() {
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                });
            }
        });
    };


    function toggleActionDiv() {
        if ($('.row-checkbox:checked').length > 0) {

            $('#actionDiv').show();
        } else {
            $('#actionDiv').hide();
        }
    }

    const handleDestroy = () => {
        $('tbody').on('click', '.btn-destroy', function(e) {
            e.preventDefault();

            if (confirm('Chắc chắn muốn xóa?')) {
                var form = $(this).closest('form');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        $('#myTable').DataTable().ajax.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(jqXHR)
                    }
                });
            }
        });
    }

    const formatDataInput = function(input) {
        let $input = $(`#${input}`);

        // Hàm format số theo định dạng tiền tệ Việt Nam
        function formatNumber(value) {
            return Number(value).toLocaleString("vi-VN");
        }

        // Format ngay khi trang load nếu có giá trị
        let initialValue = $input.val().replace(/\./g, "");
        if (!isNaN(initialValue) && initialValue !== "") {
            $input.val(formatNumber(initialValue));
        }

        // Lắng nghe sự kiện nhập liệu
        $input.on('input', function() {
            let value = $(this).val().replace(/\./g, ""); // Xóa dấu chấm cũ
            if (!isNaN(value)) {
                $(this).val(formatNumber(value)); // Format lại số
            } else {
                $(this).val($(this).val().slice(0, -1)); // Xóa ký tự không hợp lệ
            }

            // Cập nhật giá trị vào input ẩn nếu cần
            console.log(`name=[${input.slice(5)}]`);
            console.log(value.replace(/\./g, ""));


            $(`input[name=${input.slice(5)}]`).val(value.replace(/\./g, ""));
        });
    };

    const previewImage = function(event, imgId) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function() {
            const imgElement = document.getElementById(imgId);
            imgElement.src = reader.result;
        }
        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@include('backend/includes/alert')

@stack('scripts')
