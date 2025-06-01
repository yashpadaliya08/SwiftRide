@extends('admin.layout')

@section('title', 'Reports & Analytics')

@section('content')
<div class="container-fluid py-4 fade-in-up">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold">Reports & Analytics</h2>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-5">
        @php
            $cards = [
                ['title' => 'Total Users', 'count' => $totalUsers ?? '0', 'bg' => 'primary', 'icon' => 'fas fa-users'],
                ['title' => 'Total Rides', 'count' => $totalRides ?? '0', 'bg' => 'success', 'icon' => 'fas fa-car-side'],
                ['title' => 'Revenue', 'count' => '₹' . number_format($totalRevenue ?? 0, 2), 'bg' => 'warning', 'icon' => 'fas fa-dollar-sign'],
                // Uncomment if needed:
                // ['title' => 'Active Drivers', 'count' => $activeDrivers ?? '0', 'bg' => 'danger', 'icon' => 'fas fa-id-badge'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="col-md-4 col-lg-3">
                <div class="card shadow-sm text-white rounded-4 bg-{{ $card['bg'] }} card-animated">
                    <div class="card-body d-flex align-items-center gap-3">
                        <i class="{{ $card['icon'] }} fa-2x opacity-75"></i>
                        <div>
                            <h6 class="card-title text-uppercase mb-1 fw-semibold opacity-75">{{ $card['title'] }}</h6>
                            <h3 class="mb-0 fw-bold">{{ $card['count'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Recent Rides Table -->
    <div class="card shadow-sm rounded-4">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0 fw-semibold">Recent Rides</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light text-uppercase text-muted small">
                        <tr>
                            <th style="width:5%;">#</th>
                            <th style="width:30%;">User</th>
                            <th style="width:25%;">Date</th>
                            <th style="width:20%;">Fare</th>
                            <th style="width:20%;">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($recentRides as $index => $ride)
                            @php
                                $statusColors = [
                                    'pending' => 'secondary',
                                    'confirmed' => 'primary',
                                    'completed' => 'success',
                                    'cancelled' => 'danger',
                                    'in_progress' => 'warning',
                                ];
                                $badgeColor = $statusColors[$ride->status] ?? 'info';
                            @endphp
                            <tr class="table-row-hover">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ride->user->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($ride->start_datetime)->format('d M Y') }}</td>
                                <td>${{ number_format($ride->total_price, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $badgeColor }} text-uppercase fw-semibold px-3 py-2">
                                        {{ str_replace('_', ' ', ucfirst($ride->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No recent rides found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
    /* Fade-in animation */
    .fade-in-up {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.7s ease forwards;
    }
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card animation */
    .card-animated {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-animated:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.12);
        cursor: default;
    }

    /* Table row hover effect */
    .table-row-hover:hover {
        background-color: #f1f9ff;
        transition: background-color 0.25s ease;
        cursor: default;
    }

    /* Badge style improvements */
    .badge {
        font-size: 0.85rem;
        border-radius: 12px;
    }
</style>
@endsection
