<?php

namespace App\Http\Requests\Chargers\Products;

use App\Http\Requests\APIRequest;

class FilterProductDetailsRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'status'=>'nullable|string|in:charged,non-charged'
        ];
    }
}
