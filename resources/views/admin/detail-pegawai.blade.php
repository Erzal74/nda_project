@extends('layouts.app')

@section('content')
<div class="container py-4 py-md-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4 gap-3">
        <div>
            <h1 class="h4 h2-md fw-bold text-dark mb-1">Detail Pegawai</h1>
            <p class="text-body-secondary mb-0">{{ $user->name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pegawai.edit', $user) }}" class="btn btn-primary btn-lg rounded-3 px-4 d-flex align-items-center">
                <i class="bi bi-pencil-square me-1"></i> Edit Profil
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-lg rounded-3 px-4 d-flex align-items-center">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-body p-4">

            <div class="row g-4">

                <!-- No Pegawai -->
                <div class="col-12 col-md-6">
                    <dl class="row mb-0 lh-sm">
                        <dt class="col-5 col-md-4 text-body-secondary d-flex align-items-center">
                            <i class="bi bi-hash me-1 fs-6"></i> No Pegawai
                        </dt>
                        <dd class="col-7 col-md-8 fw-medium text-dark">{{ $user->no ?? '<span class="text-muted">Tidak tersedia</span>' }}</dd>
                    </dl>
                </div>

                <!-- Nama -->
                <div class="col-12 col-md-6">
                    <dl class="row mb-0 lh-sm">
                        <dt class="col-5 col-md-4 text-body-secondary d-flex align-items-center">
                            <i class="bi bi-person me-1 fs-6"></i> Nama
                        </dt>
                        <dd class="col-7 col-md-8 fw-medium text-dark">{{ $user->name }}</dd>
                    </dl>
                </div>

                <!-- Email -->
                <div class="col-12 col-md-6">
                    <dl class="row mb-0 lh-sm">
                        <dt class="col-5 col-md-4 text-body-secondary d-flex align-items-center">
                            <i class="bi bi-envelope me-1 fs-6"></i> Email
                        </dt>
                        <dd class="col-7 col-md-8 fw-medium text-break">{{ $user->email }}</dd>
                    </dl>
                </div>

                <!-- NIP -->
                <div class="col-12 col-md-6">
                    <dl class="row mb-0 lh-sm">
                        <dt class="col-5 col-md-4 text-body-secondary d-flex align-items-center">
                            <i class="bi bi-credit-card me-1 fs-6"></i> NIP
                        </dt>
                        <dd class="col-7 col-md-8 fw-medium">{{ $user->nip ?? '<span class="text-muted">Tidak tersedia</span>' }}</dd>
                    </dl>
                </div>

                <!-- Role -->
                <div class="col-12 col-md-6">
                    <dl class="row mb-0 lh-sm">
                        <dt class="col-5 col-md-4 text-body-secondary d-flex align-items-center">
                            <i class="bi bi-shield me-1 fs-6"></i> Role
                        </dt>
                        <dd class="col-7 col-md-8">
                            <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }} rounded-pill px-3 py-1 fw-normal">
                                {{ ucfirst($user->role) }}
                            </span>
                        </dd>
                    </dl>
                </div>

                <!-- Dibuat pada -->
                <div class="col-12 col-md-6">
                    <dl class="row mb-0 lh-sm">
                        <dt class="col-5 col-md-4 text-body-secondary d-flex align-items-center">
                            <i class="bi bi-calendar-event me-1 fs-6"></i> Dibuat pada
                        </dt>
                        <dd class="col-7 col-md-8 fw-medium">{{ $user->created_at->format('d M Y, H:i') }}</dd>
                    </dl>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection