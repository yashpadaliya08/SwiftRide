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
                    <div class="ms-auto">
                        <!-- Dark mode toggle removed -->
                    </div>
                </div>
            </nav>

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
