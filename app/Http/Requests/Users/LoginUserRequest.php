<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\APIRequest;

class LoginUserRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'mobile_number' => 'required|string',
        // 'email'=> 'string',
        // 'password'=>'string'
        ];
    }
}
