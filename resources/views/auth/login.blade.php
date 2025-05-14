@extends('auth.layout')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f3f4f6 0%, #dbeafe 100%);
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .container-wrap {
        min-width: 650px;
    }

    .login-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        width: 100%;
        padding: 3rem;
        margin: 2rem;
    }

    .brand {
        text-align: center;
        margin-bottom: 3rem;
    }

    .brand img {
        height: 80px;
        width: 80px;
        margin-bottom: 1.5rem;
    }

    .brand-name {
        font-family: 'Alfa Slab One', cursive;
        font-size: 2.25rem;
        margin: 0;
    }

    .brand-name .counsel {
        color: #5A6C57;
    }

    .brand-name .link {
        color: #F9CB43;
    }

    .welcome-text {
        text-align: center;
        margin-bottom: 3rem;
    }

    .welcome-text h1 {
        font-size: 2rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.75rem;
    }

    .welcome-text p {
        color: #6b7280;
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-group label {
        font-size: 1rem;
        margin-bottom: 0.75rem;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1.25rem;
    }

    .form-control {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        font-size: 1rem;
        height: 3rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        background-color: #f9fafb;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #5A6C57;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(90, 108, 87, 0.1);
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 1.5rem 0;
    }

    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
    }

    .form-check-label {
        font-size: 1rem;
        color: #6b7280;
    }

    .forgot-password {
        font-size: 1rem;
        color: #5A6C57;
        text-decoration: none;
        transition: color 0.2s;
        display: inline-block;
        margin: 1rem 0;
    }

    .forgot-password:hover {
        color: #3f4d3d;
    }

    .btn-login {
        display: block;
        width: 100%;
        padding: 1rem;
        background-color: #5A6C57;
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 500;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.2s;
        margin-top: 1rem;
        height: 3rem;
    }

    .btn-login:hover {
        background-color: #3f4d3d;
    }

    .invalid-feedback {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    @media (max-width: 640px) {
        .login-container {
            margin: 1rem;
            padding: 2rem;
            max-width: 100%;
        }

        .brand img {
            height: 60px;
            width: 60px;
        }

        .brand-name {
            font-size: 1.75rem;
        }

        .welcome-text h1 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container container-wrap">
    <div class="login-container">
        <div class="brand">
            <img src="{{ asset('asset/images/dapuda.png') }}" alt="Logo">
            <h1 class="brand-name">
                <span class="counsel">Counsel</span><span class="link">Link</span>
            </h1>
        </div>

        <div class="welcome-text">
            <h1>Welcome Back!</h1>
            <p>Please sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email address</label>
                <div class="input-wrapper">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="email" 
                        autofocus>
                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        name="password" 
                        id="password" 
                        required 
                        autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-check">
                <input class="form-check-input" 
                    type="checkbox" 
                    id="showPassword" 
                    onclick="togglePassword()">
                <label class="form-check-label" for="showPassword">
                    Show Password
                </label>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center mb-3">
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                </div>
            @endif

            <button type="submit" class="btn-login">
                Sign In
            </button>
        </form>
    </div>
</div>
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const showPasswordCheckbox = document.getElementById('showPassword');
        
        if (showPasswordCheckbox.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>

@endsection
