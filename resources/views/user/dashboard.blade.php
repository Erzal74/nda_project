@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold">User Dashboard</h2>
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
                                <a href="{{ route('user.nda.detail', $nda) }}" class="btn btn-primary btn-sm">Detail</a>
                                @if ($nda->token)
                                    <a href="{{ route('file.download', $nda->token) }}"
                                        class="btn btn-success btn-sm">Download</a>
                                @endif
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
@endsection
