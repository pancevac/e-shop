<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWidgetRequest extends FormRequest
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
            'title' => 'required|string',
            'button_text' => 'required|string',
            'link' => 'required',
            'active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Ime widgeta je obavezno!',
            'title.string' => 'Ime mora biti u tekstualnom formatu',
            'button_text.required' => 'Ime teskta dugmeta je obavezno!',
            'button_text.string' => 'Ime teksta dugmeta mora biti u tekstualnom formatu',
            'link.required' => 'Link je obavezan',
            'active.boolean' => 'Checkbox active nije ispravnog formata',
        ];
    }
}
