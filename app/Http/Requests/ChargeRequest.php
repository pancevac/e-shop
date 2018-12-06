<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class ChargeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'city' => 'required',
            'country' => 'required',
            //'postal_code' => 'required|numeric',
            'address1' => 'required',
            'stripe_token' => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'Ime je obavezno',
            'last_name.required' => 'Prezime je obavezno',
            'email.required' => 'Email adresa je obavezna',
            'email.email' => 'Neodgovarajući format email adrese',
            'country.required' => 'Država je obavezna',
            'city.required' => 'Grad je obavezan',
            'postal_code.required' => 'Poštanski broj je obavezan',
            'address1.required' => 'Adresa je obavezna',
            'stripe_token.required' => 'Neuspela potvrda ispravnosti kreditne kartice',
        ];
    }

    /**
     * Get sanitized input data
     * Override parent validationData()
     *
     * @return array
     */
    protected function validationData()
    {
        $this->sanitize();

        return $this->all();
    }

    /**
     * Sanitize input data
     */
    protected function sanitize()
    {
        $input = $this->all();

        if (auth()->check()) {
            $input['email'] = auth()->user()->email;
        }

        $this->replace($input);
    }

    /**
     * Get validator instance and call after validation hook
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        // After validation hook
        $validator->after(function ($validator) {

            // If user is guest and submit email that is already in database, return message
            if (auth()->guest()) {
                if (User::whereEmail($this->input('email'))->first()) {
                    return redirect()->back()
                        ->withInput()
                        ->with('message', 'Korisnički nalog sa datom email adresom već postoji, molimo prvo se ulogujte.');
                }
            }
        });

        return $validator;
    }
}
