<?php

namespace App\Http\Resources\Members;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return[
            'id'=>$this->id,
            'username'=>$this->username,
            'img'=>'the path',
  
            'fullname'=>$this->fullname,
            'user_type'=>$this->user_type,

            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
           
           
        ];
    }
}
