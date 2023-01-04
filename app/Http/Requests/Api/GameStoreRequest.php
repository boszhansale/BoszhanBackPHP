<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GameStoreRequest extends FormRequest
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
            'token' => 'required|unique:games',
            'store_id' => 'integer|exists:stores,id',
            'order_id' => 'integer|exists:orders,id',
            'total_win' => 'required|numeric',
            'loops' => 'required|array',
            'loops.*.win' => 'required|numeric|min:0',
            'loops.*.mobile_id' => 'required|unique:game_loops'
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
