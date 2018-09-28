<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBrandRequest extends FormRequest
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
            'title' => 'required|unique:brands',
            'order' => 'numeric'
        ];
    }

    /**
     * Custom error messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Ime brenda je obavezno!',
            'title.unique' => 'Ime je već zauzeto!',
            'order.numeric' => 'Redosled mora biti napisan cifrom!'
        ];
    }
}
