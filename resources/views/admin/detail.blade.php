@extends('layouts.app')

@section('title', 'Detail Proyek NDA')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold">Detail Proyek NDA</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">{{ $nda->project_name }}</div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th style="width: 30%;">Nama Proyek</th>
                    <td>{{ $nda->project_name }}</td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td>{{ $nda->start_date ? $nda->start_date->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td>{{ $nda->end_date ? $nda->end_date->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Durasi</th>
                    <td>{{ $nda->formatted_duration }}</td>
                </tr>
                <tr>
                    <th>Tanggal TTD NDA</th>
                    <td>{{ $nda->nda_signature_date ? $nda->nda_signature_date->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $nda->description ?? '-' }}</td>
                </tr>
                <tr>
                    <th>File NDA</th>
                    <td>
                        <a href="{{ route('file.preview', $nda->token) }}" target="_blank" class="btn btn-info btn-sm">Lihat
                            File</a>
                    </td>
                </tr>
                <tr>
                    <th>Diunggah Oleh</th>
                    <td>{{ $nda->user->name ?? 'Unknown' }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
