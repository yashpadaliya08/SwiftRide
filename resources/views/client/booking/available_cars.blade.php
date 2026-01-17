@extends('client.layout')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5" data-aos="fade-down">
        <div>
            <span class="badge bg-primary text-white rounded-pill px-3 py-2 mb-2 text-uppercase fw-bold small shadow-sm animate__animated animate__fadeInLeft">Step 2 of 3</span>
            <h2 class="fw-bold mb-1">Available Cars</h2>
            <p class="text-muted mb-0">For your trip from <span class="text-dark fw-bold">{{ $pickup_city }}</span> to <span class="text-dark fw-bold">{{ $dropoff_city }}</span></p>
        </div>
        <a href="{{ route('booking.selectCriteria') }}" class="btn btn-outline-secondary rounded-pill btn-sm mt-3 mt-md-0"><i class="fas fa-edit me-2"></i>Change Search</a>
    </div>

    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3" data-aos="fade-right">
            <!-- Trip Summary Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-dark text-white border-0 py-3 rounded-top-4">
                    <h5 class="mb-0 fw-bold small text-uppercase"><i class="fas fa-map-marked-alt me-2 text-warning"></i>Your Trip</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <small class="text-muted d-block fw-bold text-uppercase">Pick-up</small>
                        <div class="fw-bold">{{ $pickup_city }}</div>
                        <small>{{ \Carbon\Carbon::parse("$start_date")->format('M d, Y') }}</small>
                    </div>
                    <div class="mb-3">
                         <small class="text-muted d-block fw-bold text-uppercase">Drop-off</small>
                        <div class="fw-bold">{{ $dropoff_city }}</div>
                         <small>{{ \Carbon\Carbon::parse("$end_date")->format('M d, Y') }}</small>
                    </div>
                </div>
            </div>

            <!-- Filters (Visual Only for now) -->
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-filter me-2 text-primary"></i>Filters</h5>
                </div>
                <div class="card-body p-4">
                     <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Max Price</label>
                        <input type="range" class="form-range" min="500" max="10000" id="priceRangeResult">
                         <div class="d-flex justify-content-between small fw-bold">
                            <span>₹500</span>
                            <span id="priceValResult" class="text-primary">--</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Transmission</label>
                        <div class="d-flex gap-2">
                             <button class="btn btn-outline-dark btn-sm flex-fill fw-bold active">All</button>
                             <button class="btn btn-outline-dark btn-sm flex-fill fw-bold">Auto</button>
                             <button class="btn btn-outline-dark btn-sm flex-fill fw-bold">Manual</button>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 rounded-pill fw-bold" disabled>Apply Filters</button>
                    <small class="text-muted text-center d-block mt-2">Filter logic coming soon</small>
                </div>
            </div>
        </div>

        <!-- Car Grid -->
        <div class="col-lg-9">
            @if(count($availableCars) > 0)
                <div class="row g-4">
                @foreach($availableCars as $car)
                    <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden car-card hover-lift">
                            <!-- Image -->
                            <div class="position-relative">
                                <img src="{{ $car->image ? asset('storage/' . $car->image) : 'https://via.placeholder.com/400x250?text=No+Image' }}" 
                                     class="card-img-top object-fit-cover" 
                                     style="height: 220px;" 
                                     alt="{{ $car->brand }} {{ $car->model }}">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-success shadow-sm px-3 py-2 rounded-pill small">Available</span>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="fw-bold mb-0 text-dark">{{ $car->brand }} {{ $car->model }}</h5>
                                        <small class="text-muted">{{ $car->year }} Series</small>
                                    </div>
                                    <div class="text-end">
                                        <h5 class="fw-bold text-primary mb-0">₹{{ number_format($car->price_per_day) }}</h5>
                                        <small class="text-muted">/ day</small>
                                    </div>
                                </div>

                                <!-- Specs Icons -->
                                <div class="row g-2 my-3">
                                    <div class="col-4">
                                        <div class="p-2 border rounded-3 text-center bg-light">
                                            <i class="fas fa-gas-pump text-muted mb-1 d-block"></i>
                                            <small class="fw-bold fs-xs">{{ $car->fuel_type }}</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded-3 text-center bg-light">
                                            <i class="fas fa-cogs text-muted mb-1 d-block"></i>
                                            <small class="fw-bold fs-xs">{{ $car->transmission }}</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded-3 text-center bg-light">
                                            <i class="fas fa-users text-muted mb-1 d-block"></i>
                                            <small class="fw-bold fs-xs">{{ $car->seats }} Seats</small>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('booking.confirm') }}" method="POST" class="mt-auto">
                                    @csrf
                                    <input type="hidden" name="pickup_city" value="{{ $pickup_city }}">
                                    <input type="hidden" name="dropoff_city" value="{{ $dropoff_city }}">
                                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                                    <input type="hidden" name="start_time" value="{{ $start_time }}">
                                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                                    <input type="hidden" name="end_time" value="{{ $end_time }}">
                                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm">
                                        Book Now <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3 text-muted opacity-25"><i class="fas fa-car-crash fa-4x"></i></div>
                    <h4 class="fw-bold">No cars available</h4>
                    <p class="text-muted">We couldn't find any cars for your selected dates.</p>
                    <a href="{{ route('booking.selectCriteria') }}" class="btn btn-outline-primary rounded-pill px-4">Change Dates</a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Simple script to update price label (Visual Only)
    const range = document.getElementById('priceRangeResult');
    const label = document.getElementById('priceValResult');
    if(range && label){
        label.textContent = '₹' + range.value; // init
        range.addEventListener('input', () => label.textContent = '₹' + range.value);
    }
</script>
<style>
    .fs-xs { font-size: 0.75rem; }
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection

@section('styles')
    <style>
        .car-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .btn-theme {
            background-color: #007bff;
            border: none;
            color: white;
        }

        .btn-theme:hover {
            background-color: #0056b3;
        }
    </style>
@endsection

@section('scripts')
    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
@endsection
