@extends('layouts.app')

@section('title', 'Edit Proyek NDA')

@section('content')
    <div class="mt-5">
        <h2>Edit Proyek NDA</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

        <form method="POST" action="{{ route('admin.nda.update', $nda) }}" enctype="multipart/form-data" id="ndaForm">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="project_name" class="form-label">Nama Proyek</label>
                <input type="text" name="project_name" id="project_name"
                    class="form-control @error('project_name') is-invalid @enderror"
                    value="{{ old('project_name', $nda->project_name) }}" required>
                @error('project_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai Proyek</label>
                <input type="date" name="start_date" id="start_date"
                    class="form-control @error('start_date') is-invalid @enderror"
                    value="{{ old('start_date', $nda->start_date ? $nda->start_date->format('Y-m-d') : '') }}" required>
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">Tanggal Selesai Proyek</label>
                <input type="date" name="end_date" id="end_date"
                    class="form-control @error('end_date') is-invalid @enderror"
                    value="{{ old('end_date', $nda->end_date ? $nda->end_date->format('Y-m-d') : '') }}" required>
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Durasi Proyek</label>
                <input type="text" id="project_duration" class="form-control" readonly
                    value="{{ $nda->formatted_duration }}" placeholder="Durasi akan dihitung otomatis">
                <small class="text-muted">Durasi proyek akan dihitung otomatis berdasarkan tanggal mulai dan
                    selesai.</small>
            </div>

            <div class="mb-3">
                <label for="nda_signature_date" class="form-label">Tanggal Tanda Tangan NDA</label>
                <input type="date" name="nda_signature_date" id="nda_signature_date"
                    class="form-control @error('nda_signature_date') is-invalid @enderror"
                    value="{{ old('nda_signature_date', $nda->nda_signature_date ? $nda->nda_signature_date->format('Y-m-d') : '') }}"
                    required>
                @error('nda_signature_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Proyek</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                    rows="5" placeholder="Masukkan deskripsi proyek...">{{ old('description', $nda->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Ganti File PDF NDA (opsional)</label>
                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror"
                    accept="application/pdf">
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">File saat ini: <a href="{{ Storage::url($nda->file_path) }}"
                        target="_blank">{{ basename($nda->file_path) }}</a></small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <script>
        // Calculate project duration automatically
        function calculateDuration() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const timeDifference = end.getTime() - start.getTime();
                const dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));

                if (dayDifference > 0) {
                    document.getElementById('project_duration').value = dayDifference + ' hari';
                } else {
                    document.getElementById('project_duration').value = 'Tanggal tidak valid';
                }
            } else {
                document.getElementById('project_duration').value = '';
            }
        }

        document.getElementById('start_date').addEventListener('change', calculateDuration);
        document.getElementById('end_date').addEventListener('change', calculateDuration);

        document.getElementById('file').addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.type !== 'application/pdf') {
                alert('Harap pilih file PDF.');
                this.value = '';
            }
        });

        // Calculate duration on page load
        calculateDuration();
    </script>
@endsection
