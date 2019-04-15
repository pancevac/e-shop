<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'address1' => 'required',
            'address2' => 'nullable',
            'city' => 'required|string',
            'country' => 'required',
            'postal_code' => 'nullable',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(auth()->id(), 'id'),
            ]
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
            'first_name.string' => 'Ime mora biti u tekstualnom formatu.',
            'first_name.min' => 'Ime mora imati minimum 2 karaktera.',
            'last_name.required' => 'Prezime je obavezno',
            'last_name.string' => 'Prezime mora biti u tekstualnom formatu.',
            'last_name.min' => 'Prezime mora imati minimum 2 karaktera.',
            'address1.required' => 'Adresa je obavezna',
            'city.required' => 'Grad je obavezan',
            'city.string' => 'Grad mora biti u tekstualnom formatu',
            'country.required' => 'Država je ovazna',
            'email.required' => 'E-mail je obavezan',
            'email.email' => 'E-mail mora biti u formatu e-mail adrese',
            'email.unique' => 'Navedena e-mail adresa već postoji!',
        ];
    }
}
