<?php

namespace App\Http\Requests\Admins\Products;

use App\Http\Requests\APIRequest;

class UpdateCategoryRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'current_password'=>'required|string',
            'name'=>'required|string|unique:categories,name,'.$this->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'

        ];
    }
}
