<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BonusGameStoreRequest extends FormRequest
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
            'mobile_id' => 'required|string',
            'store_id' => 'integer|exists:stores,id',
            'win' => 'required|numeric',
            'game_id' => 'required|unique:bonus_games',
        ];
    }

    public function messages()
    {
        return [
            'mobile_id.required' => 'поле mobile_id обязательное',
            'win.required' => 'поле сумма выигрыша обязательное',
        ];
    }

    public function failedValidation($validator)
    {
        throw new HttpResponseException(
            response()->json(['message' => $validator->errors()->first()], 400)
        );
    }
}
