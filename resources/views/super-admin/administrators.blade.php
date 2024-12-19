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
                        <h4 class="m-0">List of Personels</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="dashboard" class="breadcrumb-item active">Dashboard</a>
                            <li class="breadcrumb-item"><a href="administrators">Personels</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form for Adding Principal -->
                        <div class="card mt-2 smoky-shadow">
                            <div class="card-header" style="background: rgb(83, 61, 145);">
                                <h4 class="text-white" style="letter-spacing: 4px">Add Personels</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('administrators.store') }}" method="POST">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <select class="form-control" id="title" name="title">
                                                    {{-- <option value="">-- Select Title --</option> --}}
                                                    <option value="Mr.">Mr.</option>
                                                    <option value="Ms.">Ms.</option>
                                                    <option value="Mrs.">Mrs.</option>
                                                    <option value="Dr.">Dr.</option>
                                                    <option value="Prof.">Prof.</option>
                                                    <option value="Ph.D.">Ph.D.</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="firstName">First Name</label>
                                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="middleName">Middle Name</label>
                                                <input type="text" class="form-control" id="middleName" name="middleName">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lastName">Last Name</label>
                                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-5" style="display: none;">
                                            <div class="form-group">
                                                <label for="name">Full Name (Combined)</label>
                                                <input type="text" class="form-control" id="name" name="name" required readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="position">Position</label>
                                                    <select class="form-control" id="position" name="position" required>
                                                        <option value="">Select Position</option>
                                                        <option value="Accountant I">Accountant I</option>
                                                        <option value="Accountant III">Accountant III</option>
                                                        <option value="Administrative Aide I">Administrative Aide I</option>
                                                        <option value="Administrative Aide II">Administrative Aide II</option>
                                                        <option value="Administrative Aide III">Administrative Aide III</option>
                                                        <option value="Administrative Aide IV">Administrative Aide IV</option>
                                                        <option value="Administrative Aide V">Administrative Aide V</option>
                                                        <option value="Administrative Aide VI">Administrative Aide VI</option>
                                                        <option value="Administrative Assistant I">Administrative Assistant I</option>
                                                        <option value="Administrative Assistant II">Administrative Assistant II</option>
                                                        <option value="Administrative Assistant III">Administrative Assistant III</option>
                                                        <option value="Administrative Officer I">Administrative Officer I</option>
                                                        <option value="Administrative Officer II">Administrative Officer II</option>
                                                        <option value="Administrative Officer III">Administrative Officer III</option>
                                                        <option value="Administrative Officer IV">Administrative Officer IV</option>
                                                        <option value="Administrative Officer V">Administrative Officer V</option>
                                                        <option value="Assistant School Principal">Assistant School Principal</option>
                                                        <option value="Assistant Schools Division Superintendent">Assistant Schools Division Superintendent</option>
                                                        <option value="Attorney III">Attorney III</option>
                                                        <option value="Chief Education Program Supervisor, CID">Chief Education Program Supervisor, CID</option>
                                                        <option value="Chief Education Program Supervisor, SGOD">Chief Education Program Supervisor, SGOD</option>
                                                        <option value="Dentist II">Dentist II</option>
                                                        <option value="Division Guidance Coordinator">Division Guidance Coordinator</option>
                                                        <option value="Education Program Specialist II">Education Program Specialist II</option>
                                                        <option value="Education Program Supervisor">Education Program Supervisor</option>
                                                        <option value="Engineer III">Engineer III</option>
                                                        <option value="Guidance Coordinator I">Guidance Coordinator I</option>
                                                        <option value="Guidance Counselor I">Guidance Counselor I</option>
                                                        <option value="Guidance Counselor II">Guidance Counselor II</option>
                                                        <option value="Guidance Counselor III">Guidance Counselor III</option>
                                                        <option value="Head Teacher I">Head Teacher I</option>
                                                        <option value="Head Teacher II">Head Teacher II</option>
                                                        <option value="Head Teacher III">Head Teacher III</option>
                                                        <option value="Head Teacher IV">Head Teacher IV</option>
                                                        <option value="Head Teacher V">Head Teacher V</option>
                                                        <option value="Head Teacher VI">Head Teacher VI</option>
                                                        <option value="Information Technology Officer I">Information Technology Officer I</option>
                                                        <option value="Librarian II">Librarian II</option>
                                                        <option value="Master Teacher I">Master Teacher I</option>
                                                        <option value="Master Teacher II">Master Teacher II</option>
                                                        <option value="Medical Officer III">Medical Officer III</option>
                                                        <option value="Nurse II">Nurse II</option>
                                                        <option value="OIC - Assistant School Principal">OIC - Assistant School Principal</option>
                                                        <option value="Planning Officer III">Planning Officer III</option>
                                                        <option value="Principal I">Principal I</option>
                                                        <option value="Principal II">Principal II</option>
                                                        <option value="Principal III">Principal III</option>
                                                        <option value="Principal IV">Principal IV</option>
                                                        <option value="Project Development Officer I">Project Development Officer I</option>
                                                        <option value="Project Development Officer II">Project Development Officer II</option>
                                                        <option value="Public Schools District Supervisor">Public Schools District Supervisor</option>
                                                        <option value="Registrar I">Registrar I</option>
                                                        <option value="Schools Division Superintendent">Schools Division Superintendent</option>
                                                        <option value="Security Guard I">Security Guard I</option>
                                                        <option value="Security Guard II">Security Guard II</option>
                                                        <option value="Senior Education Program Specialist">Senior Education Program Specialist</option>
                                                        <option value="Special Education Teacher I">Special Education Teacher I</option>
                                                    </select>
                                                </div>
                                            </div>  

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="start_date">Start Date</label>
                                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                                </div>
                                            </div> 
                                                                                                                         <div class="col-md-6">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success form-control">Save Administrator</button>
                                </form>
                            </div>
                        </div>

                        <!-- Table for Listing Administrators -->
                        <div class="card mt-5 smoky-shadow">
                            <div class="card-header" style="background: rgb(64, 105, 151);">
                                <h4 class="text-white" style="letter-spacing: 4px">Personels List</h4>
                            </div>
                            <div class="card-body">
                                <table id="adminTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Position</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($administrator as $admin)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->position }}</td> 
                                            <td>
                                                <!-- Delete button with Swal confirmation -->
                                                <form action="{{ route('administrators.destroy', $admin->id) }}" method="POST" class="d-inline-block" id="deleteForm{{ $admin->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger delete-btn" data-id="{{ $admin->id }}">Delete</button>
                                                </form>
                                                  
                                                <!-- Edit button -->
                                                <button class="btn btn-warning edit-btn" 
                                                        data-id="{{ $admin->id }}" 
                                                        data-name="{{ $admin->name }}" 
                                                        data-email="{{ $admin->email }}" 
                                                        data-position="{{ $admin->position }}" 
                                                        data-start_date="{{ $admin->start_date }}">Edit</button>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Administrator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('administrators.update', 'admin_id') }}" method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="edit_position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="edit_position" name="position">
                    </div>
                    <div class="mb-3">
                        <label for="edit_start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="edit_start_date" name="start_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery (local) -->

