@extends('client.layout')

@section('title', 'Search Available Cars')

@section('content')
<div class="container py-5">
    <div class="row align-items-center g-5">
        
        <!-- Left Column: Form -->
        <div class="col-lg-6" data-aos="fade-right">
             <div class="mb-4">
                <span class="badge bg-primary text-white rounded-pill px-3 py-2 mb-2 text-uppercase fw-bold small shadow-sm animate__animated animate__fadeInLeft">Step 1 of 3</span>
                <h1 class="fw-bold display-5 mb-2">Plan your journey</h1>
                <p class="text-muted lead">Choose where and when you want to go.</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-3 icon-link">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form id="bookingForm" action="{{ route('booking.handleSearch') }}" method="POST" novalidate>
                        @csrf
                        
                        <!-- Route Selection -->
                        <div class="position-relative mb-4">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Pick-up Location</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0 text-primary"><i class="fas fa-map-marker-alt"></i></span>
                                    <select name="pickup_city" id="pickup_city" class="form-select bg-light border-start-0 ps-0" required>
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city }}" {{ old('pickup_city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Drop-off Location</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0 text-danger"><i class="fas fa-map-marker-alt"></i></span>
                                    <select name="dropoff_city" id="dropoff_city" class="form-select bg-light border-start-0 ps-0" required>
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city }}" {{ old('dropoff_city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Date Selection -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Start Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="far fa-calendar-alt text-muted"></i></span>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                                </div>
                                <input type="hidden" name="start_time" value="10:00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">End Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="far fa-calendar-check text-muted"></i></span>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
                                </div>
                                <input type="hidden" name="end_time" value="10:00">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg rounded-pill fw-bold shadow-sm py-3 hvr-grow">
                            Find Available Cars <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Hero Image -->
        <div class="col-lg-6 d-none d-lg-block position-relative" data-aos="fade-left">
            <div class="position-absolute top-0 end-0 bg-warning rounded-circle blur-bg" style="width: 300px; height: 300px; opacity: 0.1; filter: blur(50px); z-index: -1;"></div>
            <div class="position-absolute bottom-0 start-0 bg-primary rounded-circle blur-bg" style="width: 200px; height: 200px; opacity: 0.1; filter: blur(40px); z-index: -1;"></div>
            
            <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=2070&auto=format&fit=crop" 
                 class="img-fluid rounded-4 shadow-lg rotate-img" 
                 alt="Driving on a road">
            
            <!-- Float Card -->
            <div class="card position-absolute bottom-0 start-0 m-4 shadow-lg border-0 rounded-4 p-3" style="max-width: 250px;">
                <div class="d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle p-2 me-3"><i class="fas fa-check"></i></div>
                    <div>
                        <h6 class="fw-bold mb-0">Best Rate Guarantee</h6>
                        <small class="text-muted">We price match locally.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <style>
        .hvr-grow { transition: transform 0.2s; }
        .hvr-grow:hover { transform: scale(1.02); }
        .rotate-img { transform: rotate(2deg); transition: transform 0.5s ease; }
        .rotate-img:hover { transform: rotate(0deg); }
        
        .form-select, .form-control {
            border-color: #dee2e6;
            padding: 0.75rem 1rem;
            font-weight: 500;
        }
        .form-select:focus, .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
        .input-group-text { font-size: 1.1rem; }
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

            $('#start_date').attr('min', formatDate(minDateTime));

            $('#start_date').on('change', function () {
                const startDate = $(this).val();
                if (startDate) {
                    $('#end_date').attr('min', startDate);
                    if ($('#end_date').val() && $('#end_date').val() < startDate) {
                        $('#end_date').val('');
                    }
                }
            });

            $("#bookingForm").validate({
                rules: {
                    pickup_city: "required",
                    dropoff_city: "required",
                    start_date: {
                        required: true,
                        dateISO: true,
                    },
                    end_date: {
                        required: true,
                        dateISO: true,
                    },
                },
                messages: {
                    pickup_city: "Please select a pickup city",
                    dropoff_city: "Please select a dropoff city",
                    start_date: {
                        required: "Please select a start date",
                    },
                    end_date: {
                        required: "Please select an end date",
                    },
                },
                errorClass: "text-danger",
                errorPlacement: function(error, element) {
                    error.insertAfter(element.closest('.input-group'));
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
