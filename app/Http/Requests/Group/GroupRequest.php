<?php

namespace App\Http\Requests\Group;

use App\Http\Requests\BaseFormRequest;

class GroupRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'fields.name' => 'required|string|max:255',
            'fields.description' => 'sometimes|nullable|string',
            'fields.budget' => 'sometimes|nullable|numeric|min:0',
            'fields.event_date' => 'sometimes|nullable|date',
            'fields.status' => 'sometimes|string|in:draft,ready,drawn,sent',
        ];
    }
}
