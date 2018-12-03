<?php

namespace App\Http\Controllers\Web;

use App\Traits\ShoppingCartTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutsController extends Controller
{
    use ShoppingCartTrait;

    public function checkoutPage()
    {
        $cartItems = self::getShoppingCartItems();
        $subTotal = \Cart::instance('shoppingCart')->subtotal();

        return view('themes.'.env('APP_THEME').'.pages.checkout', [
            'cartItems' => $cartItems,
            'subTotal' => $subTotal,
            'total' => self::getTotalPrice(),
            'discount' => self::getDiscountPrice(),
        ]);
    }
}
