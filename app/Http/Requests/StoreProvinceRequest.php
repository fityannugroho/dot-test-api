<?php

namespace App\Http\Requests;

class StoreProvinceRequest extends ApiRequest
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
            'id' => 'required|string|size:2|unique:provinces,id',
            'name' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
