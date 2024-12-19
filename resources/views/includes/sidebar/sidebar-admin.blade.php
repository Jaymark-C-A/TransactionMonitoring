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
            <a id="hamburger-menu" class="nav-link" data-widget="pushmenu" href="/admin/dashboard" role="button">
                <img src="{{ asset('img/logo.png') }}" alt="logo" style="width: 90px; height: auto;">
            </a>
        </li>
        <li class="nav-item" style="margin-left: auto; margin-right: auto;">
            <a href="/admin/dashboard" class="nav-item">TRANSACTION MONITORING</a>
        </li>
    </ul>

    <div class="dropdown-divider"></div> <!-- Divider for better separation -->

    <!-- Sidebar Menu -->
    <nav class="mt-2 vh-100">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header text-gray text-xs">MAIN NAVIGATION</li>
        <li class="nav-item">
            <a href="/admin/dashboard" class="nav-link nav-text py-2">
                <i class="fa fa-dashboard" style="font-size:22px; padding-right: 10px;"></i>
                <p class="text-md">Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
        <a href="/admin/monitor" class="nav-link nav-text py-2">
            <i class="fa fa-tv" style="font-size:22px; padding-right: 10px;"></i>
            <p class="text-md">Monitor</p>
        </a>
        </li>
        <li class="nav-item">
            <a href="/admin/TransactionHistory" class="nav-link nav-text py-2">
                <i class="fa fa-chart-bar" style="font-size:22px; padding-right: 10px;"></i>
                <p class="text-md">Transactions History</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link nav-text py-2">
                <i class="fa fa-list" aria-hidden="true" style="font-size: 16px; padding-right: 8px;"></i>
                <p class="text-md">Reports</p>
                <i class="right fa fa-angle-down" style="font-size:20px"></i>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="/admin/reports/transactReport" class="nav-link nav-text py-2">
                    <i class="fas fa-clipboard-list" style="font-size: 16px; padding-right: 10px; text-indent: 20px;"></i>
                    <p class="text-md">Transactions</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="/admin/reports/feedbackReport" class="nav-link nav-text py-2">
                    <i class="fas fa-clipboard-list" style="font-size: 16px; padding-right: 10px; text-indent: 20px;"></i>
                    <p class="text-md">Feedbacks</p>
                </a>
                </li> 
            </ul>
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