<?php

namespace App\Http\Resources\Marchents\SalesOrders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SalesOrdersCollection extends ResourceCollection
{
    public $collects = SalesOrderResource::class;

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
