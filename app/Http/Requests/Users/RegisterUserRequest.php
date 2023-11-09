<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\APIRequest;

class RegisterUserRequest extends APIRequest
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
            "username" => "string|required|unique:users",
            "password"=> "string|nullable|min:6", // this field is optional as two factor and used for pay process , add post , ..etc 
            "mobile_number"=>"numeric|required|unique:users",
            "email"=>"email|nullable|unique:users",
            "fullname"=>"string|required",
        ];
    }
}

