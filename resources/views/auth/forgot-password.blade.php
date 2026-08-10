<x-guest-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #A5D6A7;
            --navy-dark: #1B5E20;
            --gold: #f5a623;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-900: #111827;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-image: linear-gradient(rgba(9, 38, 20, 0.55), rgba(9, 38, 20, 0.55)), url('{{ asset('mirpurback.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        .w-full.sm\:max-w-md,
        .bg-white,
        .shadow-md,
        .rounded-lg,
        .overflow-hidden {
            background: transparent !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            padding: 0 !important;
            max-width: none !important;
        }

        .fp-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            min-height: 100vh;
        }

        .fp-card {
            position: relative;
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(6px);
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            padding: 46px 40px 40px;
            overflow: hidden;
            text-align: center;
        }

        .fp-card::before {
            content: "";
            position: absolute;
            top: -70px;
            right: -70px;
            width: 200px;
            height: 200px;
            background: rgba(165, 214, 167, 0.25);
            border-radius: 50%;
        }

        .fp-card::after {
            content: "";
            position: absolute;
            bottom: -80px;
            left: -60px;
            width: 220px;
            height: 220px;
            background: rgba(245, 166, 35, 0.12);
            border-radius: 50%;
        }

        .fp-icon {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 78px;
            height: 78px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--navy), var(--navy-dark));
            box-shadow: 0 10px 25px rgba(27, 94, 32, 0.35);
            margin-bottom: 20px;
        }

        .fp-icon svg {
            width: 36px;
            height: 36px;
            stroke: #fff;
        }

        .fp-card h2 {
            position: relative;
            z-index: 2;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 10px;
        }

        .fp-card p.fp-desc {
            position: relative;
            z-index: 2;
            font-size: 13.5px;
            color: var(--gray-500);
            line-height: 1.65;
            margin-bottom: 26px;
            padding: 0 6px;
        }

        .fp-status {
            position: relative;
            z-index: 2;
            background: #ecfdf5;
            border: 1px solid #6ee7b7;
            color: #065f46;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13.5px;
            margin-bottom: 18px;
            text-align: left;
        }

        .fp-field {
            position: relative;
            z-index: 2;
            text-align: left;
            margin-bottom: 22px;
        }

        .fp-field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 6px;
        }

        .fp-field .input-wrap {
            position: relative;
        }

        .fp-field .input-wrap svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            stroke: var(--gray-500);
            pointer-events: none;
        }

        .fp-field input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            font-size: 14.5px;
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            background: #fff;
            color: var(--gray-900);
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .fp-field input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(245, 166, 35, 0.12);
        }

        .fp-field .error-text {
            font-size: 12px;
            color: #ef4444;
            margin-top: 5px;
        }

        .fp-submit {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 13px 0;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(120deg, var(--navy), var(--navy-dark));
            border: none;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(15, 45, 89, 0.3);
            transition: all 0.2s ease;
        }

        .fp-submit:hover {
            background: var(--gold);
            color: var(--navy-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(245, 166, 35, 0.35);
        }

        .fp-back {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 22px;
            font-size: 13.5px;
            color: var(--gray-500);
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .fp-back svg { width: 15px; height: 15px; stroke: currentColor; }

        .fp-back:hover { color: var(--navy-dark); }

        @media (max-width: 480px) {
            .fp-card { padding: 36px 24px 30px; border-radius: 16px; }
            .fp-icon { width: 68px; height: 68px; }
            .fp-icon svg { width: 30px; height: 30px; }
            .fp-card h2 { font-size: 1.3rem; }
        }
    </style>

    <div class="fp-wrapper">
        <div class="fp-card">
            <div class="fp-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="10" rx="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    <circle cx="12" cy="16" r="1.5" fill="#fff" stroke="none"/>
                </svg>
            </div>

            <h2>{{ __('Forgot Password?') }}</h2>
            <p class="fp-desc">
                {{ __('No problem. Enter the email address linked to your account and we will send you a link to reset your password.') }}
            </p>

            @if (session('status'))
                <div class="fp-status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="fp-field">
                    <label for="email">{{ __('Email Address') }}</label>
                    <div class="input-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 6-10 7L2 6"/>
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="error-text" />
                </div>

                <button type="submit" class="fp-submit">
                    {{ __('Send Reset Link') }}
                </button>
            </form>

            <a href="{{ route('login') }}" class="fp-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                {{ __('Back to Login') }}
            </a>
        </div>
    </div>
</x-guest-layout>
