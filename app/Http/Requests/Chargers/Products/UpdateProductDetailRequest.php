<?php

namespace App\Http\Requests\Chargers\Products;

use App\Http\Requests\APIRequest;

class UpdateProductDetailRequest extends APIRequest
{
 
    public function rules(): array
    {
        return [
            'current_password'=>'required|string',
            'product_secure_type_value'=>'required|string',
        ];
    }
}
