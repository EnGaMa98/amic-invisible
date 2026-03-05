<?php

namespace App\Http\Resources\Group;

use App\Http\Resources\Assignment\AssignmentResource;
use App\Http\Resources\BaseResource;
use App\Http\Resources\Participant\ParticipantResource;

class GroupResource extends BaseResource
{
    public function toArray($request): array
    {
        $result = [
            'id' => $this->id,
            'fields' => [
                'name' => $this->name,
                'description' => $this->description,
                'budget' => $this->budget,
                'event_date' => $this->event_date?->format('Y-m-d'),
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];

        if ($this->relationLoaded('participants')) {
            $result['participants'] = ParticipantResource::collection($this->participants);
        }

        if ($this->relationLoaded('assignments')) {
            $result['assignments'] = AssignmentResource::collection($this->assignments);
        }

        return $result;
    }
}
