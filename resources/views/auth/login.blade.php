@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <div class="form-header">
        <h2>Selamat Datang Kembali</h2>
        <p>Masuk ke akun Anda untuk mengakses sistem</p>
    </div>

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="form-group">
            <label for="nip" class="form-label">
                <i class="fas fa-id-card"></i> NIP (8 Digit)
            </label>
            <input type="text" id="nip" name="nip" class="form-control @error('nip') is-invalid @enderror"
                value="{{ old('nip') }}" placeholder="Contoh: 12345678" required autofocus maxlength="8">
            @error('nip')
                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">
                <i class="fas fa-lock"></i> Password
            </label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
            @error('password')
                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
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
            <span class="btn-text">Masuk ke Sistem</span>
            <span class="btn-loader" style="display:none;">
                <i class="fas fa-spinner fa-spin"></i> Memproses...
            </span>
        </button>
    </form>
@endsection
