<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body class="text-sm">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-lg navbar-light bg-light">
            @include('includes.nav')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('includes.sidebar.sidebar-offices')  
        </aside>
        <div class="content-wrapper bg-light">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">Dashboard</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            @include('includes.footer')
        </footer>
    </div>
    <!-- ./wrapper -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
