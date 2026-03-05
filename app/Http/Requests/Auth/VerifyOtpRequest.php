<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;

class VerifyOtpRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'fields.email' => ['required', 'email'],
            'fields.code' => ['required', 'string', 'size:6'],
        ];
    }
}
