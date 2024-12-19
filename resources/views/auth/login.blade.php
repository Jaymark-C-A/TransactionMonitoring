<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/custom.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


  <style>
    .login-section {
      padding: 25px 80px;
      height: 100vh;
    }
    #signup-section {
      background-color: rgb(90, 164, 233);
    }
    #password-error {
    font-size: 0.875rem; /* Adjust font size */
    color: red; /* Set error message color */
    }
  </style>
  <script>
    // Function to check login attempts and time
    function checkLoginAttempts() {
      const attempts = parseInt(localStorage.getItem('loginAttempts')) || 0;
      const loginButton = document.getElementById('login-button');
      const messageDiv = document.getElementById('message');
      const lastAttemptTime = localStorage.getItem('lastAttemptTime');

      if (attempts >= 4 && lastAttemptTime) {
        const currentTime = new Date().getTime();
        const timeDifference = (currentTime - lastAttemptTime) / 1000; // Time difference in seconds

        if (timeDifference < 60) { // If 60 seconds haven't passed
          loginButton.disabled = true;
          messageDiv.textContent = `Too many login attempts. Please try again in ${60 - Math.floor(timeDifference)} seconds.`;
          messageDiv.style.display = 'block';
        } else {
          // Reset attempts after 60 seconds
          localStorage.removeItem('loginAttempts');
          localStorage.removeItem('lastAttemptTime');
          loginButton.disabled = false;
          messageDiv.style.display = 'none';
        }
      }
    }

    // Function to increment login attempts
    function incrementLoginAttempts() {
      let attempts = parseInt(localStorage.getItem('loginAttempts')) || 0;
      attempts++;
      localStorage.setItem('loginAttempts', attempts);

      const loginButton = document.getElementById('login-button');
      const messageDiv = document.getElementById('message');

      // Record the time of the last failed attempt
      const currentTime = new Date().getTime();
      localStorage.setItem('lastAttemptTime', currentTime);

      if (attempts >= 4) {
        loginButton.disabled = true;
        messageDiv.textContent = 'Too many login attempts. Please try again in 60 seconds.';
        messageDiv.style.display = 'block';
      }
    }

    // Call this function upon successful login
    function resetLoginAttempts() {
      localStorage.removeItem('loginAttempts');
      localStorage.removeItem('lastAttemptTime');
    }

    // Function to refresh the page after 60 seconds (1 minute)
    function autoRefreshPage() {
      setTimeout(function() {
        location.reload(); // Reload the page after 1 minute
      }, 60 * 1000); // 60 seconds
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Call existing functions
      checkLoginAttempts();
      autoRefreshPage(); // Start auto-refresh countdown
    });
  </script>
</head>
<body>

<div class="container-fluid d-flex align-items-center justify-content-center" style="height: 100vh; background-color: rgb(90, 164, 233);">
  <div class="row">
    <div class="col-12 col-sm-10 col-md-10 col-lg-10 mx-auto" style="background-color: white; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
      <div class="row">
        <!-- LEFT -->
        <div class="col-md-6 p-0" style="background-color: #214464" id="login-section" >
          <img src="{{ asset('img/Login_pic.jpeg') }}" alt="logo" style="width: 100%; height: auto;">
        </div>
        <!-- RIGHT -->
        <div class="col-md-6 p-5 d-flex flex-column justify-content-between" style="border: solid !important; border-color: #DEDEDE !important;">
          <div id="message" class="alert alert-danger" style="display: none; color: rgb(90, 164, 233);"></div>

          <div class="title text-center">
            <!-- <svg xmlns="http://www.w3.org/2000/svg" width="60" color="#084262" height="60" fill="currentColor" class="bi bi-person-circle text-center" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg> -->
            <h1 class="text-center">Sign In:</h1>
            <p class="mb-2 text-center" style="font-size: 22px">TRANSACTION MONITORING SYSTEM</p>
          <form class="text-left" method="post" action="{{ route('login') }}" id="loginForm">
            @csrf
            <div class="form-group mt-4">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="account@example.com" 
                    value="{{ old('email') }}" required>
              {{-- <span class="text-danger">@error('email') {{ $message }} @enderror</span> --}}
              <span class="text-danger">
                @if ($errors->any())
                    <span class="text-danger">
                          @foreach ($errors->all() as $error)
                              {{ $error }}
                          @endforeach
                    </span>
                @endif
              </span>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <div class="input-group mb-2">
                <input type="password" 
                class="form-control" 
                id="password" 
                name="password" 
                placeholder="••••••••••••" 
                pattern="^[^'\"\\]+$" 
                title="Password cannot contain single quotes, double quotes, or backslashes." 
                required>
                         <div class="input-group-append">
                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i class="bi bi-eye-slash" id="password-icon"></i>
                    </span>
                </div>
            </div>              <span class="text-danger">@error('password') {{ $message }} @enderror</span>

              @if (Route::has('password.request'))
              <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}" wire:navigate>
                  {{ __('Forgot your password?') }}
              </a>
              @endif
            </div>

            <button type="submit" class="btn form-control mt-2" style="background-color: #063b6c; color: white; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">Login</button>

          </form>

            <div class="col-md-12 p-0 pt-4 text-left">
              <a href="/lobbyMonitor">REDIRECT TO SERVICE MONITOR</a>  
            </div>
        </div>
          

          @if(session('resetAttempts'))
            <script>
              resetLoginAttempts(); // Reset login attempts
            </script>
          @endif
        </div>

      </div>
    </div>
  </div>
</div>

<script src="{{ asset('../js/bootstrap.bundle.min.js') }}"></script>


<!-- Add Bootstrap Icons CDN -->

<script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");
    const passwordIcon = document.querySelector("#password-icon");

    togglePassword.addEventListener("click", function (e) {
        // Toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // Toggle the icon
        passwordIcon.classList.toggle("bi-eye");
        passwordIcon.classList.toggle("bi-eye-slash");
    });
</script>

</body>
</html>
