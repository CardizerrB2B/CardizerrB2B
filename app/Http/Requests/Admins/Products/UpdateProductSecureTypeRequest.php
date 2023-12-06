<?php

namespace App\Http\Requests\Admins\Products;

use App\Http\Requests\APIRequest;

class UpdateProductSecureTypeRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'current_password'=>'required|string',
            'name'=>'required|string'
        ];
    }
}
