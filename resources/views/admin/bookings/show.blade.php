@extends('admin.layout')

@section('title', 'Booking Details')

@section('content')
<div class="container-fluid py-4 fade-in-up">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Booking #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h2>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-{{ match($booking->status) { 'confirmed' => 'success', 'pending' => 'warning text-dark', 'cancelled' => 'danger', default => 'secondary' } }} px-3 py-2 rounded-pill text-uppercase">
                    {{ $booking->status }}
                </span>
                <span class="text-muted small"><i class="far fa-clock me-1"></i> Created {{ $booking->created_at->format('M d, Y h:i A') }}</span>
            </div>
        </div>
        <div class="btn-group shadow-sm">
            <button class="btn btn-white border fw-bold" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Print
            </button>
            @if($booking->status === 'pending')
                <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-success fw-bold text-white">
                        <i class="fas fa-check me-2"></i> Confirm Booking
                    </button>
                </form>
            @endif
             @if($booking->status !== 'cancelled' && $booking->status !== 'completed')
                <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this booking? If payment was received, a refund entry will be generated.');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger fw-bold text-white">
                        <i class="fas fa-ban me-2"></i> Cancel
                    </button>
                </form>
             @endif
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Details (Invoice Style) -->
        <div class="col-lg-8" id="printable-admin-invoice">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden invoice-card bg-white" style="border: 1px solid rgba(0, 0, 0, 0.05) !important;">
                <div style="height: 6px; background: linear-gradient(90deg, #ff3333, #3399ff);"></div>
                <div class="card-body p-5">
                    
                    <!-- Invoice Header (Shown on Print) -->
                    <div class="d-flex justify-content-between align-items-start mb-5 pb-4 border-bottom flex-wrap gap-3">
                        <div>
                            <h2 class="fw-black text-dark mb-1" style="font-weight: 800; letter-spacing: -1px;">SWIFTRIDE<span style="color: #ff3333;">.</span></h2>
                            <p class="text-muted small mb-0">Official Booking & Transaction Invoice</p>
                        </div>
                        <div class="text-md-end">
                            <h5 class="fw-bold mb-1 text-dark text-uppercase tracking-wider">Booking Invoice</h5>
                            <p class="text-muted small mb-1">Invoice Reference: <span class="fw-bold text-dark">SR-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span></p>
                            <p class="text-muted small mb-0">Date Generated: {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Client & Car Info -->
                    <div class="row mb-5">
                        <div class="col-md-6 border-end">
                            <h6 class="text-uppercase text-muted fw-bold small mb-3" style="font-size: 0.68rem; letter-spacing: 0.8px;">Customer Details</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-circle d-flex align-items-center justify-content-center rounded-circle me-3 text-white fw-bold shadow-sm" style="width: 48px; height: 48px; background: linear-gradient(135deg, #ff3333, #3399ff); font-size: 1.15rem; font-family: 'Outfit'; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.06);">
                                    {{ strtoupper(substr($booking->user->name ?? 'G', 0, 1)) }}
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">{{ $booking->user->name }}</h5>
                                    <a href="mailto:{{ $booking->user->email }}" class="text-decoration-none text-muted small">{{ $booking->user->email }}</a>
                                </div>
                            </div>
                            <div class="p-3 bg-light rounded-3 small border border-light-subtle">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Phone:</span>
                                    <span class="fw-bold text-dark">{{ $booking->phone ?? $booking->user->phone ?? 'N/A' }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">License:</span>
                                    <span class="fw-bold text-dark">DL-123-45678</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <h6 class="text-uppercase text-muted fw-bold small mb-3" style="font-size: 0.68rem; letter-spacing: 0.8px;">Vehicle Information</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-white border rounded p-2 me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 58px; height: 58px;">
                                    <i class="fas fa-car fa-2x text-primary opacity-75"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">{{ $booking->car->brand }} {{ $booking->car->model }}</h5>
                                    <div class="badge bg-secondary text-uppercase mt-1" style="font-size: 0.65rem; font-weight: 700;">{{ $booking->car->type }}</div>
                                </div>
                            </div>
                            <div class="row g-2 small">
                                <div class="col-6">
                                    <div class="p-2 border rounded text-center bg-light">
                                        <i class="fas fa-gas-pump text-muted mb-1"></i>
                                        <div class="fw-bold">{{ $booking->car->fuel_type ?? 'Petrol' }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 border rounded text-center bg-light">
                                        <i class="fas fa-cogs text-muted mb-1"></i>
                                        <div class="fw-bold">{{ $booking->car->transmission ?? 'Automatic' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Timeline -->
                    <div class="mb-5">
                        <h6 class="text-uppercase text-muted fw-bold small mb-3" style="font-size: 0.68rem; letter-spacing: 0.8px;">Trip Schedule</h6>
                        <div class="d-flex justify-content-between align-items-center bg-light p-4 rounded-4 border">
                            <div class="text-center">
                                <div class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">Pick-up</div>
                                <h5 class="fw-bold text-dark mb-0">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('M d, Y') }}</h5>
                                <div class="text-primary fw-bold small">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('h:i A') }}</div>
                            </div>
                            <div class="flex-grow-1 mx-4 position-relative text-center d-none d-sm-block" style="height: 2px; background: #dee2e6;">
                                <div class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small fw-bold border rounded-pill py-0.5" style="font-size: 0.75rem;">
                                    {{ round(\Carbon\Carbon::parse($booking->start_datetime)->diffInHours(\Carbon\Carbon::parse($booking->end_datetime)) / 24) ?: 1 }} Days
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">Drop-off</div>
                                <h5 class="fw-bold text-dark mb-0">{{ \Carbon\Carbon::parse($booking->end_datetime)->format('M d, Y') }}</h5>
                                <div class="text-primary fw-bold small">{{ \Carbon\Carbon::parse($booking->end_datetime)->format('h:i A') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted fw-bold small mb-3" style="font-size: 0.68rem; letter-spacing: 0.8px;">Payment Summary</h6>
                        <div class="table-responsive border-0">
                            <table class="table align-middle" style="border: none !important;">
                                <thead>
                                    <tr class="text-muted" style="border-bottom: 2px solid #f1f5f9; font-size: 0.72rem; text-transform: uppercase;">
                                        <th class="ps-0 py-2 border-0">Item Description</th>
                                        <th class="text-center py-2 border-0">Duration</th>
                                        <th class="text-end pe-0 py-2 border-0">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="ps-0 py-3 border-0">
                                            <span class="fw-bold text-dark" style="font-size: 0.95rem;">Premium Car Fleet Hire (₹{{ number_format($booking->car->price_per_day) }} / day)</span>
                                            <small class="text-muted d-block">Inclusive of damage and liability coverage</small>
                                        </td>
                                        <td class="text-center py-3 border-0">{{ round(\Carbon\Carbon::parse($booking->start_datetime)->diffInHours(\Carbon\Carbon::parse($booking->end_datetime)) / 24) ?: 1 }} Days</td>
                                        <td class="text-end pe-0 py-3 fw-bold text-dark border-0">₹{{ number_format($booking->car->price_per_day * (round(\Carbon\Carbon::parse($booking->start_datetime)->diffInHours(\Carbon\Carbon::parse($booking->end_datetime)) / 24) ?: 1)) }}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="ps-0 py-3 border-0" colspan="2">
                                            <span class="text-muted">Standard Taxes & Rental Surcharges (5%)</span>
                                        </td>
                                        <td class="text-end pe-0 py-3 fw-bold text-success border-0">Included</td>
                                    </tr>
                                    <tr style="border-top: 2px solid #f1f5f9 !important;">
                                        <td class="ps-0 py-4 border-0" colspan="2">
                                            <h5 class="fw-black text-dark mb-0" style="font-weight: 800;">Total Charged Fare</h5>
                                        </td>
                                        <td class="text-end pe-0 py-4 border-0">
                                            <h5 class="fw-black mb-0 text-danger" style="font-weight: 900; font-size: 1.45rem;">
                                                ₹{{ number_format($booking->total_price) }}
                                            </h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Status Stamp & Note -->
                    <div class="row align-items-center mt-4 pt-4 border-top">
                        <div class="col-sm-7 mb-4 mb-sm-0">
                            <h6 class="text-uppercase text-muted fw-bold small mb-1" style="font-size: 0.65rem; letter-spacing: 0.8px;">Verification Guidelines</h6>
                            <p class="text-muted small mb-0">This document represents a certified transaction invoice. Vehicle handovers require verification of the customer's driving credentials against this reservation.</p>
                        </div>
                        <div class="col-sm-5 text-sm-end">
                            @if($booking->status == 'confirmed' || $booking->status == 'completed')
                                <div class="d-inline-block border border-success text-success px-4 py-2.5 rounded fw-bold text-uppercase tracking-wider rotate-stamp shadow-sm" style="font-size: 1.25rem; font-weight: 900; letter-spacing: 2px; transform: rotate(-5deg); border-width: 3.5px !important; background-color: rgba(25, 135, 84, 0.04);">
                                    <i class="fas fa-check-circle me-1"></i> PAID
                                </div>
                            @elseif($booking->status == 'cancelled')
                                <div class="d-inline-block border border-danger text-danger px-4 py-2.5 rounded fw-bold text-uppercase tracking-wider rotate-stamp shadow-sm" style="font-size: 1.25rem; font-weight: 900; letter-spacing: 2px; transform: rotate(-5deg); border-width: 3.5px !important; background-color: rgba(220, 53, 69, 0.04);">
                                    <i class="fas fa-ban me-1"></i> CANCELLED
                                </div>
                            @else
                                <div class="d-inline-block border border-warning text-warning px-4 py-2.5 rounded fw-bold text-uppercase tracking-wider rotate-stamp shadow-sm" style="font-size: 1.25rem; font-weight: 900; letter-spacing: 2px; transform: rotate(-5deg); border-width: 3.5px !important; background-color: rgba(245, 158, 11, 0.04);">
                                    <i class="fas fa-clock me-1"></i> PENDING
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar / Notes -->
        <div class="col-lg-4 no-print">
            <!-- Status Card -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Booking Status</h6>
                    <div class="alert alert-{{ match($booking->status) { 'confirmed' => 'success', 'pending' => 'warning', 'cancelled' => 'danger', default => 'secondary' } }} border-0 d-flex align-items-center mb-0" style="border-radius: 12px;">
                         <i class="fas fa-info-circle me-2"></i>
                         <div>
                             <strong class="text-capitalize">{{ $booking->status }}</strong>
                             <div class="small opacity-75">
                                 @if($booking->status == 'pending') Waiting for admin approval.
                                 @elseif($booking->status == 'confirmed') Payment received & car reserved.
                                 @else Booking has been cancelled. @endif
                             </div>
                         </div>
                    </div>
                </div>
            </div>

            <!-- Admin Notes -->
             <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">Admin Notes</h6>
                </div>
                <div class="card-body">
                    <textarea class="form-control bg-light border-0 mb-3" rows="4" placeholder="Add private notes about this booking..." style="border-radius: 10px;"></textarea>
                    <button class="btn btn-primary w-100 btn-sm" style="border-radius: 10px;">Save Note</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fade-in-up {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }

    /* PREMIUM PRINT STYLES */
    @media print {
        /* Completely hide navigation sidebar, admin layouts, navbar, side notes, toast notifications, buttons, headers */
        .sidebar-container, 
        .admin-navbar, 
        .btn-group, 
        .btn, 
        .col-lg-4, 
        #liveToast, 
        .toast-container,
        nav,
        form,
        .no-print {
            display: none !important;
        }

        /* Reset background, padding, overflow & margins on all wrapper panels */
        body, 
        main, 
        .container-fluid, 
        .py-4,
        .fade-in-up {
            background: #fff !important;
            color: #000 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: visible !important;
            height: auto !important;
            min-height: auto !important;
        }

        /* Force printed content to occupy 100% full-width */
        .col-lg-8, 
        #printable-admin-invoice {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .invoice-card {
            border: none !important;
            box-shadow: none !important;
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .card-body {
            padding: 0 !important;
        }

        /* Force correct color adjustments */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        .text-dark {
            color: #000 !important;
        }

        .text-muted {
            color: #555 !important;
        }

        .bg-light {
            background-color: #f8fafc !important;
        }
        
        .border-end {
            border-right: 1px solid #dee2e6 !important;
        }
    }
</style>
@endsection