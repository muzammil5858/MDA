
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MDHA</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="icon" type="image/x-icon" href="/bor2.png">
  <style>
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      height: 100vh;
      width: 100%;
      font-family: "Open Sans", sans-serif;
      background: #444;
      overflow: hidden;
      position: relative;
    }

    .slider {
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      height: 100vh;
      width: 100%;
      position: absolute;
      top: 20;
      left: 0;
    }
    a{
      color:white;
      text-decoration: none;
    }

    .slider--content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 100vh;
      position: relative;
    }

    .login-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      background-color: transparent;
      color: #fff;
      border: 1px solid #fff;
      border-radius: 10px;
      padding: 10px 20px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s;
    }

    .login-btn:hover  {
      background-color: #fff;
      color: #444;
    }
    .login-btn:hover a {
      color:black;
    }
    .slider--feature {
      text-align: center;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100%;
    }

    .slider--text {
      font-weight: bold;
      color: #fff;
      text-transform: uppercase;
      margin: 0.5rem 0;
      max-width: 600px;
      margin: 0 auto;
    }

    .slider__btn-right,
    .slider__btn-left {
      background: transparent;
      border: none;
      outline: none;
      font-size: 4rem;
      color: #eee;
      padding: 0 1rem;
      cursor: pointer;
      transition: transform 0.1s ease-in-out;
    }

    .slider__btn-right:hover,
    .slider__btn-left:hover {
      transform: scale(0.95);
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
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .slider-dot {
      width: 12px;
      height: 12px;
      background-color: #eee;
      border-radius: 50%;
      margin: 0 6px;
      cursor: pointer;
    }

    @media only screen and (max-width: 768px) {
      .slider--text {
        font-size: 0.8rem;
      }

      .slider__btn-right,
      .slider__btn-left {
        font-size: 3rem;
      }

      .slider-dot {
        width: 10px;
        height: 10px;
        margin: 0 4px;
      }
    }
    .captcha-container { text-align: center; display: flex; }
    .captcha-container img { border: 1px solid #ccc; border-radius: 0.5rem; height:60px; margin-top:10px; }
    .captcha-container button { height:60px;margin-top:10px;margin-left: 0.5rem; padding: 0.25rem .8rem; background: #23aab5; color: white; border: none; border-radius: 0.25rem; cursor: pointer; }
    .captcha-container button:hover { background: #237890; }
  </style>
</head>

<body>
  <nav class="navbar navbar-dark bg-dark">
    <!-- Navbar content -->
      <a class="navbar-brand text-white ml-3"><B>Mangla Dam Housing Authority</B></a>
      
        {{-- <button class="btn btn-outline-white my-2 my-sm-0 bg-secondary mr-5  text-white" type="submit">Login</button> --}}
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
         {{-- @if (Route::has('login'))
              
                    @auth
                        <a href="{{ url('/dashboard') }}"><button class="login-btn">Dashboard</button></a>
                    @else
                        <a href="{{ route('login') }}" ><button class="login-btn">Login</button></a>

                    @endauth
             
            @endif --}}
        
            
        
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
  {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button> --}}
  
  <!-- Modal -->
  <div class="modal fade " style="top:50px !important;" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mr-0" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <x-guest-layout>
            <x-authentication-card>
                <x-slot name="logo">
                    {{-- <x-authentication-card-logo />   --}}
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
                        <x-label for="email" value="{{ __('Email Or Cnic') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" placeholder="Email or Cnic" />

                    </div>
        
                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                    </div>
                    <div class="form-group captcha-container">
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
        
                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
        
                        <x-button class="ml-4">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>
            </x-authentication-card>
        </x-guest-layout>
        </div>
        
      </div>
    </div>
  </div>
 
  {{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> --}}
  
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script>
  $(document).ready(function(){

    $('#myModal').on('shown.bs.modal', function () {
      console.log('hhfhgfhgff');
  $('#myInput').trigger('focus')
})
})
  </script>
  <script>
    const slideContainer = document.querySelector(".slider");
    const sliderText = document.querySelector(".slider--text");
    const sliderDots = document.querySelectorAll(".slider-dot");

    const sliderImages = [
      {
        src: "../img2.jpeg",
        // text: "Digitization of Settlement and Rehabilitation Record (Phase-1)"
      },
      {
        src: "../img1.jpeg"
      },
      {
        src: "../img3.jpeg"
      },

    ];

    let slideCounter = 0;
    let slideInterval;

    function startSlider() {
      updateSlide();
      slideInterval = setInterval(() => {
        nextSlide();
      }, 5000); // 5000 milliseconds = 5 seconds

      // Pause slide transition on mouseenter
      slideContainer.addEventListener("mouseenter", () => {
        clearInterval(slideInterval);
      });

      // Resume slide transition on mouseleave
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
      sliderText.innerHTML = sliderImages[slideCounter].text || ''; // Set text content
      slideContainer.classList.add("slideIn"); // Use the new animation class

      // Update active dot
      sliderDots.forEach((dot, index) => {
        if (index === slideCounter) {
          dot.style.backgroundColor = "#fff";
        } else {
          dot.style.backgroundColor = "#eee";
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
