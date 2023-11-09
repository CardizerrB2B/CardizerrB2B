<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class APIRequest extends FormRequest
{
    /**
     * Determine if user authorized to make this request
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * If validator fails return the exception in json form
     * @param Validator $validator
     * @return array
     */

     protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->respond([
            'status' => 0,
            'data' => [],
            'code'=> 400,
            'message' => $validator->errors()->first(),
        ],
            200));
    }
    protected function respond($data, $statusCode, $headers = [])
    {
        return response()->json($data, $statusCode, $headers);
    }

    abstract public function rules();

}
