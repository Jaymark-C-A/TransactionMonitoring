<!-- Main Sidebar Container -->


<!-- Sidebar -->
<div class="sidebar">
    <ul class="navbar-nav" style="display: flex; justify-content: center; align-items: center;">
        <li class="nav-item">
            <a id="hamburger-menu" class="nav-link" data-widget="pushmenu" href="/super-admin/dashboard" role="button">
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
        <a href="/super-admin/dashboard" class="nav-link nav-text" style="background: rgb(6, 193, 255);">
            <i class="fa fa-dashboard" style="font-size:24px; padding-right: 10px;"></i>
            <p class="text-sm">Dashboard</p>
        </a>
        </li>
        {{-- <li class="nav-header text-gray text-xs">TRANSACTION</li> --}}
        <li class="nav-item">
        <a href="/view" class="nav-link nav-text">
            <i class="fa fa-tv" style="font-size:20px; padding-right: 10px;"></i>
            <p class="text-sm">Monitor</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="#" class="nav-link nav-text">
            <i class="ion ion-stats-bars" style="font-size:28px; padding-right: 14px;"></i>
            <p class="text-sm">Reports</p>
            <i class="right fa fa-angle-down" style="font-size:24px"></i>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="/super-admin/reports/transactReport" class="nav-link nav-text">
                <i class="fas fa-clipboard-list" style="font-size:24px; padding-right: 10px; text-indent: 10px;"></i>
                <p class="text-sm">Transaction Reports</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="pages/tables/data.html" class="nav-link nav-text">
                <i class="fas fa-clipboard-list" style="font-size:24px; padding-right: 10px;"></i>
                <p class="text-sm">Report 2</p>
            </a>
            </li>
        </ul>
        </li>
        <li class="nav-header text-gray text-xs">USER MANAGEMENT</li>
        <li class="nav-item">
            <a href="/super-admin/profile" class="nav-link nav-text">
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
            <li class="nav-item">
                <a href="#" class="nav-link nav-text">
                    <i class="fas fa-user-cog" style="font-size:24px; padding-right: 10px; text-indent: 10px;"></i>
                    <p class="text-sm">User Settings</p>
                    <i class="right fa fa-angle-down" style="font-size:24px"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('users') }}" class="nav-link nav-text">
                            <i class="fas fa-user-plus" style="font-size:24px; padding-right: 10px; text-indent: 20px;"></i>
                            <p class="text-sm">Create Account</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('roles') }}" class="nav-link nav-text">
                            <i class="fas fa-user-check" style="font-size:24px; padding-right: 10px; text-indent: 20px;"></i>
                            <p class="text-sm">User Types</p>
                        </a>
                    </li>
            </ul>
        </li>
                <li class="nav-item ">
            <a href="#" class="nav-link nav-text">
                <i class="fas fa-user-cog" style="font-size:24px; padding-right: 10px; text-indent: 10px;"></i>
                <p class="text-sm">Account Settings</p>
                <i class="right fa fa-angle-down" style="font-size:24px"></i>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/account_setting/super-admin/account" class="nav-link nav-text">
                        <i class="fas fa-user-alt" style="font-size:24px; padding-right: 10px; text-indent: 20px;"></i>
                        <p class="text-sm">Account</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/account_setting/super-admin/password" class="nav-link nav-text">
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
            <i class="fas fa-trash-alt" style="font-size:24px; padding-right: 14px;"></i>
            <p class="text-sm">Logs</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('permissions') }}" class="nav-link nav-text">
            <i class="fa fa-angle-down" style="font-size:24px; padding-right: 14px;"></i>
            <p class="text-sm">Help</p>
        </a>
    </li>
        </ul>
    </nav>
</div>
