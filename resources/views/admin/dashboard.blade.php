@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard Admin - Daftar Pegawai</h1>
        <a href="{{ route('admin.pegawai.create') }}" class="btn btn-primary mb-3">Tambah Pegawai</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIP</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawais as $pegawai)
                    <tr>
                        <td>{{ $pegawai->no }}</td>
                        <td>{{ $pegawai->name }}</td>
                        <td>{{ $pegawai->email }}</td>
                        <td>{{ $pegawai->nip }}</td>
                        <td>{{ ucfirst($pegawai->role) }}</td>
                        <td>
                            <a href="{{ route('admin.pegawai.detail', $pegawai) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.pegawai.edit', $pegawai) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.pegawai.delete', $pegawai) }}" method="POST"
                                style="display: inline;" onsubmit="return confirm('Yakin hapus pegawai ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pegawais->links() }}
    </div>
@endsection
