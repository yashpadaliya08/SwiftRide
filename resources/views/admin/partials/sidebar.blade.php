<!-- Sidebar -->
<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 250px; min-height: 100vh;">
    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4 fw-bold">SwiftRide Admin</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white @if(request()->routeIs('admin.dashboard')) active @endif" aria-current="page">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.cars.index') }}" class="nav-link text-white @if(request()->routeIs('admin.cars.*')) active @endif">
                <i class="fas fa-car me-2"></i> Cars
            </a>
        </li>
        <li>
            <a href="{{ route('admin.bookings.index') }}" class="nav-link text-white @if(request()->routeIs('admin.bookings.*')) active @endif">
                <i class="fas fa-book me-2"></i> Bookings
            </a>
        </li>
        <li>
            <a href="{{ route('admin.calendar') }}" class="nav-link text-white @if(request()->routeIs('admin.calendar')) active @endif">
                <i class="fas fa-calendar-alt me-2"></i> Calendar
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users') }}" class="nav-link text-white @if(request()->routeIs('admin.users')) active @endif">
                <i class="fas fa-users me-2"></i> Users
            </a>
        </li>
        <li>
            <a href="{{ route('admin.reviews.index') }}" class="nav-link text-white @if(request()->routeIs('admin.reviews.*')) active @endif">
                <i class="fas fa-star me-2"></i> Reviews
            </a>
        </li>
        <li>
            <a href="{{ route('admin.messages') }}" class="nav-link text-white @if(request()->routeIs('admin.messages')) active @endif">
                <i class="fas fa-envelope me-2"></i> Messages
            </a>
        </li>
        <li>
            <a href="{{ route('admin.reports') }}" class="nav-link text-white @if(request()->routeIs('admin.reports')) active @endif">
                <i class="fas fa-chart-bar me-2"></i> Reports
            </a>
        </li>
        <li>
            <a href="{{ route('admin.coupons.index') }}" class="nav-link text-white @if(request()->routeIs('admin.coupons.*')) active @endif">
                <i class="fas fa-tag me-2"></i> Coupons
            </a>
        </li>
        <li>
            <a href="{{ route('admin.settings') }}" class="nav-link text-white @if(request()->routeIs('admin.settings')) active @endif">
                <i class="fas fa-cog me-2"></i> Settings
            </a>
        </li>
    </ul>
    <hr>
    <div>
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="d-flex align-items-center text-white text-decoration-none">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>
