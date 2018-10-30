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
        $this->sanitize();

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

    /**
     * Sanitize inputs, if parent field is array (which was returned by multi-select as object),
     * get only ID from array.
     */
    private function sanitize()
    {
        $input = $this->all();

        if (isset($input['parent']) && is_array($input['parent'])) {

            $input['parent'] = $input['parent']['id'];
        }

        $this->replace($input);
    }
}
