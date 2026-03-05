<?php

namespace App\Services\User;

use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserService extends BaseService
{
    public function getModel(): Model
    {
        return new User();
    }

    public function query(array $include = [], array $filter = []): Builder
    {
        $query = $this->getModel()->newQuery();

        if ($filter['email'] ?? false) {
            $query->where('email', 'like', '%' . $filter['email'] . '%');
        }

        if ($filter['name'] ?? false) {
            $query->where('name', 'like', '%' . $filter['name'] . '%');
        }

        return $query;
    }

    public function get(array $include = [], array $filter = [], array $sort = [], int $perPage = 25)
    {
        $query = $this->query($include, $filter);

        $query = $this->sortBy($query, $sort);

        return UserResource::paginate($query->paginate($perPage));
    }

    public function save(User $user, Request $request): UserResource
    {
        $fields = $request->input('fields', []);

        $user->fill($fields);
        $user->save();

        return new UserResource($user->fresh());
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
