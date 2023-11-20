<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\APIRequest;

class CreateNewUserRequest extends APIRequest
{
 
    public function rules(): array
    {
        return [
            "username" => "string|required|unique:users",
            "mobile_number"=>"numeric|required|unique:users",
            "email"=>"email|required|unique:users",
            "fullname"=>"string|required",
   
        ];
    }
}

