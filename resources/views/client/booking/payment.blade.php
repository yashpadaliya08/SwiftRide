@extends('client.layout')

@section('title', $booking->status !== 'pending' ? 'Booking Invoice' : 'Secure Payment')

@section('content')
<!-- Animate.css via CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<div class="container py-5">
    @if($booking->status === 'pending')
        <!-- Stepper (Show only for pending payment) -->
        <div class="row justify-content-center mb-5 no-print" data-aos="fade-down">
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
                        <small class="fw-bold text-dark">Pay</small>
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
    @else
        <!-- State B: Gorgeous Premium Invoice/Receipt -->
        <div class="row justify-content-center py-4">
            <div class="col-lg-9" id="printable-invoice">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden invoice-card bg-white" style="border: 1px solid rgba(0, 0, 0, 0.05) !important;">
                    <!-- Electric Gradient Trim -->
                    <div style="height: 6px; background: linear-gradient(90deg, #ff3333, #3399ff);"></div>
                    
                    <div class="card-body p-5">
                        <!-- Invoice Header -->
                        <div class="d-flex justify-content-between align-items-start mb-5 pb-4 border-bottom flex-wrap gap-3">
                            <div>
                                <h2 class="fw-black text-dark mb-1" style="font-weight: 800; letter-spacing: -1px;">SWIFTRIDE<span style="color: #ff3333;">.</span></h2>
                                <p class="text-muted small mb-0">Premium Rental Transaction Invoice</p>
                            </div>
                            <div class="text-md-end">
                                <h5 class="fw-bold mb-1 text-dark text-uppercase tracking-wider">Receipt Invoice</h5>
                                <p class="text-muted small mb-1">Receipt ID: <span class="fw-bold text-dark">SR-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span></p>
                                <p class="text-muted small mb-0">Date Issued: {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</p>
                            </div>
                        </div>

                        <!-- Bill details -->
                        <div class="row mb-5">
                            <div class="col-sm-6 mb-4 mb-sm-0">
                                <h6 class="text-uppercase text-muted fw-bold small mb-2" style="font-size: 0.68rem; letter-spacing: 0.8px;">Issued By</h6>
                                <h6 class="fw-bold text-dark mb-1">SwiftRide Vehicles Ltd.</h6>
                                <p class="text-muted small mb-0">Support Desk: support@swiftride.com</p>
                                <p class="text-muted small mb-0">Central Hub: New Delhi, India</p>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <h6 class="text-uppercase text-muted fw-bold small mb-2" style="font-size: 0.68rem; letter-spacing: 0.8px;">Customer Information</h6>
                                <h6 class="fw-bold text-dark mb-1">{{ $booking->user->name ?? $booking->name }}</h6>
                                <p class="text-muted small mb-0">Email ID: {{ $booking->user->email ?? $booking->email }}</p>
                                <p class="text-muted small mb-0">Customer Reference: #{{ str_pad($booking->user_id ?? 1, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>

                        <!-- Booking specs -->
                        <div class="bg-light p-4 rounded-4 mb-5 border-light-subtle" style="border: 1px solid rgba(0, 0, 0, 0.03);">
                            <div class="row g-4">
                                <div class="col-md-5">
                                    <h6 class="text-uppercase text-muted fw-bold small mb-3" style="font-size: 0.68rem; letter-spacing: 0.8px;">Vehicle Allocation</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white rounded p-2.5 me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 58px; height: 58px; border: 1px solid rgba(0,0,0,0.03);">
                                            <i class="fas fa-car fa-2x text-primary opacity-75"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $booking->car->brand }} {{ $booking->car->model }}</h6>
                                            <span class="badge bg-dark-subtle text-dark-emphasis px-2.5 py-1 text-uppercase" style="font-size: 0.65rem; font-weight: 700;">{{ $booking->car->type ?? 'Standard' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 border-start-md">
                                    <h6 class="text-uppercase text-muted fw-bold small mb-3 ps-md-4" style="font-size: 0.68rem; letter-spacing: 0.8px;">Schedule Summary</h6>
                                    <div class="d-flex justify-content-between align-items-center ps-md-4">
                                        <div>
                                            <span class="text-muted small d-block">Pick-up Location</span>
                                            <strong class="text-dark">{{ $booking->pickup_city }}</strong>
                                            <span class="text-muted small d-block" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M Y, h:i A') }}</span>
                                        </div>
                                        <i class="fas fa-arrow-right text-muted opacity-50 mx-2"></i>
                                        <div>
                                            <span class="text-muted small d-block">Drop-off Location</span>
                                            <strong class="text-dark">{{ $booking->dropoff_city }}</strong>
                                            <span class="text-muted small d-block" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($booking->end_datetime)->format('d M Y, h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="mb-5">
                            <h6 class="text-uppercase text-muted fw-bold small mb-3" style="font-size: 0.68rem; letter-spacing: 0.8px;">Rental Calculation</h6>
                            <div class="table-responsive border-0">
                                <table class="table align-middle" style="border: none !important;">
                                    <thead>
                                        <tr class="text-muted" style="border-bottom: 2px solid #f1f5f9; font-size: 0.72rem; text-transform: uppercase;">
                                            <th class="ps-0 py-2 border-0">Item Description</th>
                                            <th class="text-center py-2 border-0">Daily Rate</th>
                                            <th class="text-center py-2 border-0">Rental Duration</th>
                                            <th class="text-end pe-0 py-2 border-0">Line Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td class="ps-0 py-3 border-0">
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">Premium Car Fleet Lease</span>
                                                <small class="text-muted d-block">Full damage protection & road safety package included</small>
                                            </td>
                                            <td class="text-center py-3 border-0">₹{{ number_format($booking->car->price_per_day) }}</td>
                                            <td class="text-center py-3 border-0">{{ \Carbon\Carbon::parse($booking->start_datetime)->diffInDays(\Carbon\Carbon::parse($booking->end_datetime)) + 1 }} Days</td>
                                            <td class="text-end pe-0 py-3 fw-bold text-dark border-0">₹{{ number_format($booking->car->price_per_day * (\Carbon\Carbon::parse($booking->start_datetime)->diffInDays(\Carbon\Carbon::parse($booking->end_datetime)) + 1)) }}</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td class="ps-0 py-3 border-0" colspan="3">
                                                <span class="text-muted">Government Tolls, Fees & Taxes (Included)</span>
                                            </td>
                                            <td class="text-end pe-0 py-3 fw-bold text-success border-0">₹0</td>
                                        </tr>
                                        <tr style="border-top: 2px solid #f1f5f9 !important;">
                                            <td class="ps-0 py-4 border-0" colspan="3">
                                                <h5 class="fw-black text-dark mb-0" style="font-weight: 800;">Total Paid Fare</h5>
                                            </td>
                                            <td class="text-end pe-0 py-4 border-0">
                                                <h5 class="fw-black mb-0 text-danger" style="font-weight: 900; font-size: 1.45rem;">
                                                    ₹{{ number_format($booking->total_price) }}
                                                </h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Footer notes -->
                        <div class="row align-items-center mt-5 pt-4 border-top">
                            <div class="col-sm-7 mb-4 mb-sm-0">
                                <h6 class="text-uppercase text-muted fw-bold small mb-1" style="font-size: 0.65rem; letter-spacing: 0.8px;">Verification Guidelines</h6>
                                <p class="text-muted small mb-0">This receipt represents a secure transaction confirmation on the SwiftRide network. Please bring a digital or printed copy of this receipt, along with your original driving license and identity card to verify vehicle handover.</p>
                            </div>
                            <div class="col-sm-5 text-sm-end">
                                @if($booking->status == 'confirmed' || $booking->status == 'completed')
                                    <div class="d-inline-block border border-success text-success px-4 py-2.5 rounded fw-bold text-uppercase tracking-wider rotate-stamp shadow-sm" style="font-size: 1.25rem; font-weight: 900; letter-spacing: 2px; transform: rotate(-5deg); border-width: 3.5px !important; background-color: rgba(25, 135, 84, 0.04);">
                                        <i class="fas fa-check-circle me-1"></i> PAID
                                    </div>
                                @elseif($booking->status == 'cancelled')
                                    <div class="d-inline-block border border-danger text-danger px-4 py-2.5 rounded fw-bold text-uppercase tracking-wider rotate-stamp shadow-sm" style="font-size: 1.25rem; font-weight: 900; letter-spacing: 2px; transform: rotate(-5deg); border-width: 3.5px !important; background-color: rgba(220, 53, 69, 0.04);">
                                        <i class="fas fa-ban me-1"></i> CANCELLED
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons (Non-printable) -->
                <div class="d-flex justify-content-center gap-3 mt-5 no-print">
                    <button class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg d-flex align-items-center gap-2" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Invoice Receipt
                    </button>
                    <a href="{{ route('booking.myBookings') }}" class="btn btn-outline-dark rounded-pill px-5 py-3 fw-bold">
                        Back to My Trips
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .x-small { font-size: 0.7rem; }
    .summary-card { position: sticky; top: 2rem; }
    .input-group-text { min-width: 45px; justify-content: center; }
    .border-start-md {
        border-left: 1px solid #dee2e6;
    }
    @media (max-width: 767.98px) {
        .border-start-md {
            border-left: none !important;
        }
    }

    /* PREMIUM PRINT STYLES */
    @media print {
        /* Completely hide navigation, client layouts, buttons, headers, alert banners, and stepper */
        nav, 
        .navbar, 
        header, 
        footer, 
        .no-print, 
        .btn, 
        .alert,
        .row.justify-content-center.mb-5,
        .d-flex.justify-content-between.position-relative {
            display: none !important;
        }

        /* Remove client global backings, scrollbar containers, padding & background shadows */
        body, 
        main, 
        .container, 
        .py-5,
        .py-4 {
            background: #fff !important;
            color: #000 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: visible !important;
            height: auto !important;
            min-height: auto !important;
        }

        /* Set receipt block to occupy 100% printed page width */
        .col-lg-9, 
        #printable-invoice {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .invoice-card {
            border: none !important;
            box-shadow: none !important;
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .card-body {
            padding: 0 !important;
        }

        /* Ensure color adjustments print clearly */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        .text-dark {
            color: #000 !important;
        }

        .text-muted {
            color: #555 !important;
        }

        .bg-light {
            background-color: #f8fafc !important;
        }
    }
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
