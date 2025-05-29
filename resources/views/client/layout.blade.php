<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SwiftRide - @yield('title')</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script> -->

    <style>
        body {
            background-color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #212529;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #d32f2f, #1976d2);
        }

        .navbar-brand {
            font-weight: 700;
            color: #fff !important;
            font-size: 1.8rem;
            letter-spacing: 1px;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #000 !important;
            text-decoration: underline;
        }

        .navbar-toggler {
            border-color: #fff;
        }

        .navbar-toggler-icon {
            filter: invert(1);
        }

        footer {
            background-color: #000;
            color: #fff;
            padding: 20px 0;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Buttons */
        .btn-primary {
            background-color: #d32f2f;
            border-color: #d32f2f;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #b71c1c;
            border-color: #b71c1c;
        }

        /* Headings */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
        }

        /* Section padding */
        section {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }

        /* Elevate effect on hover */
        .elevate-on-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .elevate-on-hover:hover,
        .elevate-on-hover:focus {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            z-index: 10;
        }

        .typing-title {
            font-family: monospace, monospace;
            overflow: hidden;
            /* Ensures the content is hidden */
            white-space: nowrap;
            border-right: 3px solid #d32f2f;
            /* Cursor effect */
            animation: typing 3s steps(40, end), blink-caret 0.75s step-end infinite;
            width: 0;
            /* Start hidden */
        }

        @keyframes typing {
            from {
                width: 0
            }

            to {
                width: 100%
            }
        }

        @keyframes blink-caret {

            0%,
            100% {
                border-color: transparent
            }

            50% {
                border-color: #d32f2f
            }
        }

        .theme-accent {
            color: #e74c3c !important;
            /* Rich red-orange */
        }

        .btn-theme {
            background-color: #e74c3c;
            color: #fff;
            border: none;
        }

        .btn-theme:hover {
            background-color: #c0392b;
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">SwiftRide</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-3 align-items-center">

                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('booking.selectCriteria') }}">Browse Cars</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/my_bookings') }}">My Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>

                    @guest
                        <!-- User NOT logged in -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="guestDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-4"></i> <!-- Bootstrap Icons profile icon -->
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="guestDropdown">
                                <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                            </ul>
                        </li>
                    @else
                        <!-- User IS logged in -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-4"></i> <!-- Profile icon -->
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest

                </ul>
            </div>
        </div>
    </nav>

    <!-- Include Bootstrap Icons CDN in your <head> or before closing body tag -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Page Content -->
    <main class="py-5">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} SwiftRide. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery Validation Plugin -->
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


    <!-- Your custom script -->
    @yield('scripts')
    @stack('scripts')

</body>

</html>