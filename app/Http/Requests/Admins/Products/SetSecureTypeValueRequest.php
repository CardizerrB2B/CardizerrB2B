<?php

namespace App\Http\Requests\Admins\Products;

use App\Http\Requests\APIRequest;

class SetSecureTypeValueRequest extends APIRequest
{
 
    public function rules(): array
    {
        return [
            'current_password'=>'required|string',
            'product_secure_type_value'=>'required|string',
        ];
    }
}
