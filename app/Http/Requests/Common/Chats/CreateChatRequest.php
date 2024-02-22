<?php

namespace App\Http\Requests\Common\Chats;

use App\Http\Requests\APIRequest;

class CreateChatRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'users'=>'required|array|min:1',
            'users.*'=>'sometimes|exists:users,id',
            'isPrivate'=>'required|boolean',
        ];
    }
}
