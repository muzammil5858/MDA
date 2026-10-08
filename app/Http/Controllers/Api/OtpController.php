<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Otp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Contracts\OTPInterface;

class OtpController extends Controller
{
    /**
     * Generate and send an OTP.
     */
    public function generateOtp(Request $request, OTPInterface $otpService)
    {
        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $phoneNo = $request->input('phone_no');

        // Generate a 6-digit random numeric OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store or update OTP for the given phone number
        $otpRecord = Otp::updateOrCreate(
            ['phone_no' => $phoneNo],
            [
                'otp' => $otpCode,
                'expires_at' => Carbon::now()->addMinutes(5),
                'is_verified' => false
            ]
        );

        // Send OTP using the configured SMS service
        $smsText = "Your MDA verification OTP is: {$otpCode}. It will expire in 5 minutes.";
        $smsSent = $otpService->send($phoneNo, $smsText);

        if (!$smsSent) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP via SMS.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully.',
        ]);
    }

    /**
     * Verify the generated OTP.
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|string|max:15',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $phoneNo = $request->input('phone_no');
        $otpCode = $request->input('otp');

        $otpRecord = Otp::where('phone_no', $phoneNo)
            ->where('otp', $otpCode)
            ->first();

        if (!$otpRecord) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.',
            ], 400);
        }

        if ($otpRecord->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has already been verified.',
            ], 400);
        }

        if (Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired.',
            ], 400);
        }

        // Mark OTP as verified
        $otpRecord->update(['is_verified' => true]);

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.',
        ]);
    }
}
