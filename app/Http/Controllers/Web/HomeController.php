<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        /*//dd(Carbon::parse('25-10-2018') > Carbon::now());
        if ('2018-10-25' < Carbon::now()->format('Y-m-d')) {
            dd('radi');
        }
        dd('ne radi');*/
        return view('themes.'.env('APP_THEME').'.pages.home');
    }
}
