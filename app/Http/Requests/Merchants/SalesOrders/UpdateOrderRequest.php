<?php

namespace App\Http\Requests\Merchants\SalesOrders;

use App\Http\Requests\APIRequest;

class UpdateOrderRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'shipping_cost' =>'nullable|numeric',
            'note'=>'nullable|string'
        ];
    }
}
