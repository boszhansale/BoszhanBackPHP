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
            'label_product_id' => 'required|exists:label_products,id',
            'composition' => 'string',
            'size' => 'string',
            'weight' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
