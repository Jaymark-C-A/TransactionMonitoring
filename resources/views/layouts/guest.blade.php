{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('includes.head')
    </head>
    <body class="font-sans text-gray-900 antialiased" style="background-color: #cecece;">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-3">
                <img src="{{ asset('img/logo.png') }}" alt="logo" style="width: 150px; height: auto;">
            </div>

            <div class="w-full sm:max-w-md m-0 p-0 bg-white smoky-shadow overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html> --}}


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        @include('includes.head')
</head>
<body>

<div class="container-fluid d-flex align-items-center justify-content-center" style="height: 100vh; background-color: rgb(90, 164, 233);">
  <div class="row">
    <div class="col-12 col-sm-10 col-md-10 col-lg-10 mx-auto" style="background-color: white; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
      <div class="row">
        <!-- LEFT -->
        <div class="col-md-6 p-0" id="login-section" >
          <img src="{{ asset('img/Login_pic.jpeg') }}" alt="logo" style="width: 100%; height: auto;">
        </div>
        <!-- RIGHT -->
        <div class="col-md-6 p-5 d-flex flex-column justify-content-between" style="border: solid !important; border-color: #DEDEDE !important;">
          <div id="message" class="alert alert-danger" style="display: none; color: rgb(90, 164, 233);"></div>

        <div class="title">
            <div class="mb-4">
                <p class="text-center mb-1" style="font-size: 22px"><strong>Reset Password:</strong></p>
                <p class="mb-2 text-center" style="font-size: 22px">TRANSACTION MONITORING SYSTEM</p>
            </div>
                {{ $slot }}
        </div>
          
        </div>

      </div>
    </div>
  </div>
</div>

<script src="{{ asset('../js/bootstrap.bundle.min.js') }}"></script>

<!-- Add the Script -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
      const passwordField = document.getElementById('password');
      const confirmPasswordField = document.getElementById('password_confirmation');
      const showPasswordCheckbox = document.getElementById('show_password');

      showPasswordCheckbox.addEventListener('change', () => {
          const type = showPasswordCheckbox.checked ? 'text' : 'password';
          passwordField.type = type;
          confirmPasswordField.type = type;
      });
  });
</script>

</body>
</html>
