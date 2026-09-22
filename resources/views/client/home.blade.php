@extends('client.layout')

@section('title', 'Your Premium Journey Starts Here')

@section('content')
<!-- 🚀 Hero Section -->
<section class="hero-section position-relative overflow-hidden vh-100 d-flex align-items-center" style="margin-top: -90px; z-index: 1;">
    <!-- Background Image with Overlay -->
    <div class="position-absolute inset-0 w-100 h-100" style="background: url('{{ asset('hero_car_luxury_1768655390063.png') }}') center/cover no-repeat;">
        <div class="position-absolute inset-0 w-100 h-100" style="background: radial-gradient(circle at 30% 50%, rgba(13, 17, 23, 0.85) 0%, rgba(9, 13, 22, 0.95) 100%);"></div>
    </div>

    <!-- Glowing Background blobs for Hero -->
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    <div class="container position-relative text-center text-white" data-aos="zoom-in" data-aos-duration="1200">
        <span class="badge bg-primary bg-opacity-25 text-white rounded-pill px-4 py-2 border border-danger border-opacity-50 mb-4 text-uppercase fw-bold small tracking-widest animate__animated animate__fadeInDown" style="letter-spacing: 2px;">
            <i class="fas fa-crown me-2 text-danger"></i>Premium Car Fleet
        </span>
        <h1 class="display-2 fw-black mb-3 text-white tracking-tight animate__animated animate__fadeInUp">
            Drive the <span class="brand-gradient-text">Extraordinary</span>
        </h1>
        <p class="lead mb-5 opacity-75 mx-auto animate__animated animate__fadeInUp" style="max-width: 720px; font-size: 1.15rem; font-weight: 400; line-height: 1.6;">
            Experience ultimate luxury and freedom with SwiftRide. From high-performance sports cars to spacious SUVs, find the perfect companion for your next journey.
        </p>
        
        <!-- Quick Search Box -->
        <div class="card border-0 shadow-lg rounded-5 search-glass-card p-4 mx-auto animate__animated animate__fadeInUp" style="max-width: 960px;" data-aos="fade-up" data-aos-delay="400">
            <form action="{{ route('browse') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="search-input-group px-3 py-2">
                        <span class="search-icon"><i class="fas fa-search"></i></span>
                        <div class="flex-grow-1 text-start">
                            <label class="search-label">Find Vehicle</label>
                            <input type="text" name="search" class="search-control" placeholder="Search brand, model, type (e.g. Toyota, SUV)...">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="search-input-group px-3 py-2">
                        <span class="search-icon"><i class="fas fa-sliders-h"></i></span>
                        <div class="flex-grow-1 text-start">
                            <label class="search-label">Vehicle Type</label>
                            <select name="type" class="search-control bg-transparent border-0 text-white" style="cursor: pointer;">
                                <option value="" class="text-dark">All Vehicle Types</option>
                                <option value="SUV" class="text-dark">SUV</option>
                                <option value="Sedan" class="text-dark">Sedan</option>
                                <option value="Hatchback" class="text-dark">Hatchback</option>
                                <option value="Luxury" class="text-dark">Luxury</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12">
                    <button type="submit" class="btn btn-primary rounded-4 w-100 py-3 fw-bold search-submit-btn">
                        Search Fleet <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- 🚘 Featured Fleet -->
<section class="py-5 bg-white position-relative">
    <div class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5" data-aos="fade-right">
            <div>
                <span class="text-danger fw-bold text-uppercase tracking-wider small d-block mb-2">Our Curated Fleet</span>
                <h2 class="display-5 fw-black text-dark tracking-tight">Selected for Excellence</h2>
            </div>
            <a href="{{ route('browse') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 mt-3 mt-md-0 fw-bold border-2 d-inline-flex align-items-center gap-2">
                Explore All Fleet <i class="fas fa-chevron-right fs-7"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @foreach($cars as $car)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden car-card hover-lift">
                    <!-- Image -->
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <img src="{{ $car->image ? asset('storage/' . $car->image) : 'https://via.placeholder.com/400x250?text=No+Image' }}" 
                             class="card-img-top object-fit-cover w-100 h-100 car-img-hover" 
                             alt="{{ $car->brand }} {{ $car->model }}">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="price-pill shadow-sm">₹{{ number_format($car->price_per_day) }}<span class="price-day">/day</span></span>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-3">
                            <span class="badge bg-light text-muted rounded-pill px-3 py-1 mb-2 fw-semibold" style="font-size: 0.75rem;">{{ $car->type }}</span>
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
            @endforeach
        </div>
    </div>
</section>

