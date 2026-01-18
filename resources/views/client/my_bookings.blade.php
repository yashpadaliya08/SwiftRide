@extends('client.layout')

@section('title', 'My Trips - SwiftRide')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5" data-aos="fade-down">
        <div>
            <h5 class="text-primary fw-bold mb-2">My Activity</h5>
            <h1 class="display-5 fw-black text-dark mb-0">Your Journey History</h1>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-3">
            <a href="{{ route('booking.selectCriteria') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i>New Adventure
            </a>
            <div class="dropdown">
                <button class="btn btn-outline-dark rounded-pill dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2">
                    <li><a class="dropdown-item rounded-3 mb-1" href="#all" data-bs-toggle="tab">All Bookings</a></li>
                    <li><a class="dropdown-item rounded-3 mb-1" href="#upcoming" data-bs-toggle="tab">Upcoming Trips</a></li>
                    <li><a class="dropdown-item rounded-3" href="#completed" data-bs-toggle="tab">Past Trips</a></li>
                </ul>
            </div>
        </div>
    </div>

    @if($bookings->isEmpty())
        <div class="text-center py-5" data-aos="zoom-in">
            <div class="mb-4 text-primary opacity-25">
                <i class="fas fa-calendar-times fa-5x"></i>
            </div>
            <h2 class="fw-black text-dark">No trips found.</h2>
            <p class="text-muted lead mb-5">Your travel diary is empty! Let's start by planning your first ride.</p>
            <a href="{{ route('booking.selectCriteria') }}" class="btn btn-dark btn-lg rounded-pill px-5 fw-bold shadow-lg">Find a Car Now</a>
        </div>
    @else
        <!-- Tabs Navigation -->
        <div class="mb-4" data-aos="fade-up">
            <ul class="nav nav-pills gap-2 bg-light p-2 rounded-pill d-inline-flex border" id="bookingTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4 fw-bold text-dark-emphasis" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All Trips</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 fw-bold text-dark-emphasis" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab">Upcoming</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 fw-bold text-dark-emphasis" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">Past History</button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content border-0" id="bookingTabContent">
            <!-- ALL TAB -->
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                @include('client.partials.booking-list', ['filtered_bookings' => $bookings])
            </div>
            
            <!-- UPCOMING TAB -->
            <div class="tab-pane fade" id="upcoming" role="tabpanel">
                @php $upcoming = $bookings->filter(fn($b) => in_array($b->status, ['confirmed', 'pending']) && \Carbon\Carbon::parse($b->end_datetime)->isFuture()); @endphp
                @if($upcoming->count() > 0)
                    @include('client.partials.booking-list', ['filtered_bookings' => $upcoming])
                @else
                    <div class="text-center py-5 text-muted">No upcoming adventures found. <a href="{{ route('booking.selectCriteria') }}" class="text-primary fw-bold text-decoration-none">Book one?</a></div>
                @endif
            </div>

            <!-- COMPLETED TAB -->
            <div class="tab-pane fade" id="completed" role="tabpanel">
                @php $history = $bookings->filter(fn($b) => $b->status == 'completed' || $b->status == 'cancelled' || ($b->status == 'confirmed' && \Carbon\Carbon::parse($b->end_datetime)->isPast())); @endphp
                @if($history->count() > 0)
                    @include('client.partials.booking-list', ['filtered_bookings' => $history])
                @else
                    <div class="text-center py-5 text-muted">Your trip history will appear here once you complete your travels.</div>
                @endif
            </div>
        </div>
        
        <div class="mt-5 d-flex justify-content-center">
            {{ $bookings->links() }}
        </div>
    @endif
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="cancelForm">
            @csrf
            @method('PATCH')
            <div class="modal-content border-0 shadow-lg rounded-5 overflow-hidden">
                <div class="modal-header border-0 bg-danger text-white p-4">
                    <h5 class="modal-title fw-black"><i class="fas fa-exclamation-triangle me-2"></i>Cancel Trip?</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5 text-center">
                    <div class="mb-4 text-danger opacity-25">
                        <i class="fas fa-ban fa-5x"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Are you sure?</h4>
                    <p class="text-muted mb-0">Cancelling your trip may incur fees depending on the time of cancellation. This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-5 gap-3">
                    <button type="button" class="btn btn-light rounded-pill px-5 fw-bold" data-bs-dismiss="modal">Keep Trip</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-5 fw-bold shadow-sm">Yes, Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-5 overflow-hidden">
            <div class="modal-header border-0 bg-warning text-dark p-4">
                <h5 class="modal-title fw-black"><i class="fas fa-star me-2"></i>Rate Your Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 p-md-5">
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" id="review_booking_id">
                    
                    <div class="mb-4 text-center">
                        <div class="rating-stars h3">
                            <i class="far fa-star rating-star" data-value="1" style="cursor: pointer;"></i>
                            <i class="far fa-star rating-star" data-value="2" style="cursor: pointer;"></i>
                            <i class="far fa-star rating-star" data-value="3" style="cursor: pointer;"></i>
                            <i class="far fa-star rating-star" data-value="4" style="cursor: pointer;"></i>
                            <i class="far fa-star rating-star" data-value="5" style="cursor: pointer;"></i>
                        </div>
                        <input type="hidden" name="rating" id="review_rating" value="5">
                        <small class="text-muted d-block mt-2">Click a star to rate</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Your Review</label>
                        <textarea name="comment" class="form-control bg-light border-0 px-3 py-2 rounded-3" rows="3" placeholder="Tell others about the car and service..."></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning rounded-pill py-3 fw-bold shadow-sm">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link {
        color: #6c757d;
        background: none;
    }
    .nav-pills .nav-link.active {
        color: #fff !important;
        background: #0d1117 !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .dropdown-item:active {
        background-color: #d12e2e;
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Handle cancellation modal
        $('.cancel-btn').on('click', function () {
            let bookingId = $(this).data('booking-id');
            let cancelUrl = `{{ url('booking/my-bookings') }}/${bookingId}/cancel`;
            $('#cancelForm').attr('action', cancelUrl);
        });

        // Handle Review modal
        $(document).on('click', '.rate-btn', function() {
            $('#review_booking_id').val($(this).data('booking-id'));
            resetRating();
        });

        $('.rating-star').on('click', function() {
            const val = $(this).data('value');
            $('#review_rating').val(val);
            setRating(val);
        });

        function setRating(val) {
            $('.rating-star').each(function() {
                if($(this).data('value') <= val) {
                    $(this).removeClass('far').addClass('fas text-warning');
                } else {
                    $(this).removeClass('fas text-warning').addClass('far');
                }
            });
        }

        function resetRating() {
            const val = 5;
            $('#review_rating').val(val);
            setRating(val);
        }

        // Optional: Smoothly switch tabs via URL hash or dropdown
        $('a[data-bs-toggle="tab"]').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
@endsection