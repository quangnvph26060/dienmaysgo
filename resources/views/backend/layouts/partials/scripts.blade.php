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
        // Lấy toàn bộ các menu có submenu
        const menuItems = document.querySelectorAll('.nav-item > a[data-bs-toggle="collapse"]');

        menuItems.forEach(function(menuItem) {
            // Kiểm tra xem đường dẫn của menu có khớp với route hiện tại hay không
            const submenuId = menuItem.getAttribute('href').substring(
                1); // Lấy id của submenu (ví dụ: "order", "product")
            const currentRoute = window.location.pathname;

            // Nếu menu tương ứng với route hiện tại, mở submenu
            if (currentRoute.includes(submenuId)) {
                const collapseElement = document.getElementById(submenuId);
                if (collapseElement) {
                    // Mở submenu bằng cách thêm class 'show' vào collapse
                    collapseElement.classList.add('show');
                }
            }
        });
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    const dataTables = (api, columns, model, filterDate = false, filterCatalogue = false, sortable = false, column ='id') => {
        const table = $('#myTable').DataTable({ // Định nghĩa biến table
            processing: true,
            serverSide: true,
            ajax: {
                url: api,
                data: function(d) {
                    d.startDate = $('#startDate').val() || null;
                    d.endDate = $('#endDate').val() || null;
                    d.catalogue = $('#catalogueFilter').val() || null; // Thêm dữ liệu filter catalogue
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

        if (filterCatalogue) {
            const lengthContainer = document.querySelector('.dt-length');

            if (lengthContainer) {
                const catalogueFilterHtml = `
        <div class="catalogue-filter ms-2 d-flex align-items-center">
            <select id="catalogueFilter" class="form-control w-auto">
                <option value="">Chọn danh mục</option> <!-- Dữ liệu mặc định "Chọn danh mục" -->
            </select>
            <button id="resetCatalogueBtn" class="btn btn-secondary ms-2 btn-sm">Reset</button>
        </div>
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

                        console.log(data);
                        let $select = $('#catalogueFilter');
                        $select.empty(); // Xóa dữ liệu cũ

                        $select.append('<option value="">Chọn danh mục</option>'); // Thêm option mặc định


                        data.forEach(item => {
                            let prefix = '-'.repeat(item.level);
                            let option = `<option value="${item.id}">${prefix} ${item.name}</option>`;
                            $select.append(option); // Thêm từng option vào select
                        });

                        // Khởi tạo lại select2 sau khi đã thêm option
                        // $('#catalogueFilter').select2({
                        //     placeholder: 'Chọn danh mục',
                        //     allowClear: true
                        // });
                    }
                });

                // Khi chọn catalogue, filter bảng
                $('#catalogueFilter').on('change', function() {
                    table.draw();
                });

                // Reset filter
                $('#resetCatalogueBtn').on('click', function() {
                    $('#catalogueFilter').val(null).trigger('change');
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
