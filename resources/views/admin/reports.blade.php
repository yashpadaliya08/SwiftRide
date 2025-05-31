@extends('admin.layout')

@section('title', 'Reports & Analytics')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Reports & Analytics</h2>
        </div>

        <!-- Summary Cards -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Total Users</h6>
                        <h3 class="mb-0">{{ $totalUsers ?? '0' }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Total Rides</h6>
                        <h3 class="mb-0">{{ $totalRides ?? '0' }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Revenue</h6>
                        <h3 class="mb-0">${{ $totalRevenue }}</h3>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-3">
                        <div class="card text-white bg-danger shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title">Active Drivers</h6>
                                <h3 class="mb-0">{{ $activeDrivers ?? '0' }}</h3>
                            </div>
                        </div>
                    </div> -->
        </div>

        <!-- Recent Rides Table -->
        <div class="card mt-5 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Rides</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Fare</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($recentRides as $index => $ride)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $ride->user->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ride->start_datetime)->format('d M Y') }}</td>
                                    <td>${{ number_format($ride->total_price, 2) }}</td>
                                    <td>
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

                                        <span class="badge bg-{{ $badgeColor }}">
                                            {{ ucfirst(str_replace('_', ' ', $ride->status)) }}
                                        </span>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No recent rides found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection