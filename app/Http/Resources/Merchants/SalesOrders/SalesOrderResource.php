<?php

namespace App\Http\Resources\Merchants\SalesOrders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesOrderResource extends JsonResource
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
            'distributor_id' => $this->distributor_id,
            'merchant_id' => $this->merchant_id,
            'store_id' => $this->store_id,
            'VAT' => $this->VAT,
            'total' => $this->total,
            'status' => $this->status,
            'is_invoiced' => $this->is_invoiced,
            'is_credit' => $this->is_credit,
            'finished' => $this->finished,
            
        ];
    }
}
