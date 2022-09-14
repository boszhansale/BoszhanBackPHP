<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
            'store_id' => 'required|exists:stores,id',
            'salesrep_id' => 'required|exists:users,id',
            'driver_id' => 'required|exists:users,id',
            'status_id' => 'required|exists:statuses,id',
            'payment_type_id' => 'required|exists:payment_types,id',
            'payment_status_id' => 'required|exists:payment_statuses,id',
            'delivery_date' => 'required',
            'delivered_date' => 'required',
            'purchase_price' => 'required',
            'return_price' => 'required',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
