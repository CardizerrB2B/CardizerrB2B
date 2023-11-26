<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\APIRequest;

class SearchUserRequest extends APIRequest
{
    public function rules(): array
    {
        return [
            'key' =>'required|string',
        ];
    }
}
