<?php

namespace App\Http\Middleware;

use Closure;

class CartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app('shoppingCart')->init();

        return $next($request);
    }
}
