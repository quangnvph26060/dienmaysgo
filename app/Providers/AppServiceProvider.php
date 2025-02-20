<?php

namespace App\Providers;

use App\Models\SgoCategory;
use App\Models\SgoConfig;
use App\Models\SgoOrder;
use App\Models\SgoProduct;
use App\Models\TransactionHistory;
use App\Observers\ProductObserver;
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
        SgoProduct::observe(ProductObserver::class);

        Paginator::defaultView('vendor.pagination.custom');

        View::composer(['frontends.layouts.master', 'frontends.pages.home', 'frontends.pages.category'], function ($view) {

            $categories = SgoCategory::with('childrens')->whereNull('category_parent_id')->get();

            // Load tất cả danh mục con của các danh mục cha
            $categories->each(function ($category) {
                $category->load('childrens.childrens'); // Load sâu hơn nếu cần
            });

            // Truyền vào view
            $view->with([
                'cataloguesMenu' => $categories,
            ]);
        });

        View::composer('*', function ($view) {
            $settings = Cache::remember('site_settings', now()->addMinutes(30), function () {
                return SgoConfig::query()->first();
            });

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
