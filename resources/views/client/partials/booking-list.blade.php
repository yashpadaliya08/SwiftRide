<div class="row g-4">
    @foreach($filtered_bookings as $booking)
        <div class="col-12" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden booking-card hover-lift">
                <div class="row g-0">
                    <!-- Left: Car Image & Status -->
                    <div class="col-md-3 bg-light d-flex align-items-center justify-content-center p-4">
                        <div class="text-center">
                            <div class="bg-white rounded-circle p-3 shadow-sm mb-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-car fa-2x text-primary opacity-75"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $booking->car->brand }} {{ $booking->car->model }}</h6>
                            @php
                                $statusClasses = [
                                    'confirmed' => 'bg-success bg-opacity-10 text-success',
                                    'pending' => 'bg-warning bg-opacity-10 text-warning text-dark',
                                    'cancelled' => 'bg-danger bg-opacity-10 text-danger',
                                    'completed' => 'bg-primary bg-opacity-10 text-primary',
                                ];
                                $statusClass = $statusClasses[$booking->status] ?? 'bg-secondary bg-opacity-10 text-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 text-uppercase fw-bold x-small">
                                {{ $booking->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Center: Details -->
                    <div class="col-md-6 p-4">
                        <div class="row g-4 h-100 align-items-center">
                            <div class="col-md-6">
                                <small class="text-muted text-uppercase fw-bold x-small tracking-wider d-block mb-2">Pick-up</small>
                                <div class="d-flex align-items-start gap-3">
                                    <div class="text-primary mt-1"><i class="fas fa-map-marker-alt"></i></div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $booking->pickup_city }}</div>
                                        <div class="small text-muted">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('D, M d, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 border-start border-light ps-md-4">
                                <small class="text-muted text-uppercase fw-bold x-small tracking-wider d-block mb-2">Drop-off</small>
                                <div class="d-flex align-items-start gap-3">
                                    <div class="text-danger mt-1"><i class="fas fa-map-marker-alt"></i></div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $booking->dropoff_city }}</div>
                                        <div class="small text-muted">{{ \Carbon\Carbon::parse($booking->end_datetime)->format('D, M d, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Pricing & Actions -->
                    <div class="col-md-3 border-start border-light p-4 d-flex flex-column justify-content-center bg-light bg-opacity-25">
                        <div class="text-center mb-3">
                            <small class="text-muted text-uppercase fw-bold x-small tracking-wider d-block mb-1">Total Fare</small>
                            <h3 class="fw-black text-dark mb-0">₹{{ number_format($booking->total_price) }}</h3>
                        </div>
                        
                        <div class="vstack gap-2">
                             @if($booking->status == 'pending')
                                <a href="{{ route('booking.payment', $booking->id) }}" class="btn btn-primary w-100 rounded-pill fw-bold">Pay Now</a>
                                <button type="button" class="btn btn-outline-danger w-100 rounded-pill fw-bold btn-sm cancel-btn"
                                    data-bs-toggle="modal" data-bs-target="#cancelModal"
                                    data-booking-id="{{ $booking->id }}">
                                    Cancel
                                </button>
                            @else
                                <a href="{{ route('booking.payment', $booking->id) }}" class="btn btn-dark w-100 rounded-pill fw-bold">View Receipt</a>
                                @if($booking->status == 'completed')
                                    <button class="btn btn-outline-primary w-100 rounded-pill fw-bold btn-sm">Rate Experience</button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
    .x-small { font-size: 0.65rem; }
    .booking-card {
        border: 1px solid rgba(0,0,0,0.02) !important;
    }
</style>
