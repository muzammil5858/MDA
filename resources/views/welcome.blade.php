<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MDA</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="icon" type="image/x-icon" href="/bor2.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap");

    :root {
        --navy: #A5D6A7;
        --navy-dark: #1B5E20;
      --gold: #f5a623;
      --gold-light: #ffc861;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', "Open Sans", sans-serif;
    }

    body {
      height: 100vh;
      width: 100%;
      background: #444;
      overflow: hidden;
      position: relative;
    }

    /* ---------- NAVBAR ---------- */
    .navbar {
      background: linear-gradient(120deg, var(--navy), var(--navy-dark)) !important;
      backdrop-filter: blur(10px);
      padding: 0.9rem 1.5rem;
      box-shadow: 0 2px 18px rgba(0, 0, 0, 0.25);
      position: relative;
      z-index: 30;
    }

    .navbar-brand {
      font-size: 1.15rem;
      letter-spacing: 0.02em;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .navbar .btn-primary {
      background: transparent;
      border: 1.5px solid rgba(255, 255, 255, 0.5);
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 0.5rem 1.3rem;
      transition: all 0.25s ease;
    }

    .navbar .btn-primary:hover {
      background: var(--gold);
      border-color: var(--gold);
      color: var(--navy-dark);
      transform: translateY(-1px);
    }

    /* ---------- SLIDER ---------- */
    .slider {
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      height: 100vh;
      width: 100%;
      position: absolute;
      top: 0;
      left: 0;
    }

    .slider::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(8, 27, 56, 0.55) 0%, rgba(8, 27, 56, 0.25) 40%, rgba(8, 27, 56, 0.65) 100%);
    }

    a {
      color: white;
      text-decoration: none;
    }

    .slider--content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 100vh;
      position: relative;
      z-index: 2;
    }

    .login-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(6px);
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.4);
      border-radius: 10px;
      padding: 10px 20px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s;
    }

    .login-btn:hover {
      background-color: var(--gold);
      color: var(--navy-dark);
      border-color: var(--gold);
    }

    .slider--feature {
      text-align: center;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100%;
      z-index: 2;
    }

    .slider--text {
      font-weight: 700;
      color: #fff;
      text-transform: uppercase;
      letter-spacing: 0.03em;
      margin: 0.5rem 0;
      max-width: 600px;
      margin: 0 auto;
      text-shadow: 0 2px 12px rgba(0, 0, 0, 0.4);
    }

    .slider__btn-right,
    .slider__btn-left {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(6px);
      border: 1px solid rgba(255, 255, 255, 0.25);
      outline: none;
      font-size: 2.2rem;
      color: #eee;
      width: 56px;
      height: 56px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s ease-in-out;
      z-index: 3;
      margin: 0 1.5rem;
    }

    .slider__btn-right:hover,
    .slider__btn-left:hover {
      background: var(--gold);
      color: var(--navy-dark);
      transform: scale(1.05);
    }

    @keyframes slideIn {
      0% {
        opacity: 0;
        transform: translateX(50%);
      }

      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .slideIn {
      animation: slideIn 1s;
    }

    .slider-shape {
      position: absolute;
      bottom: 28px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 3;
    }

    .slider-dot {
      width: 10px;
      height: 10px;
      background-color: rgba(255, 255, 255, 0.5);
      border-radius: 50%;
      margin: 0 6px;
      cursor: pointer;
      transition: all 0.25s ease;
    }

    .slider-dot:hover {
      background-color: var(--gold);
    }

    @media only screen and (max-width: 768px) {
      .slider--text {
        font-size: 0.8rem;
      }

      .slider__btn-right,
      .slider__btn-left {
        width: 44px;
        height: 44px;
        font-size: 1.6rem;
        margin: 0 0.8rem;
      }

      .slider-dot {
        width: 8px;
        height: 8px;
        margin: 0 4px;
      }
    }

    /* ---------- CAPTCHA ---------- */
    .captcha-container {
      text-align: center;
      display: flex;
      align-items: center;
    }

    .captcha-container img {
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      height: 52px;
      margin-top: 6px;
    }

    .captcha-container button {
      height: 52px;
      margin-top: 6px;
      margin-left: 0.6rem;
      padding: 0.25rem .9rem;
      background: var(--navy);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1.1rem;
      transition: background 0.2s ease, transform 0.15s ease;
    }

    .captcha-container button:hover {
      background: var(--navy-dark);
      transform: rotate(90deg);
    }

    /* ---------- LOGIN MODAL ---------- */
    .modal-content {
      border: none;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
    }

    .modal-body {
      padding: 0;
    }

    .modal-body .card,
    .modal-body [class*="card"] {
      box-shadow: none !important;
    }

    .modal-header-band {
      background: linear-gradient(120deg, var(--navy), var(--navy-dark));
      padding: 22px 28px;
      color: #fff;
    }

    .modal-header-band h5 {
      font-weight: 700;
      font-size: 1.15rem;
      margin: 0;
    }

    .modal-header-band p {
      font-size: 0.82rem;
      color: rgba(255, 255, 255, 0.7);
      margin: 2px 0 0;
    }

    .modal-body-inner {
      padding: 26px 28px 30px;
    }

    .modal-body-inner label {
      font-size: 13px;
      font-weight: 600;
      color: #4b5563;
      margin-bottom: 4px;
    }

    .modal-body-inner input[type="text"],
    .modal-body-inner input[type="password"] {
      width: 100%;
      padding: 11px 13px;
      font-size: 14.5px;
      border: 1.5px solid #e5e7eb;
      border-radius: 9px;
      background: #fff;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
      outline: none;
    }

    .modal-body-inner input:focus {
      border-color: var(--gold);
      box-shadow: 0 0 0 4px rgba(245, 166, 35, 0.12);
    }

    .modal-body-inner .btn-login-submit {
      background: linear-gradient(120deg, var(--navy), var(--navy-dark));
      color: #fff;
      border: none;
      border-radius: 9px;
      padding: 10px 22px;
      font-weight: 600;
      font-size: 14.5px;
      transition: all 0.2s ease;
    }

    .modal-body-inner .btn-login-submit:hover {
      background: var(--gold);
      color: var(--navy-dark);
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-dark">
    <a class="navbar-brand text-white ml-3"><B>Mirpur Development Authority</B></a>

    <div>
      <button type="button" class="btn btn-primary mr-3" data-toggle="modal" data-target="#exampleModal">
        Login
      </button>
      <a href="/register"><button type="button" class="btn btn-primary mr-3">
          Register
        </button></a>
    </div>
  </nav>

  <main>
    <div class="slider">
      <div class="slider--content">
        <button class="slider__btn-left" onclick="prevSlide()">&#10094;</button>
        <button class="slider__btn-right" onclick="nextSlide()">&#10095;</button>

        <div class="slider--feature">
          <p class="slider--text"></p>
        </div>
      </div>
    </div>
    <div class="slider-shape">
      <div class="slider-dot" onclick="goToSlide(0)"></div>
      <div class="slider-dot" onclick="goToSlide(1)"></div>
      <div class="slider-dot" onclick="goToSlide(2)"></div>
    </div>
  </main>

  <!-- Modal -->
  <div class="modal fade" style="top:50px !important;" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mr-0" role="document">
      <div class="modal-content">
        <div class="modal-header-band">
          <h5>Welcome Back</h5>
          <p>Sign in to access your MDA account</p>
        </div>
        <div class="modal-body">
          <x-guest-layout>
            <x-authentication-card>
              <x-slot name="logo">
              </x-slot>

              <x-validation-errors class="mb-4" />

              @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                  {{ session('status') }}
                </div>
              @endif

              <div class="modal-body-inner">
                <form method="POST" action="{{ route('login') }}">
                  @csrf

                  <div>
                    <x-label for="email" value="{{ __('Email Or Cnic') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" placeholder="Email or Cnic" />
                  </div>

                  <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                  </div>

                  <div class="form-group captcha-container mt-4">
                    <img src="{{ route('captcha.generate') }}?t={{ time() }}" id="captcha-image">
                    <button type="button" onclick="document.getElementById('captcha-image').src = '{{ route('captcha.generate') }}?t=' + Date.now()">↻</button>
                  </div>

                  <div class="mt-4">
                    <x-input id="captcha" class="block mt-1 w-full" type="text" name="captcha" required placeholder="Enter Captcha Here" />
                  </div>

                  <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                      <x-checkbox id="remember_me" name="remember" />
                      <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                  </div>

                  <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                      <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                      </a>
                    @endif

                    <button type="submit" class="btn-login-submit">
                      {{ __('Log in') }}
                    </button>
                  </div>
                </form>
              </div>
            </x-authentication-card>
          </x-guest-layout>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
      $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
      })
    })
  </script>
  <script>
    const slideContainer = document.querySelector(".slider");
    const sliderText = document.querySelector(".slider--text");
    const sliderDots = document.querySelectorAll(".slider-dot");

    const sliderImages = [
      { src: "../img1.jpeg" },
    //   { src: "../img2.png" },
      { src: "../img3.jpeg" },
    ];

    let slideCounter = 0;
    let slideInterval;

    function startSlider() {
      updateSlide();
      slideInterval = setInterval(() => {
        nextSlide();
      }, 5000);

      slideContainer.addEventListener("mouseenter", () => {
        clearInterval(slideInterval);
      });

      slideContainer.addEventListener("mouseleave", () => {
        slideInterval = setInterval(() => {
          nextSlide();
        }, 5000);
      });
    }

    function nextSlide() {
      slideCounter = (slideCounter + 1) % sliderImages.length;
      updateSlide();
      manualNavigation();
    }

    function prevSlide() {
      slideCounter = (slideCounter - 1 + sliderImages.length) % sliderImages.length;
      updateSlide();
      manualNavigation();
    }

    function goToSlide(index) {
      slideCounter = index;
      updateSlide();
      manualNavigation();
    }

    function updateSlide() {
      slideContainer.style.backgroundImage = `url(${sliderImages[slideCounter].src})`;
      sliderText.innerHTML = sliderImages[slideCounter].text || '';
      slideContainer.classList.add("slideIn");

      sliderDots.forEach((dot, index) => {
        if (index === slideCounter) {
          dot.style.backgroundColor = "#f5a623";
        } else {
          dot.style.backgroundColor = "rgba(255,255,255,0.5)";
        }
      });

      setTimeout(() => {
        slideContainer.classList.remove("slideIn");
      }, 1000);
    }

    function manualNavigation() {
      clearInterval(slideInterval);
      setTimeout(() => {
        slideInterval = setInterval(() => {
          nextSlide();
        }, 5000);
      }, 1000);
    }

    startSlider();
  </script>
</body>

</html>
