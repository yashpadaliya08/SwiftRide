@extends('admin.layout')

@section('title', 'Add New Car')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Add New Car</h2>
        <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Listings
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form id="carForm" action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Car Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" class="form-control" name="year" value="{{ old('year') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" name="brand" value="{{ old('brand') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" name="model" value="{{ old('model') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control" name="color" value="{{ old('color') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="price_per_day" class="form-label">Price per Day (₹)</label>
                        <input type="number" class="form-control" name="price_per_day" value="{{ old('price_per_day') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" name="type">
                            <option disabled selected value="">Select Type</option>
                            <option value="Hatchback">Hatchback</option>
                            <option value="Sedan">Sedan</option>
                            <option value="SUV">SUV</option>
                            <option value="Luxury">Luxury</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label">Car Image</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <div class="d-flex">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="fas fa-save me-1"></i> Save Car
                    </button>
                    <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- jQuery and jQuery Validation Plugin -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $('#carForm').validate({
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        rules: {
            name: { required: true },
            year: {
                required: true,
                digits: true,
                min: 1900,
                max: new Date().getFullYear()
            },
            brand: { required: true },
            model: { required: true },
            color: { required: true },
            price_per_day: {
                required: true,
                number: true,
                min: 1
            },
            type: { required: true }
        },
        messages: {
            name: "Car name is required.",
            year: {
                required: "Please enter year.",
                digits: "Year must be numeric.",
                min: "Minimum year is 1900.",
                max: "Year cannot be in the future."
            },
            brand: "Brand is required.",
            model: "Model is required.",
            color: "Color is required.",
            price_per_day: {
                required: "Enter price per day.",
                number: "Must be a valid number.",
                min: "Must be greater than zero."
            },
            type: "Please select a car type."
        }
    });
});
</script>
@endsection
