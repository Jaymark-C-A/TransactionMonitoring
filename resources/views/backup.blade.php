<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">
</head>
<body class="text-sm" style="background-color: #cecece;">
    <div class="wrapper" style="background-color: transparent">
        <nav class="main-header navbar navbar-expand-lg navbar-light" style="background-color: #084262;">
            @include('includes.nav')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
            @include('includes.sidebar.sidebar')  
        </aside>
        <div class="content-wrapper" style="background-color: transparent">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">Account Backup and Restore</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="dashboard" class="breadcrumb-item active">Dashboard</a>
                                <li class="breadcrumb-item"><a href="/backup">Backup and Restore</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <div class="card smoky-shadow">
                    <div class="card-header text-light" style="background-color: #0c6899">
                        <h1>Database Backup and Restore</h1>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header" style="background-color: #A8D5BA">
                                        <h3 class="text-white" >Download Backup</h3>
                                    </div>
                                    <div class="card-body">
                                        <button id="downloadBackup" class="btn btn-primary">Download Backup</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header" style="background-color: #B8A6D1">
                                        <h3 class="text-white">Upload Backup</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('database.upload') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="sqlFile">Choose SQL File</label>
                                                <input type="file" name="sql_file" id="sqlFile" class="form-control" accept=".sql" required>
                                            </div>
                                            <button type="submit" class="btn btn-success">Upload SQL File</button>
                                        </form>
                                       @if($errors->any()) 
                                            <div class="alert alert-danger mt-3">
                                                @foreach ($errors->all() as $error)
                                                    <p>{{ $error }}</p>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('../js/bootstrapInfo.bundle.min.js') }}"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="{{ asset('../js/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // SweetAlert2 confirmation for "Download Backup" button
            $('#downloadBackup').on('click', function(e) {
                e.preventDefault(); // Prevent default action
                
                // Show confirmation alert
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to download the latest backup!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, download it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonColor: '#28a745',  // Green color for 'Yes'
                    cancelButtonColor: '#dc3545'   // Red color for 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('database.download') }}"; // Redirect to download link
                    }
                });
            });

            // SweetAlert2 confirmation for "Upload SQL File" button
            $('form').on('submit', function(e) {
                e.preventDefault(); // Prevent form submission
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to upload a new backup!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, upload it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonColor: '#28a745',  // Green color for 'Yes'
                    cancelButtonColor: '#dc3545'   // Red color for 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Submit the form after confirmation
                    }
                });
            });

            // Display success alert if the upload is successful
            @if(session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>


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
