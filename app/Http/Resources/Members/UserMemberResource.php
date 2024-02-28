<?php

namespace App\Http\Resources\Members;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        $tokenResult = $this->createToken('Token Name');

     //   dd($tokenResult->token->expires_at);

       // dd( $this->createToken('Token Name')->accessToken->token);
       //dd($tokenResult->expires_at);
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
           
           
            'token_type' => 'Bearer',
            'token' => $tokenResult->accessToken,
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),

        ];
    }
}
