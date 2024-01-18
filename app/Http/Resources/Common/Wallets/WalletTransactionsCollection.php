<?php

namespace App\Http\Resources\Common\Wallets;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WalletTransactionsCollection extends ResourceCollection
{
 
    public $collects = WalletTransactionResource::class;
    
    public function toArray(Request $request): array
    {
        return [
            'status' => 1,
            'data' => parent::toArray($request),
            'code' => '200',
            'message' => __('msg.successStatus'),
        ];   
    }
}
