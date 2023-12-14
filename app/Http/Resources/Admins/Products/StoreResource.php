<?php

namespace App\Http\Resources\Admins\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'name'=>$this->name,

            'owner_id'=>$this->owner_id,
            'owner_name'=>$this->distributor->fullname??'',
            'createdBy_id'=>$this->createdBy_id,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,

        ];
    }
}
