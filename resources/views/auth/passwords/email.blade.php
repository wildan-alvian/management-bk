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
        max-width: 400px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-group label {
        font-size: 1rem;
        margin-bottom: 0.75rem;
        display: block;
        font-weight: 500;
        color: #374151;
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

    .btn-submit {
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

    .btn-submit:hover {
        background-color: #3f4d3d;
    }

    .back-to-login {
        display: block;
        text-align: center;
        margin-top: 1.5rem;
        color: #5A6C57;
        text-decoration: none;
        font-size: 1rem;
        transition: color 0.2s;
    }

    .back-to-login:hover {
        color: #3f4d3d;
    }

    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
    }

    .alert-success {
        background-color: #ecfdf5;
        color: #047857;
        border: 1px solid #047857;
    }

    .alert-danger {
        background-color: #fef2f2;
        color: #dc2626;
        border: 1px solid #dc2626;
    }

    @media (max-width: 640px) {
        .container-wrap {
            min-width: auto;
        }

        .login-container {
            margin: 1rem;
            padding: 2rem;
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
            <h1>Reset Password</h1>
            <p>Enter your email address and we'll send you a new password to access your account</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
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
                </div>
            </div>

            <button type="submit" class="btn-submit">
                Send Password Reset Link
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-to-login">
            <i class="bi bi-arrow-left"></i> Back to Login
        </a>
    </div>
</div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection 