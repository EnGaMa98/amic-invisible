<?php

namespace App\Services\Participant;

use App\Http\Resources\Participant\ParticipantResource;
use App\Models\Group;
use App\Models\Participant;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ParticipantService extends BaseService
{
    public function getModel(): Model
    {
        return new Participant();
    }

    public function query(array $include = [], array $filter = []): Builder
    {
        $query = $this->getModel()->newQuery();

        if ($filter['group_id'] ?? false) {
            $query->where('group_id', $filter['group_id']);
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
            return new ParticipantResource($query->findOrFail($filter['id']));
        }

        $query = $this->sortBy($query, $sort);

        return ParticipantResource::paginate($query->paginate($perPage));
    }

    public function save(Group $group, Participant $participant, Request $request): ParticipantResource
    {
        $fields = $request->input('fields', []);

        $participant->group_id = $group->id;
        $participant->fill($fields);
        $participant->save();

        return new ParticipantResource($participant->fresh());
    }

    public function delete(Participant $participant): void
    {
        $participant->delete();
    }
}
