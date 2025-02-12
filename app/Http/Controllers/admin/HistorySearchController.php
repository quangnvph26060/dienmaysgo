<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\HistorySearch;
use App\Models\ProductView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorySearchController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            DB::reconnect();

            // Lấy startDate và endDate từ request
            $startDate = request()->get('startDate');
            $endDate = request()->get('endDate');

            // Truyền startDate và endDate vào getAll() để lọc dữ liệu
            return datatables()->of(HistorySearch::getAll($startDate, $endDate))
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->keywords . '" />';
                })
                ->addColumn('count', function ($row) {
                    return $row->count;
                })
                ->addIndexColumn()
                ->rawColumns(['checkbox'])
                ->make(true);
        }

        return view('backend.history-search.index');
    }

    public function getAverageTimePerProduct()
    {
        if (request()->ajax()) {
            DB::reconnect();

            // Lấy startDate và endDate từ request
            $startDate = request()->get('startDate');
            $endDate = request()->get('endDate');

            // Truyền startDate và endDate vào getAll() để lọc dữ liệu
            return datatables()->of(ProductView::getAverageTimePerProduct($startDate, $endDate))
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->keywords . '" />';
                })
                ->addColumn('count', function ($row) {
                    return $row->count;
                })
                ->addIndexColumn()
                ->rawColumns(['checkbox'])
                ->make(true);
        }
    }
}
