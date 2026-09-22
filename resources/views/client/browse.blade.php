@extends('client.layout')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5" data-aos="fade-down">
        <span class="text-danger fw-bold text-uppercase tracking-wider small d-block mb-2">Explore Fleet</span>
        <h1 class="display-5 fw-black text-dark tracking-tight mb-2">Find Your Perfect Ride</h1>
        <p class="text-muted mx-auto" style="max-width: 600px; font-weight: 500;">Explore our wide range of premium vehicles for your next premium journey.</p>
    </div>

    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3" data-aos="fade-right">
            <div class="card border-0 shadow-sm rounded-4 sticky-top filter-sidebar" style="top: 110px; z-index: 10;">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2 text-dark">
                        <i class="fas fa-sliders-h text-danger"></i> Filter Fleet
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('browse') }}" method="GET">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="form-label filter-label">Keyword Search</label>
                            <div class="input-group search-filter-group">
                                <span class="input-group-text bg-transparent border-0 pe-1"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-0 bg-transparent" placeholder="Model, brand, type..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <label class="form-label filter-label d-flex justify-content-between">
                                <span>Max Price / Day</span>
                                <span id="priceVal" class="text-danger fw-bold">₹{{ request('max_price', 10000) }}</span>
                            </label>
                            <input type="range" class="form-range custom-range" min="500" max="10000" step="500" id="priceRange" name="max_price" value="{{ request('max_price', 10000) }}">
                            <div class="d-flex justify-content-between text-muted mt-1" style="font-size: 0.72rem; font-weight: 600;">
                                <span>₹500</span>
                                <span>₹10,000</span>
                            </div>
                        </div>

                        <!-- Transmission -->
                        <div class="mb-4">
                            <label class="form-label filter-label">Transmission</label>
                            <div class="d-flex flex-column gap-2">
                                <label class="custom-radio-container">
                                    <input type="radio" name="transmission" value="" {{ !request('transmission') ? 'checked' : '' }}>
                                    <span class="custom-radio-checkmark"></span>
                                    <span class="custom-radio-label">All Transmissions</span>
                                </label>
                                <label class="custom-radio-container">
                                    <input type="radio" name="transmission" value="Automatic" {{ request('transmission') == 'Automatic' ? 'checked' : '' }}>
                                    <span class="custom-radio-checkmark"></span>
                                    <span class="custom-radio-label">Automatic</span>
                                </label>
                                <label class="custom-radio-container">
                                    <input type="radio" name="transmission" value="Manual" {{ request('transmission') == 'Manual' ? 'checked' : '' }}>
                                    <span class="custom-radio-checkmark"></span>
                                    <span class="custom-radio-label">Manual</span>
                                </label>
                            </div>
                        </div>

                        <!-- Car Type -->
                        <div class="mb-4">
                            <label class="form-label filter-label">Vehicle Type</label>
                            <select class="form-select custom-filter-select" name="type">
                                <option value="">All Vehicle Types</option>
                                <option value="SUV" {{ request('type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                                <option value="Sedan" {{ request('type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="Hatchback" {{ request('type') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                <option value="Luxury" {{ request('type') == 'Luxury' ? 'selected' : '' }}>Luxury</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-3 fw-bold py-2.5 filter-apply-btn">
                                Apply Filters
                            </button>
                            <a href="{{ route('browse') }}" class="btn btn-light rounded-3 btn-sm py-2 fw-semibold border text-dark text-decoration-none">
                                Reset Filters
                            </a>
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
                            <div class="position-relative overflow-hidden" style="height: 200px;">
                                <img src="{{ $car->image ? asset('storage/' . $car->image) : 'https://via.placeholder.com/400x250?text=No+Image' }}" 
                                     class="card-img-top object-fit-cover w-100 h-100 car-img-hover" 
                                     alt="{{ $car->brand }} {{ $car->model }}">
                                
                                <!-- Badges -->
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-white text-dark shadow-sm px-3 py-1.5 rounded-pill fw-bold text-uppercase" style="font-size: 0.72rem;">
                                        {{ $car->type }}
                                    </span>
                                </div>
                                
                                <div class="position-absolute top-0 end-0 m-3">
                                    @if($car->status == 'available')
                                        <span class="badge bg-success bg-opacity-90 shadow-sm px-3 py-1.5 rounded-pill fw-bold" style="font-size: 0.72rem;">Available</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-90 shadow-sm px-3 py-1.5 rounded-pill fw-bold" style="font-size: 0.72rem;">Booked</span>
                                    @endif
                                </div>

                                <div class="position-absolute bottom-0 end-0 m-3">
                                    <span class="price-pill shadow-sm">₹{{ number_format($car->price_per_day) }}<span class="price-day">/day</span></span>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="mb-3">
                                    <h5 class="fw-bold text-dark mb-1 tracking-tight">{{ $car->brand }} <span class="fw-normal text-muted">{{ $car->model }}</span></h5>
                                    <p class="text-muted small mb-0"><i class="far fa-star text-warning me-1"></i> 4.9 ({{ rand(15, 60) }} reviews) • {{ $car->year }}</p>
                                </div>

                                <!-- Specs Grid -->
                                <div class="row g-2 mb-4">
                                    <div class="col-4">
                                        <div class="spec-bubble">
                                            <i class="fas fa-gas-pump mb-1"></i>
                                            <span>{{ $car->fuel_type ?? 'Petrol' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="spec-bubble">
                                            <i class="fas fa-cog mb-1"></i>
                                            <span>{{ $car->transmission ?? 'Auto' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="spec-bubble">
                                            <i class="fas fa-user-friends mb-1"></i>
                                            <span>{{ $car->seats ?? 5 }} Seats</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    <a href="{{ route('car.details', $car->id) }}" class="btn btn-dark w-100 rounded-3 fw-bold py-2.5 shadow-sm car-details-btn">
                                        View Details <i class="fas fa-arrow-right ms-2 fs-7 opacity-0 btn-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-4 text-danger bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <i class="fas fa-car-side fa-2x"></i>
                        </div>
                        <h4 class="fw-bold text-dark">No Vehicles Found</h4>
                        <p class="text-muted mx-auto" style="max-width: 400px;">We couldn't find any vehicles matching your filters. Try resetting them or adjusting values.</p>
                        <a href="{{ route('browse') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold mt-2">Clear All Filters</a>
                    </div>
                @endforelse
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
            priceVal.textContent = '₹' + Number(this.value).toLocaleString();
        });
    }
</script>

<style>
    /* Sidebar card styling */
    .filter-sidebar {
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.03) !important;
    }

    .filter-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 0.6rem;
    }

    .search-filter-group {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .search-filter-group:focus-within, .search-filter-group:hover {
        border-color: #ff3333;
        box-shadow: 0 0 10px rgba(255, 51, 51, 0.1);
        background: #fff;
    }

    .search-filter-group .form-control {
        font-size: 0.88rem;
        font-weight: 550;
        color: #0f172a;
        padding: 0.6rem 0.8rem;
    }

    /* Custom range slider */
    .custom-range::-webkit-slider-thumb {
        background: #ff3333 !important;
        box-shadow: 0 0 8px rgba(255, 51, 51, 0.5);
    }
    
    .custom-range::-moz-range-thumb {
        background: #ff3333 !important;
        box-shadow: 0 0 8px rgba(255, 51, 51, 0.5);
    }

    /* Custom select style */
    .custom-filter-select {
        background-color: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.65rem 1rem;
        font-size: 0.88rem;
        font-weight: 550;
        color: #0f172a;
        transition: all 0.3s ease;
    }

    .custom-filter-select:focus {
        border-color: #ff3333;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(255, 51, 51, 0.1);
    }

    /* Custom Radio styling */
    .custom-radio-container {
        display: flex;
        align-items: center;
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        font-size: 0.88rem;
        font-weight: 550;
        color: #334155;
        user-select: none;
        transition: all 0.2s ease;
    }
    
    .custom-radio-container:hover {
        color: #ff3333;
    }
    
    .custom-radio-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    
    .custom-radio-checkmark {
        position: absolute;
        top: 2px;
        left: 0;
        height: 18px;
        width: 18px;
        background-color: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 50%;
        transition: all 0.2s ease;
    }
    
    .custom-radio-container input:checked ~ .custom-radio-checkmark {
        background-color: #ff3333;
        border-color: #ff3333;
        box-shadow: 0 0 6px rgba(255, 51, 51, 0.3);
    }
    
    .custom-radio-checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    
    .custom-radio-container input:checked ~ .custom-radio-checkmark:after {
        display: block;
    }
    
    .custom-radio-container .custom-radio-checkmark:after {
        top: 5px;
        left: 5px;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: white;
    }

    /* Apply button style */
    .filter-apply-btn {
        background: linear-gradient(135deg, #ff3333, #c21a1a);
        border: none;
        box-shadow: 0 5px 15px rgba(255, 51, 51, 0.25);
    }
    
    .filter-apply-btn:hover {
        background: linear-gradient(135deg, #e02424, #a81313);
        box-shadow: 0 8px 20px rgba(255, 51, 51, 0.4);
    }

    /* Listing Car Card Improvements */
    .car-card {
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03) !important;
    }
    
    .car-img-hover {
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    
    .car-card:hover .car-img-hover {
        transform: scale(1.08);
    }

    .price-pill {
        background: rgba(13, 17, 23, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: #fff;
        font-weight: 800;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 0.88rem;
        display: inline-block;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .price-day {
        font-size: 0.68rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.6);
    }

    .spec-bubble {
        background: #f8fafc;
        border: 1.5px solid #f1f5f9;
        border-radius: 12px;
        padding: 8px;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .car-card:hover .spec-bubble {
        border-color: rgba(255, 51, 51, 0.12);
        background: rgba(255, 51, 51, 0.01);
    }

    .spec-bubble i {
        color: #ff4d4d;
        font-size: 0.8rem;
    }
    
    .spec-bubble span {
        font-size: 0.68rem;
        font-weight: 700;
        color: #475569;
        margin-top: 3px;
    }

    .car-details-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    
    .car-card:hover .car-details-btn {
        background: #ff3333 !important;
        border-color: #ff3333 !important;
        box-shadow: 0 6px 20px rgba(255, 51, 51, 0.3);
    }
    
    .car-card:hover .btn-arrow {
        opacity: 1 !important;
        transform: translateX(3px);
    }
</style>
@endsection
