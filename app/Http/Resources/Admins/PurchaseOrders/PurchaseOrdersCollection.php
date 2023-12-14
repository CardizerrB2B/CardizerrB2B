<?php

namespace App\Http\Resources\Admins\PurchaseOrders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PurchaseOrdersCollection extends ResourceCollection
{
    public $collects = PurchaseOrderResource::class;

    public function toArray(Request $request): array
    {

        return [
            'status'=> 1 ,
            'data' => parent::toArray($request),
            'code'=>200,
            'message'=>__('msg.successStatus')
        ];
    }
}
