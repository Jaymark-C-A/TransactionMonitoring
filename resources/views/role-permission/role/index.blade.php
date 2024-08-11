<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        .permission-column {
            max-width: 500px;
        }
    </style>
    <!-- Local FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">
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
            <div class="container-fluid">
                <div class="row">
                    {{-- @include('role-permission.nav-links') --}}
                    <div class="col-lg-12">
                        @if (@session('status'))
                            <div class="alert alert-success mt-3">{{ session('status') }}</div>
                        @endif
                        <div class="card mt-5">
                            <div class="card-header" style="background: rgb(6, 193, 255);">
                                <h4>User types</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            {{-- <th>Permissions</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)  
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>{{ $role->name }}</td>
                                                {{-- <td class="permission-column">
                                                    @if (!empty($role->getPermissionNames()))
                                                        @foreach ($role->getPermissionNames() as $permissionname)
                                                            <label class="badge badge-primary mx-2">{{ $permissionname }}</label>
                                                        @endforeach
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    @if ($role->name != 'Super-admin')
                                                        <a href="{{ url('roles/'.$role->id.'/edit') }}" class="btn btn-success">Edit</a>
                                                        <a href="javascript:void(0);" class="btn btn-danger" onclick="confirmDelete({{ $role->id }})">Delete</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <a href="{{ url('roles/create') }}" class="btn btn-primary float-right mt-3">Add User-type</a>
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
<script src="{{ asset('../js/jquery.min.js') }}"></script>
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

    function confirmDelete(roleId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'roles/' + roleId + '/delete';
            }
        })
    }
</script>
</body>
</html>
