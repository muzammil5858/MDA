<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\OTPInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;


class SmsOtpController extends Controller
{
    public function __construct(private OTPInterface $otpService) {}

    public function send(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
        ]);

        $phone = $validated['phone'];

        // Generate OTP (adjust to however you already generate/store it)
        $otp = (string) random_int(100000, 999999);

        // Store it (cache, DB, etc.) with an expiry so you can verify it later
        Cache::put('otp:'.$phone, $otp, now()->addMinutes(5));

        $smsText = 'Your OTP (One-Time Password) is: '.$otp.'. Please use it to log in to your account in Women Working Hostel.';

        $sent = $this->otpService->send($phone, $smsText);

        if (!$sent) {
            return response()->json([
                'message' => 'Failed to send OTP. Please try again later.',
            ], 500);
        }

        return response()->json([
            'message' => 'OTP sent successfully.',
        ]);
    }
}
