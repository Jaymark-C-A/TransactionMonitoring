<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- Custom styles -->
  <style>
    .login-section {
      padding: 25px 80px;
      height: 100vh;
    }
    #login-section {
      /* background-color: rgb(121, 10, 172); */
    }
    #signup-section {
      /* background-color: #ffffff;  */
      background-color: rgb(90, 164, 233);
    }
  </style>
</head>
<body >

<div class="container-fluid">
  <div class="row">
    <div id="login-section" class="col-md-8 login-section">
      <br><br>
      <a id="hamburger-menu" class="nav-link text-center" data-widget="pushmenu" href="#" role="button">
        <img src="{{ asset('img/loginVector.png') }}" alt="logo" style="width: 100%; height: auto;">
    </a>
    </div>
    <div id="signup-section" class="col-md-4 login-section">
        <a id="hamburger-menu" class="nav-link text-center" data-widget="pushmenu" href="#" role="button">
            <img src="{{ asset('img/logo.png') }}" alt="logo" style="width: 130px; height: auto;">
        </a>
      <h2 class="mb-4">Sign In:</h2>
      <form  action="{{route('login')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Account@gmail.com" 
                value="{{old('email')}}" class="border-2 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                <span class="text-danger">@error('email') {{$message}} @enderror</span>
        </div>
        <div class="form-group">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>  
          <input type="password" class="form-control" id="password" name="password" placeholder="••••••••••••••••••••••" value="{{old('password')}}">
          <span class="text-danger">@error('password') {{$message}} @enderror</span>
        </div>
        <button type="submit" class="btn btn-primary form-control mt-2">Login</button>
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="color: black;" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

            </div>            
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
