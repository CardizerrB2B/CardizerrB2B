<?php

namespace App\Http\Controllers\API\Distributor\Management;

use App\Http\Controllers\ApiController;
use App\Models\Invitation;
use App\Http\Resources\Distributors\Invitations\InvitationResource;
use App\Models\User;
use App\Http\Requests\Distributors\Invitations\CheckInvitationAndStoreNewMerchantRequest;
use App\Http\Requests\Distributors\Invitations\CheckInvitationRequest;

class InvitationController extends ApiController
{
    public function index()
    {
        $invitations = Invitation::where('distributor_id', auth()->user()->id)->paginate(20);
        if(!$invitations->count() > 0)
        {
            return $this->errorNotFound(__('msg.InvitationsNotFound'));
        }
        return $this->sendResponse(InvitationResource::collection($invitations), __('msg.InvitationsRetrieved'));
    }

    public function show($id)
    {
        $invitation = Invitation::where('distributor_id', auth()->user()->id)->find($id);
        if (!$invitation) {
            return $this->errorStatus(__('msg.InvitationNotFound'));
        }
        return $this->sendResponse(new InvitationResource($invitation), __('msg.InvitationRetrieved'));
    }

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


    public function useInvitation(CheckInvitationAndStoreNewMerchantRequest $request)
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

        $newMerchant = User::create([
            "username" => $request->username,
            "mobile_number"=> $request->mobile_number,
            "email"=> $request->email,
            "fullname"=> $request->fullname,
            'user_type'=>'Merchant',
            'password'=>1234,//defualt password and it should be changed in the first login process 
            "distributor_id"=> $invitation->distributor_id,
            'invitation_id' => $invitation->id,
        ]);
        
        $invitation->is_used = true;
        $invitation->used_at = now();
        $invitation->used_by_id = $newMerchant->id;
        $invitation->save();

        return $this->successStatus((__('msg.successStatus')));


    }
}
