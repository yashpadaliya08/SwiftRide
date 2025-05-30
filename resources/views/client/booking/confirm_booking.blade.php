@extends('client.layout')

@section('title', 'Confirm Your Booking')

@section('content')
    <div class="container my-5">
        <div class="row g-4 align-items-start">
            <!-- Left: Booking Summary -->
            <div class="col-md-6" data-aos="fade-right">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">🚗 Booking Summary</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><strong>Car:</strong> {{ $car->brand }} {{ $car->model }} ({{ $car->year }})</li>
                            <li><strong>Pickup City:</strong> {{ $pickup_city }}</li>
                            <li><strong>Dropoff City:</strong> {{ $dropoff_city }}</li>
                            <li><strong>Pickup:</strong> {{ $start->format('d M Y, h:i A') }}</li>
                            <li><strong>Return:</strong> {{ $end->format('d M Y, h:i A') }}</li>
                            <li><strong>Duration:</strong> {{ $start->diffInDays($end) + 1 }} day(s)</li>
                            <li><strong>Rate:</strong> ₹{{ number_format($car->price_per_day, 2) }}/day</li>
                        </ul>
                        <div class="mt-3 border-top pt-3">
                            <h4 class="text-success">Total: ₹{{ number_format($total, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Booking Form -->
            <div class="col-md-6" data-aos="fade-left">
                <div class="card shadow border-0 h-100">
                    <div class="card-body">
                        <h5 class="mb-4">👤 Your Details</h5>
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
                            @csrf

                            <!-- Hidden Fields -->
                            <input type="hidden" name="car_id" value="{{ $car->id }}">
                            <input type="hidden" name="pickup_city" value="{{ $pickup_city }}">
                            <input type="hidden" name="dropoff_city" value="{{ $dropoff_city }}">
                            <input type="hidden" name="start_date" value="{{ $start_date }}">
                            <input type="hidden" name="start_time" value="{{ $start_time }}">
                            <input type="hidden" name="end_date" value="{{ $end_date }}">
                            <input type="hidden" name="end_time" value="{{ $end_time }}">

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" id="name" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', auth()->user()->name ?? '') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" id="phone" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('booking.selectCriteria') }}" class="btn btn-outline-secondary">← Back</a>
                                <button type="submit" class="btn btn-primary">Confirm Booking</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        .card-header {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-label {
            font-weight: 500;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 700, once: true });

        $(document).ready(function () {
            $('#bookingForm').validate({
                rules: {
                    name: { required: true, minlength: 2 },
                    email: { required: true, email: true },
                    phone: { required: true, digits: true, minlength: 10 }
                },
                messages: {
                    name: "Enter a valid name",
                    email: "Enter a valid email",
                    phone: "Enter a valid phone number"
                },
                errorClass: 'is-invalid',
                validClass: 'is-valid',
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    error.insertAfter(element);
                }
            });
        });
    </script>
@endsection
