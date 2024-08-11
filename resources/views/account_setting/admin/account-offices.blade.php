<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body class="text-sm">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light" style="background: rgb(6, 193, 255);">
            @include('includes.nav')
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('includes.sidebar.sidebar-admin')  
        </aside>
        <div class="content-wrapper">
            <x-app-layout>
                <div class="py-5">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <div class="max-w-xl">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                </div>
            </x-app-layout> 
            
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
