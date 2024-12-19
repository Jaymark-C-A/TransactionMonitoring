
<!-- Left navbar links -->
<style>
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
    <li class="nav-item" style="margin-left: auto; margin-right: auto;">
        <a href="#" class="nav-link text-lg d-none d-sm-block text-white">OLONGAPO CITY NATIONAL HIGH SCHOOL</a>
        <a id="hamburger-menu" class="nav-link d-sm-none d-md-none d-lg-none" data-widget="pushmenu" href="/TransactionMonitoring/dashboard" role="button">
            <img src="{{ asset('img/logo.png') }}" alt="logo" style="width: 70px; height: auto;">
        </a>
    </li>
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto flex" style="margin-left: 30px;">
    <!-- Navbar dropdown -->

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
