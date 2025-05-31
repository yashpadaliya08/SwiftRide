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
                                <h4 class="mb-0 fw-bold">{{ $bookingCount  }}</h4>
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
                                <h4 class="mb-0 fw-bold">{{ $totalRevenue }}</h4>
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
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-theme">View All</a>
            </div>
            <div class="card-body p-0">
                @if ($recentBookings->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Car</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Status</th>
                                    <th>Fare</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentBookings as $index => $booking)
                                    @php
                                        $statusColors = [
                                            'pending' => 'secondary',
                                            'confirmed' => 'primary',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                            'in_progress' => 'warning',
                                        ];
                                        $badgeColor = $statusColors[$booking->status] ?? 'info';
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                        <td>{{ $booking->car->name ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M Y, h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->end_datetime)->format('d M Y, h:i A') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $badgeColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($booking->total_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-3">
                        <p class="text-muted mb-0">No recent bookings to show yet.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection