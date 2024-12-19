<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    <!-- Local FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset('../fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">
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
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 mt-5">
                        <div class="card">
                            <div class="card-header" style="background: rgb(6, 193, 255);">
                                <h4>Create User-type
                                    <a href="{{ url('roles') }}" class="btn btn-primary float-right ">Back</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('roles') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name">User-type<span style="color: red;"> *</span></label>
                                        <select name="name" class="form-control" id="name">
                                            <option value="" disabled selected>Select user type</option>
                                            <option value="Admin">Admin</option>
                                            <option value="Accounting">Accounting</option>
                                            <option value="Records">Records</option>
                                            <option value="Department_Head">Department_Head</option>
                                            <option value="Principal">Principal</option>
                                            <option value="Guard">Guard</option>
                                            <option value="Guest">Guest</option>
                                        </select>
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
    <footer class="main-footer bg-dark text-light py-16">
        @include('includes.footer')
    </footer>
</div>

<!-- jQuery (local) -->
<script src="../js/jquery.min.js"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
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
