<?php

namespace App\Providers;

use App\Models\SgoCategory;
use App\Models\SgoConfig;
use App\Models\SgoOrder;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.custom');

        View::composer(['frontends.layouts.master', 'frontends.pages.home', 'frontends.pages.category'], function ($view) {

            $view->with([
                'cataloguesMenu' => SgoCategory::query()->whereNull('category_parent_id')->with('childrens')->get(),
            ]);
        });

        View::composer('*', function ($view) {
            $settings = SgoConfig::query()->first();

            $view->with('settings', $settings);
        });



        View::composer('backend.layouts.partials.navbar', function ($view) {
            $groupedOrders  = SgoOrder::query()
                ->with('user')
                ->latest()
                ->limit(20)
                ->get()
                ->groupBy(function ($order) {
                    $createdDate = Carbon::parse($order->created_at);
                    $now = Carbon::now();

                    if ($createdDate->isToday()) {
                        return 'Hôm nay';
                    } elseif ($createdDate->isYesterday()) {
                        return '1 ngày trước';
                    } elseif ($createdDate->diffInDays($now) <= 7) {
                        return $createdDate->diffInDays($now) . ' ngày trước';
                    } elseif ($createdDate->diffInWeeks($now) <= 4) {
                        return $createdDate->diffInWeeks($now) . ' tuần trước';
                    } elseif ($createdDate->diffInYears($now) < 1) {
                        return $createdDate->diffInMonths($now) . ' tháng trước';
                    } else {
                        return $createdDate->diffInYears($now) . ' năm trước';
                    }
                });

            $todayOrdersCount = $groupedOrders->get('Hôm nay') ? $groupedOrders->get('Hôm nay')->count() : 0;

            $ransferHistory = TransactionHistory::query()->latest()->limit(20)->get();

            $view->with([
                'groupedOrders' => $groupedOrders,
                'todayOrdersCount' => $todayOrdersCount,
                'ransferHistory' => $ransferHistory
            ]);
        });
    }
}
