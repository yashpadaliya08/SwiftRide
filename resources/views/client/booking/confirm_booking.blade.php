@extends('client.layout')

@section('title', 'Confirm Your Trip')

@section('content')
<div class="container py-5">
    <!-- Stepper -->
    <div class="row justify-content-center mb-5" data-aos="fade-down">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between position-relative">
                <div class="text-center position-relative" style="z-index: 2;">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow" style="width: 40px; height: 40px;"><i class="fas fa-check"></i></div>
                    <small class="fw-bold text-muted">Select</small>
                </div>
                <div class="text-center position-relative" style="z-index: 2;">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow" style="width: 40px; height: 40px;">2</div>
                    <small class="fw-bold">Confirm</small>
                </div>
                <div class="text-center position-relative" style="z-index: 2;">
                    <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px;">3</div>
                    <small class="fw-bold text-muted">Pay</small>
                </div>
                <!-- Progress Line -->
                <div class="position-absolute top-0 start-0 w-100 mt-3" style="height: 2px; background: #e9ecef; z-index: 1;">
                    <div class="bg-primary h-100" style="width: 50%;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5">
        <!-- Left: Summary -->
        <div class="col-lg-5" data-aos="fade-right">
            <h4 class="fw-bold mb-4">Trip Summary</h4>
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-body p-4">
                    <!-- Car Preview -->
                    <div class="d-flex align-items-center mb-4 pb-4 border-bottom">
                         @if($car->image)
                            <img src="{{ asset('storage/' . $car->image) }}" class="rounded-3 me-3" style="width: 100px; height: 70px; object-fit: cover;">
                        @endif
                        <div>
                            <h5 class="fw-bold mb-0">{{ $car->brand }} {{ $car->model }}</h5>
                            <small class="text-muted">{{ $car->type }} • {{ $car->year }}</small>
                        </div>
                    </div>

                    <!-- Itinerary Timeline -->
                    <div class="position-relative ps-4 mb-4">
                        <div class="position-absolute start-0 top-0 h-100 border-start border-2 border-primary opacity-25" style="left: 7px !important;"></div>
                        
                        <div class="mb-4 position-relative">
                            <div class="position-absolute rounded-circle bg-primary" style="width: 14px; height: 14px; left: -31px; top: 4px;"></div>
                            <div class="small fw-bold text-muted text-uppercase mb-1">Pick-up</div>
                            <div class="fw-bold">{{ $pickup_city }}</div>
                            <div class="small">{{ $start->format('d M Y') }}</div>
                        </div>

                        <div class="position-relative">
                            <div class="position-absolute rounded-circle bg-danger" style="width: 14px; height: 14px; left: -31px; top: 4px;"></div>
                            <div class="small fw-bold text-muted text-uppercase mb-1">Drop-off</div>
                            <div class="fw-bold">{{ $dropoff_city }}</div>
                            <div class="small">{{ $end->format('d M Y') }}</div>
                        </div>
                    </div>

                    <!-- Pricing Details -->
                    <div class="bg-light rounded-4 p-3 vstack gap-2">
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted">Duration</span>
                            <span class="fw-bold">{{ $start->diffInDays($end) + 1 }} Days</span>
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted">Rate / Day</span>
                            <span class="fw-bold">₹{{ number_format($car->price_per_day) }}</span>
                        </div>
                        <div class="border-top mt-2 pt-2 d-flex justify-content-between align-items-center" id="discount-row" style="display: none !important;">
                            <span class="text-success small">Discount</span>
                            <span class="text-success fw-bold" id="discount-amount">-₹0</span>
                        </div>
                        <div class="border-top mt-2 pt-2 d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total Amount</span>
                            <span class="h4 fw-bold text-primary mb-0" id="final-total">₹{{ number_format($total) }}</span>
                        </div>
                    </div>

                    <!-- Promo Code Input -->
                    <div class="mt-4 pt-3 border-top">
                        <label class="form-label small fw-bold text-muted text-uppercase">Have a promo code?</label>
                        <div class="input-group">
                            <input type="text" id="coupon_input" class="form-control bg-light border-0" placeholder="Enter code">
                            <button class="btn btn-dark px-3" type="button" id="apply_coupon_btn">Apply</button>
                        </div>
                        <div id="coupon_msg" class="x-small mt-2"></div>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('booking.available') }}?pickup_city={{ $pickup_city }}&dropoff_city={{ $dropoff_city }}&start_date={{ $start_date }}&start_time={{ $start_time }}&end_date={{ $end_date }}&end_time={{ $end_time }}" class="text-decoration-none small fw-bold"><i class="fas fa-arrow-left me-2"></i>Choose a different car</a>
        </div>

        <!-- Right: Booking Form -->
        <div class="col-lg-7" data-aos="fade-left">
            <h4 class="fw-bold mb-4">Your Information</h4>
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                 @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-3 small">{{ session('error') }}</div>
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
                    <input type="hidden" name="coupon_code" id="hidden_coupon_code">

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" name="name" class="form-control bg-light border-0" 
                                   value="{{ old('name', auth()->user()->name ?? '') }}" placeholder="Enter your full name" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-0" 
                                   value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="Enter your email" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Phone Number</label>
                        <div class="input-group px-3 bg-light rounded-2">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-phone text-muted"></i></span>
                            <input type="text" name="phone" class="form-control bg-light border-0" 
                                   value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="Enter mobile number" required>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label small text-muted" for="terms">
                            I agree to the <a href="#" class="text-decoration-none">Rental Agreement</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>.
                        </label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm py-3">
                            Confirm & Proceed to Payment
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="text-center mt-4">
                 <div class="d-flex justify-content-center gap-4 opacity-50">
                    <div class="text-center"><i class="fas fa-shield-alt fa-lg mb-1"></i><div class="small">Secure</div></div>
                    <div class="text-center"><i class="fas fa-bolt fa-lg mb-1"></i><div class="small">Instant</div></div>
                    <div class="text-center"><i class="fas fa-headset fa-lg mb-1"></i><div class="small">Support</div></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
        // Minimal validation styling
        $(document).ready(function () {
             $('#bookingForm').validate({
                errorClass: 'text-danger small mt-1',
                errorElement: 'div'
            });

            $('#apply_coupon_btn').on('click', function() {
                const code = $('#coupon_input').val();
                if(!code) return;

                const btn = $(this);
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    url: '{{ route('coupons.apply') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        code: code,
                        amount: {{ $total }}
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#discount-row').attr('style', 'display: flex !important;');
                            $('#discount-amount').text('-₹' + response.discount.toLocaleString());
                            $('#final-total').text('₹' + response.new_total.toLocaleString());
                            $('#hidden_coupon_code').val(code);
                            $('#coupon_msg').removeClass('text-danger').addClass('text-success').text(response.message);
                            $('#coupon_input').prop('readonly', true);
                            btn.hide();
                        } else {
                            $('#coupon_msg').removeClass('text-success').addClass('text-danger').text(response.message);
                        }
                    },
                    error: function() {
                        $('#coupon_msg').addClass('text-danger').text('Error applying coupon.');
                    },
                    complete: function() {
                        btn.prop('disabled', false).text('Apply');
                    }
                });
            });
        });
    </script>
@endsection
