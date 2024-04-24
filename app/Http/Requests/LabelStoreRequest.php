<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelStoreRequest extends FormRequest
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
//            'label_product_name' => 'required',
//            'composition' => 'string',
            'size' => 'string',
//            'weight' => 'required',
//            'lang' => 'required'
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
