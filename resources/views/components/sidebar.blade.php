<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('home')}}">Palembang Stay</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('home') }}">General Dashboard</a>
                    </li>
                </ul>
            </li>

            @can('view permissions')
                <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Roles and Permission aplikasi</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('permissions.index')}}">Permission</a>
                            <a class="nav-link" href="{{ route('roles.index')}}">Roles</a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('view users')
                <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Users</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('users.index')}}">All Users</a>
                            <a class="nav-link" href="{{ route('users.create')}}">Create Users</a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('view company')
                <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Company</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('companies.show', 1)}}">Profil Perusahaan</a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('view attendances')
                <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Attendance</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('attendances.index', 1)}}">Attendance</a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('view izin')
                <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Izin atau cuti</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('permissions-absensi.index', 1)}}">Izin atau cuti</a>
                        </li>

                    </ul>
                </li>
            @endcan



    </aside>
</div>
