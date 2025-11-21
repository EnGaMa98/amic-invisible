<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
class UserService
{
    public function create (array $data): User
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $validated = $validator->validate();

        return User::create($validated);
    }
}
