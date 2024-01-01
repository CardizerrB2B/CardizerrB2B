<?php

namespace App\Http\Resources\Admins\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductDetailsCollection extends ResourceCollection
{
    public $collects = ProductDetailResource::class;

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
