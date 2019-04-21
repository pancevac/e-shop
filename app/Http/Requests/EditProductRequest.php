<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditProductRequest extends FormRequest
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
                Rule::unique('products')->ignore($this->id),
            ],
            'code' => [
                'required',
                Rule::unique('products')->ignore($this->id),
            ],
            'selectedCategories' => 'required|array|min:1',
            'selectedAttributes' => 'required|array|min:1',
            'brand_id' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'discount' => 'nullable|numeric',
            'publish_at' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Naziv je obavezan',
            'title.unique' => 'Proizvod sa datim nazivom već postoji',
            'code.required' => 'Šifra je obavezna',
            'code.unique' => 'Šifra već postoji',
            'selectedCategories.required' => 'Kategorija je obavezna',
            'selectedCategories.array' => 'Kategorija je obavezna',
            'selectedCategories.min' => 'Kategorija je obavezna',
            'brand_id.required' => 'Brend je obavezan',
            'brand_id.numeric' => 'Brend je obavezan',
            'brand_id.min' => 'Brend je obavezan',
            'selectedAttributes.required' => 'Jedan atribut je obavezan',
            'selectedAttributes.numeric' => 'Jedan atribut je obavezan',
            'selectedAttributes.min' => 'Jedan atribut je obavezan',
            'price.required' => 'Cena je obavezna',
            'price.numeric' => 'Cena je obavezna',
            'price.min' => 'Cena je obavezna',
            'discount.numeric' => 'Popust mora biti celobrojan',
            'publish_at.required' => 'Datum publikovanja je obavezan',
            'publish_at.date' => 'Datum publikovanja  nije u ispravnom formatu',
        ];
    }
}
