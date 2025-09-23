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
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div class="progress-step-label">Informasi Dasar</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step" data-step="2">
                    <div class="progress-step-circle">
                        <i class="bi bi-calendar-range"></i>
                    </div>
                    <div class="progress-step-label">Timeline Proyek</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step" data-step="3">
                    <div class="progress-step-circle">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="progress-step-label">Tim & Berkas</div>
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
                                <i class="bi bi-info-circle"></i>
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
                                <i class="bi bi-calendar-range"></i>
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
                                <i class="bi bi-people"></i>
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
                                    </div>
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

            /* Progress Section */
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
                width: 3rem;
                height: 3rem;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
                background: var(--gray-200);
                color: var(--gray-500);
                margin-bottom: 0.75rem;
                transition: var(--transition);
                position: relative;
                z-index: 2;
            }

            .progress-step.active .progress-step-circle,
            .progress-step.completed .progress-step-circle {
                background: var(--primary);
                color: white;
                transform: scale(1.1);
                box-shadow: 0 0 0 4px var(--primary-bg);
            }

            .progress-step.completed .progress-step-circle {
                background: var(--success);
            }

            .progress-step-label {
                font-size: 0.875rem;
                color: var(--gray-600);
                font-weight: 500;
                transition: var(--transition);
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
                margin: 0 1rem;
                margin-top: -1.5rem;
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

            /* Step Cards */
            .step-card {
                padding: 2.5rem;
            }

            .step-header {
                display: flex;
                align-items: flex-start;
                gap: 1.5rem;
                margin-bottom: 2.5rem;
                padding-bottom: 2rem;
                border-bottom: 1px solid var(--gray-200);
            }

            .step-icon {
                width: 3.5rem;
                height: 3.5rem;
                border-radius: var(--radius-lg);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
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
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--gray-900);
                margin: 0 0 0.5rem 0;
            }

            .step-description {
                font-size: 1rem;
                color: var(--gray-600);
                margin: 0;
                line-height: 1.5;
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
                gap: 2rem;
            }

            .form-field {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
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
                padding: 0.875rem 1rem 0.875rem 2.75rem;
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
                padding: 0.875rem 1rem;
                border: 1px solid var(--gray-300);
                border-radius: var(--radius);
                font-size: 0.875rem;
                background: white;
                transition: var(--transition);
                outline: none;
                resize: vertical;
                min-height: 120px;
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
                padding: 1.5rem;
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-top: 1rem;
                transition: var(--transition);
            }

            .duration-card:hover {
                transform: translateY(-1px);
                box-shadow: var(--shadow-md);
            }

            .duration-icon {
                width: 2.5rem;
                height: 2.5rem;
                background: white;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--primary);
                font-size: 1.125rem;
                box-shadow: var(--shadow-sm);
            }

            .duration-info {
                flex: 1;
            }

            .duration-label {
                font-size: 0.875rem;
                font-weight: 600;
                color: var(--gray-700);
                margin-bottom: 0.25rem;
            }

            .duration-value {
                font-size: 1rem;
                color: var(--gray-900);
                font-weight: 500;
            }

            /* NDA Status Card */
            .nda-status-card {
                background: var(--warning-bg);
                border: 1px solid var(--warning);
                border-radius: var(--radius-lg);
                padding: 1.5rem;
                display: flex;
                align-items: center;
                gap: 1rem;
                transition: var(--transition);
            }

            .nda-status-card.status-success {
                background: var(--success-bg);
                border-color: var(--success);
            }

            .status-icon {
                width: 2.5rem;
                height: 2.5rem;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.125rem;
                flex-shrink: 0;
            }

            .status-icon-warning {
                background: var(--warning);
                color: white;
            }

            .status-icon-success {
                background: var(--success);
                color: white;
            }

            .status-content {
                flex: 1;
            }

            .status-label {
                font-size: 0.875rem;
                font-weight: 600;
                color: var(--gray-700);
                margin-bottom: 0.25rem;
            }

            .status-value {
                font-size: 1rem;
                color: var(--gray-900);
                font-weight: 500;
            }

            /* Members Container */
            .members-container {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }

            .member-card {
                background: var(--gray-50);
                border: 1px solid var(--gray-200);
                border-radius: var(--radius-lg);
                padding: 1.5rem;
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
                gap: 1rem;
                margin-bottom: 1.5rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid var(--gray-200);
            }

            .member-avatar {
                width: 2.5rem;
                height: 2.5rem;
                background: var(--primary-bg);
                color: var(--primary);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.125rem;
                flex-shrink: 0;
            }

            .member-info {
                flex: 1;
            }

            .member-label {
                font-size: 0.875rem;
                font-weight: 600;
                color: var(--gray-700);
            }

            .btn-remove-member {
                width: 2rem;
                height: 2rem;
                border: none;
                background: var(--danger-bg);
                color: var(--danger);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: var(--transition);
                font-size: 0.875rem;
            }

            .btn-remove-member:hover {
                background: var(--danger);
                color: white;
                transform: scale(1.1);
            }

            .member-body {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }

            .member-fields {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1.5rem;
            }

            .member-field {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .member-name {
                padding-left: 1rem !important;
            }

            /* File Upload */
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
                gap: 1rem;
                padding: 1.5rem;
                border: 2px dashed var(--gray-300);
                border-radius: var(--radius);
                background: white;
                cursor: pointer;
                transition: var(--transition);
                text-align: left;
            }

            .file-upload-label:hover {
                border-color: var(--primary);
                background: var(--primary-bg);
            }

            .file-upload-icon {
                width: 2.5rem;
                height: 2.5rem;
                background: var(--primary-bg);
                color: var(--primary);
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.125rem;
                flex-shrink: 0;
            }

            .file-upload-text {
                flex: 1;
            }

            .file-upload-title {
                font-size: 0.875rem;
                font-weight: 600;
                color: var(--gray-700);
                margin-bottom: 0.25rem;
            }

            .file-upload-subtitle {
                font-size: 0.75rem;
                color: var(--gray-500);
            }

            .file-upload-info {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1rem;
                background: var(--success-bg);
                border: 1px solid var(--success);
                border-radius: var(--radius);
            }

            .file-info {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: var(--success-dark);
                font-size: 0.875rem;
                font-weight: 500;
            }

            .file-name {
                max-width: 200px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .btn-remove-file {
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

            .btn-remove-file:hover {
                background: var(--danger);
                color: white;
            }

            /* Members Hint */
            .members-hint {
                display: flex;
                align-items: flex-start;
                gap: 0.75rem;
                padding: 1rem;
                background: var(--info-bg);
                border-radius: var(--radius);
                margin-top: 1rem;
            }

            .hint-icon {
                width: 1.25rem;
                height: 1.25rem;
                color: var(--info);
                flex-shrink: 0;
                margin-top: 0.125rem;
            }

            .hint-text {
                font-size: 0.875rem;
                color: var(--info-dark);
                line-height: 1.4;
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

            /* Responsive Design */
            @media (max-width: 1024px) {
                .main-container {
                    padding: 1.5rem 1rem;
                }

                .step-card {
                    padding: 2rem;
                }

                .form-grid {
                    grid-template-columns: 1fr;
                    gap: 1.5rem;
                }

                .member-fields {
                    grid-template-columns: 1fr;
                    gap: 1.5rem;
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
                    font-size: 1.75rem;
                }

                .progress-indicator {
                    flex-direction: column;
                    gap: 1.5rem;
                    padding: 1.5rem;
                }

                .progress-line {
                    width: 2px;
                    height: 1.5rem;
                    margin: 0;
                }

                .step-header {
                    flex-direction: column;
                    text-align: center;
                    gap: 1rem;
                }

                .step-card {
                    padding: 1.5rem;
                }

                .step-title {
                    font-size: 1.25rem;
                }

                .duration-card,
                .nda-status-card {
                    flex-direction: column;
                    text-align: center;
                    gap: 0.75rem;
                }

                .member-header {
                    flex-wrap: wrap;
                    gap: 0.75rem;
                }

                .file-upload-label {
                    flex-direction: column;
                    text-align: center;
                    gap: 1rem;
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
            }

            @media (max-width: 480px) {
                .main-container {
                    padding: 1rem 0.75rem;
                }

                .header-content {
                    padding: 1rem;
                }

                .page-title {
                    font-size: 1.5rem;
                }

                .progress-indicator {
                    padding: 1rem;
                }

                .progress-step-circle {
                    width: 2.5rem;
                    height: 2.5rem;
                    font-size: 1rem;
                }

                .progress-step-label {
                    font-size: 0.75rem;
                }

                .step-card {
                    padding: 1rem;
                }

                .step-icon {
                    width: 3rem;
                    height: 3rem;
                    font-size: 1.25rem;
                }

                .step-title {
                    font-size: 1.125rem;
                }

                .step-description {
                    font-size: 0.875rem;
                }

                .member-card {
                    padding: 1rem;
                }

                .duration-card,
                .nda-status-card {
                    padding: 1rem;
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
                font-size: 0.75rem;
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

            /* Custom scrollbar for form container */
            .form-container {
                max-height: calc(100vh - 200px);
                overflow-y: auto;
            }

            .form-container::-webkit-scrollbar {
                width: 6px;
            }

            .form-container::-webkit-scrollbar-track {
                background: var(--gray-100);
                border-radius: 3px;
            }

            .form-container::-webkit-scrollbar-thumb {
                background: var(--gray-300);
                border-radius: 3px;
            }

            .form-container::-webkit-scrollbar-thumb:hover {
                background: var(--gray-400);
            }

            .file-upload-info.file-success {
                border: 1px solid var(--success) !important;
                background: var(--success-bg) !important;
            }

            .file-info .success-icon {
                color: var(--success);
                margin-left: 0.5rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let currentStep = 1;
                let memberCount = 1;
                const totalSteps = 3;
                // Elements
                const form = document.getElementById('projectForm');
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const submitBtn = document.getElementById('submitBtn');
                const descriptionTextarea = document.getElementById('description');
                const descriptionCounter = document.getElementById('descriptionCount');
                // Initialize
                updateStepDisplay();
                initializeCharacterCounter();
                attachEventListeners();
                // Character counter for description
                function initializeCharacterCounter() {
                    if (descriptionTextarea && descriptionCounter) {
                        const updateCount = () => {
                            const count = descriptionTextarea.value.length;
                            descriptionCounter.textContent = count;
                            // Color coding for character count
                            if (count > 900) {
                                descriptionCounter.style.color = 'var(--danger)';
                            } else if (count > 700) {
                                descriptionCounter.style.color = 'var(--warning)';
                            } else {
                                descriptionCounter.style.color = 'var(--gray-500)';
                            }
                        };
                        descriptionTextarea.addEventListener('input', updateCount);
                        updateCount(); // Initial count
                    }
                }
                // Attach all event listeners
                function attachEventListeners() {
                    // Navigation buttons
                    prevBtn.addEventListener('click', () => changeStep(-1));
                    nextBtn.addEventListener('click', () => changeStep(1));
                    // Form fields
                    document.getElementById('start_date').addEventListener('change', calculateDuration);
                    document.getElementById('end_date').addEventListener('change', calculateDuration);
                    // Add member button
                    document.getElementById('add-member').addEventListener('click', addMember);
                    // Form submission
                    form.addEventListener('submit', handleFormSubmit);
                    // Real-time validation
                    attachFieldValidation();
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
                    // Smooth scroll to top
                    document.querySelector('.form-container').scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
                // Update step display
                function updateStepDisplay() {
                    // Update progress indicator
                    document.querySelectorAll('.progress-step').forEach((step, index) => {
                        const stepNum = index + 1;
                        step.classList.remove('active', 'completed');
                        if (stepNum < currentStep) {
                            step.classList.add('completed');
                        } else if (stepNum === currentStep) {
                            step.classList.add('active');
                        }
                    });
                    // Update progress lines
                    document.querySelectorAll('.progress-line').forEach((line, index) => {
                        line.classList.toggle('completed', index < currentStep - 1);
                    });
                    // Update form steps
                    document.querySelectorAll('.form-step').forEach((step, index) => {
                        step.classList.toggle('active', index + 1 === currentStep);
                    });
                    // Update navigation buttons
                    prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-flex';
                    nextBtn.style.display = currentStep === totalSteps ? 'none' : 'inline-flex';
                    submitBtn.style.display = currentStep === totalSteps ? 'inline-flex' : 'none';
                    // Update progress step icons for completed steps
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
                    // Special validation for step 3 (members)
                    if (currentStep === 3) {
                        isValid = validateMembersStep() && isValid;
                    }
                    return isValid;
                }
                // Validate individual field
                function validateField(field) {
                    const value = field.type === 'file' ? field.files.length > 0 : field.value.trim();
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
                        const fileInput = card.querySelector('.file-input');
                        if (!validateField(nameInput) || !validateField(fileInput)) {
                            isValid = false;
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
                        confirmButtonColor: '#4f46e5',
                        customClass: {
                            popup: 'swal-modern-popup',
                            title: 'swal-modern-title',
                            content: 'swal-modern-content'
                        }
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
                        // Calculate duration breakdown
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
                        // Add animation
                        durationText.classList.add('slide-in');
                        setTimeout(() => durationText.classList.remove('slide-in'), 300);
                    } else {
                        durationText.textContent = 'Akan dihitung otomatis';
                        durationIcon.className = 'bi bi-clock';
                    }
                }
                // Add member functionality
                function addMember() {
                    const container = document.getElementById('member-container');
                    const memberCard = createMemberCard(memberCount);
                    container.appendChild(memberCard);
                    memberCount++;
                    updateRemoveButtons();
                    attachMemberEventListeners(memberCard);
                    // Animate new member card
                    memberCard.classList.add('slide-in');
                    setTimeout(() => memberCard.classList.remove('slide-in'), 300);
                    // Scroll to new member
                    memberCard.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
                // Create member card HTML
                function createMemberCard(index) {
                    const div = document.createElement('div');
                    div.className = 'member-card';
                    div.setAttribute('data-member', index);
                    div.innerHTML = `
                <div class="member-header">
                    <div class="member-avatar">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="member-info">
                        <div class="member-label">Anggota ke-${index + 1}</div>
                    </div>
                    <button type="button" class="btn-remove-member">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="member-body">
                    <div class="member-fields">
                        <div class="member-field">
                            <label class="field-label required">Nama Lengkap</label>
                            <div class="field-wrapper">
                                <input type="text"
                                    name="members[${index}][name]"
                                    class="field-input member-name"
                                    placeholder="Masukkan nama lengkap anggota tim"
                                    maxlength="100"
                                    required>
                            </div>
                        </div>
                        <div class="member-field">
                            <label class="field-label required">Tanggal Tanda Tangan NDA</label>
                            <div class="field-wrapper">
                                <div class="field-icon">
                                    <i class="bi bi-pen"></i>
                                </div>
                                <input type="date"
                                    name="members[${index}][signature_date]"
                                    class="field-input"
                                    required>
                            </div>
                        </div>
                        <div class="member-field">
                            <label class="field-label required">Berkas NDA (PDF)</label>
                            <div class="file-upload-area">
                                <input type="file"
                                    name="files[${index}]"
                                    class="file-input"
                                    id="file-${index}"
                                    accept="application/pdf"
                                    required>
                                <label for="file-${index}" class="file-upload-label">
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
                                        <i class="bi bi-check-circle success-icon" title="Berkas berhasil dimasukkan"></i> <!-- Tambahan ikon success -->
                                    </div>
                                    <button type="button" class="btn-remove-file">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
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
                    // Remove member button
                    removeBtn.addEventListener('click', () => removeMember(memberCard));
                    // File input validation
                    fileInput.addEventListener('change', (e) => handleFileUpload(e.target));
                    // File remove button
                    const removeFileBtn = memberCard.querySelector('.btn-remove-file');
                    removeFileBtn.addEventListener('click', () => removeFile(fileInput));
                    // Real-time validation
                    nameInput.addEventListener('blur', () => validateField(nameInput));
                    nameInput.addEventListener('input', () => {
                        if (nameInput.classList.contains('field-error') && nameInput.value.trim()) {
                            nameInput.classList.remove('field-error');
                            nameInput.classList.add('field-success');
                        }
                    });
                    fileInput.addEventListener('change', () => validateField(fileInput));
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
                        reverseButtons: true,
                        customClass: {
                            popup: 'swal-modern-popup',
                            title: 'swal-modern-title',
                            content: 'swal-modern-content'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Add fade out animation
                            memberCard.style.opacity = '0';
                            memberCard.style.transform = 'translateX(-20px)';
                            setTimeout(() => {
                                memberCard.remove();
                                updateRemoveButtons();
                                reindexMembers();
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
                // Reindex members after removal
                function reindexMembers() {
                    const memberCards = document.querySelectorAll('.member-card');
                    memberCards.forEach((card, index) => {
                        card.setAttribute('data-member', index);
                        card.querySelector('.member-label').textContent = `Anggota ke-${index + 1}`;
                        // Update form field names
                        const nameInput = card.querySelector('.member-name');
                        const fileInput = card.querySelector('.file-input');
                        nameInput.name = `members[${index}][name]`;
                        fileInput.name = `files[${index}]`;
                        fileInput.id = `file-${index}`;
                        const fileLabel = card.querySelector('.file-upload-label');
                        fileLabel.setAttribute('for', `file-${index}`);
                    });
                    memberCount = memberCards.length;
                }
                // Handle file upload
                function handleFileUpload(fileInput) {
                    const file = fileInput.files[0];
                    const uploadArea = fileInput.closest('.file-upload-area');
                    const uploadLabel = uploadArea.querySelector('.file-upload-label');
                    const uploadInfo = uploadArea.querySelector('.file-upload-info');
                    const fileName = uploadInfo.querySelector('.file-name');
                    if (!file) return;
                    // Validate file type
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
                    // Show file info
                    fileName.textContent = file.name;
                    uploadLabel.style.display = 'none';
                    uploadInfo.style.display = 'flex';
                    uploadArea.classList.add('has-file');
                    // Tambahkan class success untuk highlight
                    uploadInfo.classList.add('file-success');
                    // Remove error state
                    fileInput.classList.remove('field-error');
                    fileInput.classList.add('field-success');
                    // Animation
                    uploadInfo.classList.add('fade-in');
                    setTimeout(() => uploadInfo.classList.remove('fade-in'), 300);
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
                    uploadInfo.classList.remove('file-success'); // Hapus class success
                    fileInput.classList.remove('field-success');
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
                // Handle form submission
                function handleFormSubmit(e) {
                    e.preventDefault();
                    // Final validation
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
                    // Show confirmation
                    const projectName = document.getElementById('project_name').value;
                    const memberCards = document.querySelectorAll('.member-card');
                    Swal.fire({
                        title: 'Konfirmasi Pembuatan Proyek',
                        html: `
                    <div style="text-align: left; margin: 1rem 0;">
                        <p><strong>Nama Proyek:</strong> ${projectName}</p>
                        <p><strong>Jumlah Anggota:</strong> ${memberCards.length} orang</p>
                        <p style="margin-top: 1rem; color: #6b7280; font-size: 0.9rem;">
                            Pastikan semua data sudah benar sebelum membuat proyek.
                        </p>
                    </div>
                `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Buat Proyek',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            popup: 'swal-modern-popup',
                            title: 'swal-modern-title',
                            htmlContainer: 'swal-modern-html'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            submitForm();
                        }
                    });
                }
                // Submit form with loading state
                function submitForm() {
                    // Disable submit button and show loading
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise loading-spin me-2"></i>Membuat Proyek...';
                    // Show loading modal
                    Swal.fire({
                        title: 'Membuat Proyek',
                        html: `
                    <div style="padding: 2rem 0;">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <p>Mohon tunggu, sedang memproses data proyek dan mengunggah berkas...</p>
                    </div>
                `,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal-modern-popup'
                        }
                    });
                    // Submit the actual form
                    setTimeout(() => {
                        form.submit();
                    }, 1000);
                }
                // Validate all steps
                function validateAllSteps() {
                    let isValid = true;
                    for (let step = 1; step <= totalSteps; step++) {
                        const stepEl = document.querySelector(`.form-step[data-step="${step}"]`);
                        const requiredFields = stepEl.querySelectorAll('[required]');
                        requiredFields.forEach(field => {
                            if (!validateField(field)) {
                                isValid = false;
                            }
                        });
                        if (step === 3 && !validateMembersStep()) {
                            isValid = false;
                        }
                    }
                    return isValid;
                }
                // Initialize first member event listeners
                const firstMemberCard = document.querySelector('.member-card[data-member="0"]');
                if (firstMemberCard) {
                    attachMemberEventListeners(firstMemberCard);
                }
                // Update remove buttons initially
                updateRemoveButtons();
                // Keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    // Navigate with arrow keys (Alt + Arrow)
                    if (e.altKey) {
                        if (e.key === 'ArrowLeft' && currentStep > 1) {
                            e.preventDefault();
                            changeStep(-1);
                        } else if (e.key === 'ArrowRight' && currentStep < totalSteps) {
                            e.preventDefault();
                            changeStep(1);
                        }
                    }
                    // Submit with Ctrl/Cmd + Enter
                    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter' && currentStep === totalSteps) {
                        e.preventDefault();
                        handleFormSubmit(e);
                    }
                });
                // Auto-save to localStorage (optional feature)
                function autoSave() {
                    const formData = new FormData(form);
                    const data = {};
                    for (let [key, value] of formData.entries()) {
                        if (key !== 'files[]') { // Don't save files
                            data[key] = value;
                        }
                    }
                    localStorage.setItem('nda-project-draft', JSON.stringify(data));
                }
                // Restore from localStorage
                function restoreFromAutoSave() {
                    const saved = localStorage.getItem('nda-project-draft');
                    if (saved) {
                        try {
                            const data = JSON.parse(saved);
                            // Restore basic fields
                            Object.entries(data).forEach(([key, value]) => {
                                const field = document.querySelector(`[name="${key}"]`);
                                if (field && field.type !== 'file') {
                                    field.value = value;
                                    // Trigger change events for calculated fields
                                    if (key === 'start_date' || key === 'end_date') {
                                        calculateDuration();
                                    }
                                }
                            });
                            // Update character counter
                            if (descriptionTextarea && descriptionCounter) {
                                descriptionCounter.textContent = descriptionTextarea.value.length;
                            }
                        } catch (e) {
                            console.warn('Failed to restore auto-save data:', e);
                        }
                    }
                }
                // Auto-save on input changes (debounced)
                let autoSaveTimeout;
                document.addEventListener('input', function(e) {
                    if (e.target.closest('#projectForm') && e.target.type !== 'file') {
                        clearTimeout(autoSaveTimeout);
                        autoSaveTimeout = setTimeout(autoSave, 2000); // Save after 2 seconds of inactivity
                    }
                });
                // Clear auto-save on successful submission
                form.addEventListener('submit', function() {
                    localStorage.removeItem('nda-project-draft');
                });
                // Restore auto-save on page load
                restoreFromAutoSave();
                // Show helpful tooltips for better UX
                function initializeTooltips() {
                    // Add tooltips to step icons in progress indicator
                    document.querySelectorAll('.progress-step').forEach((step, index) => {
                        const stepNames = ['Informasi Dasar', 'Timeline Proyek', 'Tim & Berkas'];
                        step.title = stepNames[index];
                    });
                    // Add tooltips to action buttons
                    document.getElementById('add-member').title =
                        'Tambah anggota tim baru (minimal 1 anggota diperlukan)';
                }
                initializeTooltips();
            });
            // Custom SweetAlert2 styles
            const swalStyles = document.createElement('style');
            swalStyles.innerHTML = `
        .swal-modern-popup {
            border-radius: 16px !important;
            padding: 0 !important;
            font-family: 'Inter', sans-serif !important;
        }
        .swal-modern-title {
            font-size: 1.25rem !important;
            font-weight: 700 !important;
            color: #1f2937 !important;
            margin-bottom: 0.5rem !important;
        }
        .swal-modern-content {
            font-size: 0.9rem !important;
            line-height: 1.5 !important;
            color: #4b5563 !important;
        }
        .swal-modern-html {
            margin: 0 !important;
            padding: 0 !important;
        }
        .swal2-confirm {
            border-radius: 8px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
        }
        .swal2-cancel {
            border-radius: 8px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
        }
        .swal2-actions {
            gap: 0.75rem !important;
            margin-top: 1.5rem !important;
        }
        .spinner-border {
            width: 2rem;
            height: 2rem;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border-spin 0.75s linear infinite;
        }
        @keyframes spinner-border-spin {
            to { transform: rotate(360deg); }
        }
        .text-primary {
            color: #4f46e5 !important;
        }
        .sr-only {
            position: absolute !important;
            width: 1px !important;
            height: 1px !important;
            padding: 0 !important;
            margin: -1px !important;
            overflow: hidden !important;
            clip: rect(0, 0, 0, 0) !important;
            border: 0 !important;
        }
    `;
            document.head.appendChild(swalStyles);
        </script>
    @endpush
@endsection
