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
    <!-- Google Font: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --admin-primary: #ff3333; /* Electric Crimson */
            --admin-primary-hover: #e02424;
            --admin-accent: #3399ff; /* Sapphire Glow */
            --admin-primary-glow: rgba(255, 51, 51, 0.4);
            --admin-dark: #090d16;
            --bg-gradient: linear-gradient(135deg, #090d16 0%, #0d1117 50%, #161b22 100%);
            --glass-border: rgba(255, 255, 255, 0.07);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow-x: hidden;
            position: relative;
        }

        /* Abstract Glow Blobs */
        .glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 51, 51, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
            filter: blur(100px);
            pointer-events: none;
        }
        .glow-1 { 
            top: -150px; 
            left: -150px; 
            animation: floatGlow1 12s infinite alternate ease-in-out;
        }
        .glow-2 { 
            bottom: -150px; 
            right: -150px; 
            background: radial-gradient(circle, rgba(51, 153, 255, 0.12) 0%, transparent 70%);
            animation: floatGlow2 15s infinite alternate ease-in-out;
        }

        @keyframes floatGlow1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, 20px) scale(1.1); }
        }

        @keyframes floatGlow2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-20px, -30px) scale(1.05); }
        }

        .auth-card {
            width: 100%;
            max-width: 460px;
            background: rgba(13, 17, 23, 0.5) !important;
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            padding: 3.5rem 3rem 3rem 3rem;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.65),
                        inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 32px;
            padding: 1.5px;
            background: linear-gradient(135deg, rgba(255, 51, 51, 0.35), rgba(51, 153, 255, 0.15), rgba(255, 255, 255, 0.05));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .admin-badge {
            display: inline-block;
            background: rgba(255, 51, 51, 0.1);
            color: var(--admin-primary);
            border: 1px solid rgba(255, 51, 51, 0.15);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1.2rem;
            box-shadow: 0 0 10px rgba(255, 51, 51, 0.05);
        }

        .brand-logo-text {
            font-weight: 900;
            font-size: 2.1rem;
            letter-spacing: -1.2px;
            background: linear-gradient(135deg, #ff4d4d, #3399ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            position: relative;
            margin-bottom: 0.2rem;
        }
        
        .brand-logo-text::after {
            content: '';
            position: absolute;
            width: 5px;
            height: 5px;
            background: #ff4d4d;
            bottom: 8px;
            right: -8px;
            border-radius: 50%;
            box-shadow: 0 0 8px #ff4d4d;
        }

        .nav-tabs {
            border: none;
            background: rgba(255, 255, 255, 0.03);
            padding: 5px;
            border-radius: 18px;
            margin-bottom: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .nav-tabs .nav-link {
            border: none;
            color: rgba(255, 255, 255, 0.55) !important;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 14px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            width: 50%;
            padding: 10px 15px;
        }

        .nav-tabs .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.04);
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-hover)) !important;
            color: #fff !important;
            box-shadow: 0 6px 18px var(--admin-primary-glow);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .form-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.45);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 0.6rem;
            display: block;
        }

        .input-group {
            background: rgba(255, 255, 255, 0.02);
            border: 1.5px solid rgba(255, 255, 255, 0.07);
            border-radius: 14px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow: hidden;
        }

        .input-group:hover {
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.04);
        }

        .input-group:focus-within {
            border-color: var(--admin-primary);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 15px rgba(255, 51, 51, 0.15);
        }

        .input-group-text {
            background: transparent !important;
            border: none !important;
            color: rgba(255, 255, 255, 0.35);
            padding-left: 1.2rem;
            padding-right: 0.5rem;
            font-size: 1.05rem;
        }

        .input-group:focus-within .input-group-text {
            color: var(--admin-primary);
        }

        .form-control {
            background: transparent !important;
            border: none !important;
            color: #fff !important;
            padding: 0.85rem 1.1rem;
            font-size: 0.95rem;
            font-weight: 550;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .form-control:focus {
            box-shadow: none !important;
        }

        .btn-admin {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-hover));
            border: none;
            border-radius: 14px;
            padding: 0.9rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #fff;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 8px 22px var(--admin-primary-glow);
        }

        .btn-admin:hover {
            background: linear-gradient(135deg, var(--admin-primary-hover), #9b1010);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(255, 51, 51, 0.4);
        }
        
        .btn-admin:active {
            transform: translateY(-1px);
        }

        .form-check-input {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
        }

        .form-check-input:checked {
            background-color: var(--admin-primary);
            border-color: var(--admin-primary);
        }

        /* Validation Styles */
        label.error {
            color: #ff4d4d;
            font-size: 0.72rem;
            font-weight: 600;
            margin-top: 6px;
            padding-left: 0.5rem;
            display: block;
        }

        .footer-text {
            text-align: center;
            margin-top: 2.2rem;
            font-size: 0.78rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.45);
        }
        
        .footer-text span {
            color: var(--admin-primary);
        }
    </style>
</head>
<body>

<div class="glow glow-1"></div>
<div class="glow glow-2"></div>

<div class="auth-card animate__animated animate__zoomIn">
    <div class="brand-header">
        <div class="admin-badge">Admin Panel</div>
        <div>
            <span class="brand-logo-text">SwiftRide</span>
        </div>
        <p class="small text-white-50 mb-0" style="font-weight: 500;">Secure Central Console</p>
    </div>

    <div class="mb-4">
        <!-- Error Reporting -->
        @if($errors->any() || session('login'))
            <div class="alert alert-danger border-0 rounded-4 p-3 mb-4 animate__animated animate__shakeX" style="background: rgba(255,77,77,0.15); border: 1px solid rgba(255,77,77,0.2) !important; color: #ff8080;">
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
        <form id="loginForm" method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label">Administrator Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="admin@swiftride.com" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Passkey</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <div class="mb-4 form-check d-flex align-items-center gap-2">
                <input type="checkbox" name="remember" class="form-check-input m-0" id="remember">
                <label for="remember" class="form-check-label small text-white-50 select-none">Keep session active</label>
            </div>

            <button type="submit" class="btn btn-admin w-100">
                Authorize Access <i class="fas fa-sign-in-alt ms-2"></i>
            </button>
        </form>
    </div>

    <div class="footer-text">
        &copy; {{ date('Y') }} SwiftRide Systems &bull; <span>High Integrity</span>
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
                $(element).closest('.input-group').css('border-color', '#ff4d4d');
            },
            unhighlight: function(element) {
                $(element).closest('.input-group').css('border-color', 'rgba(255, 255, 255, 0.07)');
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
