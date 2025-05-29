@extends('client.layout')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">
                    @if ($car->image)
                        <div class="col-md-5 bg-light">
                            <img src="{{ asset('storage/' . $car->image) }}" class="img-fluid h-100 w-100 object-fit-cover" alt="{{ $car->name }}" style="min-height: 100%;">
                        </div>
                    @endif

                    <div class="col-md-7">
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <h2 class="card-title mb-3 text-theme">{{ $car->name }}</h2>

                            <ul class="list-unstyled mb-4">
                                <li><strong>Brand:</strong> {{ $car->brand }}</li>
                                <li><strong>Model:</strong> {{ $car->model }}</li>
                                <li><strong>Year:</strong> {{ $car->year }}</li>
                                <li><strong>Color:</strong> {{ $car->color }}</li>
                                <li><strong>Type:</strong> {{ $car->type ?? 'N/A' }}</li>
                                <li><strong>Price/Day:</strong> ₹{{ number_format($car->price_per_day) }}</li>
                            </ul>

                            <div class="mb-4">
                                <h5 class="fw-semibold">Description</h5>
                                <p class="text-muted">{{ $car->description ?? 'No description available.' }}</p>
                            </div>

                            <div class="mt-auto">
                                {{-- Updated booking link to match web.php route --}}
                                <a href="{{ route('book', ['car_id' => $car->id]) }}" class="btn btn-theme w-100">Book This Car</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>

<style>
    .text-theme {
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

    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endsection
