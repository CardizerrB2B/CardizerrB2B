<?php

namespace App\Http\Resources\Admins\PurchaseOrders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderDetailResource extends JsonResource
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
            'PO_id' => $this->PO_id,
            'item_id' => $this->item_id,
            'item_code' => $this->item_code,
            'product_secure_type_id' => $this->product_secure_type_id,
            'QTY' => $this->QTY,
            'item_price' => $this->item_price,
            'total_price' => $this->total_price,
            
        ];
    }
}
