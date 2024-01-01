<?php

namespace App\Http\Resources\Distributors\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterStoreResource extends JsonResource
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
            'store_id'=>$this->store_id,
            'sub_category_id'=>$this->sub_category_id,
            'product_secure_type_id'=>$this->product_secure_type_id,
            'item_id'=>$this->item_id,
            'item_code'=>$this->item_code,
            'description'=>$this->description,
            'QTY'=>$this->QTY,
            'last_cost'=>$this->last_cost,
            'AVG_cost'=>$this->AVG_cost,
            'stock_cost'=>$this->stock_cost,

            'retail_price'=>$this->retail_price,
            'createdBy_id'=>$this->createdBy_id,
            'lastEditBy_id'=>$this->lastEditBy_id,
            'image'=>$this->image_path??'',

            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,

        ];
    }
}
