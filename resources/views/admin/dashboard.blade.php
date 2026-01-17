@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Dashboard Overview</h2>
            <p class="text-muted mb-0">Welcome back! Here's what's happening today.</p>
        </div>
        <span class="badge bg-light text-dark shadow-sm border px-3 py-2 fs-6">
            <i class="bi bi-calendar-event me-2"></i> {{ now()->format('F d, Y') }}
        </span>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Revenue -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 py-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fas fa-dollar-sign fa-lg"></i>
                            </div>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.75rem;">Total Revenue</h6>
                            <h4 class="mb-0 fw-bold text-dark text-truncate" title="₹{{ number_format($totalRevenue, 2) }}">
                                ₹{{ number_format($totalRevenue, 2) }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-calendar-check fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold mb-1 small">Total Bookings</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ $bookingCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cars -->
        <div class="col-xl-3 col-md-6">
             <div class="card border-0 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                         <div class="flex-shrink-0 me-3">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-car fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold mb-1 small">Fleet Vehicles</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ $carCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold mb-1 small">Active Users</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ $userCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Sales Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-chart-line me-2 text-primary"></i> Monthly Revenue</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Car Types Chart -->
        <div class="col-lg-4">
             <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2 text-info"></i> Fleet Popularity</h6>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <canvas id="carTypeChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold"><i class="fas fa-history me-2 text-warning"></i> Recent Activity</h6>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">User</th>
                        <th>Vehicle</th>
                        <th>Dates</th>
                        <th>Fare</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-2 text-secondary">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $booking->user->name ?? 'Guest' }}</div>
                                        <div class="small text-muted">{{ $booking->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $booking->car->brand ?? 'Unknown' }}</span>
                                <small class="text-muted d-block mt-1">{{ $booking->car->model ?? '' }}</small>
                            </td>
                            <td>
                                <div class="small">
                                    <i class="fas fa-arrow-up text-success me-1"></i> {{ $booking->start_datetime->format('M d') }}
                                </div>
                                <div class="small">
                                    <i class="fas fa-arrow-down text-danger me-1"></i> {{ $booking->end_datetime->format('M d') }}
                                </div>
                            </td>
                            <td class="fw-bold">₹{{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                @php
                                    $badgeClass = match($booking->status) {
                                        'confirmed', 'completed' => 'success',
                                        'pending' => 'warning text-dark',
                                        'cancelled' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }} px-3 py-2 rounded-pill">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-light text-muted">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No recent activity found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
<!-- Load Chart.js from a specific version to ensure compatibility -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing Dashboard Charts...');

        // Debug Data
        const revenueLabels = {!! json_encode($months) !!};
        const revenueData = {!! json_encode($revenueData) !!};
        const carLabels = {!! json_encode($carTypes) !!};
        const carData = {!! json_encode($carTypeCounts) !!};

        console.log('Revenue Data:', revenueData);
        console.log('Car Data:', carData);

        // 1. Revenue Chart
        const revenueChartCanvas = document.getElementById('revenueChart');
        if (revenueChartCanvas) {
            new Chart(revenueChartCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: revenueLabels,
                    datasets: [{
                        label: 'Revenue (₹)',
                        data: revenueData,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#0d6efd',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { param: 'index', intersect: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4], color: '#f0f0f0' },
                            ticks: { callback: function(value) { return '₹' + value; } }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 2. Car Type Chart
        const carChartCanvas = document.getElementById('carTypeChart');
        if (carChartCanvas) {
            // Check if we have data, otherwise show dummy data
            let finalCarLabels = carLabels;
            let finalCarData = carData;
            
            if (finalCarLabels.length === 0) {
                 finalCarLabels = ['No Data'];
                 finalCarData = [1]; // dummy value to show grey circle
            }

            new Chart(carChartCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: finalCarLabels,
                    datasets: [{
                        data: finalCarData,
                        backgroundColor: [
                            '#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d', '#0dcaf0'
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, padding: 20 }
                        }
                    },
                    cutout: '75%'
                }
            });
        }
    });
</script>
@endsection

@endsection
