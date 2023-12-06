<?php

namespace App\Http\Requests\Admins\Products;

use App\Http\Requests\APIRequest;

class StoreSubCategoryRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'current_password'=>'required|string',
            'category_id'=>'required|integer|exists:categories,id',
            'name'=>'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'

        ];
    }
}
