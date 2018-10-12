<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRoleRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'title' => 'required|min:3|unique:roles',
            ];
        }

        if ($this->isMethod('put')) {

            return [
                'title' => [
                    'required',
                    'min:3',
                    Rule::unique('roles')->ignore($this->get('id')),
                ]
            ];
        }
    }

    /**
     * Define custom messages for errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Naziv je obavezan',
            'title.min' => 'Naziv mora sadržati minimum 3 slova.',
            'title.unique' => 'Uloga sa istim imenom već postoji!',
        ];
    }
}