<script src="{{ asset('../js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('../js/bootstrap.bundle.min.js') }}"></script>

<!-- Bootstrap Bundle with Popper -->
<script src="{{ asset('../js/bootspopper.js') }}"></script>
<!-- DataTables JS -->
<script src="{{ asset('../js/dataTable.js') }}"></script>

<script>
    function updateNameField() {
        // Get values from the inputs
        const title = document.getElementById('title').value.trim();
        const firstName = document.getElementById('firstName').value.trim();
        const middleName = document.getElementById('middleName').value.trim();
        const lastName = document.getElementById('lastName').value.trim();

        // Concatenate the values to form the full name
        const fullName = [title, firstName, middleName, lastName].filter(Boolean).join(' ');

        // Update the combined name field
        document.getElementById('name').value = fullName;
    }

    // Attach event listeners to update the name field whenever input changes
    document.getElementById('title').addEventListener('input', updateNameField);
    document.getElementById('firstName').addEventListener('input', updateNameField);
    document.getElementById('middleName').addEventListener('input', updateNameField);
    document.getElementById('lastName').addEventListener('input', updateNameField);
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


<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#adminTable').DataTable();
    });

    // Edit button click handler
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var position = $(this).data('position');
        var start_date = $(this).data('start_date');
        
        // Set the form action to the correct route for this administrator
        $('#editForm').attr('action', '/administrators/' + id);
        
        // Fill the form inputs with the current data
        $('#edit_name').val(name);
        $('#edit_email').val(email);
        $('#edit_position').val(position);
        $('#edit_start_date').val(start_date);
        
        // Show the modal
        $('#editModal').modal('show');
    });

    // Delete button click handler with SweetAlert2 confirmation
    $(document).on('click', '.delete-btn', function() {
        var adminId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Trigger the form submission
                $('#deleteForm' + adminId).submit();
            }
        });
    });

        // Add confirmation on "Save changes" button click
    $('#editForm').submit(function(e) {
        e.preventDefault(); // Prevent form submission

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save the changes?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with form submission
                $('#editForm')[0].submit();
            }
        });
    });
</script>
</body>
</html>
