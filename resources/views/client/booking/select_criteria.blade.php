@extends('client.layout')

@section('title', 'Search Available Cars')

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

        @php
            $cities = ['Rajkot', 'Ahmedabad', 'Vadodara', 'Surat', 'Jamnagar'];
        @endphp

        <!-- ✅ FORM SUBMITS TO booking.handleSearch (POST) -->
        <form id="bookingForm" action="{{ route('booking.handleSearch') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="pickup_city" class="form-label">Pickup City</label>
                    <select name="pickup_city" id="pickup_city" class="form-control" required>
                        <option value="">Select Pickup City</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city }}" {{ old('pickup_city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="dropoff_city" class="form-label">Dropoff City</label>
                    <select name="dropoff_city" id="dropoff_city" class="form-control" required>
                        <option value="">Select Dropoff City</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city }}" {{ old('dropoff_city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
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

@section('scripts')
    <!-- ✅ Include jQuery and jQuery Validation (if not already included in layout) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#bookingForm').validate({
                rules: {
                    pickup_city: { required: true },
                    dropoff_city: { required: true },
                    start_date: { required: true, date: true },
                    start_time: { required: true },
                    end_date: { required: true, date: true },
                    end_time: { required: true }
                },
                messages: {
                    pickup_city: "Please select a pickup city",
                    dropoff_city: "Please select a dropoff city",
                    start_date: "Please select a start date",
                    start_time: "Please select a start time",
                    end_date: "Please select an end date",
                    end_time: "Please select an end time"
                },
                errorClass: 'text-danger',
                errorElement: 'div',
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
