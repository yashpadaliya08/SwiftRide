@extends('client.layout')

@section('title', 'Your Premium Journey Starts Here')

@section('content')
<!-- 🚀 Hero Section -->
<section class="hero-section position-relative overflow-hidden vh-100 d-flex align-items-center" style="margin-top: -85px; z-index: 1;">
    <!-- Background Image with Overlay -->
    <div class="position-absolute inset-0 w-100 h-100" style="background: url('{{ asset('hero_car_luxury_1768655390063.png') }}') center/cover no-repeat;">
        <div class="position-absolute inset-0 w-100 h-100 bg-dark opacity-40"></div>
        <div class="position-absolute inset-0 w-100 h-100 bg-gradient-to-t from-dark to-transparent opacity-80"></div>
    </div>

    <div class="container position-relative text-center text-white" data-aos="zoom-in" data-aos-duration="1200">
        <span class="badge bg-primary bg-opacity-25 text-white rounded-pill px-4 py-2 border border-white border-opacity-25 mb-4 text-uppercase fw-bold small tracking-widest">Premium Car Rental</span>
        <h1 class="display-1 fw-black mb-4">Drive the <span class="text-primary">Extraordinary</span></h1>
        <p class="lead mb-5 opacity-75 mx-auto" style="max-width: 700px;">Experience ultimate luxury and freedom with SwiftRide. From high-performance sports cars to spacious SUVs, find the perfect companion for your next journey.</p>
        
        <!-- Quick Search Box -->
        <div class="card border-0 shadow-lg rounded-5 bg-white p-3 mx-auto search-glass-card" style="max-width: 900px;" data-aos="fade-up" data-aos-delay="400">
            <form action="{{ route('booking.selectCriteria') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group bg-light rounded-pill px-3 py-1">
                        <span class="input-group-text bg-transparent border-0 text-primary"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text" class="form-control bg-transparent border-0 small" placeholder="Where to pick up?">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group bg-light rounded-pill px-3 py-1">
                        <span class="input-group-text bg-transparent border-0 text-primary"><i class="far fa-calendar"></i></span>
                        <input type="text" class="form-control bg-transparent border-0 small" placeholder="Pick-up date" onfocus="(this.type='date')">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group bg-light rounded-pill px-3 py-1">
                        <span class="input-group-text bg-transparent border-0 text-primary"><i class="far fa-clock"></i></span>
                        <input type="text" class="form-control bg-transparent border-0 small" placeholder="Drop-off date" onfocus="(this.type='date')">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary rounded-pill w-100 py-3 fw-bold shadow-sm">
                        Search <i class="fas fa-search ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- 🚘 Featured Fleet -->
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-right">
            <div>
                <h5 class="text-primary fw-bold mb-2">Our Fleet</h5>
                <h2 class="display-5 fw-black text-dark">Selected for Excellence</h2>
            </div>
            <a href="{{ route('browse') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold">Explore All <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
        
        <div class="row g-4">
            @foreach($cars as $car)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden car-card hover-lift">
                    <!-- Image -->
                    <div class="position-relative">
                        <img src="{{ $car->image ? asset('storage/' . $car->image) : 'https://via.placeholder.com/400x250?text=No+Image' }}" 
                             class="card-img-top object-fit-cover" 
                             style="height: 200px;" 
                             alt="{{ $car->brand }} {{ $car->model }}">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-white text-dark shadow-sm rounded-pill fw-bold">₹{{ number_format($car->price_per_day) }}/day</span>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-3">
                            <h6 class="fw-bold text-dark mb-1">{{ $car->brand }} {{ $car->model }}</h6>
                            <p class="text-muted small mb-0">{{ $car->type }} • {{ $car->year }}</p>
                        </div>
                        
                        <!-- Specs -->
                        <div class="row g-2 mb-4">
                            <div class="col-4">
                                <div class="p-2 border rounded-3 text-center bg-light">
                                    <i class="fas fa-gas-pump text-muted mb-1 d-block" style="font-size: 0.7rem;"></i>
                                    <small class="fw-bold x-small">{{ $car->fuel_type ?? 'Petrol' }}</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 border rounded-3 text-center bg-light">
                                    <i class="fas fa-cog text-muted mb-1 d-block" style="font-size: 0.7rem;"></i>
                                    <small class="fw-bold x-small">{{ $car->transmission ?? 'Auto' }}</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 border rounded-3 text-center bg-light">
                                    <i class="fas fa-user-friends text-muted mb-1 d-block" style="font-size: 0.7rem;"></i>
                                    <small class="fw-bold x-small">{{ $car->seats ?? 5 }} Seats</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('car.details', $car->id) }}" class="btn btn-dark w-100 rounded-pill fw-bold py-2 shadow-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 🧍 Testimonials -->
<section class="py-5 bg-light overflow-hidden">
    <div class="container py-5 text-center">
        <h5 class="text-primary fw-bold mb-2" data-aos="fade-up">Trusted by Thousands</h5>
        <h2 class="display-5 fw-black text-dark mb-5" data-aos="fade-up" data-aos-delay="100">Customer Success Stories</h2>
        
        <div class="row g-4">
            @foreach([
                ['text' => 'The best car rental experience I\'ve ever had. The Porsche 911 was in pristine condition!', 'name' => 'Alex Thompson', 'role' => 'Business Traveler'],
                ['text' => 'Exceptional service and extremely easy booking process. Highly recommended!', 'name' => 'Sarah Johnson', 'role' => 'Driving Enthusiast'],
                ['text' => 'SwiftRide made our family trip unforgettable. The SUV was spacious and very comfortable.', 'name' => 'Michael Chen', 'role' => 'Family Man'],
            ] as $testimonial)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 200 }}">
                <div class="card border-0 shadow-sm rounded-4 p-5 h-100 bg-white hover-lift">
                    <div class="mb-4 text-primary opacity-25">
                        <i class="fas fa-quote-left fa-3x"></i>
                    </div>
                    <p class="mb-4 fst-italic text-dark">{{ $testimonial['text'] }}</p>
                    <div class="mt-auto">
                        <h6 class="fw-bold mb-0 text-dark">{{ $testimonial['name'] }}</h6>
                        <small class="text-muted">{{ $testimonial['role'] }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 📞 Final CTA -->
<section class="py-5">
    <div class="container py-5">
        <div class="card border-0 bg-dark rounded-5 overflow-hidden shadow-lg" data-aos="zoom-in-up">
            <div class="row g-0 align-items-center">
                <div class="col-lg-7 p-5 p-md-5">
                    <h2 class="display-4 fw-black text-white mb-3">Ready to experience the best?</h2>
                    <p class="lead text-white opacity-75 mb-5">Join thousands of happy customers and start your premium journey today.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('booking.selectCriteria') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold">Book a Ride Now</a>
                        <a href="{{ route('browse') }}" class="btn btn-outline-white border-2 rounded-pill px-5 py-3 fw-bold text-white">Browse Cars</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=2070&auto=format&fit=crop" class="img-fluid" style="object-fit: cover; height: 100%;" alt="CTA Car">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true });
</script>

<style>
    .x-small { font-size: 0.65rem; }
    .vh-100 { min-height: 100vh; }
    .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
    
    .bg-gradient-to-t {
        background: linear-gradient(0deg, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
    }
    
    .search-glass-card {
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(20px);
    }
    
    .btn-outline-white {
        border-color: rgba(255,255,255,0.2);
    }
    .btn-outline-white:hover {
        background: white;
        color: black !important;
    }
</style>
@endsection
