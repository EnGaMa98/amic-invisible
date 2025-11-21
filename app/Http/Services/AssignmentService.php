<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\Assignment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AssignmentMail;
use Illuminate\Support\Arr;
use Exception;
class AssignmentService
{
    public function generateAssignments(int $year): int
    {
        $users = User::all()->values();
        $count = $users->count();

        if ($count < 2) {
            throw new Exception('Se necesitan al menos 2 usuarios para generar asignaciones.');
        }

        // Borrar asignaciones previas de ese año
        Assignment::where('year', $year)->delete();

        $givers = $users->all();
        $receivers = $users->all();

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
                throw new Exception('No se pudo generar una derangement válida después de muchos intentos.');
            }
        } while (!$valid);

        $created = 0;
        for ($i = 0; $i < $count; $i++) {
            Assignment::create([
                'giver_id'    => $givers[$i]->id,
                'receiver_id' => $receivers[$i]->id,
                'year'        => $year,
            ]);
            $created++;
        }

        return $created;
    }

    public function sendEmails(?string $giverName = null, ?int $year = null): int
    {
        $year = $year ?? intval(date('Y'));
        $query = Assignment::with(['giver', 'receiver'])->where('year', $year);

        if ($giverName) {
            $query->whereHas('giver', function ($q) use ($giverName) {
                $q->where('name', $giverName);
            });
        }

        $assignments = $query->get();
        $sent = 0;

        foreach ($assignments as $assignment) {
            if (!$assignment->giver || !$assignment->receiver) {
                continue;
            }

            Mail::to($assignment->giver->email)
                ->send(new AssignmentMail($assignment->giver->name, $assignment->receiver->name));

            $sent++;
        }

        return $sent;
    }
}
