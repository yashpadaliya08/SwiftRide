<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SwiftRide - @yield('title')</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

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
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 2000;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            padding: 1rem 0;
        }

        .navbar.scrolled {
            padding: 0.6rem 0;
            background: rgba(13, 17, 23, 0.95) !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        body {
            padding-top: 85px;
        }

        .navbar-brand {
            font-weight: 900 !important;
            color: #fff !important;
            font-size: 1.8rem;
            letter-spacing: -1px;
        }

        .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem !important;
            border-radius: 50px;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #fff !important;
            background: rgba(255,255,255,0.1);
        }

        .navbar-toggler {
            border: none;
            padding: 0;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler-icon {
            filter: invert(1);
        }

        footer {
            background-color: #0d1117;
            color: #fff;
            padding: 60px 0;
            font-weight: 500;
        }

        /* Buttons */
        .btn-primary {
            background-color: #d12e2e;
            border-color: #d12e2e;
            font-weight: 700;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #b32525;
            border-color: #b32525;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(209, 46, 46, 0.3);
        }

        /* Headings */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Section padding */
        section {
            padding: 5rem 0;
        }

        /* Elevate effect */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
        }

        .fw-black { font-weight: 900 !important; }
        .text-primary { color: #d12e2e !important; }
        .bg-primary { background-color: #d12e2e !important; }
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
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 text-md-start mb-3 mb-md-0">
                    <a class="navbar-brand text-white fs-4" href="{{ url('/') }}">SwiftRide</a>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" class="text-white opacity-50"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white opacity-50"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white opacity-50"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <p class="mb-0 small text-muted">&copy; {{ date('Y') }} SwiftRide. All rights reserved.</p>
                </div>
            </div>
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

    <script>
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>