<?php

namespace App\Providers;

use App\Models\SgoCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('frontends.layouts.master', function ($view) {

            $view->with([
                'cataloguesMenu' => SgoCategory::query()->whereNull('category_parent_id')->with('childrens')->get()
            ]);
        });
    }
}
