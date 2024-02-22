<?php

namespace App\Http\Requests\Common\Chats;

use App\Http\Requests\APIRequest;

class CreateChatRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            //'users'=>'required|array|min:1',// for group chat
            //'users.*'=>'sometimes|exists:users,id',//for group chat
            'user_id' => 'required|exists:users,id', // for single chat
            'isPrivate'=>'required|boolean',
        ];
    }
}
