@extends('layouts.app')
@section('title', 'Buat Proyek NDA Baru')
@section('content')
    <div class="main-container">
        <!-- Header Section -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-text">
                    <h1 class="page-title">Buat Proyek Baru</h1>
                    <p class="page-subtitle">Tambahkan proyek NDA baru dengan mudah dan atur semua detail yang diperlukan
                        dalam satu tempat</p>
                </div>
                <div class="header-action">
                    <a href="{{ route('pegawai.dashboard') }}" class="btn btn-secondary btn-back">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Progress Indicator -->
        <div class="progress-section">
            <div class="progress-indicator">
                <div class="progress-step active" data-step="1">
                    <div class="progress-step-circle">
                        <i class="bi bi-circle"></i>
                    </div>
                    <div class="progress-step-label">Informasi Dasar</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step" data-step="2">
                    <div class="progress-step-circle">
                        <i class="bi bi-calendar"></i>
                    </div>
                    <div class="progress-step-label">Timeline Proyek</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step" data-step="3">
                    <div class="progress-step-circle">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="progress-step-label">Tim & Berkas</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step" data-step="4">
                    <div class="progress-step-circle">
                        <i class="bi bi-check"></i>
                    </div>
                    <div class="progress-step-label">Konfirmasi Data</div>
                </div>
            </div>
        </div>
        <!-- Main Form -->
        <div class="form-container">
            <form method="POST" action="{{ route('pegawai.nda.store') }}" enctype="multipart/form-data" id="projectForm">
                @csrf
                <!-- Step 1: Basic Information -->
                <div class="form-step active" data-step="1">
                    <div class="step-card">
                        <div class="step-header">
                            <div class="step-icon step-icon-info">
                                <i class="bi bi-circle"></i>
                            </div>
                            <div class="step-content">
                                <h3 class="step-title">Informasi Dasar Proyek</h3>
                                <p class="step-description">Berikan nama dan deskripsi yang jelas untuk proyek NDA Anda</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="form-grid">
                                <div class="form-field col-span-2">
                                    <label for="project_name" class="field-label required">Nama Proyek</label>
                                    <div class="field-wrapper">
                                        <div class="field-icon">
                                            <i class="bi bi-folder"></i>
                                        </div>
                                        <input type="text" name="project_name" id="project_name"
                                            class="field-input @error('project_name') field-error @enderror"
                                            value="{{ old('project_name') }}"
                                            placeholder="Contoh: Proyek Pengembangan Aplikasi Mobile" maxlength="255"
                                            required>
                                    </div>
                                    @error('project_name')
                                        <div class="field-feedback field-feedback-error">{{ $message }}</div>
                                    @else
                                        <div class="field-hint">Masukkan nama proyek yang jelas dan deskriptif</div>
                                    @enderror
                                </div>
                                <div class="form-field col-span-2">
                                    <label for="description" class="field-label">Deskripsi Proyek</label>
                                    <div class="field-wrapper">
                                        <textarea name="description" id="description" class="field-textarea @error('description') field-error @enderror"
                                            rows="4" placeholder="Deskripsikan tujuan, lingkup, dan detail penting dari proyek ini..." maxlength="1000">{{ old('description') }}</textarea>
                                        <div class="textarea-counter">
                                            <span id="descriptionCount">0</span>/1000
                                        </div>
                                    </div>
                                    @error('description')
                                        <div class="field-feedback field-feedback-error">{{ $message }}</div>
                                    @else
                                        <div class="field-hint">Opsional - Berikan gambaran umum tentang proyek</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Step 2: Timeline -->
                <div class="form-step" data-step="2">
                    <div class="step-card">
                        <div class="step-header">
                            <div class="step-icon step-icon-warning">
                                <i class="bi bi-calendar"></i>
                            </div>
                            <div class="step-content">
                                <h3 class="step-title">Timeline Proyek</h3>
                                <p class="step-description">Tentukan periode pelaksanaan proyek dari awal hingga selesai</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="form-grid">
                                <div class="form-field">
                                    <label for="start_date" class="field-label required">Tanggal Mulai</label>
                                    <div class="field-wrapper">
                                        <div class="field-icon">
                                            <i class="bi bi-calendar-event"></i>
                                        </div>
                                        <input type="date" name="start_date" id="start_date"
                                            class="field-input @error('start_date') field-error @enderror"
                                            value="{{ old('start_date') }}" required>
                                    </div>
                                    @error('start_date')
                                        <div class="field-feedback field-feedback-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-field">
                                    <label for="end_date" class="field-label required">Tanggal Berakhir</label>
                                    <div class="field-wrapper">
                                        <div class="field-icon">
                                            <i class="bi bi-calendar-check"></i>
                                        </div>
                                        <input type="date" name="end_date" id="end_date"
                                            class="field-input @error('end_date') field-error @enderror"
                                            value="{{ old('end_date') }}" required>
                                    </div>
                                    @error('end_date')
                                        <div class="field-feedback field-feedback-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="duration-card" id="duration-display">
                                <div class="duration-icon">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="duration-info">
                                    <div class="duration-label">Durasi Proyek</div>
                                    <div class="duration-value" id="duration-text">Akan dihitung otomatis</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Step 3: Team & Files -->
                <div class="form-step" data-step="3">
                    <div class="step-card">
                        <div class="step-header">
                            <div class="step-icon step-icon-primary">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="step-content">
                                <h3 class="step-title">Anggota Tim & Berkas NDA</h3>
                                <p class="step-description">Tambahkan anggota tim dan berkas NDA yang diperlukan</p>
                            </div>
                            <div class="step-action">
                                <button type="button" class="btn btn-primary btn-add-member" id="add-member">
                                    <i class="bi bi-person-plus me-2"></i>
                                    Tambah Anggota
                                </button>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="members-container" id="member-container">
                                <!-- First member row -->
                                <div class="member-card" data-member="0">
                                    <div class="member-header">
                                        <div class="member-avatar">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <div class="member-info">
                                            <div class="member-label">Anggota ke-1</div>
                                        </div>
                                        <button type="button" class="btn-remove-member" style="display: none;">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                    <div class="member-body">
                                        <div class="member-fields">
                                            <div class="member-field">
                                                <label class="field-label required">Nama Lengkap</label>
                                                <div class="field-wrapper">
                                                    <input type="text" name="members[0][name]"
                                                        class="field-input member-name"
                                                        placeholder="Masukkan nama lengkap anggota tim" maxlength="100"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="member-field">
                                                <label class="field-label required">Tanggal Tanda Tangan NDA</label>
                                                <div class="field-wrapper">
                                                    <div class="field-icon">
                                                        <i class="bi bi-pen"></i>
                                                    </div>
                                                    <input type="date" name="members[0][signature_date]"
                                                        class="field-input" required>
                                                </div>
                                                <div class="field-hint">Tanggal ketika anggota ini menandatangani NDA</div>
                                            </div>
                                            <div class="member-field">
                                                <label class="field-label required">Berkas NDA (PDF)</label>
                                                <div class="file-upload-area">
                                                    <input type="file" name="files[0]" class="file-input"
                                                        id="file-0" accept="application/pdf" required>
                                                    <label for="file-0" class="file-upload-label">
                                                        <div class="file-upload-icon">
                                                            <i class="bi bi-cloud-upload"></i>
                                                        </div>
                                                        <div class="file-upload-text">
                                                            <div class="file-upload-title">Pilih atau Seret File PDF</div>
                                                            <div class="file-upload-subtitle">Maksimal 10MB</div>
                                                        </div>
                                                    </label>
                                                    <div class="file-upload-info" style="display: none;">
                                                        <div class="file-info">
                                                            <i class="bi bi-file-earmark-pdf"></i>
                                                            <span class="file-name"></span>
                                                            <i class="bi bi-check-circle success-icon"
                                                                title="Berkas berhasil dimasukkan"></i>
                                                        </div>
                                                        <button type="button" class="btn-remove-file">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @error('files.0')
                                                    <div class="field-feedback field-feedback-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="member-actions">
                                            <button type="button" class="btn btn-success btn-save-member">
                                                <i class="bi bi-save me-2"></i>Save Anggota Ini
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="saved-members-table" id="saved-members-table">
                                <h4>Daftar Anggota yang Sudah Disimpan</h4>
                                <div class="table-wrapper">
                                    <table class="table table-minimal">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Tanggal Tanda Tangan</th>
                                                <th>Berkas</th>
                                            </tr>
                                        </thead>
                                        <tbody id="saved-table-body">
                                            <!-- Diisi oleh JS setelah save -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="members-hint">
                                <div class="hint-icon">
                                    <i class="bi bi-info-circle"></i>
                                </div>
                                <div class="hint-text">
                                    Setiap anggota tim harus memiliki berkas NDA dalam format PDF dan tanggal tanda tangan.
                                    Minimal 1 anggota diperlukan untuk membuat proyek.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Step 4: Confirmation -->
                <div class="form-step" data-step="4">
                    <div class="step-card">
                        <div class="step-header">
                            <div class="step-icon step-icon-success">
                                <i class="bi bi-check"></i>
                            </div>
                            <div class="step-content">
                                <h3 class="step-title">Konfirmasi Data Anggota</h3>
                                <p class="step-description">Periksa kembali data anggota tim dan berkas NDA. Anda bisa edit
                                    atau hapus jika diperlukan.</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="confirmation-table">
                                <div class="table-wrapper">
                                    <table class="table table-minimal">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Tanggal Tanda Tangan</th>
                                                <th>Berkas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="confirmation-table-body">
                                            <!-- Diisi oleh JS dari session/temp data -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="confirmation-hint">
                                <div class="hint-icon"><i class="bi bi-info-circle"></i></div>
                                <div class="hint-text">Pastikan semua data benar sebelum submit final.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form Navigation -->
                <div class="form-navigation">
                    <div class="nav-buttons">
                        <button type="button" class="btn btn-secondary btn-nav" id="prevBtn" style="display: none;">
                            <i class="bi bi-chevron-left me-2"></i>
                            Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary btn-nav" id="nextBtn">
                            Selanjutnya
                            <i class="bi bi-chevron-right ms-2"></i>
                        </button>
                        <button type="submit" class="btn btn-success btn-nav" id="submitBtn" style="display: none;">
                            <i class="bi bi-check-circle me-2"></i>
                            Buat Proyek
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('styles')
        <style>
            /* CSS Variables */
            :root {
                --primary: #4f46e5;
                --primary-light: #6366f1;
                --primary-dark: #4338ca;
                --primary-bg: rgba(79, 70, 229, 0.08);
                --secondary: #6b7280;
                --secondary-light: #9ca3af;
                --secondary-dark: #4b5563;
                --secondary-bg: rgba(107, 114, 128, 0.08);
                --success: #10b981;
                --success-light: #34d399;
                --success-dark: #059669;
                --success-bg: rgba(16, 185, 129, 0.08);
                --warning: #f59e0b;
                --warning-light: #fbbf24;
                --warning-dark: #d97706;
                --warning-bg: rgba(245, 158, 11, 0.08);
                --danger: #ef4444;
                --danger-light: #f87171;
                --danger-dark: #dc2626;
                --danger-bg: rgba(239, 68, 68, 0.08);
                --info: #0ea5e9;
                --info-light: #38bdf8;
                --info-dark: #0284c7;
                --info-bg: rgba(14, 165, 233, 0.08);
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
                --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
                --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                --radius: 8px;
                --radius-sm: 6px;
                --radius-lg: 12px;
                --radius-xl: 16px;
                --radius-2xl: 20px;
                --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                --transition-fast: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
                --transition-slow: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Base Styles */
            * {
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                background-color: var(--gray-50);
                color: var(--gray-900);
                line-height: 1.6;
            }

            /* Main Container */
            .main-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem 1rem;
                min-height: 100vh;
            }

            /* Page Header */
            .page-header {
                margin-bottom: 2rem;
            }

            .header-content {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 2rem;
                background: white;
                padding: 2rem;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-sm);
                border: 1px solid var(--gray-200);
            }

            .header-text {
                flex: 1;
            }

            .page-title {
                font-size: 2rem;
                font-weight: 700;
                color: var(--gray-900);
                margin: 0 0 0.5rem 0;
                letter-spacing: -0.025em;
            }

            .page-subtitle {
                font-size: 1rem;
                color: var(--gray-600);
                margin: 0;
                line-height: 1.5;
            }

            .header-action {
                display: flex;
                align-items: center;
            }

            /* Progress Section - Simplified Icons */
            .progress-section {
                margin-bottom: 2rem;
            }

            .progress-indicator {
                display: flex;
                align-items: center;
                justify-content: center;
                background: white;
                padding: 2rem;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-sm);
                border: 1px solid var(--gray-200);
                max-width: 800px;
                margin: 0 auto;
            }

            .progress-step {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                position: relative;
                flex: 1;
                transition: var(--transition);
            }

            .progress-step-circle {
                width: 2.5rem;
                height: 2.5rem;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                background: var(--gray-200);
                color: var(--gray-500);
                margin-bottom: 0.5rem;
                transition: var(--transition);
                position: relative;
                z-index: 2;
            }

            .progress-step.active .progress-step-circle,
            .progress-step.completed .progress-step-circle {
                background: var(--primary);
                color: white;
                transform: scale(1.05);
                box-shadow: 0 0 0 3px var(--primary-bg);
            }

            .progress-step.completed .progress-step-circle {
                background: var(--success);
            }

            .progress-step-label {
                font-size: 0.75rem;
                color: var(--gray-600);
                font-weight: 500;
                transition: var(--transition);
                white-space: nowrap;
            }

            .progress-step.active .progress-step-label,
            .progress-step.completed .progress-step-label {
                color: var(--primary);
                font-weight: 600;
            }

            .progress-step.completed .progress-step-label {
                color: var(--success);
            }

            .progress-line {
                height: 2px;
                background: var(--gray-200);
                flex: 1;
                margin: 0 0.5rem;
                margin-top: -1.25rem;
                position: relative;
                z-index: 1;
                transition: var(--transition);
            }

            .progress-line.completed {
                background: var(--success);
            }

            /* Form Container */
            .form-container {
                background: white;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-sm);
                border: 1px solid var(--gray-200);
                overflow: hidden;
            }

            /* Form Steps */
            .form-step {
                display: none;
                animation: fadeInSlide 0.5s ease-out;
            }

            .form-step.active {
                display: block;
            }

            @keyframes fadeInSlide {
                from {
                    opacity: 0;
                    transform: translateX(20px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            /* Step Cards - Simplified Icons */
            .step-card {
                padding: 2.5rem;
            }

            .step-header {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                margin-bottom: 2rem;
                padding-bottom: 1.5rem;
                border-bottom: 1px solid var(--gray-200);
            }

            .step-icon {
                width: 2.5rem;
                height: 2.5rem;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.125rem;
                flex-shrink: 0;
            }

            .step-icon-primary {
                background: var(--primary-bg);
                color: var(--primary);
            }

            .step-icon-secondary {
                background: var(--secondary-bg);
                color: var(--secondary);
            }

            .step-icon-success {
                background: var(--success-bg);
                color: var(--success);
            }

            .step-icon-warning {
                background: var(--warning-bg);
                color: var(--warning);
            }

            .step-icon-danger {
                background: var(--danger-bg);
                color: var(--danger);
            }

            .step-icon-info {
                background: var(--info-bg);
                color: var(--info);
            }

            .step-content {
                flex: 1;
            }

            .step-title {
                font-size: 1.25rem;
                font-weight: 700;
                color: var(--gray-900);
                margin: 0 0 0.25rem 0;
            }

            .step-description {
                font-size: 0.875rem;
                color: var(--gray-600);
                margin: 0;
                line-height: 1.4;
            }

            .step-action {
                display: flex;
                align-items: center;
            }

            .step-body {
                padding: 0;
            }

            /* Form Grid */
            .form-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }

            .form-field {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .form-field.col-span-2 {
                grid-column: 1 / -1;
            }

            /* Field Elements */
            .field-label {
                font-size: 0.875rem;
                font-weight: 600;
                color: var(--gray-700);
                display: flex;
                align-items: center;
                gap: 0.25rem;
            }

            .field-label.required::after {
                content: '*';
                color: var(--danger);
                font-size: 0.875rem;
            }

            .field-wrapper {
                position: relative;
                display: flex;
                align-items: center;
            }

            .field-icon {
                position: absolute;
                left: 1rem;
                z-index: 2;
                color: var(--gray-400);
                font-size: 1rem;
                pointer-events: none;
            }

            .field-input {
                width: 100%;
                padding: 0.75rem 1rem 0.75rem 2.5rem;
                border: 1px solid var(--gray-300);
                border-radius: var(--radius);
                font-size: 0.875rem;
                background: white;
                transition: var(--transition);
                outline: none;
            }

            .field-input:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px var(--primary-bg);
            }

            .field-input::placeholder {
                color: var(--gray-400);
            }

            .field-textarea {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid var(--gray-300);
                border-radius: var(--radius);
                font-size: 0.875rem;
                background: white;
                transition: var(--transition);
                outline: none;
                resize: vertical;
                min-height: 100px;
            }

            .field-textarea:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px var(--primary-bg);
            }

            .field-error {
                border-color: var(--danger) !important;
                box-shadow: 0 0 0 3px var(--danger-bg) !important;
            }

            .textarea-counter {
                position: absolute;
                bottom: 0.5rem;
                right: 0.75rem;
                font-size: 0.75rem;
                color: var(--gray-500);
                background: white;
                padding: 0.25rem;
                border-radius: var(--radius-sm);
            }

            .field-feedback {
                font-size: 0.75rem;
                margin-top: -0.25rem;
            }

            .field-feedback-error {
                color: var(--danger);
            }

            .field-hint {
                font-size: 0.75rem;
                color: var(--gray-500);
            }

            /* Duration Card */
            .duration-card {
                background: linear-gradient(135deg, var(--primary-bg) 0%, var(--info-bg) 100%);
                border: 1px solid var(--gray-200);
                border-radius: var(--radius-lg);
                padding: 1rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                margin-top: 1rem;
                transition: var(--transition);
            }

            .duration-card:hover {
                transform: translateY(-1px);
                box-shadow: var(--shadow-md);
            }

            .duration-icon {
                width: 2rem;
                height: 2rem;
                background: white;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--primary);
                font-size: 1rem;
                box-shadow: var(--shadow-sm);
            }

            .duration-info {
                flex: 1;
            }

            .duration-label {
                font-size: 0.75rem;
                font-weight: 600;
                color: var(--gray-700);
                margin-bottom: 0.125rem;
            }

            .duration-value {
                font-size: 0.875rem;
                color: var(--gray-900);
                font-weight: 500;
            }

            /* Members Container */
            .members-container {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                max-height: 400px;
                overflow-y: auto;
            }

            .member-card {
                background: var(--gray-50);
                border: 1px solid var(--gray-200);
                border-radius: var(--radius-lg);
                padding: 1rem;
                transition: var(--transition);
            }

            .member-card:hover {
                background: white;
                border-color: var(--gray-300);
                box-shadow: var(--shadow-sm);
            }

            .member-header {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                margin-bottom: 1rem;
                padding-bottom: 0.75rem;
                border-bottom: 1px solid var(--gray-200);
            }

            .member-avatar {
                width: 2rem;
                height: 2rem;
                background: var(--primary-bg);
                color: var(--primary);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.875rem;
                flex-shrink: 0;
            }

            .member-info {
                flex: 1;
            }

            .member-label {
                font-size: 0.75rem;
                font-weight: 600;
                color: var(--gray-700);
            }

            .btn-remove-member {
                width: 1.5rem;
                height: 1.5rem;
                border: none;
                background: var(--danger-bg);
                color: var(--danger);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: var(--transition);
                font-size: 0.75rem;
            }

            .btn-remove-member:hover {
                background: var(--danger);
                color: white;
                transform: scale(1.05);
            }

            .member-body {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .member-fields {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            .member-field {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .member-name {
                padding-left: 1rem !important;
            }

            /* File Upload - Compact */
            .file-upload-area {
                position: relative;
            }

            .file-input {
                position: absolute;
                opacity: 0;
                width: 100%;
                height: 100%;
                cursor: pointer;
                z-index: 2;
            }

            .file-upload-label {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 1rem;
                border: 2px dashed var(--gray-300);
                border-radius: var(--radius);
                background: white;
                cursor: pointer;
                transition: var(--transition);
                text-align: left;
                font-size: 0.875rem;
            }

            .file-upload-label:hover {
                border-color: var(--primary);
                background: var(--primary-bg);
            }

            .file-upload-icon {
                width: 1.75rem;
                height: 1.75rem;
                background: var(--primary-bg);
                color: var(--primary);
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.875rem;
                flex-shrink: 0;
            }

            .file-upload-text {
                flex: 1;
            }

            .file-upload-title {
                font-size: 0.75rem;
                font-weight: 600;
                color: var(--gray-700);
                margin-bottom: 0.125rem;
            }

            .file-upload-subtitle {
                font-size: 0.625rem;
                color: var(--gray-500);
            }

            .file-upload-info {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0.75rem;
                background: var(--success-bg);
                border: 1px solid var(--success);
                border-radius: var(--radius);
                font-size: 0.75rem;
            }

            .file-info {
                display: flex;
                align-items: center;
                gap: 0.25rem;
                color: var(--success-dark);
                font-weight: 500;
            }

            .file-name {
                max-width: 150px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .btn-remove-file {
                width: 1.25rem;
                height: 1.25rem;
                border: none;
                background: var(--danger-bg);
                color: var(--danger);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: var(--transition);
                font-size: 0.625rem;
            }

            .btn-remove-file:hover {
                background: var(--danger);
                color: white;
            }

            /* Members Hint */
            .members-hint,
            .confirmation-hint {
                display: flex;
                align-items: flex-start;
                gap: 0.5rem;
                padding: 0.75rem;
                background: var(--info-bg);
                border-radius: var(--radius);
                margin-top: 1rem;
                font-size: 0.875rem;
            }

            .hint-icon {
                width: 1rem;
                height: 1rem;
                color: var(--info);
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-top: 0.15rem;
            }

            .hint-text {
                color: var(--info-dark);
                line-height: 1.4;
                flex: 1;
            }

            /* Minimalist Table */
            .saved-members-table h4,
            .confirmation-table h4 {
                font-size: 1rem;
                font-weight: 600;
                color: var(--gray-900);
                margin-bottom: 0.75rem;
            }

            .table-wrapper {
                overflow-x: auto;
                border-radius: var(--radius);
                border: 1px solid var(--gray-200);
                background: white;
            }

            .table-minimal {
                width: 100%;
                min-width: 400px;
                border-collapse: collapse;
                font-size: 0.875rem;
            }

            .table-minimal th,
            .table-minimal td {
                padding: 0.5rem 0.75rem;
                text-align: left;
                border-bottom: 1px solid var(--gray-100);
            }

            .table-minimal th {
                background: var(--gray-50);
                font-weight: 600;
                color: var(--gray-700);
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.025em;
            }

            .table-minimal tbody tr:hover {
                background: var(--gray-50);
            }

            .table-minimal td {
                color: var(--gray-600);
            }

            .table-minimal .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.625rem;
                margin: 0 0.25rem;
            }

            /* Buttons */
            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.75rem 1.5rem;
                font-size: 0.875rem;
                font-weight: 600;
                text-decoration: none;
                border: none;
                border-radius: var(--radius);
                transition: var(--transition);
                cursor: pointer;
                white-space: nowrap;
                outline: none;
            }

            .btn:focus {
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary), var(--primary-light));
                color: white;
                box-shadow: var(--shadow-sm);
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, var(--primary-dark), var(--primary));
                transform: translateY(-1px);
                box-shadow: var(--shadow-md);
            }

            .btn-secondary {
                background: white;
                color: var(--gray-700);
                border: 1px solid var(--gray-300);
            }

            .btn-secondary:hover {
                background: var(--gray-50);
                border-color: var(--gray-400);
                color: var(--gray-800);
            }

            .btn-success {
                background: linear-gradient(135deg, var(--success), var(--success-light));
                color: white;
                box-shadow: var(--shadow-sm);
            }

            .btn-success:hover {
                background: linear-gradient(135deg, var(--success-dark), var(--success));
                transform: translateY(-1px);
                box-shadow: var(--shadow-md);
            }

            .btn-danger {
                background: linear-gradient(135deg, var(--danger), var(--danger-light));
                color: white;
                box-shadow: var(--shadow-sm);
            }

            .btn-danger:hover {
                background: linear-gradient(135deg, var(--danger-dark), var(--danger));
                transform: translateY(-1px);
                box-shadow: var(--shadow-md);
            }

            .btn-back {
                padding: 0.75rem 1.25rem;
                font-size: 0.875rem;
            }

            .btn-add-member {
                padding: 0.75rem 1.25rem;
                font-size: 0.875rem;
            }

            .btn-nav {
                padding: 1rem 2rem;
                font-size: 1rem;
                border-radius: var(--radius-lg);
            }

            /* Form Navigation */
            .form-navigation {
                background: var(--gray-50);
                padding: 2rem 2.5rem;
                border-top: 1px solid var(--gray-200);
            }

            .nav-buttons {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
            }

            .nav-buttons .btn {
                min-width: 140px;
            }

            /* Animations */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            .loading-spin {
                animation: spin 1s linear infinite;
            }

            .fade-in {
                animation: fadeIn 0.3s ease-out;
            }

            .slide-in {
                animation: slideIn 0.3s ease-out;
            }

            /* Responsive Design - Enhanced for Mobile */
            @media (max-width: 1024px) {
                .main-container {
                    padding: 1.5rem 1rem;
                }

                .step-card {
                    padding: 2rem;
                }

                .form-grid {
                    grid-template-columns: 1fr;
                    gap: 1.25rem;
                }

                .member-fields {
                    grid-template-columns: 1fr;
                    gap: 1rem;
                }

                .members-container {
                    max-height: 300px;
                }
            }

            @media (max-width: 768px) {
                .header-content {
                    flex-direction: column;
                    gap: 1.5rem;
                    padding: 1.5rem;
                    text-align: center;
                }

                .page-title {
                    font-size: 1.5rem;
                }

                .progress-indicator {
                    flex-direction: column;
                    gap: 1.5rem;
                    padding: 1.5rem;
                }

                .progress-line {
                    width: 2px;
                    height: 1rem;
                    margin: 0;
                }

                .progress-step-circle {
                    width: 2rem;
                    height: 2rem;
                    font-size: 0.875rem;
                }

                .progress-step-label {
                    font-size: 0.625rem;
                }

                .step-header {
                    flex-direction: column;
                    text-align: center;
                    gap: 0.75rem;
                }

                .step-card {
                    padding: 1.5rem;
                }

                .step-title {
                    font-size: 1.125rem;
                }

                .step-description {
                    font-size: 0.75rem;
                }

                .duration-card,
                .nda-status-card {
                    flex-direction: column;
                    text-align: center;
                    gap: 0.5rem;
                }

                .member-header {
                    flex-wrap: wrap;
                    gap: 0.5rem;
                }

                .file-upload-label {
                    flex-direction: column;
                    text-align: center;
                    gap: 0.75rem;
                }

                .form-navigation {
                    padding: 1.5rem;
                }

                .nav-buttons {
                    flex-direction: column;
                    gap: 0.75rem;
                }

                .nav-buttons .btn {
                    width: 100%;
                    min-width: auto;
                }

                /* Table Responsive on Mobile */
                .table-wrapper {
                    font-size: 0.75rem;
                }

                .table-minimal {
                    min-width: 500px;
                }

                .table-minimal th,
                .table-minimal td {
                    padding: 0.375rem 0.5rem;
                }

                .members-container {
                    max-height: 250px;
                }
            }

            @media (max-width: 480px) {
                .main-container {
                    padding: 1rem 0.75rem;
                }

                .header-content {
                    padding: 1rem;
                }

                .page-title {
                    font-size: 1.25rem;
                }

                .progress-indicator {
                    padding: 1rem;
                }

                .step-card {
                    padding: 1rem;
                }

                .step-icon {
                    width: 2rem;
                    height: 2rem;
                    font-size: 1rem;
                }

                .step-title {
                    font-size: 1rem;
                }

                .step-description {
                    font-size: 0.75rem;
                }

                .member-card {
                    padding: 0.75rem;
                }

                .duration-card,
                .nda-status-card {
                    padding: 0.75rem;
                }

                .form-grid {
                    gap: 1rem;
                }

                .table-minimal {
                    min-width: 600px;
                }

                .members-container {
                    max-height: 200px;
                }
            }

            /* Focus and accessibility improvements */
            .btn:focus-visible,
            .field-input:focus-visible,
            .field-textarea:focus-visible,
            .file-input:focus-visible+.file-upload-label {
                outline: 2px solid var(--primary);
                outline-offset: 2px;
            }

            /* Loading states */
            .btn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
                transform: none !important;
            }

            .btn:disabled:hover {
                transform: none !important;
                box-shadow: var(--shadow-sm) !important;
            }

            /* Error states */
            .field-error+.file-upload-label {
                border-color: var(--danger);
                background: var(--danger-bg);
            }

            /* Success states */
            .field-success {
                border-color: var(--success);
                box-shadow: 0 0 0 3px var(--success-bg);
            }

            /* Validation improvements */
            .field-wrapper.has-error .field-icon {
                color: var(--danger);
            }

            .field-wrapper.has-success .field-icon {
                color: var(--success);
            }

            /* Enhanced member cards */
            .member-card[data-member="0"] .member-label::after {
                content: " (Utama)";
                font-size: 0.625rem;
                color: var(--primary);
                font-weight: 500;
            }

            /* Improved file upload states */
            .file-upload-area.has-file .file-upload-label {
                display: none;
            }

            .file-upload-area.has-file .file-upload-info {
                display: flex;
            }

            /* Custom scrollbar for form container and members */
            .form-container,
            .members-container {
                max-height: calc(100vh - 200px);
                overflow-y: auto;
            }

            .form-container::-webkit-scrollbar,
            .members-container::-webkit-scrollbar {
                width: 6px;
            }

            .form-container::-webkit-scrollbar-track,
            .members-container::-webkit-scrollbar-track {
                background: var(--gray-100);
                border-radius: 3px;
            }

            .form-container::-webkit-scrollbar-thumb,
            .members-container::-webkit-scrollbar-thumb {
                background: var(--gray-300);
                border-radius: 3px;
            }

            .form-container::-webkit-scrollbar-thumb:hover,
            .members-container::-webkit-scrollbar-thumb:hover {
                background: var(--gray-400);
            }

            .file-upload-info.file-success {
                border: 1px solid var(--success) !important;
                background: var(--success-bg) !important;
            }

            .file-info .success-icon {
                color: var(--success);
                margin-left: 0.25rem;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let currentStep = 1;
                let memberCount = 1;
                const totalSteps = 4;
                const form = document.getElementById('projectForm');
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const submitBtn = document.getElementById('submitBtn');
                const descriptionTextarea = document.getElementById('description');
                const descriptionCounter = document.getElementById('descriptionCount');
                let savedMembers = {};

                // Initialize
                updateStepDisplay();
                initializeCharacterCounter();
                attachEventListeners();
                restoreFromAutoSave();
                loadSavedMembers();

                // Restore from localStorage
                function restoreFromAutoSave() {
                    const saved = localStorage.getItem('nda-project-draft');
                    if (saved) {
                        try {
                            const data = JSON.parse(saved);
                            Object.entries(data).forEach(([key, value]) => {
                                const field = document.querySelector(`[name="${key}"]`) || document
                                    .getElementById(key);
                                if (field && field.type !== 'file') {
                                    field.value = value || '';
                                    if (key === 'start_date' || key === 'end_date') calculateDuration();
                                }
                            });
                            if (descriptionTextarea && descriptionCounter) descriptionCounter.textContent =
                                descriptionTextarea.value.length;
                        } catch (e) {
                            console.warn('Failed to restore auto-save data:', e);
                        }
                    }
                    const membersDraft = localStorage.getItem('nda-members-draft');
                    if (membersDraft) {
                        try {
                            const membersData = JSON.parse(membersDraft);
                            membersData.forEach((member, idx) => {
                                let card = document.querySelector(`[data-member="${idx}"]`);
                                if (!card) {
                                    card = createMemberCard(idx);
                                    document.getElementById('member-container').appendChild(card);
                                    attachMemberEventListeners(card);
                                }
                                card.querySelector('.member-name').value = member.name || '';
                                card.querySelector('input[type="date"]').value = member.signature_date || '';
                                if (member.file_name) {
                                    const uploadInfo = card.querySelector('.file-upload-info');
                                    const fileNameSpan = uploadInfo.querySelector('.file-name');
                                    fileNameSpan.textContent = member.file_name;
                                    uploadInfo.style.display = 'flex';
                                    card.querySelector('.file-upload-label').style.display = 'none';
                                    card.querySelector('.file-upload-area').classList.add('has-file');
                                    card.querySelector('.btn-save-member').textContent = 'Re-Save jika Ganti';
                                }
                            });
                            memberCount = membersData.length;
                            updateRemoveButtons();
                        } catch (e) {
                            console.warn('Failed to restore members draft:', e);
                        }
                    }
                }

                // Auto-save to localStorage
                let autoSaveTimeout, membersSaveTimeout;
                document.addEventListener('input', function(e) {
                    if (e.target.closest('.member-card')) {
                        clearTimeout(membersSaveTimeout);
                        membersSaveTimeout = setTimeout(autoSaveMembers, 500);
                    } else if (e.target.closest('#projectForm') && e.target.type !== 'file') {
                        clearTimeout(autoSaveTimeout);
                        autoSaveTimeout = setTimeout(autoSave, 2000);
                    }
                });

                function autoSaveMembers() {
                    const memberCards = document.querySelectorAll('.member-card');
                    const membersData = [];
                    memberCards.forEach((card, idx) => {
                        const name = card.querySelector('.member-name').value;
                        const signatureDate = card.querySelector('input[type="date"]').value;
                        const fileName = card.querySelector('.file-name') ? card.querySelector('.file-name')
                            .textContent : null;
                        membersData[idx] = {
                            name,
                            signature_date: signatureDate,
                            file_name: fileName
                        };
                    });
                    localStorage.setItem('nda-members-draft', JSON.stringify(membersData));
                }

                function autoSave() {
                    const formData = new FormData(form);
                    const data = {};
                    for (let [key, value] of formData.entries()) {
                        if (key !== 'files[]') data[key] = value;
                    }
                    localStorage.setItem('nda-project-draft', JSON.stringify(data));
                }

                // Character counter
                function initializeCharacterCounter() {
                    if (descriptionTextarea && descriptionCounter) {
                        const updateCount = () => {
                            const count = descriptionTextarea.value.length;
                            descriptionCounter.textContent = count;
                            if (count > 900) descriptionCounter.style.color = 'var(--danger)';
                            else if (count > 700) descriptionCounter.style.color = 'var(--warning)';
                            else descriptionCounter.style.color = 'var(--gray-500)';
                        };
                        descriptionTextarea.addEventListener('input', updateCount);
                        updateCount();
                    }
                }

                // Event listeners
                function attachEventListeners() {
                    prevBtn.addEventListener('click', () => changeStep(-1));
                    nextBtn.addEventListener('click', () => changeStep(1));
                    document.getElementById('start_date').addEventListener('change', calculateDuration);
                    document.getElementById('end_date').addEventListener('change', calculateDuration);
                    document.getElementById('add-member').addEventListener('click', addMember);
                    form.addEventListener('submit', function(e) {
                        e.preventDefault(); // Prevent default form submission
                        handleFormSubmit(e);
                    });
                    attachFieldValidation();
                }

                // Load saved members from server
                function loadSavedMembers() {
                    fetch('{{ route('pegawai.nda.temp-member') }}', {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                savedMembers = {};
                                data.members.forEach(member => {
                                    savedMembers[member.index] = member;
                                });
                                updateTable();
                                Object.keys(savedMembers).forEach(idx => {
                                    const card = document.querySelector(`[data-member="${idx}"]`);
                                    if (card) {
                                        card.setAttribute('data-saved', 'true');
                                        card.querySelector('.member-name').value = savedMembers[idx].name;
                                        card.querySelector('input[type="date"]').value = savedMembers[idx]
                                            .signature_date;
                                        const uploadInfo = card.querySelector('.file-upload-info');
                                        const fileNameSpan = uploadInfo.querySelector('.file-name');
                                        if (savedMembers[idx].file_name) {
                                            fileNameSpan.textContent = savedMembers[idx].file_name;
                                            uploadInfo.style.display = 'flex';
                                            card.querySelector('.file-upload-label').style.display = 'none';
                                            card.querySelector('.file-upload-area').classList.add(
                                                'has-file');
                                            card.querySelector('.btn-save-member').textContent =
                                                'Re-Save jika Ganti';
                                        }
                                    }
                                });
                            }
                        })
                        .catch(error => console.warn('Gagal load saved members:', error));
                }

                // Step navigation
                function changeStep(direction) {
                    const newStep = currentStep + direction;
                    if (newStep < 1 || newStep > totalSteps) return;
                    if (direction === 1 && !validateCurrentStep()) {
                        showValidationError();
                        return;
                    }
                    currentStep = newStep;
                    updateStepDisplay();
                    document.querySelector('.form-container').scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }

                // Update step display
                function updateStepDisplay() {
                    document.querySelectorAll('.progress-step').forEach((step, index) => {
                        const stepNum = index + 1;
                        step.classList.remove('active', 'completed');
                        if (stepNum < currentStep) step.classList.add('completed');
                        else if (stepNum === currentStep) step.classList.add('active');
                    });
                    document.querySelectorAll('.progress-line').forEach((line, index) => {
                        line.classList.toggle('completed', index < currentStep - 1);
                    });
                    document.querySelectorAll('.form-step').forEach((step, index) => {
                        step.classList.toggle('active', index + 1 === currentStep);
                    });
                    prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-flex';
                    nextBtn.style.display = currentStep === totalSteps ? 'none' : 'inline-flex';
                    submitBtn.style.display = currentStep === totalSteps ? 'inline-flex' : 'none';
                    document.querySelectorAll('.progress-step.completed .progress-step-circle i').forEach(icon => {
                        icon.className = 'bi bi-check';
                    });
                }

                // Validate current step
                function validateCurrentStep() {
                    const currentStepEl = document.querySelector(`.form-step[data-step="${currentStep}"]`);
                    const requiredFields = currentStepEl.querySelectorAll('[required]');
                    let isValid = true;
                    requiredFields.forEach(field => {
                        if (!validateField(field)) {
                            isValid = false;
                        }
                    });
                    if (currentStep === 3) isValid = validateMembersStep() && isValid;
                    if (currentStep === 4 && Object.keys(savedMembers).length === 0) {
                        isValid = false;
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Kosong',
                            text: 'Belum ada anggota yang disimpan. Silakan kembali ke Step 3.'
                        });
                    }
                    return isValid;
                }

                // Validate individual field
                function validateField(field) {
                    let value = field.value;
                    if (field.type === 'file') {
                        value = field.files.length > 0;
                    } else {
                        value = field.value.trim();
                    }
                    const isValid = !!value;
                    field.classList.toggle('field-error', !isValid);
                    field.classList.toggle('field-success', isValid && field.value.trim());
                    return isValid;
                }

                // Validate members step
                function validateMembersStep() {
                    const memberCards = document.querySelectorAll('.member-card');
                    let isValid = true;
                    memberCards.forEach(card => {
                        const nameInput = card.querySelector('.member-name');
                        const dateInput = card.querySelector('input[type="date"]');
                        const fileInput = card.querySelector('.file-input');
                        if (!validateField(nameInput) || !validateField(dateInput)) {
                            isValid = false;
                        }
                        if (card.getAttribute('data-saved') !== 'true') {
                            if (!validateField(fileInput)) {
                                isValid = false;
                            }
                        }
                    });
                    return isValid && memberCards.length > 0;
                }

                // Show validation error
                function showValidationError() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Form Belum Lengkap',
                        text: 'Harap lengkapi semua field yang wajib diisi sebelum melanjutkan.',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#4f46e5'
                    });
                }

                // Duration calculation
                function calculateDuration() {
                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;
                    const durationText = document.getElementById('duration-text');
                    const durationIcon = document.querySelector('.duration-icon i');
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
                                confirmButtonColor: '#4f46e5'
                            });
                            document.getElementById('end_date').value = '';
                            durationText.textContent = 'Akan dihitung otomatis';
                            durationIcon.className = 'bi bi-clock';
                            return;
                        }
                        const months = Math.floor(diffDays / 30);
                        const weeks = Math.floor((diffDays % 30) / 7);
                        const days = diffDays % 7;
                        let durationParts = [];
                        if (months > 0) durationParts.push(`${months} bulan`);
                        if (weeks > 0) durationParts.push(`${weeks} minggu`);
                        if (days > 0 || durationParts.length === 0) durationParts.push(`${days} hari`);
                        const durationString = durationParts.join(', ');
                        durationText.textContent = `${durationString} (${diffDays} hari total)`;
                        durationIcon.className = 'bi bi-calendar-check';
                        durationText.classList.add('slide-in');
                        setTimeout(() => durationText.classList.remove('slide-in'), 300);
                    } else {
                        durationText.textContent = 'Akan dihitung otomatis';
                        durationIcon.className = 'bi bi-clock';
                    }
                }

                // Add member
                function addMember() {
                    const container = document.getElementById('member-container');
                    const memberCard = createMemberCard(memberCount);
                    container.appendChild(memberCard);
                    memberCount++;
                    updateRemoveButtons();
                    attachMemberEventListeners(memberCard);
                    memberCard.classList.add('slide-in');
                    setTimeout(() => memberCard.classList.remove('slide-in'), 300);
                    memberCard.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                // Create member card
                function createMemberCard(index) {
                    const div = document.createElement('div');
                    div.className = 'member-card';
                    div.setAttribute('data-member', index);
                    div.innerHTML = `
                <div class="member-header">
                    <div class="member-avatar"><i class="bi bi-person"></i></div>
                    <div class="member-info"><div class="member-label">Anggota ke-${index + 1}</div></div>
                    <button type="button" class="btn-remove-member"><i class="bi bi-x"></i></button>
                </div>
                <div class="member-body">
                    <div class="member-fields">
                        <div class="member-field">
                            <label class="field-label required">Nama Lengkap</label>
                            <div class="field-wrapper">
                                <input type="text" name="members[${index}][name]" class="field-input member-name" placeholder="Masukkan nama lengkap anggota tim" maxlength="100" required>
                            </div>
                        </div>
                        <div class="member-field">
                            <label class="field-label required">Tanggal Tanda Tangan NDA</label>
                            <div class="field-wrapper">
                                <div class="field-icon"><i class="bi bi-pen"></i></div>
                                <input type="date" name="members[${index}][signature_date]" class="field-input" required>
                            </div>
                            <div class="field-hint">Tanggal ketika anggota ini menandatangani NDA</div>
                        </div>
                        <div class="member-field">
                            <label class="field-label required">Berkas NDA (PDF)</label>
                            <div class="file-upload-area">
                                <input type="file" name="files[${index}]" class="file-input" id="file-${index}" accept="application/pdf" required>
                                <label for="file-${index}" class="file-upload-label">
                                    <div class="file-upload-icon"><i class="bi bi-cloud-upload"></i></div>
                                    <div class="file-upload-text"><div class="file-upload-title">Pilih atau Seret File PDF</div><div class="file-upload-subtitle">Maksimal 10MB</div></div>
                                </label>
                                <div class="file-upload-info" style="display: none;">
                                    <div class="file-info"><i class="bi bi-file-earmark-pdf"></i><span class="file-name"></span><i class="bi bi-check-circle success-icon" title="Berkas berhasil dimasukkan"></i></div>
                                    <button type="button" class="btn-remove-file"><i class="bi bi-x"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="member-actions">
                        <button type="button" class="btn btn-success btn-save-member"><i class="bi bi-save me-2"></i>Save Anggota Ini</button>
                    </div>
                </div>
            `;
                    return div;
                }

                // Attach event listeners to member card
                function attachMemberEventListeners(memberCard) {
                    const removeBtn = memberCard.querySelector('.btn-remove-member');
                    const fileInput = memberCard.querySelector('.file-input');
                    const nameInput = memberCard.querySelector('.member-name');
                    const saveBtn = memberCard.querySelector('.btn-save-member');
                    const removeFileBtn = memberCard.querySelector('.btn-remove-file');
                    const dateInput = memberCard.querySelector('input[type="date"]');
                    if (saveBtn) saveBtn.addEventListener('click', () => saveMember(memberCard));
                    if (removeBtn) removeBtn.addEventListener('click', () => removeMember(memberCard));
                    if (fileInput) {
                        fileInput.addEventListener('change', (e) => handleFileUpload(e.target));
                        fileInput.addEventListener('change', () => validateField(fileInput));
                    }
                    if (removeFileBtn) removeFileBtn.addEventListener('click', () => removeFile(fileInput));
                    if (nameInput) {
                        nameInput.addEventListener('blur', () => validateField(nameInput));
                        nameInput.addEventListener('input', () => {
                            if (nameInput.classList.contains('field-error') && nameInput.value.trim()) {
                                nameInput.classList.remove('field-error');
                                nameInput.classList.add('field-success');
                            }
                        });
                    }
                    if (dateInput) dateInput.addEventListener('change', () => validateField(dateInput));
                }

                // Remove member
                function removeMember(memberCard) {
                    const memberNumber = memberCard.querySelector('.member-label').textContent;
                    Swal.fire({
                        title: 'Hapus Anggota Tim',
                        text: `Apakah Anda yakin ingin menghapus ${memberNumber} beserta berkas NDA-nya?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const index = memberCard.dataset.member;
                            memberCard.style.opacity = '0';
                            memberCard.style.transform = 'translateX(-20px)';
                            setTimeout(() => {
                                memberCard.remove();
                                updateRemoveButtons();
                                reindexMembers();
                                fetch(`{{ route('pegawai.nda.temp-member.delete', ':index') }}`
                                        .replace(':index', index), {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json'
                                            }
                                        })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            delete savedMembers[index];
                                            updateTable();
                                            autoSaveMembers();
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Dihapus',
                                                text: 'Anggota dihapus.'
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Gagal',
                                                text: data.message
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Delete error:', error);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Terjadi kesalahan.'
                                        });
                                    });
                            }, 300);
                        }
                    });
                }

                // Update remove buttons visibility
                function updateRemoveButtons() {
                    const memberCards = document.querySelectorAll('.member-card');
                    memberCards.forEach((card, index) => {
                        const removeBtn = card.querySelector('.btn-remove-member');
                        removeBtn.style.display = memberCards.length > 1 ? 'flex' : 'none';
                    });
                }

                // Reindex members
                function reindexMembers() {
                    const memberCards = document.querySelectorAll('.member-card');
                    memberCards.forEach((card, index) => {
                        card.setAttribute('data-member', index);
                        card.querySelector('.member-label').textContent = `Anggota ke-${index + 1}`;
                        const nameInput = card.querySelector('.member-name');
                        const fileInput = card.querySelector('.file-input');
                        nameInput.name = `members[${index}][name]`;
                        fileInput.name = `files[${index}]`;
                        fileInput.id = `file-${index}`;
                        card.querySelector('.file-upload-label').setAttribute('for', `file-${index}`);
                    });
                    memberCount = memberCards.length;
                }

                // Handle file upload
                function handleFileUpload(fileInput) {
                    const file = fileInput.files[0];
                    const uploadArea = fileInput.closest('.file-upload-area');
                    const uploadLabel = uploadArea.querySelector('.file-upload-label');
                    const uploadInfo = uploadArea.querySelector('.file-upload-info');
                    const fileNameSpan = uploadInfo.querySelector('.file-name');
                    if (!file) return;
                    if (file.type !== 'application/pdf') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format File Tidak Valid',
                            text: 'Hanya file PDF yang diperbolehkan.',
                            confirmButtonText: 'Mengerti',
                            confirmButtonColor: '#4f46e5'
                        });
                        fileInput.value = '';
                        return;
                    }
                    const maxSize = 10 * 1024 * 1024; // 10MB
                    if (file.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 10MB.',
                            confirmButtonText: 'Mengerti',
                            confirmButtonColor: '#4f46e5'
                        });
                        fileInput.value = '';
                        return;
                    }
                    fileNameSpan.textContent = file.name;
                    uploadLabel.style.display = 'none';
                    uploadInfo.style.display = 'flex';
                    uploadArea.classList.add('has-file');
                    uploadInfo.classList.add('file-success');
                    fileInput.classList.remove('field-error');
                    fileInput.classList.add('field-success');
                    uploadInfo.classList.add('fade-in');
                    setTimeout(() => uploadInfo.classList.remove('fade-in'), 300);
                    autoSaveMembers();
                }

                // Remove file
                function removeFile(fileInput) {
                    const uploadArea = fileInput.closest('.file-upload-area');
                    const uploadLabel = uploadArea.querySelector('.file-upload-label');
                    const uploadInfo = uploadArea.querySelector('.file-upload-info');
                    fileInput.value = '';
                    uploadLabel.style.display = 'flex';
                    uploadInfo.style.display = 'none';
                    uploadArea.classList.remove('has-file');
                    uploadInfo.classList.remove('file-success');
                    fileInput.classList.remove('field-success');
                    autoSaveMembers();
                }

                // Attach field validation
                function attachFieldValidation() {
                    const fields = document.querySelectorAll('[required]');
                    fields.forEach(field => {
                        field.addEventListener('blur', () => validateField(field));
                        field.addEventListener('input', () => {
                            if (field.classList.contains('field-error') && field.value.trim()) {
                                field.classList.remove('field-error');
                                field.classList.add('field-success');
                            }
                        });
                    });
                }

                // Save member
                function saveMember(memberCard) {
                    const index = memberCard.dataset.member;
                    const name = memberCard.querySelector('.member-name').value;
                    const signatureDate = memberCard.querySelector(`input[name="members[${index}][signature_date]"]`)
                        .value;
                    const fileInput = memberCard.querySelector('.file-input');
                    if (!name || !signatureDate) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Belum Lengkap',
                            text: 'Isi nama dan tanggal sebelum save.'
                        });
                        return;
                    }
                    const formData = new FormData();
                    formData.append('member_index', index);
                    formData.append('name', name);
                    formData.append('signature_date', signatureDate);
                    if (fileInput.files[0]) formData.append('file', fileInput.files[0]);
                    formData.append('_token', '{{ csrf_token() }}');
                    fetch('{{ route('pegawai.nda.temp-member') }}', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: `Anggota ke-${parseInt(index) + 1} sudah tersimpan ke dalam tabel daftar.`
                                });
                                savedMembers[index] = data.data;
                                const saveBtn = memberCard.querySelector('.btn-save-member');
                                saveBtn.textContent = 'Re-Save jika Ganti';
                                memberCard.setAttribute('data-saved', 'true');
                                updateTable();
                                autoSaveMembers();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Save error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan koneksi.'
                            });
                        });
                }

                // Update table - PERBAIKAN UTAMA
                function updateTable() {
                    const savedTableBody = document.getElementById('saved-table-body');
                    const confirmationTableBody = document.getElementById('confirmation-table-body');
                    savedTableBody.innerHTML = '';
                    confirmationTableBody.innerHTML = '';
                    Object.values(savedMembers).forEach((member, idx) => {
                        const row = `
                    <tr>
                        <td>${idx + 1}</td>
                        <td>${member.name}</td>
                        <td>${member.signature_date}</td>
                        <td>${member.file_name}</td>
                    </tr>`;
                        savedTableBody.innerHTML += row;
                        const actionRow = `
                    <tr>
                        <td>${idx + 1}</td>
                        <td>${member.name}</td>
                        <td>${member.signature_date}</td>
                        <td>${member.file_name}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm btn-edit-member" data-index="${member.index}">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete-member" data-index="${member.index}">Hapus</button>
                        </td>
                    </tr>`;
                        confirmationTableBody.innerHTML += actionRow;
                    });

                    // Attach event listeners to buttons in confirmation table
                    document.querySelectorAll('.btn-edit-member').forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault(); // Prevent form submission
                            e.stopPropagation(); // Stop event bubbling
                            const index = this.getAttribute('data-index');
                            editMember(index);
                        });
                    });
                    document.querySelectorAll('.btn-delete-member').forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault(); // Prevent form submission
                            e.stopPropagation(); // Stop event bubbling
                            const index = this.getAttribute('data-index');
                            deleteMemberByIndex(index);
                        });
                    });
                }

                // Edit member
                function editMember(index) {
                    currentStep = 3;
                    updateStepDisplay();
                    const memberCard = document.querySelector(`.member-card[data-member="${index}"]`);
                    if (memberCard) {
                        memberCard.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        memberCard.style.backgroundColor = 'var(--primary-bg)';
                        setTimeout(() => {
                            memberCard.style.backgroundColor = '';
                        }, 2000);
                    } else {
                        addMember();
                        const newCard = document.querySelector(`.member-card[data-member="${index}"]`);
                        if (newCard && savedMembers[index]) {
                            newCard.querySelector('.member-name').value = savedMembers[index].name;
                            newCard.querySelector('input[type="date"]').value = savedMembers[index].signature_date;
                            const uploadInfo = newCard.querySelector('.file-upload-info');
                            const fileNameSpan = uploadInfo.querySelector('.file-name');
                            fileNameSpan.textContent = savedMembers[index].file_name;
                            uploadInfo.style.display = 'flex';
                            newCard.querySelector('.file-upload-label').style.display = 'none';
                            newCard.querySelector('.file-upload-area').classList.add('has-file');
                            newCard.querySelector('.btn-save-member').textContent = 'Re-Save jika Ganti';
                            newCard.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    }
                    Swal.fire({
                        icon: 'info',
                        title: 'Edit Anggota',
                        text: 'Anda sekarang di Step 3. Edit data lalu klik "Re-Save jika Ganti" untuk update.',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#4f46e5'
                    });
                }

                // Delete member by index
                function deleteMemberByIndex(index) {
                    Swal.fire({
                        title: 'Hapus Anggota',
                        text: `Apakah Anda yakin ingin menghapus anggota ke-${parseInt(index) + 1}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`{{ route('pegawai.nda.temp-member.delete', ':index') }}`.replace(':index',
                                    index), {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        delete savedMembers[index];
                                        const card = document.querySelector(`[data-member="${index}"]`);
                                        if (card) {
                                            card.remove();
                                            reindexMembers();
                                        }
                                        updateTable();
                                        autoSaveMembers();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Dihapus',
                                            text: 'Anggota dihapus.'
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: data.message
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Delete error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Terjadi kesalahan.'
                                    });
                                });
                        }
                    });
                }

                // Handle form submission
                function handleFormSubmit(e) {
                    e.preventDefault();
                    if (Object.keys(savedMembers).length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Anggota Kosong',
                            text: 'Harap save minimal 1 anggota di Step 3 sebelum submit.',
                            confirmButtonText: 'Mengerti',
                            confirmButtonColor: '#4f46e5'
                        });
                        return;
                    }
                    if (!validateAllSteps()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Form Tidak Valid',
                            text: 'Harap periksa kembali semua data yang dimasukkan.',
                            confirmButtonText: 'Mengerti',
                            confirmButtonColor: '#4f46e5'
                        });
                        return;
                    }
                    const projectName = document.getElementById('project_name').value;
                    const memberCards = document.querySelectorAll('.member-card');
                    Swal.fire({
                        title: 'Konfirmasi Pembuatan Proyek',
                        html: `<div style="text-align: left; margin: 1rem 0;"><p><strong>Nama Proyek:</strong> ${projectName}</p><p><strong>Jumlah Anggota:</strong> ${memberCards.length} orang</p><p style="margin-top: 1rem; color: #6b7280; font-size: 0.9rem;">Pastikan semua data sudah benar sebelum membuat proyek.</p></div>`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Buat Proyek',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            submitForm();
                            localStorage.removeItem('nda-members-draft');
                            localStorage.removeItem('nda-project-draft');
                        }
                    });
                }

                // Submit form
                function submitForm() {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise loading-spin me-2"></i>Membuat Proyek...';
                    Swal.fire({
                        title: 'Membuat Proyek',
                        html: `<div style="padding: 2rem 0;"><div class="d-flex justify-content-center mb-3"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div><p>Mohon tunggu, sedang memproses data proyek dan mengunggah berkas...</p></div>`,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false
                    });
                    setTimeout(() => form.submit(), 1000);
                }

                // Validate all steps
                function validateAllSteps() {
                    let isValid = true;
                    for (let step = 1; step <= totalSteps; step++) {
                        const stepEl = document.querySelector(`.form-step[data-step="${step}"]`);
                        const requiredFields = stepEl.querySelectorAll('[required]');
                        requiredFields.forEach(field => {
                            if (!validateField(field)) isValid = false;
                        });
                        if (step === 3 && !validateMembersStep()) isValid = false;
                    }
                    return isValid;
                }

                // Initialize first member
                const firstMemberCard = document.querySelector('.member-card[data-member="0"]');
                if (firstMemberCard) attachMemberEventListeners(firstMemberCard);
                updateRemoveButtons();

                // Keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    if (e.altKey) {
                        if (e.key === 'ArrowLeft' && currentStep > 1) {
                            e.preventDefault();
                            changeStep(-1);
                        } else if (e.key === 'ArrowRight' && currentStep < totalSteps) {
                            e.preventDefault();
                            changeStep(1);
                        }
                    }
                    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter' && currentStep === totalSteps) {
                        e.preventDefault();
                        handleFormSubmit(e);
                    }
                });

                // Initialize tooltips
                function initializeTooltips() {
                    document.querySelectorAll('.progress-step').forEach((step, index) => {
                        const stepNames = ['Informasi Dasar', 'Timeline Proyek', 'Tim & Berkas'];
                        step.title = stepNames[index];
                    });
                    document.getElementById('add-member').title =
                        'Tambah anggota tim baru (minimal 1 anggota diperlukan)';
                }
                initializeTooltips();

                // Custom SweetAlert2 styles
                const swalStyles = document.createElement('style');
                swalStyles.innerHTML = `
            .swal-modern-popup { border-radius: 16px !important; padding: 0 !important; font-family: 'Inter', sans-serif !important; }
            .swal-modern-title { font-size: 1.25rem !important; font-weight: 700 !important; color: #1f2937 !important; margin-bottom: 0.5rem !important; }
            .swal-modern-content { font-size: 0.9rem !important; line-height: 1.5 !important; color: #4b5563 !important; }
            .swal-modern-html { margin: 0 !important; padding: 0 !important; }
            .swal2-confirm { border-radius: 8px !important; padding: 0.75rem 1.5rem !important; font-weight: 600 !important; font-size: 0.875rem !important; }
            .swal2-cancel { border-radius: 8px !important; padding: 0.75rem 1.5rem !important; font-weight: 600 !important; font-size: 0.875rem !important; }
            .swal2-actions { gap: 0.75rem !important; margin-top: 1.5rem !important; }
            .spinner-border { width: 2rem; height: 2rem; border: 0.25em solid currentColor; border-right-color: transparent; border-radius: 50%; animation: spinner-border-spin 0.75s linear infinite; }
            @keyframes spinner-border-spin { to { transform: rotate(360deg); } }
            .text-primary { color: #4f46e5 !important; }
            .sr-only { position: absolute !important; width: 1px !important; height: 1px !important; padding: 0 !important; margin: -1px !important; overflow: hidden !important; clip: rect(0, 0, 0, 0) !important; border: 0 !important; }
        `;
                document.head.appendChild(swalStyles);
            });
        </script>
    @endpush
@endsection
