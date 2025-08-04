@extends('layouts.app')

@section('title', 'Detail Proyek NDA')

@section('content')
    <div class="mt-5">
        <h2>Detail Proyek NDA</h2>
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

        <div class="card">
            <div class="card-header">
                <h3>{{ $nda->project_name }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Proyek</th>
                        <td>{{ $nda->project_name }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai Proyek</th>
                        <td>{{ $nda->start_date ? $nda->start_date->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai Proyek</th>
                        <td>{{ $nda->end_date ? $nda->end_date->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Durasi Proyek</th>
                        <td>{{ $nda->formatted_duration }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Tanda Tangan NDA</th>
                        <td>{{ $nda->nda_signature_date ? $nda->nda_signature_date->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi Proyek</th>
                        <td>{{ $nda->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>File PDF NDA</th>
                        <td>
                            <a href="{{ route('file.preview', $nda->token) }}" target="_blank"
                                class="btn btn-sm btn-info">Lihat File</a>
                        </td>
                    </tr>
                    <tr>
                        <th>Diunggah Oleh</th>
                        <td>{{ $nda->user->name ?? 'Unknown' }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <div class="alert alert-info">
                        <strong>Informasi NDA:</strong> Dokumen ini telah ditandatangani pada tanggal
                        {{ $nda->nda_signature_date ? $nda->nda_signature_date->format('d/m/Y') : 'belum ditentukan' }}.
                        Harap baca dan pahami semua ketentuan yang tercantum dalam dokumen NDA ini.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
