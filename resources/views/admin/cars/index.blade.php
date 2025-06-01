@extends('admin.layout')

@section('title', 'Car Listings')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Car Listings</h2>
        <a href="{{ route('admin.cars.create') }}" class="btn btn-theme btn-shadow">
            <i class="fas fa-plus me-1"></i> Add New Car
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle text-center table-striped animate-table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Model</th>
                        <th scope="col">Year</th>
                        <th scope="col">Color</th>
                        <th scope="col">Price/Day</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cars as $car)
                        <tr class="table-row-fade">
                            <td>
                                @if($car->image)
                                    <img src="{{ asset('storage/' . $car->image) }}" alt="Car Image" width="80" class="img-thumbnail img-hover-scale shadow-sm">
                                @else
                                    <span class="text-muted fst-italic">N/A</span>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $car->name }}</td>
                            <td>{{ $car->brand }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->year }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $car->color }}</span>
                            </td>
                            <td class="text-success fw-bold">₹{{ number_format($car->price_per_day) }}</td>
                            <td>
                                @if($car->status === 'available')
                                    <span class="badge bg-success">Available</span>
                                @elseif($car->status === 'unavailable')
                                    <span class="badge bg-danger">Unavailable</span>
                                @else
                                    <span class="badge bg-warning text-dark">N/A</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.cars.edit', $car->id) }}" 
                                   class="btn btn-sm btn-outline-primary me-1 btn-action"
                                   data-bs-toggle="tooltip" title="Edit Car">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger btn-action" 
                                            onclick="return confirm('Are you sure you want to delete this car?')"
                                            data-bs-toggle="tooltip" title="Delete Car">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-5">
                                <p class="text-muted fst-italic fs-5">No cars found. Please add new cars to get started.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Animate table rows on load */
    .animate-table tbody tr {
        opacity: 0;
        transform: translateY(10px);
        animation: fadeInUp 0.5s ease forwards;
    }
    .animate-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
    .animate-table tbody tr:nth-child(2) { animation-delay: 0.15s; }
    .animate-table tbody tr:nth-child(3) { animation-delay: 0.2s; }
    .animate-table tbody tr:nth-child(4) { animation-delay: 0.25s; }
    .animate-table tbody tr:nth-child(5) { animation-delay: 0.3s; }
    /* add more delays if needed */

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Scale up image on hover */
    .img-hover-scale {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 0.375rem;
    }
    .img-hover-scale:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        z-index: 10;
        position: relative;
    }

    /* Button hover effect */
    .btn-action {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-action:hover {
        transform: scale(1.1);
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
    }

    /* Button with subtle shadow */
    .btn-shadow {
        box-shadow: 0 4px 6px rgba(13, 110, 253, 0.3);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
