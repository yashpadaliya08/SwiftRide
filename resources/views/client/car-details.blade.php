@extends('client.layout')

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <!-- Left: Car Details -->
        <div class="col-lg-8" data-aos="fade-right">
            <!-- Header -->
            <div class="d-flex align-items-center mb-3 flex-wrap gap-2">
                <span class="badge premium-tag text-uppercase fw-bold">{{ $car->year }} Model</span>
                @if($car->status == 'available')
                    <span class="badge status-tag-available text-uppercase fw-bold"><i class="fas fa-check-circle me-1 text-success"></i>Available</span>
                @else
                    <span class="badge status-tag-booked text-uppercase fw-bold"><i class="fas fa-history me-1 text-muted"></i>Booked</span>
                @endif
                <span class="badge category-tag text-uppercase fw-bold">{{ $car->type }}</span>
            </div>
            <h1 class="fw-black text-dark display-5 mb-2 tracking-tight">{{ $car->brand }} <span class="fw-normal text-muted">{{ $car->model }}</span></h1>
            
            <div class="d-flex align-items-center mb-4 flex-wrap gap-3 pb-3 border-bottom border-light">
                @php $avg = $car->averageRating(); @endphp
                <div class="text-warning d-flex align-items-center gap-1">
                    @for($i=1; $i<=5; $i++)
                        <i class="fas fa-star {{ $i <= $avg ? 'text-warning' : 'text-light opacity-60' }}" style="font-size: 0.9rem;"></i>
                    @endfor
                </div>
                <span class="fw-bold text-dark d-flex align-items-center gap-1" style="font-size: 0.95rem;">
                    {{ number_format($avg, 1) }}
                    <span class="text-muted fw-normal">({{ $car->approvedReviews->count() }} customer reviews)</span>
                </span>
            </div>

            <!-- Main Image Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 detail-img-card">
                <img src="{{ $car->image ? asset('storage/' . $car->image) : 'https://via.placeholder.com/800x500?text=No+Image' }}" 
                     class="img-fluid w-100 object-fit-cover detail-main-image" 
                     style="max-height: 480px;" 
                     alt="{{ $car->brand }} {{ $car->model }}">
            </div>

            <!-- Specs Grid -->
            <h4 class="fw-black text-dark mb-4 tracking-tight">Vehicle Specifications</h4>
            <div class="row g-3 mb-5">
                <div class="col-6 col-md-3">
                    <div class="spec-card">
                        <div class="spec-icon-holder"><i class="fas fa-cog"></i></div>
                        <span class="spec-title">Transmission</span>
                        <span class="spec-val">{{ $car->transmission }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="spec-card">
                        <div class="spec-icon-holder"><i class="fas fa-gas-pump"></i></div>
                        <span class="spec-title">Fuel Type</span>
                        <span class="spec-val">{{ $car->fuel_type }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="spec-card">
                        <div class="spec-icon-holder"><i class="fas fa-user-friends"></i></div>
                        <span class="spec-title">Capacity</span>
                        <span class="spec-val">{{ $car->seats }} Seats</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="spec-card">
                        <div class="spec-icon-holder"><i class="fas fa-tachometer-alt"></i></div>
                        <span class="spec-title">Efficiency</span>
                        <span class="spec-val">{{ $car->fuel_efficiency ?? '14.5' }} km/l</span>
                    </div>
                </div>
            </div>

            <!-- Features / Description -->
            <h4 class="fw-black text-dark mb-3 tracking-tight">Overview Description</h4>
            <p class="text-muted leading-relaxed mb-5 lh-relaxed" style="font-size: 1.05rem; font-weight: 450;">
                {{ $car->description ?? 'Experience the ultimate driving comfort with this premium ' . $car->brand . ' ' . $car->model . '. Perfect for corporate travel, family vacations, or upscale weekend getaways. Exceptionally maintained and fully detailed to ensure your absolute comfort, safety, and ultimate satisfaction during your journey.' }}
            </p>

            <!-- Reviews Section -->
            <div class="reviews-section mt-5 pt-4 border-top">
                <h4 class="fw-black text-dark mb-4 tracking-tight">Customer Reviews</h4>
                @if($car->approvedReviews->count() > 0)
                    <div class="vstack gap-4">
                        @foreach($car->approvedReviews as $review)
                            <div class="review-item-card p-4 rounded-4">
                                <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                                    <div class="d-flex align-items-center">
                                        <div class="review-avatar-circle">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark">{{ $review->user->name }}</h6>
                                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="text-warning d-flex gap-1" style="font-size: 0.8rem;">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-light opacity-60' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-muted small mb-0 ps-5 mt-2 lh-relaxed" style="font-size: 0.9rem; font-weight: 500;">
                                    "{{ $review->comment }}"
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                        <div class="text-muted opacity-30 mb-2"><i class="far fa-comments fa-3x"></i></div>
                        <p class="text-muted mb-0 small italic" style="font-weight: 550;">No reviews yet for this premium vehicle.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Booking Form (Sticky) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 sticky-top booking-card" style="top: 110px; z-index: 10;">
                <div class="card-header booking-card-header text-white py-4 px-4 border-0">
                    <span class="mb-0 text-white-50 small text-uppercase fw-bold tracking-wider d-block">Premium Daily Rate</span>
                    <h2 class="mb-0 fw-black text-white display-6">₹{{ number_format($car->price_per_day) }}<span class="price-day-tag">/day</span></h2>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('booking.confirm') }}" method="POST">
                        @csrf
                        <input type="hidden" name="car_id" value="{{ $car->id }}">

                        <div class="mb-3">
                            <label class="form-label booking-field-label">Pick-up City</label>
                            <select name="pickup_city" class="form-select custom-booking-select" required>
                                <option value="">Select Pickup Location</option>
                                @foreach(['Rajkot', 'Ahmedabad', 'Vadodara', 'Surat', 'Jamnagar'] as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label booking-field-label">Drop-off City</label>
                            <select name="dropoff_city" class="form-select custom-booking-select" required>
                                <option value="">Select Drop-off Location</option>
                                @foreach(['Rajkot', 'Ahmedabad', 'Vadodara', 'Surat', 'Jamnagar'] as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label booking-field-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control custom-booking-input" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label booking-field-label">Time</label>
                                <input type="time" name="start_time" class="form-control custom-booking-input" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <label class="form-label booking-field-label">End Date</label>
                                <input type="date" name="end_date" class="form-control custom-booking-input" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label booking-field-label">Time</label>
                                <input type="time" name="end_time" class="form-control custom-booking-input" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-3 py-3 fw-bold booking-submit-btn">
                                Check Availability & Book
                            </button>
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted"><i class="fas fa-shield-alt text-success me-1"></i> 100% Secure Transaction & Free Support</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>

<style>
    /* Premium Tags */
    .premium-tag {
        background: #0f172a;
        color: #fff;
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 0.72rem;
        letter-spacing: 0.5px;
    }
    
    .status-tag-available {
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
        border: 1px solid rgba(25, 135, 84, 0.15);
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 0.72rem;
    }
    
    .status-tag-booked {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.15);
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 0.72rem;
    }
    
    .category-tag {
        background: rgba(255, 51, 51, 0.1);
        color: #ff3333;
        border: 1px solid rgba(255, 51, 51, 0.15);
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 0.72rem;
    }

    /* Detail Image Card */
    .detail-img-card {
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04) !important;
    }
    
    .detail-main-image {
        transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    
    .detail-img-card:hover .detail-main-image {
        transform: scale(1.03);
    }

    /* Specs card layout */
    .spec-card {
        background: #f8fafc;
        border: 1.5px solid #f1f5f9;
        border-radius: 16px;
        padding: 20px 10px;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    
    .spec-card:hover {
        transform: translateY(-5px);
        border-color: rgba(255, 51, 51, 0.18);
        background: rgba(255, 51, 51, 0.01);
        box-shadow: 0 10px 25px rgba(255, 51, 51, 0.05);
    }

    .spec-icon-holder {
        width: 48px;
        height: 48px;
        background: rgba(255, 51, 51, 0.08);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff3333;
        font-size: 1.15rem;
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }
    
    .spec-card:hover .spec-icon-holder {
        background: #ff3333;
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 51, 51, 0.25);
    }

    .spec-title {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .spec-val {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
    }

    /* Review Card layout */
    .review-item-card {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        transition: all 0.25s ease;
    }
    
    .review-item-card:hover {
        border-color: #e2e8f0;
        background: #f1f5f9;
    }

    .review-avatar-circle {
        width: 40px;
        height: 40px;
        background: rgba(255, 51, 51, 0.1);
        border: 1px solid rgba(255, 51, 51, 0.15);
        color: #ff3333;
        font-weight: 800;
        font-size: 1.1rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
    }

    /* Booking Sticky Widget */
    .booking-card {
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.08) !important;
        overflow: hidden;
    }

    .booking-card-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-bottom: 1.5px solid rgba(255, 51, 51, 0.15);
        position: relative;
    }
    
    .booking-card-header::after {
        content: '';
        position: absolute;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(255, 51, 51, 0.2) 0%, transparent 70%);
        top: -30px;
        right: -30px;
        pointer-events: none;
    }

    .price-day-tag {
        font-size: 0.95rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.55);
    }

    .booking-field-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #64748b;
        margin-bottom: 0.5rem;
    }

    .custom-booking-select, .custom-booking-input {
        background-color: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.7rem 1rem;
        font-size: 0.88rem;
        font-weight: 550;
        color: #0f172a;
        transition: all 0.3s ease;
    }

    .custom-booking-select:focus, .custom-booking-input:focus {
        border-color: #ff3333;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(255, 51, 51, 0.1);
    }

    .booking-submit-btn {
        background: linear-gradient(135deg, #ff3333, #c21a1a);
        border: none;
        box-shadow: 0 6px 20px rgba(255, 51, 51, 0.3);
        transition: all 0.3s ease;
    }
    
    .booking-submit-btn:hover {
        background: linear-gradient(135deg, #e02424, #a81313);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 51, 51, 0.45);
    }
    
    .booking-submit-btn:active {
        transform: translateY(-1px);
    }
</style>
@endsection
