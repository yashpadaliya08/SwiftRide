<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password - SwiftRide</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #ff3333;
            --primary-hover: #e02424;
            --primary-glow: rgba(255, 51, 51, 0.4);
            --dark-bg: #090d16;
            --glass-bg: rgba(13, 17, 23, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
        }
        body {
            background-color: var(--dark-bg);
            font-family: 'Outfit', sans-serif;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
            padding: 20px;
        }
        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            z-index: 1;
            pointer-events: none;
        }
        .shape-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%);
            top: -100px;
            left: -100px;
        }
        .shape-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #3399ff 0%, transparent 70%);
            bottom: -100px;
            right: -100px;
        }
        .auth-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 28px;
            width: 100%;
            max-width: 480px;
            padding: 40px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.6);
            z-index: 10;
        }
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
        }
        .input-group {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 14px;
            overflow: hidden;
        }
        .input-group-text {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.4);
            padding-left: 1.2rem;
        }
        .form-control {
            background: transparent !important;
            border: none !important;
            color: #fff !important;
            padding: 0.9rem 1.2rem;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }
        .form-control:focus {
            box-shadow: none;
        }
        .btn-primary-auth {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border: none;
            color: #fff;
            font-weight: 700;
            border-radius: 14px;
            padding: 0.9rem;
            box-shadow: 0 10px 25px var(--primary-glow);
            transition: all 0.3s ease;
        }
        .btn-primary-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(255, 51, 51, 0.4);
            color: #fff;
        }
    </style>
</head>
<body>

<div class="shape shape-1"></div>
<div class="shape shape-2"></div>

<div class="auth-card">
    <div class="text-center mb-4">
        <a href="{{ url('/') }}" class="brand-logo mb-3">SwiftRide</a>
        <h4 class="fw-bold mt-2">Choose New Password</h4>
        <p class="text-white-50 small mb-0">Create a secure password for your SwiftRide account.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-3 p-3 mb-4 small fw-bold" style="background: rgba(220, 53, 69, 0.2); color: #ea868f;">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label small fw-bold text-white-50 text-uppercase">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            </div>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label small fw-bold text-white-50 text-uppercase">New Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="new-password">
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label class="form-label small fw-bold text-white-50 text-uppercase">Confirm New Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required autocomplete="new-password">
            </div>
        </div>

        <button type="submit" class="btn btn-primary-auth w-100 mb-4">
            Reset Password <i class="fas fa-check ms-2"></i>
        </button>

        <div class="text-center">
            <a href="{{ route('client.auth') }}" class="text-white-50 text-decoration-none small">
                <i class="fas fa-arrow-left me-1"></i> Back to Login
            </a>
        </div>
    </form>
</div>

</body>
</html>
