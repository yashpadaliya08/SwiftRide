<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - SwiftRide</title>

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
            max-width: 500px;
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

<div class="auth-card text-center">
    <a href="{{ url('/') }}" class="brand-logo mb-3">SwiftRide</a>
    <div class="my-3">
        <i class="fas fa-envelope-open-text fa-3x text-primary"></i>
    </div>
    <h4 class="fw-bold">Verify Your Email</h4>
    <p class="text-white-50 small mb-4">
        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success border-0 rounded-3 p-3 mb-4 small fw-bold" style="background: rgba(25, 135, 84, 0.2); color: #75b798;">
            <i class="fas fa-check-circle me-1"></i> A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif

    <div class="d-flex flex-column gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary-auth w-100">
                Resend Verification Email <i class="fas fa-redo ms-2"></i>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-white-50 text-decoration-none small">
                <i class="fas fa-sign-out-alt me-1"></i> Log Out
            </button>
        </form>
    </div>
</div>

</body>
</html>
