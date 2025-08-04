@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold">Admin Dashboard</h2>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('admin.nda.create') }}" class="btn btn-primary">Tambah NDA Baru</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Daftar User</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="status-badge status-{{ $user->status }}">{{ ucfirst($user->status) }}</span>
                            </td>
                            <td>
                                @if ($user->status == 'pending')
                                    <form action="{{ route('admin.user.approve', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.user.reject', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                @elseif ($user->status == 'approved')
                                    <form action="{{ route('admin.user.disable', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning btn-sm">Nonaktifkan</button>
                                    </form>
                                @elseif ($user->status == 'disabled')
                                    <form action="{{ route('admin.user.enable', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">Aktifkan</button>
                                    </form>
                                @endif
                                @if (in_array($user->status, ['rejected', 'disabled']))
                                    <form action="{{ route('admin.user.delete', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Daftar Proyek NDA</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Proyek</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Durasi</th>
                        <th>Tanggal TTD</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ndas as $nda)
                        <tr>
                            <td>{{ $nda->project_name }}</td>
                            <td>{{ $nda->start_date ? $nda->start_date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $nda->end_date ? $nda->end_date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $nda->formatted_duration }}</td>
                            <td>{{ $nda->nda_signature_date ? $nda->nda_signature_date->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if ($nda->token)
                                    <a href="{{ route('file.preview', $nda->token) }}" target="_blank"
                                        class="btn btn-info btn-sm">Preview</a>
                                @else
                                    <span class="text-muted">Tidak tersedia</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.nda.detail', $nda) }}" class="btn btn-primary btn-sm">Detail</a>
                                <a href="{{ route('admin.nda.edit', $nda) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.nda.delete', $nda) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada proyek NDA.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (this.closest('form')) {
                        e.preventDefault();
                        const action = this.textContent.trim();
                        Swal.fire({
                            title: `Yakin ingin ${action.toLowerCase()}?`,
                            icon: action === 'Hapus' ? 'warning' : 'question',
                            showCancelButton: true,
                            confirmButtonText: action,
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.closest('form').submit();
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
