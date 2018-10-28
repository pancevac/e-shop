<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $componentPath = 'themes.' . env('APP_THEME') . '.components';
        Blade::component($componentPath.'.shop.product', 'product');
        Blade::component($componentPath.'.shop.filter', 'filter');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
