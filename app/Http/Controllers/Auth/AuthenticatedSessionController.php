<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate(['login' => 'required|string',
            'password' => 'required|string',
            'captcha' => ['required', function ($attribute, $value, $fail) {
                $stored = Session::pull('captcha_code');
                if (!$stored || strtolower($value) !== strtolower($stored)) {
                    $fail('The CAPTCHA is incorrect or has expired.');
                }
            }],
        ]);
        $request->authenticate();

        $request->session()->regenerate();

        if(Auth::user()->hasRole('admin')){
            return redirect()->intended('users');
        }
        if(Auth::user()->hasRole('QA')){
            return redirect('/dashboard');
        }
        if(Auth::user()->hasRole('user')){
            return redirect('/properties-list');
        }
        if(Auth::user()->hasRole('record-clerk')){
            return redirect('/transfer-request-file');
        }
        if(Auth::user()->hasRole('director')){
            return redirect('/dashboard');
        }
   
            return redirect('/form');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
