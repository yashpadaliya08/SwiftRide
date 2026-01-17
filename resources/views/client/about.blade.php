@extends('client.layout')

@section('title', 'About Our Journey')

@section('content')
<!-- Hero Header -->
<section class="py-5 bg-dark text-white text-center position-relative overflow-hidden" style="padding-top: 80px !important; padding-bottom: 80px !important;">
    <div class="position-absolute inset-0 opacity-20" style="background: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=2083&auto=format&fit=crop') center/cover no-repeat;"></div>
    <div class="container position-relative" data-aos="fade-down">
        <h1 class="display-3 fw-black mb-3">Redefining <span class="text-primary">Mobility</span></h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 600px;">SwiftRide is more than just a car rental service. We are your partners in every journey, providing excellence since 2024.</p>
    </div>
</section>

<div class="container py-5">
    <!-- Story Section -->
    <div class="row align-items-center g-5 py-5">
        <div class="col-lg-6" data-aos="fade-right">
            <h5 class="text-primary fw-bold mb-2">Our Story</h5>
            <h2 class="display-5 fw-black text-dark mb-4">Born from a Passion for Exploration</h2>
            <p class="text-muted lead mb-4">Founded in Mumbai, SwiftRide started with a simple idea: making premium car rentals accessible, transparent, and hassle-free.</p>
            <p class="text-muted mb-5">Today, we manage a diverse fleet of hundreds of vehicles, ranging from daily commuters to luxury exotics, ensuring that every customer finds their perfect match.</p>
            
            <div class="row g-4">
                <div class="col-6">
                    <h3 class="fw-bold text-dark mb-0">120+</h3>
                    <small class="text-muted text-uppercase fw-bold x-small tracking-wider">Vehicles</small>
                </div>
                <div class="col-6">
                    <h3 class="fw-bold text-dark mb-0">50k+</h3>
                    <small class="text-muted text-uppercase fw-bold x-small tracking-wider">Trips Completed</small>
                </div>
            </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=2070&auto=format&fit=crop" class="img-fluid rounded-5 shadow-lg" alt="Our Story">
                <div class="position-absolute top-100 start-0 translate-middle-y ms-5 p-4 bg-white shadow-lg rounded-4 d-none d-md-block" style="width: 250px;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary text-white rounded-circle p-3">
                            <i class="fas fa-award"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">99.9%</h6>
                            <small class="text-muted">Satisfaction</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Values -->
    <div class="py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h5 class="text-primary fw-bold mb-2">Our Values</h5>
            <h2 class="display-5 fw-black text-dark">The Pillars of SwiftRide</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm rounded-4 p-5 h-100 text-center hover-lift">
                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 70px; height: 70px;">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Safety First</h4>
                    <p class="text-muted mb-0">Rigorous safety checks and regular maintenance for every single vehicle in our fleet.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm rounded-4 p-5 h-100 text-center hover-lift">
                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 70px; height: 70px;">
                        <i class="fas fa-hand-holding-usd fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Transparent Pricing</h4>
                    <p class="text-muted mb-0">What you see is what you pay. No hidden fees, no surge pricing, just honest rentals.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm rounded-4 p-5 h-100 text-center hover-lift">
                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 70px; height: 70px;">
                        <i class="fas fa-bolt fa-2x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Instant Freedom</h4>
                    <p class="text-muted mb-0">Pick up your car from dozens of locations or have it delivered right to your doorstep.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Meet the Team -->
    <div class="py-5 mb-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h5 class="text-primary fw-bold mb-2">Our People</h5>
            <h2 class="display-5 fw-black text-dark">Driven by Passion</h2>
        </div>
        
        <div class="row g-4 justify-content-center">
            @foreach([
                ['name' => 'Yash Padaliya', 'role' => 'Founder & CEO', 'img' => 'https://i.pravatar.cc/150?u=yash'],
                ['name' => 'Sarah Collins', 'role' => 'Operations Director', 'img' => 'https://i.pravatar.cc/150?u=sarah'],
                ['name' => 'David Miller', 'role' => 'Head of Fleet', 'img' => 'https://i.pravatar.cc/150?u=david'],
            ] as $member)
            <div class="col-lg-3 col-md-6 text-center" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="mb-4 d-inline-block position-relative">
                    <img src="{{ $member['img'] }}" class="rounded-circle shadow-lg" width="150" alt="{{ $member['name'] }}">
                    <div class="position-absolute bottom-0 start-100 translate-middle p-2 bg-primary rounded-circle text-white shadow">
                        <i class="fab fa-linkedin-in"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-1">{{ $member['name'] }}</h5>
                <p class="text-muted small text-uppercase fw-bold">{{ $member['role'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- CTA -->
<section class="py-5 bg-light">
    <div class="container text-center py-5" data-aos="fade-up">
        <h2 class="display-5 fw-black mb-4">Join the SwiftRide Community</h2>
        <p class="lead text-muted mb-5 mx-auto" style="max-width: 600px;">Stay updated with our latest offers, new fleet additions, and travel stories.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm">Get Started</a>
            <a href="{{ route('contact') }}" class="btn btn-outline-dark rounded-pill px-5 py-3 fw-bold">Contact Us</a>
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
    .fw-black { font-weight: 900 !important; }
    .x-small { font-size: 0.65rem; }
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
    .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
</style>
@endsection
