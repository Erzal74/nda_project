@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Dashboard Admin</h1>
            <p class="text-muted mb-0">Daftar Pegawai</p>
        </div>
        <a href="{{ route('admin.pegawai.create') }}" class="btn btn-primary btn-lg shadow-sm px-4">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pegawai
        </a>
    </div>

    <!-- Desktop Table -->
    <div class="d-none d-md-block">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width:5%">No</th>
                                <th style="width:20%">Nama</th>
                                <th style="width:20%">Email</th>
                                <th style="width:15%">NIP</th>
                                <th style="width:10%">Role</th>
                                <th class="text-center" style="width:20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pegawais as $pegawai)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + ($pegawais->currentPage() - 1) * $pegawais->perPage() }}</td>
                                    <td class="fw-semibold">{{ $pegawai->name }}</td>
                                    <td>{{ $pegawai->email }}</td>
                                    <td>{{ $pegawai->nip }}</td>
                                    <td>
                                        <span class="badge bg-{{ $pegawai->role === 'admin' ? 'primary' : 'secondary' }} rounded-pill px-3 py-2">
                                            {{ ucfirst($pegawai->role) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.pegawai.detail', $pegawai) }}" class="btn btn-sm btn-outline-info rounded-3">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('admin.pegawai.edit', $pegawai) }}" class="btn btn-sm btn-outline-warning rounded-3">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.pegawai.delete', $pegawai) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus pegawai ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data pegawai</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($pegawais->hasPages())
                <div class="card-footer bg-white border-0">
                    {{ $pegawais->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="d-md-none">
        @forelse ($pegawais as $pegawai)
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="fw-bold mb-0">{{ $pegawai->name }}</h6>
                        <span class="badge bg-{{ $pegawai->role === 'admin' ? 'primary' : 'secondary' }} rounded-pill">
                            {{ ucfirst($pegawai->role) }}
                        </span>
                    </div>
                    <ul class="list-unstyled small text-muted mb-3">
                        <li class="mb-1"><strong>Email:</strong> {{ $pegawai->email }}</li>
                        <li class="mb-1"><strong>NIP:</strong> {{ $pegawai->nip }}</li>
                        <li class="mb-1"><strong>No:</strong> {{ $loop->iteration + ($pegawais->currentPage() - 1) * $pegawais->perPage() }}</li>
                    </ul>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.pegawai.detail', $pegawai) }}" class="btn btn-outline-info btn-sm flex-fill rounded-3">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <a href="{{ route('admin.pegawai.edit', $pegawai) }}" class="btn btn-outline-warning btn-sm flex-fill rounded-3">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('admin.pegawai.delete', $pegawai) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus pegawai ini?')" class="flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-3">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="bi bi-people fs-1 d-block mb-3"></i>
                <p class="mb-0">Belum ada data pegawai</p>
            </div>
        @endforelse

        @if ($pegawais->hasPages())
            <div class="mt-4">
                {{ $pegawais->links() }}
            </div>
        @endif
    </div>
</div>
@endsection