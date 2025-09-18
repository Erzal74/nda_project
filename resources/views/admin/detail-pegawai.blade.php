@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Pegawai: {{ $user->name }}</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>No Pegawai:</strong> {{ $user->no }}</p>
                <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>NIP:</strong> {{ $user->nip }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                <p><strong>Dibuat:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('admin.pegawai.edit', $user) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
