@extends('backend.layouts.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Danh sách từ khóa tìm kiếm</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll" /></th>
                            <th>TỪ KHÓA</th>
                            <th>SỐ LẦN</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    @include('backend.history-search.columns')
    <script>
        $(document).ready(function() {
            const api = '{{ route('admin.marketing.history-search') }}'

            dataTables(api, columns, 'HistorySearch', true, false, false, 'keywords')

            handleDestroy()

        })
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        #startDate,
        #endDate {
            padding: .375rem .75rem !important;
        }
    </style>
@endpush
