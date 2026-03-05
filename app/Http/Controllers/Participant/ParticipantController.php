<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Participant\ParticipantRequest;
use App\Http\Requests\Shared\GetRequest;
use App\Models\Group;
use App\Models\Participant;
use App\Services\Participant\ParticipantService;

class ParticipantController extends Controller
{
    protected ParticipantService $service;

    public function __construct()
    {
        $this->service = new ParticipantService();
    }

    public function index(Group $group, GetRequest $request)
    {
        $filter = array_merge($request->input('filter'), ['group_id' => $group->id]);

        return $this->service->get(
            $request->input('include'),
            $filter,
            $request->input('sort'),
            $request->input('perPage'),
        );
    }

    public function save(Group $group, Participant $participant, ParticipantRequest $request)
    {
        return $this->service->save($group, $participant, $request);
    }

    public function delete(Group $group, Participant $participant)
    {
        if ($participant->group_id !== $group->id) {
            abort(404);
        }

        $this->service->delete($participant);

        return response()->json(['message' => 'Participant eliminat correctament.']);
    }
}
