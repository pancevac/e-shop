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
        Blade::component('components.home.product', 'home_product');
        //Blade::component($componentPath.'.home.widget', 'home_widget');
        Blade::component('components.shop.product', 'product');
        Blade::component('components.shop.filter', 'filter');
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
