<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\APIRequest;

class LoginUserRequest extends APIRequest
{

    public function rules(): array
    {
        return [
        'username' => 'required|string|exists:users,username',
        'password'=>'required|string',
        'new_password'=>'nullable|string'

        ];
    }
}
