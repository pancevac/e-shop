<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateMenuRequest extends FormRequest
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
                'title' => 'required|unique:menus',
            ];
        }

        if ($this->isMethod('put')) {
            return [
                'title' => [
                    'required',
                    Rule::unique('menus')->ignore($this->get('id')),
                ],
            ];
        }
    }

    public function messages()
    {
        return [
            'title.required' => 'Ime tipa menija je obavezno!',
            'title.unique' => 'Ime je već zauzeto!',
        ];
    }
}
