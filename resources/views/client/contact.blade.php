@extends('client.layout')

@section('title', 'Get in Touch')

@section('content')
<!-- Hero Header -->
<section class="py-5 bg-primary text-white text-center position-relative overflow-hidden" style="padding-top: 80px !important; padding-bottom: 80px !important;">
    <div class="container position-relative" data-aos="fade-down">
        <h1 class="display-3 fw-black mb-3">Questions? <span class="opacity-75">Let's Talk</span></h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 600px;">Our dedicated team is ready to assist you with any inquiries about our fleet, bookings, or services.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row g-5 py-5">
        <!-- Contact Info -->
        <div class="col-lg-5" data-aos="fade-right">
            <h2 class="display-6 fw-black text-dark mb-4">Contact Information</h2>
            <p class="text-muted mb-5">Fill out the form and our team will get back to you within 24 hours.</p>
            
            <div class="vstack gap-4 mb-5">
                <div class="d-flex align-items-start gap-3">
                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Phone Number</h6>
                        <p class="text-muted mb-0">+91 98765 43210</p>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3">
                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Email Address</h6>
                        <p class="text-muted mb-0">support@swiftride.com</p>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3">
                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Our Location</h6>
                        <p class="text-muted mb-0">123 Business Hub, BKC, Mumbai - 400051</p>
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div>
                <h6 class="fw-bold text-dark text-uppercase small tracking-widest mb-3">Follow Us</h6>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-outline-primary rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-primary rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-outline-primary rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-outline-primary rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <!-- Contact Form -->
        <div class="col-lg-7" data-aos="fade-left">
            <div class="card border-0 shadow-lg rounded-5 p-4 p-md-5">
                @if($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4 animate__animated animate__shakeX">
                        <ul class="mb-0 small fw-bold">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-4 p-4 mb-4 d-flex align-items-center animate__animated animate__fadeInDown">
                        <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Success!</h6>
                            <p class="mb-0 small text-muted">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" name="name" class="form-control bg-light border-0 py-3" 
                                    value="{{ auth()->check() ? auth()->user()->name : old('name') }}" 
                                    placeholder="John Doe" 
                                    {{ auth()->check() ? 'readonly' : '' }} required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-0 py-3" 
                                    value="{{ auth()->check() ? auth()->user()->email : old('email') }}" 
                                    placeholder="john@example.com" 
                                    {{ auth()->check() ? 'readonly' : '' }} required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Issue Type</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-tag text-muted"></i></span>
                                <select name="issue_type" class="form-select bg-light border-0 py-3 appearance-none" required>
                                    <option value="" disabled selected>Select an issue type</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Booking Issue">Booking Issue</option>
                                    <option value="Payment Issue">Payment Issue</option>
                                    <option value="Feedback">Feedback</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Message</label>
                            <textarea name="message" rows="5" class="form-control bg-light border-0 p-4" placeholder="Your message here..." required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold w-100 py-3 shadow-lg">
                                Send Message <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Map -->
<section class="py-0 px-0 mt-5 overflow-hidden rounded-5 container mb-5 shadow-sm" style="height: 400px;" data-aos="zoom-in">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15082.903822!2d72.845173!3d19.064516!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c8e123f8d21b%3A0xc3910c85b596f2a0!2sBandra%20Kurla%20Complex!5e0!3m2!1sen!2sin!4v1680000000000" 
        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</section>

<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true });
</script>

<style>
    .fw-black { font-weight: 900 !important; }
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1) !important;
        border: 1px solid rgba(13, 110, 253, 0.2) !important;
    }
</style>
@endsection
