@extends('client.layout')

@section('title', 'Home')

@section('content')

<!-- 🚀 Hero Banner -->
<section class="text-center py-5 bg-white w-100">
    <div class="container px-3 px-md-5">
        <h1 id="typing-text" class="display-4 fw-bold text-danger mb-3" aria-live="polite" aria-atomic="true"></h1>
        <p class="lead mt-3 text-secondary">Find the perfect car for your journey — anytime, anywhere.</p>
        <a href="{{ route('booking.selectCriteria') }}" class="btn btn-theme btn-lg mt-4 shadow-sm" role="button" aria-label="Browse Available Cars">Browse Available Cars</a>
    </div>
</section>

<!-- 🚘 Our Cars -->
<section class="py-5 text-center bg-white w-100">
    <div class="container px-3 px-md-5">
        <h2 class="mb-4 fw-semibold text-dark">Our Popular Cars</h2>
        <div class="row g-4 justify-content-center">
            @foreach($cars as $car)
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100 shadow-sm border-0 hover-shadow">
                    <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" alt="{{ $car->name ?? 'Car image' }}">
                    <div class="card-body">
                        <h5 class="card-title text-truncate" title="{{ $car->name }}">{{ $car->name }}</h5>
                        <p class="fw-semibold theme-accent">₹{{ number_format($car->price_per_day) }}/day</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 🚗 How It Works -->
<section class="py-5 bg-light text-center w-100">
    <div class="container px-3 px-md-5">
        <h2 class="mb-4 fw-semibold text-dark">How It Works</h2>
        <div class="row g-4">
            @foreach([
                ['title' => '1. Choose Your Car', 'desc' => 'Select from a wide range of cars for any occasion.', 'delay' => 0],
                ['title' => '2. Book Instantly', 'desc' => 'Pick a date, confirm your booking — done in minutes.', 'delay' => 100],
                ['title' => '3. Drive & Enjoy', 'desc' => 'Pick up your car and hit the road hassle-free.', 'delay' => 200],
            ] as $step)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $step['delay'] }}">
                <div class="p-4 shadow-sm bg-white rounded h-100 hover-shadow">
                    <h4 class="theme-accent">{{ $step['title'] }}</h4>
                    <p>{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 🏆 Why Choose SwiftRide -->
<section class="py-5 text-center w-100 bg-white">
    <div class="container px-3 px-md-5">
        <h2 class="mb-4 fw-semibold text-dark">Why Choose SwiftRide?</h2>
        <div class="row g-4">
            @foreach([
                ['title' => 'Affordable Rates', 'desc' => 'Transparent pricing with no hidden fees.', 'delay' => 0],
                ['title' => '24/7 Support', 'desc' => "We're always here to assist you anytime.", 'delay' => 100],
                ['title' => 'Easy Pickup', 'desc' => 'Multiple locations for convenient access.', 'delay' => 200],
                ['title' => 'Quality Vehicles', 'desc' => 'Clean, well-maintained, and reliable cars.', 'delay' => 300],
            ] as $feature)
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="{{ $feature['delay'] }}">
                <div class="p-3 border rounded h-100 bg-light hover-shadow">
                    <h5 class="theme-accent">{{ $feature['title'] }}</h5>
                    <p>{{ $feature['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 🧍 Testimonials -->
<section class="py-5 bg-light w-100">
    <div class="container px-3 px-md-5 text-center">
        <h2 class="mb-5">What Our Customers Say</h2>
        <div class="row g-4">
            @foreach([
                ['text' => 'Easy booking and amazing car condition. Loved it!', 'name' => 'Priya Patel', 'animation' => 'fade-right'],
                ['text' => 'Great rates, quick support, and smooth pickup!', 'name' => 'Rahul Desai', 'animation' => 'fade-up'],
                ['text' => 'Definitely my go-to car rental app from now on.', 'name' => 'Meera Joshi', 'animation' => 'fade-left'],
            ] as $testimonial)
            <div class="col-md-4" data-aos="{{ $testimonial['animation'] }}">
                <div class="p-4 bg-white rounded shadow-sm hover-shadow">
                    <p class="fst-italic">“{{ $testimonial['text'] }}”</p>
                    <h6 class="mt-3 mb-0">- {{ $testimonial['name'] }}</h6>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 📞 CTA -->
<section class="py-5 text-center theme-accent-bg w-100">
    <div class="container px-3 px-md-5">
        <h2 class="fw-bold">Ready to ride?</h2>
        <p class="lead">Find your perfect car now and enjoy your journey.</p>
        <a href="{{ url('/browse') }}" class="btn btn-light btn-lg mt-3 shadow-sm" role="button" aria-label="Start Browsing">Start Browsing</a>
    </div>
</section>

<!-- 💬 WhatsApp Button -->
<a href="https://wa.me/91XXXXXXXXXX" class="btn btn-success position-fixed bottom-0 end-0 m-4 shadow rounded-circle" style="z-index:999;" aria-label="Chat on WhatsApp">
    <i class="bi bi-whatsapp fs-4"></i>
</a>

<!-- 🔤 Typing Animation -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const text = "SwiftRide - Rent Smarter, Drive Faster";
        const typingTarget = document.getElementById("typing-text");
        let index = 0, isDeleting = false, speed = 100;

        function typeLoop() {
            if (!isDeleting) {
                typingTarget.textContent = text.substring(0, index + 1);
                index++;
                if (index === text.length) {
                    isDeleting = true;
                    setTimeout(typeLoop, 2000);
                    return;
                }
            } else {
                typingTarget.textContent = text.substring(0, index - 1);
                index--;
                if (index === 0) {
                    isDeleting = false;
                    setTimeout(typeLoop, 800);
                    return;
                }
            }
            setTimeout(typeLoop, speed);
        }

        typeLoop();
    });
</script>

<!-- 🌟 AOS (Animate On Scroll) -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>

<!-- 🎨 Custom Theme Styling -->
<style>
    .theme-accent { color: #e74c3c !important; }
    .theme-accent-bg { background-color: #e74c3c !important; color: #fff; }
    .btn-theme { background-color: #e74c3c; color: #fff; border: none; transition: background-color 0.3s ease; }
    .btn-theme:hover, .btn-theme:focus {
        background-color: #c0392b;
        color: #fff;
        outline: none;
        box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.5);
    }
    .hover-shadow {
        transition: all 0.4s ease-in-out;
        cursor: pointer;
    }
    .hover-shadow:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        transform: scale(1.03);
    }
</style>

@endsection
