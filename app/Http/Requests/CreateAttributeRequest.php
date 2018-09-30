<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAttributeRequest extends FormRequest
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
            'title' => 'required',
            'property_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Naziv atributa je obavezan!',
            'property_id.required' => 'Osobina je obavezna!',
        ];
    }
}
