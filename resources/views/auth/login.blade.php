<x-guest-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* --- 1. CAPTCHA FIX: Restoring and refining the necessary styles --- */
        .captcha-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 1rem;
        }

        /* Ensure input takes up available space */
        .captcha-input {
            flex: 1;
        }

        /* Match the standard input height (usually around 42-44px for rounded-lg with padding) */
        .captcha-image {
            height: 42px; 
            width: 100px; /* Set a standard width */
            border: 1px solid #e5e7eb; /* border-gray-200 */
            border-radius: 0.5rem; /* rounded-lg */
            cursor: pointer;
        }

        /* Match the height of the Captcha image */
        .captcha-refresh {
            height: 42px; 
            width: 42px; /* Set a fixed width for the circular icon */
            margin-left: 4px;
            background: #4f46e5; /* indigo-600 */
            color: white;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 16px;
            display: flex; /* Use flex to center the SVG */
            align-items: center;
            justify-content: center;
            transition: background 0.2s ease-in-out;
        }

        .captcha-refresh:hover {
            background: #4338ca; /* indigo-700 */
        }
        #img {
            width: 60px;
            animation: fadeIn 1s ease;
        }

        #img:hover {
            scale: 1.04;
        }

        /* --- 2. MODAL FIX: Restoring essential modal CSS --- */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6); /* Slightly darker overlay */
            z-index: 1000;
            display: none; /* Default hidden state */
            justify-content: center;
            align-items: center;
        }

        .modal.is-active {
            display: flex; /* Show the modal using this class */
        }

        .modal-content {
            position: relative;
            background: #fff;
            border-radius: 16px; /* Slightly smaller radius */
            padding: 40px 30px;
            width: 90%;
            max-width: 380px; /* Slightly narrower modal */
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            /* Removed animation keys for now to simplify, focusing on function */
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px; /* Larger close button */
            font-weight: 300;
            color: #999;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close:hover {
            color: #333;
        }

        .finger-container {
            display: inline-flex;
            position: relative;
            background: linear-gradient(135deg, #054468, #03346E);
            border-radius: 50%;
            padding: 20px;
            color: #fff;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Loader spinning around the fingerprint */

        #loader {
            position: absolute;
            top: -5px;
            left: -5px;
            width: 101px;
            height: 101px;
            border: 6px solid rgba(37, 99, 235, 0.3);
            border-top: 6px solid #2539eb;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none;
            /* hidden initially */
        }

        h2 {
            font-size: 20px; /* Slightly smaller heading */
            font-weight: 600;
            margin-bottom: 8px;
            color: #1f2937; /* gray-900 */
        }

        .modal-content p {
            font-size: 14px;
            color: #6b7280; /* gray-500 */
            margin-bottom: 15px;
        }

        #startScanBtn {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #054468, #03346E); /* Using a clean green for action */
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
            transition: all 0.3s ease;
        }

        #startScanBtn:hover {
            background: linear-gradient(135deg, #059669, #10b981);
        }

        #scanStatus {
            font-size: 14px;
            margin-top: 12px;
            color: #4b5563; /* gray-600 */
            font-style: italic;
        }

        /* Animation for Loader */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-label for="email" value="{{ __('Email Or CNIC') }}" />
                <x-input id="email" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required
                    autofocus autocomplete="username" placeholder="Email or CNIC" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" placeholder="Password" />
            </div>

            <div class="captcha-container">
                <div class="captcha-input">
                    <x-input id="captcha" class="block w-full" type="text" name="captcha" required
                        placeholder="Enter Captcha Here" />
                </div>

                <div class="flex items-center">
                    <img src="{{ route('captcha.generate') }}?t={{ time() }}" id="captcha-image" class="captcha-image">
                    
                    <button type="button" class="captcha-refresh"
                        onclick="document.getElementById('captcha-image').src = '{{ route('captcha.generate') }}?t=' + Date.now()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center mt-6 w-full">
                <div class="flex justify-between w-full items-center space-x-4">
                    <x-button class="flex-1 justify-center py-3 mr-2 text-lg bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-900 focus:ring-indigo-500 transition duration-200">
                        {{ __('Secure Log In') }}
                    </x-button>

                    <button type="button" id="fingerLoginBtn"
                        class="w-12 h-12 flex items-center justify-center bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-semibold rounded-full shadow-lg transition-all duration-300 transform hover:scale-105"
                        aria-label="Login with Fingerprint">
                                                <img id="img" src="{{ asset('email.png') }}" alt="Fingerprint Icon">

                        </svg>
                    </button>
                </div>
            </div>
        </form>

        <div id="fingerModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeModal">&times;</span>

                <div class="finger-container" id="finger-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path id="fingerPath" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3v1c0 3.314-2.686 6-6 6s-6-2.686-6-6V9c0-2.761 2.239-5 5-5s5 2.239 5 5" />
                    </svg>

                    <!-- Loader remains the same -->
                    <div id="loader" class="loader"></div>
                </div>

                <h2>Fingerprint Login</h2>

                <x-input id="cnic" class="block mt-1 w-full " type="text" name="cnic" 
                    autocomplete="current-password" placeholder="Enter CNIC" />
                <p id="modal-instruction" class="mt-2">Place your finger on the scanner to authenticate securely.</p>

                <button id="startScanBtn" class="mt-4">Start Scan</button>
                
                <div id="matchResult" class="mt-4 text-sm font-semibold"></div>
                
                <p id="scanStatus" class="mt-3 text-sm italic text-gray-500"></p> 
            </div>
        </div>

    </x-authentication-card>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
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

let dbTemplate = null; // store DB fingerprint template


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

    // 🔐 CNIC validation
    if (!/^[0-9]{13}$/.test(cnic)) {
        toastr.error('Please enter a valid 13-digit CNIC');
        return;
    }

    scanBtn.style.display = 'none';
    loader.style.display = 'block';
    scanStatus.textContent = "Validating CNIC...";
    matchResultDiv.innerHTML = '';

    // 🔎 Step 1: Check CNIC & fetch DB template
    fetch('/api/check-cnic', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({ cnic })
})
.then(async res => {

    // Read raw response first
    const data = await res.json().catch(() => null);


    if (!res.ok) {
        // Backend error message
        throw {
            status: res.status,
            message: data?.message || 'Unknown server error',
            data
        };
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

    // Show real backend error
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
                    console.log(dbTemplate,data.TemplateBase64);

                    // 🔁 Step 2: Match DB template + Scanner template
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
                        
                        // loader.style.display = 'none';

                        if (matchData.isMatch) {
                            matchResultDiv.innerHTML = '<span class="text-green-600">Login Successful! Redirecting...</span>';
                            scanStatus.textContent = "Fingerprint matched successfully ✅";
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
                                console.log(res);
                                // return;
                                if (res.redirect) {
                                    alert('me');
                                    window.location.href = res.redirect; // navigate the browser
                                } else {
                                    console.log(res.message);
                                }
                            })
                            .catch(err => console.error(err));

                            
                        } else {
                            matchResultDiv.innerHTML = '<span class="text-red-600">Match Failed. Try Again.</span>';
                            scanStatus.textContent = "Fingerprint not recognized ❌";
                            scanBtn.style.display = 'block';
                            fingerContainer.style.background = 'linear-gradient(135deg, #680505, #6E0303)';
                        }
                    })
                    .catch(err => {
                        loader.style.display = 'none';
                        scanBtn.style.display = 'block';
                        scanStatus.textContent = "Matching failed ❌";
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
                scanStatus.textContent = "Scanner connection failed ❌";
            });
    }
});

    </script>
</x-guest-layout>