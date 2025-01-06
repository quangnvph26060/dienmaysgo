<?php

namespace App\Providers;

use App\Models\SgoCategory;
use App\Models\SgoConfig;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


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

        View::composer(['frontends.layouts.master', 'frontends.pages.home'], function ($view) {

            $view->with([
                'cataloguesMenu' => SgoCategory::query()->whereNull('category_parent_id')->with('childrens')->get(),
            ]);
        });

        View::composer('*', function ($view) {
            $view->with([
                'settings' => SgoConfig::query()->first(),
            ]);
        });
    }
}
