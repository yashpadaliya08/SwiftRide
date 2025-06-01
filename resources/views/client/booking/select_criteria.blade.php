@extends('client.layout')

@section('title', 'Search Available Cars')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 theme-accent">Search Available Cars</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" aria-live="polite">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $cities = ['Rajkot', 'Ahmedabad', 'Vadodara', 'Surat', 'Jamnagar'];
            $bufferHours = 8;
        @endphp

        <form id="bookingForm" action="{{ route('booking.handleSearch') }}" method="POST" novalidate>
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

@section('styles')
    <style>
        form .form-control {
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
        }
        form .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0,123,255,0.5);
            outline: none;
        }
        .btn-theme {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-theme:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        }
        .text-danger {
            opacity: 0;
            animation: fadeIn 0.3s forwards;
            margin-top: 0.25rem;
            font-size: 0.9rem;
        }
        @keyframes fadeIn {
            to { opacity: 1; }
        }
    </style>
@endsection

@section('scripts')
    <!-- jQuery & jQuery Validation -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        $(function () {
            const bufferHours = {{ $bufferHours }};
            const now = new Date();
            const minDateTime = new Date(now.getTime() + bufferHours * 60 * 60 * 1000);

            function formatDate(date) {
                return date.toISOString().split('T')[0];
            }

            function formatTime(date) {
                return date.toTimeString().slice(0, 5);
            }

            $('#start_date').attr('min', formatDate(minDateTime));

            function updateStartTimeMin() {
                const startDateVal = $('#start_date').val();
                const todayStr = formatDate(minDateTime);
                if (startDateVal === todayStr) {
                    $('#start_time').attr('min', formatTime(minDateTime));
                } else {
                    $('#start_time').removeAttr('min');
                }
            }
            updateStartTimeMin();

            $('#start_date').on('change', function () {
                updateStartTimeMin();

                const startDate = $(this).val();
                if (startDate) {
                    $('#end_date').attr('min', startDate);

                    if ($('#end_date').val() && $('#end_date').val() < startDate) {
                        $('#end_date').val('');
                        $('#end_time').val('');
                    }
                } else {
                    $('#end_date').removeAttr('min');
                }
                updateEndTimeMin();
            });

            $('#start_time').on('change', function () {
                const startDate = $('#start_date').val();
                if (startDate) {
                    $('#end_date').attr('min', startDate);
                }
                updateEndTimeMin();
            });

            function updateEndTimeMin() {
                const startDate = $('#start_date').val();
                const startTime = $('#start_time').val();
                const endDate = $('#end_date').val();

                if (!startDate || !startTime || !endDate) {
                    $('#end_time').removeAttr('min');
                    return;
                }

                if (endDate === startDate) {
                    const startDateTime = new Date(`${startDate}T${startTime}`);
                    const minEndTimeDate = new Date(startDateTime.getTime() + 60000);
                    $('#end_time').attr('min', formatTime(minEndTimeDate));

                    const currentEndTime = $('#end_time').val();
                    if (currentEndTime && currentEndTime < formatTime(minEndTimeDate)) {
                        $('#end_time').val('');
                    }
                } else {
                    $('#end_time').removeAttr('min');
                }
            }

            $('#end_date').on('change', updateEndTimeMin);

            // Custom validation rules
            $.validator.addMethod("startAfterBuffer", function (value, element) {
                const startDate = $('#start_date').val();
                const startTime = $('#start_time').val();
                if (!startDate || !startTime) return true;
                const startDateTime = new Date(`${startDate}T${startTime}`);
                const nowBuffer = new Date(new Date().getTime() + bufferHours * 60 * 60 * 1000);
                return startDateTime >= nowBuffer;
            }, `Start date & time must be at least ${bufferHours} hour(s) from now`);

            $.validator.addMethod("endAfterStart", function (value, element) {
                const startDate = $('#start_date').val();
                const startTime = $('#start_time').val();
                const endDate = $('#end_date').val();
                const endTime = $('#end_time').val();
                if (!startDate || !startTime || !endDate || !endTime) return true;
                const startDateTime = new Date(`${startDate}T${startTime}`);
                const endDateTime = new Date(`${endDate}T${endTime}`);
                return endDateTime > startDateTime;
            }, "End date & time must be after start date & time");

            $.validator.addMethod("endAfterBuffer", function (value, element) {
                const endDate = $('#end_date').val();
                const endTime = $('#end_time').val();
                if (!endDate || !endTime) return true;
                const endDateTime = new Date(`${endDate}T${endTime}`);
                const nowBuffer = new Date(new Date().getTime() + bufferHours * 60 * 60 * 1000);
                return endDateTime >= nowBuffer;
            }, `End date & time must be at least ${bufferHours} hour(s) from now`);

            $("#bookingForm").validate({
                rules: {
                    pickup_city: "required",
                    dropoff_city: "required",
                    start_date: {
                        required: true,
                        dateISO: true,
                        startAfterBuffer: true,
                    },
                    start_time: {
                        required: true,
                    },
                    end_date: {
                        required: true,
                        dateISO: true,
                        endAfterStart: true,
                        endAfterBuffer: true,
                    },
                    end_time: {
                        required: true,
                    },
                },
                messages: {
                    pickup_city: "Please select a pickup city",
                    dropoff_city: "Please select a dropoff city",
                    start_date: {
                        required: "Please select a start date",
                        dateISO: "Please enter a valid date",
                    },
                    start_time: {
                        required: "Please select a start time",
                    },
                    end_date: {
                        required: "Please select an end date",
                        dateISO: "Please enter a valid date",
                    },
                    end_time: {
                        required: "Please select an end time",
                    },
                },
                errorClass: "text-danger",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });

            // Real-time validation feedback
            $('#bookingForm input, #bookingForm select').on('input change', function() {
                $(this).valid();
            });
        });
    </script>
@endsection
