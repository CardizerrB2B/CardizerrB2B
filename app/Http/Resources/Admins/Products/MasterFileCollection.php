<?php

namespace App\Http\Resources\Admins\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MasterFileCollection extends ResourceCollection
{
    public $collects = MasterFileResource::class;

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
