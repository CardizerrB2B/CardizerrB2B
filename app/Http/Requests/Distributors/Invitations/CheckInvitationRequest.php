<?php

namespace App\Http\Requests\Distributors\Invitations;

use App\Http\Requests\APIRequest;

class CheckInvitationRequest extends APIRequest
{
    
    public function rules(): array
    {
        return [
            'invitation_token' => 'required|string'

        ];
    }
}
