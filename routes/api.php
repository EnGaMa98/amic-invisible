<?php

use App\Http\Controllers\Assignment\AssignmentController;
use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\Participant\ParticipantController;
use Illuminate\Support\Facades\Route;

// Groups
Route::prefix('groups')->group(function () {
    Route::get('/', [GroupController::class, 'index']);
    Route::post('/', [GroupController::class, 'save']);

    Route::prefix('{group}')->group(function () {
        Route::get('/', [GroupController::class, 'get']);
        Route::put('/', [GroupController::class, 'save']);
        Route::delete('/', [GroupController::class, 'delete']);

        // Participants
        Route::prefix('participants')->group(function () {
            Route::get('/', [ParticipantController::class, 'index']);
            Route::post('/', [ParticipantController::class, 'save']);
            Route::put('/{participant}', [ParticipantController::class, 'save']);
            Route::delete('/{participant}', [ParticipantController::class, 'delete']);
        });

        // Assignments
        Route::get('/assignments', [AssignmentController::class, 'index']);
        Route::post('/draw', [AssignmentController::class, 'draw']);
        Route::post('/send-emails', [AssignmentController::class, 'sendEmails']);
    });
});
