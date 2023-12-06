<?php

namespace App\Http\Requests\Admins\Products;

use App\Http\Requests\APIRequest;

class DeleteRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'current_password'=>'required|min:6'
        ];
    }
}
