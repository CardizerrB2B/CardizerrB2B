<?php

namespace App\Http\Resources\Distributors\Invitations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvitationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'distributor_id' => $this->distributor_id,
            'is_used' => $this->is_used,
            'used_by_id' => $this->used_by_id,
            'invitation_token' => $this->invitation_token,
            'used_at' => $this->used_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
