<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\AddToWishList;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishListsController extends Controller
{

    public function showWishListPage()
    {
        return view('themes.'.env('APP_THEME').'.pages.wish_list', [
            'wishListItems' => self::getWishListItems(),
        ]);
    }

    /**
     * Return wish-list items for logged customer
     */
    public static function getWishListItems()
    {
        // If exist, restore previous wish-list instance from db
        // Note: after getting instance, record from db will be deleted
        // So we need to insert it again in order to save items
        \Cart::instance('wishList')->restore(Auth::user()->getKey());
        \Cart::instance('wishList')->store(Auth::user()->getKey());

        // Get wish-list items
        $wishListItems = \Cart::instance('wishList')->content();
        //dd($wishListItems);

        $wishListItemsWithModel = [];

        // Get associated products and append optimized image dimensions for cart page
        $products = Product::withoutGlobalScopes()->with('categories')->whereIn('id', $wishListItems->pluck('id'))
            ->get()->each->setAppends(['cartProductImage', 'link']);

        foreach ($wishListItems as $key => $item) {
            // Convert each item object's properties as array
            // We do this cuz shopping-cart package override laravel's toArray() method which remove eager loaded associated model.
            // We bypass this with transforming item object properties into array.
            $wishListItemsWithModel[$key] = get_object_vars($item);
            $wishListItemsWithModel[$key]['model'] = $products->where('id', $item->id)->first();
        }

        return $wishListItemsWithModel;
    }

    /**
     * Handle adding item to customers wish-list
     *
     * @param AddToWishList $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToWishList(AddToWishList $request)
    {
        $product = Product::withoutGlobalScopes()->published()->whereCode($request->get('productCode'))->first();

        // If exist, restore previous wish-list instance from db
        // Note: after getting instance, record from db will be deleted
        // So we need to insert it again in order to save items
        \Cart::instance('wishList')->restore(Auth::user()->getKey());

        // Check if product is already in wish list
        $existingProduct = \Cart::instance('wishList')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id == $product->id;
        });

        // If product already exist, we don't need to save its quantity, so return warning...
        if (! $existingProduct->isEmpty()) {

            // Save wish-list instance in database
            \Cart::instance('wishList')->store(Auth::user()->getKey());

            return response()->json([
                'message' => 'Proizvod se već nalazi u listi želja.',
            ], 500);
        }

        // Add item to wish-list
        \Cart::instance('wishList')->add($product, 1);

        // Save wish-list instance in database
        \Cart::instance('wishList')->store(Auth::user()->getKey());

        return response()->json([
            'message' => 'Proizvod je uspešno dodat u listu želja.',
        ]);
    }

    /**
     * Handle removing item from wish-list
     *
     * @param $itemId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFromWishList($itemId)
    {
        // If exist, restore previous wish-list instance from db
        // Note: after getting instance, record from db will be deleted
        // So we need to insert it again in order to save items
        \Cart::instance('wishList')->restore(Auth::user()->getKey());

        // Delete product from wish-list instance
        \Cart::instance('wishList')->remove($itemId);

        // Save wish-list instance in database
        \Cart::instance('wishList')->store(Auth::user()->getKey());

        return response()->json([
            'message' => 'Proizvod je uspešno izbrisan iz liste želja.',
            'wishListItems' => self::getWishListItems(),
        ]);
    }
}
