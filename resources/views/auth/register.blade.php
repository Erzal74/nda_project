@extends('layouts.guest')

@section('title', 'Daftar Admin')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Daftar Admin Baru</h1>
        <p class="page-subtitle">Buat akun admin untuk mengakses NDA System</p>
    </div>

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="Masukkan email" required>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="Buat password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                placeholder="Konfirmasi password" required>
        </div>

        <button type="submit" class="btn-primary">Daftar</button>

        <div class="divider">
            <span>Sudah punya akun?</span>
        </div>

        <a href="{{ route('login') }}" class="btn-outline">
            Masuk
        </a>
    </form>
@endsection
