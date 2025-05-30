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
                        <table id="bookings-table" class="table table-striped table-hover align-middle text-center">
                            <thead class="table-theme text-white rounded-top">
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Car</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->name }}</td>
                                        <td>{{ $booking->car->brand ?? 'N/A' }} {{ $booking->car->model ?? '' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M, Y h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->end_datetime)->format('d M, Y h:i A') }}</td>
                                        <td>₹{{ number_format($booking->total_price ?? 0, 2) }}</td>
                                        <td>
                                            @if($booking->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($booking->status == 'confirmed')
                                                <span class="badge bg-success">Confirmed</span>
                                            @elseif($booking->status == 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking->status == 'pending')
                                                <button type="button" class="btn btn-sm btn-outline-danger cancel-btn"
                                                    data-bs-toggle="modal" data-bs-target="#cancelModal"
                                                    data-booking-id="{{ $booking->id }}">
                                                    Cancel
                                                </button>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Cancel Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="cancelForm">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelModalLabel">Confirm Cancellation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to cancel this booking?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep it</button>
                        <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Include DataTables via CDN if not already included -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
    $('#bookings-table').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            search: "_INPUT_",
            searchPlaceholder: "Search bookings..."
        },
        "columnDefs": [
            { targets: [0], className: "fw-bold" }, // ID bold
            { targets: '_all', className: "align-middle" }
        ]
    });

    $('.cancel-btn').on('click', function () {
        let bookingId = $(this).data('booking-id');
        let cancelUrl = `{{ url('booking/my-bookings') }}/${bookingId}/cancel`;
        $('#cancelForm').attr('action', cancelUrl);
    });
});

    </script>
@endsection

<style>
 .text-theme {
        color: #e74c3c;
    }

    .table-theme {
        background-color: #e74c3c;
    }

    #bookings-table thead th {
        background-color: #e74c3c;
        color: white;
        border: none;
        vertical-align: middle;
    }

    #bookings-table td,
    #bookings-table th {
        padding: 1rem;
        vertical-align: middle;
    }

    #bookings-table tbody tr:hover {
        background-color: #fef2f2;
        cursor: pointer;
    }

    .dataTables_filter {
        float: right !important;
        margin-bottom: 1rem;
    }

    .dataTables_filter input {
        border-radius: 0.5rem;
        padding: 0.5rem;
        border: 1px solid #ccc;
    }

    .dataTables_paginate {
        float: right;
    }

    .paginate_button {
        margin: 0 4px !important;
        border-radius: 0.3rem !important;
    }

    .dataTables_info {
        font-size: 0.9rem;
        margin-top: 1rem;
    }

    thead tr th:first-child {
        border-top-left-radius: 0.5rem;
    }

    thead tr th:last-child {
        border-top-right-radius: 0.5rem;
    }

    @media (max-width: 576px) {
        .table-responsive {
            font-size: 0.9rem;
        }

        .dataTables_filter {
            float: none !important;
            text-align: left;
        }
    }
</style>