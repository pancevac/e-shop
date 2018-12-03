<?php

namespace App\Http\Controllers\Web;

use App\Customer;
use App\Http\Requests\ChangeCustomerPassword;
use App\Http\Requests\UpdateCustomerRequest;
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

        return view('themes.fashiop.pages.profile', [
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

        // Update customer
        $customer->update($request->all());

        return redirect()->back()->with('message', 'Uspešno ažuriran nalog');
    }

    /**
     * Method for changing customer password
     *
     * @param ChangeCustomerPassword $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(ChangeCustomerPassword $request)
    {
        // Check if entered old password match current password of logged user
        if (Hash::check($request->input('password_old'), auth()->user()->getAuthPassword())) {

            // Get user model instance and update password
            $user = User::find(auth()->user()->getAuthIdentifier());
            // TODO check for password bug, won't log in after changes
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return redirect()->back()->with('message', 'Uspešno promenjena lozinka');
        }

        return redirect()->back()->with('error', 'Stara lozinka je netačna');
    }
}
