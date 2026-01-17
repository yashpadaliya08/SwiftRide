@extends('admin.layout')

@section('title', 'Admin Settings')

@section('content')
<div class="container-fluid py-4 fade-in-up">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Settings</h2>
            <p class="text-muted mb-0">Manage profile and system configurations.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3">
            <div class="list-group list-group-flush shadow-sm rounded-4 overflow-hidden">
                <a href="#" class="list-group-item list-group-item-action active py-3">
                    <i class="fas fa-user-circle me-3"></i> My Profile
                </a>
                <a href="#" class="list-group-item list-group-item-action py-3">
                    <i class="fas fa-lock me-3"></i> Security
                </a>
                <a href="#" class="list-group-item list-group-item-action py-3">
                    <i class="fas fa-sliders-h me-3"></i> System Config
                </a>
                <a href="#" class="list-group-item list-group-item-action py-3 text-danger">
                    <i class="fas fa-trash-alt me-3"></i> Clear Cache
                </a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-lg-9">
            
            <!-- Profile Section -->
            <div class="card shadow-sm border-0 mb-4 rounded-4 profile-section">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="mb-0 fw-bold">Profile Details</h5>
                </div>
                <div class="card-body p-4">
                    <form onsubmit="event.preventDefault(); alert('Demo: Profile update saved!');">
                        <div class="row align-items-center mb-4">
                            <div class="col-auto">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fs-3 fw-bold shadow-sm" style="width: 80px; height: 80px;">
                                    A
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="fw-bold mb-1">Admin Photo</h6>
                                <div class="text-muted small mb-2">Recommended size: 200x200px</div>
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3">Upload New</button>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">First Name</label>
                                <input type="text" class="form-control" value="SwiftRide" placeholder="First Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Last Name</label>
                                <input type="text" class="form-control" value="Admin" placeholder="Last Name">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted">Email Address</label>
                                <input type="email" class="form-control" value="admin@swiftride.com" placeholder="name@example.com">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill shadow-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Section -->
            <div class="card shadow-sm border-0 mb-4 rounded-4 security-section">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="mb-0 fw-bold">Login & Security</h5>
                </div>
                <div class="card-body p-4">
                    <form onsubmit="event.preventDefault(); alert('Demo: Password updated!');">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Current Password</label>
                            <input type="password" class="form-control" placeholder="Enter current password">
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">New Password</label>
                                <input type="password" class="form-control" placeholder="Enter new password">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Confirm Password</label>
                                <input type="password" class="form-control" placeholder="Confirm new password">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-secondary fw-bold px-4 rounded-pill">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .list-group-item {
        border: none;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        font-weight: 500;
        color: #555;
        transition: all 0.2s;
    }
    .list-group-item:last-child { border-bottom: none; }
    .list-group-item:hover { background-color: #f8f9fa; color: #0d6efd; padding-left: 1.25rem; }
    .list-group-item.active {
        background-color: #e7f1ff;
        color: #0d6efd !important;
        border-left: 4px solid #0d6efd;
    }
    
    .fade-in-up {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection