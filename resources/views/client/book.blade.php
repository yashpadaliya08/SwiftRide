@extends('client.layout')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-center text-theme">Book Your Ride</h2>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($car)
            <div class="card mb-5 shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-5 d-flex align-items-stretch">
                        @if($car->image)
                            <img src="{{ asset('storage/' . $car->image) }}"
                                class="img-fluid w-100 h-100 object-fit-cover rounded-start" alt="{{ $car->model }}">
                        @else
                            <img src="https://via.placeholder.com/400x300?text=No+Image"
                                class="img-fluid w-100 h-100 object-fit-cover rounded-start" alt="No Image">
                        @endif
                    </div>
                    <div class="col-md-7 p-4">
                        <h4 class="fw-bold">{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</h4>
                        <ul class="list-unstyled mb-2 mt-3">
                            <li><strong>Color:</strong> {{ $car->color }}</li>
                            <li><strong>Type:</strong> {{ $car->type ?? 'N/A' }}</li>
                            <li><strong>Price Per Day:</strong> ₹{{ number_format($car->price_per_day) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-danger text-center">Car information not found.</div>
        @endif

        @if($car)
            <div class="card shadow-lg border-0 rounded-4 p-4 bg-light">
                <form action="{{ route('booking.store') }}" method="POST" class="row g-3" id="bookingForm">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="Your full name"
                            value="{{ old('name') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required placeholder="example@email.com"
                            value="{{ old('email') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" required placeholder="+91XXXXXXXXXX"
                            value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="pickup_city" class="form-label">Pickup City</label>
                        <input type="text" name="pickup_city" class="form-control" required placeholder="Enter pickup city"
                            value="{{ old('pickup_city') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="dropoff_city" class="form-label">Dropoff City</label>
                        <input type="text" name="dropoff_city" class="form-control" required placeholder="Enter dropoff city"
                            value="{{ old('dropoff_city') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Pickup Date</label>
                        <input type="date" name="start_date" class="form-control" required value="{{ old('start_date') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="start_time" class="form-label">Pickup Time</label>
                        <input type="time" name="start_time" class="form-control" required value="{{ old('start_time') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="end_date" class="form-label">Return Date</label>
                        <input type="date" name="end_date" class="form-control" required value="{{ old('end_date') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="end_time" class="form-label">Return Time</label>
                        <input type="time" name="end_time" class="form-control" required value="{{ old('end_time') }}">
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-theme px-4">Confirm Booking</button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- 🌟 Custom Styling -->
    <style>
        .text-theme {
            color: #e74c3c;
        }

        .btn-theme {
            background-color: #e74c3c;
            color: white;
            border: none;
        }

        .btn-theme:hover {
            background-color: #c0392b;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .img-fluid {
            height: 100%;
            max-height: 300px;
        }

        @media (max-width: 768px) {
            .img-fluid {
                max-height: 250px;
            }
        }

        /* Validation styles */
        .is-valid {
            border-color: #28a745 !important;
            background-color: #e6ffed;
        }

        .is-invalid {
            border-color: #dc3545 !important;
            background-color: #ffe6e6;
        }

        .invalid-feedback {
            color: #dc3545;
            font-weight: 500;
            margin-top: 0.25rem;
        }

        .valid-feedback {
            color: #28a745;
            font-weight: 500;
            margin-top: 0.25rem;
        }

        .animated {
            animation-duration: 0.4s;
            animation-fill-mode: both;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fadeInDown {
            animation-name: fadeInDown;
        }
    </style>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- jQuery & Validation Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#bookingForm").validate({
                rules: {
                    name: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    phone: "required",
                    start_date: "required",
                    start_time: "required",
                    end_date: "required",
                    end_time: "required"
                },
                messages: {
                    name: "Please enter your full name",
                    email: "Please enter a valid email address",
                    phone: "Please enter your phone number",
                    start_date: "Please select a pickup date",
                    start_time: "Please select a pickup time",
                    end_date: "Please select a return date",
                    end_time: "Please select a return time"
                },
                errorElement: "div",
                errorClass: "invalid-feedback animated fadeInDown",
                highlight: function (element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                success: function (label) {
                    label.addClass("valid-feedback").html('<i class="fas fa-check-circle text-success me-1"></i> Looks good!');
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
@endsection