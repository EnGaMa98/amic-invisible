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

        // Scope to authenticated user
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        }

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

        // Assign user on creation
        if (!$group->exists && auth()->check()) {
            $group->user_id = auth()->id();
        }

        $group->save();

        return new GroupResource($group->fresh());
    }

    public function duplicate(Group $group, Request $request): GroupResource
    {
        $fields = $request->input('fields', []);

        $newGroup = Group::create(array_merge([
            'user_id' => auth()->id(),
            'description' => $group->description,
            'budget' => $group->budget,
            'event_date' => $group->event_date,
            'status' => 'draft',
        ], $fields));

        foreach ($group->participants as $participant) {
            $newGroup->participants()->create([
                'name' => $participant->name,
                'email' => $participant->email,
            ]);
        }

        return new GroupResource($newGroup->load('participants'));
    }

    public function delete(Group $group): void
    {
        $group->delete();
    }
}
