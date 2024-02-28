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
        if($this->id == auth()->user()->id){
            return[
                'id'=>$this->id,
                'username'=>$this->username,
                'mobile_number'=>$this->mobile_number,
                'email'=>$this->email,
                'fullname'=>$this->fullname,
                'user_type' => $this->user_type,
                'img'=>'the path',
                'google2fa_secret'=>$this->google2fa_secret??'',
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ];
        }else{
            return[
                'id'=>$this->id,
                'username'=>$this->username,
                'mobile_number'=>$this->mobile_number,
                'email'=>$this->email,
                'fullname'=>$this->fullname,
                'user_type' => $this->user_type,
                'img'=>'the path',
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ];}

        
    }
}
