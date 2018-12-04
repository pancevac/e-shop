<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\ChargeRequest;
use App\Traits\ShoppingCartTrait;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutsController extends Controller
{
    use ShoppingCartTrait;

    /**
     * Show checkout page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkoutPage()
    {
        $cartItems = self::getShoppingCartItems();
        $subTotal = \Cart::instance('shoppingCart')->subtotal();

        $user = auth()->check() ? $this->collectLoggedCustomerInfo() : null;

        return view('themes.'.env('APP_THEME').'.pages.checkout', [
            'cartItems' => $cartItems,
            'subTotal' => $subTotal,
            'total' => self::getTotalPrice(),
            'discount' => self::getDiscountPrice(),
            'user' => $user,
        ]);
    }

    /**
     * Handle charging
     * @param ChargeRequest $request
     */
    public function charge(ChargeRequest $request)
    {
        dd($request->all());
    }

    /**
     * Get currently logged customer info, temporary hided fields like id, user_id etc.etc
     *
     * @return mixed
     */
    private function collectLoggedCustomerInfo()
    {
        // Retrieve logged user with customer profile
        $loggedCustomer = auth()->user()->load('customer');

        // Temporarily hide user fields from showing in json
        $loggedCustomer->makeHidden([
            'id', 'role_id', 'email_verified_at', 'image', 'block', 'created_at', 'updated_at', 'role'
        ]);

        if ($loggedCustomer->customer) {

            // Temporarily hide customer fields from showing in json
            $loggedCustomer->customer->makeHidden([
                'id', 'user_id', 'created_at', 'updated_at'
            ]);
        }

        return $loggedCustomer;

    }
}
