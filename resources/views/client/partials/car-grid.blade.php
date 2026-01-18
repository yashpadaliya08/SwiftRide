@if(count($availableCars) > 0)
    <div class="row g-4 animate__animated animate__fadeIn">
    @foreach($availableCars as $car)
        <div class="col-md-6 col-xl-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden car-card hover-lift">
                <!-- Image -->
                <div class="position-relative">
                    <img src="{{ $car->image ? asset('storage/' . $car->image) : 'https://via.placeholder.com/400x250?text=No+Image' }}" 
                         class="card-img-top object-fit-cover" 
                         style="height: 220px;" 
                         alt="{{ $car->brand }} {{ $car->model }}">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-success shadow-sm px-3 py-2 rounded-pill small">Available</span>
                    </div>
                </div>

                <!-- Body -->
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">{{ $car->brand }} {{ $car->model }}</h5>
                            <small class="text-muted">{{ $car->year }} Series</small>
                            <div class="mt-1">
                                @php $avg = $car->averageRating(); @endphp
                                @for($i=1; $i<=5; $i++)
                                    <i class="fas fa-star size-xs {{ $i <= $avg ? 'text-warning' : 'text-light' }}" style="font-size: 0.7rem;"></i>
                                @endfor
                                <span class="small text-muted ms-1">({{ $avg }})</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <h5 class="fw-bold text-primary mb-0">₹{{ number_format($car->price_per_day) }}</h5>
                            <small class="text-muted">/ day</small>
                        </div>
                    </div>

                    <!-- Specs Icons -->
                    <div class="row g-2 my-3">
                        <div class="col-4">
                            <div class="p-2 border rounded-3 text-center bg-light">
                                <i class="fas fa-gas-pump text-muted mb-1 d-block"></i>
                                <small class="fw-bold fs-xs">{{ $car->fuel_type }}</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded-3 text-center bg-light">
                                <i class="fas fa-cogs text-muted mb-1 d-block"></i>
                                <small class="fw-bold fs-xs">{{ $car->transmission }}</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded-3 text-center bg-light">
                                <i class="fas fa-users text-muted mb-1 d-block"></i>
                                <small class="fw-bold fs-xs">{{ $car->seats }} Seats</small>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('booking.confirm') }}" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="pickup_city" value="{{ $pickup_city }}">
                        <input type="hidden" name="dropoff_city" value="{{ $dropoff_city }}">
                        <input type="hidden" name="start_date" value="{{ $start_date }}">
                        <input type="hidden" name="start_time" value="{{ $start_time }}">
                        <input type="hidden" name="end_date" value="{{ $end_date }}">
                        <input type="hidden" name="end_time" value="{{ $end_time }}">
                        <input type="hidden" name="car_id" value="{{ $car->id }}">

                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm">
                            Book Now <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@else
    <div class="text-center py-5">
        <div class="mb-3 text-muted opacity-25"><i class="fas fa-car-crash fa-4x"></i></div>
        <h4 class="fw-bold">No cars available</h4>
        <p class="text-muted">We couldn't find any cars matching your filters.</p>
        <button type="button" onclick="resetFilters()" class="btn btn-outline-primary rounded-pill px-4">Reset Filters</button>
    </div>
@endif
