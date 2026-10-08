<?php

namespace App\Services;

use App\Contracts\OTPInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SMSOTPService implements OTPInterface
{
    public function send(string $recipient, string $smsText): bool
    {
        try {

            $securityKey = config('services.sms.key');

            $url = config('services.sms.secret');

            $response = Http::asForm()
                ->timeout(30)
                ->post($url, [
                    'phone_no' => $recipient,
                    'sms_text' => $smsText,
                    'sec_key' => $securityKey,
                    'sms_language' => 'english',
                ]);

            $ok = $response->successful();

            if ($ok) {

                $smsCount = \App\Models\SmsCount::firstOrCreate(
                    ['provider' => 'mda'],
                    ['count' => 0]
                );

                $smsCount->increment('count');
            }

            return $ok;

        } catch (\Exception $e) {

            Log::error('Error sending OTP via SMS: ' . $e->getMessage());

            return false;
        }
    }
}