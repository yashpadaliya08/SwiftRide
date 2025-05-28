@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Dashboard Overview</h2>
        <span class="badge bg-theme text-white">{{ now()->format('F d, Y') }}</span>
    </div>

    <div class="row g-4">
        <!-- Total Cars -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary text-white h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-car-front-fill fs-2 me-3"></i>
                        <div>
                            <h6 class="mb-1 text-uppercase">Total Cars</h6>
                            <h4 class="mb-0 fw-bold">{{ $carCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success text-white h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-calendar-check-fill fs-2 me-3"></i>
                        <div>
                            <h6 class="mb-1 text-uppercase">Total Bookings</h6>
                            <h4 class="mb-0 fw-bold">{{$bookingCount  }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-warning text-white h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-people-fill fs-2 me-3"></i>
                        <div>
                            <h6 class="mb-1 text-uppercase">Total Users</h6>
                            <h4 class="mb-0 fw-bold">{{ $userCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-danger text-white h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-currency-dollar fs-2 me-3"></i>
                        <div>
                            <h6 class="mb-1 text-uppercase">Revenue</h6>
                            <h4 class="mb-0 fw-bold">$5,420</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Section -->
    <div class="card mt-5 shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recent Bookings</h5>
            <a href="#" class="btn btn-sm btn-theme">View All</a>
        </div>
        <div class="card-body">
            <p class="text-muted mb-0">No recent bookings to show yet.</p>
        </div>
    </div>
</div>
@endsection
