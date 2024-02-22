<?php

namespace App\Http\Requests\Common\Chats;

use App\Http\Requests\APIRequest;

class SendTextMessageRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'message'=>'required|string|max:500',
            'chat_id'=>'required|exists:chats,id',
        ];
    }
}
