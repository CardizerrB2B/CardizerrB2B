<?php

namespace App\Http\Resources\Common\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductSecureTypeCollection extends ResourceCollection
{
    public $collects = ProductSecureTypeResource::class;
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
