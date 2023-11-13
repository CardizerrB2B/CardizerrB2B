<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\APIRequest;

class ChangePasswordRequest extends APIRequest
{

    public function rules(): array
    {
        return [
        'current_password' => 'required|min:6',
        'new_password' => 'required|min:6',
        ];
    }
}
