@extends('admin.layout')

@section('title', 'Manage Coupons')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Promo Codes & Coupons</h2>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addCouponModal">
            <i class="fas fa-plus me-2"></i> Create Coupon
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Min. Spend</th>
                        <th>Expires</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td class="ps-4">
                                <div class="badge bg-dark px-3 py-2 fs-6 fw-bold letter-spacing-1">{{ $coupon->code }}</div>
                            </td>
                            <td>{{ ucfirst($coupon->type) }}</td>
                            <td>
                                <span class="fw-bold">{{ $coupon->type == 'percent' ? $coupon->value . '%' : '₹' . number_format($coupon->value) }}</span>
                            </td>
                            <td>₹{{ number_format($coupon->min_booking_amount) }}</td>
                            <td>
                                @if($coupon->expires_at)
                                    <div class="small {{ $coupon->expires_at->isPast() ? 'text-danger' : 'text-dark' }}">
                                        {{ $coupon->expires_at->format('M d, Y') }}
                                    </div>
                                    @if($coupon->expires_at->isPast()) <span class="badge bg-danger p-1 small">Expired</span> @endif
                                @else
                                    <span class="text-muted small">No Expiry</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.coupons.toggle', $coupon->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" onChange="this.form.submit()" {{ $coupon->is_active ? 'checked' : '' }}>
                                        <span class="small {{ $coupon->is_active ? 'text-success' : 'text-muted' }}">
                                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </form>
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Delete this coupon?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-circle">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-5 text-muted">No coupons created yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Coupon Modal -->
<div class="modal fade" id="addCouponModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold">New Promo Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Coupon Code</label>
                        <input type="text" name="code" class="form-control bg-light border-0" placeholder="e.g. SUMMER500" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Type</label>
                            <select name="type" class="form-select bg-light border-0">
                                <option value="fixed">Fixed Amount (₹)</option>
                                <option value="percent">Percentage (%)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Value</label>
                            <input type="number" name="value" class="form-control bg-light border-0" required min="1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Min. Booking Amount (₹)</label>
                        <input type="number" name="min_booking_amount" class="form-control bg-light border-0" value="0">
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Expiry Date</label>
                        <input type="date" name="expires_at" class="form-control bg-light border-0">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold w-100 py-2">Create Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .letter-spacing-1 { letter-spacing: 1px; }
</style>
@endsection
