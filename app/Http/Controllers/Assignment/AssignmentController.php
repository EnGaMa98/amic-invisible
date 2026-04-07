<?php

namespace App\Http\Controllers\Assignment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\GetRequest;
use App\Models\Group;
use App\Models\Participant;
use App\Services\Assignment\AssignmentService;
use Exception;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    protected AssignmentService $service;

    public function __construct()
    {
        $this->service = new AssignmentService();
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

    public function draw(Group $group)
    {
        try {
            $count = $this->service->draw($group);

            return response()->json([
                'message' => "Sorteig realitzat correctament. {$count} assignacions creades.",
                'count' => $count,
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function sendEmails(Group $group, Request $request)
    {
        try {
            $emailBody = $request->input('fields.email_body');
            $group->update(['email_body' => $emailBody]);

            $sent = $this->service->sendEmails($group);

            return response()->json([
                'message' => "{$sent} correus enviats correctament.",
                'count' => $sent,
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function sendEmailToParticipant(Group $group, Participant $participant)
    {
        try {
            $this->service->sendEmailToParticipant($group, $participant);

            return response()->json([
                'message' => "Correu enviat a {$participant->name}.",
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
