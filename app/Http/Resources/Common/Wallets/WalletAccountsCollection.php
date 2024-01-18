<?php

namespace App\Http\Resources\Common\Wallets;

use App\Models\WalletDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WalletAccountsCollection extends ResourceCollection
{
    public $collects = WalletAccountResource::class;

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
