@extends('admin.layout')

@section('title', $car->brand . ' ' . $car->model . ' - Vehicle Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('admin.cars.index') }}" class="btn btn-sm btn-light border text-muted">
                    <i class="fas fa-arrow-left me-1"></i> Fleet
                </a>
                <h2 class="mb-0 fw-bold text-dark">{{ $car->brand }} {{ $car->model }}</h2>
                <span class="badge {{ $car->status === 'available' ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2 text-uppercase">
                    {{ $car->status }}
                </span>
            </div>
            <p class="text-muted mb-0 small">Registered vehicle: {{ $car->name }} (ID #{{ $car->id }})</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-primary px-4 fw-bold shadow-sm">
                <i class="fas fa-edit me-2"></i> Edit Vehicle
            </a>
            <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vehicle? This action cannot be undone.');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger px-3">
                    <i class="fas fa-trash-alt me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Vehicle Media & Highlight -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                <div class="position-relative bg-light text-center p-3" style="min-height: 280px;">
                    <img src="{{ $car->image ? asset('storage/' . $car->image) : asset('assets/img/subaru.png') }}"
                         alt="{{ $car->name }}"
                         class="img-fluid rounded-3 object-fit-cover w-100"
                         style="max-height: 320px;">
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-dark bg-opacity-75 text-white px-3 py-2 rounded-pill">
                            <i class="fas fa-calendar-alt me-1"></i> {{ $car->year }}
                        </span>
                    </div>
                    <div class="position-absolute bottom-0 end-0 m-3">
                        <span class="badge bg-primary text-white fs-6 px-3 py-2 rounded-pill shadow">
                            ₹{{ number_format($car->price_per_day) }} <small class="fw-normal">/ day</small>
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-dark">Vehicle Overview</h5>
                    <p class="text-muted mb-0" style="line-height: 1.6;">
                        {{ $car->description ?: 'No detailed description recorded for this vehicle. Standard vehicle specifications apply according to the SwiftRide fleet charter.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Specifications & Details -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-cogs text-danger me-2"></i> Technical Specifications</h5>
                
                <div class="row g-3">
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted text-uppercase fw-bold small d-block mb-1" style="font-size: 0.7rem;">Brand</span>
                            <div class="fw-bold text-dark fs-6">{{ $car->brand }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted text-uppercase fw-bold small d-block mb-1" style="font-size: 0.7rem;">Model</span>
                            <div class="fw-bold text-dark fs-6">{{ $car->model }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted text-uppercase fw-bold small d-block mb-1" style="font-size: 0.7rem;">Body Type</span>
                            <div class="fw-bold text-dark fs-6">{{ $car->type ?? 'Sedan' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted text-uppercase fw-bold small d-block mb-1" style="font-size: 0.7rem;">Transmission</span>
                            <div class="fw-bold text-dark fs-6 text-capitalize">{{ $car->transmission ?? 'Automatic' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted text-uppercase fw-bold small d-block mb-1" style="font-size: 0.7rem;">Fuel Type</span>
                            <div class="fw-bold text-dark fs-6 text-capitalize">{{ $car->fuel_type ?? 'Petrol' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted text-uppercase fw-bold small d-block mb-1" style="font-size: 0.7rem;">Seating Capacity</span>
                            <div class="fw-bold text-dark fs-6">{{ $car->seats ?? 5 }} Passengers</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted text-uppercase fw-bold small d-block mb-1" style="font-size: 0.7rem;">Color</span>
                            <div class="fw-bold text-dark fs-6">{{ $car->color ?? 'Standard' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted text-uppercase fw-bold small d-block mb-1" style="font-size: 0.7rem;">Daily Tariff</span>
                            <div class="fw-bold text-danger fs-6">₹{{ number_format($car->price_per_day) }} / day</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted text-uppercase fw-bold small d-block mb-1" style="font-size: 0.7rem;">Fleet Status</span>
                            <div class="fw-bold {{ $car->status === 'available' ? 'text-success' : 'text-danger' }} fs-6 text-capitalize">
                                <i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i> {{ $car->status }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center text-muted small">
                    <span>Record Created: {{ $car->created_at ? $car->created_at->format('M d, Y h:i A') : 'N/A' }}</span>
                    <span>Last Updated: {{ $car->updated_at ? $car->updated_at->format('M d, Y h:i A') : 'N/A' }}</span>
                </div>
            </div>

            <!-- Recent Bookings for this Car -->
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-history text-primary me-2"></i> Recent Bookings</h5>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-link text-decoration-none">View All Bookings</a>
                </div>
                
                @if($car->bookings && $car->bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-muted small text-uppercase">
                                    <th>Booking #</th>
                                    <th>Customer</th>
                                    <th>Dates</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($car->bookings->take(5) as $b)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.bookings.show', $b->id) }}" class="fw-bold text-dark text-decoration-none">
                                                #{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td>{{ $b->name ?? $b->user?->name ?? 'Guest' }}</td>
                                        <td class="small">{{ \Carbon\Carbon::parse($b->start_datetime)->format('d M') }} - {{ \Carbon\Carbon::parse($b->end_datetime)->format('d M Y') }}</td>
                                        <td class="fw-bold">₹{{ number_format($b->total_price) }}</td>
                                        <td>
                                            <span class="badge {{ match($b->status) { 'confirmed' => 'bg-success', 'pending' => 'bg-warning text-dark', 'cancelled' => 'bg-danger', default => 'bg-secondary' } }} rounded-pill px-2 py-1 text-uppercase" style="font-size: 0.65rem;">
                                                {{ $b->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-calendar-times fa-2x mb-2 opacity-50"></i>
                        <p class="mb-0 small">No booking reservations recorded for this car yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
