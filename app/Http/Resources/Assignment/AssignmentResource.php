<?php

namespace App\Http\Resources\Assignment;

use App\Http\Resources\BaseResource;
use App\Http\Resources\Participant\ParticipantResource;

class AssignmentResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'fields' => [
                'sent_at' => $this->sent_at,
                'created_at' => $this->created_at,
            ],
            'giver' => $this->relationLoaded('giver') ? new ParticipantResource($this->giver) : null,
            'receiver' => $this->relationLoaded('receiver') ? new ParticipantResource($this->receiver) : null,
        ];
    }
}
