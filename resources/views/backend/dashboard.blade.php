@extends('backend.layouts.master')

@section('content')
    <form method="GET" action="{{ route('admin.dashboard') }}">
        <div class="form-group">
    <div class="w-25 mb-3">
        <label for="year">Chọn năm:</label>
        <select name="year" id="year" class="form-select" onchange="this.form.submit()">
            @php($year = is_numeric($year) ? $year : date('Y'))
            @for ($i = $year - 5; $i <= date('Y'); $i++)
                <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
    </div>
    </div>
    </form>

    <div class="row gap-2">
        <div class="col d-flex align-items-center p-3 rounded" style="background-color: #f8d7da">
            <div class="icon rounded-circle bg-light me-3" style="padding: .8rem 1rem !important">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="result">
                <p class="m-0">Tổng Đơn Hàng</p>
                <h4 class="mb-0"><strong>{{ $totalOrder }} đơn hàng</strong></h4>
            </div>
        </div>
        <div class="col d-flex align-items-center p-3 rounded" style="background-color: #f8d7da">
            <div class="icon rounded-circle bg-light me-3" style="padding: .8rem 1rem !important">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="result">
                <p class="m-0">Tổng Tiền</p>
                <h4 class="mb-0"><strong>{{ $total }} VND</strong></h4>
            </div>
        </div>
        <div class="col d-flex align-items-center p-3 rounded" style="background-color: #f8d7da">
            <div class="icon rounded-circle bg-light me-3" style="padding: .8rem 1rem !important">
                <i class="fas fa-yen-sign"></i>
            </div>
            <div class="result">
                <p class="m-0">Tổng Tiền Lãi</p>
                <h4 class="mb-0"><strong>{{ $totalProfit }} VND</strong></h4>
            </div>
        </div>
        <div class="col d-flex align-items-center p-3 rounded" style="background-color: #f8d7da">
            <div class="icon rounded-circle bg-light me-3" style="padding: .8rem 1rem !important">
                <i class="fas fa-dolly-flatbed"></i>
            </div>
            <div class="result">
                <p class="m-0">Tổng Sản Phẩm Tồn Kho</p>
                <h4 class="mb-0"><strong>{{ $calculateStock }} sản phẩm</strong></h4>
            </div>
        </div>
    </div>


    <div class="row mt-5">
        <div class="col-lg-8">
            {!! $chart->container() !!}
        </div>
        <div class="col-md-4">
            {!! $topProductsChart->container() !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $topProductsChart->script() !!}
    {!! $chart->script() !!}
@endpush

@push('styles')
    <style>
        .chartjs-render-monitor {
            height: auto !important;
        }

        /* .page-inner {
            padding-right: 0 !important;
        } */
    </style>
@endpush
