@extends('client.layout')

@section('title', 'My Bookings')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-theme fw-bold text-center">My Bookings</h2>

    @if($bookings->isEmpty())
        <div class="alert alert-info text-center shadow-sm rounded">
            You have no bookings yet. Book a car to see it here.
        </div>
    @else
        <div class="card shadow-lg rounded-4 border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle text-center">
                        <thead class="table-theme text-white rounded-top">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">User</th>
                                <th scope="col">Car</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Status</th>
                                <!-- <th scope="col">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->name }}</td>
                                    <td>{{ $booking->car->brand ?? 'N/A' }} {{ $booking->car->model ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->end_datetime)->format('d M, Y') }}</td>
                                    <td>₹{{ number_format($booking->total_price ?? 0, 2) }}</td>
                                    <td>
                                        @if($booking->status == 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($booking->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                    <!-- <td>
                                        <a href="#" class="btn btn-sm btn-primary disabled">View</a>
                                    </td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    /* Theme colors */
    .text-theme {
        color: #e74c3c;
    }

    .table-theme {
        background-color: #e74c3c;
    }

    /* Rounded header */
    thead tr th:first-child {
        border-top-left-radius: 0.5rem;
    }
    thead tr th:last-child {
        border-top-right-radius: 0.5rem;
    }
    

    /* Responsive tweaks */
    @media (max-width: 576px) {
        .table-responsive {
            font-size: 0.9rem;
        }
    }
      thead {
        background-color: #007bff; /* Bootstrap primary blue */
        color: #fff;
    }
    thead th {
        font-weight: 600;
        padding: 12px 15px;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>
@endsection
