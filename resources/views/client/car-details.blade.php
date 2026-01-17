@extends('client.layout')

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <!-- Left: Car Details -->
        <div class="col-lg-8" data-aos="fade-right">
            <!-- Header -->
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-dark text-white rounded-pill px-3 py-2 me-3 text-uppercase small fw-bold">{{ $car->year }} Model</span>
                <span class="badge bg-{{ $car->status == 'available' ? 'success' : 'secondary' }} rounded-pill px-3 py-2 text-uppercase small fw-bold">{{ $car->status }}</span>
            </div>
            <h1 class="fw-bold display-5 mb-2">{{ $car->brand }} {{ $car->model }}</h1>
            <p class="text-muted lead mb-4">{{ $car->type }}</p>

            <!-- Main Image -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <img src="{{ $car->image ? asset('storage/' . $car->image) : 'https://via.placeholder.com/800x500?text=No+Image' }}" 
                     class="img-fluid w-100 object-fit-cover" 
                     style="max-height: 500px;" 
                     alt="{{ $car->model }}">
            </div>

            <!-- Specs Grid -->
            <h4 class="fw-bold mb-4">Specifications</h4>
            <div class="row g-3 mb-5">
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-light rounded-4 text-center h-100 border border-light">
                        <i class="fas fa-cogs fa-2x text-primary mb-2 opacity-50"></i>
                        <div class="small text-muted text-uppercase fw-bold">Transmission</div>
                        <div class="fw-bold">{{ $car->transmission }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-light rounded-4 text-center h-100 border border-light">
                        <i class="fas fa-gas-pump fa-2x text-primary mb-2 opacity-50"></i>
                        <div class="small text-muted text-uppercase fw-bold">Fuel Type</div>
                        <div class="fw-bold">{{ $car->fuel_type }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-light rounded-4 text-center h-100 border border-light">
                        <i class="fas fa-users fa-2x text-primary mb-2 opacity-50"></i>
                        <div class="small text-muted text-uppercase fw-bold">Capacity</div>
                        <div class="fw-bold">{{ $car->seats }} Seats</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-light rounded-4 text-center h-100 border border-light">
                        <i class="fas fa-tachometer-alt fa-2x text-primary mb-2 opacity-50"></i>
                        <div class="small text-muted text-uppercase fw-bold">Efficiency</div>
                        <div class="fw-bold">{{ $car->fuel_efficiency ?? 'N/A' }} km/l</div>
                    </div>
                </div>
            </div>

            <!-- Features / Description -->
            <h4 class="fw-bold mb-3">Vehicle Description</h4>
            <p class="text-muted leading-relaxed">
                {{ $car->description ?? 'Experience the ultimate driving comfort with this ' . $car->brand . ' ' . $car->model . '. Perfect for city drives and long weekend getaways. Well maintained and fully serviced to ensure your safety and satisfaction.' }}
            </p>
        </div>

        <!-- Right: Booking Form (Sticky) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 sticky-top" style="top: 2rem; z-index: 10;">
                <div class="card-header bg-primary text-white py-4 px-4 border-0 rounded-top-4">
                    <h5 class="mb-0 text-white-50 small text-uppercase fw-bold">Daily Rate</h5>
                    <h2 class="mb-0 fw-bold">₹{{ number_format($car->price_per_day) }}</h2>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('booking.confirm') }}" method="POST">
                        @csrf
                        <input type="hidden" name="car_id" value="{{ $car->id }}">

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Pick-up City</label>
                            <select name="pickup_city" class="form-select bg-light border-0" required>
                                <option value="">Select City</option>
                                @foreach(['Rajkot', 'Ahmedabad', 'Vadodara', 'Surat', 'Jamnagar'] as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Drop-off City</label>
                            <select name="dropoff_city" class="form-select bg-light border-0" required>
                                <option value="">Select City</option>
                                @foreach(['Rajkot', 'Ahmedabad', 'Vadodara', 'Surat', 'Jamnagar'] as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">Start Date</label>
                                <input type="date" name="start_date" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">Time</label>
                                <input type="time" name="start_time" class="form-control bg-light border-0" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">End Date</label>
                                <input type="date" name="end_date" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">Time</label>
                                <input type="time" name="end_time" class="form-control bg-light border-0" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill py-3 fw-bold shadow-sm">
                                Check Availability & Book
                            </button>
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted"><i class="fas fa-lock me-1"></i> Secure Booking</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>
@endsection
