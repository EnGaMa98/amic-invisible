<?php

use App\Http\Controllers\Assignment\AssignmentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\Participant\ParticipantController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

// Auth (public)
Route::prefix('auth')->group(function () {
    Route::post('/request-otp', [AuthController::class, 'requestOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth (authenticated)
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Users (admin only)
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'save']);
        Route::put('/{user}', [UserController::class, 'save']);
        Route::delete('/{user}', [UserController::class, 'delete']);
    });

    // Groups
    Route::prefix('groups')->group(function () {
        Route::get('/', [GroupController::class, 'index']);
        Route::post('/', [GroupController::class, 'save']);

        Route::prefix('{group}')->group(function () {
            Route::get('/', [GroupController::class, 'get']);
            Route::put('/', [GroupController::class, 'save']);
            Route::delete('/', [GroupController::class, 'delete']);
            Route::post('/duplicate', [GroupController::class, 'duplicate']);

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
});
