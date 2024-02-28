<?php

namespace App\Http\Resources\Admins\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterFileResource extends JsonResource
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
            'sub_category_id'=>$this->sub_category_id,
            'sub_category_name'=>$this->subCategory->name??'',
            'item_code'=>$this->item_code,
            'description'=>$this->description,
            'retail_price'=>$this->retail_price,
            'is_active'=>$this->is_active,
            'createdBy_id'=>$this->createdBy_id,
            'lastEditBy_id'=>$this->lastEditBy_id,
            'image'=>$this->image_path??'',

            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,

        ];
    }
}
