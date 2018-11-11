<?php

namespace App\Http\Controllers\Web;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartsController extends Controller
{

    /**
     * Return shopping cart items
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shoppingCart()
    {
        // Get cart items with associated products
        $cartItems = \Cart::instance('shoppingCart')->content();

        $cartItemsWithModel = [];

        // Get associated products and append optimized image dimensions for cart page
        $products = Product::withoutGlobalScopes()->whereIn('id', $cartItems->pluck('id'))
            ->get()->each->setAppends(['cartProductImage']);

        foreach ($cartItems as $key => $item) {
            // Convert each item object's properties as array
            // We do this cuz shopping-cart package override laravel's toArray() method which remove eager loaded associated model.
            // We bypass this with transforming item object properties into array.
            $cartItemsWithModel[$key] = get_object_vars($item);
            $cartItemsWithModel[$key]['model'] = $products->where('id', $item->id)->first();
        }

        return view('themes.'.env('APP_THEME').'.pages.cart', [
            'cartItems' => $cartItemsWithModel,
        ]);
    }

    /**
     * Method for handling adding items to cart.
     *
     * @param Request $request
     * @param $categories
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function shoppingCartStore(Request $request, $categories, $slug)
    {
        // Get product instance
        $product = Product::getProductByUrl($categories, $slug);

        if (!$product) {
            return response()->json([
                'message' => 'Error! Nepoznat proizvod',
            ], 500);
        }

        // Add product to shopping cart
        \Cart::instance('shoppingCart')->add($product, $request->get('qty', 1));

        return response()->json([
            'message' => 'Proizvod je uspešno dodat u korpu!',
            'cartItemsCount' => \Cart::instance('shoppingCart')->count(),
        ]);
    }

    public function shoppingCartUpdate(Request $request)
    {
        if (!$request->has('rowId')) {
            return response()->json([
                'message' => 'Error! Nepoznat proizvod',
            ], 500);
        }

        // Update product quantity
        \Cart::instance('shoppingCart')->update($request->get('rowId'), $request->get('qty', 1));

        return response()->json([
            'message' => 'Uspešno izmenjena količina proizvoda!',
            'cartItemsCount' => \Cart::instance('shoppingCart')->count(),
        ]);
    }

    public function shoppingCartDelete(Request $request)
    {
        if (!$request->has('rowId')) {
            return response()->json([
                'message' => 'Error! Nepoznat proizvod',
            ], 500);
        }

        \Cart::instance('shoppingCart')->remove($request->get('rowId'));

        return response()->json([
            'message' => 'Proizvod je izbrisan iz korpe!',
            'cartItemsCount' => \Cart::instance('shoppingCart')->count(),
        ]);
    }
}
