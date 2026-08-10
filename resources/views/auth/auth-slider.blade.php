<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    :root {
        --navy: #A5D6A7;
        --navy-dark: #1B5E20;
        --gold: #f5a623;
        --success: #10b981;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-400: #9ca3af;
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
        background-image: url('{{ asset('mirpurback.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 20px;
    }

    /* Neutralize default Jetstream/Breeze card wrapper so our slider controls layout */
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

    .swapauth-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 100vh;
    }

    /* ===================== SLIDING AUTH CONTAINER ===================== */
    .swapauth-container {
        background-color: #fff;
        border-radius: 18px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, .35);
        position: relative;
        overflow: hidden;
        width: 1000px;
        max-width: 100%;
        min-height: 620px;
    }

    .swapauth-form-container {
        position: absolute;
        top: 0;
        height: 100%;
        width: 50%;
        left: 0;
        transition: all 0.6s ease-in-out;
        overflow-y: auto;
    }

    .swapauth-sign-in {
        z-index: 2;
    }

    .swapauth-container.right-panel-active .swapauth-sign-in {
        transform: translateX(100%);
    }

    .swapauth-sign-up {
        opacity: 0;
        z-index: 1;
    }

    .swapauth-container.right-panel-active .swapauth-sign-up {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: swapauth-show 0.6s;
    }

    @keyframes swapauth-show {
        0%, 49.99% { opacity: 0; z-index: 1; }
        50%, 100%  { opacity: 1; z-index: 5; }
    }

    .swapauth-overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .swapauth-container.right-panel-active .swapauth-overlay-container {
        transform: translateX(-100%);
    }

    .swapauth-overlay {
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-dark) 100%);
        color: #fff;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .swapauth-container.right-panel-active .swapauth-overlay {
        transform: translateX(50%);
    }

    .swapauth-overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 45px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .swapauth-overlay-left {
        transform: translateX(-20%);
    }

    .swapauth-container.right-panel-active .swapauth-overlay-left {
        transform: translateX(0);
    }

    .swapauth-overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .swapauth-container.right-panel-active .swapauth-overlay-right {
        transform: translateX(20%);
    }

    .swapauth-overlay-panel h2 {
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 12px;
        position: relative;
        z-index: 2;
    }

    .swapauth-overlay-panel p {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.75);
        line-height: 1.6;
        margin-bottom: 22px;
        position: relative;
        z-index: 2;
    }

    .swapauth-ghost {
        background: transparent;
        border: 1.5px solid rgba(255,255,255,0.8);
        color: #fff;
        padding: 11px 34px;
        border-radius: 24px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        letter-spacing: 0.03em;
        transition: all 0.2s ease;
        position: relative;
        z-index: 2;
    }

    .swapauth-ghost:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: var(--navy-dark);
    }

    /* ===================== FORM STYLES ===================== */
    .login-body {
        padding: 46px 44px;
        background: #fff;
        height: 100%;
    }

    .login-body h5 {
        font-weight: 700;
        font-size: 1.35rem;
        color: var(--gray-900);
        margin-bottom: 4px;
    }

    .login-body .subtext {
        font-size: 0.85rem;
        color: var(--gray-500);
        margin-bottom: 22px;
    }

    .modern-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-600);
        margin-bottom: 6px;
        letter-spacing: 0.01em;
    }

    .modern-input {
        width: 100%;
        padding: 11px 13px;
        font-size: 14.5px;
        border: 1.5px solid var(--gray-200);
        border-radius: 10px;
        background: #fff;
        color: var(--gray-900);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        outline: none;
    }

    .modern-input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 4px rgba(245, 166, 35, 0.12);
    }

    .field-group {
        margin-bottom: 14px;
    }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    /* Captcha */
    .captcha-container {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 4px;
    }

    .captcha-input { flex: 1; }

    .captcha-image {
        height: 44px;
        width: 96px;
        border: 1.5px solid var(--gray-200);
        border-radius: 10px;
        cursor: pointer;
        object-fit: cover;
        transition: transform 0.15s ease, border-color 0.15s ease;
    }

    .captcha-image:hover { transform: scale(1.03); border-color: var(--gold); }

    .captcha-refresh {
        height: 44px;
        width: 44px;
        flex-shrink: 0;
        background: var(--navy);
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s ease, transform 0.15s ease;
    }

    .captcha-refresh:hover { background: var(--navy-dark); transform: rotate(90deg); }
    .captcha-refresh svg { width: 20px; height: 20px; }

    .remember-row {
        display: flex;
        align-items: center;
        margin-top: 2px;
    }

    .remember-row label {
        display: flex;
        align-items: center;
        font-size: 13.5px;
        color: var(--gray-600);
        cursor: pointer;
    }

    .remember-row input[type="checkbox"] {
        width: 16px;
        height: 16px;
        margin-right: 8px;
        accent-color: var(--navy);
        cursor: pointer;
    }

    .action-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-primary-modern {
        flex: 1;
        padding: 13px 0;
        font-size: 14.5px;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(120deg, var(--navy), var(--navy-dark));
        border: none;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(15, 45, 89, 0.3);
        transition: all 0.2s ease;
    }

    .btn-primary-modern:hover {
        background: var(--gold);
        color: var(--navy-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(245, 166, 35, 0.35);
    }

    .btn-finger {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(120deg, var(--navy), var(--navy-dark));
        border: none;
        border-radius: 14px;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(15, 45, 89, 0.35);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-finger:hover { transform: translateY(-1px) scale(1.03); }
    .btn-finger img, .btn-finger svg { width: 22px; height: 22px; }

    .btn-register-submit {
        margin-top: 18px;
        width: 100%;
        background: linear-gradient(120deg, var(--navy), var(--navy-dark));
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 12px 0;
        font-weight: 600;
        font-size: 14.5px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(15, 45, 89, 0.25);
    }

    .btn-register-submit:hover {
        background: var(--gold);
        color: var(--navy-dark);
        transform: translateY(-1px);
    }

    .validation-errors {
        background: #fef2f2;
        border: 1px solid #fca5a5;
        color: #991b1b;
        padding: 10px 14px;
        border-radius: 10px;
        margin-bottom: 14px;
        font-size: 13px;
    }

    .validation-errors ul { list-style: none; padding: 0; margin: 0; }
    .validation-errors li { padding: 2px 0; }

    .status-message {
        padding: 10px 14px;
        border-radius: 10px;
        margin-bottom: 14px;
        font-size: 13px;
        background: #ecfdf5;
        border: 1px solid #6ee7b7;
        color: #065f46;
    }

    .error-text {
        font-size: 12px;
        color: #ef4444;
        margin-top: 3px;
    }

    /* ===================== MODAL (fingerprint) ===================== */
    .modal {
        position: fixed;
        inset: 0;
        background: rgba(8, 27, 56, 0.65);
        backdrop-filter: blur(3px);
        z-index: 1000;
        display: none;
        justify-content: center;
        align-items: center;
        padding: 16px;
    }

    .modal.is-active { display: flex; animation: fadeInOverlay 0.2s ease; }

    @keyframes fadeInOverlay { from { opacity: 0; } to { opacity: 1; } }

    .modal-content {
        position: relative;
        background: #fff;
        border-radius: 20px;
        padding: 36px 28px 30px;
        width: 100%;
        max-width: 380px;
        text-align: center;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
        animation: modalPopIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes modalPopIn {
        from { opacity: 0; transform: scale(0.94) translateY(8px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .close {
        position: absolute;
        top: 14px;
        right: 16px;
        font-size: 24px;
        font-weight: 300;
        color: var(--gray-400);
        cursor: pointer;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.15s ease, color 0.15s ease;
        background: none;
        border: none;
    }

    .close:hover { background: var(--gray-100); color: var(--gray-900); }

    .finger-container {
        position: relative;
        display: inline-flex;
        background: linear-gradient(120deg, var(--navy), var(--navy-dark));
        border-radius: 50%;
        padding: 22px;
        color: #fff;
        margin-bottom: 18px;
        box-shadow: 0 8px 20px rgba(15, 45, 89, 0.3);
    }

    .finger-container svg { width: 46px; height: 46px; }

    #loader {
        position: absolute;
        top: -6px;
        left: -6px;
        width: 106px;
        height: 106px;
        border: 5px solid rgba(245, 166, 35, 0.2);
        border-top: 5px solid var(--gold);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: none;
    }

    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    .modal-content h2 { font-size: 19px; font-weight: 700; margin-bottom: 4px; color: var(--gray-900); }
    .modal-content p { font-size: 13.5px; color: var(--gray-500); margin-bottom: 14px; line-height: 1.5; }

    #startScanBtn {
        width: 100%;
        padding: 12px 0;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, var(--success), #059669);
        border: none;
        border-radius: 10px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        transition: all 0.2s ease;
    }

    #startScanBtn:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(16, 185, 129, 0.45); }

    #scanStatus { font-size: 13px; margin-top: 12px; color: var(--gray-500); font-style: italic; }
    #matchResult { font-size: 14px; font-weight: 600; margin-top: 10px; }

    .text-green-600 { color: #059669; }
    .text-red-600 { color: #dc2626; }

    @media (max-width: 860px) {
        body {
            padding: 12px;
            /* iOS Safari renders fixed backgrounds unreliably inside scrollable flex layouts */
            background-attachment: scroll;
        }

        .swapauth-wrapper { min-height: auto; padding: 20px 0; }

        .swapauth-container {
            min-height: auto;
            border-radius: 14px;
            width: 100%;
        }

        .swapauth-form-container,
        .swapauth-overlay-container {
            position: relative;
            width: 100%;
            left: 0;
            height: auto;
            transform: none !important;
        }

        .swapauth-form-container { overflow-y: visible; }

        .swapauth-overlay-container { display: none; }

        .swapauth-sign-up { display: none; opacity: 1; }

        .swapauth-container.right-panel-active .swapauth-sign-in { display: none; }
        .swapauth-container.right-panel-active .swapauth-sign-up { display: block; opacity: 1; }

        .login-body {
            padding: 30px 24px;
            height: auto;
        }

        .field-row {
            grid-template-columns: 1fr;
        }

        .field-row .field-group { margin-bottom: 14px; }
    }

    .mobile-switch-link {
        display: none;
        text-align: center;
        margin-top: 16px;
        font-size: 13.5px;
        color: var(--gray-500);
    }

    .mobile-switch-link a { color: var(--navy-dark); font-weight: 600; text-decoration: underline; cursor: pointer; }

    @media (max-width: 860px) {
        .mobile-switch-link { display: block; }
    }

    @media (max-width: 480px) {
        body { padding: 8px; }

        .swapauth-container { border-radius: 10px; }

        .login-body { padding: 22px 16px; }

        .login-body h5 { font-size: 1.15rem; }

        .login-body .subtext { font-size: 0.8rem; margin-bottom: 18px; }

        .modern-label { font-size: 12.5px; }

        .modern-input { padding: 10px 12px; font-size: 14px; }

        .captcha-container { flex-wrap: wrap; row-gap: 8px; }

        .captcha-image { width: 88px; }

        .action-row { flex-wrap: wrap; }

        .btn-primary-modern { flex: 1 1 100%; order: 1; }
        .btn-finger { order: 2; margin: 0 auto; }
    }
</style>

<div class="swapauth-wrapper">
    <div class="swapauth-container {{ request()->routeIs('login') ? 'right-panel-active' : '' }}" id="swapauthContainer">

        {{-- ============ SIGN UP PANEL (now default / left side) ============ --}}
        <div class="swapauth-form-container swapauth-sign-in">
            <div class="login-body">
                <h5>Create Account</h5>
                <p class="subtext">Fill in your details to get started</p>

                @if (request()->routeIs('register'))
                    <x-validation-errors class="validation-errors" />
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="field-group">
                        <label class="modern-label" for="reg-name">{{ __('Name') }}</label>
                        <input id="reg-name" class="modern-input" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Full name">
                    </div>

                    <div class="field-group">
                        <label class="modern-label" for="reg-email">{{ __('Email') }}</label>
                        <input id="reg-email" class="modern-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com">
                    </div>

                    <div class="field-row">
                        <div class="field-group">
                            <label class="modern-label" for="reg-cnic">{{ __('CNIC') }}</label>
                            <input id="reg-cnic" class="modern-input" type="text" name="cnic" value="{{ old('cnic') }}" required placeholder="3520112345671">
                        </div>
                        <div class="field-group">
                            <label class="modern-label" for="reg-phone">{{ __('Phone No') }}</label>
                            <input id="reg-phone" class="modern-input" type="text" name="phoneno" value="{{ old('phoneno') }}" required placeholder="03001234567">
                        </div>
                    </div>

                    <div class="field-row">
                        <div class="field-group">
                            <label class="modern-label" for="reg-password">{{ __('Password') }}</label>
                            <input id="reg-password" class="modern-input" type="password" name="password" required autocomplete="new-password" placeholder="Password">
                        </div>
                        <div class="field-group">
                            <label class="modern-label" for="reg-password_confirmation">{{ __('Confirm') }}</label>
                            <input id="reg-password_confirmation" class="modern-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter">
                        </div>
                    </div>

                    <button type="submit" class="btn-register-submit">{{ __('Register') }}</button>
                </form>

                <div class="mobile-switch-link">
                    {{ __('Already registered?') }} <a href="{{ route('login') }}">{{ __('Log in') }}</a>
                </div>
            </div>
        </div>

        {{-- ============ SIGN IN PANEL (now active / right side) ============ --}}
        <div class="swapauth-form-container swapauth-sign-up">
            <div class="login-body">
                <h5>Welcome Back</h5>
                <p class="subtext">Sign in to access your account</p>

                @if (request()->routeIs('login'))
                    <x-validation-errors class="validation-errors" />
                @endif

                @if (session('status'))
                    <div class="status-message">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field-group">
                        <label class="modern-label" for="email">{{ __('Email Or CNIC') }}</label>
                        <input id="email" class="modern-input" type="text" name="login" value="{{ old('login') }}" required autocomplete="username" placeholder="Enter email or CNIC">
                    </div>

                    <div class="field-group">
                        <label class="modern-label" for="password">{{ __('Password') }}</label>
                        <input id="password" class="modern-input" type="password" name="password" required autocomplete="current-password" placeholder="Enter password">
                    </div>

                    <div class="field-group">
                        <label class="modern-label">{{ __('Security Check') }}</label>
                        <div class="captcha-container">
                            <div class="captcha-input">
                                <input id="captcha" class="modern-input" type="text" name="captcha" required placeholder="Enter captcha">
                            </div>
                            <img src="{{ route('captcha.generate') }}?t={{ time() }}" id="captcha-image" class="captcha-image">
                            <button type="button" class="captcha-refresh"
                                onclick="document.getElementById('captcha-image').src = '{{ route('captcha.generate') }}?t=' + Date.now()"
                                aria-label="Refresh captcha">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="remember-row">
                        <label for="remember_me">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ml-2">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="action-row">
                        <button type="submit" class="btn-primary-modern">{{ __('Secure Log In') }}</button>
                        <button type="button" id="fingerLoginBtn" class="btn-finger" aria-label="Login with Fingerprint">
                            <img id="img" src="{{ asset('email.png') }}" alt="Fingerprint Icon">
                        </button>
                    </div>
                </form>

                <div class="mobile-switch-link">
                    {{ __('Not registered?') }} <a href="{{ route('register') }}">{{ __('Register') }}</a>
                </div>
            </div>
        </div>

        {{-- ============ OVERLAY (slides on desktop) ============ --}}
        <div class="swapauth-overlay-container">
            <div class="swapauth-overlay">
                <div class="swapauth-overlay-panel swapauth-overlay-left">
                    <h2>Hello, Friend!</h2>
                    <p>New here? Create an account to get started with property registration and services.</p>
                    <button class="swapauth-ghost" id="swapauthSignUp" type="button">{{ __('Sign Up') }}</button>
                </div>
                <div class="swapauth-overlay-panel swapauth-overlay-right">
                    <h2>Welcome Back!</h2>
                    <p>Already have an account? Sign in to continue managing your property records and applications.</p>
                    <button class="swapauth-ghost" id="swapauthSignIn" type="button">{{ __('Sign In') }}</button>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ============ FINGERPRINT MODAL ============ --}}
<div id="fingerModal" class="modal">
    <div class="modal-content">
        <button class="close" id="closeModal">&times;</button>

        <div class="finger-container" id="finger-container">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path id="fingerPath" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3v1c0 3.314-2.686 6-6 6s-6-2.686-6-6V9c0-2.761 2.239-5 5-5s5 2.239 5 5" />
            </svg>
            <div id="loader"></div>
        </div>

        <h2>Fingerprint Login</h2>
        <p id="modal-instruction">Enter CNIC then place your finger on the scanner.</p>

        <input id="cnic" class="modern-input" style="margin-bottom: 14px;" type="text" name="cnic"
            autocomplete="current-password" placeholder="Enter CNIC">

        <button id="startScanBtn">Start Scan</button>

        <div id="matchResult"></div>
        <p id="scanStatus"></p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // ---------- Sliding panel toggle ----------
    const swapauthContainer = document.getElementById('swapauthContainer');
    const swapauthSignUp = document.getElementById('swapauthSignUp');
    const swapauthSignIn = document.getElementById('swapauthSignIn');

    swapauthSignIn.addEventListener('click', () => {
        swapauthContainer.classList.add('right-panel-active');
        // Update URL without full reload so refresh keeps correct state
        window.history.pushState({}, '', "{{ route('login') }}");
    });

    swapauthSignUp.addEventListener('click', () => {
        swapauthContainer.classList.remove('right-panel-active');
        window.history.pushState({}, '', "{{ route('register') }}");
    });

    // ---------- Fingerprint modal (unchanged logic) ----------
    const modal = document.getElementById('fingerModal');
    const openBtn = document.getElementById('fingerLoginBtn');
    const closeBtn = document.getElementById('closeModal');
    const loader = document.getElementById('loader');
    const scanBtn = document.getElementById('startScanBtn');
    const scanStatus = document.getElementById('scanStatus');
    const matchResultDiv = document.getElementById('matchResult');
    const modalInstruction = document.getElementById('modal-instruction');
    const fingerPath = document.getElementById('fingerPath');
    const fingerContainer = document.getElementById('finger-container');
    const cnicInput = document.getElementById('cnic');

    let dbTemplate = null;
    let token = null;

    openBtn.addEventListener('click', () => {
        modal.classList.add('is-active');
        resetScanUI();
    });

    closeBtn.addEventListener('click', () => resetScan());
    window.addEventListener('click', e => { if (e.target === modal) resetScan(); });

    function resetScanUI() {
        loader.style.display = 'none';
        scanStatus.textContent = "";
        matchResultDiv.innerHTML = "";
        modalInstruction.textContent = "Enter CNIC then place your finger on the scanner.";
        scanBtn.style.display = 'block';
        fingerPath.setAttribute('stroke', 'white');
        fingerContainer.style.background = '';
        dbTemplate = null;
    }

    function resetScan() {
        modal.classList.remove('is-active');
        resetScanUI();
    }

    scanBtn.addEventListener('click', function () {

        const cnic = cnicInput.value.trim();
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        if (!/^[0-9]{13}$/.test(cnic)) {
            toastr.error('Please enter a valid 13-digit CNIC');
            return;
        }

        scanBtn.style.display = 'none';
        loader.style.display = 'block';
        scanStatus.textContent = "Validating CNIC...";
        matchResultDiv.innerHTML = '';

        fetch('/api/check-cnic', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ cnic })
        })
        .then(async res => {
            const data = await res.json().catch(() => null);
            if (!res.ok) {
                throw { status: res.status, message: data?.message || 'Unknown server error', data };
            }
            return data;
        })
        .then(res => {
            if (!res.exists) {
                loader.style.display = 'none';
                scanBtn.style.display = 'block';
                toastr.error(res.message || 'CNIC not found');
                return;
            }

            dbTemplate = res.template;
            token = res.roken;

            scanStatus.textContent = "CNIC verified. Place finger on scanner...";
            fingerPath.setAttribute('stroke', '#f9fafb');

            pollScan();
        })
        .catch(err => {
            loader.style.display = 'none';
            scanBtn.style.display = 'block';
            console.error('CHECK CNIC ERROR:', err);
            toastr.error(err.message || 'CNIC validation failed');
        });

        function pollScan() {
            fetch('http://localhost:9099/api/GetImage', { method: 'POST' })
                .then(response => response.text())
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch {
                        scanStatus.textContent = "Place your finger on scanner...";
                        return setTimeout(pollScan, 1000);
                    }

                    if (data?.Status && data?.ImgBase64) {
                        scanStatus.textContent = "Scan captured. Matching...";
                        loader.style.display = 'block';

                        fetch('http://localhost:9099/api/matching', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                template1: data.TemplateBase64,
                                template2: dbTemplate,
                                MatchingSDK: 1,
                                templateType: 2
                            })
                        })
                        .then(res => res.json())
                        .then(matchData => {
                            if (matchData.isMatch) {
                                matchResultDiv.innerHTML = '<span class="text-green-600">Login Successful! Redirecting...</span>';
                                scanStatus.textContent = "Fingerprint matched successfully";
                                fingerContainer.style.background = '#10B981';
                                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                                fetch('/dummy-dashboard', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: JSON.stringify({
                                        cnic: cnicInput.value,
                                        domain: 'http://localhost:9099/api/matching'
                                    })
                                })
                                .then(res => res.json())
                                .then(res => {
                                    if (res.redirect) {
                                        window.location.href = res.redirect;
                                    } else {
                                        console.log(res.message);
                                    }
                                })
                                .catch(err => console.error(err));

                            } else {
                                matchResultDiv.innerHTML = '<span class="text-red-600">Match Failed. Try Again.</span>';
                                scanStatus.textContent = "Fingerprint not recognized";
                                scanBtn.style.display = 'block';
                                fingerContainer.style.background = 'linear-gradient(135deg, #680505, #6E0303)';
                            }
                        })
                        .catch(err => {
                            loader.style.display = 'none';
                            scanBtn.style.display = 'block';
                            scanStatus.textContent = "Matching failed";
                            fingerContainer.style.background = 'linear-gradient(135deg, #680505, #6E0303)';
                            console.log(err.message);
                        });

                    } else {
                        scanStatus.textContent = "Place your finger on scanner and hold...";
                        setTimeout(pollScan, 1000);
                    }
                })
                .catch(() => {
                    loader.style.display = 'none';
                    scanBtn.style.display = 'block';
                    scanStatus.textContent = "Scanner connection failed";
                });
        }
    });
</script>
