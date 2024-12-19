<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        .smoky-shadow {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
        }
    </style>
    <!-- Local FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">
    <!-- DataTables CSS -->
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
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="m-0">List of Archives</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="dashboard" class="breadcrumb-item active">Dashboard</a>
                            <li class="breadcrumb-item"><a href="archive">Archive</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->
        <div class="content">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="card mt-2 smoky-shadow">
                            <div class="card-header" style="background: rgb(39, 150, 126);">
                                <h4 class="text-white" style="letter-spacing: 4px" >Archive Data</h4>
                            </div>
                            <div class="card-body">
                                <table id="archiveTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Archived Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->updated_at }}</td>  <!-- Display the date when archived -->
                                            <td>
                                                <a href="javascript:void(0);" class="btn btn-success restore-btn" data-user-id="{{ $user->id }}">
                                                    <i class="fas fa-undo"></i> Restore
                                                </a>
                                                <button data-user-id="{{ $user->id }}" class="btn btn-danger delete-btn">
                                                    <i class="fas fa-trash-alt"></i> Permanent Delete
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
<!-- DataTables JS -->
<script src="{{ asset('../js/dataTable.js') }}"></script>

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

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#archiveTable').DataTable();

        // Add click event listener to restore buttons
        $('.restore-btn').click(function() {
            var userId = $(this).data('user-id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'This user will be restored to the active list.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with restoring
                    window.location.href = "{{ url('users') }}/" + userId + "/restore";
                }
            });
        });

        // Add click event listener to delete buttons
        $('.delete-btn').click(function() {
            var userId = $(this).data('user-id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This user will be permanently deleted and cannot be restored.',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with permanent delete
                    window.location.href = "{{ url('users') }}/" + userId + "/delete";
                }
            });
        });
    });
</script>
</body>
</html>
