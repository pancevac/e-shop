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
     * Cart items array
     *
     * @array
     */
    protected $cartItems = [];

    /**
     * Hide attributes before transforming product class into JSON.
     *
     * @var array
     */
    protected $hiddenProductAttributes = [
        'id',
        'user_id',
        'short',
        'description',
        'featured',
        'publish_at',
        'publish',
        'created_at',
        'updated_at',
    ];

    /**
     * Initialize shopping cart
     */
    public function init()
    {
        // Get cart items with associated products
        $cartItems = \Cart::instance('shoppingCart')->content();

        $cartItemsWithModel = [];

        // Get associated products and append optimized image dimensions for cart page
        $products = Product::withoutGlobalScopes()->whereIn('id', $cartItems->pluck('id'))
            ->get()->each
            ->setAppends(['cartProductImage', 'link'])
            ->makeHidden($this->hiddenProductAttributes);

        foreach ($cartItems as $key => $item) {
            // Convert each item object's properties as array
            // We do this cuz shopping-cart package override laravel's toArray() method which remove eager loaded associated model.
            // We bypass this with transforming item object properties into array.
            $cartItemsWithModel[$key] = get_object_vars($item);
            $cartItemsWithModel[$key]['model'] = $products->where('id', $item->id)->first();
        }

        $this->cartItems = $cartItemsWithModel;
    }

    /**
     * Return shopping cart items as array or as json
     *
     * @param bool $asJson
     * @return false|string
     */
    public function getShoppingCartItems(bool $asJson  = false)
    {
        return $asJson ? json_encode($this->cartItems) : $this->cartItems;
    }

    /**
     * Return shopping cart subtotal price (without discounts) as array or json
     *
     * @return mixed
     */
    public function getSubtotalPrice()
    {
        $content = session()->get('cart')['shoppingCart'];

        $subTotal = $content->reduce(function ($subTotal, CartItem $cartItem) {
            return $subTotal + ($cartItem->qty * $cartItem->price);
        }, 0);

        return $subTotal;
    }

    /**
     * Get shopping cart total price (discount included if coupon is set)
     *
     * @return float|int
     */
    public function getTotalPrice()
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

        return $this->getSubtotalPrice();
    }

    public function getDiscountPrice()
    {
        if (session()->has('coupon')) {

            $content = session()->get('cart')['shoppingCart'];

            $subTotal = $content->reduce(function ($subTotal, CartItem $cartItem) {
                return $subTotal + ($cartItem->qty * $cartItem->price);
            }, 0);

            return $subTotal - $this->getTotalPrice();
        }
    }

    public function getPricePerProduct($shoppingCartItem)
    {
        $subTotal = $shoppingCartItem['price'] * $shoppingCartItem['qty'];

        if (session()->has('coupon')) {
            $coupon = session()->get('coupon');
            return $subTotal - ($subTotal * ($coupon->discount / 100));
        }

        return $subTotal;
    }

    /**
     * Return number of items in cart.
     *
     * @return int
     */
    public function getCartCount(): int
    {
        return \Cart::instance('shoppingCart')->count();
    }

    /**
     * Return refreshed cart status as JSON
     *
     * @param string $withMessage
     * @param bool $asJson
     * @param array $append
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCartStatus(string $withMessage, bool $asJson = true, array $append = [])
    {
        // Init(refresh) cart state before returning status
        $this->init();

        $response = [
            'message' => $withMessage,
            'cartItems' => $this->getShoppingCartItems(),
            'cartItemsCount' => $this->getCartCount(),
            'subtotalPrice' => $this->getSubtotalPrice(),
            'totalPrice' => $this->getTotalPrice(),
            'coupon' => session()->get('coupon')
        ];

        if (! empty($append)) {
            // Append response array
            $response = array_merge($response, $append);
        }

        return response()->json($response);
    }
}