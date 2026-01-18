<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SwiftRide - Join Our Journey</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary-color: #d12e2e;
            --primary-hover: #b32525;
            --accent-color: #1976d2;
            --bg-gradient: linear-gradient(135deg, #0d1117 0%, #161b22 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            color: #fff;
        }

        /* Abstract shapes */
        .shape {
            position: absolute;
            z-index: -1;
            filter: blur(80px);
            opacity: 0.4;
            border-radius: 50%;
        }
        .shape-1 {
            width: 400px;
            height: 400px;
            background: var(--primary-color);
            top: -100px;
            left: -100px;
        }
        .shape-2 {
            width: 300px;
            height: 300px;
            background: var(--accent-color);
            bottom: -50px;
            right: -50px;
        }

        .auth-container {
            width: 100%;
            max-width: 900px;
            margin: 20px;
            z-index: 10;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }

        .auth-image {
            background: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=1966&auto=format&fit=crop') center/cover;
            min-height: 400px;
            position: relative;
        }

        .auth-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(13, 17, 23, 0.8), transparent);
        }

        .auth-content {
            padding: 3rem;
        }

        .nav-pills {
            background: rgba(255, 255, 255, 0.05);
            padding: 5px;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .nav-pills .nav-link {
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .nav-pills .nav-link.active {
            background: var(--primary-color);
            color: #fff;
            box-shadow: 0 8px 15px rgba(209, 46, 46, 0.3);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 0.5rem;
        }

        .input-group {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(209, 46, 46, 0.1);
        }

        .input-group-text {
            background: transparent !important;
            border: none !important;
            color: rgba(255, 255, 255, 0.4);
            padding-left: 1.2rem;
            padding-right: 0.8rem;
        }

        .form-control {
            background: transparent !important;
            border: none !important;
            color: #fff !important;
            padding: 0.8rem 1.2rem;
            font-weight: 500;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .form-control:focus {
            box-shadow: none !important;
        }

        .btn-auth {
            border-radius: 15px;
            padding: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
        }

        .btn-primary-auth {
            background: var(--primary-color);
            border: none;
            color: #fff;
            box-shadow: 0 10px 20px rgba(209, 46, 46, 0.2);
        }

        .btn-primary-auth:hover {
            background: var(--primary-hover);
            box-shadow: 0 15px 25px rgba(209, 46, 46, 0.3);
        }

        .btn-secondary-auth {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .btn-secondary-auth:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Validation Overrides */
        .form-control.error {
            color: #ff4d4d !important;
        }
        label.error {
            color: #ff4d4d;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 5px;
            display: block;
        }

        /* Branding */
        .brand-logo {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: #fff;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 2rem;
        }
        .brand-logo span {
            color: var(--primary-color);
        }

        .login-benefits {
            position: absolute;
            bottom: 30px;
            left: 30px;
            z-index: 2;
        }

        .login-benefits h3 {
            font-weight: 800;
            margin-bottom: 10px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            margin-bottom: 5px;
            color: rgba(255, 255, 255, 0.8);
        }

        .benefit-item i {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .auth-image {
                display: none;
            }
            .auth-content {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

<div class="shape shape-1"></div>
<div class="shape shape-2"></div>

<div class="auth-container animate__animated animate__fadeIn">
    <div class="auth-card">
        <div class="row g-0">
            <!-- Left Side: Image & Branding -->
            <div class="col-lg-5 auth-image d-flex align-items-end p-5">
                <div class="login-benefits">
                    <a href="{{ url('/') }}" class="brand-logo mb-4">Swift<span>Ride</span></a>
                    <h3 class="text-white">Drive your dreams today.</h3>
                    <div class="benefit-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Luxury fleet at best prices</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Instant online booking</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-check-circle"></i>
                        <span>24/7 Roadside assistance</span>
                    </div>
                </div>
            </div>

            <!-- Right Side: Forms -->
            <div class="col-lg-7 auth-content">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Welcome Back</h2>
                    <p class="text-white-50">Explore the world of premium travel.</p>
                </div>

                <ul class="nav nav-pills justify-content-center" id="authTabs" role="tablist">
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link active w-100" id="login-tab" data-bs-toggle="pill" data-bs-target="#loginTab" type="button">Login</button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="register-tab" data-bs-toggle="pill" data-bs-target="#registerTab" type="button">Register</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Login Form -->
                    <div class="tab-pane fade show active" id="loginTab">
                        @if($errors->has('login'))
                            <div class="alert alert-danger border-0 rounded-4 p-3 mb-4 animate__animated animate__shakeX">
                                <small class="fw-bold">{{ $errors->first('login') }}</small>
                            </div>
                        @endif

                        <form id="loginForm" method="POST" action="{{ route('client.login') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="example@mail.com" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                    <label for="remember" class="form-check-label small text-white-50">Remember me</label>
                                </div>
                                <a href="#" class="small text-primary text-decoration-none fw-bold">Forgot Password?</a>
                            </div>

                            <button type="submit" class="btn btn-primary-auth btn-auth w-100 mb-4">
                                Sign In <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Register Form -->
                    <div class="tab-pane fade" id="registerTab">
                         @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-4 p-3 mb-4">
                                <ul class="mb-0 small fw-bold">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="registerForm" method="POST" action="{{ route('client.register') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="John Doe" value="{{ old('name') }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="example@mail.com" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password" id="reg_password" class="form-control" placeholder="••••••••" required minlength="6">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirm</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary-auth btn-auth w-100">
                                Create Account <i class="fas fa-user-plus ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <p class="small text-white-50 mb-0">By continuing, you agree to our <a href="#" class="text-white text-decoration-none fw-bold">Terms of Service</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        // Toggle Title & Description when switching tabs
        $('#login-tab').on('click', function() {
            $('.auth-content h2').text('Welcome Back');
            $('.auth-content p').text('Explore the world of premium travel.');
            $('.auth-content p').removeClass('text-muted').addClass('text-white-50');
        });
        $('#register-tab').on('click', function() {
            $('.auth-content h2').text('Join SwiftRide');
            $('.auth-content p').text('Start your journey with us today.');
            $('.auth-content p').removeClass('text-muted').addClass('text-white-50');
        });

        // Validation Options
        const validationOptions = {
            errorElement: 'label',
            errorClass: 'error',
            highlight: function(element) {
                $(element).closest('.input-group').addClass('border-danger');
            },
            unhighlight: function(element) {
                $(element).closest('.input-group').removeClass('border-danger');
            }
        };

        // Login Validation
        $("#loginForm").validate({
            ...validationOptions,
            rules: {
                email: { required: true, email: true },
                password: "required"
            }
        });

        // Register Validation
        $("#registerForm").validate({
            ...validationOptions,
            rules: {
                name: "required",
                email: { required: true, email: true },
                password: { required: true, minlength: 6 },
                password_confirmation: { required: true, equalTo: "#reg_password" }
            },
            messages: {
                password_confirmation: { equalTo: "Passwords do not match" }
            }
        });
    });
</script>

</body>
</html>
