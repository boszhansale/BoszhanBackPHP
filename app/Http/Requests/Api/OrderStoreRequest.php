<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderStoreRequest extends FormRequest
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
            'store_id' => 'required|exists:stores,id',
            'mobile_id' => 'required|unique:orders',
            'payment_type_id' => 'exists:payment_types,id',

            'payment_full' => '',
            'payment_partial' => '',

            'winning_name' => '',
            'winning_phone' => '',
            'winning_status' => '',

            'delivery_date' => 'date',
            'salesrep_mobile_app_version' => '',

            'baskets' => 'required|array|min:1',
            'baskets.*.type' => 'required|in:0,1',
            'baskets.*.product_id' => 'required|exists:products,id',
            'baskets.*.reason_refund_id' => 'exists:reason_refunds,id',
            'baskets.*.comment' => '',
            'baskets.*.count' => 'required|min:0.01',
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
