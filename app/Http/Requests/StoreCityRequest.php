<?php

namespace App\Http\Requests;

class StoreCityRequest extends ApiRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|string|max:10|unique:cities,id',
            'name' => 'required|string|max:255',
            'province_id' => 'required|string|size:2|exists:provinces,id',
            'type' => 'required|string|in:Kabupaten,Kota',
            'postal_code' => 'required|string|size:5',
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
