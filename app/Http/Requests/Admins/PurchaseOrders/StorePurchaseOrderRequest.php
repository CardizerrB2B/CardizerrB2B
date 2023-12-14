<?php

namespace App\Http\Requests\Admins\PurchaseOrders;

use App\Http\Requests\APIRequest;

class StorePurchaseOrderRequest extends APIRequest
{

    public function rules(): array
    {
        return [

            'distributor_id' => 'required|integer|exists:users,id',

            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:master_files,id',
            'items.*.QTY' => 'required|integer',
            'items.*.product_secure_type_id'=>'required|integer|exists:product_secure_types,id'

        ];
    }
}
