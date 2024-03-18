<?php

namespace App\Http\Resources\Merchants\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MasterStoreCollection extends ResourceCollection
{
    public $collects = MasterStoreResource::class;

    public function toArray(Request $request): array
    {
        return [
            'status'=>1,
            'data'=>parent::toArray($request),
            'code'=>200,
            'message' => __('msg.successStatus'),
        ];
    }
}
