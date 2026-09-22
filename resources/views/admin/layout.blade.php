<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SwiftRide Admin - Console</title>

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Google Font: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Embedded Theme Styles (Spaceship Slate & Crimson Glow) -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #ff3333, #c21a1a);
            --primary-glow: 0 0 15px rgba(255, 51, 51, 0.25);
            --accent-glow: 0 0 15px rgba(51, 153, 255, 0.2);
            --dark-sidebar: #090d16;
            --main-bg: #f8fafc;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            --border-light: rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: var(--main-bg);
            font-family: 'Outfit', sans-serif;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #ff3333;
        }

        /* Admin Navbar */
        .admin-navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-light);
            padding: 1.1rem 2rem !important;
        }

        .admin-navbar .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            color: #0f172a !important;
            letter-spacing: -0.5px;
        }

        /* Premium Cards */
        .card {
            border: 1px solid var(--border-light) !important;
            border-radius: 16px !important;
            box-shadow: var(--card-shadow) !important;
            background: #fff;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06) !important;
        }

        .card-body i.stat-icon {
            background: rgba(255, 51, 51, 0.08);
            color: #ff3333;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.25rem;
            box-shadow: var(--primary-glow);
        }

        /* Professional Tables */
        .table-responsive {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--border-light);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: #f8fafc !important;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 0.8px;
            color: #64748b;
            padding: 1rem 1.25rem;
            border-bottom: 1.5px solid #edf2f7 !important;
        }

        .table td {
            padding: 1rem 1.25rem;
            font-size: 0.88rem;
            font-weight: 550;
            color: #334155;
            vertical-align: middle;
            border-bottom: 1px solid #edf2f7;
            background-color: #fff !important;
        }

        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover td {
            background-color: #f8fafc !important;
            color: #ff3333;
        }

        /* Sidebar Styling Overrides */
        .sidebar-container {
            background: var(--dark-sidebar);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            width: 260px;
            min-height: 100vh;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-brand-link {
            font-weight: 900;
            font-size: 1.4rem;
            color: #fff !important;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #ff4d4d, #3399ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        .sidebar-brand-link::after {
            content: '';
            position: absolute;
            width: 5px;
            height: 5px;
            background: #ff4d4d;
            bottom: 5px;
            right: -8px;
            border-radius: 50%;
            box-shadow: 0 0 6px #ff4d4d;
        }

        .sidebar-nav .nav-link {
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.6) !important;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
            margin-bottom: 0.4rem;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-nav .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.08);
            transform: translateX(4px);
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, #ff3333, #c21a1a) !important;
            color: #fff !important;
            box-shadow: var(--primary-glow);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav .nav-link i {
            font-size: 1.05rem;
            transition: transform 0.3s ease;
        }

        .sidebar-nav .nav-link:hover i {
            transform: scale(1.15);
            color: #ff3333;
        }

        /* Buttons & Forms */
        .btn-primary {
            background: linear-gradient(135deg, #ff3333, #c21a1a);
            border: none;
            font-weight: 700;
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            box-shadow: var(--primary-glow);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #e02424, #a81313);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 51, 51, 0.4);
        }

        /* Form styling */
        .form-control, .form-select {
            background-color: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-weight: 550;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #ff3333;
            box-shadow: 0 0 10px rgba(255, 51, 51, 0.1);
        }

        /* Badges */
        .badge {
            font-weight: 700;
            padding: 0.55em 1em;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        @include('admin.partials.sidebar')

        <div class="flex-grow-1 overflow-auto vh-100">
            <!-- Admin Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light admin-navbar sticky-top">
                <div class="container-fluid">
                    <span class="navbar-brand">SwiftRide <span class="fw-normal text-muted">Admin Panel</span></span>
                    <div class="ms-auto d-flex align-items-center gap-4">
                        <div class="position-relative cursor-pointer" id="notificationBell" style="cursor: pointer;">
                            <i class="fas fa-bell fa-lg text-muted hover-red"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display: none; font-size: 0.65rem; padding: 0.35em 0.55em;">
                                0
                            </span>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Toast Container -->
            <div class="position-fixed bottom-0 end-0 p-4" style="z-index: 1100">
                <div id="liveToast" class="toast border-0 shadow-lg rounded-4 overflow-hidden" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-dark text-white border-0 py-3">
                        <div class="rounded-circle bg-danger me-2 shadow" style="width: 10px; height: 10px; box-shadow: var(--primary-glow);"></div>
                        <strong class="me-auto text-white">New Booking Notice</strong>
                        <small class="text-white-50">Just now</small>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body bg-white py-3" style="font-weight: 550; font-size: 0.9rem;">
                        A premium booking request has just been received on SwiftRide!
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="p-4">
                @yield('content')
            </main>
            @stack('script')
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Simple Polling Simulation for Demo
        document.addEventListener('DOMContentLoaded', function() {
            const badge = document.getElementById('notificationBadge');
            const toastEl = document.getElementById('liveToast');
            const toast = new bootstrap.Toast(toastEl);
            let count = 0;

            // Simulate a new notification every 60 seconds
            setInterval(() => {
                count++;
                badge.innerText = count;
                badge.style.display = 'inline-block';
                
                // Show toast
                toast.show();
            }, 60000);
        });
    </script>
</body>

</html>
