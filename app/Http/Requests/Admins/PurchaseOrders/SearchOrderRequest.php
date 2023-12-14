<?php

namespace App\Http\Requests\Admins\PurchaseOrders;

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
