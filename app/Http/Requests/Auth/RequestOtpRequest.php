<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;

class RequestOtpRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'fields.email' => ['required', 'email', 'exists:users,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'fields.email.exists' => 'Aquest correu electrònic no està registrat.',
        ];
    }
}
