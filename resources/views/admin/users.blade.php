@extends('admin.layout')

@section('title', 'Registered Users')

@section('content')
<div class="container-fluid fade-in-up py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold">Registered Users</h2>
        <span class="badge bg-primary badge-animated">{{ date('F d, Y') }}</span>
    </div>

    <div class="card shadow-lg rounded-4">
        <div class="card-body table-responsive p-3">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width:5%;">#ID</th>
                        <th scope="col" style="width:25%;">Name</th>
                        <th scope="col" style="width:30%;">Email</th>
                        <th scope="col" style="width:25%;">Password (Hashed)</th>
                        <th scope="col" style="width:15%;">Registered On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="table-row-hover">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><code>{{ $user->password }}</code></td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Fade in from below */
    .fade-in-up {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Animate badge background color pulse */
    .badge-animated {
        animation: pulse-bg 2.5s ease-in-out infinite;
        font-weight: 600;
        font-size: 1rem;
        padding: 0.45em 1em;
        border-radius: 1rem;
        user-select: none;
    }

    @keyframes pulse-bg {
        0%, 100% {
            background-color: #0d6efd;
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.5);
        }
        50% {
            background-color: #0b5ed7;
            box-shadow: 0 0 14px rgba(11, 94, 215, 0.75);
        }
    }

    /* Table row hover effect */
    .table-row-hover:hover {
        background-color: #e9f5ff;
        transition: background-color 0.25s ease;
        cursor: default;
    }

    /* Code style for password field */
    td code {
        background-color: #f8f9fa;
        padding: 0.15em 0.4em;
        border-radius: 4px;
        font-family: monospace;
        font-size: 0.875rem;
        user-select: text;
        color: #444;
    }

    /* Card improvements */
    .card {
        border: none;
    }
</style>
@endsection
