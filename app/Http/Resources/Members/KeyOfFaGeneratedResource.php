<?php

namespace App\Http\Resources\Members;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class KeyOfFaGeneratedResource extends JsonResource
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
            'email'=>$this->email,
            'google2fa_secret'=>$this->google2fa_secret,
 
        ];
    }
}
