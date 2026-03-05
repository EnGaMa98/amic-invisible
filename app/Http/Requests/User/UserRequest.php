<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'fields.name' => ['required', 'string', 'max:255'],
            'fields.email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
        ];
    }
}
