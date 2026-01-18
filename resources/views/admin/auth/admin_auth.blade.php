<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SwiftRide Admin - Central Command</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --admin-primary: #0d6efd;
            --admin-secondary: #6c757d;
            --admin-dark: #0f172a;
            --bg-gradient: radial-gradient(circle at top right, #1e293b, #0f172a);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow: hidden;
        }

        /* Abstract Glow */
        .glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
        }
        .glow-1 { top: -200px; left: -200px; }
        .glow-2 { bottom: -200px; right: -200px; }

        .auth-card {
            width: 100%;
            max-width: 450px;
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
            position: relative;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--admin-primary), transparent);
            border-radius: 24px 24px 0 0;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .admin-badge {
            display: inline-block;
            background: rgba(13, 110, 253, 0.1);
            color: var(--admin-primary);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }

        .nav-tabs {
            border: none;
            background: rgba(255, 255, 255, 0.05);
            padding: 6px;
            border-radius: 14px;
            margin-bottom: 2rem;
        }

        .nav-tabs .nav-link {
            border: none;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
            width: 50%;
        }

        .nav-tabs .nav-link.active {
            background: var(--admin-primary);
            color: #fff;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.6rem;
        }

        .input-group {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
        }

        .input-group-text {
            background: transparent !important;
            border: none !important;
            color: rgba(255, 255, 255, 0.3);
            padding-left: 1rem;
        }

        .form-control {
            background: transparent !important;
            border: none !important;
            color: #fff !important;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        .form-control:focus {
            box-shadow: none !important;
        }

        .btn-admin {
            background: var(--admin-primary);
            border: none;
            border-radius: 12px;
            padding: 0.8rem;
            font-weight: 700;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.2);
        }

        .btn-admin:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(13, 110, 253, 0.3);
        }

        .form-check-input {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .form-check-input:checked {
            background-color: var(--admin-primary);
            border-color: var(--admin-primary);
        }

        /* Validation Styles */
        label.error {
            color: #ef4444;
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 5px;
            display: block;
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>

<div class="glow glow-1"></div>
<div class="glow glow-2"></div>

<div class="auth-card animate__animated animate__zoomIn">
    <div class="brand-header">
        <div class="admin-badge">Admin Panel</div>
        <h2 class="fw-black mb-1">SwiftRide</h2>
        <p class="small text-white-50 mb-0">Secure Management System</p>
    </div>

    <ul class="nav nav-tabs" id="authTabs" role="tablist">
        <li class="nav-item flex-fill">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#loginTab" type="button">Sign In</button>
        </li>
        <li class="nav-item flex-fill">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#registerTab" type="button">Enroll</button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Error Reporting -->
        @if($errors->any() || session('login'))
            <div class="alert alert-danger border-0 rounded-3 p-2 mb-4 animate__animated animate__shakeX">
                <ul class="mb-0 small fw-bold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @if(session('login'))
                        <li>{{ session('login') }}</li>
                    @endif
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <div class="tab-pane fade show active" id="loginTab">
            <form id="loginForm" method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Administrator Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="admin@swiftride.com" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Passkey</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label for="remember" class="form-check-label small text-white-50">Keep session active</label>
                </div>

                <button type="submit" class="btn btn-admin w-100">
                    Authorize Access <i class="fas fa-sign-in-alt ms-2"></i>
                </button>
            </form>
        </div>

        <!-- Register Form -->
        <div class="tab-pane fade" id="registerTab">
            <form id="registerForm" method="POST" action="{{ route('admin.register') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="System Administrator" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Official Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="admin@swiftride.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Security Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="admin_pass" class="form-control" placeholder="Min 6 chars" required minlength="6">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirm Passkey</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat passkey" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-admin w-100">
                    Register Admin <i class="fas fa-user-plus ms-2"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="footer-text">
        &copy; {{ date('Y') }} SwiftRide Systems &bull; <span class="text-white-50">High Integrity Environment</span>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        // Form Validation Configuration
        const config = {
            errorElement: 'label',
            errorClass: 'error',
            highlight: function(element) {
                $(element).closest('.input-group').css('border-color', '#ef4444');
            },
            unhighlight: function(element) {
                $(element).closest('.input-group').css('border-color', 'rgba(255, 255, 255, 0.08)');
            }
        };

        $("#loginForm").validate({
            ...config,
            rules: { email: { required: true, email: true }, password: "required" }
        });

        $("#registerForm").validate({
            ...config,
            rules: {
                name: "required",
                email: { required: true, email: true },
                password: { required: true, minlength: 6 },
                password_confirmation: { required: true, equalTo: "#admin_pass" }
            },
            messages: {
                password_confirmation: { equalTo: "Passkeys must match each other." }
            }
        });
    });
</script>

</body>
</html>
