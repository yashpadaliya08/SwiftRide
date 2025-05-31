@extends('admin.layout')

@section('content')
    <div class="container-fluid py-4">
        <h2 class="mb-4">All Bookings</h2>

        <div class="card shadow-sm">
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
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ ($booking->car->brand ?? 'N/A') . ' ' . ($booking->car->model ?? '') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->end_datetime)->format('d M Y') }}</td>
                                    <td>₹{{ number_format($booking->total_price ?? 0, 2) }}</td>
                                    <td>
                                        @if($booking->status === 'confirmed')
                                            <span class="badge bg-info">Confirmed</span>
                                        @elseif($booking->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">No bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection