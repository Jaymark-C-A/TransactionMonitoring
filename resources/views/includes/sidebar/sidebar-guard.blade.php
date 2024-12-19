<!-- Main Sidebar Container -->


<style>
    .nav-link.active {
        background-color: #007bff !important;
        color: #ffffff !important;
        font-weight: bold;
    }

    .nav-treeview .nav-link.active {
        background-color: #007bff !important;
        color: #ffffff !important;
        font-weight: bold;
    }

    .nav-item.active > .nav-link {
        background-color: #007bff !important;
        color: #ffffff !important;
    }

    .smoky-shadow {
        box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px !important;
    }
</style>
<!-- Sidebar -->
<div class="sidebar">
    <ul class="navbar-nav" style="display: flex; justify-content: center; align-items: center; padding-top:20px;">
        <li class="nav-item">
            <a id="hamburger-menu" class="nav-link" data-widget="pushmenu" href="/admin-guard/dashboard" role="button">
                <img src="{{ asset('img/logo.png') }}" alt="logo" style="width: 80px; height: auto;">
            </a>
        </li>
        <li class="nav-item" style="margin-left: auto; margin-right: auto;">
            <a href="#" class="nav-link">TRANSACTION MONITORING</a>
        </li>
    </ul>

    <div class="dropdown-divider"></div> <!-- Divider for better separation -->

    <!-- Sidebar Menu -->
    <nav class="mt-2 vh-100">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header text-gray text-xs">MAIN NAVIGATION</li>
        <li class="nav-item">
        <a href="/admin-guard/dashboard" class="nav-link nav-text py-2">
            <i class="fa fa-dashboard" style="font-size:22px; padding-right: 10px;"></i>
            <p class="text-md">Dashboard</p>
        </a>
        </li>
        </ul>
        <ul class="nav nav-pills nav-sidebar flex-column" style="margin-top: 20px;">
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link nav-text py-2"
                   onclick="event.preventDefault(); showLogoutAlert();">
                    <i class="fa fa-sign-out-alt" style="font-size:22px; padding-right: 10px;"></i>
                    <p class="text-md">Logout</p>
                </a>
        
                <!-- Logout form (hidden) -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>   
        </nav>
    </div>

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
    
        document.addEventListener("DOMContentLoaded", function () {
        const currentURL = window.location.href; // Use full URL for comparison
        const navLinks = document.querySelectorAll(".sidebar .nav-link");
    
        navLinks.forEach(link => {
            // Skip the hamburger-menu and reports-dropdown links
            if (link.id === "hamburger-menu" || link.id === "reports-dropdown") return;
    
            // Check if the full link's href matches the current URL
            if (link.href === currentURL) {
                link.classList.add("active");
                link.closest(".nav-item").classList.add("active");
            }
        });
    });
    
    </script>