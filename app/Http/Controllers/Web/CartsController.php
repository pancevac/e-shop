<?php

namespace App\Http\Controllers\Web;

use App\Coupon;
use App\Http\Requests\StoreCouponRequest;
use App\Product;
use App\Traits\SEO;
use App\Traits\ShoppingCartTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartsController extends Controller
{
    use ShoppingCartTrait, SEO;

    /**
     * Return shopping cart if isn't empty
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showShoppingCartPage()
    {
        // Set SEO optimization
        $this->seoDefault('Korpa');

        if (\Cart::instance('shoppingCart')->count() == 0) {
            return redirect()->back()->with('message', 'Morate dodati minimum jedan proizvod kako biste nastavili dalje');
        }

        return view('pages.cart', [
            'cartItems' => $this->getShoppingCartItems(),
            'subTotal' => $this->getSubtotalPrice(),
            'total' => $this->getTotalPrice(),
            'coupon' => session()->get('coupon') ?: null,
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

        return $this->getCartStatus('Proizvod je uspešno dodat u korpu!');
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

        return $this->getCartStatus('Uspešno izmenjena količina proizvoda!');
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

        return $this->getCartStatus('Proizvod je izbrisan iz korpe!');
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
        $coupon->decrement('amount');

        // Put coupon in session
        session()->put('coupon', $coupon);

        return $this->getCartStatus('Uspešno iskorišćen kupon.');
    }

    /**
     * Remove applied coupon from session.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function decoupon(Request $request)
    {
        session()->forget('coupon');

        return $this->getCartStatus('Uklonili ste kupon!');
    }
}
