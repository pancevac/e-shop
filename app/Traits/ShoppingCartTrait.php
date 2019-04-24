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


            $product = $products->where('id', $item->id)->first();
            // Convert each item object's properties as array
            // We do this cuz shopping-cart package override laravel's toArray() method which remove eager loaded associated model.
            // We bypass this with transforming item object properties into array.
            $cartItemsWithModel[$key] = get_object_vars($item);
            $cartItemsWithModel[$key]['model'] = $product;
            $cartItemsWithModel[$key]['price_formatted'] = currency($this->getPricePerProduct($cartItemsWithModel[$key], false));
            $cartItemsWithModel[$key]['price_qty_formatted'] = currency($this->getPricePerProduct($cartItemsWithModel[$key]));

        }

        $this->cartItems = $cartItemsWithModel;
    }

    /**
     * Return shopping cart items as array or as json
     *
     * @param bool $asJson
     * @return array|string
     */
    public function getShoppingCartItems(bool $asJson  = false)
    {
        return $asJson ? json_encode($this->cartItems) : $this->cartItems;
    }

    /**
     * Return shopping cart subtotal price (without discounts) as array or json
     *
     * @param bool $format
     * @return string|float
     */
    public function getSubtotalPrice($format = false)
    {
        $subtotal = array_reduce($this->getShoppingCartItems(), function ($carry, array $cartItem) {
            return $carry + ($cartItem['qty'] * $cartItem['price']);
        }, 0);

        return $this->processPrice($subtotal, $format);
    }

    /**
     * Get shopping cart total price (discount included if coupon is set)
     *
     * @param bool $format
     * @return string|float|int
     */
    public function getTotalPrice($format = false)
    {
        if (session()->has('coupon')) {

            $coupon = session()->get('coupon');

            $subTotal = $this->getSubtotalPrice();

            $total = $subTotal - ($subTotal * ($coupon->discount / 100));

            return $this->processPrice($total, $format);
        }

        $total = $this->getSubtotalPrice();

        return $this->processPrice($total, $format);
    }

    /**
     * Get discount value.
     *
     * @param bool $format
     * @return float|int|string|false
     */
    public function getDiscountPrice(bool $format = false)
    {
        if (session()->has('coupon')) {

            $discountPrice = $this->getSubtotalPrice() - $this->getTotalPrice();

            return $this->processPrice($discountPrice, $format);
        }
    }

    /**
     * Return price multiple by quantity and with coupon discount per product.
     *
     * @param array $shoppingCartItem
     * @param bool $multipleByQty
     * @return float|int
     */
    public function getPricePerProduct(array $shoppingCartItem, bool $multipleByQty = true)
    {
        $subTotal = $shoppingCartItem['price'];

        if ($multipleByQty) {
            $subTotal = $subTotal * $shoppingCartItem['qty'];
        }

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
            'subtotalPrice' => $this->getSubtotalPrice(true),
            'totalPrice' => $this->getTotalPrice(true),
            'discountPrice' => $this->getDiscountPrice(true),
            'coupon' => session()->get('coupon'),
        ];

        if (! empty($append)) {
            // Append response array
            $response = array_merge($response, $append);
        }

        return response()->json($response);
    }

    /**
     * Format price as string with currency or just return float.
     *
     * @param float $price
     * @param bool $format
     * @return float|string|\Torann\Currency\Currency
     */
    protected function processPrice(float $price, $format = false)
    {
        return $format ? currency($price) : $price;
    }
}