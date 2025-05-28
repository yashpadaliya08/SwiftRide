@extends('admin.layout')

@section('title', 'Contact Messages')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Contact Messages</h2>
    </div>

    @if($messages->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-1"></i> No messages found.
        </div>
    @else
        <div class="card shadow-sm ">
            <div class="card-body table-responsive">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Issue Type</th>
                                <th scope="col">Message</th>
                                <th scope="col">Received At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message)
                            <tr>
                                <td>{{ $message->id }}</td>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->issue_type }}</td>
                                <td>{{ Str::limit($message->message, 60) }}</td>
                                <td>{{ $message->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
