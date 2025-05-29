@extends('client.layout')

@section('title', 'Home')

@section('content')

<!-- 🚀 Hero Banner -->
<section class="text-center py-5 bg-white w-100">
    <div class="px-3 px-md-5">
        <h1 id="typing-text" class="display-4 fw-bold text-danger mb-3"></h1>
        <p class="lead mt-3 text-secondary">Find the perfect car for your journey — anytime, anywhere.</p>
        <a href="{{ route('booking.selectCriteria') }}" class="btn btn-theme btn-lg mt-4 shadow-sm">Browse Available Cars</a>
    </div>
</section>

<!-- 🚗 How It Works -->
<section class="py-5 bg-light text-center w-100">
    <div class="px-3 px-md-5">
        <h2 class="mb-4 fw-semibold text-dark">How It Works</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 shadow-sm bg-white rounded h-100 hover-shadow">
                    <h4 class="theme-accent">1. Choose Your Car</h4>
                    <p>Select from a wide range of cars for any occasion.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 shadow-sm bg-white rounded h-100 hover-shadow">
                    <h4 class="theme-accent">2. Book Instantly</h4>
                    <p>Pick a date, confirm your booking — done in minutes.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 shadow-sm bg-white rounded h-100 hover-shadow">
                    <h4 class="theme-accent">3. Drive & Enjoy</h4>
                    <p>Pick up your car and hit the road hassle-free.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🏆 Why Choose SwiftRide -->
<section class="py-5 text-center w-100 bg-white">
    <div class="px-3 px-md-5">
        <h2 class="mb-4 fw-semibold text-dark">Why Choose SwiftRide?</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="p-3 border rounded h-100 bg-light hover-shadow">
                    <h5 class="theme-accent">Affordable Rates</h5>
                    <p>Transparent pricing with no hidden fees.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 border rounded h-100 bg-light hover-shadow">
                    <h5 class="theme-accent">24/7 Support</h5>
                    <p>We're always here to assist you anytime.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 border rounded h-100 bg-light hover-shadow">
                    <h5 class="theme-accent">Easy Pickup</h5>
                    <p>Multiple locations for convenient access.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 border rounded h-100 bg-light hover-shadow">
                    <h5 class="theme-accent">Quality Vehicles</h5>
                    <p>Clean, well-maintained, and reliable cars.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🧍 Testimonials -->
<section class="py-5 bg-light w-100">
    <div class="px-3 px-md-5 text-center">
        <h2 class="mb-5">What Our Customers Say</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded shadow-sm hover-shadow">
                    <p class="fst-italic">“Easy booking and amazing car condition. Loved it!”</p>
                    <h6 class="mt-3 mb-0">- Priya Patel</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded shadow-sm hover-shadow">
                    <p class="fst-italic">“Great rates, quick support, and smooth pickup!”</p>
                    <h6 class="mt-3 mb-0">- Rahul Desai</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded shadow-sm hover-shadow">
                    <p class="fst-italic">“Definitely my go-to car rental app from now on.”</p>
                    <h6 class="mt-3 mb-0">- Meera Joshi</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 📞 CTA -->
<section class="py-5 text-center theme-accent-bg w-100">
    <div class="px-3 px-md-5">
        <h2 class="fw-bold">Ready to ride?</h2>
        <p class="lead">Find your perfect car now and enjoy your journey.</p>
        <a href="{{ url('/browse') }}" class="btn btn-light btn-lg mt-3 shadow-sm">Start Browsing</a>
    </div>
</section>

<!-- 🧠 Typing Animation Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const text = "SwiftRide - Rent Smarter, Drive Faster";
        const typingTarget = document.getElementById("typing-text");
        let index = 0;
        let isDeleting = false;
        let speed = 100;

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

<!-- 🌟 Custom Theme Styling -->
<style>
    .theme-accent {
        color: #e74c3c !important;
    }

    .theme-accent-bg {
        background-color: #e74c3c !important;
        color: #fff;
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

    .hover-shadow {
        transition: all 0.4s ease-in-out;
    }

    .hover-shadow:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        transform: scale(1.03);
    }
</style>

@endsection
