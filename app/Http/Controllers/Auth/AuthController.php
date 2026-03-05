<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RequestOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Resources\Auth\UserResource;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function requestOtp(RequestOtpRequest $request)
    {
        try {
            $this->service->requestOtp($request->input('fields.email'));

            return response()->json([
                'message' => 'Codi OTP enviat al correu electrònic.',
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        try {
            $result = $this->service->verifyOtp(
                $request->input('fields.email'),
                $request->input('fields.code'),
            );

            return response()->json([
                'token' => $result['token'],
                'user' => new UserResource($result['user']),
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'fields.name' => ['required', 'string', 'max:255'],
        ]);

        $user = $request->user();
        $user->update(['name' => $request->input('fields.name')]);

        return new UserResource($user->fresh());
    }

    public function logout(Request $request)
    {
        $this->service->logout($request->user());

        return response()->json([
            'message' => 'Sessió tancada correctament.',
        ]);
    }
}
