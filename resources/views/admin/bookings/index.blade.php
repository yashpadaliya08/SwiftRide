@extends('admin.layout')

@section('content')
    <div class="container-fluid py-4">
        <h2 class="mb-4 fw-bold text-primary fade-in">All Bookings</h2>

        <div class="card shadow-sm fade-in delay-1">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">User</th>
                                <th scope="col">Car</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr class="fade-in delay-2">
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ ($booking->car->brand ?? 'N/A') . ' ' . ($booking->car->model ?? '') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->end_datetime)->format('d M Y') }}</td>
                                    <td>₹{{ number_format($booking->total_price ?? 0, 2) }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'confirmed' => 'info',
                                                'pending' => 'warning text-dark',
                                                'cancelled' => 'danger',
                                                'completed' => 'success',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$booking->status] ?? 'secondary' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                            class="btn btn-outline-primary btn-sm fw-semibold px-3 py-1 rounded-pill shadow-sm">
                                            <i class="fas fa-eye me-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4 fade-in delay-3">No bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Fade-in Animations --}}
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .fade-in.delay-1 { animation-delay: 0.2s; }
        .fade-in.delay-2 { animation-delay: 0.4s; }
        .fade-in.delay-3 { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: #fff;
        }
    </style>
@endsection
