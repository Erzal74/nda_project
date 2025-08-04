@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Welcome Back</h1>
        <p class="page-subtitle">Sign in to access your account</p>
    </div>

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                Remember me
            </label>
        </div>

        <button type="submit" class="btn-primary">Sign In</button>

        @if (Route::has('password.request'))
            <div class="text-center">
                <a href="{{ route('password.request') }}" class="text-link">
                    Forgot your password?
                </a>
            </div>
        @endif

        <div class="divider">
            <span>Don't have an account?</span>
        </div>

        <a href="{{ route('register') }}" class="btn-outline">
            Create Account
        </a>
    </form>
@endsection
