<?php

namespace App\Http\Requests\Admins\Products;

use App\Http\Requests\APIRequest;

class UpdateMasterFileRequest extends APIRequest
{
 
    public function rules(): array
    {
        return [
            'current_password'=>'required|string',
            'description'=>'nullable|string',
            'retail_price'=>'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}
