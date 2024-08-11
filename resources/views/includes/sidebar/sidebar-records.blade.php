<!-- Main Sidebar Container -->


<!-- Sidebar -->
<div class="sidebar">
    <ul class="navbar-nav" style="display: flex; justify-content: center; align-items: center;">
        <li class="nav-item">
            <a id="hamburger-menu" class="nav-link" data-widget="pushmenu" href="/offices/dashboard" role="button">
                <img src="{{ asset('img/logo.png') }}" alt="logo" style="width: 70px; height: auto;">
            </a>
        </li>
        <li class="nav-item" style="margin-left: auto; margin-right: auto;">
            <a href="#" class="nav-link">TRANSACTION MONITORING</a>
        </li>
    </ul>
    <!-- Sidebar Menu -->
    <nav class="mt-2 vh-100">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header text-gray text-xs">MAIN NAVIGATION</li>
        <li class="nav-item menu-open">
        <a href="/records/dashboard" class="nav-link nav-text" style="background: rgb(6, 193, 255);">
            <i class="fa fa-dashboard" style="font-size:24px; padding-right: 10px;"></i>
            <p class="text-sm">Dashboard</p>
        </a>
        </li>
        <li class="nav-header text-gray text-xs">USER MANAGEMENT</li>
        <li class="nav-item">
            <a href="/records/profile" class="nav-link nav-text">
                <i class="fas fa-user-circle" style="font-size:24px; padding-right: 10px;"></i>
                <p class="text-sm">Profile</p>
            </a>
        </li>
        <li class="nav-item">
        <a href="#" class="nav-link nav-text">
            <i class="fas fa-gear" style="font-size:24px; padding-right: 10px;"></i>
            <p class="text-sm">Settings<i class="right fa fa-angle-down" style="font-size:24px"></i></p>
        </a>
        <ul class="nav nav-treeview">
                <li class="nav-item ">
            <a href="#" class="nav-link nav-text">
                <i class="fas fa-user-cog" style="font-size:24px; padding-right: 10px;"></i>
                <p class="text-sm">Account Settings</p>
                <i class="right fa fa-angle-down" style="font-size:24px"></i>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/account_setting/records/account-offices" class="nav-link nav-text">
                        <i class="fas fa-user-alt" style="font-size:24px; padding-right: 10px; text-indent: 20px;"></i>
                        <p class="text-sm">Account</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/account_setting/records/password-offices" class="nav-link nav-text">
                        <i class="fas fa-lock" style="font-size:24px; padding-right: 10px; text-indent: 20px;"></i>
                        <p class="text-sm">Password</p>
                    </a>
                </li>
            </ul>
            </li>
        </ul>
    </li>
    <li class="nav-header text-gray text-xs">OTHERS</li>
    <li class="nav-item">
        <a href="{{ url('permissions') }}" class="nav-link nav-text">
            <i class="fas fa-trash-alt" style="font-size:24px; padding-right: 10px;"></i>
            <p class="text-sm">Logs</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('permissions') }}" class="nav-link nav-text">
            <i class="fa fa-angle-down" style="font-size:24px; padding-right: 10px;"></i>
            <p class="text-sm">Help</p>
        </a>
    </li>
        </ul>
    </nav>
</div>

