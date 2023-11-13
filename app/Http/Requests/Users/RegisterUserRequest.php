<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\APIRequest;

class RegisterUserRequest extends APIRequest
{
 
    public function rules(): array
    {
        return [
            "username" => "string|required|unique:users",
            "password"=> "string|required|min:6", 
            "mobile_number"=>"numeric|required|unique:users",
            "email"=>"email|required|unique:users",
            "fullname"=>"string|required",
            "user_type"=>"string|required|in:SA,Admin,Distributor,Marchent,Charger",


        ];
    }
}

