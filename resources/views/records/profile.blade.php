<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        /* Custom styles */
        body {
            font-family: Arial, sans-serif;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
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
            @include('includes.sidebar.sidebar-records')   
        </aside>
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">My Profile</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5 p-5" style="border:2px solid rgb(6, 193, 255);">
                            <div class="text-center">
                                <form id="profile-picture-form" action="{{ route('profile.picture.upload') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <label for="profile-picture-input">
                                        @if(Auth::user()->profile_picture)
                                            <img id="profile-picture" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="profile-img">
                                        @else
                                            <img id="profile-picture" src="https://via.placeholder.com/150" alt="Default Profile Picture" class="profile-img">
                                        @endif
                                    </label><br>
                                    <input type="file" name="profile_picture" style="background: rgb(6, 193, 255); border-radius: 5px;">
                                    <button type="submit" style="background: rgb(6, 193, 255); border-radius: 5px; border:1px solid green; font-size:14px;">Upload</button>
                                </form>
                                <h4 class="mt-3">{{ Auth::user()->name }}</h4>
                                @foreach (auth()->user()->roles as $role)
                                    {{ $role->name }}
                                @endforeach
                            </div>  
                            <div class="col-md- mt-3">
                                <table class="table table-bordered table-striped" style="background: rgb(6, 193, 255);">
                                    <h5>Employee Info :</h5>
                                    <tbody>
                                        <tr>
                                            <th>Employee No.</th>
                                            <td>{{ Auth::user()->employee_no }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
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
                        <div class="col-md-7">
                            <table class="table table-bordered table-striped" style="background: rgb(6, 193, 255);">
                                <h5 class="">General Info :</h5>
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ Auth::user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ Auth::user()->email }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            @include('includes.footer')
        </footer>
    </div>
    <!-- ./wrapper -->

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
