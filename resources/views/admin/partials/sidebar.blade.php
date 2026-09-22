<!-- Sidebar -->
<div class="d-flex flex-column flex-shrink-0 p-4 sidebar-container">
    <div class="d-flex align-items-center mb-4 me-auto">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-link text-decoration-none">
            SwiftRide
        </a>
    </div>
    
    <hr style="border-color: rgba(255, 255, 255, 0.1); margin-top: 0.5rem; margin-bottom: 1.5rem;">

    <ul class="nav nav-pills flex-column mb-auto sidebar-nav">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.cars.index') }}" class="nav-link @if(request()->routeIs('admin.cars.*')) active @endif">
                <i class="fas fa-car"></i> Cars
            </a>
        </li>
        <li>
            <a href="{{ route('admin.bookings.index') }}" class="nav-link @if(request()->routeIs('admin.bookings.*')) active @endif">
                <i class="fas fa-book"></i> Bookings
            </a>
        </li>
        <li>
            <a href="{{ route('admin.calendar') }}" class="nav-link @if(request()->routeIs('admin.calendar')) active @endif">
                <i class="fas fa-calendar-alt"></i> Calendar
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users') }}" class="nav-link @if(request()->routeIs('admin.users')) active @endif">
                <i class="fas fa-users"></i> Users
            </a>
        </li>
        <li>
            <a href="{{ route('admin.reviews.index') }}" class="nav-link @if(request()->routeIs('admin.reviews.*')) active @endif">
                <i class="fas fa-star"></i> Reviews
            </a>
        </li>
        <li>
            <a href="{{ route('admin.messages') }}" class="nav-link @if(request()->routeIs('admin.messages')) active @endif">
                <i class="fas fa-envelope"></i> Messages
            </a>
        </li>
        <li>
            <a href="{{ route('admin.reports') }}" class="nav-link @if(request()->routeIs('admin.reports')) active @endif">
                <i class="fas fa-chart-bar"></i> Reports
            </a>
        </li>
        <li>
            <a href="{{ route('admin.coupons.index') }}" class="nav-link @if(request()->routeIs('admin.coupons.*')) active @endif">
                <i class="fas fa-tag"></i> Coupons
            </a>
        </li>
        <li>
            <a href="{{ route('admin.settings') }}" class="nav-link @if(request()->routeIs('admin.settings')) active @endif">
                <i class="fas fa-cog"></i> Settings
            </a>
        </li>
    </ul>

    <hr style="border-color: rgba(255, 255, 255, 0.1); margin-top: 1.5rem; margin-bottom: 1rem;">
    
    <div>
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="nav-link text-white-50 text-decoration-none d-flex align-items-center gap-2"
           style="font-size: 0.9rem; font-weight: 600; padding: 0.6rem 1rem; border-radius: 10px; transition: all 0.3s;"
           onmouseover="this.style.color='#ff3333'; this.style.transform='translateX(4px)';"
           onmouseout="this.style.color='rgba(255,255,255,0.5)'; this.style.transform='none';">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>
