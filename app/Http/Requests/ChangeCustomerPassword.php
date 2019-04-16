<?php

namespace App\Http\Requests;

use App\Rules\ValidateOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangeCustomerPassword extends FormRequest
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
            'password_old' => ['required', 'min:5', new ValidateOldPassword()],
            'password' => 'required|confirmed|min:5',
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
            'password_old.required' => 'Trenutna lozinka je obavezna',
            'password_old.min' => 'Minimalan broj karaktera je 5',
            'password.required' => 'Nova lozinka je obavezna',
            'password.confirmed' => 'Nove lozinke se ne podudaraju',
            'password.min' => 'Minimalan broj karaktera je 5',
        ];
    }
}
