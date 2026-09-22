@extends('admin.layout')

@section('title', 'Financial Reports')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Financial & Fleet Reports</h2>
            <p class="text-muted mb-0">Deep dive into your revenue and usage analytics.</p>
        </div>
        <div>
            <button class="btn btn-outline-secondary border shadow-sm me-2" onclick="window.print()">
                <i class="fas fa-file-pdf me-2"></i> Download PDF / Print
            </button>
            <button class="btn btn-primary shadow-sm" onclick="alert('Export Excel features are currently offline.')">
                <i class="fas fa-file-excel me-2"></i> Export Excel
            </button>
        </div>
    </div>

    <!-- Print Header Info -->
    <div class="d-none d-print-block p-4 border-bottom mb-4">
        <h2 class="fw-black text-dark mb-1" style="font-weight: 800; letter-spacing: -1px;">SWIFTRIDE<span style="color: #ff3333;">.</span></h2>
        <h4 class="fw-bold text-dark mt-2">Executive Business & Revenue Summary</h4>
        <p class="text-muted small mb-0">Report Generated on: {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <!-- Summary Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-6">
             <div class="card border-0 shadow-sm h-100 py-3 stat-card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 d-print-none" style="width: 50px; height: 50px;">
                        <i class="fas fa-wallet fa-lg"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="text-muted text-uppercase fw-bold mb-1 small" style="font-size: 0.72rem;">Total Revenue</h6>
                        <h4 class="mb-0 fw-bold text-dark text-truncate" title="₹{{ number_format($totalRevenue, 2) }}">
                            ₹{{ number_format($totalRevenue, 2) }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-md-3 col-6">
             <div class="card border-0 shadow-sm h-100 py-3 stat-card">
                <div class="card-body d-flex align-items-center">
                     <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3 d-print-none" style="width: 50px; height: 50px;">
                        <i class="fas fa-calendar-check fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-1 small" style="font-size: 0.72rem;">Completed Rides</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ $totalRides }}</h4>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-md-3 col-6">
             <div class="card border-0 shadow-sm h-100 py-3 stat-card">
                <div class="card-body d-flex align-items-center">
                     <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3 d-print-none" style="width: 50px; height: 50px;">
                        <i class="fas fa-car fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-1 small" style="font-size: 0.72rem;">Fleet Utilization</h6>
                        <h4 class="mb-0 fw-bold text-dark">78%</h4> 
                    </div>
                </div>
            </div>
        </div>
         <div class="col-md-3 col-6">
             <div class="card border-0 shadow-sm h-100 py-3 stat-card">
                <div class="card-body d-flex align-items-center">
                     <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3 d-print-none" style="width: 50px; height: 50px;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-1 small" style="font-size: 0.72rem;">Active Clients</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ $totalUsers }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
     <div class="row g-4 mb-4">
        <div class="col-lg-8" id="revenue-chart-card">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-chart-bar me-2"></i> Monthly Revenue Overview</h6>
                </div>
                <div class="card-body">
                    <canvas id="reportsRevenueChart" style="max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
         <div class="col-lg-4" id="insights-card">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h6 class="mb-0 fw-bold text-info"><i class="fas fa-info-circle me-2"></i> Insight Highlights</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <div class="fw-bold">Top Performing Car</div>
                                <div class="small text-muted">Audi A4 (Sedan)</div>
                            </div>
                            <span class="badge bg-success rounded-pill">₹12,500</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <div class="fw-bold">Peak Booking Day</div>
                                <div class="small text-muted">Saturdays</div>
                            </div>
                            <span class="badge bg-primary rounded-pill">12 Rides</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <div class="fw-bold">Avg. Booking Duration</div>
                                <div class="small text-muted">3.5 Days</div>
                            </div>
                             <span class="text-muted"><i class="fas fa-clock"></i></span>
                        </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <div class="fw-bold">Customer Retention</div>
                                <div class="small text-muted">Returning Users</div>
                            </div>
                            <span class="badge bg-info rounded-pill">45%</span>
                        </li>
                    </ul>
                     <div class="alert alert-light border mt-3 mb-0 small no-print">
                        <i class="fas fa-lightbulb text-warning me-1"></i> <strong>Tip:</strong> Increasing fleet size by 2 SUVs could boost weekend revenue by 15%.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-transparent border-0 py-3">
            <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-history me-2"></i> Recent Ledger Transactions</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                 <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                         <th class="ps-4">Transaction ID</th>
                         <th>User</th>
                         <th>Date</th>
                         <th>Amount</th>
                         <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRides as $ride)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">#TRX-{{ $ride->id }}{{ rand(100,999) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-1 me-2 d-print-none"><i class="fas fa-user text-secondary"></i></div>
                                    {{ $ride->user->name ?? 'Deleted User' }}
                                </div>
                            </td>
                            <td>{{ $ride->created_at->format('M d, Y, h:i A') }}</td>
                            <td class="fw-bold text-dark">₹{{ number_format($ride->total_price, 2) }}</td>
                            <td>
                                <span class="badge bg-success px-3 py-1 rounded-pill">Received</span>
                            </td>
                        </tr>
                    @empty
                         <tr><td colspan="5" class="text-center py-4 text-muted">No transactions recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* PREMIUM PRINT STYLES */
    @media print {
        /* Completely hide navigation, sidebars, buttons, toast widgets, recommendations */
        .sidebar-container, 
        .admin-navbar, 
        .btn, 
        .d-flex.gap-2, 
        .alert,
        #liveToast, 
        .toast-container,
        header,
        nav,
        .no-print {
            display: none !important;
        }

        /* Expand content canvas */
        body, 
        main, 
        .container-fluid, 
        .py-4 {
            background: #fff !important;
            color: #000 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: visible !important;
            height: auto !important;
            min-height: auto !important;
        }

        /* Flex wrap columns side by side on paper */
        .row {
            display: flex !important;
            flex-wrap: wrap !important;
            margin-right: -15px !important;
            margin-left: -15px !important;
        }

        .col-md-3 {
            width: 25% !important;
            flex: 0 0 25% !important;
            max-width: 25% !important;
        }

        .col-lg-8 {
            width: 60% !important;
            flex: 0 0 60% !important;
            max-width: 60% !important;
        }

        .col-lg-4 {
            width: 40% !important;
            flex: 0 0 40% !important;
            max-width: 40% !important;
        }

        .card {
            border: 1px solid #e2e8f0 !important;
            box-shadow: none !important;
            background: #fff !important;
            page-break-inside: avoid;
        }

        .stat-card {
            border: none !important;
            background: #f8fafc !important;
        }

        canvas {
            max-width: 100% !important;
            height: auto !important;
        }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('reportsRevenueChart').getContext('2d');
        
        // Mock Data specifically for reports page (can be dynamic later)
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        const data = [12000, 19000, 15000, 25000, 22000, 30000];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Revenue (₹)',
                    data: data,
                    backgroundColor: '#ff3333',
                    borderRadius: 4,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                         beginAtZero: true,
                         grid: { borderDash: [2, 2] }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection
