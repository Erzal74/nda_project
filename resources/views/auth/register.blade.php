@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Create Account</h1>
        <p class="page-subtitle">Join the NDA System today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="Enter your email" required>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="Create a password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                placeholder="Confirm your password" required>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="terms" required>
            <label class="form-check-label" for="terms">
                I agree to the <a href="#" class="text-link">Terms & Conditions</a>
            </label>
        </div>

        <button type="submit" class="btn-primary" disabled>Create Account</button>

        <div class="divider">
            <span>Already have an account?</span>
        </div>

        <a href="{{ route('login') }}" class="btn-outline">
            Sign In
        </a>
    </form>
@endsection
