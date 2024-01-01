<?php

namespace App\Http\Resources\Marchents\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
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
            'master_store_id'=>$this->master_store_id,
            'PO_id'=>$this->PO_id,
            'product_secure_type_value'=>$this->product_secure_type_value,
            'charger_id'=>$this->charger_id,
            'isCharger'=>$this->isCharger,
            'charger_date'=>$this->charger_date,
            'sales_order_id'=>$this->sales_order_id,
            'marchent_id'=>$this->marchent_id??'',
            'isSold'=>$this->isSold,
            'sold_date'=>$this->sold_date??'',

            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,

        ];
    }
}
