<?php
/**
 * Created by PhpStorm.
 * User: Sile
 * Date: 12/3/2018
 * Time: 6:54 PM
 */

namespace App\Traits;


use App\Product;
use Gloudemans\Shoppingcart\CartItem;

trait ShoppingCartTrait
{
    /**
     * Return shopping cart items
     *
     * @return array
     */
    public static function getShoppingCartItems()
    {
        // Get cart items with associated products
        $cartItems = \Cart::instance('shoppingCart')->content();

        $cartItemsWithModel = [];

        // Get associated products and append optimized image dimensions for cart page
        $products = Product::withoutGlobalScopes()->with('categories')->whereIn('id', $cartItems->pluck('id'))
            ->get()->each->setAppends(['cartProductImage', 'link']);

        foreach ($cartItems as $key => $item) {
            // Convert each item object's properties as array
            // We do this cuz shopping-cart package override laravel's toArray() method which remove eager loaded associated model.
            // We bypass this with transforming item object properties into array.
            $cartItemsWithModel[$key] = get_object_vars($item);
            $cartItemsWithModel[$key]['model'] = $products->where('id', $item->id)->first();
        }

        return $cartItemsWithModel;
    }

    /**
     * Get shopping cart total price (discount included if coupon is set)
     *
     * @return float|int
     */
    public static function getTotalPrice()
    {
        if (session()->has('coupon')) {

            $coupon = session()->get('coupon');

            //$subPrice = \Cart::instance('shoppingCart')->subtotal();

            $content = session()->get('cart')['shoppingCart'];

            $subTotal = $content->reduce(function ($subTotal, CartItem $cartItem) {
                return $subTotal + ($cartItem->qty * $cartItem->price);
            }, 0);

            return $subTotal - ($subTotal * ($coupon->discount / 100));
        }

        return \Cart::instance('shoppingCart')->subtotal();
    }

    public static function getDiscountPrice()
    {
        if (session()->has('coupon')) {

            $content = session()->get('cart')['shoppingCart'];

            $subTotal = $content->reduce(function ($subTotal, CartItem $cartItem) {
                return $subTotal + ($cartItem->qty * $cartItem->price);
            }, 0);

            return $subTotal - self::getTotalPrice();
        }
    }
}