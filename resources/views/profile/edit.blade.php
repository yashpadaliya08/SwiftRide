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

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                                <input type="text" name="name" class="form-control bg-light border-0 py-3" value="{{ old('name', $user->name) }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
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
@endsection
