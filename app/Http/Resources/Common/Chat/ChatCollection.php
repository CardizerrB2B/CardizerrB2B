<?php

namespace App\Http\Resources\Common\Chat;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChatCollection extends ResourceCollection
{

    public $collects = ChatResource::class;
    
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
