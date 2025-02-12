@extends('backend.layouts.master')

@section('title', 'Lịch sử chuyển khoản')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Lịch sử chuyển khoản</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="display" style="width:100%">
                    <thead>
                        <th>ĐƠN HÀNG</th>
                        <th>NGƯỜI CHUYỂN KHOẢN</th>
                        <th>GIÁ TRỊ ĐƠN HÀNG</th>
                        <th>SỐ TIỀN</th>
                        <th>GHI CHÚ</th>
                        <th>NGÀY THỰC HIỆN</th>
                    </thead>
                </table>
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
                ajax: '{{ route('admin.order.transfer-history') }}',
                columns: [{
                        data: 'code',
                        name: 'code',
                        width: '12%'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: false,
                        // searchable: false
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'transaction_amount',
                        name: 'transaction_amount',
                        orderable: false,
                    },
                    {
                        data: 'transaction_notes',
                        name: 'transaction_notes',
                        orderable: false,
                        searchable: false,
                        width: '30%'
                    },
                    {
                        data: 'transaction_date',
                        name: 'transaction_date'
                    },
                ],
                order: [],
            });
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        table tr td p {
            margin: 0;
        }
    </style>
@endpush
