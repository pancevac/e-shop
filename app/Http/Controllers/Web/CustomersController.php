<?php

namespace App\Http\Controllers\Web;

use App\Customer;
use App\Http\Requests\ChangeCustomerPassword;
use App\Http\Requests\UpdateCustomerRequest;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{
    /**
     * Return logged customer
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function profile()
    {
        // Get logged user with customer relationship
        $user = auth()->user()->load('customer');

        return view('pages.profile', [
            'user' => $user,
        ]);
    }

    /**
     * Update customer profile
     *
     * @param UpdateCustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(UpdateCustomerRequest $request)
    {
        // Retrieve customer model
        $customer = Customer::where('user_id', auth()->id())->first();
        $user = User::where('id', auth()->id());

        // Update customer
        $customer->update($request->except('email'));
        $user->update($request->only('email'));

        return redirect()->back()->with('success', 'Uspešno ažuriran nalog');
    }

    public function showChangePasswordForm()
    {
        return view('pages.change_password');
    }

    /**
     * Method for changing customer password
     *
     * @param ChangeCustomerPassword $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(ChangeCustomerPassword $request)
    {
        // Get user model instance and update password
        $user = User::find(auth()->id());

        $user->password = $request->get('password');
        $user->save();

        return redirect()->back()->with('success', 'Uspešno promenjena lozinka');
    }

    /**
     * Show customer orders
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders()
    {
        $orders = Order::with('products')
            ->where('customer_id', auth()->user()->customer->id)
            ->get();

        return view('pages.orders', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show customer order
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOrder(Order $order)
    {
        if ($order->customer_id != auth()->user()->customer->id) {
            return redirect('/');
        }

        return view('pages.successful-purchase', [
            'order' => $order->getOrder(),
        ]);
    }
}
