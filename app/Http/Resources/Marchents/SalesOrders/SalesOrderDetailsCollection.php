<?php

namespace App\Http\Resources\Marchents\SalesOrders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SalesOrderDetailsCollection extends ResourceCollection
{
    public $collects = SalesOrderDetailResource::class;

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
