<?php

namespace App\Providers;

use App\Http\ViewComposers\CategoryComposer;
use App\Http\ViewComposers\MainMenuComposer;
use App\Http\ViewComposers\TopSalesComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'partials.nav',
            MainMenuComposer::class
        );
        View::composer(
            'partials.shop.categories',
            CategoryComposer::class
        );
        View::composer(
            'partials.top_sales',
            TopSalesComposer::class
        );
    }
}
