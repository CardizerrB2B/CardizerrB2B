<?php

namespace App\Http\Resources\Common\Wallets;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentTransactionResource extends JsonResource
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
            'user_id'=>$this->user_id,
            'username'=>$this->user->username??'',
            'apporvedby_id '=>$this->apporvedby_id ,

            'payment_account_id'=>$this->payment_account_id,
            'type'=>$this->type,
            'status'=>$this->status,
            'amount'=>$this->amount,
            'rejected_note'=>$this->rejected_note,
            'payment_transfer'=>$this->payment_transfer_path,

            'created_at'=>$this->created_at,
        ];
    }
}
