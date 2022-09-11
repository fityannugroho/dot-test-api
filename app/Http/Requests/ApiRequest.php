<?php

namespace App\Http\Requests;

use App\Traits\ApiResponser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * This class is used to validate the request data and return a Bad Request response (400) if the data is invalid.
 */
class ApiRequest extends FormRequest
{
    use ApiResponser;

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->error(
            array_merge(...array_values($validator->errors()->toArray())),
            400
        ));
    }
}
