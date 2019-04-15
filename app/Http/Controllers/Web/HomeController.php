<?php

namespace App\Http\Controllers\Web;

use App\Banner;
use App\Product;
use App\Widget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show site home page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Get home main banner
        $homeBanner = Banner::getBanner();

        // Get home widgets
        $homeWidgets = Widget::getHomeWidgets();

        //dd($homeWidgets);

        // Get latest featured products
        $productInstance = new Product();
        $featuredProducts = $productInstance->withoutGlobalScopes(['brand', 'attributes'])
            ->published()->orderByDesc('updated_at')->take($productInstance->frontPaginate)->get();

        return view('pages.home', [
            'products' => $featuredProducts,
            'widgets' => $homeWidgets,
            'banner' => $homeBanner,
        ]);
    }
}
