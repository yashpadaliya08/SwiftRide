<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SwiftRide Admin</title>

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Embedded Styles -->
    <style>
        body {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 1rem;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .card-body i {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 0.6rem;
            border-radius: 50%;
        }

        .table-hover tbody tr:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        .btn-theme {
            background-color: #0d6efd;
            color: white;
        }

        .btn-theme:hover {
            background-color: #084298;
            color: white;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        @include('admin.partials.sidebar')

        <div class="flex-grow-1 overflow-auto">
            <!-- Admin Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
                <div class="container-fluid">
                    <span class="navbar-brand fw-bold">SwiftRide Admin</span>
                    <div class="ms-auto d-flex align-items-center gap-3">
                        <div class="position-relative cursor-pointer" id="notificationBell">
                            <i class="fas fa-bell fa-lg text-muted"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display: none;">
                                0
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </div>
                        <!-- Profile/User Dropdown could go here -->
                    </div>
                </div>
            </nav>

            <!-- Toast Container -->
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                         <div class="rounded me-2 bg-primary" style="width: 20px; height: 20px;"></div>
                        <strong class="me-auto">New Booking!</strong>
                        <small>Just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        A new booking request has been received.
                    </div>
                </div>
            </div>

            <script>
                // Simple Polling Simulation for Demo
                // In a real app, you would fetch an endpoint like /admin/api/notifications
                document.addEventListener('DOMContentLoaded', function() {
                    const badge = document.getElementById('notificationBadge');
                    const toastEl = document.getElementById('liveToast');
                    const toast = new bootstrap.Toast(toastEl);
                    let count = 0;

                    // Simulate a new notification every 45 seconds
                    setInterval(() => {
                        count++;
                        badge.innerText = count;
                        badge.style.display = 'block';
                        
                        // Show toast
                        toast.show();
                        
                        // Optional: Play sound
                        // new Audio('/path/to/sound.mp3').play();
                    }, 45000);
                });
            </script>

            <main class="p-4">
                @yield('content')
            </main>
            @stack('script')
            <!-- @yield('scripts') -->
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Dark mode script removed -->
</body>

</html>
