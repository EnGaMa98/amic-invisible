<?php

namespace App\Http\Controllers\Assignment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\GetRequest;
use App\Models\Group;
use App\Services\Assignment\AssignmentService;
use Exception;

class AssignmentController extends Controller
{
    protected AssignmentService $service;

    public function __construct()
    {
        $this->service = new AssignmentService();
    }

    public function index(Group $group, GetRequest $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'No tens permisos per veure les assignacions.'], 403);
        }

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

    public function sendEmails(Group $group)
    {
        try {
            $sent = $this->service->sendEmails($group);

            return response()->json([
                'message' => "{$sent} correus enviats correctament.",
                'count' => $sent,
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
