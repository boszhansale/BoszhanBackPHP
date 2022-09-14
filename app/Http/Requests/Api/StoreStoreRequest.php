<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreStoreRequest extends FormRequest
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
            'counteragent_id' => 'exists:counteragents,id',
            'name' => 'required',
            'phone' => 'required',
            'bin' => '  ',
            'id_1c' => '',
            'district_id' => '',
            'address' => 'required',
            'lat' => '',
            'lng' => '',
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
