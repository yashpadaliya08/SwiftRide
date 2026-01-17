@extends('admin.layout')

@section('title', 'User Management')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">User Management</h2>
            <p class="text-muted mb-0">Manage registered clients and their account status.</p>
        </div>
        <div>
            <button class="btn btn-primary shadow-sm" onclick="alert('Demo: Invite feature coming soon!')">
                <i class="fas fa-user-plus me-2"></i> Invite User
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 py-3">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-1 small">Total Users</h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ $users->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
             <div class="card border-0 shadow-sm h-100 py-3">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-user-check fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-1 small">Active Today</h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ $users->where('updated_at', '>=', now()->subDay())->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-md-4">
             <div class="card border-0 shadow-sm h-100 py-3">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-user-shield fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold mb-1 small">Verified Users</h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ $users->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
             <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-list me-2"></i> Registered Clients</h6>
             <div class="input-group w-25">
                 <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                 <input type="text" class="form-control bg-light border-start-0" placeholder="Search users..." id="userSearch">
             </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Client Name</th>
                        <th>Email Address</th>
                        <th>Joined Date</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3 fw-bold shadow-sm" style="width: 40px; height: 40px; font-size: 1.1rem;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="small text-muted">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="mailto:{{ $user->email }}" class="text-decoration-none text-secondary">
                                    <i class="far fa-envelope me-1"></i> {{ $user->email }}
                                </a>
                            </td>
                            <td>
                                <div class="text-dark">{{ $user->created_at->format('M d, Y') }}</div>
                                <div class="small text-muted">{{ $user->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Active
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v text-muted"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-history me-2 text-primary"></i> View History</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash-alt me-2"></i> Delete User
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-transparent border-0 py-3">
             <!-- Pagination could go here -->
               <div class="small text-muted">Showing all {{ $users->count() }} users</div>
        </div>
    </div>
</div>

<script>
    // Simple Client-Side Search
    document.getElementById('userSearch').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#usersTableBody tr');
        
        rows.forEach(function(row) {
            let text = row.textContent.toLowerCase();
            row.style.display = text.indexOf(value) > -1 ? '' : 'none';
        });
    });
</script>
@endsection