<!-- 🧍 Testimonials -->
<section class="py-5 bg-light overflow-hidden position-relative">
    <div class="container py-5 text-center">
        <span class="text-danger fw-bold text-uppercase tracking-wider small d-block mb-2" data-aos="fade-up">Trusted by Thousands</span>
        <h2 class="display-5 fw-black text-dark mb-5 tracking-tight" data-aos="fade-up" data-aos-delay="100">Customer Success Stories</h2>
        
        <div class="row g-4">
            @foreach([
                ['text' => 'The best car rental experience I\'ve ever had. The Porsche 911 was in pristine condition!', 'name' => 'Alex Thompson', 'role' => 'Business Traveler'],
                ['text' => 'Exceptional service and extremely easy booking process. Highly recommended!', 'name' => 'Sarah Johnson', 'role' => 'Driving Enthusiast'],
                ['text' => 'SwiftRide made our family trip unforgettable. The SUV was spacious and very comfortable.', 'name' => 'Michael Chen', 'role' => 'Family Man'],
            ] as $testimonial)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 200 }}">
                <div class="card border-0 shadow-sm rounded-4 p-5 h-100 bg-white hover-lift text-start position-relative overflow-hidden">
                    <div class="quote-glow"></div>
                    <div class="mb-4 text-danger opacity-15">
                        <i class="fas fa-quote-left fa-3x"></i>
                    </div>
                    <p class="mb-4 fst-italic text-dark-50 lh-relaxed" style="font-size: 1.05rem;">"{{ $testimonial['text'] }}"</p>
                    <div class="mt-auto pt-3 border-top border-light d-flex align-items-center gap-3">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 48px; height: 48px;">
                            {{ substr($testimonial['name'], 0, 1) }}
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ $testimonial['name'] }}</h6>
                            <small class="text-muted">{{ $testimonial['role'] }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 📞 Final CTA -->
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="card border-0 bg-dark rounded-5 overflow-hidden shadow-lg position-relative" data-aos="zoom-in-up">
            <div class="cta-glow"></div>
            <div class="row g-0 align-items-center">
                <div class="col-lg-7 p-5 p-md-5 position-relative" style="z-index: 2;">
                    <h2 class="display-4 fw-black text-white mb-3 tracking-tight">Ready to experience the best?</h2>
                    <p class="lead text-white opacity-75 mb-5" style="font-size: 1.1rem;">Join thousands of happy customers and start your premium journey today.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('browse') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold">Book a Ride Now</a>
                        <a href="{{ route('browse') }}" class="btn btn-outline-white border-2 rounded-pill px-5 py-3 fw-bold text-white">Browse Cars</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block position-relative" style="height: 400px;">
                    <div class="position-absolute inset-0" style="background: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=2070&auto=format&fit=crop') center/cover; z-index: 1;"></div>
                    <div class="position-absolute inset-0 bg-gradient-to-r" style="background: linear-gradient(to right, #0d1117, transparent); z-index: 2;"></div>
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
    .brand-gradient-text {
        background: linear-gradient(135deg, #ff4d4d, #3399ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 900;
    }

    /* Hero Glow Blobs */
    .hero-glow-1 {
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 51, 51, 0.15) 0%, transparent 70%);
        top: 10%;
        left: 5%;
        filter: blur(50px);
        z-index: 1;
        pointer-events: none;
    }
    .hero-glow-2 {
        position: absolute;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(51, 153, 255, 0.12) 0%, transparent 70%);
        bottom: 15%;
        right: 10%;
        filter: blur(50px);
        z-index: 1;
        pointer-events: none;
    }

    .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }

    /* Frosted Glass Quick Search */
    .search-glass-card {
        background: rgba(13, 17, 23, 0.65) !important;
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4) !important;
    }

    .search-input-group {
        background: rgba(255, 255, 255, 0.04);
        border-radius: 16px;
        border: 1.5px solid rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .search-input-group:hover, .search-input-group:focus-within {
        border-color: #ff3333;
        background: rgba(255, 255, 255, 0.07);
        box-shadow: 0 0 15px rgba(255, 51, 51, 0.15);
    }

    .search-icon {
        color: #ff4d4d;
        font-size: 1.15rem;
    }

    .search-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.4);
        margin-bottom: 2px;
        letter-spacing: 0.8px;
    }

    .search-control {
        background: transparent;
        border: none;
        color: #fff;
        font-weight: 600;
        font-size: 0.88rem;
        width: 100%;
        outline: none;
    }

    .search-control::placeholder {
        color: rgba(255, 255, 255, 0.25);
    }

    .search-submit-btn {
        background: linear-gradient(135deg, #ff3333, #c21a1a);
        border: none;
        box-shadow: 0 6px 20px rgba(255, 51, 51, 0.35);
        transition: all 0.3s ease;
    }
    
    .search-submit-btn:hover {
        background: linear-gradient(135deg, #e02424, #a81313);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(255, 51, 51, 0.5);
    }

    /* Car Fleet Card Improvements */
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
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.95rem;
        display: inline-block;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .price-day {
        font-size: 0.72rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.6);
    }

    .spec-bubble {
        background: #f8fafc;
        border: 1.5px solid #f1f5f9;
        border-radius: 12px;
        padding: 10px;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .car-card:hover .spec-bubble {
        border-color: rgba(255, 51, 51, 0.15);
        background: rgba(255, 51, 51, 0.01);
    }

    .spec-bubble i {
        color: #ff4d4d;
        font-size: 0.85rem;
    }
    
    .spec-bubble span {
        font-size: 0.72rem;
        font-weight: 700;
        color: #475569;
        margin-top: 4px;
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

    /* Testimonial Quote glow */
    .quote-glow {
        position: absolute;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(255, 51, 51, 0.03) 0%, transparent 70%);
        top: -50px;
        right: -50px;
        pointer-events: none;
    }

    /* CTA Section */
    .cta-glow {
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 51, 51, 0.12) 0%, transparent 70%);
        bottom: -100px;
        left: -100px;
        pointer-events: none;
    }

    .btn-outline-white {
        border-color: rgba(255,255,255,0.15);
        transition: all 0.3s ease;
    }
    
    .btn-outline-white:hover {
        background: #fff;
        color: #0f172a !important;
        border-color: #fff;
        box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
    }
</style>
@endsection
