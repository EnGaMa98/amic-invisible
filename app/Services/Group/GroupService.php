<?php

namespace App\Services\Group;

use App\Http\Resources\Group\GroupResource;
use App\Models\Group;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GroupService extends BaseService
{
    public function getModel(): Model
    {
        return new Group();
    }

    public function query(array $include = [], array $filter = []): Builder
    {
        $query = $this->getModel()->newQuery();

        if (in_array('participants', $include)) {
            $query->with('participants');
        }

        if (in_array('assignments', $include)) {
            $query->with(['assignments.giver', 'assignments.receiver']);
        }

        if ($filter['status'] ?? false) {
            $query->where('status', $filter['status']);
        }

        if ($filter['name'] ?? false) {
            $query->where('name', 'like', '%' . $filter['name'] . '%');
        }

        return $query;
    }

    public function get(array $include = [], array $filter = [], array $sort = [], int $perPage = 25)
    {
        $query = $this->query($include, $filter);

        if ($filter['id'] ?? false) {
            return new GroupResource($query->findOrFail($filter['id']));
        }

        $query = $this->sortBy($query, $sort);

        return GroupResource::paginate($query->paginate($perPage));
    }

    public function save(Group $group, Request $request): GroupResource
    {
        $fields = $request->input('fields', []);

        $group->fill($fields);
        $group->save();

        return new GroupResource($group->fresh());
    }

    public function delete(Group $group): void
    {
        $group->delete();
    }
}
