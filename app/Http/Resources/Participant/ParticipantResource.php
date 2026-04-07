<?php

namespace App\Http\Resources\Participant;

use App\Http\Resources\BaseResource;

class ParticipantResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'fields' => [
                'name' => $this->name,
                'email' => $this->email,
                'preferences' => $this->preferences,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
