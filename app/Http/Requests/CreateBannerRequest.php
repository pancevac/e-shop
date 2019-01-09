<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBannerRequest extends FormRequest
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
            'image_text' => 'required|string',
            'button_text' => 'required|string',
            'link' => 'required',
            'active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'button_text.required' => 'Ime teksta slike je obavezno!',
            'button_text.string' => 'Ime teksta slike mora biti u tekstualnom formatu',
            'button_text.required' => 'Ime teksta dugmeta je obavezno!',
            'button_text.string' => 'Ime teksta dugmeta mora biti u tekstualnom formatu',
            'link.required' => 'Link je obavezan',
            'active.boolean' => 'Checkbox active nije ispravnog formata',
        ];
    }
}
