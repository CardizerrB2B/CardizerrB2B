<?php

namespace App\Http\Resources\Admins\PurchaseOrders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
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
            'admin_id' => $this->admin_id,
            'distributor_id' => $this->distributor_id,
            'total' => $this->total,
            'VAT' => $this->VAT,
            'total' => $this->total,
            'status' => $this->status,
            'is_invoiced' => $this->is_invoiced,
            'is_credit' => $this->is_credit,
            'finished' => $this->finished,
            
        ];
    }
}
