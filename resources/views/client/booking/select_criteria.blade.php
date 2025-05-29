@extends('client.layout')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 theme-accent">Search Available Cars</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ✅ FORM SUBMITS TO booking.handleSearch (POST) -->
        <form action="{{ route('booking.handleSearch') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="pickup_city" class="form-label">Pickup City</label>
                    <input type="text" name="pickup_city" id="pickup_city" class="form-control" value="{{ old('pickup_city') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="dropoff_city" class="form-label">Dropoff City</label>
                    <input type="text" name="dropoff_city" id="dropoff_city" class="form-control" value="{{ old('dropoff_city') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time') }}" required>
                </div>
            </div>

            <button type="submit" class="btn btn-theme">Find Cars</button>
        </form>
    </div>
@endsection
