@extends('admin.layout')

@section('title', 'Manage Reviews')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Customer Reviews</h2>
        <span class="badge bg-primary rounded-pill px-3">{{ $reviews->total() }} Total</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Customer</th>
                        <th>Vehicle</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $review->user->name }}</div>
                                <div class="small text-muted">{{ $review->created_at->format('M d, Y') }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $review->car->brand }} {{ $review->car->model }}</div>
                            </td>
                            <td>
                                <div class="text-warning">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-light opacity-50' }}"></i>
                                    @endfor
                                </div>
                            </td>
                            <td>
                                <div class="small text-truncate" style="max-width: 250px;" title="{{ $review->comment }}">
                                    {{ $review->comment ?? 'No comment' }}
                                </div>
                            </td>
                            <td>
                                @if($review->is_approved)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Approved</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">Pending</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    @if(!$review->is_approved)
                                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-success rounded-pill px-3 fw-bold">Approve</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No reviews found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reviews->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
