@extends('client.layout')

@section('title', 'Booking Confirmed!')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-5">
        <div class="col-lg-6 text-center" data-aos="zoom-in">
            <!-- Success Icon -->
            <div class="success-animation mb-5">
                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg mb-4" style="width: 100px; height: 100px;">
                    <i class="fas fa-check fa-3x"></i>
                </div>
                <div class="confetti-container"></div>
            </div>

            <h1 class="display-4 fw-black text-dark mb-3">Booking Confirmed!</h1>
            <p class="lead text-muted mb-5">Thank you for choosing SwiftRide. Your journey with the <span class="fw-bold text-primary">{{ $booking->car->brand }} {{ $booking->car->model }}</span> is all set.</p>

            <!-- Booking Brief -->
            <div class="card border-0 shadow-sm rounded-4 p-4 text-start mb-5 bg-light">
                <div class="row g-3">
                    <div class="col-6">
                        <small class="text-muted text-uppercase fw-bold x-small d-block mb-1">Booking ID</small>
                        <span class="fw-bold">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted text-uppercase fw-bold x-small d-block mb-1">Amount Paid</small>
                        <span class="fw-bold text-success">₹{{ number_format($booking->total_price) }}</span>
                    </div>
                    <hr class="my-2 opacity-5">
                    <div class="col-12">
                        <small class="text-muted text-uppercase fw-bold x-small d-block mb-1">Pick-up Location & Date</small>
                        <span class="fw-bold">{{ $booking->pickup_city }}</span> • {{ $booking->start_datetime->format('d M, Y') }}
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg">Go to Dashboard</a>
                <a href="{{ route('booking.myBookings') }}" class="btn btn-outline-dark rounded-pill px-5 py-3 fw-bold">View My Bookings</a>
            </div>
            
            <p class="mt-5 text-muted small">A confirmation email has been sent to <strong>{{ $booking->email }}</strong> with all the details.</p>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900 !important; }
    .x-small { font-size: 0.65rem; }
    
    .success-animation {
        position: relative;
    }
    
    .bg-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
    }
</style>

<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true });
</script>
@endsection
