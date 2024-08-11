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
    </style>
        <!-- Local FontAwesome CSS -->
        <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
</head>
<body class="text-sm">

   <div class="wrapper">
    <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light" style="background: rgb(6, 193, 255);">
        @include('includes.nav')
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        @include('includes.sidebar.sidebar')  
    </aside>
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 mt-5">
                        <div class="card">
                            <div class="card-header" style="background: rgb(6, 193, 255);">
                                <h4>Create Account
                                    <a href="{{ url('users') }}" class="btn btn-primary float-right">Back</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form id="registrationForm" action="{{ url('users') }}" method="POST" onsubmit="return validateForm()">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" class="form-control" oninput="checkPassword()" required>
                                        <div id="passwordMessage"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="re-password">Re-enter your password</label>
                                        <input type="password" id="re-password" name="re-password" class="form-control" oninput="checkPasswordMatch()" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="roles">User-type</label>
                                        <select name="roles[]" class="form-control" multiple required>
                                            <option value="">Select Roles</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}">{{ $role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button id="submitButton" type="submit" class="btn btn-success" disabled>Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="main-footer">
        @include('includes.footer')
    </footer>
</div>

<!-- jQuery (local) -->
<script src="../js/jquery.min.js"></script>

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
        // Toggle sidebar menu
        $('.nav-link').click(function() {
            var parent = $(this).parent();
            if ($(parent).hasClass('menu-open')) {
                $(parent).removeClass('menu-open');
            } else {
                $(parent).addClass('menu-open');
            }
        });
    });
</script>
</body>
</html>
