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

    <!-- Google Font: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #e02424, #0056b3);
            --crimson-glow: 0 0 20px rgba(224, 36, 36, 0.25);
            --sapphire-glow: 0 0 20px rgba(13, 110, 253, 0.25);
            --card-glow: 0 10px 30px rgba(0, 0, 0, 0.04);
            --dark-carbon: #0d1117;
            --light-bg: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Outfit', sans-serif;
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            padding-top: 90px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #e02424;
        }

        /* Navbar */
        .navbar {
            background: rgba(13, 17, 23, 0.9) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 2000;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            padding: 1.2rem 0;
        }

        .navbar.scrolled {
            padding: 0.7rem 0;
            background: rgba(13, 17, 23, 0.98) !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(224, 36, 36, 0.15);
        }

        .navbar-brand {
            font-weight: 900 !important;
            font-size: 1.9rem;
            letter-spacing: -1.2px;
            background: linear-gradient(135deg, #ff4d4d, #3399ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .navbar-brand::after {
            content: '';
            position: absolute;
            width: 6px;
            height: 6px;
            background: #ff4d4d;
            bottom: 8px;
            right: -8px;
            border-radius: 50%;
            box-shadow: 0 0 10px #ff4d4d;
        }

        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.75) !important;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            padding: 0.5rem 1.2rem !important;
            border-radius: 50px;
            border: 1px solid transparent;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .navbar .navbar-nav .dropdown-menu {
            background: #161b22;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            margin-top: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            padding: 0.5rem;
        }

        .navbar .dropdown-item {
            color: rgba(255, 255, 255, 0.75) !important;
            font-weight: 550;
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            transition: all 0.2s ease;
        }

        .navbar .dropdown-item:hover {
            background: rgba(224, 36, 36, 0.1) !important;
            color: #ff4d4d !important;
            transform: translateX(4px);
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

        /* Premium Footer */
        footer {
            background-color: var(--dark-carbon);
            color: #fff;
            padding: 80px 0 40px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            font-weight: 500;
        }

        footer .navbar-brand {
            font-size: 2.2rem;
        }

        footer a {
            transition: all 0.3s ease;
        }

        footer a:hover {
            color: #ff4d4d !important;
            transform: translateY(-2px);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #e02424, #c21a1a);
            border: none;
            font-weight: 700;
            letter-spacing: -0.2px;
            padding: 0.85rem 1.8rem;
            border-radius: 50px;
            box-shadow: var(--crimson-glow);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            color: #fff !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #c21a1a, #a81313);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(224, 36, 36, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            border: 2px solid #e02424;
            color: #e02424;
            background: transparent;
            font-weight: 700;
            padding: 0.8rem 1.8rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #e02424;
            color: #fff;
            box-shadow: var(--crimson-glow);
            transform: translateY(-3px);
        }

        /* Form Controls */
        .form-control, .form-select {
            background-color: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #e02424;
            box-shadow: 0 0 0 4px rgba(224, 36, 36, 0.15);
            background-color: #fff;
        }

        /* Headings */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--text-dark);
        }

        /* Section styling */
        section {
            padding: 6rem 0;
        }

        /* Cards & Hover Effects */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-glow);
            background: #fff;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08) !important;
        }

        .fw-black { font-weight: 900 !important; }
        .text-primary { color: #e02424 !important; }
        .bg-primary { background: linear-gradient(135deg, #e02424, #c21a1a) !important; }
        
        /* Badges */
        .badge {
            font-weight: 700;
            letter-spacing: 0.2px;
            padding: 0.5em 1em;
            border-radius: 8px;
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('browse') }}">Browse Cars</a></li>
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
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2 opacity-50"></i> Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2 opacity-50"></i> Edit Profile</a></li>
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