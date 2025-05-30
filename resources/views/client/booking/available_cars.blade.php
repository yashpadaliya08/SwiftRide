@extends('client.layout')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 theme-accent" data-aos="fade-right">Available Cars</h2>

        @if(count($availableCars) > 0)
            <div class="row">
                @foreach($availableCars as $car)
                    <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card h-100 shadow-sm border-0 car-card transition-hover">
                            <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top rounded-top" alt="{{ $car->model }}"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                                <p class="card-text mb-1">🚗 Seats: {{ $car->seats }}</p>
                                <p class="card-text mb-3">💰 ₹{{ number_format($car->price_per_day, 2) }} / day</p>

                                <form action="{{ route('booking.confirm') }}" method="POST" class="mt-auto">
                                    @csrf
                                    <input type="hidden" name="pickup_city" value="{{ $pickup_city }}">
                                    <input type="hidden" name="dropoff_city" value="{{ $dropoff_city }}">
                                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                                    <input type="hidden" name="start_time" value="{{ $start_time }}">
                                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                                    <input type="hidden" name="end_time" value="{{ $end_time }}">
                                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                                    <button type="submit" class="btn btn-theme w-100">Book Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning" role="alert" data-aos="fade-in">
                🚫 No cars available for the selected dates.
            </div>
        @endif
    </div>
@endsection

@section('styles')
    <style>
        .car-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .btn-theme {
            background-color: #007bff;
            border: none;
            color: white;
        }

        .btn-theme:hover {
            background-color: #0056b3;
        }
    </style>
@endsection

@section('scripts')
    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
@endsection
