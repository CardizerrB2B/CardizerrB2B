<?php

namespace App\Http\Controllers\API\Distributor\Management;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Http\Resources\Distributors\Invitations\InvitationResource;
use App\Models\User;
use App\Http\Requests\Distributors\Invitations\CheckInvitationAndStoreNewMarchentRequest;
use App\Http\Requests\Distributors\Invitations\CheckInvitationRequest;

class InvitationController extends ApiController
{
    public function storeInvitation()
    {
        $invitation = new Invitation();
        $invitation->distributor_id = auth()->user()->id;
        $invitation->generateInvitationToken();
        $invitation->save();
        
       return $this->sendResponse(new InvitationResource($invitation), __('msg.InvitationGenerated'));

    }

    public function checkInvitation(CheckInvitationRequest $request)
    {
        $invitation = Invitation::where('invitation_token', $request->invitation_token)->first();

        if (!$invitation) {
            return $this->errorStatus(__('msg.invalidInvitationToken'));//not found
        }

        if ($invitation->is_used) {
            return $this->errorStatus(__('msg.invalidInvitationToken'));//Invitation already used
        }

        if ($invitation->isTokenExpired()) {
            $invitation->is_expired = true;
            $invitation->save();    
            return $this->errorStatus(__('msg.expiredinvitationToken'));//Invitation token expired
        }

        return $this->sendResponse(new InvitationResource($invitation), __('msg.validInvitationToken'));

    }


    public function useInvitation(CheckInvitationAndStoreNewMarchentRequest $request)
    {
    
        $invitation = Invitation::where('invitation_token', $request->invitation_token)->first();

        if (!$invitation) {
            return $this->errorStatus(__('msg.invalidInvitationToken'));//not found
        }

        if ($invitation->is_used) {
            return $this->errorStatus(__('msg.invalidInvitationToken'));//Invitation already used
        }

        if ($invitation->isTokenExpired()) {
            $invitation->is_expired = true;
            $invitation->save();    
            return $this->errorStatus(__('msg.expiredinvitationToken'));//Invitation token expired
        }

        $newMarchent = User::create([
            "username" => $request->username,
            "mobile_number"=> $request->mobile_number,
            "email"=> $request->email,
            "fullname"=> $request->fullname,
            'user_type'=>'Marchent',
            'password'=>1234,//defualt password and it should be changed in the first login process 
            "distributor_id"=> $invitation->distributor_id,
            'invitation_id' => $invitation->id,
        ]);
        
        $invitation->is_used = true;
        $invitation->used_at = now();
        $invitation->used_by_id = $newMarchent->id;
        $invitation->save();

        return $this->successStatus((__('msg.successStatus')));


    }
}
