<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login / Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- jQuery & Validation Plugin -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <style>
        body {
            background: linear-gradient(to right, #f1f1f1, #e1eafc);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-card {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }

        .nav-tabs .nav-link {
            font-weight: bold;
            color: #555;
        }

        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom: 3px solid #0d6efd;
        }

        .form-control.error {
            border-color: red;
            animation: shake 0.3s;
        }

        .form-control.valid {
            border-color: green;
        }

        label.error {
            color: red;
            font-size: 0.85rem;
            margin-top: 4px;
        }

        @keyframes shake {
            0% { transform: translateX(0px); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0px); }
        }
    </style>
</head>
<body>

<div class="auth-card p-4">
    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3" id="authTabs" role="tablist">
        <li class="nav-item w-50 text-center">
            <button class="nav-link active w-100" id="login-tab" data-bs-toggle="tab" data-bs-target="#loginTab" type="button">Login</button>
        </li>
        <li class="nav-item w-50 text-center">
            <button class="nav-link w-100" id="register-tab" data-bs-toggle="tab" data-bs-target="#registerTab" type="button">Register</button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Login Form -->
        <div class="tab-pane fade show active" id="loginTab" role="tabpanel">
            <form id="loginForm" method="POST" action="{{ route('admin.login') }}">

                @csrf
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label for="remember" class="form-check-label">Remember Me</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>

        <!-- Register Form -->
        <div class="tab-pane fade" id="registerTab" role="tabpanel">
            <form id="registerForm" method="POST" action="{{ route('admin.register') }}">

                @csrf
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required equalTo="#registerForm input[name='password']">
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Login Form Validation
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: "required"
            },
            messages: {
                email: {
                    required: "Email is required",
                    email: "Enter a valid email"
                },
                password: "Password is required"
            },
            errorClass: "error",
            validClass: "valid"
        });

        // Register Form Validation
        $("#registerForm").validate({
            rules: {
                name: "required",
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#registerForm input[name='password']"
                }
            },
            messages: {
                name: "Name is required",
                email: {
                    required: "Email is required",
                    email: "Enter a valid email"
                },
                password: {
                    required: "Password is required",
                    minlength: "Minimum 6 characters"
                },
                password_confirmation: {
                    required: "Please confirm password",
                    equalTo: "Passwords do not match"
                }
            },
            errorClass: "error",
            validClass: "valid"
        });
    });
</script>

</body>
</html>
