<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
    body {
        font-family: Arial, sans-serif;
    }
    .position-relative:hover .position-absolute {
        opacity: 1; /* Show overlay on hover */
    }
    .smoky-shadow {
        box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
    }
    </style>
            <!-- Local FontAwesome CSS -->
            <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
            <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
            <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">    
</head>
<body class="text-sm" style="background-color: #cecece;">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light" style="background-color: #084262;">
            @include('includes.nav')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
            @include('includes.sidebar.sidebar')  
        </aside>
        <div class="content-wrapper" style="background-color: transparent">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">My Profile</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="dashboard" class="breadcrumb-item active">Dashboard</a>
                                <li class="breadcrumb-item"><a href="profile">Profile</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 p-4 mx-auto mb-3 smoky-shadow bg-light">
                            <div class="text-center">
                                <label for="profile-picture-input" class="position-relative">
                                    <img src="../img/sysAd.png" alt="System Admin Profile Picture" class="profile-img border-transparent" style="width: 200px; height: 200px; object-fit: cover;">
                                </label>
                                <h2 class="mt-3">{{ Auth::user()->name }}</h2>
                                @foreach (auth()->user()->roles as $role)
                                    <span class="badge bg-info text-sm">{{ $role->name }}</span>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <table class="table table-bordered table-striped" style="background: rgb(6, 193, 255);">
                                    <h2 class="mb-4">Employee Info :</h2>
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ Auth::user()->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ Auth::user()->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>User-type</th>
                                            <td>
                                                @foreach (auth()->user()->roles as $role)
                                                    {{ $role->name }}
                                                @endforeach</td>
                                        </tr>
                                        <tr>
                                            <th>Date Created</th>
                                            <td>{{ Auth::user()->created_at }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="col-md-6 p-1 mx-auto mb-3">
                            <div class="" style="background-color: transparent">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>

                        <div class="col-md-6 p-1 mx-auto mb-3">
                            <div class="" style="background-color: transparent;">
                                    @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery (local) -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery (local) -->
    <script src="../js/jquery.min.js"></script>

    <script src="{{ asset('../js/sweetalert2.min.js') }}"></script>
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
