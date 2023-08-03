<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ trans('Admin') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ trans('Dashboard') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if (Auth::user()->hasAnyPermission(['read roles', 'read permissions']))
        <!-- Heading -->
        <div class="sidebar-heading">
            {{ trans('Roles & Permissions') }}
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        @can('read roles')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.roles') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ trans('Roles') }}</span></a>
            </li>
        @endcan

        @can('read permissions')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.permissions') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ trans('Permissions') }}</span></a>
            </li>
        @endcan
        <!-- Divider -->
        <hr class="sidebar-divider">
    @endif
    <!-- Nav Item - Utilities Collapse Menu -->
    {{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Utilities</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="utilities-color.html">Colors</a>
            <a class="collapse-item" href="utilities-border.html">Borders</a>
            <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a>
        </div>
    </div>
</li> --}}




    <!-- Nav Item -  -->
    @can('read users')
        <!-- Heading -->
        <div class="sidebar-heading">
            {{ trans('Users') }}
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>{{ trans('Users') }}</span></a>
        </li>
        <hr class="sidebar-divider">
    @endcan


    <li class="nav-item">
        <a class="nav-link"  href="{{ route('get_all_individual_chats') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>{{ trans('Individual Chat') }}</span></a>

    </li>
    <li class="nav-item">
        <a class="nav-link"  href="{{ route('global_chat.view') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>{{ trans('Global Chat') }}</span></a>

    </li>

    <hr class="sidebar-divider">



    <!-- Sidebar Toggler (Sidebar) -->

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
