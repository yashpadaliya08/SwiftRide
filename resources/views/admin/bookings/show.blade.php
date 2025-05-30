@extends('admin.layout')

@section('content')
    <div class="container-fluid py-4">
        <h2 class="mb-4">Booking Details <small class="text-muted">(ID: {{ $booking->id }})</small></h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <p><strong>User:</strong> {{ $booking->name }}</p>
                <p><strong>Car:</strong> {{ ($booking->car->brand ?? 'N/A') . ' ' . ($booking->car->model ?? '') }}</p>
                <p><strong>From:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                <p><strong>To:</strong> {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                <p><strong>Total Price:</strong> ₹{{ number_format($booking->total_price ?? 0, 2) }}</p>
                <p><strong>Pickup Location:</strong> {{ $booking->pickup_location ?? 'N/A' }}</p>
                <p><strong>Status:</strong>
                    @if($booking->status === 'confirmed')
                        <span class="badge bg-success">Confirmed</span>
                    @elseif($booking->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @else
                        <span class="badge bg-secondary">Unknown</span>
                    @endif
                    @if($booking->status === 'pending')
                        <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to confirm this booking?');">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-1"></i> Confirm Booking
                            </button>
                        </form>
                    @endif

                </p>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left me-1"></i> Back to Bookings
                </a>
            </div>
        </div>
    </div>
@endsection