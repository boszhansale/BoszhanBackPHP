<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderUpdateRequest extends FormRequest
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
            'status_id' => 'exists:statuses,id',
            'payment_type_id' => 'exists:payment_types,id',
            'payment_status_id' => 'exists:payment_statuses,id',
            'payment_full' => '',
            'payment_partial' => '',
            'winning_name' => '',
            'winning_phone' => '',
            'winning_status' => '',
            'delivery_date' => '',
            'delivered_date' => '',

            'baskets' => 'array|min:1',
            'baskets.*.id' => 'required',
            'baskets.*.type' => 'required|in:0,1',
            'baskets.*.product_id' => 'required|exists:products,id',
            'baskets.*.count' => 'required',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function failedValidation($validator)
    {
        throw new HttpResponseException(
            response()->json(['message' => $validator->errors()->first()], 400)
        );
    }
}
