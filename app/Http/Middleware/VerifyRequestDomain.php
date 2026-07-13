<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VerifyRequestDomain
{
    // List of allowed domains
    protected $allowedDomains = [
        'http://localhost:9099/api/matching',
    ];
    
    public function handle(Request $request, Closure $next)
    {
        $domain = $request->input('domain'); // sent in POST body
        $cnic = $request->input('cnic');     // sent in POST body

        // 1️⃣ Check domain
        if (!$domain || !in_array($domain, $this->allowedDomains)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized domain'
            ], 401);
        }

        // 2️⃣ Auto-login user by CNIC if not logged in
        if (!Auth::check() && $cnic) {
            $user = User::where('cnic', $cnic)->first();
            if ($user) {
                Auth::loginUsingId($user->id);
            }
        }

        // 3️⃣ If still not authenticated, return failure
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication failed'
            ], 401);
        }
         return response()->json([
                        'success' => true,
                        'redirect' => route('dashboard')
                    ]);

        // 4️⃣ Continue request
        return $next($request);
    }
}
