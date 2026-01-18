@extends('client.layout')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5" data-aos="fade-down">
        <div>
            <span class="badge bg-primary text-white rounded-pill px-3 py-2 mb-2 text-uppercase fw-bold small shadow-sm">Step 2 of 3</span>
            <h2 class="fw-bold mb-1">Available Cars</h2>
            <p class="text-muted mb-0">For your trip from <span class="text-dark fw-bold">{{ $pickup_city }}</span> to <span class="text-dark fw-bold">{{ $dropoff_city }}</span></p>
        </div>
        <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
            <select id="sort_by" class="form-select rounded-pill px-4 shadow-sm border-0" style="width: 200px;">
                <option value="popular">Sort: Popular</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
                <option value="newest">Year: Newest First</option>
            </select>
            <a href="{{ route('booking.selectCriteria') }}" class="btn btn-outline-secondary rounded-pill btn-sm"><i class="fas fa-edit me-2"></i>Change Search</a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3" data-aos="fade-right">
            <!-- Trip Summary Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-dark text-white border-0 py-3 rounded-top-4">
                    <h5 class="mb-0 fw-bold small text-uppercase"><i class="fas fa-map-marked-alt me-2 text-warning"></i>Your Trip</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <small class="text-muted d-block fw-bold text-uppercase">Pick-up</small>
                        <div class="fw-bold">{{ $pickup_city }}</div>
                        <small>{{ \Carbon\Carbon::parse("$start_date")->format('M d, Y') }}</small>
                    </div>
                    <div class="mb-0">
                         <small class="text-muted d-block fw-bold text-uppercase">Drop-off</small>
                        <div class="fw-bold">{{ $dropoff_city }}</div>
                         <small>{{ \Carbon\Carbon::parse("$end_date")->format('M d, Y') }}</small>
                    </div>
                </div>
            </div>

            <!-- Real-time Filters -->
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-filter me-2 text-primary"></i>Refine Search</h5>
                </div>
                <div class="card-body p-4">
                     <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Max Price: <span id="priceValResult" class="text-primary">₹10,000</span></label>
                        <input type="range" class="form-range" min="1000" max="15000" step="500" value="15000" id="max_price">
                        <div class="d-flex justify-content-between x-small fw-bold text-muted">
                            <span>₹1k</span>
                            <span>₹15k</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-2 d-block">Transmission</label>
                        <div class="btn-group w-100 filter-group" role="group" id="transmission_group">
                             <input type="radio" class="btn-check" name="transmission" id="trans_all" value="All" checked>
                             <label class="btn btn-outline-light text-dark btn-sm flex-fill fw-bold" for="trans_all">All</label>

                             <input type="radio" class="btn-check" name="transmission" id="trans_auto" value="Automatic">
                             <label class="btn btn-outline-light text-dark btn-sm flex-fill fw-bold" for="trans_auto">Auto</label>

                             <input type="radio" class="btn-check" name="transmission" id="trans_manual" value="Manual">
                             <label class="btn btn-outline-light text-dark btn-sm flex-fill fw-bold" for="trans_manual">Manual</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-2 d-block">Fuel Type</label>
                        <select id="fuel_type" class="form-select bg-light border-0 rounded-3">
                            <option value="All">All Fuel Types</option>
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Electric">Electric</option>
                        </select>
                    </div>

                    <button type="button" onclick="resetFilters()" class="btn btn-light w-100 rounded-pill fw-bold btn-sm text-muted">Reset All</button>
                </div>
            </div>
        </div>

        <!-- Car Grid Container -->
        <div class="col-lg-9">
            <div id="car-results-container">
                @include('client.partials.car-grid', ['availableCars' => $availableCars])
            </div>
            
            <!-- Loading Overlay -->
            <div id="loading-overlay" class="d-none position-absolute top-50 start-50 translate-middle">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .x-small { font-size: 0.75rem; }
    .fs-xs { font-size: 0.7rem; }
    .hover-lift { transition: all 0.3s ease; }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important; }
    .btn-check:checked + .btn-outline-light { background-color: #0d1117 !important; color: #fff !important; border-color: #0d1117 !important; }
    .filter-group { border: 1px solid #f8f9fa; border-radius: 10px; overflow: hidden; }
</style>

<script>
    function updateResults() {
        const container = $('#car-results-container');
        const overlay = $('#loading-overlay');
        
        container.css('opacity', '0.5');
        overlay.removeClass('d-none');

        const params = {
            pickup_city: '{{ $pickup_city }}',
            dropoff_city: '{{ $dropoff_city }}',
            start_date: '{{ $start_date }}',
            start_time: '{{ $start_time }}',
            end_date: '{{ $end_date }}',
            end_time: '{{ $end_time }}',
            max_price: $('#max_price').val(),
            transmission: $('input[name="transmission"]:checked').val(),
            fuel_type: $('#fuel_type').val(),
            sort_by: $('#sort_by').val()
        };

        $.get('{{ route('booking.available') }}', params, function(html) {
            container.html(html);
            container.css('opacity', '1');
            overlay.addClass('d-none');
        });
    }

    function resetFilters() {
        $('#max_price').val(15000);
        $('#priceValResult').text('₹15,000');
        $('#trans_all').prop('checked', true);
        $('#fuel_type').val('All');
        $('#sort_by').val('popular');
        updateResults();
    }

    $(function() {
        $('#max_price').on('input', function() {
            $('#priceValResult').text('₹' + parseInt($(this).val()).toLocaleString());
        });

        $('#max_price, input[name="transmission"], #fuel_type, #sort_by').on('change', function() {
            updateResults();
        });
    });
</script>
@endsection
