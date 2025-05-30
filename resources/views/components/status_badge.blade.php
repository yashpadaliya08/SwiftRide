@php
    $status = $booking->status;
@endphp

@if($status === 'cancelled')
    <span class="badge bg-danger">Cancelled</span>
@elseif($status === 'completed')
    <span class="badge bg-secondary">Completed</span>
@elseif($status === 'active')
    <span class="badge bg-success">Active</span>
@elseif($status === 'confirmed')
    <span class="badge bg-warning text-dark">Upcoming</span>
@else
    <span class="badge bg-dark">Unknown</span>
@endif
