<?php

namespace App\Http\Requests\Common\Products;

use App\Http\Requests\APIRequest;

class SearchRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'key'=>'nullable|string'
        ];
    }
}
