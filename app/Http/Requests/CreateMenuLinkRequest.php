<?php

namespace App\Http\Requests;

use App\MenuLink;
use Illuminate\Foundation\Http\FormRequest;

class CreateMenuLinkRequest extends FormRequest
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
        ];
    }

    /**
     * Define custom messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Ime linka je obavezno!'
        ];
    }
}
