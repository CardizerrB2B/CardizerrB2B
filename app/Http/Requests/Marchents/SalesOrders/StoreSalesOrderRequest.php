<?php

namespace App\Http\Requests\Marchents\SalesOrders;

use App\Http\Requests\APIRequest;

class StoreSalesOrderRequest extends APIRequest
{

    public function rules(): array
    {
        return [

            'items' => 'required|array',
            'items.*.store_item_id' => 'required|integer|exists:store_items,id',
            'items.*.master_store_id'=>'required|integer|exists:master_stores,id',
            'items.*.product_secure_type_id'=>'required|integer|exists:product_secure_types,id'

        ];
    }
}
