@extends('admin.layout')

@section('title', 'Add New Vehicle')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Add New Vehicle</h2>
            <p class="text-muted mb-0">Enter vehicle details to add to fleet</p>
        </div>
        <a href="{{ route('admin.cars.index') }}" class="btn btn-light border shadow-sm px-4">
            <i class="fas fa-times me-2"></i> Cancel
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form id="carForm" action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="card shadow-sm border-0 mb-4 rounded-3 overflow-hidden">
                    <div class="card-header bg-light border-bottom py-3 px-4">
                        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-car me-2"></i> Vehicle Information</h6>
                    </div>
                    <div class="card-body p-4">
                        <!-- Primary Info -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Vehicle Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="name" placeholder="e.g. BMW X5 M-Sport" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Brand <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg" name="brand" required>
                                    <option value="" disabled selected>Select Brand</option>
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
                                <input type="text" class="form-control form-control-lg" name="model" placeholder="e.g. X5" value="{{ old('model') }}" required>
                            </div>
                        </div>

                        <!-- Specs Row 1 -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Body Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="type" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="SUV">SUV</option>
                                    <option value="Sedan">Sedan</option>
                                    <option value="Hatchback">Hatchback</option>
                                    <option value="Luxury">Luxury</option>
                                    <option value="Convertible">Convertible</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Wait, Transmission <span class="text-danger">*</span></label>
                                <select class="form-select" name="transmission" required>
                                    <option value="automatic" selected>Automatic</option>
                                    <option value="manual">Manual</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Fuel Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="fuel_type" required>
                                    <option value="petrol" selected>Petrol</option>
                                    <option value="diesel">Diesel</option>
                                    <option value="electric">Electric</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Seats <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="seats" value="{{ old('seats', 5) }}" min="1" max="50" required>
                            </div>
                        </div>

                        <!-- Specs Row 2 -->
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Manufacturing Year <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="year" placeholder="YYYY" value="{{ date('Y') }}" min="2000" max="{{ date('Y') + 1 }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Color</label>
                                <input type="text" class="form-control" name="color" placeholder="e.g. Black" value="{{ old('color') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Price Per Day (₹) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold">₹</span>
                                    <input type="number" class="form-control form-control-lg fw-bold text-primary" name="price_per_day" placeholder="0.00" required>
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
                                    <label class="form-label fw-bold small text-uppercase text-muted">Upload Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(this)">
                                    <div class="form-text">Supported formats: JPG, PNG. Max size: 2MB.</div>
                                </div>
                                <div id="imagePreview" class="d-none mt-3 p-2 border rounded bg-light text-center">
                                    <img src="" class="img-fluid rounded" style="max-height: 200px;">
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
                                        <option value="available" class="text-success fw-bold">Available</option>
                                        <option value="unavailable" class="text-danger fw-bold">Unavailable</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">
                                    <i class="fas fa-save me-2"></i> Save Vehicle
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden Description (Optional) -->
                <input type="hidden" name="description" value="Premium vehicle for rent.">

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
                preview.classList.remove('d-none');
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
