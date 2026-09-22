@extends('admin.layout')

@section('title', 'Manage Bookings')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Booking Management</h2>
            <p class="text-muted mb-0">Track and manage all vehicle reservations.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-white border shadow-sm" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Export / Print
            </button>
            <a href="#" class="btn btn-primary shadow-sm" onclick="alert('Manual booking creation coming soon')">
                <i class="fas fa-plus me-2"></i> New Booking
            </a>
        </div>
    </div>

    <!-- Booking Stats -->
    <div class="row g-4 mb-4 no-print">
        <div class="col-md-3">
             <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body">
                    <h2 class="fw-bold mb-0">{{ $bookings->where('status', 'confirmed')->count() }}</h2>
                    <div class="small opacity-75 text-uppercase fw-bold">Confirmed</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
             <div class="card border-0 shadow-sm bg-warning text-dark h-100">
                <div class="card-body">
                    <h2 class="fw-bold mb-0">{{ $bookings->where('status', 'pending')->count() }}</h2>
                    <div class="small opacity-75 text-uppercase fw-bold">Pending Action</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
             <div class="card border-0 shadow-sm bg-success text-white h-100">
                <div class="card-body">
                    <h2 class="fw-bold mb-0">{{ $bookings->where('status', 'completed')->count() }}</h2>
                    <div class="small opacity-75 text-uppercase fw-bold">Completed</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
             <div class="card border-0 shadow-sm bg-danger text-white h-100">
                <div class="card-body">
                    <h2 class="fw-bold mb-0">{{ $bookings->where('status', 'cancelled')->count() }}</h2>
                    <div class="small opacity-75 text-uppercase fw-bold">Cancelled</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Tabs & Table -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom py-3 no-print">
            <ul class="nav nav-pills card-header-pills" id="bookingTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold" data-filter="all">All Bookings</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold" data-filter="pending">Pending <span class="badge bg-warning text-dark ms-1">{{ $bookings->where('status', 'pending')->count() }}</span></button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold" data-filter="confirmed">Confirmed</button>
                </li>
                 <li class="nav-item">
                    <button class="nav-link fw-bold" data-filter="completed">History</button>
                </li>
            </ul>
        </div>
        
        <!-- Search -->
         <div class="p-3 bg-light border-bottom no-print">
             <div class="input-group">
                 <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                 <input type="text" class="form-control bg-white border-start-0" placeholder="Search by Order ID, User, or Car..." id="bookingSearch">
             </div>
        </div>

        <!-- Print Header Info -->
        <div class="d-none d-print-block p-4 border-bottom mb-4">
            <h2 class="fw-black text-dark mb-1" style="font-weight: 800; letter-spacing: -1px;">SWIFTRIDE<span style="color: #ff3333;">.</span></h2>
            <h4 class="fw-bold text-dark mt-2">Active Booking & Reservation Ledger</h4>
            <p class="text-muted small mb-0">Ledger Generated on: {{ now()->format('F d, Y h:i A') }}</p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Booking Details</th>
                        <th>User Info</th>
                        <th>Dates</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th class="text-end pe-4 no-print">Action</th>
                    </tr>
                </thead>
                <tbody id="bookingsTableBody">
                    @forelse($bookings as $booking)
                        <tr class="booking-row" data-status="{{ $booking->status }}">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                     <div class="bg-light rounded p-2 me-3 border text-center d-print-none" style="width: 50px; height: 50px;">
                                        <i class="fas fa-car-side text-secondary fa-lg mt-1"></i>
                                     </div>
                                     <div>
                                         <div class="fw-bold text-dark">{{ $booking->car->brand ?? 'Unknown' }} {{ $booking->car->model ?? 'Car' }}</div>
                                         <div class="small text-muted">ID: #{{ $booking->id }}</div>
                                     </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $booking->user->name ?? 'Guest User' }}</div>
                                <div class="small text-muted">{{ $booking->user->email ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div class="small">
                                    <span class="text-muted">From:</span> {{ \Carbon\Carbon::parse($booking->start_datetime)->format('M d, Y') }}
                                </div>
                                <div class="small">
                                    <span class="text-muted">To:</span> &nbsp;&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($booking->end_datetime)->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="fw-bold text-dark">₹{{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                @php
                                    $badgeClass = match($booking->status) {
                                        'confirmed' => 'success',
                                        'pending' => 'warning text-dark',
                                        'completed' => 'primary',
                                        'cancelled' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }} px-3 py-2 rounded-pill text-uppercase" style="font-size: 0.7rem;">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4 no-print">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* PREMIUM PRINT STYLES */
    @media print {
        /* Completely hide navigation, controls, headers, filters, sidebars */
        .sidebar-container, 
        .admin-navbar, 
        .btn-group, 
        .btn, 
        #bookingTabs, 
        #bookingSearch, 
        .input-group, 
        .p-3.bg-light.border-bottom, 
        .toast-container,
        #liveToast,
        nav,
        .d-flex.gap-2,
        header,
        .no-print,
        .d-print-none {
            display: none !important;
        }

        /* Reset margins and paddings */
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

        /* Printable list boundaries */
        .card {
            border: none !important;
            box-shadow: none !important;
            background: #fff !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .table-responsive {
            border: none !important;
            overflow: visible !important;
        }

        .table {
            width: 100% !important;
        }

        th {
            border-bottom: 2px solid #334155 !important;
            color: #000 !important;
            font-weight: bold !important;
        }

        td {
            border-bottom: 1px solid #e2e8f0 !important;
        }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('#bookingTabs .nav-link');
        const rows = document.querySelectorAll('.booking-row');
        const searchInput = document.getElementById('bookingSearch');

        // Filter Tabs Logic
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                rows.forEach(row => {
                    const status = row.getAttribute('data-status');
                    if (filter === 'all' ||  
                        (filter === 'completed' && (status === 'completed' || status === 'cancelled')) || 
                        status === filter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        // Search Logic
        searchInput.addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            rows.forEach(function(row) {
                let text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(value) > -1 ? '' : 'none';
            });
        });
    });
</script>
@endsection
