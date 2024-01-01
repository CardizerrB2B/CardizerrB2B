<?php

namespace App\Http\Resources\Marchents\SalesOrders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesOrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'SO_id' => $this->SO_id,
            'store_item_id' => $this->store_item_id,
            'master_store_id' => $this->master_store_id,
            'item_code' => $this->item_code,
            'product_secure_type_id' => $this->product_secure_type_id,
            'product_secure_type_value' => $this->product_secure_type_value,
            'item_price' => $this->item_price,
            
        ];
    }
}
