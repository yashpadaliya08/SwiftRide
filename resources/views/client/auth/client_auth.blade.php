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
    <!-- Google Font: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary-color: #ff3333; /* Electric Crimson */
            --primary-hover: #e02424;
            --accent-color: #3399ff; /* Sapphire Glow */
            --primary-glow: rgba(255, 51, 51, 0.4);
            --accent-glow: rgba(51, 153, 255, 0.3);
            --bg-gradient: linear-gradient(135deg, #090d16 0%, #0d1117 50%, #161b22 100%);
            --dark-carbon: #0d1117;
            --glass-bg: rgba(255, 255, 255, 0.02);
            --glass-border: rgba(255, 255, 255, 0.07);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            color: #fff;
        }

        /* Abstract glowing mesh shapes */
        .shape {
            position: absolute;
            z-index: -1;
            filter: blur(120px);
            opacity: 0.35;
            border-radius: 50%;
            pointer-events: none;
        }
        .shape-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%);
            top: -150px;
            left: -150px;
            animation: floatShape1 12s infinite alternate ease-in-out;
        }
        .shape-2 {
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, var(--accent-color) 0%, transparent 70%);
            bottom: -100px;
            right: -100px;
            animation: floatShape2 15s infinite alternate ease-in-out;
        }

        @keyframes floatShape1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(40px, 30px) scale(1.1); }
        }

        @keyframes floatShape2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-30px, -40px) scale(1.05); }
        }

        .auth-container {
            width: 100%;
            max-width: 980px;
            margin: 30px 20px;
            z-index: 10;
        }

        .auth-card {
            background: rgba(13, 17, 23, 0.45);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.6), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 32px;
            padding: 1.5px;
            background: linear-gradient(135deg, rgba(255, 51, 51, 0.3), rgba(51, 153, 255, 0.1), rgba(255, 255, 255, 0.05));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .auth-image {
            background: linear-gradient(135deg, rgba(13, 17, 23, 0.6) 0%, rgba(9, 13, 22, 0.85) 100%), 
                        url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1920&auto=format&fit=crop') center/cover;
            min-height: 480px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid var(--glass-border);
        }

        .auth-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(255, 51, 51, 0.15), transparent 60%);
            pointer-events: none;
        }

        .auth-content {
            padding: 4rem 3.5rem;
        }

        .nav-pills {
            background: rgba(255, 255, 255, 0.03);
            padding: 6px;
            border-radius: 20px;
            margin-bottom: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .nav-pills .nav-link {
            border-radius: 15px;
            color: rgba(255, 255, 255, 0.6) !important;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 12px 20px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid transparent;
        }

        .nav-pills .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), #c21a1a) !important;
            color: #fff !important;
            box-shadow: 0 8px 25px var(--primary-glow);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.45);
            margin-bottom: 0.6rem;
        }

        .input-group {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 16px;
            border: 1.5px solid rgba(255, 255, 255, 0.07);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow: hidden;
        }

        .input-group:hover {
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.04);
        }

        .input-group:focus-within {
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 20px rgba(255, 51, 51, 0.15);
        }

        .input-group-text {
            background: transparent !important;
            border: none !important;
            color: rgba(255, 255, 255, 0.35);
            padding-left: 1.4rem;
            padding-right: 0.6rem;
            font-size: 1.1rem;
        }

        .input-group:focus-within .input-group-text {
            color: var(--primary-color);
        }

        .form-control {
            background: transparent !important;
            border: none !important;
            color: #fff !important;
            padding: 0.9rem 1.2rem;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .form-control:focus {
            box-shadow: none !important;
        }

        .btn-auth {
            border-radius: 16px;
            padding: 0.95rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .btn-auth:hover {
            transform: translateY(-3px);
        }

        .btn-primary-auth {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border: none;
            color: #fff;
            box-shadow: 0 10px 25px var(--primary-glow);
        }

        .btn-primary-auth:hover {
            background: linear-gradient(135deg, var(--primary-hover), #9b1010);
            box-shadow: 0 15px 30px rgba(255, 51, 51, 0.4);
        }

        .btn-secondary-auth {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            color: #fff;
        }

        .btn-secondary-auth:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Validation Overrides */
        .form-control.error {
            color: #ff4d4d !important;
        }
        label.error {
            color: #ff4d4d;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 6px;
            padding-left: 0.5rem;
            display: block;
        }

        /* Branding */
        .brand-logo {
            font-weight: 900;
            font-size: 1.8rem;
            color: #fff;
            text-decoration: none;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #ff4d4d, #3399ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            position: relative;
        }
        
        .brand-logo::after {
            content: '';
            position: absolute;
            width: 5px;
            height: 5px;
            background: #ff4d4d;
            bottom: 6px;
            right: -8px;
            border-radius: 50%;
            box-shadow: 0 0 8px #ff4d4d;
        }

        .login-benefits {
            position: relative;
            z-index: 2;
        }

        .login-benefits h3 {
            font-weight: 800;
            font-size: 1.8rem;
            letter-spacing: -0.5px;
            margin-bottom: 20px;
            background: linear-gradient(to right, #fff 40%, rgba(255,255,255,0.7));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 12px;
            color: rgba(255, 255, 255, 0.75);
            transition: all 0.3s ease;
        }
        
        .benefit-item:hover {
            color: #fff;
            transform: translateX(5px);
        }

        .benefit-item i {
            color: var(--primary-color);
            filter: drop-shadow(0 0 5px var(--primary-glow));
        }

        @media (max-width: 991px) {
            .auth-image {
                display: none;
            }
            .auth-content {
                padding: 3rem 2rem;
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
                                <a href="{{ route('password.request') }}" class="small text-primary text-decoration-none fw-bold">Forgot Password?</a>
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
