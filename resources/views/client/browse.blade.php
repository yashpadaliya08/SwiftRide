@extends('client.layout')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="text-center mb-5" data-aos="fade-down">
        <h2 class="fw-bold mb-2">Find Your Perfect Ride</h2>
        <p class="text-muted">Explore our wide range of premium vehicles for your next journey.</p>
    </div>

    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3" data-aos="fade-right">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px; z-index: 10;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-filter me-2 text-primary"></i>Filters</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('browse') }}" method="GET">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Search</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Model, Brand..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Max Price (₹/day)</label>
                            <input type="range" class="form-range" min="500" max="10000" step="500" id="priceRange" name="max_price" value="{{ request('max_price', 10000) }}">
                            <div class="d-flex justify-content-between small fw-bold">
                                <span>₹500</span>
                                <span id="priceVal" class="text-primary">₹{{ request('max_price', 10000) }}</span>
                            </div>
                        </div>

                        <!-- Transmission -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Transmission</label>
                            <div class="d-flex gap-2">
                                <input type="radio" class="btn-check" name="transmission" id="transAll" value="" {{ !request('transmission') ? 'checked' : '' }}>
                                <label class="btn btn-outline-light text-dark btn-sm flex-fill fw-bold" for="transAll">All</label>
                                
                                <input type="radio" class="btn-check" name="transmission" id="transAuto" value="Automatic" {{ request('transmission') == 'Automatic' ? 'checked' : '' }}>
                                <label class="btn btn-outline-light text-dark btn-sm flex-fill fw-bold" for="transAuto">Auto</label>

                                <input type="radio" class="btn-check" name="transmission" id="transManual" value="Manual" {{ request('transmission') == 'Manual' ? 'checked' : '' }}>
                                <label class="btn btn-outline-light text-dark btn-sm flex-fill fw-bold" for="transManual">Manual</label>
                            </div>
                        </div>

                         <!-- Car Type -->
                         <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Vehicle Type</label>
                            <select class="form-select bg-light border-0" name="type">
                                <option value="">All Types</option>
                                <option value="SUV" {{ request('type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                                <option value="Sedan" {{ request('type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="Hatchback" {{ request('type') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                <option value="Luxury" {{ request('type') == 'Luxury' ? 'selected' : '' }}>Luxury</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill fw-bold">Apply Filters</button>
                            <a href="{{ route('browse') }}" class="btn btn-link text-muted btn-sm mt-2 text-decoration-none">Reset All</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Car Grid -->
        <div class="col-lg-9">
            <div class="row g-4">
                @forelse($cars as $car)
                    <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden car-card hover-lift">
                            <!-- Image -->
                            <div class="position-relative">
                                <img src="{{ $car->image ? asset('storage/' . $car->image) : 'https://via.placeholder.com/400x250?text=No+Image' }}" 
                                     class="card-img-top object-fit-cover" 
                                     style="height: 220px;" 
                                     alt="{{ $car->brand }} {{ $car->model }}">
                                
                                <!-- Badges -->
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill fw-bold small text-uppercase">
                                        {{ $car->type }}
                                    </span>
                                </div>
                                @if($car->status == 'available')
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-success shadow-sm px-3 py-2 rounded-pill small">Available</span>
                                    </div>
                                @else
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-secondary shadow-sm px-3 py-2 rounded-pill small">Booked</span>
                                    </div>
                                @endif
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

                                <div class="mt-auto">
                                    <a href="{{ route('car.details', $car->id) }}" class="btn btn-dark w-100 rounded-pill fw-bold py-2">
                                        View Details <i class="fas fa-arrow-right ms-2 small"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-3 text-muted opacity-25"><i class="fas fa-car-crash fa-4x"></i></div>
                        <h4>No cars found</h4>
                        <p class="text-muted">Try adjusting your filters to find what you're looking for.</p>
                        <a href="{{ route('browse') }}" class="btn btn-outline-primary rounded-pill">Clear Filters</a>
                    </div>
                @endforelse
            </div>
             <div class="mt-5 d-flex justify-content-center">
                <!-- Pagination could go here -->
            </div>
        </div>
    </div>
</div>

<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
    
    // Price Range Live Update
    const priceRange = document.getElementById('priceRange');
    const priceVal = document.getElementById('priceVal');
    if(priceRange) {
        priceRange.addEventListener('input', function() {
            priceVal.textContent = '₹' + this.value;
        });
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
    .btn-check:checked + .btn-outline-light {
        background-color: #0d6efd;
        color: white !important;
        border-color: #0d6efd;
    }
    .btn-outline-light {
        border-color: #dee2e6;
    }
</style>
@endsection
