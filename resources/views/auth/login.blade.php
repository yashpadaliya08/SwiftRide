<<<<<<< HEAD
@extends('client.layout')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4">Login to SwiftRide</h2>

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" class="form-control" name="email" required autofocus>
                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
                @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#loginForm').validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 6,
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email",
            },
            password: {
                required: "Please enter your password",
                minlength: "Password must be at least 6 characters",
            }
        },
        errorClass: 'is-invalid', // Bootstrap red border
        validClass: 'is-valid',   // Optional: green border when valid
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback'); // Bootstrap red error text
            error.insertAfter(element);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        }
    });
});
</script>
@endsection
=======
{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Client Login</title>
</head>
<body>
    <h1>Login Page</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" required autofocus>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</body>
</html>
>>>>>>> b97c7c6 (Push all files to SwiftRide repository)
