<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Auction Management <sup>.</sup></div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    <!-- Nav Item - Pages Collapse Menu -->

    @can('view companies')
    <li class="nav-item {{ request()->is('admin/company*') ? 'active show' : '' }}">
        <a class="nav-link " href="{{route('admin.company.index')}}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Companies</span>
        </a>
    </li>
    @endcan
    @can('view orders')
    <li class="nav-item {{ request()->is('admin/orders*') ? 'active show' : '' }}">
        <a class="nav-link " href="{{route('admin.orders.index')}}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Orders</span>
        </a>
    </li>
    @endcan
    @can('view users')
        <li class="nav-item {{ request()->is('admin/users*') ? 'active show' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseusers"
                aria-expanded="{{ request()->is('admin/users*') ? 'true' : 'false' }}" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>users</span>
            </a>
            <div id="collapseusers" class="collapse {{ request()->is('admin/users*') ? 'show' : '' }}"
                aria-labelledby="headingusers" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Users:</h6>
                    <a class="collapse-item {{ request()->is('admin/users/create') ? 'active ' : '' }}"
                        href="{{ route('admin.users.create') }}">Create user</a>
                    <a class="collapse-item {{ request()->is('admin/users') ? 'active' : '' }}"
                        href="{{ route('admin.users.index') }}">View users</a>
                </div>
            </div>
        </li>
        @endcan
    {{-- permission Tab --}}
    @can('view permission')
        <li
            class="nav-item {{ request()->is('admin/permissions*') || request()->is('admin/roles*') ? 'active show' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsepermission"
                aria-expanded="{{ request()->is('admin/permissions*') || request()->is('admin/roles*') ? 'true' : 'false' }}"
                aria-controls="collapsepermission">
                <i class="fas fa-fw fa-cog"></i>
                <span>Permissions</span>
            </a>
            <div id="collapsepermission"
                class="collapse {{ request()->is('admin/permissions*') || request()->is('admin/roles*') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Permission And Roles:</h6>
                    <a class="collapse-item {{ request()->is('admin/permissions*') ? 'active' : '' }}"
                        href="{{ route('admin.permissions') }}">Permissions</a>
                    <a class="collapse-item {{ request()->is('admin/roles*') ? 'active' : '' }}"
                        href="{{ route('admin.roles.index') }}">Roles</a>
                </div>
            </div>
        </li>
    @endcan
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
