<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
    .smoky-shadow {
        box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
    }
    </style>

    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/dataTable.css') }}">
</head>
<body class="text-sm" style="background-color: #cecece">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light" style="background-color: #084262;">
            @include('includes.nav')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
            @include('includes.sidebar.sidebar')   
        </aside>
        <div class="content-wrapper" style="background-color: transparent">
            <div class="content">
                <div class="container-fluid">
                    <div class="row ">
                        <div class="col-lg-12">
                            @if (@session('status'))
                                <div class="alert alert-success mt-3">{{ session('status') }}</div>
                            @endif
                            <div class="card mt-3 smoky-shadow">
                                <div class="card-header" style="background: rgb(39, 150, 126);">
                                    <h4 class="text-white" style="letter-spacing: 4px" >User Account</h4>
                                </div>
                                <div class="card-body">
                                    <table id="userTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Roles</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)  
                                                @if (!$user->is_archived)  <!-- Add this check -->
                                                    <tr>
                                                        <td>{{ $user->id }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>
                                                            @if (!empty($user->getRoleNames()))
                                                                @foreach ($user->getRoleNames() as $rolename)
                                                                    <label class="badge badge-primary mx-1">{{ $rolename }}</label>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (!$user->hasRole('Super-admin'))
                                                                <a href="{{ url('users/'.$user->id.'/edit') }}" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                                                                <button class="btn btn-warning archive-btn" data-user-id="{{ $user->id }}"><i class="fa-solid fa-box-archive"></i> Archive</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <a href="{{ url('users/create') }}" class="btn btn-success float-right mt-3"><i class="fa-solid fa-plus"></i> Add User Account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- jQuery (local) -->
<script src="{{ asset('../js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('../js/jquery.min.js') }}"></script>
<script src="{{ asset('../js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('../js/dataTable.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable for the user table
        $('#userTable').DataTable();
        // Toggle sidebar menu
        $('.nav-link').click(function() {
            var parent = $(this).parent();
            if ($(parent).hasClass('menu-open')) {
                $(parent).removeClass('menu-open');
            } else {
                $(parent).addClass('menu-open');
            }
        });
        // Add click event listener to archive buttons
        $('.archive-btn').click(function() {
            var userId = $(this).data('user-id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This user will be archived and will not appear in active lists.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, archive it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with archiving
                    window.location.href = "{{ url('users') }}/" + userId + "/archive";
                }
            });
        });
    });
</script>
</body>
</html>
