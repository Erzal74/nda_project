@extends('layouts.app')

@section('title', 'Tambah Proyek NDA')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold">Tambah Proyek NDA</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.nda.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="project_name" class="form-label">Nama Proyek</label>
                    <input type="text" name="project_name" id="project_name"
                        class="form-control @error('project_name') is-invalid @enderror" value="{{ old('project_name') }}"
                        required>
                    @error('project_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date"
                            class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}"
                            required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date"
                            class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}"
                            required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Durasi Proyek</label>
                    <input type="text" id="project_duration" class="form-control" readonly
                        placeholder="DiHitung otomatis">
                </div>

                <div class="mb-3">
                    <label for="nda_signature_date" class="form-label">Tanggal Tanda Tangan NDA</label>
                    <input type="date" name="nda_signature_date" id="nda_signature_date"
                        class="form-control @error('nda_signature_date') is-invalid @enderror"
                        value="{{ old('nda_signature_date') }}" required>
                    @error('nda_signature_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Proyek</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                        rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">File PDF NDA</label>
                    <input type="file" name="file" id="file"
                        class="form-control @error('file') is-invalid @enderror" accept="application/pdf" required>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function calculateDuration() {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const durationInput = document.getElementById('project_duration');

                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    const diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                    durationInput.value = diffDays > 0 ? `${diffDays} hari` : 'Tanggal tidak valid';
                } else {
                    durationInput.value = '';
                }
            }

            document.getElementById('start_date').addEventListener('change', calculateDuration);
            document.getElementById('end_date').addEventListener('change', calculateDuration);

            document.getElementById('file').addEventListener('change', function() {
                if (this.files[0]?.type !== 'application/pdf') {
                    Swal.fire('Error', 'Harap pilih file PDF.', 'error');
                    this.value = '';
                }
            });
        </script>
    @endpush
@endsection
