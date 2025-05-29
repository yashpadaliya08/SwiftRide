@extends('client.layout')

@section('content')
    <div class="container">
        <h2 class="my-4">Available Cars</h2>

        @if(count($availableCars) > 0)
            <div class="row">
                @foreach($availableCars as $car)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" alt="{{ $car->model }}"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                                <p class="card-text mb-1">Seats: {{ $car->seats }}</p>
                                <p class="card-text mb-3">Price per day: ₹{{ number_format($car->price_per_day, 2) }}</p>

                                <form action="{{ route('booking.confirm') }}" method="POST" class="mt-auto">
                                    @csrf
                                    {{-- Pass all the booking criteria as hidden inputs --}}
                                    <input type="hidden" name="pickup_city" value="{{ $pickup_city }}">
                                    <input type="hidden" name="dropoff_city" value="{{ $dropoff_city }}">
                                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                                    <input type="hidden" name="start_time" value="{{ $start_time }}">
                                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                                    <input type="hidden" name="end_time" value="{{ $end_time }}">
                                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                                    <button type="submit" class="btn btn-primary w-100">
                                        Book Now
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                No cars available for the selected dates.
            </div>
        @endif
    </div>
@endsection