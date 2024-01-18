<?php

namespace App\Http\Resources\Common\Wallets;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' =>$this->user_id,
            'bank_name' =>$this->bank_name,
            'account_number' =>$this->account_number,
            'IBAN'=>$this->IBAN,
            'account_ownerName'=>$this->account_ownerName,

            'status' =>$this->status,
            'verified' =>$this->verified,
            'verified_date' =>$this->verified_date,
       

        ];
    }
}
