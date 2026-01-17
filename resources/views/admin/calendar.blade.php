@extends('admin.layout')

@section('title', 'Fleet Calendar')

@section('content')
<style>
    /* Premium Calendar Overrides */
    :root {
        --fc-border-color: #f1f3f5;
        --fc-button-text-color: #495057;
        --fc-button-bg-color: #ffffff;
        --fc-button-border-color: #dee2e6;
        --fc-button-hover-bg-color: #f8f9fa;
        --fc-button-hover-border-color: #dee2e6;
        --fc-button-active-bg-color: #0d6efd;
        --fc-button-active-border-color: #0d6efd;
        --fc-button-active-text-color: #fff;
        --fc-event-bg-color: #3788d8;
        --fc-event-border-color: #3788d8;
        --fc-today-bg-color: rgba(13, 110, 253, 0.04);
    }

    /* Container adjustments */
    .calendar-card {
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
    }

    /* Toolbar Styling */
    .fc-header-toolbar {
        padding: 1.5rem;
        margin-bottom: 0 !important;
        background: #fff;
    }

    .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 800;
        color: #212529;
        letter-spacing: -0.5px;
    }

    .fc-button {
        border-radius: 8px !important;
        padding: 0.5rem 1rem !important;
        font-weight: 600 !important;
        font-size: 0.9rem !important;
        text-transform: capitalize !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }
    
    .fc-button:focus {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25) !important;
    }

    /* Grid & Cells */
    .fc-scrollgrid {
        border: none !important;
    }
    
    .fc-col-header-cell {
        background: #f8f9fa;
        padding: 1rem 0;
        border-bottom: 1px solid #dee2e6 !important;
    }
    
    .fc-col-header-cell-cushion {
        color: #6c757d;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 700;
        text-decoration: none !important;
    }

    .fc-daygrid-day-top {
        flex-direction: row;
        padding: 8px 12px;
    }

    .fc-daygrid-day-number {
        font-size: 0.9rem;
        font-weight: 600;
        color: #495057;
        text-decoration: none !important;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .fc-day-today .fc-daygrid-day-number {
        background: #0d6efd;
        color: #fff;
    }

    /* Events Styling */
    .fc-event {
        border: none !important;
        border-radius: 6px;
        margin: 2px 4px !important;
        padding: 3px 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08); /* Soft shadow */
        font-size: 0.8rem;
        line-height: 1.3;
    }

    .fc-event-main {
        display: flex;
        align-items: center;
        font-weight: 500;
        overflow: hidden; 
    }
    
    /* Small dot instead of time */
    .fc-event-main::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: rgba(255,255,255,0.8);
        margin-right: 6px;
        flex-shrink: 0;
    }
    
    /* Hide the default time text */
    .fc-event-time { 
        display: none; 
    }

</style>

<div class="container-fluid py-4 h-100">
    <!-- Clean Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">Fleet Schedule</h2>
            <p class="text-muted mb-0">Overview of vehicle bookings and availability.</p>
        </div>
    </div>

    <!-- Calendar Container -->
    <div class="card border-0 shadow-lg calendar-card" style="min-height: 750px;">
        <div id="calendar" class="h-100"></div>
    </div>
</div>

<!-- FullCalendar CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<!-- Tooltip -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'standard', // Use standard to allow full custom CSS override
            headerToolbar: {
                left: 'prev,today,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            height: '100%',
            contentHeight: 'auto',
            aspectRatio: 1.8, 
            navLinks: true, // can click day/week names to navigate views
            events: {!! json_encode($bookings) !!},
            
            // Custom Event Rendering
            eventDidMount: function(info) {
                // Tooltip
                tippy(info.el, {
                    content: `
                        <div style="text-align: center;">
                            <strong>${info.event.title}</strong><br>
                            <span style="opacity:0.8; font-size:0.8em;">Includes Time</span>
                        </div>
                    `,
                    allowHTML: true,
                    placement: 'top',
                    theme: 'light',
                    animation: 'shift-away'
                });
            },
            
            eventClick: function(info) {
                if (info.event.url) {
                    window.location.href = info.event.url;
                    info.jsEvent.preventDefault();
                }
            }
        });
        calendar.render();
    });
</script>
@endsection
