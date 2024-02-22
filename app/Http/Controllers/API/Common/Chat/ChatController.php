<?php

namespace App\Http\Controllers\API\Common\Chat;
use App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Http\Requests\Common\Chats\CreateChatRequest;
use App\Http\Requests\Common\Chats\SendTextMessageRequest;
use App\Models\ChatMessages;

use App\Http\Resources\Common\Chat\ChatResource;
use App\Http\Resources\Common\Chat\ChatMessagesResource;
use App\Http\Resources\Common\Chat\ChatCollection;
use App\Http\Resources\Common\Chat\MessageResource;
use App\Notifications\NewMessage;
use App\Events\ChatMessageSent;
use App\Events\ChatMessageStatus;

class ChatController extends ApiController
{
    public function getChats(Request $request){
        $user = $request->user();
        $chats = $user->chats()->with('participants')->get();
 
        return new ChatCollection($chats);

    }

    public function getChatById(Chat $chat,Request $request){
        if($chat->isParticipant($request->user()->id)){
            return $this->respondWithItem(new ChatMessagesResource($chat) );
        }else{
            return $this->errorNotFound();
        }
    }

    public function createChat(CreateChatRequest $request){//The chat here will be between 2 users
        $users = $request->users;
        // check if they had a chat before
       $chat =  $request->user()->chats()->whereHas('participants',function($q) use($users){// authenticated user should be one of the participants of the chat and has relation with participants tbale in the database
            $q->where('user_id', $users[0]);//the other user and we use one eleemnt of the array as we are creating a chat between 2 users
        })->first();

        //if not, create a new one
        if(empty($chat)){
        array_push( $users,$request->user()->id); //Note that the users’ array $request->users doesn’t include the authenticated user we add the user to it array_push( $users,$request->user()->id); that way is safer to protect our app from hackers to create conversations for others.
        $chat = Chat::create()->makePrivate($request->isPrivate);
        $chat->participants()->attach($users); 
        }

        return $this->respondWithItem(new ChatResource($chat) );

    }


    public function sendTextMessage(SendTextMessageRequest $request){
        $chat = Chat::find($request->chat_id);//find the chat
        if($chat->isParticipant($request->user()->id)){//check if the user is a participant in the chat
            $message = ChatMessages::create([
                'message' => $request->message,
                'chat_id' => $request->chat_id,
                'user_id' => $request->user()->id,
                'data' => json_encode(['seenBy'=>[],'status'=>'sent']) //status = sent, delivered,seen
            ]);
 
            $message =new MessageResource($message);

            // broadcast the message to all users 
            //dd(broadcast(new ChatMessageSent($message)));
            broadcast(new ChatMessageSent($message));
            

            // foreach($chat->participants as $participant){
            //     if($participant->id != $request->user()->id){
            //         $participant->notify(new NewMessage($message));
            //     }
            // }
            return $this->respondWithItem($message);

   
        }else{
            return $this->errorNotFound();
        }
    }

    public function messageStatus(Request $request,ChatMessages $message){//Note, in this function we will broadcast an event for changing the message status on the Frontend via WebSockets.
        if($message->chat->isParticipant($request->user()->id)){
            $messageData = json_decode($message->data);
            array_push($messageData->seenBy,$request->user()->id);
            $messageData->seenBy = array_unique($messageData->seenBy);
            
           //Check if all participant have seen or not
           if(count($message->chat->participants)-1 < count( $messageData->seenBy)){
                $messageData->status = 'delivered';
            }else{
                $messageData->status = 'seen';    
            }
            $message->data = json_encode($messageData);
            $message->save();

            //triggering the event
           broadcast(new ChatMessageStatus($message));

           return $this->respondWithItem(new MessageResource($message) );

        }else{
            return $this->errorNotFound();
        }
    }




    public function searchUsers(Request $request){
        $users = User::where('email','like',"%{$request->email}%")->limit(3)->get();
        return response()->json( [
            'users'=> $users ,
        ],200);
    }
    
}
