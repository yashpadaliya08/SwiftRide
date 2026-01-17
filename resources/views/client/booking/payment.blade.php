@extends('client.layout')

@section('title', 'Secure Payment')

@section('content')
<!-- Animate.css via CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

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
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow" style="width: 40px; height: 40px;"><i class="fas fa-check"></i></div>
                    <small class="fw-bold text-muted">Confirm</small>
                </div>
                <div class="text-center position-relative" style="z-index: 2;">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow" style="width: 40px; height: 40px;">3</div>
                    <small class="fw-bold">Pay</small>
                </div>
                <!-- Progress Line -->
                <div class="position-absolute top-0 start-0 w-100 mt-3" style="height: 2px; background: #e9ecef; z-index: 1;">
                    <div class="bg-primary h-100" style="width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5">
        <!-- LEFT COLUMN: Payment Form -->
        <div class="col-lg-8" data-aos="fade-right">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-credit-card me-2 text-primary"></i> Secure Payment
                    </h5>
                    <div class="d-flex gap-2">
                        <i class="fab fa-cc-visa fa-2x text-primary opacity-75"></i>
                        <i class="fab fa-cc-mastercard fa-2x text-danger opacity-75"></i>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <!-- Demo Mode Notice -->
                    <div class="alert alert-warning border-0 rounded-4 p-3 mb-5 d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x me-3 text-warning"></i>
                        <div>
                            <strong class="d-block">Demo Mode</strong>
                            <small class="text-muted">No real charges will be made. Use any dummy 16-digit card number.</small>
                        </div>
                    </div>

                    <form action="{{ route('booking.payment.process', $booking->id) }}" method="POST" id="payment-form">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Card Holder Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" name="card-holder" class="form-control bg-light border-0 ps-0" value="{{ $booking->name }}" placeholder="Lucky Person" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Card Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-credit-card text-muted"></i></span>
                                <input type="text" name="card-number" id="card-number" class="form-control bg-light border-0 ps-0" placeholder="0000 0000 0000 0000" maxlength="19" required>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Expiry Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="far fa-calendar-alt text-muted"></i></span>
                                    <input type="text" name="expiration-date" id="expiration-date" class="form-control bg-light border-0 ps-0 text-center" placeholder="MM / YY" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">CVC / CVV</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="cvc" class="form-control bg-light border-0 ps-0 text-center" placeholder="•••" maxlength="3" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" id="pay-button" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-lg py-3">
                                <span id="btn-text">Pay ₹{{ number_format($booking->total_price) }}</span>
                                <i class="fas fa-lock ms-2" id="btn-icon"></i>
                                <i class="fas fa-circle-notch fa-spin d-none" id="btn-spinner"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light border-0 py-3 px-4 d-flex justify-content-between align-items-center opacity-75">
                    <span class="small text-muted"><i class="fas fa-shield-alt text-success me-1"></i> 256-bit SSL Layer</span>
                    <span class="small text-muted">Powered by <strong>SwiftPay</strong></span>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Order Summary -->
        <div class="col-lg-4" data-aos="fade-left">
            <h5 class="fw-bold mb-4">Trip Summary</h5>
            <div class="card border-0 shadow-sm rounded-4 summary-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4 pb-4 border-bottom">
                         @if($booking->car->image)
                            <img src="{{ asset('storage/' . $booking->car->image) }}" class="rounded-3 me-3" style="width: 80px; height: 60px; object-fit: cover;">
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0">{{ $booking->car->brand }} {{ $booking->car->model }}</h6>
                            <span class="badge bg-light text-dark border py-1 px-2 small">{{ $booking->car->type ?? 'Standard' }}</span>
                        </div>
                    </div>

                    <div class="vstack gap-3 mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Pick-up</span>
                            <div class="text-end">
                                <div class="fw-bold small">{{ $booking->pickup_city }}</div>
                                <small class="text-muted x-small">{{ $booking->start_datetime->format('M d, Y') }}</small>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Drop-off</span>
                            <div class="text-end">
                                <div class="fw-bold small">{{ $booking->dropoff_city }}</div>
                                <small class="text-muted x-small">{{ $booking->end_datetime->format('M d, Y') }}</small>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Duration</span>
                            <span class="fw-bold small">{{ $booking->start_datetime->diffInDays($booking->end_datetime) + 1 }} Days</span>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <div class="vstack gap-2 mb-3">
                             <div class="d-flex justify-content-between small">
                                <span class="text-muted">Base Rate</span>
                                <span>₹{{ number_format($booking->car->price_per_day) }}</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Taxes & Fees</span>
                                <span class="text-success fw-bold">₹0</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="h5 fw-bold mb-0">Total</span>
                            <span class="h4 fw-bold text-primary mb-0">₹{{ number_format($booking->total_price) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .x-small { font-size: 0.7rem; }
    .summary-card { position: sticky; top: 2rem; }
    .input-group-text { min-width: 45px; justify-content: center; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cardInput = document.getElementById('card-number');
        const expInput = document.getElementById('expiration-date');
        const form = document.getElementById('payment-form');
        const btn = document.getElementById('pay-button');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');
        const btnSpinner = document.getElementById('btn-spinner');

        // Card Formatting (Groups of 4)
        if(cardInput) {
            cardInput.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '').substring(0, 16);
                value = value != '' ? value.match(/.{1,4}/g).join(' ') : '';
                e.target.value = value;
            });
        }

        // Date Formatting (MM/YY)
        if(expInput) {
            expInput.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '').substring(0, 4);
                if (value.length >= 2) {
                    value = value.substring(0, 2) + ' / ' + value.substring(2);
                }
                e.target.value = value;
            });
        }

        // Form Submit Animation
        if(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); 
                btnText.innerText = 'Verifying Transaction...';
                btnIcon.classList.add('d-none');
                btnSpinner.classList.remove('d-none');
                btn.classList.add('opacity-75', 'disabled');
                
                setTimeout(() => { form.submit(); }, 2000);
            });
        }
    });
</script>
@endsection
