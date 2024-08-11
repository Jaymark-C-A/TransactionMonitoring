<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
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
                                <h4>Edit Account
                                    <a href="{{ url('users') }}" class="btn btn-primary float-right">Back</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('users/'.$user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" readonly value="{{ $user->email }}" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" value="{{ $user->password }}">
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="roles">User-type</label>
                                        <select name="roles[]" class="form-control" multiple>
                                            <option value="">Select Roles</option>
                                            @foreach ($roles as $role)
                                                <option 
                                                    value="{{ $role }}"
                                                    {{ in_array($role, $userRoles) ? 'selected':'' }}
                                                >
                                                    {{ $role }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-success">Save</button>
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
