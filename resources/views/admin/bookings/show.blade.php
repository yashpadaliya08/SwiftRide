@extends('admin.layout')

@section('content')
    <div class="container-fluid py-4">
        <div class="fade-in-down">
            <h2 class="mb-4 fw-bold">Booking Details
                <small class="text-muted fs-5">(ID: {{ $booking->id }})</small>
            </h2>

            <div class="card shadow-lg border-0 animated-card">
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3 text-muted">User:</dt>
                        <dd class="col-sm-9">{{ $booking->name }}</dd>

                        <dt class="col-sm-3 text-muted">Car:</dt>
                        <dd class="col-sm-9">{{ ($booking->car->brand ?? 'N/A') . ' ' . ($booking->car->model ?? '') }}</dd>

                        <dt class="col-sm-3 text-muted">From:</dt>
                        <dd class="col-sm-9">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M Y') }}</dd>

                        <dt class="col-sm-3 text-muted">To:</dt>
                        <dd class="col-sm-9">{{ \Carbon\Carbon::parse($booking->end_datetime)->format('d M Y') }}</dd>

                        <dt class="col-sm-3 text-muted">Total Price:</dt>
                        <dd class="col-sm-9">₹{{ number_format($booking->total_price ?? 0, 2) }}</dd>

                        <dt class="col-sm-3 text-muted">Pickup Location:</dt>
                        <dd class="col-sm-9">{{ $booking->pickup_city ?? 'N/A' }}</dd>

                        <dt class="col-sm-3 text-muted">Status:</dt>
                        <dd class="col-sm-9">
                            @php
                                $badge = match ($booking->status) {
                                    'confirmed' => 'info',
                                    'pending' => 'warning text-dark',
                                    'cancelled' => 'danger',
                                    'completed' => 'success',
                                    default => 'secondary'
                                };
                            @endphp
                            <span
                                class="badge bg-{{ $badge }} px-3 py-1 fs-6 animate-badge">{{ ucfirst($booking->status) }}</span>
                        </dd>
                    </dl>

                    @if($booking->status === 'pending')
                        <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to confirm this booking?');"
                            class="mt-4 d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-success shadow-sm px-4 py-2 fw-semibold">
                                <i class="fas fa-check-circle me-1"></i> Confirm Booking
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.bookings.index') }}"
                        class="btn btn-outline-secondary ms-2 px-4 py-2 fw-semibold shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to Bookings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Entrance Animation */
        .fade-in-down {
            animation: fadeInDown 0.6s ease-out both;
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-15px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card pop effect */
        .animated-card {
            animation: zoomIn 0.3s ease-in-out;
            border-radius: 12px;
        }

        @keyframes zoomIn {
            0% {
                opacity: 0;
                transform: scale(0.95);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Badge animation */
        .animate-badge {
            animation: pulse 1.2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* Button hover improvements */
        .btn:hover {
            transform: translateY(-1px);
            transition: all 0.2s ease-in-out;
        }
    </style>
@endsection