@extends('client.layout')

@section('title', 'About Us')

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="text-center mb-5" data-aos="fade-down">
        <h2 class="fw-bold text-primary">🚘 About SwiftRide</h2>
        <p class="lead mt-3">Experience a smarter, smoother, and safer way to travel with SwiftRide – your trusted car rental partner.</p>
    </div>

    <!-- Mission & Vision -->
    <div class="row mb-5">
        <div class="col-md-6 mb-3" data-aos="fade-right">
            <div class="p-4 border rounded shadow-sm h-100 bg-light">
                <h4 class="text-success">🌟 Our Mission</h4>
                <p class="mt-2">To redefine mobility by offering flexible, convenient, and tech-powered car rental services that empower people to move freely.</p>
            </div>
        </div>
        <div class="col-md-6 mb-3" data-aos="fade-left">
            <div class="p-4 border rounded shadow-sm h-100 bg-light">
                <h4 class="text-info">🚀 Our Vision</h4>
                <p class="mt-2">We envision a future where car rental is as easy as ordering food. With SwiftRide, you're always in the driver’s seat.</p>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="text-center mb-4" data-aos="fade-up">
        <h3 class="fw-bold text-dark">💡 Why Choose SwiftRide?</h3>
    </div>

    <div class="row text-center mb-5">
        <div class="col-md-4 mb-3" data-aos="zoom-in">
            <div class="p-4 border rounded shadow-sm h-100 bg-white">
                <h5 class="text-primary">🔒 Hassle-Free Booking</h5>
                <p class="mt-2">Book your ride in just a few clicks with a seamless online experience.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3" data-aos="zoom-in" data-aos-delay="100">
            <div class="p-4 border rounded shadow-sm h-100 bg-white">
                <h5 class="text-primary">🚗 Premium Fleet</h5>
                <p class="mt-2">Choose from a wide range of clean, well-maintained, and feature-packed cars.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3" data-aos="zoom-in" data-aos-delay="200">
            <div class="p-4 border rounded shadow-sm h-100 bg-white">
                <h5 class="text-primary">📞 24/7 Support</h5>
                <p class="mt-2">Our team is here for you anytime, anywhere. Your comfort is our priority.</p>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="mb-5" data-aos="fade-up">
        <h3 class="text-center fw-bold text-secondary mb-4">💬 What Our Users Say</h3>
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner text-center">
                <div class="carousel-item active">
                    <blockquote class="blockquote">
                        <p>"SwiftRide made our weekend trip smooth and worry-free. Highly recommend!"</p>
                        <footer class="blockquote-footer">Priya Mehta, Mumbai</footer>
                    </blockquote>
                </div>
                <div class="carousel-item">
                    <blockquote class="blockquote">
                        <p>"Great cars, great support. Best rental experience I’ve had so far!"</p>
                        <footer class="blockquote-footer">Aarav Shah, Ahmedabad</footer>
                    </blockquote>
                </div>
                <div class="carousel-item">
                    <blockquote class="blockquote">
                        <p>"Booking and pickup were seamless. Loved the car's condition and service."</p>
                        <footer class="blockquote-footer">Sneha Patil, Pune</footer>
                    </blockquote>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    <!-- Meet the Team -->
    <div class="mb-5" data-aos="fade-up">
        <h3 class="text-center fw-bold text-dark mb-4">👨‍💻 Meet the Team</h3>
        <div class="row justify-content-center">
            <div class="col-md-3 text-center" data-aos="zoom-in">
                <img src="https://i.pravatar.cc/150?img=1" class="rounded-circle mb-3" width="100" alt="Founder">
                <h5 class="fw-bold">Yash Padaliya</h5>
                <p class="text-muted">Founder & Developer</p>
            </div>
            <div class="col-md-3 text-center" data-aos="zoom-in" data-aos-delay="100">
                <img src="https://i.pravatar.cc/150?img=2" class="rounded-circle mb-3" width="100" alt="Support Lead">
                <h5 class="fw-bold">Riya Kapoor</h5>
                <p class="text-muted">Customer Support Lead</p>
            </div>
            <div class="col-md-3 text-center" data-aos="zoom-in" data-aos-delay="200">
                <img src="https://i.pravatar.cc/150?img=3" class="rounded-circle mb-3" width="100" alt="Fleet Manager">
                <h5 class="fw-bold">Vikram Joshi</h5>
                <p class="text-muted">Fleet Manager</p>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="text-center p-5 bg-primary text-white rounded shadow" data-aos="fade-up">
        <h4 class="fw-bold mb-3">Ready to Ride?</h4>
        <p class="mb-4">Start your SwiftRide journey today. Book your car in minutes!</p>
        <a href="{{ route('booking.selectCriteria') }}" class="btn btn-light btn-lg">Book Now</a>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>
@endsection
