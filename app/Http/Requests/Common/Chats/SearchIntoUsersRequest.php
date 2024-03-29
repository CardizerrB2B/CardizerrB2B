<?php

namespace App\Http\Requests\Common\Chats;

use App\Http\Requests\APIRequest;

class SearchIntoUsersRequest extends APIRequest
{
    
    public function rules(): array
    {
        return [
            'user_type' => 'required|in:Merchant,Charger', 
            'email' => 'nullable|email',

        ];
    }
}
