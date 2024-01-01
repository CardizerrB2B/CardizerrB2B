<?php

namespace App\Http\Resources\Distributors\PurchaseOrders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PurchaseOrderDetailsCollection extends ResourceCollection
{
    public $collects = PurchaseOrderDetailResource::class;

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
