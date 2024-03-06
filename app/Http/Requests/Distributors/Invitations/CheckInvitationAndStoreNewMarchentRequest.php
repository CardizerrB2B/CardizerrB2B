<?php

namespace App\Http\Requests\Distributors\Invitations;

use App\Http\Requests\APIRequest;

class CheckInvitationAndStoreNewMarchentRequest extends APIRequest
{
    
    public function rules(): array
    {
        return [
            'invitation_token' => 'required|string',
            "username" => "string|required|unique:users",
            "mobile_number"=>"numeric|required|unique:users",
            "email"=>"email|required|unique:users",
            "fullname"=>"string|required",
        ];
    }
}
