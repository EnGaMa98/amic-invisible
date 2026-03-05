<?php

namespace App\Http\Requests\Participant;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class ParticipantRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $group = $this->route('group');
        $participant = $this->route('participant');

        return [
            'fields.name' => 'required|string|max:255',
            'fields.email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('participants', 'email')
                    ->where('group_id', $group->id)
                    ->ignore($participant?->id),
            ],
        ];
    }
}
