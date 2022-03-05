@php
    $user = userInfo();
    $url = $_SERVER['REQUEST_URI'];
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">GBI PPL Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{$user['full_name']}}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="/" class="nav-link {{ $url == '/' ? 'active' : "" }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li> 
                <li class="nav-header">Schedule</li>
                <li class="nav-item">
                    <a href="/schedule" class="nav-link {{ $url == '/schedule' ? 'active' : "" }}">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Schedules 
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/schedule/create" class="nav-link {{ $url == '/schedule/create' ? 'active' : "" }}">
                        <i class="nav-icon far fa-calendar-plus"></i>
                        <p>
                            Add Schedule
                        </p>
                    </a>
                </li>
                <li class="nav-header">Khotbah</li>
                <li class="nav-item">
                    <a href="/khotbah" class="nav-link {{ $url == '/khotbah' ? 'active' : "" }}">
                        <i class="nav-icon fas fa-bible"></i>
                        <p>Khotbah</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/khotbah/create" class="nav-link {{ $url == '/khotbah/create' ? 'active' : "" }}">
                        <i class="fas fa-file-medical nav-icon white-text"></i>
                        <p>Add Khotbah</p>
                    </a>
                </li>
                <li class="nav-header">Announcement</li>
                <li class="nav-item">
                    <a href="/announcement" class="nav-link {{ $url == '/announcement' ? 'active' : "" }}">
                        <i class="fas fa-scroll nav-icon"></i>
                        <p>Announcement</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/announcement/create" class="nav-link {{ $url == '/announcement/create' ? 'active' : "" }}">
                        <i class="fas fa-plus-square nav-icon"></i>
                        <p>Add Announcement</p>
                    </a>
                </li>
                <li class="nav-header">Attendance</li>
                <li class="nav-item">
                    <a href="/attendance" class="nav-link {{ $url == '/attendance' ? 'active' : "" }}">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Attendance</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/attendance/history" class="nav-link {{ str_contains($url,'/attendance/history') ? 'active' : "" }}">
                        <i class="fas fa-history nav-icon"></i>
                        <p>History</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>