<?php

namespace App\Http\Controllers\Web;

use App\Coupon;
use App\Http\Requests\StoreCouponRequest;
use App\Product;
use App\Traits\ShoppingCartTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartsController extends Controller
{
    use ShoppingCartTrait;

    public function showShoppingCartPage()
    {
        return view('themes.'.env('APP_THEME').'.pages.cart', [
            'cartItems' => self::getShoppingCartItems(),
            'subTotal' => \Cart::instance('shoppingCart')->subtotal(),
            'total' => self::getTotalPrice(),
        ]);
    }

    /**
     * Method for handling adding items to cart.
     *
     * @param Request $request
     * @param $categories
     * @param $slug
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function shoppingCartStore(Request $request, $categories, $slug, $code)
    {
        // Get product instance
        $product = Product::getProductByUrl($categories, $slug, $code);

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

    /**
     * Method for handling updating shopping cart item
     *
     * @param Request $request
     * @param $rowId
     * @return \Illuminate\Http\JsonResponse
     */
    public function shoppingCartUpdate(Request $request, $rowId)
    {
        if (!$request->has('qty')) {
            return response()->json([
                'message' => 'Error! Nepoznat proizvod',
            ], 500);
        }

        // Update product quantity
        \Cart::instance('shoppingCart')->update($rowId, $request->get('qty', 1));

        return response()->json([
            'message' => 'Uspešno izmenjena količina proizvoda!',
            'cartItems' => self::getShoppingCartItems(),
            'cartItemsCount' => \Cart::instance('shoppingCart')->count(),
            'subTotal' => \Cart::instance('shoppingCart')->subtotal(),
            'total' => self::getTotalPrice(),
        ]);
    }

    /**
     * Remove item from shopping cart
     *
     * @param $rowId
     * @return \Illuminate\Http\JsonResponse
     */
    public function shoppingCartDelete($rowId)
    {
        if (!$rowId) {
            return response()->json([
                'message' => 'Error! Nepoznat proizvod',
            ], 500);
        }

        \Cart::instance('shoppingCart')->remove($rowId);

        return response()->json([
            'message' => 'Proizvod je izbrisan iz korpe!',
            'cartItems' => self::getShoppingCartItems(),
            'cartItemsCount' => \Cart::instance('shoppingCart')->count(),
            'subTotal' => \Cart::instance('shoppingCart')->subtotal(),
            'total' => self::getTotalPrice(),
        ]);
    }

    /**
     * Method for checking is coupon valid and if so, putting to session
     *
     * @param StoreCouponRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function coupon(StoreCouponRequest $request)
    {
        // Get coupon
        $coupon = Coupon::getValidCoupon($request->input('coupon'));

        // If no coupon, return error
        if (!$coupon) {
            return response()->json([
                'message' => 'Kupon ne postoji ili je istekao'
            ], 404);
        }

        // Decrement coupon amount
        //$coupon->decrement('amount');

        // Put coupon in session
        session()->put('coupon', $coupon);

        return response()->json([
            'message' => 'Uspešno iskorišćen kupon',
            'total' => self::getTotalPrice(),
        ]);
    }
}
