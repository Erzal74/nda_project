@extends('layouts.app')

@section('title', 'Buat Proyek NDA Baru')

@section('content')
    <div class="container-fluid py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="h2 fw-bold text-gray-900 mb-2">Buat Proyek Baru</h1>
                <p class="text-muted mb-0">Tambahkan proyek NDA baru ke portofolio Anda</p>
            </div>
            <a href="{{ route('pegawai.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white p-4 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="feature-icon bg-primary bg-opacity-10 rounded-2">
                        <i class="bi bi-folder-plus text-primary fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-semibold mb-1">Informasi Proyek</h5>
                        <p class="text-muted small mb-0">Lengkapi semua informasi yang diperlukan untuk proyek NDA</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 p-lg-5">
                <form method="POST" action="{{ route('pegawai.nda.store') }}" enctype="multipart/form-data"
                    id="projectForm">
                    @csrf

                    <!-- Basic Information -->
                    <div class="form-section mb-5">
                        <div class="section-header d-flex align-items-center gap-3 mb-4">
                            <div class="section-icon bg-info bg-opacity-10 rounded-2">
                                <i class="bi bi-info-circle text-info fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Informasi Dasar</h6>
                                <p class="text-muted small mb-0">Masukkan nama dan deskripsi proyek</p>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="project_name" class="form-label fw-medium required">Nama Proyek</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-folder"></i></span>
                                        <input type="text" name="project_name" id="project_name"
                                            class="form-control rounded-end @error('project_name') is-invalid @enderror"
                                            value="{{ old('project_name') }}"
                                            placeholder="Contoh: Proyek Pengembangan Aplikasi Mobile" maxlength="255"
                                            required>
                                    </div>
                                    @error('project_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="form-text small">Masukkan nama proyek yang jelas dan deskriptif (maksimal
                                            255 karakter)</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" class="form-label fw-medium">Deskripsi Proyek</label>
                                    <textarea name="description" id="description" class="form-control rounded-2 @error('description') is-invalid @enderror"
                                        rows="5" placeholder="Deskripsikan tujuan, lingkup, dan detail penting lainnya dari proyek ini..."
                                        maxlength="1000">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="form-text small"><span id="descriptionCount">0</span>/1000 karakter</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="form-section mb-5">
                        <div class="section-header d-flex align-items-center gap-3 mb-4">
                            <div class="section-icon bg-warning bg-opacity-10 rounded-2">
                                <i class="bi bi-calendar-range text-warning fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Timeline Proyek</h6>
                                <p class="text-muted small mb-0">Tentukan waktu pelaksanaan proyek</p>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_date" class="form-label fw-medium required">Tanggal Mulai</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        <input type="date" name="start_date" id="start_date"
                                            class="form-control rounded-end @error('start_date') is-invalid @enderror"
                                            value="{{ old('start_date') }}" required>
                                    </div>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_date" class="form-label fw-medium required">Tanggal Berakhir</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                        <input type="date" name="end_date" id="end_date"
                                            class="form-control rounded-end @error('end_date') is-invalid @enderror"
                                            value="{{ old('end_date') }}" required>
                                    </div>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label fw-medium">Durasi Proyek</label>
                                    <div class="duration-display rounded-2" id="duration-display">
                                        <div class="duration-placeholder d-flex align-items-center">
                                            <i class="bi bi-clock me-2"></i>
                                            <span>Akan dihitung otomatis</span>
                                        </div>
                                    </div>
                                    <div class="form-text small">Durasi akan dihitung berdasarkan tanggal mulai dan berakhir
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- NDA Information -->
                    <div class="form-section mb-5">
                        <div class="section-header d-flex align-items-center gap-3 mb-4">
                            <div class="section-icon bg-success bg-opacity-10 rounded-2">
                                <i class="bi bi-shield-check text-success fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Informasi NDA</h6>
                                <p class="text-muted small mb-0">Detail terkait Non-Disclosure Agreement</p>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nda_signature_date" class="form-label fw-medium required">Tanggal
                                        Penandatanganan NDA</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                        <input type="date" name="nda_signature_date" id="nda_signature_date"
                                            class="form-control rounded-end @error('nda_signature_date') is-invalid @enderror"
                                            value="{{ old('nda_signature_date') }}" required>
                                    </div>
                                    @error('nda_signature_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="form-text small">Wajib diisi dengan tanggal penandatanganan NDA</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="nda-status-info">
                                    <div class="alert alert-info small rounded-2 mb-0 p-3">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <div>
                                            <strong>Status NDA:</strong>
                                            <span id="nda-status">Belum ditentukan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Anggota + Berkas Terintegrasi -->
                    <div class="form-section mb-5">
                        <div class="section-header d-flex align-items-center justify-content-between gap-3 mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="section-icon bg-purple bg-opacity-10 rounded-2">
                                    <i class="bi bi-people text-purple fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Anggota Tim & Berkas NDA</h6>
                                    <p class="text-muted small mb-0">Tambahkan anggota tim, setiap anggota wajib punya 1
                                        berkas NDA</p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-2" id="add-member">
                                <i class="bi bi-person-plus me-1"></i>Tambah Anggota
                            </button>
                        </div>

                        <div id="member-container">
                            <!-- Row awal -->
                            <div class="member-item mb-3">
                                <div class="member-card border rounded-2 p-3">
                                    <div class="d-flex align-items-start gap-3">
                                        <div
                                            class="member-avatar bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mt-1">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="text" name="members[0][name]"
                                                class="form-control member-input rounded-2 mb-2"
                                                placeholder="Nama lengkap anggota tim" maxlength="100" required>
                                            <input type="file" name="files[0]" class="form-control file-input"
                                                accept="application/pdf" required>
                                            @error('files.0')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm remove-member rounded-2 d-none"
                                            style="margin-top: 1rem;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-text small">
                            <i class="bi bi-lightbulb me-1"></i>
                            Minimal 1 anggota dengan 1 berkas PDF. Setiap anggota wajib punya berkas NDA.
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions pt-4 border-top">
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary btn-modern rounded-2" id="submitBtn">
                                <i class="bi bi-check-lg me-2"></i>Buat Proyek
                            </button>
                            <a href="{{ route('pegawai.dashboard') }}" class="btn btn-outline-secondary rounded-2">
                                <i class="bi bi-x-lg me-2"></i>Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            :root {
                --primary: #6366f1;
                --primary-soft: rgba(99, 102, 241, 0.1);
                --success: #10b981;
                --success-soft: rgba(16, 185, 129, 0.1);
                --warning: #f59e0b;
                --warning-soft: rgba(245, 158, 11, 0.1);
                --danger: #ef4444;
                --danger-soft: rgba(239, 68, 68, 0.1);
                --info: #0ea5e9;
                --info-soft: rgba(14, 165, 233, 0.1);
                --purple: #8b5cf6;
                --purple-soft: rgba(139, 92, 246, 0.1);
                --gray-50: #f9fafb;
                --gray-100: #f3f4f6;
                --gray-200: #e5e7eb;
                --gray-300: #d1d5db;
                --gray-400: #9ca3af;
                --gray-500: #6b7280;
                --gray-600: #4b5563;
                --gray-700: #374151;
                --gray-800: #1f2937;
                --gray-900: #111827;
                --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
                --radius: 0.5rem;
                --radius-md: 0.75rem;
                --radius-lg: 1rem;
            }

            .container-fluid {
                max-width: 1280px;
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .text-gray-900 {
                color: var(--gray-900) !important;
            }

            .text-purple {
                color: var(--purple) !important;
            }

            .bg-primary-soft {
                background-color: var(--primary-soft) !important;
            }

            .bg-success-soft {
                background-color: var(--success-soft) !important;
            }

            .bg-warning-soft {
                background-color: var(--warning-soft) !important;
            }

            .bg-danger-soft {
                background-color: var(--danger-soft) !important;
            }

            .bg-info-soft {
                background-color: var(--info-soft) !important;
            }

            .bg-purple-soft {
                background-color: var(--purple-soft) !important;
            }

            /* Progress Indicator */
            .progress-indicator {
                display: flex;
                align-items: center;
                justify-content: center;
                max-width: 600px;
                margin: 0 auto;
                padding: 1.5rem;
                background: white;
                border-radius: var(--radius-lg);
                box-shadow: var(--shadow-sm);
            }

            .progress-step {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                flex: 1;
            }

            .progress-step-circle {
                width: 2.5rem;
                height: 2.5rem;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                background: var(--gray-200);
                color: var(--gray-500);
                margin-bottom: 0.5rem;
                transition: all 0.3s ease;
            }

            .progress-step.active .progress-step-circle {
                background: var(--primary);
                color: white;
            }

            .progress-step-label {
                font-size: 0.875rem;
                color: var(--gray-600);
                font-weight: 500;
            }

            .progress-step.active .progress-step-label {
                color: var(--primary);
            }

            .progress-line {
                height: 3px;
                flex: 1;
                background: var(--gray-200);
                margin: 0 0.75rem;
                margin-top: -1rem;
            }

            /* Card Styling */
            .card {
                border-radius: var(--radius-lg);
                border: 1px solid var(--gray-200);
                box-shadow: var(--shadow);
            }

            .card-header {
                border-bottom: 1px solid var(--gray-200);
                background-color: white;
                padding: 1.5rem;
            }

            .feature-icon {
                width: 3rem;
                height: 3rem;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
            }

            /* Form Sections */
            .form-section {
                position: relative;
            }

            .section-header {
                padding-bottom: 1rem;
                border-bottom: 1px solid var(--gray-200);
            }

            .section-icon {
                width: 2.5rem;
                height: 2.5rem;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.125rem;
            }

            .section-title {
                color: var(--gray-900);
                font-weight: 600;
                font-size: 1.125rem;
                margin: 0;
            }

            .section-subtitle {
                color: var(--gray-600);
                font-size: 0.875rem;
                margin: 0.25rem 0 0 0;
            }

            /* Form Groups */
            .form-group {
                position: relative;
                margin-bottom: 1.5rem;
            }

            .form-label {
                font-weight: 500;
                color: var(--gray-700);
                margin-bottom: 0.5rem;
                font-size: 0.875rem;
            }

            .form-label.required::after {
                content: '*';
                color: var(--danger);
                margin-left: 0.25rem;
            }

            /* Input Wrapper */
            .input-wrapper {
                position: relative;
            }

            .input-icon {
                position: absolute;
                right: 0.75rem;
                top: 50%;
                transform: translateY(-50%);
                color: var(--gray-400);
                font-size: 1rem;
                pointer-events: none;
            }

            /* Form Controls */
            .form-control {
                border-radius: var(--radius);
                border: 1px solid var(--gray-300);
                transition: all 0.2s ease;
                font-size: 0.875rem;
                padding: 0.75rem 2.5rem 0.75rem 1rem;
                background-color: white;
            }

            .form-control:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
                outline: none;
            }

            .form-control::placeholder {
                color: var(--gray-400);
            }

            textarea.form-control {
                resize: vertical;
                min-height: 120px;
            }

            .form-text {
                font-size: 0.75rem;
                color: var(--gray-500);
                margin-top: 0.5rem;
            }

            /* Duration Display */
            .duration-display {
                height: 48px;
                border: 1px solid var(--gray-300);
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                padding: 0 1rem;
                background-color: var(--gray-50);
            }

            .duration-placeholder,
            .duration-result {
                display: flex;
                align-items: center;
                color: var(--gray-500);
                font-size: 0.875rem;
            }

            .duration-result {
                color: var(--gray-800);
                font-weight: 600;
            }

            /* Member Cards */
            .member-card {
                border: 1px solid var(--gray-200);
                border-radius: var(--radius);
                background: white;
                transition: all 0.2s ease;
            }

            .member-card:hover {
                border-color: var(--gray-300);
                box-shadow: var(--shadow-sm);
            }

            .member-avatar {
                width: 2.5rem;
                height: 2.5rem;
                border-radius: 50%;
                background: var(--primary-soft);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--primary);
                font-size: 1.125rem;
            }

            .member-input {
                border: none;
                background: transparent;
                padding: 0.5rem 0;
                font-weight: 500;
            }

            .member-input:focus {
                box-shadow: none;
                border-color: transparent;
            }

            /* File Upload Cards */
            .file-upload-card {
                border: 2px dashed var(--gray-300);
                border-radius: var(--radius);
                background: var(--gray-50);
                transition: all 0.2s ease;
            }

            .file-upload-card:hover {
                border-color: var(--primary);
                background: rgba(99, 102, 241, 0.02);
            }

            .file-upload-label {
                cursor: pointer;
                margin: 0;
            }

            .file-upload-icon {
                width: 3rem;
                height: 3rem;
                border-radius: var(--radius);
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--primary);
                font-size: 1.5rem;
                box-shadow: var(--shadow-sm);
            }

            .file-name {
                color: var(--gray-800);
                font-weight: 500;
                font-size: 0.875rem;
            }

            .file-requirements {
                background: white;
                border-radius: 0 0 var(--radius) var(--radius);
            }

            /* Buttons */
            .btn-modern {
                border-radius: var(--radius);
                font-weight: 600;
                padding: 0.75rem 1.5rem;
                transition: all 0.2s ease;
                border: none;
                font-size: 0.875rem;
            }

            .btn-primary.btn-modern {
                background-color: var(--primary);
                box-shadow: 0 2px 4px 0 rgba(99, 102, 241, 0.1);
            }

            .btn-primary.btn-modern:hover {
                background-color: #4f46e5;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px 0 rgba(99, 102, 241, 0.2);
            }

            .btn-outline-secondary {
                border: 1px solid var(--gray-300);
                color: var(--gray-600);
                background: white;
                transition: all 0.2s ease;
                font-weight: 500;
                font-size: 0.875rem;
            }

            .btn-outline-secondary:hover {
                background-color: var(--gray-50);
                border-color: var(--gray-400);
                color: var(--gray-700);
            }

            /* Alert Styling */
            .alert {
                border-radius: var(--radius);
                border: none;
                font-size: 0.875rem;
                padding: 1rem;
            }

            .alert-info {
                background-color: var(--info-soft);
                color: #0369a1;
            }

            .alert-success {
                background-color: var(--success-soft);
                color: #065f46;
            }

            .alert-warning {
                background-color: var(--warning-soft);
                color: #92400e;
            }

            /* Invalid Feedback */
            .invalid-feedback {
                font-size: 0.75rem;
                margin-top: 0.5rem;
                color: var(--danger);
            }

            .is-invalid {
                border-color: var(--danger) !important;
                box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
            }

            .file-upload-card.is-invalid {
                border-color: var(--danger) !important;
                box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
            }

            /* Loading Animation */
            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            .spin {
                animation: spin 1s linear infinite;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .container-fluid {
                    padding-left: 1.5rem;
                    padding-right: 1.5rem;
                }

                .progress-indicator {
                    flex-direction: column;
                    gap: 1rem;
                }

                .progress-line {
                    width: 3px;
                    height: 2rem;
                    margin: 0;
                }

                .section-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.75rem;
                }

                .form-actions .d-flex {
                    flex-direction: column;
                    gap: 0.75rem;
                }
            }

            @media (max-width: 576px) {
                .file-upload-content {
                    flex-direction: column;
                    text-align: center;
                    gap: 1rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let memberCount = 1;

                // Character counter for description
                const descriptionTextarea = document.getElementById('description');
                const descriptionCounter = document.getElementById('descriptionCount');
                if (descriptionTextarea && descriptionCounter) {
                    descriptionTextarea.addEventListener('input', function() {
                        descriptionCounter.textContent = this.value.length;
                    });
                    descriptionCounter.textContent = descriptionTextarea.value.length;
                }

                // Add Member
                document.getElementById('add-member').addEventListener('click', function() {
                    const container = document.getElementById('member-container');
                    const newItem = document.createElement('div');
                    newItem.className = 'member-item mb-3';
                    newItem.innerHTML = `
                        <div class="member-card border rounded-2 p-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="member-avatar bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mt-1">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="text" name="members[${memberCount}][name]" class="form-control member-input rounded-2 mb-2" placeholder="Nama lengkap anggota tim" maxlength="100" required>
                                    <input type="file" name="files[${memberCount}]" class="form-control file-input" accept="application/pdf" required>
                                    @error('files.${memberCount}')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm remove-member rounded-2 d-none" style="margin-top: 1rem;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    container.appendChild(newItem);
                    memberCount++;
                    updateRemoveButtons();
                    attachFileValidation(newItem.querySelector('.file-input'));
                });

                // Update Remove Buttons
                function updateRemoveButtons() {
                    const memberItems = document.querySelectorAll('.member-item');
                    memberItems.forEach((item, index) => {
                        const removeBtn = item.querySelector('.remove-member');
                        if (memberItems.length > 1) {
                            removeBtn.classList.remove('d-none');
                            removeBtn.onclick = function() {
                                Swal.fire({
                                    title: 'Hapus Anggota',
                                    text: 'Apakah Anda yakin ingin menghapus anggota ini dan berkasnya?',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#ef4444',
                                    cancelButtonColor: '#6b7280',
                                    confirmButtonText: 'Hapus',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        item.remove();
                                        updateRemoveButtons();
                                    }
                                });
                            };
                        } else {
                            removeBtn.classList.add('d-none');
                        }
                    });
                }

                // Duration Calculator
                function calculateDuration() {
                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;
                    const durationDisplay = document.getElementById('duration-display');

                    if (startDate && endDate) {
                        const start = new Date(startDate);
                        const end = new Date(endDate);
                        const diffTime = end - start;
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        if (diffDays <= 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Tanggal Tidak Valid',
                                text: 'Tanggal berakhir harus setelah tanggal mulai.',
                                confirmButtonText: 'Mengerti',
                                confirmButtonColor: '#6366f1'
                            });
                            document.getElementById('end_date').value = '';
                            durationDisplay.innerHTML = `
                                <div class="duration-placeholder d-flex align-items-center">
                                    <i class="bi bi-clock me-2"></i>
                                    <span>Akan dihitung otomatis</span>
                                </div>
                            `;
                            return;
                        }

                        const months = Math.floor(diffDays / 30);
                        const weeks = Math.floor((diffDays % 30) / 7);
                        const days = diffDays % 7;
                        let durationText = '';
                        if (months > 0) durationText += `${months} bulan `;
                        if (weeks > 0) durationText += `${weeks} minggu `;
                        if (days > 0 || durationText === '') durationText += `${days} hari`;

                        durationDisplay.innerHTML = `
                            <div class="duration-result d-flex align-items-center">
                                <i class="bi bi-calendar-check me-2 text-success"></i>
                                <span>${durationText.trim()} (${diffDays} hari total)</span>
                            </div>
                        `;
                    } else {
                        durationDisplay.innerHTML = `
                            <div class="duration-placeholder d-flex align-items-center">
                                <i class="bi bi-clock me-2"></i>
                                <span>Akan dihitung otomatis</span>
                            </div>
                        `;
                    }
                }

                // Update NDA Status with warning if empty
                function updateNDAStatus() {
                    const ndaDate = document.getElementById('nda_signature_date').value;
                    const statusAlert = document.querySelector('.nda-status-info .alert');
                    const ndaInput = document.getElementById('nda_signature_date');

                    if (ndaDate) {
                        statusAlert.className = 'alert alert-success small rounded-2 mb-0 p-3';
                        statusAlert.innerHTML = `
                    <i class="bi bi-check-circle me-2"></i>
                    <div>
                        <strong>Status NDA:</strong>
                        <span>Sudah ditandatangani pada ${formatDate(ndaDate)}</span>
                    </div>
                `;
                        ndaInput.classList.remove('is-invalid');
                    } else {
                        statusAlert.className = 'alert alert-warning small rounded-2 mb-0 p-3';
                        statusAlert.innerHTML = `
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <div>
                        <strong>Status NDA:</strong>
                        <span>Wajib diisi sebelum membuat proyek</span>
                    </div>
                `;
                        ndaInput.classList.add('is-invalid');
                    }
                }

                // Format Date to Indonesian
                function formatDate(dateString) {
                    const date = new Date(dateString);
                    const months = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];
                    return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
                }

                // File Validation
                function attachFileValidation(input) {
                    input.addEventListener('change', function() {
                        if (this.files.length > 0) {
                            const file = this.files[0];
                            if (file.type !== 'application/pdf') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Tipe File Tidak Valid',
                                    text: 'Harap pilih file PDF saja.',
                                    confirmButtonText: 'Mengerti',
                                    confirmButtonColor: '#6366f1'
                                });
                                this.value = '';
                                return;
                            }

                            const maxSize = 2 * 1024 * 1024; // PERBAIKAN: Max 2MB per file
                            if (file.size > maxSize) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'File Terlalu Besar',
                                    text: 'Ukuran file maksimal 2MB.',
                                    confirmButtonText: 'Mengerti',
                                    confirmButtonColor: '#6366f1'
                                });
                                this.value = '';
                                return;
                            }
                        }
                    });
                }

                // Form Validation (diperkuat untuk dynamic fields)
                function validateForm() {
                    const form = document.getElementById('projectForm');
                    const inputs = form.querySelectorAll('input[required], textarea[required]');
                    let isValid = true;

                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    // PERBAIKAN: Validasi setiap row anggota punya nama + file
                    const memberRows = document.querySelectorAll('.member-item');
                    memberRows.forEach(row => {
                        const nameInput = row.querySelector('input[name*="members"][name*="name"]');
                        const fileInput = row.querySelector('input[name*="files"]');
                        if (!nameInput.value.trim()) {
                            nameInput.classList.add('is-invalid');
                            isValid = false;
                        }
                        if (!fileInput.files.length) {
                            fileInput.classList.add('is-invalid');
                            isValid = false;
                        }
                    });

                    return isValid;
                }

                // Event Listeners
                document.getElementById('start_date').addEventListener('change', calculateDuration);
                document.getElementById('end_date').addEventListener('change', calculateDuration);
                document.getElementById('nda_signature_date').addEventListener('change', updateNDAStatus);

                document.getElementById('projectForm').addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Form Tidak Lengkap',
                            text: 'Harap isi semua field yang wajib, termasuk Tanggal Penandatanganan NDA jika belum diisi.',
                            confirmButtonText: 'Mengerti',
                            confirmButtonColor: '#6366f1'
                        });
                        return;
                    }

                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise spin me-2"></i>Membuat Proyek...';

                    Swal.fire({
                        title: 'Membuat Proyek',
                        text: 'Mohon tunggu, sedang memproses data...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                });

                // Realtime validation untuk semua input
                document.querySelectorAll(
                    'input[required], textarea[required], input[name^="members["], input[name^="files["]').forEach(
                    input => {
                        input.addEventListener('blur', function() {
                            if (!this.value.trim() && this.required) {
                                this.classList.add('is-invalid');
                            } else {
                                this.classList.remove('is-invalid');
                            }
                        });
                        input.addEventListener('input', function() {
                            if (this.classList.contains('is-invalid') && this.value.trim()) {
                                this.classList.remove('is-invalid');
                            }
                        });
                    });

                // Initial setup
                updateRemoveButtons();
                document.querySelectorAll('.file-input').forEach(input => attachFileValidation(input));

                // Real-time validation
                document.querySelectorAll('input[required], textarea[required]').forEach(input => {
                    input.addEventListener('blur', function() {
                        if (this.value.trim()) {
                            this.classList.remove('is-invalid');
                        } else {
                            this.classList.add('is-invalid');
                        }
                    });
                    input.addEventListener('input', function() {
                        if (this.classList.contains('is-invalid') && this.value.trim()) {
                            this.classList.remove('is-invalid');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
