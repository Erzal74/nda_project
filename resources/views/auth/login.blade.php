@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Selamat Datang</h1>
        <p class="page-subtitle">Masuk ke akun Anda untuk mengakses NDA System</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="Masukkan email" required autofocus>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-options">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-link">
                    Lupa password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-primary">
            Masuk
        </button>

        <div class="divider">
            <span>Belum punya akun?</span>
        </div>

        <a href="{{ route('register') }}" class="btn-outline">
            Daftar
        </a>
    </form>
@endsection
