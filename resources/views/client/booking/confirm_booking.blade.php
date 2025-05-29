@extends('client.layout')

@section('title', 'Confirm Your Booking')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Confirm Your Booking</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <strong>Booking Summary</strong>
            </div>
            <div class="card-body">
                <p><strong>Car:</strong> {{ $car->brand }} {{ $car->model }} ({{ $car->year }})</p>
                <p><strong>Pickup City:</strong> {{ $pickup_city }}</p>
                <p><strong>Dropoff City:</strong> {{ $dropoff_city }}</p>
                <p><strong>Pickup Date & Time:</strong> {{ $start->format('d M Y, h:i A') }}</p>
                <p><strong>Return Date & Time:</strong> {{ $end->format('d M Y, h:i A') }}</p>
                <p><strong>Duration:</strong> {{ $start->diffInDays($end) + 1 }} day(s)</p>
                <p><strong>Price per Day:</strong> ₹{{ number_format($car->price_per_day, 2) }}</p>
                <hr>
                <h4>Total Price: ₹{{ number_format($total, 2) }}</h4>

            </div>
        </div>

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            {{-- Hidden Booking Fields --}}
            <input type="hidden" name="car_id" value="{{ $car->id }}">
            <input type="hidden" name="pickup_city" value="{{ $pickup_city }}">
            <input type="hidden" name="dropoff_city" value="{{ $dropoff_city }}">
            <input type="hidden" name="start_date" value="{{ $start_date }}">
            <input type="hidden" name="start_time" value="{{ $start_time }}">
            <input type="hidden" name="end_date" value="{{ $end_date }}">
            <input type="hidden" name="end_time" value="{{ $end_time }}">


            {{-- User Input --}}
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', auth()->user()->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', auth()->user()->email ?? '') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Confirm Booking</button>
            <a href="{{ route('booking.selectCriteria') }}" class="btn btn-secondary ms-2">Back</a>
        </form>
    </div>
@endsection