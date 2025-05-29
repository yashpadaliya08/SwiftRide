@extends('client.layout')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-semibold theme-accent">Available Cars</h2>
    <div class="row">
        @forelse($cars as $car)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-shadow">
                    @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top rounded-top" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                        <p class="card-text mb-2 text-muted">₹{{ number_format($car->price_per_day) }} / day</p>
                        {{-- Updated route to use named route 'car.details' --}}
                        <a href="{{ route('car.details', $car->id) }}" class="mt-auto btn btn-theme btn-sm w-100">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="alert alert-warning">No cars available at the moment.</div>
            </div>
        @endforelse
    </div>
</div>

<style>
    .theme-accent {
        color: #e74c3c;
    }

    .btn-theme {
        background-color: #e74c3c;
        color: #fff;
        border: none;
    }

    .btn-theme:hover {
        background-color: #c0392b;
        color: #fff;
    }

    .hover-shadow {
        transition: all 0.3s ease-in-out;
    }

    .hover-shadow:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
