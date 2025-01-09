<?php

namespace App\Http\Controllers\admin;

use App\Charts\RevenueChart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getRevenueChart()
    {
        $year = request("year", date('Y'));
        $chart = new RevenueChart($year);
        $chart->loadData($year);

        $total = formatAmount($chart->loadTotalRevenue($year));

        $totalOrder = formatAmount($chart->loadTotalOrders($year));

        $totalProfit = formatAmount($chart->loadTotalProfit($year));

        $totalCost = formatAmount($chart->loadTotalCost($year));

        $calculateStock = $chart->calculateStock($year);

        $topProducts = $chart->loadTopSellingProducts($year);

        $topProductsChart = new Chart;
        $topProductsChart->labels($topProducts['labels']);
        $topProductsChart->dataset('Top 10 sản phẩm bán chạy', 'pie', $topProducts['data'])
            ->color(['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)', 'rgba(255, 205, 86, 1)', 'rgba(201, 203, 207, 1)', 'rgba(50, 168, 82, 1)', 'rgba(169, 169, 169, 1)', 'rgba(255, 99, 99, 1)']);

        return view('backend.dashboard', compact('chart', 'year', 'total', 'totalOrder', 'totalProfit', 'totalCost', 'topProductsChart', 'calculateStock'));
    }
}
