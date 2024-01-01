<?php

namespace App\Http\Requests\Distributors\Products;

use App\Http\Requests\APIRequest;

class UpdateMasterStoreRequest extends APIRequest
{
 
    public function rules(): array
    {
        return [
            'current_password'=>'required|string',
            'description'=>'nullable|string',
            'retail_price'=>'nullable|numeric',
        ];
    }
}
