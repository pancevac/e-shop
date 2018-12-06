<?php

namespace App;

use App\Traits\ShoppingCartTrait;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use ShoppingCartTrait;

    // Relations

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
     * @param string $status
     * @param null $error
     */
    public function makeOrder($status = 'success', $error = null)
    {
        $this->transaction_identifier = json_decode(request()->input('stripe_token'))->card->id;
        $this->customer_id = auth()->check() ? auth()->user()->customer->getKey() : null;
        $this->coupon_id = session()->has('coupon') ? session()->get('coupon')->id : null;
        $this->first_name = request()->input('first_name');
        $this->last_name = request()->input('last_name');
        $this->email = request()->input('email');
        $this->address1 = request()->input('address1');
        $this->address2 = request()->input('address2');
        $this->country = request()->input('country');
        $this->city = request()->input('city');
        $this->postal_code = request()->input('postal_code');
        $this->phone = request()->input('phone');
        $this->note = request()->input('note');
        $this->is_paid = false; // Posle staviti true ako se plati preko kartice
        $this->is_delivered = false;
        $this->total_price = $this->getTotalPrice();
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

        foreach ($this->getShoppingCartItems() as $shoppingCartItem) {

            $syncProducts[$shoppingCartItem['id']] = [
                'qty' => $shoppingCartItem['qty'],
                'price' => $this->getPricePerProduct($shoppingCartItem),
            ];
        }

        // Finally, sync(attach) products with order
        $orderInstance->products()->sync($syncProducts);

    }
}
