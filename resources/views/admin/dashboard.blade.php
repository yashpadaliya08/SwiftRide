@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4 animate__animated animate__fadeIn">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-black text-dark" style="font-weight: 800; letter-spacing: -0.5px;">Dashboard Overview</h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem; font-weight: 500;">Welcome back! Here's a live pulse of SwiftRide today.</p>
        </div>
        <span class="badge bg-white text-dark shadow-sm border px-3 py-2.5 fs-6 d-flex align-items-center gap-2" style="border-radius: 12px; font-weight: 600; border-color: rgba(0,0,0,0.05) !important;">
            <i class="bi bi-calendar-event text-danger"></i> {{ now()->format('F d, Y') }}
        </span>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Revenue Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="border-radius: 18px; border-top: 4px solid #ff3333 !important; transition: all 0.3s ease;">
                <div style="position: absolute; top: -15px; right: -15px; width: 90px; height: 90px; background: radial-gradient(circle, rgba(255, 51, 51, 0.08) 0%, rgba(255, 51, 51, 0) 70%); border-radius: 50%;"></div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; background: linear-gradient(135deg, #ff3333, #c21a1a); box-shadow: 0 4px 15px rgba(255, 51, 51, 0.25); color: #fff;">
                                <i class="fas fa-wallet fa-lg"></i>
                            </div>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.6px; font-weight: 700;">Total Revenue</h6>
                            <h3 class="mb-0 fw-black text-dark text-truncate" style="font-weight: 800; font-size: 1.55rem;" title="₹{{ number_format($totalRevenue, 2) }}">
                                ₹{{ number_format($totalRevenue, 2) }}
                            </h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem; border-color: rgba(0,0,0,0.04) !important;">
                        <span class="fw-semibold text-success"><i class="fas fa-arrow-trend-up me-1"></i> +12.4%</span>
                        <span class="opacity-75">vs last month</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="border-radius: 18px; border-top: 4px solid #3399ff !important; transition: all 0.3s ease;">
                <div style="position: absolute; top: -15px; right: -15px; width: 90px; height: 90px; background: radial-gradient(circle, rgba(51, 153, 255, 0.08) 0%, rgba(51, 153, 255, 0) 70%); border-radius: 50%;"></div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; background: linear-gradient(135deg, #3399ff, #0056b3); box-shadow: 0 4px 15px rgba(51, 153, 255, 0.25); color: #fff;">
                                <i class="fas fa-calendar-check fa-lg"></i>
                            </div>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.6px; font-weight: 700;">Total Bookings</h6>
                            <h3 class="mb-0 fw-black text-dark text-truncate" style="font-weight: 800; font-size: 1.55rem;">
                                {{ $bookingCount }}
                            </h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem; border-color: rgba(0,0,0,0.04) !important;">
                        <span class="fw-semibold text-success"><i class="fas fa-arrow-trend-up me-1"></i> +8.2%</span>
                        <span class="opacity-75">Booking rate</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fleet Vehicles Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="border-radius: 18px; border-top: 4px solid #f59e0b !important; transition: all 0.3s ease;">
                <div style="position: absolute; top: -15px; right: -15px; width: 90px; height: 90px; background: radial-gradient(circle, rgba(245, 158, 11, 0.08) 0%, rgba(245, 158, 11, 0) 70%); border-radius: 50%;"></div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.25); color: #fff;">
                                <i class="fas fa-car fa-lg"></i>
                            </div>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.6px; font-weight: 700;">Fleet Vehicles</h6>
                            <h3 class="mb-0 fw-black text-dark text-truncate" style="font-weight: 800; font-size: 1.55rem;">
                                {{ $carCount }}
                            </h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem; border-color: rgba(0,0,0,0.04) !important;">
                        <span class="fw-semibold text-primary"><i class="fas fa-circle-check me-1"></i> Active Status</span>
                        <span class="opacity-75">94.5% Ready</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="border-radius: 18px; border-top: 4px solid #10b981 !important; transition: all 0.3s ease;">
                <div style="position: absolute; top: -15px; right: -15px; width: 90px; height: 90px; background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, rgba(16, 185, 129, 0) 70%); border-radius: 50%;"></div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25); color: #fff;">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.6px; font-weight: 700;">Active Users</h6>
                            <h3 class="mb-0 fw-black text-dark text-truncate" style="font-weight: 800; font-size: 1.55rem;">
                                {{ $userCount }}
                            </h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem; border-color: rgba(0,0,0,0.04) !important;">
                        <span class="fw-semibold text-success"><i class="fas fa-arrow-trend-up me-1"></i> +5.6%</span>
                        <span class="opacity-75">Customer growth</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Sales Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 18px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center" style="font-weight: 700; letter-spacing: -0.3px;">
                            <span class="rounded-circle bg-danger me-2 shadow-sm" style="width: 8px; height: 8px; box-shadow: var(--primary-glow); display: inline-block;"></span>
                            Revenue Analytics
                        </h5>
                        <small class="text-muted">Monthly financial earnings review</small>
                    </div>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <div class="position-relative" style="height: 300px;">
                        <canvas id="revenueChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Car Types Chart -->
        <div class="col-lg-4">
             <div class="card border-0 shadow-sm h-100" style="border-radius: 18px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center" style="font-weight: 700; letter-spacing: -0.3px;">
                            <span class="rounded-circle bg-primary me-2 shadow-sm" style="width: 8px; height: 8px; box-shadow: var(--accent-glow); display: inline-block;"></span>
                            Fleet Distribution
                        </h5>
                        <small class="text-muted">Popularity by vehicle category</small>
                    </div>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center px-4 pb-4 pt-2">
                    <div class="position-relative d-flex justify-content-center align-items-center my-3" style="width: 170px; height: 170px;">
                        <canvas id="carTypeChart" style="width: 170px; height: 170px;"></canvas>
                        <div class="position-absolute top-50 start-50 translate-middle d-flex flex-column align-items-center justify-content-center text-center" style="pointer-events: none; z-index: 10;">
                            <span class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.8px; white-space: nowrap;">Total Cars</span>
                            <h3 class="mb-0 fw-black text-dark" style="font-weight: 800; font-size: 1.6rem; line-height: 1.1;">{{ $carCount }}</h3>
                        </div>
                    </div>
                    <!-- Legend with category counts -->
                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-2 px-2" style="font-size: 0.75rem; font-weight: 600; color: #64748b;">
                        @php
                            $palette = ['#ff3333', '#3399ff', '#f59e0b', '#10b981', '#8b5cf6', '#ec4899'];
                        @endphp
                        @foreach($carTypes as $idx => $type)
                            <span class="d-inline-flex align-items-center gap-1 px-2.5 py-1 bg-light rounded-pill border" style="font-size: 0.72rem;">
                                <span class="rounded-circle me-1" style="width: 8px; height: 8px; background-color: {{ $palette[$idx % count($palette)] }}; display: inline-block;"></span>
                                {{ $type }} <span class="text-dark fw-bold">({{ $carTypeCounts[$idx] ?? 0 }})</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="card shadow-sm border-0" style="border-radius: 18px; overflow: hidden;">
        <div class="card-header bg-transparent border-0 py-4 px-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark d-flex align-items-center" style="font-weight: 700; letter-spacing: -0.3px;">
                    <span class="rounded-circle bg-warning me-2 shadow-sm" style="width: 8px; height: 8px; box-shadow: 0 0 10px rgba(245, 158, 11, 0.4); display: inline-block;"></span>
                    Recent Activity Logs
                </h5>
                <small class="text-muted">Real-time listing of customer bookings</small>
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-light border text-muted rounded-pill px-4 py-2" style="font-size: 0.82rem; font-weight: 600; transition: all 0.2s;">
                View All Activity
            </a>
        </div>
        <div class="table-responsive border-0 px-4 pb-4">
            <table class="table align-middle table-hover mb-0" style="border: none !important;">
                <thead>
                    <tr style="border-bottom: 2px solid #f1f5f9 !important;">
                        <th class="ps-3 border-0 py-3" style="font-size: 0.72rem; color: #64748b; font-weight: 700;">Customer</th>
                        <th class="border-0 py-3" style="font-size: 0.72rem; color: #64748b; font-weight: 700;">Vehicle Spec</th>
                        <th class="border-0 py-3" style="font-size: 0.72rem; color: #64748b; font-weight: 700;">Booking Window</th>
                        <th class="border-0 py-3" style="font-size: 0.72rem; color: #64748b; font-weight: 700;">Total Fare</th>
                        <th class="border-0 py-3" style="font-size: 0.72rem; color: #64748b; font-weight: 700;">Status</th>
                        <th class="text-end pe-3 border-0 py-3" style="font-size: 0.72rem; color: #64748b; font-weight: 700;">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;">
                            <td class="ps-3 py-3.5">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle d-flex align-items-center justify-content-center rounded-circle me-3 text-white fw-bold shadow-sm" style="width: 40px; height: 40px; background: linear-gradient(135deg, #ff3333, #3399ff); font-size: 0.95rem; font-family: 'Outfit'; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.06);">
                                        {{ strtoupper(substr($booking->user->name ?? 'G', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.92rem;">{{ $booking->user->name ?? 'Guest' }}</div>
                                        <div class="small text-muted" style="font-size: 0.75rem; font-weight: 500;"><i class="far fa-clock me-1"></i> {{ $booking->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5">
                                <span class="badge bg-light text-dark px-2.5 py-1.5 shadow-sm" style="font-weight: 600; font-size: 0.8rem; background-color: rgba(255, 51, 51, 0.05) !important; color: #ff3333 !important; border-radius: 8px;">
                                    {{ $booking->car->brand ?? 'Unknown' }}
                                </span>
                                <small class="text-muted d-block mt-1" style="font-size: 0.75rem; font-weight: 500;">{{ $booking->car->model ?? '' }}</small>
                            </td>
                            <td class="py-3.5">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-secondary border px-2 py-1.5" style="font-size: 0.75rem; font-weight: 550; background: #f8fafc; border-radius: 8px;">
                                        <i class="far fa-calendar text-danger me-1"></i> {{ $booking->start_datetime->format('M d') }}
                                    </span>
                                    <i class="fas fa-arrow-right text-muted opacity-50" style="font-size: 0.7rem;"></i>
                                    <span class="badge bg-light text-secondary border px-2 py-1.5" style="font-size: 0.75rem; font-weight: 550; background: #f8fafc; border-radius: 8px;">
                                        <i class="far fa-calendar text-primary me-1"></i> {{ $booking->end_datetime->format('M d') }}
                                    </span>
                                </div>
                            </td>
                            <td class="fw-bold py-3.5 text-dark" style="font-size: 0.95rem;">₹{{ number_format($booking->total_price, 2) }}</td>
                            <td class="py-3.5">
                                @php
                                    $statusLabel = ucfirst($booking->status);
                                    $statusStyle = match($booking->status) {
                                        'confirmed', 'completed' => 'background-color: rgba(16, 185, 129, 0.08) !important; color: #10b981 !important; border: 1px solid rgba(16, 185, 129, 0.15) !important;',
                                        'pending' => 'background-color: rgba(245, 158, 11, 0.08) !important; color: #d97706 !important; border: 1px solid rgba(245, 158, 11, 0.15) !important;',
                                        'cancelled' => 'background-color: rgba(239, 68, 68, 0.08) !important; color: #ef4444 !important; border: 1px solid rgba(239, 68, 68, 0.15) !important;',
                                        default => 'background-color: rgba(100, 116, 139, 0.08) !important; color: #64748b !important; border: 1px solid rgba(100, 116, 139, 0.15) !important;'
                                    };
                                    $statusIcon = match($booking->status) {
                                        'confirmed', 'completed' => 'fa-check-circle',
                                        'pending' => 'fa-clock',
                                        'cancelled' => 'fa-times-circle',
                                        default => 'fa-question-circle'
                                    };
                                @endphp
                                <span class="badge px-3 py-2 rounded-pill shadow-sm" style="{{ $statusStyle }} font-weight: 600; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fas {{ $statusIcon }}"></i> {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="text-end pe-3 py-3.5">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 34px; height: 34px; background: #fff; border: 1px solid rgba(0,0,0,0.06); transition: all 0.2s;" onmouseover="this.style.color='#ff3333'; this.style.borderColor='rgba(255, 51, 51, 0.25)'; this.style.transform='scale(1.15)';" onmouseout="this.style.color='#64748b'; this.style.borderColor='rgba(0,0,0,0.06)'; this.style.transform='none';">
                                    <i class="fas fa-eye text-muted" style="font-size: 0.8rem; transition: color 0.2s;"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No recent bookings recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('script')
<!-- Load Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing Dashboard Charts with Electric Crimson & Sapphire theme...');

        // Dynamic JSON Payload
        const revenueLabels = {!! json_encode($months) !!};
        const revenueData = {!! json_encode($revenueData) !!};
        const carLabels = {!! json_encode($carTypes) !!};
        const carData = {!! json_encode($carTypeCounts) !!};

        // 1. Revenue Chart
        const revenueChartCanvas = document.getElementById('revenueChart');
        if (revenueChartCanvas) {
            const ctx = revenueChartCanvas.getContext('2d');
            
            // Create rich glow gradient under the line
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(255, 51, 51, 0.24)');
            gradient.addColorStop(0.5, 'rgba(255, 51, 51, 0.08)');
            gradient.addColorStop(1, 'rgba(255, 51, 51, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: revenueLabels,
                    datasets: [{
                        label: 'Revenue (₹)',
                        data: revenueData,
                        borderColor: '#ff3333',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        tension: 0.38,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#ff3333',
                        pointBorderWidth: 2.5,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointHoverBackgroundColor: '#ff3333',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#090d16',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            titleFont: { family: 'Outfit', size: 13, weight: 'bold' },
                            bodyFont: { family: 'Outfit', size: 12 },
                            padding: 12,
                            cornerRadius: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Revenue: ₹' + Number(context.raw).toLocaleString('en-IN', { minimumFractionDigits: 2 });
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [4, 4], color: '#f1f5f9' },
                            ticks: {
                                font: { family: 'Outfit', size: 11, weight: '550' },
                                color: '#64748b',
                                callback: function(value) { return '₹' + value.toLocaleString('en-IN'); }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Outfit', size: 11, weight: '550' },
                                color: '#64748b'
                            }
                        }
                    }
                }
            });
        }

        // 2. Car Type Chart
        const carChartCanvas = document.getElementById('carTypeChart');
        if (carChartCanvas) {
            let finalCarLabels = carLabels;
            let finalCarData = carData;
            
            if (finalCarLabels.length === 0) {
                 finalCarLabels = ['No Data'];
                 finalCarData = [1];
            }

            new Chart(carChartCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: finalCarLabels,
                    datasets: [{
                        data: finalCarData,
                        backgroundColor: [
                            '#ff3333', // Crimson
                            '#3399ff', // Sapphire Blue
                            '#f59e0b', // Amber
                            '#10b981', // Emerald Green
                            '#8b5cf6', // Violet
                            '#ec4899'  // Pink
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#090d16',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            titleFont: { family: 'Outfit', size: 13, weight: 'bold' },
                            bodyFont: { family: 'Outfit', size: 12 },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.raw + ' vehicles';
                                }
                            }
                        }
                    },
                    cutout: '72%'
                }
            });
        }
    });
</script>
@endpush

@endsection
