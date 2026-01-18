@extends('client.layout')

@section('title', 'Manage Your Profile')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3 mb-4" data-aos="fade-right">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 2rem;">
                <div class="card-body p-0">
                    <div class="p-4 text-center border-bottom bg-light">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow" style="width: 70px; height: 70px;">
                            <span class="h2 mb-0">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <h6 class="fw-bold mb-1">{{ auth()->user()->name }}</h6>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </div>
                    <div class="list-group list-group-flush" id="profile-tabs" role="tablist">
                        <a class="list-group-item list-group-item-action active border-0 py-3" id="general-tab" data-bs-toggle="list" href="#general" role="tab">
                            <i class="fas fa-user-circle me-3 opacity-50"></i> General Info
                        </a>
                        <a class="list-group-item list-group-item-action border-0 py-3" id="security-tab" data-bs-toggle="list" href="#security" role="tab">
                            <i class="fas fa-shield-alt me-3 opacity-50"></i> Security
                        </a>
                        <a class="list-group-item list-group-item-action border-0 py-3 text-{{ auth()->user()->is_verified ? 'success' : 'warning' }}" id="verification-tab" data-bs-toggle="list" href="#verification" role="tab">
                            <i class="fas fa-{{ auth()->user()->is_verified ? 'check-circle' : 'id-card' }} me-3 opacity-50"></i> Verification
                        </a>
                        <a class="list-group-item list-group-item-action border-0 py-3 text-danger" id="danger-tab" data-bs-toggle="list" href="#danger" role="tab">
                            <i class="fas fa-trash-alt me-3 opacity-50"></i> Danger Zone
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-9" data-aos="fade-left">
            <div class="tab-content" id="nav-tabContent">
                
                <!-- General Info -->
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <h4 class="fw-bold mb-4">General Information</h4>
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                                    <input type="text" name="name" class="form-control bg-light border-0 py-3" value="{{ old('name', $user->name) }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Phone Number</label>
                                    <input type="text" name="phone" class="form-control bg-light border-0 py-3" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +91 98765 43210">
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                                <input type="email" name="email" class="form-control bg-light border-0 py-3" value="{{ old('email', $user->email) }}" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-2">
                                        <p class="small text-warning mb-1">Your email address is unverified.</p>
                                        <button form="send-verification" class="btn btn-link btn-sm p-0">Click here to re-send verification link.</button>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold py-2 shadow-sm">Save Changes</button>
                                @if (session('status') === 'profile-updated')
                                    <span class="text-success small"><i class="fas fa-check-circle me-1"></i> Saved!</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security / Password -->
                <div class="tab-pane fade" id="security" role="tabpanel">
                    <h4 class="fw-bold mb-4">Security Settings</h4>
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Current Password</label>
                                <input type="password" name="current_password" class="form-control bg-light border-0 py-3">
                                @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">New Password</label>
                                <input type="password" name="password" class="form-control bg-light border-0 py-3">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control bg-light border-0 py-3">
                                @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <button type="submit" class="btn btn-dark rounded-pill px-5 fw-bold py-2">Update Password</button>
                                @if (session('status') === 'password-updated')
                                    <span class="text-success small"><i class="fas fa-check-circle me-1"></i> Updated!</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Verification -->
                <div class="tab-pane fade" id="verification" role="tabpanel">
                    <h4 class="fw-bold mb-4">Account Verification</h4>
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <div class="text-center mb-5">
                            @if(auth()->user()->is_verified)
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                    <i class="fas fa-check-double fa-3x"></i>
                                </div>
                                <h4 class="fw-bold text-success">Verified Account</h4>
                                <p class="text-muted small">Your identity has been verified by our team. You have full access to all features.</p>
                            @else
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                    <i class="fas fa-shield-alt fa-3x"></i>
                                </div>
                                <h4 class="fw-bold">Verification Required</h4>
                                <p class="text-muted small">To start renting cars, we need to verify your driving license.</p>
                            @endif
                        </div>

                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="mb-5">
                                <label class="form-label small fw-bold text-muted text-uppercase mb-3 d-block text-center">Driving License Document</label>
                                
                                <div class="p-4 border border-dashed rounded-4 text-center bg-light mb-3">
                                    @if(auth()->user()->driving_license)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . auth()->user()->driving_license) }}" class="rounded shadow-sm" style="max-height: 150px;" alt="License">
                                        </div>
                                        <p class="small text-success fw-bold mb-1"><i class="fas fa-file-image me-2"></i> Document Uploaded</p>
                                        <p class="x-small text-muted mb-0">You can upload a new one to replace it.</p>
                                    @else
                                        <i class="fas fa-cloud-upload-alt fa-3x text-secondary opacity-25 mb-3"></i>
                                        <p class="small text-muted mb-0">Drag and drop or click to upload JPEG/PNG</p>
                                        <p class="x-small text-muted">Max size: 2MB</p>
                                    @endif
                                    <input type="file" name="driving_license" class="form-control mt-3" accept="image/*">
                                    @error('driving_license') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark rounded-pill py-3 fw-bold shadow-sm">
                                    {{ auth()->user()->driving_license ? 'Update Document' : 'Submit for Verification' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="tab-pane fade" id="danger" role="tabpanel">
                    <h4 class="fw-bold text-danger mb-4">Danger Zone</h4>
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 border-start border-danger border-4">
                        <h5 class="fw-bold mb-2">Delete Account</h5>
                        <p class="text-muted mb-4 small">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
                        
                        <button class="btn btn-outline-danger rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            Delete My Account
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-body p-4 p-md-5">
                <h5 class="fw-bold text-danger mb-3">Are you absolutely sure?</h5>
                <p class="text-muted small mb-4">This action cannot be undone. All your bookings and profile history will be wiped.</p>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Enter Password to Confirm</label>
                        <input type="password" name="password" class="form-control bg-light border-0 py-3" required>
                        @error('password', 'userDeletion') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill flex-fill fw-bold" data-bs-toggle="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger rounded-pill flex-fill fw-bold">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .list-group-item-action.active {
        background-color: rgba(13, 110, 253, 0.05) !important;
        color: var(--bs-primary) !important;
        border-right: 3px solid var(--bs-primary) !important;
        border-radius: 0 !important;
    }
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1) !important;
        border: 1px solid rgba(13, 110, 253, 0.2) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Tab Persistence (using localStorage)
        const activeTab = localStorage.getItem('profileActiveTab');
        if (activeTab) {
            const tabEl = document.querySelector(`a[href="${activeTab}"]`);
            if (tabEl) {
                const tab = new bootstrap.Tab(tabEl);
                tab.show();
            }
        }

        // 2. Auto-switch tab if there are errors
        @if($errors->hasAny(['driving_license']))
            const verificationTab = new bootstrap.Tab(document.querySelector('#verification-tab'));
            verificationTab.show();
        @elseif($errors->hasAny(['current_password', 'password']))
            const securityTab = new bootstrap.Tab(document.querySelector('#security-tab'));
            securityTab.show();
        @endif

        // 3. Save active tab on click
        document.querySelectorAll('a[data-bs-toggle="list"]').forEach(tabLink => {
            tabLink.addEventListener('shown.bs.tab', function (e) {
                localStorage.setItem('profileActiveTab', e.target.getAttribute('href'));
            });
        });
    });
</script>
@endsection
