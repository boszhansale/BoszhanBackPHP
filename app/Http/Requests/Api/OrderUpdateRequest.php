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
            'payment_type_id' => '',
            'payment_status_id' => '',
            'payment_full' => '',
            'payment_partial' => '',
            'winning_name' => '',
            'winning_phone' => '',
            'winning_status' => '',
            'delivery_date' => '',
            'delivered_date' => '',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
    public function failedValidation( $validator)
    {
        throw new HttpResponseException(
            response()->json(['message' => $validator->errors()->first()],400)
        );
    }
}
