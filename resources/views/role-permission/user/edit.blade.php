<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/sweetalert2.min.css') }}">
</head>
<body class="text-sm" style="background-color: #cecece">

   <div class="wrapper">
    <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light" style="background: #084262;">
        @include('includes.nav')
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
        @include('includes.sidebar.sidebar')  
    </aside>
    <div class="content-wrapper bg-transparent">
        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 mt-5">
                        <div class="card smoky-shadow">
                            <div class="card-header text-white" style="background: rgb(20, 121, 116);">
                                <h4>Edit Account
                                    <a href="{{ url('users') }}" class="btn btn-danger float-right">Back</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('users/'.$user->id) }}" method="POST" id="save-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <button type="button" class="form-control btn btn-success" id="save-button">Save</button>
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
    document.getElementById('save-button').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save this data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Replace `your-form-id` with the ID of your form
                const form = document.getElementById('save-form');
                if (form) {
                    form.submit(); // Submit the form
                    Swal.fire(
                        'Saved!',
                        'Your data has been saved.',
                        'success'
                    );
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
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
