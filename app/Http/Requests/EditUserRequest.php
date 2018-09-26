<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
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
            'name' => 'required',
            'password' => 'nullable|confirmed|min:6',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->segment(3)),
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ime je obavezno',
            'email.required' => 'Email adresa je obavezna',
            'email.email' => 'Email adresa nije u ispravnom formatu',
            'email.unique' => 'Email adresa je zauzeta',
            'password.confirmed' => 'Lozinka nije ispravno potvrđena',
            'password.min' => 'Lozinka mora imati minimum 6 karaktera',
        ];
    }
}
