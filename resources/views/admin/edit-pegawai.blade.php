@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-5">
        <div>
            <h1 class="h3 h2-md fw-bold text-dark mb-1">Edit Data Pegawai</h1>
            <p class="text-body-secondary">Perbarui data pegawai di bawah ini.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-3 px-4 d-flex align-items-center">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- Card Form -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">

            <!-- Flash Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                        <strong>Periksa kembali data yang Anda masukkan</strong>
                    </div>
                    <ul class="mb-0 ps-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('admin.pegawai.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    <!-- No Pegawai (Readonly) -->
                    <div class="col-12">
                        <label for="no" class="form-label fw-medium text-body-secondary d-flex align-items-center">
                            <i class="bi bi-hash me-1 fs-6"></i> No Pegawai
                        </label>
                        <input type="text"
                            id="no"
                            name="no"
                            class="form-control form-control-lg rounded-3"
                            value="{{ $user->no }}"
                            readonly>
                    </div>

                    <!-- Nama -->
                    <div class="col-12">
                        <label for="name" class="form-label fw-medium text-body-secondary d-flex align-items-center">
                            <i class="bi bi-person me-1 fs-6"></i> Nama Lengkap
                        </label>
                        <input type="text"
                            id="name"
                            name="name"
                            class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Masukkan nama lengkap"
                            required
                            autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-12">
                        <label for="email" class="form-label fw-medium text-body-secondary d-flex align-items-center">
                            <i class="bi bi-envelope me-1 fs-6"></i> Email
                        </label>
                        <input type="email"
                            id="email"
                            name="email"
                            class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}"
                            placeholder="contoh@instansi.go.id"
                            required
                            autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NIP -->
                    <div class="col-12">
                        <label for="nip" class="form-label fw-medium text-body-secondary d-flex align-items-center">
                            <i class="bi bi-credit-card me-1 fs-6"></i> NIP (8 Digit)
                        </label>
                        <input type="text"
                            id="nip"
                            name="nip"
                            class="form-control form-control-lg rounded-3 @error('nip') is-invalid @enderror"
                            value="{{ old('nip', $user->nip) }}"
                            placeholder="Contoh: 19876543"
                            maxlength="8"
                            required
                            autocomplete="off">
                        @error('nip')
                            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label fw-medium text-body-secondary d-flex align-items-center">
                            <i class="bi bi-lock me-1 fs-6"></i> Password Baru
                        </label>
                        <div class="input-group input-group-lg">
                            <input type="password"
                                id="password"
                                name="password"
                                class="form-control rounded-3 @error('password') is-invalid @enderror"
                                placeholder="Kosongkan jika tidak diubah"
                                autocomplete="new-password">
                            <button class="btn btn-outline-secondary rounded-end-3" type="button" id="togglePassword">
                                <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
                        <small class="text-body-secondary mt-1">Kosongkan jika tidak ingin mengubah password.</small>
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="col-12 col-md-6">
                        <label for="password_confirmation" class="form-label fw-medium text-body-secondary d-flex align-items-center">
                            <i class="bi bi-check2-square me-1 fs-6"></i> Konfirmasi Password
                        </label>
                        <div class="input-group input-group-lg">
                            <input type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control rounded-3"
                                placeholder="Ulangi password baru"
                                autocomplete="new-password">
                            <button class="btn btn-outline-secondary rounded-end-3" type="button" id="toggleConfirmPassword">
                                <i class="bi bi-eye-slash" id="toggleConfirmPasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="d-grid d-md-flex gap-3 mt-5">
                    <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-semibold px-4 d-flex align-items-center justify-content-center">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-lg rounded-3 fw-semibold px-4 d-flex align-items-center justify-content-center">
                        <i class="bi bi-x-lg me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle password visibility
    document.getElementById('togglePassword')?.addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    });

    document.getElementById('toggleConfirmPassword')?.addEventListener('click', function () {
        const passwordField = document.getElementById('password_confirmation');
        const icon = document.getElementById('toggleConfirmPasswordIcon');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    });
</script>
@endpush

@push('styles')
<style>
    /* Menyembunyikan ikon mata browser */
    input[type="password"]::-webkit-credentials-auto-fill-button,
    input[type="password"]::-ms-reveal,
    input[type="password"]::-moz-password-reveal,
    input[type="password"]::-webkit-textfield-decoration-container {
        display: none !important;
    }
</style>
@endpush
@endsection