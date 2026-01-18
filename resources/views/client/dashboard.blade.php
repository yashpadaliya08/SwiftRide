@extends('client.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
<div class="row g-4">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Welcome Header -->
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
            <div>
                <h2 class="fw-bold mb-1">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
                <p class="text-muted mb-0">Here's what's happening with your rides.</p>
            </div>
            <a href="{{ route('booking.selectCriteria') }}" class="btn btn-theme px-4 py-2 rounded-pill shadow-sm">
                <i class="fas fa-plus me-2"></i>New Booking
            </a>
        </div>

        <!-- Quick Stats -->
        <div class="row g-3 mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 py-2">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-route fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold mb-1 small">Total Trips</h6>
                            <h4 class="mb-0 fw-bold">{{ $bookings->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 py-2">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-wallet fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold mb-1 small">Total Spent</h6>
                            <h4 class="mb-0 fw-bold">₹{{ number_format($bookings->sum('total_price'), 0) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 py-2">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-star fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold mb-1 small">Loyalty Points</h6>
                            <h4 class="mb-0 fw-bold">{{ number_format(Auth::user()->loyalty_points) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Trip Section -->
        <h5 class="fw-bold mb-3" data-aos="fade-right">Current Status</h5>
        @php
            $activeBooking = $bookings->where('status', 'confirmed')->where('start_datetime', '<=', now())->where('end_datetime', '>=', now())->first();
        @endphp

        @if($activeBooking)
            <div class="card border-0 shadow mb-5 overflow-hidden" data-aos="zoom-in">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-8 p-4">
                            <div class="badge bg-success mb-2 px-3 py-2 rounded-pill">Active Trip</div>
                            <h3 class="fw-bold mb-1">{{ $activeBooking->car->brand }} {{ $activeBooking->car->model }}</h3>
                            <div class="text-muted small mb-3">{{ $activeBooking->car->type }} • {{ $activeBooking->car->transmission }}</div>
                            
                            <div class="d-flex align-items-center mb-4">
                                <div>
                                    <small class="text-muted fw-bold d-block text-uppercase">Pick-up</small>
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($activeBooking->start_datetime)->format('M d, h:i A') }}</span>
                                </div>
                                <div class="px-3 text-muted"><i class="fas fa-arrow-right"></i></div>
                                <div>
                                    <small class="text-muted fw-bold d-block text-uppercase">Drop-off</small>
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($activeBooking->end_datetime)->format('M d, h:i A') }}</span>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3">Extend Trip</button>
                                <button class="btn btn-outline-dark btn-sm rounded-pill px-3">Report Issue</button>
                            </div>
                        </div>
                        <div class="col-md-4 bg-light d-flex align-items-center justify-content-center position-relative">
                             <!-- Placeholder for car image -->
                            <i class="fas fa-car fa-5x text-secondary opacity-25"></i>
                            @if($activeBooking->car->image)
                                <img src="{{ asset('storage/' . $activeBooking->car->image) }}" class="position-absolute w-100 h-100 object-fit-cover" alt="Car">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card border-0 shadow-sm mb-5 bg-light" data-aos="fade-up">
                <div class="card-body text-center py-5">
                    <div class="mb-3 text-muted opacity-50"><i class="fas fa-car-side fa-3x"></i></div>
                    <h5 class="fw-bold">No Active Trips</h5>
                    <p class="text-muted">You don't have any ongoing trips at the moment.</p>
                    <a href="{{ route('booking.selectCriteria') }}" class="btn btn-primary px-4 rounded-pill">Book a Car Now</a>
                </div>
            </div>
        @endif

        <!-- Recent History -->
        <div class="d-flex justify-content-between align-items-center mb-3">
             <h5 class="fw-bold mb-0">Recent Activity</h5>
             <a href="{{ route('booking.myBookings') }}" class="text-decoration-none small fw-bold">View All</a>
        </div>
        
        <div class="card border-0 shadow-sm rounded-4" data-aos="fade-up" data-aos-delay="200">
            <div class="list-group list-group-flush rounded-4">
                @forelse($bookings->take(3) as $trip)
                    <div class="list-group-item p-3 border-bottom-0 d-flex align-items-center justify-content-between">
                         <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3 text-secondary"><i class="fas fa-history"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $trip->car->brand }} {{ $trip->car->model }}</h6>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($trip->start_datetime)->format('M d, Y') }}</small>
                            </div>
                         </div>
                         <div class="text-end">
                             <span class="badge bg-{{ match($trip->status) { 'confirmed' => 'success', 'pending' => 'warning', 'cancelled' => 'danger', default => 'secondary' } }} rounded-pill px-3">{{ ucfirst($trip->status) }}</span>
                             <div class="small fw-bold mt-1">₹{{ number_format($trip->total_price) }}</div>
                         </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">No recent activity.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card border-0 shadow-sm mb-4" data-aos="fade-left">
            <div class="card-body text-center p-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 fs-3 fw-bold" style="width: 80px; height: 80px;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                    <h5 class="fw-bold mb-0">{{ Auth::user()->name }}</h5>
                    <div class="mb-3">
                        <span class="badge {{ Auth::user()->membership_tier == 'Platinum' ? 'bg-info' : (Auth::user()->membership_tier == 'Gold' ? 'bg-warning text-dark' : 'bg-secondary') }} rounded-pill px-3">
                            <i class="fas fa-crown me-1"></i> {{ Auth::user()->membership_tier }} Member
                        </span>
                    </div>
                    <p class="text-muted small mb-4">{{ Auth::user()->email }}</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm rounded-pill">Edit Profile</a>
                </div>
            </div>
        </div>

        <!-- Promo / Info Card -->
        <div class="card border-0 shadow-sm bg-dark text-white overflow-hidden position-relative" data-aos="fade-left" data-aos-delay="100">
            <div class="card-body p-4 position-relative" style="z-index: 2;">
                <h5 class="fw-bold mb-2">Premium Member 🌟</h5>
                <p class="small opacity-75 mb-3">Unlock exclusive deals and priority support by upgrading your tier.</p>
                <button class="btn btn-light btn-sm rounded-pill fw-bold text-dark">View Benefits</button>
            </div>
            <!-- decorative circle -->
            <div class="position-absolute border border-white opacity-10 rounded-circle" style="width: 150px; height: 150px; top: -50px; right: -50px; z-index: 1;"></div>
        </div>
    </div>
    </div>
</div>

<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>
@endsection
