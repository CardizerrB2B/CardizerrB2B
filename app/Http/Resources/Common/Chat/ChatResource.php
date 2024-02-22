<?php

namespace App\Http\Resources\Common\Chat;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Members\UserProfileResource;

class ChatResource extends JsonResource
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
            'private' => $this->private,
            'direct_message' => $this->direct_message,
            'created_at' => $this->created_at,
            'participants' => UserProfileResource::collection($this->participants),
        ];
    }
}
