<?php

namespace App\Charts;

use App\Models\SgoOrder;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;

class RevenueChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct($year)
    {
        parent::__construct();

        $this->title('Doanh thu tháng, năm ' . $year);
        $this->labels(['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12']);
    }

    // public function loadData($year)
    // {
    //     // Lấy dữ liệu doanh thu theo tháng
    //     $data = SgoOrder::whereYear('created_at', $year)
    //         ->select(DB::raw('MONTH(created_at) as month, SUM(total_price) as total'))
    //         ->where('status', 'completed')
    //         ->groupBy('month')
    //         ->pluck('total', 'month')
    //         ->toArray();

    //     // Khởi tạo mảng doanh thu cho 12 tháng (mặc định là 0)
    //     $revenueData = array_fill(0, 12, 0);

    //     // Gán doanh thu cho các tháng có dữ liệu
    //     foreach ($data as $month => $total) {
    //         $revenueData[$month - 1] = (float) $total; // Chuyển đổi sang kiểu float để biểu đồ hiển thị đúng
    //     }
    //     // dd($revenueData);

    //     // Cập nhật dữ liệu cho biểu đồ
    //     $this->dataset('Doanh thu', 'line', $revenueData);
    // }

    public function loadData($year)
    {
        // Lấy dữ liệu doanh thu, chi phí và tiền lời theo tháng
        $data = SgoOrder::join('order_product as op', 'sgo_orders.id', '=', 'op.order_id')
            ->join('sgo_products as sp', 'op.product_id', '=', 'sp.id')
            ->whereYear('sgo_orders.created_at', $year)
            ->where('sgo_orders.status', 'completed')
            ->select(
                DB::raw('MONTH(sgo_orders.created_at) as month'),
                DB::raw('SUM(op.p_price * op.p_qty) as total_revenue'), // Tổng doanh thu
                DB::raw('SUM(sp.import_price * op.p_qty) as total_cost'), // Tổng chi phí
                DB::raw('SUM((op.p_price - sp.import_price) * op.p_qty) as total_profit') // Tổng tiền lời
            )
            ->groupBy(DB::raw('MONTH(sgo_orders.created_at)'))
            ->get();

        // Khởi tạo mảng doanh thu, chi phí và tiền lời cho 12 tháng (mặc định là 0)
        $revenueData = array_fill(0, 12, 0);
        $costData = array_fill(0, 12, 0);
        $profitData = array_fill(0, 12, 0);

        // Gán dữ liệu cho các tháng có dữ liệu
        foreach ($data as $row) {
            $revenueData[$row->month - 1] = (float) $row->total_revenue;
            $costData[$row->month - 1] = (float) $row->total_cost;
            $profitData[$row->month - 1] = (float) $row->total_profit;
        }

        // Cập nhật dữ liệu cho biểu đồ với màu sắc khác nhau
        $this->dataset('Doanh thu', 'line', $revenueData)
            ->color('rgba(75, 192, 192, 1)') // Màu xanh cho Doanh thu
            ->backgroundColor('rgba(75, 192, 192, 0.2)'); // Màu nền xanh nhạt

        $this->dataset('Chi phí', 'line', $costData)
            ->color('rgba(255, 99, 132, 1)') // Màu đỏ cho Chi phí
            ->backgroundColor('rgba(255, 99, 132, 0.2)'); // Màu nền đỏ nhạt

        $this->dataset('Lợi nhuận', 'line', $profitData)
            ->color('rgba(54, 162, 235, 1)') // Màu xanh dương cho Lợi nhuận
            ->backgroundColor('rgba(54, 162, 235, 0.2)'); // Màu nền xanh dương nhạt
    }

    public function loadTotalRevenue($year)
    {
        // Tính tổng doanh thu trong năm
        $totalRevenue = SgoOrder::whereYear('created_at', $year)
            ->where('status', 'completed') // Chỉ tính các đơn hàng đã hoàn thành
            ->sum('total_price'); // Tổng giá trị đơn hàng

        // Trả về tổng doanh thu để bạn có thể hiển thị con số đó
        return $totalRevenue;
    }

    public function loadTotalOrders($year)
    {
        // Tính số lượng đơn hàng trong năm
        $totalOrders = SgoOrder::whereYear('created_at', $year)
            ->where('status', 'completed') // Chỉ tính các đơn hàng đã hoàn thành
            ->count(); // Đếm số lượng đơn hàng

        // Trả về số lượng đơn hàng để bạn có thể hiển thị con số đó
        return $totalOrders;
    }

    public function loadTotalProfit($year)
    {
        // Tính tổng tiền lời trong năm
        $totalProfit = SgoOrder::join('order_product as op', 'sgo_orders.id', '=', 'op.order_id')
            ->join('sgo_products as sp', 'op.product_id', '=', 'sp.id')
            ->whereYear('sgo_orders.created_at', $year)
            ->where('sgo_orders.status', 'completed')
            ->sum(DB::raw('(op.p_price - sp.import_price) * op.p_qty'));

        return $totalProfit;
    }

    public function loadTotalCost($year)
    {
        // Tính tổng chi phí trong năm
        $totalCost = SgoOrder::join('order_product as op', 'sgo_orders.id', '=', 'op.order_id')
            ->join('sgo_products as sp', 'op.product_id', '=', 'sp.id')
            ->whereYear('sgo_orders.created_at', $year)
            ->where('sgo_orders.status', 'completed')
            ->sum(DB::raw('sp.import_price * op.p_qty'));

        return $totalCost;
    }

    public function loadTopSellingProducts($year)
    {
        // Lấy top 10 sản phẩm bán chạy nhất trong năm
        $topProducts = SgoOrder::join('order_product as op', 'sgo_orders.id', '=', 'op.order_id')
            ->join('sgo_products as sp', 'op.product_id', '=', 'sp.id')
            ->whereYear('sgo_orders.created_at', $year)
            ->where('sgo_orders.status', 'completed')
            ->select(
                'sp.name as product_name', // Tên sản phẩm
                DB::raw('SUM(op.p_qty) as total_quantity') // Tổng số lượng bán
            )
            ->groupBy('sp.name')
            ->orderByDesc(DB::raw('SUM(op.p_qty)'))
            ->limit(10)
            ->get();

        // Lấy tên sản phẩm và số lượng bán để tạo dữ liệu cho biểu đồ
        $productNames = $topProducts->pluck('product_name');
        $productQuantities = $topProducts->pluck('total_quantity');

        // Trả về dữ liệu cho biểu đồ tròn
        return [
            'labels' => $productNames,
            'data' => $productQuantities
        ];
    }

    public function calculateStock($year)
    {
        $productsInStock = DB::table('sgo_products as sp')
        ->leftJoin('order_product as op', 'sp.id', '=', 'op.product_id')
        ->select(DB::raw('COUNT(DISTINCT sp.id) as out_of_stock_count'))
        ->whereYear('sp.created_at', '=', $year) // Lọc theo năm sản phẩm được tạo
        ->groupBy('sp.id', 'sp.quantity') // Nhóm theo id và số lượng sản phẩm
        ->havingRaw('COALESCE(SUM(op.p_qty), 0) <= 10') // Sản phẩm không bán được hoặc bán <= 10 lần
        ->pluck('out_of_stock_count')
        ->sum();

        return $productsInStock;
    }
}

// DB::table('sgo_products as sp')
//         ->leftJoin('order_product as op', 'sp.id', '=', 'op.product_id')
//         ->select(
//             'sp.name',
//             'sp.image',
//             'sp.quantity',
//             DB::raw('COALESCE(SUM(op.p_qty), 0) as sold_qty')
//         )
//         ->whereYear('sp.created_at', '=', $year) // Lọc theo năm sản phẩm được tạo
//         ->groupBy('sp.id', 'sp.name', 'sp.image', 'sp.quantity') // Nhóm theo id, tên, ảnh và số lượng tồn kho
//         ->havingRaw('COALESCE(SUM(op.p_qty), 0) <= 10') // Sản phẩm không bán được hoặc bán <= 10 lần
//         ->get();
