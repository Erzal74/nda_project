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
            <label for="nip" class="form-label">NIP (8 Digit)</label>
            <input type="text" id="nip" name="nip" class="form-control @error('nip') is-invalid @enderror"
                value="{{ old('nip') }}" placeholder="Masukkan NIP" required autofocus maxlength="8">
            @error('nip')
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

        <!-- PERBAIKAN: Hapus link register -->
    </form>
@endsection
