@extends('admin.layout')

@section('title', 'Edit Vehicle')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Edit Vehicle</h2>
            <p class="text-muted mb-0">Update fleet details for {{ $car->name }}</p>
        </div>
        <a href="{{ route('admin.cars.index') }}" class="btn btn-light border shadow-sm px-4">
            <i class="fas fa-times me-2"></i> Cancel
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form id="editCarForm" action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <div class="card shadow-sm border-0 mb-4 rounded-3 overflow-hidden">
                    <div class="card-header bg-light border-bottom py-3 px-4">
                        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-car me-2"></i> Vehicle Information</h6>
                    </div>
                    <div class="card-body p-4">
                        <!-- Primary Info -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Vehicle Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="name" value="{{ old('name', $car->name) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Brand <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg" name="brand" required>
                                    <option value="{{ $car->brand }}" selected>{{ $car->brand }}</option>
                                    <option value="Toyota">Toyota</option>
                                    <option value="Honda">Honda</option>
                                    <option value="BMW">BMW</option>
                                    <option value="Mercedes">Mercedes</option>
                                    <option value="Audi">Audi</option>
                                    <option value="Tesla">Tesla</option>
                                    <option value="Ford">Ford</option>
                                    <option value="Hyundai">Hyundai</option>
                                    <option value="Tata">Tata</option>
                                    <option value="Mahindra">Mahindra</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Model <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="model" value="{{ old('model', $car->model) }}" required>
                            </div>
                        </div>

                        <!-- Specs Row 1 -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Body Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="type" required>
                                    @foreach(['SUV', 'Sedan', 'Hatchback', 'Luxury', 'Convertible'] as $type)
                                        <option value="{{ $type }}" {{ $car->type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Transmission <span class="text-danger">*</span></label>
                                <select class="form-select" name="transmission" required>
                                    <option value="manual" {{ ($car->transmission ?? 'manual') == 'manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="automatic" {{ ($car->transmission ?? '') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Fuel Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="fuel_type" required>
                                    @foreach(['petrol', 'diesel', 'electric', 'hybrid'] as $fuel)
                                        <option value="{{ $fuel }}" {{ ($car->fuel_type ?? 'petrol') == $fuel ? 'selected' : '' }}>{{ ucfirst($fuel) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Seats <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="seats" value="{{ old('seats', $car->seats ?? 5) }}" min="1" max="50" required>
                            </div>
                        </div>

                        <!-- Specs Row 2 -->
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Manufacturing Year <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="year" value="{{ old('year', $car->year) }}" min="2000" max="{{ date('Y') + 1 }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Color</label>
                                <input type="text" class="form-control" name="color" value="{{ old('color', $car->color) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Price Per Day (₹) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold">₹</span>
                                    <input type="number" class="form-control form-control-lg fw-bold text-primary" name="price_per_day" value="{{ old('price_per_day', $car->price_per_day) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photos & status -->
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="card shadow-sm border-0 rounded-3 h-100">
                             <div class="card-header bg-light border-bottom py-3 px-4">
                                <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-image me-2"></i> Vehicle Media</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase text-muted">Upload New Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(this)">
                                    <div class="form-text">Leave empty to keep current image.</div>
                                </div>
                                <div id="imagePreview" class="mt-3 p-2 border rounded bg-light text-center">
                                    <img src="{{ $car->image ? asset('storage/' . $car->image) : asset('assets/img/subaru.png') }}" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100">
                             <div class="card-header bg-light border-bottom py-3 px-4">
                                <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-toggle-on me-2"></i> Status & Save</h6>
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase text-muted">Availability</label>
                                    <select class="form-select form-select-lg" name="status">
                                        <option value="available" {{ $car->status == 'available' ? 'selected' : '' }} class="text-success fw-bold">Available</option>
                                        <option value="unavailable" {{ $car->status == 'unavailable' ? 'selected' : '' }} class="text-danger fw-bold">Unavailable</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">
                                    <i class="fas fa-save me-2"></i> Update Vehicle
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description hidden/preserved -->
                <input type="hidden" name="description" value="{{ $car->description }}">

            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                const img = preview.querySelector('img');
                img.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    .form-label {
        letter-spacing: 0.5px;
        font-size: 0.75rem;
    }
    .form-control-lg, .form-select-lg {
        font-size: 1rem;
        padding: 0.75rem 1rem;
    }
    .card {
        transition: transform 0.2s;
    }
</style>
@endsection