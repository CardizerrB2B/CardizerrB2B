<?php

namespace App\Http\Requests\Admins\Products;

use App\Http\Requests\APIRequest;

class StoreMasterFileRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'sub_category_id'=>'required|integer|exists:sub_categories,id',
            'item_code'=>'required|string|unique:master_files,item_code',
            'description'=>'required|string',
            'retail_price'=>'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'

        ];
    }
}
