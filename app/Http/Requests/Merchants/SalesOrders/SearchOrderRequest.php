<?php

namespace App\Http\Requests\Merchants\SalesOrders;

use App\Http\Requests\APIRequest;
class SearchOrderRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'key' =>'nullable|string',
        ];
    }
}
