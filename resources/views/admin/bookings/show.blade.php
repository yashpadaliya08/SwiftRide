@extends('admin.layout')

@section('title', 'Booking Details')

@section('content')
<div class="container-fluid py-4 fade-in-up">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
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
             @if($booking->status !== 'cancelled')
                <button class="btn btn-danger fw-bold text-white">
                    <i class="fas fa-ban me-2"></i> Cancel
                </button>
             @endif
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Details (Invoice Style) -->
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    
                    <!-- Client & Car Info -->
                    <div class="row mb-5">
                        <div class="col-md-6 border-end">
                            <h6 class="text-uppercase text-muted fw-bold small mb-3">Customer Details</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 fs-5 fw-bold" style="width: 48px; height: 48px;">
                                    {{ substr($booking->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">{{ $booking->user->name }}</h5>
                                    <a href="mailto:{{ $booking->user->email }}" class="text-decoration-none text-muted small">{{ $booking->user->email }}</a>
                                </div>
                            </div>
                            <div class="p-3 bg-light rounded-3 small">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Phone:</span>
                                    <span class="fw-bold text-dark">+91 98765 43210</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">License:</span>
                                    <span class="fw-bold text-dark">DL-123-45678</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <h6 class="text-uppercase text-muted fw-bold small mb-3">Vehicle Information</h6>
                            <div class="d-flex align-items-center mb-3">
                                <!-- Placeholder or Car Image -->
                                <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-car fa-2x text-muted"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">{{ $booking->car->brand }} {{ $booking->car->model }}</h5>
                                    <div class="badge bg-secondary text-uppercase">{{ $booking->car->type }}</div>
                                </div>
                            </div>
                            <div class="row g-2 small">
                                <div class="col-6">
                                    <div class="p-2 border rounded text-center">
                                        <i class="fas fa-gas-pump text-muted mb-1"></i>
                                        <div class="fw-bold">{{ $booking->car->fuel_type ?? 'Petrol' }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 border rounded text-center">
                                        <i class="fas fa-cogs text-muted mb-1"></i>
                                        <div class="fw-bold">{{ $booking->car->transmission ?? 'Automatic' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Timeline -->
                    <div class="mb-5">
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">Trip Schedule</h6>
                        <div class="d-flex justify-content-between align-items-center bg-light p-4 rounded-4 border">
                            <div class="text-center">
                                <div class="text-muted small text-uppercase fw-bold mb-1">Pick-up</div>
                                <h5 class="fw-bold text-dark mb-0">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('M d, Y') }}</h5>
                                <div class="text-primary fw-bold small">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('h:i A') }}</div>
                            </div>
                            <div class="flex-grow-1 mx-4 position-relative text-center" style="height: 2px; background: #dee2e6;">
                                <div class="position-absolute top-50 start-50 translate-middle bg-white px-2 text-muted small fw-bold">
                                    {{ round(\Carbon\Carbon::parse($booking->start_datetime)->diffInHours(\Carbon\Carbon::parse($booking->end_datetime)) / 24) ?: 1 }} Days
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-muted small text-uppercase fw-bold mb-1">Drop-off</div>
                                <h5 class="fw-bold text-dark mb-0">{{ \Carbon\Carbon::parse($booking->end_datetime)->format('M d, Y') }}</h5>
                                <div class="text-primary fw-bold small">{{ \Carbon\Carbon::parse($booking->end_datetime)->format('h:i A') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                     <div>
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">Payment Summary</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody>
                                    <tr class="border-bottom">
                                        <td class="text-muted">Daily Rate</td>
                                        <td class="text-end fw-bold">₹{{ number_format($booking->car->price_per_day) }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted">Duration</td>
                                        <td class="text-end fw-bold">{{ round(\Carbon\Carbon::parse($booking->start_datetime)->diffInHours(\Carbon\Carbon::parse($booking->end_datetime)) / 24) ?: 1 }} Days</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted">Taxes & Fees (5%)</td>
                                        <td class="text-end fw-bold">₹{{ number_format($booking->total_price * 0.05) }}</td>
                                    </tr>
                                    <tr class="table-dark">
                                        <td class="fw-bold fs-5 ps-3">Total Amount</td>
                                        <td class="text-end fw-bold fs-5 pe-3">₹{{ number_format($booking->total_price) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar / Notes -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Booking Status</h6>
                    <div class="alert alert-{{ match($booking->status) { 'confirmed' => 'success', 'pending' => 'warning', 'cancelled' => 'danger', default => 'secondary' } }} border-0 d-flex align-items-center mb-0">
                         <i class="fas fa-info-circle me-2"></i>
                         <div>
                             <strong>{{ ucfirst($booking->status) }}</strong>
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
             <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">Admin Notes</h6>
                </div>
                <div class="card-body">
                    <textarea class="form-control bg-light border-0 mb-3" rows="4" placeholder="Add private notes about this booking..."></textarea>
                    <button class="btn btn-primary w-100 btn-sm">Save Note</button>
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
</style>
@endsection