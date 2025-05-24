<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Login / Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Card -->
            <div class="card">
                <div class="card-header text-center">
                    <ul class="nav nav-tabs card-header-tabs" id="authTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login"
                                    type="button" role="tab">Login</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register"
                                    type="button" role="tab">Register</button>
                        </li>
                    </ul>
                </div>

                <div class="card-body tab-content">
                    <!-- Login Tab -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        @if($errors->has('email'))
                            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                        @elseif($errors->has('login'))
                            <div class="alert alert-danger">{{ $errors->first('login') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div>
                        </form>
                    </div>

                    <!-- Register Tab -->
                    <div class="tab-pane fade" id="register" role="tabpanel">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-success w-100">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
