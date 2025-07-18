<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">KATALIS</div>
    </a>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nav Item - Statistics -->
    <li class="nav-item {{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.statistics') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Statistics</span>
        </a>
    </li>

    <!-- Nav Item - Components -->
    <li class="nav-item {{ request()->routeIs('admin.components') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.components') }}">
            <i class="fas fa-fw fa-tools"></i>
            <span>Components</span>
        </a>
    </li>

    <!-- Nav Item - History -->
    <li class="nav-item {{ request()->routeIs('admin.history') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.history') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>History</span>
        </a>
    </li>

    <!-- Nav Item - Notifications -->
    <li class="nav-item {{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.notifications') }}">
            <i class="fas fa-fw fa-bell"></i>
            <span>Notifications</span>
        </a>
    </li>

    <!-- Nav Item - Recommender -->
    <li class="nav-item {{ request()->routeIs('admin.recommender') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.recommender') }}">
            <i class="fas fa-fw fa-brain"></i>
            <span>Recommender</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

</ul>
<style>
    .nav-item.active {
        background-color: #fec015 !important;
        color: white;
    }

    .nav-item.active .nav-link {
        color: white !important;
    }
</style>
