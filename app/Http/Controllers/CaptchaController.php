<?php

namespace App\Http\Controllers;

use App\Models\Biometric;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;


class CaptchaController extends Controller
{
    public function generateCaptcha()
    {
        // Generate a 6-character code
        $code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 4);
        Session::put('captcha_code', $code);
        Session::put('captcha_time', now());

        // Image dimensions
        $width = 150;
        $height = 60;
        $image = imagecreatetruecolor($width, $height);

        // Colors
        $bgColor = imagecolorallocate($image, 230, 240, 245);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        $borderColor = imagecolorallocate($image, 150, 150, 150);
        $noiseColor = imagecolorallocate($image, 200, 210, 215);


        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);


        for ($i = 0; $i < 100; $i++) {
            imagesetpixel($image, rand(0, $width), rand(0, $height), $noiseColor);
        }


        imagerectangle($image, 0, 0, $width - 1, $height - 1, $borderColor);


        $font = public_path('/fonts/Super Rugged.ttf');


        $x = 20;
        foreach (str_split($code) as $char) {
            $fontSize = 24;

            $xOffset = rand(-5, 5);
            $yOffset = rand(-5, 5);
            $xPos = $x + $xOffset;
            $yPos = 45 + $yOffset;
            imagettftext($image, $fontSize, 0, $xPos, $yPos, $textColor, $font, $char);
            $x += 30;
        }

        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }

    public function validateCaptcha(Request $request)
    {
        $request->validate([
            'captcha' => ['required', function ($attribute, $value, $fail) {
                $stored = Session::pull('captcha_code');
                $generatedAt = Session::pull('captcha_time');

                if (!$stored || strtolower($value) !== strtolower($stored)) {
                    $fail('The CAPTCHA is incorrect.');
                    return;
                }

                if (!$generatedAt || now()->diffInSeconds($generatedAt) > 120) {
                    $fail('The CAPTCHA has expired. Please refresh and try again.');
                }
            }],
        ]);

        return back()->with('success', 'CAPTCHA passed!');
    }
    public function ThumbLogin(Request $request){

        $request->validate([
            'cnic' => 'required|size:13',
            'template1' => 'required|string',
            'MatchingSDK' => 'required|integer',
            'templateType' => 'required|integer',
        ]);
        
        $bio = Biometric::where('cnic',$request->cnic)->latest()
        ->first();   // Prepare payload for Matching API
        // return response()->json($bio);
        
        
        $payload = [
            "template1" => $request->template1,
            "template2" => $bio->template,
            "MatchingSDK" => $request->MatchingSDK,
            "templateType" => $request->templateType
        ];
        

        // return response()->json($payload);
        try {
            // Call Matching API
            $response = Http::post('http://localhost:9099/api/Matching', $payload);


            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Matching API error'
                ], 500);
            }

            $matchData = $response->json();
            return response()->json($matchData);

            // Check matching score or status from API response
            // Assuming API returns something like { "IsMatched": true, "Score": 95 }
            if (isset($matchData['IsMatched']) && $matchData['IsMatched']) {
                // Fingerprint matched, log in user
                // Here, you should find the user in your database using ID or other logic
                // For demo, we assume user_id = 1
                $user = \App\Models\User::find(1);
                if ($user) {
                    Auth::login($user);
                    return response()->json([
                        'success' => true,
                        'message' => 'Login successful',
                        'user' => $user
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'User not found'
                    ], 404);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Fingerprint did not match'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkCnic(Request $request){

        $request->validate([
        'cnic' => ['required', 'digits:13'],
    ]);
    $user = User::where('cnic',$request->cnic)->exists();
    if($user){
        $biometric = Biometric::where('cnic', $request->cnic)
            ->latest()
            ->first();
            if (!$biometric) {
        return response()->json([
            'exists' => false,
            'message' => 'No Biometric Record Found.'
        ], 404);
    }

    return response()->json([
        'exists'   => true,
        'template' => $biometric->template, // DB fingerprint template
        'message'  => 'CNIC verified'
    ], 200);
    }
    else{
          return response()->json([
            'exists' => false,
            'message' => 'CNIC not Registered.'
        ], 404);
    }

    

    }

    

}

