<!-- Left navbar links -->
<style>
    *{
        margin: 0;
        padding: 0;
    }
    body.dark-mode {
        background-color: #121212;
    }

    body.widescreen-mode {
        width: 100vw;
        /* Add any additional widescreen styles here */
    }
    
</style>

<link rel="stylesheet" href="{{ asset('../css/bootstrap.min.css') }}">

<ul class="navbar-nav" style="display: flex; justify-content: center; align-items: center;">
    <li class="nav-item">
        <a id="hamburger-menu" class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fa fa-bars" style="font-size:22px; color:white;"></i>
        </a>
    </li>
    <li class="nav-item" style="margin-left: auto; margin-right: auto;">
        {{-- <a href="#" class="nav-link">OLONGAPO NATIONAL HIGHSCHOOL</a> --}}
    </li>
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto flex">
    <!-- Navbar dropdown -->
    <li class="nav-item dropdown d-none d-lg-block">
        <a id="hamburger-menu" class="nav-link flex-right" data-widget="pushmenu" href="/super-admin/view" role="button">
            <i class="fa fa-eye" style="font-size:20px; color:white"></i>
        </a>
    </li>
    <li class="nav-item dropdown mr-5">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @php
                $user = Auth::user();
                $profileUrl = match(true) {
                    $user->hasRole('Super-admin') => route('profile.super-admin', $user->id),
                    $user->hasRole('Offices') => route('profile.offices', $user->id),
                    default => route('profile.super-admin', $user->id)
                };
            @endphp
            {{-- <a class="dropdown-item" href="{{ $profileUrl }}">
                <i class="fas fa-user" style="margin-right: 8px;"></i>
                Profile</a> --}}
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); showLogoutAlert();">
                <i class="fa fa-sign-out-alt" style="margin-right: 8px;"></i>
                {{ __('Log Out') }}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <div class="dropdown-divider"></div> <!-- Divider for better separation -->

            <!-- Dark Mode Toggle -->
            <a class="dropdown-item" href="#" id="dark-mode" style="display: flex; align-items: center;">
                <i class="fas fa-moon" style="margin-right: 8px;"></i> <!-- Dark Mode icon -->
                Dark Mode
            </a>

            <!-- Light Mode Toggle -->
            <a class="dropdown-item" href="#" id="light-mode" style="display: flex; align-items: center;">
                <i class="fas fa-sun" style="margin-right: 8px;"></i> <!-- Light Mode icon -->
                Light Mode
            </a>
        </div>
    </li>
</ul>

<script src="{{ asset('../js/jquery.min.js') }}"></script>
<script src="{{ asset('../js/bootstrap.bundle.min.js') }}"></script>
<script>
    function showLogoutAlert() {
        Swal.fire({
            title: 'Are you sure you want to log out?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log out!',
            position: 'top'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    $(document).ready(function() {
        // Toggle sidebar menu
        $('#hamburger-menu').click(function() {
            $('body').toggleClass('sidebar-collapse');
        });

        // Dark mode / Light mode toggle logic
        const body = document.body;

        // Check local storage for dark mode preference
        if (localStorage.getItem('darkMode') === 'enabled') {
            body.classList.add('dark-mode');
        }

        document.getElementById('dark-mode').addEventListener('click', function(e) {
            e.preventDefault();
            body.classList.add('dark-mode');
            localStorage.setItem('darkMode', 'enabled');
        });

        document.getElementById('light-mode').addEventListener('click', function(e) {
            e.preventDefault();
            body.classList.remove('dark-mode');
            localStorage.setItem('darkMode', 'disabled');
        });
    });
</script>
