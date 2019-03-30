<?php

namespace App\Providers;

use App\Helpers\Cart;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('shoppingCart', Cart::class);
    }
}
