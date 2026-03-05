<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\BaseResource;

class UserResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'fields' => [
                'name' => $this->name,
                'email' => $this->email,
                'is_admin' => $this->is_admin,
            ],
        ];
    }
}
