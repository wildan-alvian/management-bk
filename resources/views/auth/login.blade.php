@extends('auth.layout')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Alfa Slab One&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #dbeafe;
        margin: 0;
        padding: 0;
    }

    .login-wrapper {
        display: flex;
        min-height: 100vh;
        flex-wrap: wrap;
    }

    .login-left {
        flex: 1 1 50%;
        background-color: #5A6C57;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 60px;
    }

    .login-left img {
        height: 55px;
        width: 55px;
        margin-bottom: 20px;
    }

    .login-left h1 {
        font-size: 40px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #ffffff;
    }

    .login-left p {
        color: #ffffff;
        margin-bottom: 30px;
    }

    .form-group {
        position: relative;
        margin-bottom: 20px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #31343b;
        font-size: 16px;
        pointer-events: none;
    }

    /* Konsisten untuk semua input */
    .login-form input[type="email"],
    .login-form input[type="password"],
    .login-form input[type="text"] {
        width: 100%;
        padding: 12px 14px 12px 42px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
        background-color: #fff;
        box-sizing: border-box;
        height: 44px;
        font-family: 'Poppins', sans-serif;
        letter-spacing: 0.5px;
    }

    .login-form label {
        margin-top: 15px;
        font-weight: 500;
        display: block;
    }

    .login-form a {
        color: #2563eb;
        font-size: 14px;
        text-decoration: none;
    }

    .login-form button {
        margin-top: 25px;
        width: 100%;
        padding: 12px;
        background-color: #1d4e89;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        transition: 0.3s;
    }

    .login-form button:hover {
        background-color: #153d6b;
    }

    .login-right {
        flex: 1 1 50%;
        background-color: #dbeafe;
        color: #000000;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px;
        text-align: center;
        box-sizing: border-box;
    }

    .login-right h2 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .login-right p {
        font-size: 16px;
        margin-bottom: 25px;
    }

    .btn-signup {
        padding: 10px 30px;
        font-size: 16px;
        border: 2px solid #121111;
        border-radius: 999px;
        background-color: transparent;
        color: #121111;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-signup:hover {
        background-color: #fff;
        color: #1d4e89;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
    }

    .form-check-input {
        width: 16px;
        height: 16px;
        margin: 0;
    }

    @media (max-width: 768px) {
        .login-wrapper {
            flex-direction: column;
        }

        .login-left, .login-right {
            flex: 1 1 100%;
            padding: 40px 20px;
            width: 100%;
            height: auto;
        }
    }
</style>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="login-wrapper">
    <div class="login-left">
        <div class="d-flex align-items-center mb-3">
            <img src="{{ asset('asset/images/dapuda.png') }}" class="me-2">
            <h4 class="fs-2 m-0" style="font-family: 'Alfa Slab One';">
                <span style="color:#D3F1DF">Counsel</span><span style="color:#F9CB43">Link</span>
            </h4>
        </div>
        <h1>Welcome</h1>
        <p>Sign in to access your account</p>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <div class="form-group">
                <label for="email">Email address</label>
                <div class="input-wrapper">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" name="email" id="email"
                        class="@error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required autofocus
                        placeholder="Enter your email">
                </div>
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" name="password" id="password"
                        class="@error('password') is-invalid @enderror"
                        required placeholder="Enter your password">
                </div>
                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                    <label class="form-check-label" for="showPassword">Show password</label>
                </div>
                <a href="{{ route('password.request') }}">Forgot password?</a>
            </div>

            <button type="submit">Sign in</button>

            <div class="mt-3 text-center">
                Don’t have an account? <a href="{{ route('register') }}">Sign up</a>
            </div>
        </form>
    </div>

    <div class="login-right">
        <h2>Join Us Today!</h2>
        <p>Register yourself now and enjoy our services immediately.</p>
        <a class="btn-signup" href="{{ route('register') }}">Sign up</a>
    </div>
</div>

<script>
    function togglePassword() {
        const pass = document.getElementById("password");
        pass.type = pass.type === "password" ? "text" : "password";
    }
</script>
@endsection
