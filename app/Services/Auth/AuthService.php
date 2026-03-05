<?php

namespace App\Services\Auth;

use App\Mail\OtpMail;
use App\Models\OtpCode;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function requestOtp(string $email): void
    {
        $user = User::where('email', $email)->firstOrFail();

        // Invalidate previous unused OTPs
        OtpCode::where('email', $email)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->update(['used_at' => now()]);

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $otp = OtpCode::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($email)->send(new OtpMail($user, $code));
    }

    public function verifyOtp(string $email, string $code): array
    {
        $otp = OtpCode::where('email', $email)
            ->where('code', $code)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp) {
            throw new Exception('Codi OTP invàlid o expirat.');
        }

        $otp->update(['used_at' => now()]);

        $user = User::where('email', $email)->firstOrFail();

        // Revoke previous tokens
        $user->tokens()->delete();

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
