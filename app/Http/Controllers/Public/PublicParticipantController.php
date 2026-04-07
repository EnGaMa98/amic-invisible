<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Participant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicParticipantController extends Controller
{
    public function show(string $token): JsonResponse
    {
        $participant = Participant::where('token', $token)->firstOrFail();

        $assignment = Assignment::where('giver_id', $participant->id)
            ->with('receiver')
            ->first();

        if (!$assignment) {
            abort(404, 'No tens cap assignació encara.');
        }

        $group = $participant->group;

        return response()->json([
            'data' => [
                'participant' => [
                    'name' => $participant->name,
                    'preferences' => $participant->preferences,
                ],
                'receiver' => [
                    'name' => $assignment->receiver->name,
                    'preferences' => $assignment->receiver->preferences,
                ],
                'group' => [
                    'name' => $group->name,
                    'budget' => $group->budget,
                    'event_date' => $group->event_date?->format('Y-m-d'),
                    'email_body' => $group->email_body,
                ],
            ],
        ]);
    }

    public function updatePreferences(Request $request, string $token): JsonResponse
    {
        $participant = Participant::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'preferences' => 'nullable|string|max:2000',
        ]);

        $participant->update($validated);

        return response()->json([
            'data' => [
                'preferences' => $participant->preferences,
            ],
        ]);
    }
}
