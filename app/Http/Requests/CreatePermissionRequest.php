<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePermissionRequest extends FormRequest
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
                'model' => 'required',
                'ability' => 'required',
                'alias' => 'required|unique:permissions'
            ];
        }

        if ($this->isMethod('put')) {

            return [
                'model' => 'required',
                'ability' => 'required',
                'alias' => [
                    'required',
                    Rule::unique('permissions')->ignore($this->get('id')),
                ],
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
            'model.required' => 'Ime modela je obavezno.',
            'ability.required' => 'Ime funkcionalnosti je obavezno.',
            'alias.required' => 'Alias je obavezan.',
            'alias.unique' => 'Alias sa istim imenom već postoji.',
        ];
    }
}
