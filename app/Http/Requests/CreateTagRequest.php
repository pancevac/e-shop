<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTagRequest extends FormRequest
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
            'title' => [
                'required',
                Rule::unique('tags')->ignore($this->get('id')),
            ],
            'slug' => [
                Rule::unique('tags')->ignore($this->get('id')),
            ]
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Naziv je obavezan!',
            'title.unique' => 'Dati naziv već postoji!',
            'slug.unique' => 'Dati slug već postoji!',
        ];
    }
}
