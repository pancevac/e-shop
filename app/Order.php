<?php

namespace App;

use App\Traits\ShoppingCartTrait;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The customer that belong to order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The coupon that belong to order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * The products that belong to order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty', 'price');
    }

    /**
     * Method for creating order
     *
     * @param $request
     * @param string $status
     * @param null $error
     */
    public function makeOrder($request, $status = 'success', $error = null)
    {
        $this->transaction_identifier = json_decode($request->input('stripe_token'))->card->id;
        $this->customer_id = auth()->check() ? auth()->user()->customer->getKey() : null;
        $this->coupon_id = session()->has('coupon') ? session()->get('coupon')->id : null;
        $this->first_name = $request->input('first_name');
        $this->last_name = $request->input('last_name');
        $this->email = $request->input('email');
        $this->address1 = $request->input('address1');
        $this->address2 = $request->input('address2');
        $this->country = $request->input('country');
        $this->city = $request->input('city');
        $this->postal_code = $request->input('postal_code');
        $this->phone = $request->input('phone');
        $this->note = $request->input('note');
        $this->is_paid = false; // Posle staviti true ako se plati preko kartice
        $this->is_delivered = false;
        $this->subtotal_price = getSubtotalPrice();
        $this->total_price = getTotalPrice();
        $this->status = $status;
        $this->error = $error;

        $this->save();

        // Attach products from shopping cart with order
        $this->syncProductsWithOrder($this);
    }

    /**
     *  Sync(attach) products with order
     *
     * @param $orderInstance
     */
    public function syncProductsWithOrder($orderInstance)
    {
        $syncProducts = [];

        foreach (getCartItems() as $item) {

            $syncProducts[$item['id']] = [
                'qty' => $item['qty'],
                'price' => getPricePerProduct($item),
            ];
        }

        // Finally, sync(attach) products with order
        $orderInstance->products()->sync($syncProducts);

    }

    /**
     * Get order with relations
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->load([
            'customer',
            'coupon',
            'products' => function ($query) {
            // Load products without it's autoload relations
            $query->withoutGlobalScopes();
        }]);
    }

    /**
     * Generate order link
     *
     * @return string
     */
    public function getLink()
    {
        return route('orders.show', ['order' => $this->getKey()]);
    }

    /**
     * Get discount value from saved order.
     *
     * @param bool $negativeDecimal
     * @return float|int|mixed
     */
    public function getDiscount($negativeDecimal = false)
    {
        $discount = $this->subtotal_price - $this->total_price;

        return $negativeDecimal ? $discount : abs($discount);
    }

    /**
     * Get total amount of products for given order.
     *
     * @return int
     */
    public function getCountProductsAttribute()
    {
        return $this->products->reduce(function (int $quantity, Product $product) {
            return $quantity + $product->pivot->qty;
        });
    }
}
