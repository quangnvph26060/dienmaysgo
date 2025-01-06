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
    document.addEventListener('DOMContentLoaded', function() {
        const collapsibleMenus = document.querySelectorAll('.nav-item > a[data-bs-toggle="collapse"]');

        // Đọc trạng thái từ local storage
        const activeMenu = localStorage.getItem('activeMenu');
        if (activeMenu) {
            const target = document.querySelector(activeMenu);
            if (target) {
                target.classList.add('show');
                const parentLi = target.closest('.nav-item');
                if (parentLi) {
                    parentLi.classList.add('active');
                }
            }
        }

        collapsibleMenus.forEach(menu => {
            menu.addEventListener('click', function() {
                // Đóng tất cả menu khác
                collapsibleMenus.forEach(otherMenu => {
                    const targetId = otherMenu.getAttribute('href');
                    const target = document.querySelector(targetId);
                    if (target && targetId !== this.getAttribute('href')) {
                        target.classList.remove('show');
                        const parentLi = otherMenu.closest('.nav-item');
                        if (parentLi) parentLi.classList.remove('active');
                    }
                });

                // Thêm active cho menu đang mở
                const parentLi = this.closest('.nav-item');
                parentLi.classList.toggle('active');

                // Lưu trạng thái vào local storage
                if (parentLi.classList.contains('active')) {
                    localStorage.setItem('activeMenu', this.getAttribute('href'));
                } else {
                    localStorage.removeItem('activeMenu');
                }
            });
        });
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    const dataTables = (api, columns, model) => {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: api,
            columns: columns,
            order: [],
        });

        $('label[for="dt-length-0"]').remove();

        const targetDiv = $('.dt-layout-cell.dt-layout-start');

        let _html =
            `
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

        $('#myTable thead input[type="checkbox"]').on('click', function() {
            const isChecked = $(this).prop('checked');
            // Tìm tất cả checkbox trong tbody và set trạng thái
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
                        model: model
                    },
                    success: function(response) {
                        alert('Xóa thành công!');
                        $('#myTable').DataTable().ajax.reload();
                        $('input[type="checkbox"]').prop('checked', false);
                        toggleActionDiv();
                    },
                    error: function() {
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                });
            }


        });
    }

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
        $(`#${input}`).on('input', function() {
            let value = $(this).val().replace(/\./g, ""); // Xóa dấu chấm cũ
            if (!isNaN(value)) {
                $(this).val(Number(value).toLocaleString("vi-VN")); // Format lại số
            } else {
                $(this).val($(this).val().slice(0, -1)); // Xóa ký tự không hợp lệ
            }

            $(`input[name=${input.slice(5)}]`).val(value.replace(/\./g, ""));
        });
    }

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
