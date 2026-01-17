@extends('admin.layout')

@section('title', 'Inbox')

@section('content')
<div class="container-fluid py-4 h-100">
     <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Message Inbox</h2>
            <p class="text-muted mb-0">Customer inquiries and support tickets.</p>
        </div>
        <button class="btn btn-outline-primary rounded-pill px-4 shadow-sm" onclick="location.reload()">
            <i class="fas fa-sync-alt me-2"></i> Refresh
        </button>
    </div>

    <div class="row h-100">
        <!-- Sidebar / Message List -->
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card shadow-sm border-0 h-100 d-flex flex-column">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control bg-light border-start-0" placeholder="Search messages...">
                    </div>
                </div>
                <div class="list-group list-group-flush overflow-auto" style="max-height: 600px;">
                    @forelse($messages as $msg)
                        <a href="#" class="list-group-item list-group-item-action py-3 lh-sm message-item" 
                           onclick="openMessage({{ $msg->id }}, '{{ addslashes($msg->name) }}', '{{ $msg->email }}', '{{ $msg->issue_type }}', '{{ $msg->created_at->format('M d, h:i A') }}', '{{ addslashes(str_replace(["\r", "\n"], " ", $msg->message)) }}')">
                            <div class="d-flex w-100 align-items-center justify-content-between mb-1">
                                <strong class="text-truncate">{{ $msg->name }}</strong>
                                <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="small fw-bold text-dark mb-1">{{ $msg->issue_type }}</div>
                            <div class="col-10 mb-1 small text-muted text-truncate">
                                {{ $msg->message }}
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="far fa-envelope-open fa-3x mb-3 opacity-50"></i>
                            <p>No messages found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Message Detail View -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100" id="messageViewPlaceholder">
                 <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted h-100" style="min-height: 400px;">
                    <i class="far fa-paper-plane fa-4x mb-3 opacity-25"></i>
                    <h5>Select a message to read</h5>
                </div>
            </div>

            <div class="card shadow-sm border-0 h-100 d-none" id="messageViewContent">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <div>
                         <span class="badge bg-primary me-2" id="detailIssue">Support</span>
                         <span class="text-muted small" id="detailDate">Today</span>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-light btn-sm" title="Reply"><i class="fas fa-reply"></i></button>
                        <button class="btn btn-light btn-sm text-danger" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
                <div class="card-body p-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 fs-5" style="width: 48px; height: 48px;" id="detailAvatar">
                            A
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold" id="detailName">Name</h5>
                            <div class="text-muted small" id="detailEmail">email@example.com</div>
                        </div>
                    </div>
                    
                    <div class="bg-light p-4 rounded-3 border">
                        <p class="mb-0 text-dark" style="white-space: pre-wrap; line-height: 1.6;" id="detailBody">
                            Message content...
                        </p>
                    </div>

                    <div class="mt-5">
                        <h6 class="fw-bold mb-3">Quick Reply</h6>
                        <textarea class="form-control mb-3" rows="4" placeholder="Type your reply here..."></textarea>
                        <button class="btn btn-primary px-4"><i class="fas fa-paper-plane me-2"></i> Send Reply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openMessage(id, name, email, issue, date, body) {
        // Hide placeholder, show content
        document.getElementById('messageViewPlaceholder').classList.add('d-none');
        document.getElementById('messageViewContent').classList.remove('d-none');

        // Populate fields
        document.getElementById('detailName').textContent = name;
        document.getElementById('detailEmail').textContent = email;
        document.getElementById('detailIssue').textContent = issue;
        document.getElementById('detailDate').textContent = date;
        document.getElementById('detailBody').textContent = body;
        document.getElementById('detailAvatar').textContent = name.charAt(0).toUpperCase();

        // Highlight active sidebar item
        document.querySelectorAll('.list-group-item').forEach(el => el.classList.remove('active', 'bg-light'));
        // Find the specific summary item - tricky without ID interaction, simple bold logic for now or:
        // In a real app, we'd add 'active' class to the clicked element via 'this'
    }
</script>
@endsection
