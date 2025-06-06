@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .card-hover:hover {
        transform: translateY(-4px);
        transition: 0.3s ease-in-out;
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
    }

    .fade-in {
        animation: fadeIn 0.6s ease-in-out both;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .badge-custom {
        padding: 0.35em 0.65em;
        font-size: 0.75rem;
        border-radius: 0.25rem;
    }

    .table-hover tbody tr:hover {
        background-color: #f9f9f9;
    }

    .bg-theme {
        background-color: #007bff !important;
        color: white;
    }
    
</style>

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Dashboard Overview</h2>
        <span class="badge bg-theme text-white fs-6">{{ now()->format('F d, Y') }}</span>
    </div>

    <div class="row g-4">
        <!-- Total Cards -->
        @php
            $stats = [
                ['icon' => 'bi-car-front-fill', 'label' => 'Total Cars', 'count' => $carCount, 'bg' => 'primary'],
                ['icon' => 'bi-calendar-check-fill', 'label' => 'Total Bookings', 'count' => $bookingCount, 'bg' => 'success'],
                ['icon' => 'bi-people-fill', 'label' => 'Total Users', 'count' => $userCount, 'bg' => 'warning'],
                ['icon' => 'bi-currency-dollar', 'label' => 'Revenue', 'count' => '₹' . number_format($totalRevenue, 2), 'bg' => 'danger'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-{{ $stat['bg'] }} text-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi {{ $stat['icon'] }} fs-2 me-3"></i>
                        <div>
                            <h6 class="mb-1 text-uppercase">{{ $stat['label'] }}</h6>
                            <h4 class="mb-0 fw-bold">{{ $stat['count'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Recent Bookings -->
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
                                    <td>₹{{ number_format($booking->total_price, 2) }}</td>
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

