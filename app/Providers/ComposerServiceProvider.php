<?php

namespace App\Providers;

use App\Http\ViewComposers\CategoryComposer;
use App\Http\ViewComposers\MainMenuComposer;
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
            'themes.'.env('APP_THEME').'.partials.header',
            MainMenuComposer::class
        );
        View::composer(
            'partials.shop.categories',
            CategoryComposer::class
        );
    }
}
