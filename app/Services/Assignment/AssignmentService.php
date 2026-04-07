<?php

namespace App\Services\Assignment;

use App\Http\Resources\Assignment\AssignmentResource;
use App\Mail\AssignmentMail;
use App\Models\Assignment;
use App\Models\Group;
use App\Models\Participant;
use App\Services\BaseService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class AssignmentService extends BaseService
{
    public function getModel(): Model
    {
        return new Assignment();
    }

    public function query(array $include = [], array $filter = []): Builder
    {
        $query = $this->getModel()->newQuery();

        $query->with(['giver', 'receiver']);

        if ($filter['group_id'] ?? false) {
            $query->where('group_id', $filter['group_id']);
        }

        return $query;
    }

    public function get(array $include = [], array $filter = [], array $sort = [], int $perPage = 25)
    {
        $query = $this->query($include, $filter);

        $query = $this->sortBy($query, $sort);

        return AssignmentResource::paginate($query->paginate($perPage));
    }

    public function draw(Group $group): int
    {
        $participants = $group->participants()->get()->values();
        $count = $participants->count();

        if ($count < 2) {
            throw new Exception('Es necessiten almenys 2 participants per fer el sorteig.');
        }

        $group->assignments()->delete();

        $givers = $participants->all();
        $receivers = $participants->all();

        $attempts = 0;
        do {
            $attempts++;
            shuffle($receivers);
            $valid = true;
            for ($i = 0; $i < $count; $i++) {
                if ($givers[$i]->id === $receivers[$i]->id) {
                    $valid = false;
                    break;
                }
            }
            if ($attempts > 1000) {
                throw new Exception('No s\'ha pogut generar un sorteig vàlid després de molts intents.');
            }
        } while (!$valid);

        $created = 0;
        for ($i = 0; $i < $count; $i++) {
            Assignment::create([
                'group_id' => $group->id,
                'giver_id' => $givers[$i]->id,
                'receiver_id' => $receivers[$i]->id,
            ]);
            $created++;
        }

        $group->update(['status' => 'drawn']);

        return $created;
    }

    public function sendEmails(Group $group): int
    {
        $assignments = $group->assignments()->with(['giver', 'receiver'])->get();

        if ($assignments->isEmpty()) {
            throw new Exception('No hi ha assignacions per enviar. Fes el sorteig primer.');
        }

        foreach ($assignments as $assignment) {
            if (!$assignment->giver->token) {
                $assignment->giver->update(['token' => Participant::generateToken()]);
                $assignment->giver->refresh();
            }
        }

        $sent = 0;

        foreach ($assignments as $assignment) {
            Mail::to($assignment->giver->email)
                ->send(new AssignmentMail($group, $assignment->giver, $assignment->receiver));

            $assignment->update(['sent_at' => now()]);
            $sent++;
        }

        $group->update(['status' => 'sent']);

        return $sent;
    }
}
