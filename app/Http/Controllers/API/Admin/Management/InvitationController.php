<?php

namespace App\Http\Controllers\API\Admin\Management;

use App\Http\Controllers\ApiController;
use App\Models\Invitation;
use App\Http\Resources\Distributors\Invitations\InvitationResource;


class InvitationController extends ApiController
{
    public function index()
    {
        $invitations = Invitation::paginate(20);
        if(!$invitations->count() > 0)
        {
            return $this->errorNotFound(__('msg.InvitationsNotFound'));
        }
        return $this->sendResponse(InvitationResource::collection($invitations), __('msg.InvitationsRetrieved'));
    }

    public function show($id)
    {
        $invitation = Invitation::find($id);
        if (!$invitation) {
            return $this->errorStatus(__('msg.InvitationNotFound'));
        }
        return $this->sendResponse(new InvitationResource($invitation), __('msg.InvitationRetrieved'));
    }
    
  
}
