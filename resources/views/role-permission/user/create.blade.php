<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        .error {
            border-color: red !important;
        }
        .success {
            border-color: green !important;
        }
        #passwordMessage {
            margin-top: 5px;
            font-size: 12px;
            color: red;
        }

        .smoky-shadow {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">
</head>
<body class="text-sm" style="background-color: #cecece">
   <div class="wrapper">
    <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light" style="background-color: #084262;">
        @include('includes.nav')
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
        @include('includes.sidebar.sidebar')  
    </aside>
    <div class="content-wrapper bg-transparent">
        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 mt-5 mb-5">
                        <div class="card smoky-shadow">
                            <div class="card-header" style="background: rgb(6, 193, 255);">
                                <h4 class="text-white">Create Account
                                    <a href="{{ url('users') }}" class="btn btn-primary float-right">Back</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form id="registrationForm" action="{{ url('users') }}" method="POST" onsubmit="return validateForm()">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name">Name<span style="color: red;"> *</span></label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email<span style="color: red;"> *</span></label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password">Password<span style="color: red;"> *</span></label>
                                        <input type="password" id="password" name="password" class="form-control" oninput="checkPassword()" required>
                                        <div id="passwordMessage"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="re-password">Re-enter your password<span style="color: red;"> *</span></label>
                                        <input type="password" id="re-password" name="re-password" class="form-control" oninput="checkPasswordMatch()" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="roles">User Type<span style="color: red;"> *</span></label>
                                        <select name="roles[]" class="form-control" multiple required>
                                            <option value="">Select Roles</option>
                                            @foreach ($roles as $role)
                                                @if ($role != 'Super-admin')
                                                    <option value="{{ $role }}">{{ $role }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>                                    
                                    <div class="mb-3">
                                        <button id="submitButton" type="submit" class="form-control btn btn-success" disabled>Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('../js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('../js/jquery.min.js') }}"></script>
<script src="{{ asset('../js/sweetalert2.min.js') }}"></script>

<script>
    function checkPassword() {
        var password = document.getElementById("password").value;
        var passwordField = document.getElementById("password");
        var submitButton = document.getElementById("submitButton");
        var message = document.getElementById("passwordMessage");

        if (password.length >= 8 && /[^a-zA-Z0-9]/.test(password)) {
            passwordField.classList.remove("error");
            passwordField.classList.add("success");
            message.innerText = "";
            submitButton.disabled = false;
        } else {
            passwordField.classList.remove("success");
            passwordField.classList.add("error");
            message.innerText = "Password must be at least 8 characters long and contain at least one special character.";
            submitButton.disabled = true;
        }
    }

    function checkPasswordMatch() {
        var password = document.getElementById("password").value;
        var rePassword = document.getElementById("re-password").value;
        var passwordField = document.getElementById("password");
        var rePasswordField = document.getElementById("re-password");
        var submitButton = document.getElementById("submitButton");

        if (password === rePassword && password.length >= 8 && /[^a-zA-Z0-9]/.test(password)) {
            passwordField.classList.remove("error");
            passwordField.classList.add("success");
            rePasswordField.classList.remove("error");
            rePasswordField.classList.add("success");
            submitButton.disabled = false;
        } else {
            passwordField.classList.remove("success");
            passwordField.classList.add("error");
            rePasswordField.classList.remove("success");
            rePasswordField.classList.add("error");
            submitButton.disabled = true;
        }
    }

    $(document).ready(function() {
        $('.nav-link').click(function() {
            $(this).parent().toggleClass('menu-open');
        });
    });
</script>
</body>
</html>
