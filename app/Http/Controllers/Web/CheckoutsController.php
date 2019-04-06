<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\ChargeRequest;
use App\Mail\OrderShipped;
use App\Order;
use App\Traits\ShoppingCartTrait;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutsController extends Controller
{
    /**
     * Show checkout page if isn't empty
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkoutPage()
    {
        if (\Cart::instance('shoppingCart')->count() == 0) {
            return redirect()->back()->with('message', 'Morate uneti makar jedan proizvod u korpu kako biste nastavili kupovinu');
        }

        $user = auth()->check() ? $this->collectLoggedCustomerInfo() : null;

        return view('pages.checkout', [
            'cartItems' => getCartItems(),
            'subTotal' => getSubtotalPrice(),
            'total' => getTotalPrice(),
            'discount' => getDiscount(),
            'user' => $user,
        ]);
    }

    /**
     * Handle charging
     *
     * @param ChargeRequest $request
     * @param Order $order
     * @return Order|\Illuminate\Http\RedirectResponse
     */
    public function submitCheckout(ChargeRequest $request, Order $order)
    {
        try {
            // Try to charge
            $this->charge();

        } catch (CardErrorException $e) {

            // If fails, create order with failed status and return error
            $order->makeOrder($request, 'failed', $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

        } catch (\Exception $e) {

            // If fails, create order with failed status and return error
            $order->makeOrder($request, 'failed', $e->getMessage());
            Log::error('Error with charging card: '.$e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }

        // Save order into db
        $order->makeOrder($request);

        // Send order mail to customer
        Mail::send(new OrderShipped($order));

        // Decrement coupon amount by one
        if (session()->has('coupon')) {

            $coupon = session()->get('coupon');
            $coupon->decrement('amount');
            session()->forget('coupon');
        }

        // Delete shopping cart items from session
        \Cart::instance('shoppingCart')->destroy();

        // set flash session for showing thank-you message for purchase
        session()->flash('first_view', true);

        // Return order info
        return view('pages.successful-purchase', [
            'order' => $order->getOrder(),
        ]);
    }

    /**
     * Charge user
     */
    protected function charge()
    {
        (new Stripe())->charges()->create([
            'amount' => getTotalPrice(),
            'currency' => 'usd',
            'description' => 'Order',
            'source' => json_decode(request()->input('stripe_token'))->id,
            'metadata' => [
                'contents' => [],
                'quantity' => getCartItemsCount(),
                'discount' => session()->has('coupon') ? session()->get('coupon')->discount : null,
            ]
        ]);
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

    /**
     * Show successful order info
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOrder(Order $order)
    {
        return view('pages.successful-purchase', [
            'order' => $order->getOrder(),
        ]);
    }
}
