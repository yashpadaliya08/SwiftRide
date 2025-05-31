@extends('client.layout')

@section('title', 'Contact Us')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 fw-bold text-primary" data-aos="fade-down">Contact Us</h2>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success" data-aos="fade-in">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" data-aos="fade-in">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('contact.submit') }}" class="row g-4 needs-validation" novalidate>
            @csrf

            <div class="col-md-6" data-aos="fade-right">
                <label for="name" class="form-label fw-semibold">Your Name</label>
                <input type="text" id="name" name="name" 
                       value="{{ Auth::check() ? Auth::user()->name : '' }}" 
                       class="form-control" placeholder="John Doe" required {{ Auth::check() ? 'readonly' : '' }}>
                <div class="invalid-feedback">Please enter your name.</div>
            </div>

            <div class="col-md-6" data-aos="fade-left">
                <label for="email" class="form-label fw-semibold">Your Email</label>
                <input type="email" id="email" name="email" 
                       value="{{ Auth::check() ? Auth::user()->email : '' }}" 
                       class="form-control" placeholder="you@example.com" required {{ Auth::check() ? 'readonly' : '' }}>
                <div class="invalid-feedback">Please provide a valid email address.</div>
            </div>

            <div class="col-md-12" data-aos="zoom-in">
                <label for="issue_type" class="form-label fw-semibold">Select Issue</label>
                <select id="issue_type" name="issue_type" class="form-select" required>
                    <option value="" disabled selected>Select an issue</option>
                    <option value="modify_booking">Modify or Cancel a Booking</option>
                    <option value="car_late">What if the Car is Late?</option>
                    <option value="refund_issues">Payment or Refund Issues</option>
                    <option value="car_not_described">Car Not as Described</option>
                    <option value="report_car_problem">Report a Car Problem</option>
                    <option value="other">Other</option>
                </select>
                <div class="invalid-feedback">Please select an issue type.</div>
            </div>

            <div class="col-12" data-aos="fade-up">
                <label for="message" class="form-label fw-semibold">Message</label>
                <textarea id="message" name="message" class="form-control" rows="5"
                          placeholder="Type your message here..." required></textarea>
                <div class="invalid-feedback">Please enter your message.</div>
            </div>

            <div class="col-12" data-aos="fade-up">
                <button id="submitBtn" type="submit" class="btn btn-primary px-4">
                    <span class="spinner-border spinner-border-sm d-none" id="submitSpinner" role="status" aria-hidden="true"></span>
                    <span>Send Message</span>
                </button>
            </div>

            <div class="col-12 text-muted small mt-2" data-aos="fade-in">
                We aim to respond within 24 hours. For urgent inquiries, call us at +91-9876543210.
            </div>
        </form>
    </div>

    {{-- AOS & Validation Scripts --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            const spinner = document.getElementById('submitSpinner')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    } else {
                        spinner.classList.remove('d-none')
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>

    {{-- AOS Styles --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endsection
