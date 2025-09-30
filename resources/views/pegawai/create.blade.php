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
                                <button type="button" class="btn btn-primary btn-add-multiple-members"
                                    id="add-multiple-members">
                                    <i class="bi bi-people me-2"></i>
                                    Tambah Beberapa Anggota
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
                            <div class="search-container" style="margin-bottom: 1rem;">
                                <div class="field-wrapper">
                                    <div class="field-icon">
                                        <i class="bi bi-search"></i>
                                    </div>
                                    <input type="text" id="member-search" class="field-input"
                                        placeholder="Cari anggota berdasarkan nama...">
                                </div>
                            </div>
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
            /* CSS Variables - Light Mode Enhanced */
            :root {
                --primary: #4f46e5;
                --primary-light: #6366f1;
                --primary-dark: #4338ca;
                --primary-bg: rgba(79, 70, 229, 0.06);
                --secondary: #64748b;
                --secondary-light: #94a3b8;
                --secondary-dark: #475569;
                --secondary-bg: rgba(100, 116, 139, 0.06);
                --success: #10b981;
                --success-light: #34d399;
                --success-dark: #059669;
                --success-bg: rgba(16, 185, 129, 0.06);
                --warning: #f59e0b;
                --warning-light: #fbbf24;
                --warning-dark: #d97706;
                --warning-bg: rgba(245, 158, 11, 0.06);
                --danger: #ef4444;
                --danger-light: #f87171;
                --danger-dark: #dc2626;
                --danger-bg: rgba(239, 68, 68, 0.06);
                --info: #0ea5e9;
                --info-light: #38bdf8;
                --info-dark: #0284c7;
                --info-bg: rgba(14, 165, 233, 0.06);
                --gray-50: #fafafa;
                --gray-100: #f5f5f5;
                --gray-200: #e5e5e5;
                --gray-300: #d4d4d4;
                --gray-400: #a3a3a3;
                --gray-500: #737373;
                --gray-600: #525252;
                --gray-700: #404040;
                --gray-800: #262626;
                --gray-900: #171717;
                --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.04);
                --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px 0 rgba(0, 0, 0, 0.04);
                --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -1px rgba(0, 0, 0, 0.04);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
                --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                --radius: 10px;
                --radius-sm: 6px;
                --radius-lg: 14px;
                --radius-xl: 18px;
                --radius-2xl: 22px;
                --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                --transition-fast: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
                --transition-slow: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Base Styles */
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                color: var(--gray-900);
                line-height: 1.6;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            /* Main Container */
            .main-container {
                max-width: 1280px;
                margin: 0 auto;
                padding: 2.5rem 1.5rem;
                min-height: 100vh;
            }

            /* Page Header */
            .page-header {
                margin-bottom: 2.5rem;
            }

            .header-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 2rem;
                background: white;
                padding: 2rem 2.5rem;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-md);
                border: 1px solid var(--gray-200);
            }

            .header-text {
                flex: 1;
            }

            .page-title {
                font-size: 2rem;
                font-weight: 700;
                color: var(--gray-900);
                margin: 0 0 0.75rem 0;
                letter-spacing: -0.02em;
                line-height: 1.2;
            }

            .page-subtitle {
                font-size: 1rem;
                color: var(--gray-600);
                margin: 0;
                line-height: 1.6;
                max-width: 600px;
            }

            .header-action {
                display: flex;
                align-items: center;
                flex-shrink: 0;
            }

            /* Progress Section */
            .progress-section {
                margin-bottom: 2.5rem;
            }

            .progress-indicator {
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: white;
                padding: 2rem 3rem;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-md);
                border: 1px solid var(--gray-200);
                max-width: 900px;
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
                font-size: 1.125rem;
                background: var(--gray-200);
                color: var(--gray-500);
                margin-bottom: 0.75rem;
                transition: var(--transition);
                position: relative;
                z-index: 2;
                border: 3px solid white;
                box-shadow: var(--shadow-sm);
            }

            .progress-step.active .progress-step-circle,
            .progress-step.completed .progress-step-circle {
                background: linear-gradient(135deg, var(--primary), var(--primary-light));
                color: white;
                transform: scale(1.08);
                box-shadow: 0 0 0 4px var(--primary-bg), var(--shadow-md);
            }

            .progress-step.completed .progress-step-circle {
                background: linear-gradient(135deg, var(--success), var(--success-light));
                box-shadow: 0 0 0 4px var(--success-bg), var(--shadow-md);
            }

            .progress-step-label {
                font-size: 0.8125rem;
                color: var(--gray-600);
                font-weight: 500;
                transition: var(--transition);
                white-space: nowrap;
            }

            .progress-step.active .progress-step-label {
                color: var(--primary);
                font-weight: 600;
            }

            .progress-step.completed .progress-step-label {
                color: var(--success);
                font-weight: 600;
            }

            .progress-line {
                height: 3px;
                background: var(--gray-200);
                flex: 1;
                margin: 0 1rem;
                margin-top: -1.5rem;
                position: relative;
                z-index: 1;
                transition: var(--transition);
                border-radius: 2px;
            }

            .progress-line.completed {
                background: linear-gradient(90deg, var(--success), var(--success-light));
            }

            /* Form Container */
            .form-container {
                background: white;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-md);
                border: 1px solid var(--gray-200);
                overflow: hidden;
            }

            /* Form Steps */
            .form-step {
                display: none;
                animation: fadeInSlide 0.4s ease-out;
            }

            .form-step.active {
                display: block;
            }

            @keyframes fadeInSlide {
                from {
                    opacity: 0;
                    transform: translateY(15px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Step Cards */
            .step-card {
                padding: 3rem;
            }

            .step-header {
                display: flex;
                align-items: flex-start;
                gap: 1.25rem;
                margin-bottom: 2.5rem;
                padding-bottom: 2rem;
                border-bottom: 2px solid var(--gray-100);
            }

            .step-icon {
                width: 3rem;
                height: 3rem;
                border-radius: var(--radius-lg);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
                flex-shrink: 0;
                box-shadow: var(--shadow-sm);
            }

            .step-icon-primary {
                background: linear-gradient(135deg, var(--primary-bg), var(--primary-bg));
                color: var(--primary);
                border: 2px solid var(--primary);
            }

            .step-icon-warning {
                background: linear-gradient(135deg, var(--warning-bg), var(--warning-bg));
                color: var(--warning);
                border: 2px solid var(--warning);
            }

            .step-icon-info {
                background: linear-gradient(135deg, var(--info-bg), var(--info-bg));
                color: var(--info);
                border: 2px solid var(--info);
            }

            .step-icon-success {
                background: linear-gradient(135deg, var(--success-bg), var(--success-bg));
                color: var(--success);
                border: 2px solid var(--success);
            }

            .step-content {
                flex: 1;
            }

            .step-title {
                font-size: 1.375rem;
                font-weight: 700;
                color: var(--gray-900);
                margin: 0 0 0.5rem 0;
                line-height: 1.3;
            }

            .step-description {
                font-size: 0.9375rem;
                color: var(--gray-600);
                margin: 0;
                line-height: 1.5;
            }

            .step-action {
                display: flex;
                align-items: center;
                gap: 0.875rem;
                flex-wrap: wrap;
            }

            .step-body {
                padding: 0;
            }

            /* Form Grid */
            .form-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.75rem;
            }

            .form-field {
                display: flex;
                flex-direction: column;
                gap: 0.625rem;
            }

            .form-field.col-span-2 {
                grid-column: 1 / -1;
            }

            /* Field Elements */
            .field-label {
                font-size: 0.9375rem;
                font-weight: 600;
                color: var(--gray-700);
                display: flex;
                align-items: center;
                gap: 0.375rem;
            }

            .field-label.required::after {
                content: '*';
                color: var(--danger);
                font-size: 0.9375rem;
            }

            .field-wrapper {
                position: relative;
                display: flex;
                align-items: center;
            }

            .field-icon {
                position: absolute;
                left: 1.125rem;
                z-index: 2;
                color: var(--gray-400);
                font-size: 1.0625rem;
                pointer-events: none;
            }

            .field-input {
                width: 100%;
                padding: 0.875rem 1.125rem 0.875rem 2.875rem;
                border: 2px solid var(--gray-200);
                border-radius: var(--radius);
                font-size: 0.9375rem;
                background: white;
                transition: var(--transition);
                outline: none;
                font-family: inherit;
            }

            .field-input:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 4px var(--primary-bg);
            }

            .field-input::placeholder {
                color: var(--gray-400);
            }

            .field-textarea {
                width: 100%;
                padding: 0.875rem 1.125rem;
                padding-bottom: 2.5rem;
                border: 2px solid var(--gray-200);
                border-radius: var(--radius);
                font-size: 0.9375rem;
                background: white;
                transition: var(--transition);
                outline: none;
                resize: vertical;
                min-height: 120px;
                font-family: inherit;
            }

            .field-textarea:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 4px var(--primary-bg);
            }

            .field-error {
                border-color: var(--danger) !important;
                box-shadow: 0 0 0 4px var(--danger-bg) !important;
            }

            .field-success {
                border-color: var(--success) !important;
            }

            .textarea-counter {
                position: absolute;
                bottom: 0.75rem;
                right: 1rem;
                font-size: 0.8125rem;
                color: var(--gray-500);
                background: white;
                padding: 0.375rem 0.625rem;
                border-radius: var(--radius-sm);
                border: 1px solid var(--gray-200);
            }

            .field-feedback {
                font-size: 0.8125rem;
                margin-top: 0.25rem;
            }

            .field-feedback-error {
                color: var(--danger);
            }

            .field-hint {
                font-size: 0.8125rem;
                color: var(--gray-500);
            }

            /* Duration Card */
            .duration-card {
                background: linear-gradient(135deg, var(--primary-bg) 0%, var(--info-bg) 100%);
                border: 2px solid var(--gray-200);
                border-radius: var(--radius-lg);
                padding: 1.25rem;
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-top: 1.5rem;
                transition: var(--transition);
            }

            .duration-card:hover {
                transform: translateY(-2px);
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
                flex-shrink: 0;
            }

            .duration-info {
                flex: 1;
            }

            .duration-label {
                font-size: 0.8125rem;
                font-weight: 600;
                color: var(--gray-700);
                margin-bottom: 0.25rem;
            }

            .duration-value {
                font-size: 0.9375rem;
                color: var(--gray-900);
                font-weight: 600;
            }

            /* Members Container */
            .members-container {
                display: flex;
                flex-direction: column;
                gap: 1.25rem;
                max-height: 500px;
                overflow-y: auto;
                padding-right: 0.5rem;
            }

            .member-card {
                background: var(--gray-50);
                border: 2px solid var(--gray-200);
                border-radius: var(--radius-lg);
                padding: 1.25rem;
                transition: var(--transition);
            }

            .member-card:hover {
                background: white;
                border-color: var(--primary);
                box-shadow: var(--shadow-md);
            }

            .member-header {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1.25rem;
                padding-bottom: 1rem;
                border-bottom: 2px solid var(--gray-200);
            }

            .member-avatar {
                width: 2.5rem;
                height: 2.5rem;
                background: linear-gradient(135deg, var(--primary-bg), var(--primary-bg));
                color: var(--primary);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                flex-shrink: 0;
                border: 2px solid var(--primary);
            }

            .member-info {
                flex: 1;
            }

            .member-label {
                font-size: 0.8125rem;
                font-weight: 700;
                color: var(--gray-700);
                text-transform: uppercase;
                letter-spacing: 0.025em;
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
                font-size: 1rem;
                border: 2px solid var(--danger);
            }

            .btn-remove-member:hover {
                background: var(--danger);
                color: white;
                transform: scale(1.1);
            }

            .member-body {
                display: flex;
                flex-direction: column;
                gap: 1.25rem;
            }

            .member-fields {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.25rem;
            }

            .member-field {
                display: flex;
                flex-direction: column;
                gap: 0.625rem;
            }

            .member-name {
                padding-left: 1.125rem !important;
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
                padding: 1.25rem;
                border: 2px dashed var(--gray-300);
                border-radius: var(--radius);
                background: var(--gray-50);
                cursor: pointer;
                transition: var(--transition);
                text-align: left;
            }

            .file-upload-label:hover {
                border-color: var(--primary);
                background: var(--primary-bg);
            }

            .file-upload-icon {
                width: 2.25rem;
                height: 2.25rem;
                background: linear-gradient(135deg, var(--primary-bg), var(--primary-bg));
                color: var(--primary);
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                flex-shrink: 0;
                border: 2px solid var(--primary);
            }

            .file-upload-text {
                flex: 1;
            }

            .file-upload-title {
                font-size: 0.8125rem;
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
                border: 2px solid var(--success);
                border-radius: var(--radius);
                font-size: 0.8125rem;
            }

            .file-info {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: var(--success-dark);
                font-weight: 600;
            }

            .file-name {
                max-width: 200px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .btn-remove-file {
                width: 1.75rem;
                height: 1.75rem;
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
                border: 2px solid var(--danger);
            }

            .btn-remove-file:hover {
                background: var(--danger);
                color: white;
            }

            /* Hints */
            .members-hint,
            .confirmation-hint {
                display: flex;
                align-items: flex-start;
                gap: 0.75rem;
                padding: 1rem;
                background: var(--info-bg);
                border-radius: var(--radius);
                margin-top: 1.5rem;
                font-size: 0.9375rem;
                border: 2px solid var(--info);
            }

            .hint-icon {
                width: 1.25rem;
                height: 1.25rem;
                color: var(--info);
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-top: 0.125rem;
            }

            .hint-text {
                color: var(--info-dark);
                line-height: 1.5;
                flex: 1;
            }

            /* Tables */
            .saved-members-table,
            .confirmation-table {
                margin-top: 2rem;
            }

            .saved-members-table h4,
            .confirmation-table h4 {
                font-size: 1.125rem;
                font-weight: 700;
                color: var(--gray-900);
                margin-bottom: 1rem;
            }

            .table-wrapper {
                overflow-x: auto;
                border-radius: var(--radius);
                border: 2px solid var(--gray-200);
                background: white;
                box-shadow: var(--shadow-sm);
            }

            .table-minimal {
                width: 100%;
                min-width: 500px;
                border-collapse: collapse;
                font-size: 0.9375rem;
            }

            .table-minimal th,
            .table-minimal td {
                padding: 0.875rem 1rem;
                text-align: left;
                border-bottom: 1px solid var(--gray-100);
            }

            .table-minimal th {
                background: var(--gray-50);
                font-weight: 700;
                color: var(--gray-700);
                font-size: 0.8125rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .table-minimal tbody tr:hover {
                background: var(--gray-50);
            }

            .table-minimal td {
                color: var(--gray-600);
            }

            .table-minimal .btn-sm {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
                margin: 0 0.25rem;
            }

            /* Buttons */
            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.875rem 1.75rem;
                font-size: 0.9375rem;
                font-weight: 600;
                text-decoration: none;
                border: none;
                border-radius: var(--radius);
                transition: var(--transition);
                cursor: pointer;
                white-space: nowrap;
                outline: none;
                box-shadow: var(--shadow-sm);
            }

            .btn:focus-visible {
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary), var(--primary-light));
                color: white;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, var(--primary-dark), var(--primary));
                transform: translateY(-2px);
                box-shadow: var(--shadow-md);
            }

            .btn-secondary {
                background: white;
                color: var(--gray-700);
                border: 2px solid var(--gray-300);
            }

            .btn-secondary:hover {
                background: var(--gray-50);
                border-color: var(--gray-400);
                color: var(--gray-900);
            }

            .btn-success {
                background: linear-gradient(135deg, var(--success), var(--success-light));
                color: white;
            }

            .btn-success:hover {
                background: linear-gradient(135deg, var(--success-dark), var(--success));
                transform: translateY(-2px);
                box-shadow: var(--shadow-md);
            }

            .btn-danger {
                background: linear-gradient(135deg, var(--danger), var(--danger-light));
                color: white;
            }

            .btn-danger:hover {
                background: linear-gradient(135deg, var(--danger-dark), var(--danger));
                transform: translateY(-2px);
                box-shadow: var(--shadow-md);
            }

            .btn-nav {
                padding: 1rem 2.25rem;
                font-size: 1rem;
                border-radius: var(--radius-lg);
            }

            .btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
                transform: none !important;
            }

            /* Form Navigation */
            .form-navigation {
                background: var(--gray-50);
                padding: 2rem 3rem;
                border-top: 2px solid var(--gray-200);
            }

            .nav-buttons {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1.25rem;
            }

            .nav-buttons .btn {
                min-width: 160px;
            }

            /* Search Container */
            .search-container {
                margin-bottom: 1.5rem;
            }

            .search-container .field-wrapper {
                max-width: 350px;
            }

            #member-search {
                padding-left: 2.875rem;
            }

            /* Scrollbar */
            .members-container::-webkit-scrollbar {
                width: 8px;
            }

            .members-container::-webkit-scrollbar-track {
                background: var(--gray-100);
                border-radius: 4px;
            }

            .members-container::-webkit-scrollbar-thumb {
                background: var(--gray-300);
                border-radius: 4px;
            }

            .members-container::-webkit-scrollbar-thumb:hover {
                background: var(--gray-400);
            }

            /* Animations */
            .loading-spin {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            .fade-in {
                animation: fadeIn 0.3s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            .slide-in {
                animation: slideIn 0.3s ease-out;
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

            /* Responsive Design */
            @media (max-width: 1024px) {
                .main-container {
                    padding: 2rem 1.25rem;
                }

                .step-card {
                    padding: 2.5rem;
                }

                .form-grid,
                .member-fields {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 768px) {
                .main-container {
                    padding: 1.5rem 1rem;
                }

                .header-content {
                    flex-direction: column;
                    align-items: flex-start;
                    padding: 1.75rem;
                    gap: 1.5rem;
                }

                .page-title {
                    font-size: 1.5rem;
                }

                .page-subtitle {
                    font-size: 0.9375rem;
                }

                .header-action {
                    width: 100%;
                }

                .btn-back {
                    width: 100%;
                    justify-content: center;
                }

                .progress-indicator {
                    flex-direction: column;
                    padding: 1.75rem;
                    gap: 1rem;
                }

                .progress-line {
                    width: 3px;
                    height: 1.5rem;
                    margin: 0.5rem 0;
                }

                .progress-step-circle {
                    width: 2.5rem;
                    height: 2.5rem;
                    font-size: 1rem;
                }

                .progress-step-label {
                    font-size: 0.75rem;
                }

                .step-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1rem;
                }

                .step-card {
                    padding: 2rem;
                }

                .step-title {
                    font-size: 1.125rem;
                }

                .step-description {
                    font-size: 0.875rem;
                }

                .step-action {
                    width: 100%;
                    flex-direction: column;
                }

                .step-action .btn {
                    width: 100%;
                    justify-content: center;
                }

                .duration-card {
                    flex-direction: column;
                    text-align: center;
                    gap: 0.75rem;
                }

                .member-header {
                    flex-wrap: wrap;
                }

                .member-fields {
                    grid-template-columns: 1fr;
                }

                .members-container {
                    max-height: 350px;
                }

                .file-upload-label {
                    flex-direction: column;
                    text-align: center;
                    gap: 0.75rem;
                }

                .form-navigation {
                    padding: 1.75rem;
                }

                .nav-buttons {
                    flex-direction: column;
                    gap: 1rem;
                }

                .nav-buttons .btn {
                    width: 100%;
                    min-width: auto;
                }

                .table-wrapper {
                    font-size: 0.8125rem;
                }

                .table-minimal {
                    min-width: 600px;
                }

                .table-minimal th,
                .table-minimal td {
                    padding: 0.625rem 0.75rem;
                }
            }

            @media (max-width: 640px) {
                .main-container {
                    padding: 1rem 0.75rem;
                }

                .header-content {
                    padding: 1.25rem;
                }

                .page-title {
                    font-size: 1.25rem;
                }

                .page-subtitle {
                    font-size: 0.875rem;
                }

                .progress-indicator {
                    padding: 1.25rem;
                }

                .progress-step-circle {
                    width: 2rem;
                    height: 2rem;
                    font-size: 0.875rem;
                    border-width: 2px;
                }

                .progress-step-label {
                    font-size: 0.6875rem;
                }

                .step-card {
                    padding: 1.5rem;
                }

                .step-icon {
                    width: 2.5rem;
                    height: 2.5rem;
                    font-size: 1rem;
                }

                .step-title {
                    font-size: 1rem;
                }

                .step-description {
                    font-size: 0.8125rem;
                }

                .member-card {
                    padding: 1rem;
                }

                .member-avatar {
                    width: 2rem;
                    height: 2rem;
                    font-size: 0.875rem;
                }

                .duration-card {
                    padding: 1rem;
                }

                .duration-icon {
                    width: 2rem;
                    height: 2rem;
                    font-size: 1rem;
                }

                .form-grid {
                    gap: 1.25rem;
                }

                .field-input,
                .field-textarea {
                    font-size: 0.875rem;
                    padding: 0.75rem 1rem;
                }

                .field-input {
                    padding-left: 2.5rem;
                }

                .field-icon {
                    left: 1rem;
                    font-size: 0.9375rem;
                }

                .file-upload-label {
                    padding: 1rem;
                }

                .file-upload-icon {
                    width: 2rem;
                    height: 2rem;
                    font-size: 0.9375rem;
                }

                .btn {
                    padding: 0.75rem 1.5rem;
                    font-size: 0.875rem;
                }

                .btn-nav {
                    padding: 0.875rem 1.75rem;
                    font-size: 0.9375rem;
                }

                .form-navigation {
                    padding: 1.25rem;
                }

                .members-container {
                    max-height: 280px;
                }

                .table-minimal {
                    min-width: 650px;
                }
            }

            @media (max-width: 480px) {
                .main-container {
                    padding: 0.875rem 0.625rem;
                }

                .header-content {
                    padding: 1rem;
                }

                .page-title {
                    font-size: 1.125rem;
                }

                .progress-indicator {
                    padding: 1rem;
                }

                .step-card {
                    padding: 1.25rem;
                }

                .step-header {
                    margin-bottom: 1.5rem;
                    padding-bottom: 1.25rem;
                }

                .form-grid {
                    gap: 1rem;
                }

                .field-label {
                    font-size: 0.875rem;
                }

                .field-input,
                .field-textarea {
                    font-size: 0.8125rem;
                    padding: 0.625rem 0.875rem;
                }

                .field-input {
                    padding-left: 2.25rem;
                }

                .textarea-counter {
                    font-size: 0.75rem;
                    padding: 0.25rem 0.5rem;
                }

                .duration-card {
                    padding: 0.875rem;
                }

                .member-card {
                    padding: 0.875rem;
                }

                .member-body {
                    gap: 1rem;
                }

                .file-upload-label {
                    padding: 0.875rem;
                }

                .file-upload-title {
                    font-size: 0.75rem;
                }

                .file-upload-subtitle {
                    font-size: 0.6875rem;
                }

                .btn {
                    padding: 0.625rem 1.25rem;
                    font-size: 0.8125rem;
                }

                .btn-nav {
                    padding: 0.75rem 1.5rem;
                    font-size: 0.875rem;
                }

                .form-navigation {
                    padding: 1rem;
                }

                .members-container {
                    max-height: 240px;
                }

                .search-container .field-wrapper {
                    max-width: 100%;
                }
            }

            /* Landscape Phone */
            @media (max-width: 896px) and (orientation: landscape) {
                .progress-indicator {
                    flex-direction: row;
                    padding: 1.25rem 1.5rem;
                }

                .progress-line {
                    width: auto;
                    height: 3px;
                    margin: 0 0.75rem;
                    margin-top: -1.25rem;
                }

                .members-container {
                    max-height: 200px;
                }
            }

            /* iPad & Tablet Portrait */
            @media (min-width: 768px) and (max-width: 1024px) {
                .header-content {
                    padding: 2rem;
                }

                .progress-indicator {
                    padding: 2rem 2.5rem;
                }

                .step-card {
                    padding: 2.5rem 2rem;
                }

                .members-container {
                    max-height: 400px;
                }
            }

            /* iPad & Tablet Landscape */
            @media (min-width: 1024px) and (max-width: 1280px) {
                .main-container {
                    padding: 2.25rem 1.5rem;
                }

                .step-card {
                    padding: 2.75rem 2.25rem;
                }
            }

            /* Large Desktop */
            @media (min-width: 1440px) {
                .main-container {
                    max-width: 1400px;
                    padding: 3rem 2rem;
                }

                .header-content {
                    padding: 2.5rem 3rem;
                }

                .progress-indicator {
                    max-width: 1000px;
                    padding: 2.5rem 3.5rem;
                }

                .step-card {
                    padding: 3.5rem;
                }

                .members-container {
                    max-height: 550px;
                }
            }

            /* Print Styles */
            @media print {

                .header-action,
                .step-action,
                .btn-remove-member,
                .btn-remove-file,
                .form-navigation {
                    display: none !important;
                }

                .main-container {
                    padding: 0;
                }

                .page-header,
                .form-container,
                .step-card {
                    box-shadow: none;
                    border: 1px solid var(--gray-300);
                }

                .form-step {
                    display: block !important;
                    page-break-after: always;
                }
            }

            /* Accessibility Improvements */
            @media (prefers-reduced-motion: reduce) {

                *,
                *::before,
                *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                }
            }

            /* High Contrast Mode */
            @media (prefers-contrast: high) {
                .btn {
                    border: 2px solid currentColor;
                }

                .field-input,
                .field-textarea {
                    border-width: 2px;
                }
            }

            /* Dark Mode Override (Optional - untuk konsistensi light mode) */
            @media (prefers-color-scheme: dark) {
                body {
                    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                }
            }

            /* Focus Visible Enhancements */
            .btn:focus-visible,
            .field-input:focus-visible,
            .field-textarea:focus-visible {
                outline: 3px solid var(--primary);
                outline-offset: 2px;
            }

            .file-input:focus-visible+.file-upload-label {
                outline: 3px solid var(--primary);
                outline-offset: 2px;
            }

            /* Utility Classes */
            .text-center {
                text-align: center;
            }

            .mt-1 {
                margin-top: 0.5rem;
            }

            .mt-2 {
                margin-top: 1rem;
            }

            .mb-1 {
                margin-bottom: 0.5rem;
            }

            .mb-2 {
                margin-bottom: 1rem;
            }

            .d-flex {
                display: flex;
            }

            .justify-content-center {
                justify-content: center;
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
                to {
                    transform: rotate(360deg);
                }
            }

            /* Success Icons */
            .success-icon {
                color: var(--success);
                margin-left: 0.375rem;
            }

            /* Badge Styles */
            .badge {
                display: inline-flex;
                align-items: center;
                padding: 0.25rem 0.625rem;
                font-size: 0.75rem;
                font-weight: 600;
                border-radius: var(--radius-sm);
            }

            .badge-primary {
                background: var(--primary-bg);
                color: var(--primary);
            }

            .badge-success {
                background: var(--success-bg);
                color: var(--success);
            }

            /* Member Card Saved State */
            .member-card[data-saved="true"] {
                border-color: var(--success);
                background: var(--success-bg);
            }

            .member-card[data-saved="true"] .member-avatar {
                background: linear-gradient(135deg, var(--success-bg), var(--success-bg));
                color: var(--success);
                border-color: var(--success);
            }

            /* File Upload Success State */
            .file-upload-area.has-file .file-upload-label {
                display: none;
            }

            .file-upload-area.has-file .file-upload-info {
                display: flex;
            }

            .file-upload-info.file-success {
                border-color: var(--success);
                background: var(--success-bg);
            }

            /* Empty States */
            .empty-state {
                padding: 3rem 2rem;
                text-align: center;
                color: var(--gray-500);
            }

            .empty-state-icon {
                font-size: 3rem;
                margin-bottom: 1rem;
                opacity: 0.5;
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
                let savedMembers = {}; // Objek untuk menyimpan data dari server

                // Initialize
                updateStepDisplay();
                initializeCharacterCounter();
                attachEventListeners();
                restoreFromAutoSave();
                loadSavedMembers(); // Load dari server

                // Restore from localStorage (draft lokal)
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
                                    card.setAttribute('data-has-file', 'true');
                                }
                            });
                            memberCount = membersData.length;
                            updateRemoveButtons();
                        } catch (e) {
                            console.warn('Failed to restore members draft:', e);
                        }
                    }
                }

                // Auto-save ke localStorage
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

                // Event listeners utama
                function attachEventListeners() {
                    prevBtn.addEventListener('click', () => changeStep(-1));
                    nextBtn.addEventListener('click', () => changeStep(1));
                    document.getElementById('start_date').addEventListener('change', calculateDuration);
                    document.getElementById('end_date').addEventListener('change', calculateDuration);
                    document.getElementById('add-member').addEventListener('click', addMember);
                    document.getElementById('add-multiple-members').addEventListener('click', addMultipleMembers);
                    form.addEventListener('submit', handleFormSubmit);
                    attachFieldValidation();
                    setupSearch();
                }

                function addMultipleMembers() {
                    Swal.fire({
                        title: 'Tambah Anggota Cepat',
                        input: 'number',
                        inputLabel: 'Masukkan jumlah anggota yang ingin ditambahkan',
                        inputPlaceholder: 'Contoh: 15',
                        inputAttributes: {
                            min: 1,
                            max: 50, // Batas maksimal untuk menghindari overload
                            step: 1
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Tambah',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#6b7280',
                        inputValidator: (value) => {
                            if (!value || value < 1) {
                                return 'Jumlah minimal 1 anggota!';
                            }
                            if (value > 50) {
                                return 'Jumlah maksimal 50 per sekali tambah!';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const count = parseInt(result.value);
                            for (let i = 0; i < count; i++) {
                                addMember();
                                // Optional: Tambahkan delay kecil jika count besar untuk menghindari lag render (misalnya 100ms per card)
                                // await new Promise(resolve => setTimeout(resolve, 100)); // Gunakan async/await jika diubah ke async function
                            }
                            // Setelah selesai, scroll ke card terakhir
                            const lastCard = document.querySelector('.member-card:last-child');
                            if (lastCard) {
                                lastCard.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: `${count} anggota baru ditambahkan. Silakan isi data masing-masing.`
                            });
                        }
                    });
                }

                // Load saved members dari server
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
                                // Buat card di Step 3 jika belum ada
                                Object.keys(savedMembers).forEach(idx => {
                                    let card = document.querySelector(`[data-member="${idx}"]`);
                                    if (!card) {
                                        card = createMemberCard(idx);
                                        document.getElementById('member-container').appendChild(card);
                                        attachMemberEventListeners(card);
                                    }
                                    card.querySelector('.member-name').value = savedMembers[idx].name;
                                    card.querySelector('input[type="date"]').value = savedMembers[idx]
                                        .signature_date;
                                    const uploadInfo = card.querySelector('.file-upload-info');
                                    const fileNameSpan = uploadInfo.querySelector('.file-name');
                                    if (savedMembers[idx].file_name) {
                                        fileNameSpan.textContent = savedMembers[idx].file_name;
                                        uploadInfo.style.display = 'flex';
                                        card.querySelector('.file-upload-label').style.display = 'none';
                                        card.querySelector('.file-upload-area').classList.add('has-file');
                                        card.querySelector('.btn-save-member').textContent =
                                            'Re-Save jika Ganti';
                                        card.setAttribute('data-has-file', 'true');
                                    }
                                    card.setAttribute('data-saved', 'true');
                                });
                                memberCount = Object.keys(savedMembers).length || 1;
                                updateRemoveButtons();
                            }
                        })
                        .catch(error => {
                            console.warn('Gagal load saved members:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat data anggota dari server.'
                            });
                        });
                }

                // Change step
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

                // Update display step
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

                // Validasi step saat ini
                function validateCurrentStep() {
                    const currentStepEl = document.querySelector(`.form-step[data-step="${currentStep}"]`);
                    const requiredFields = currentStepEl.querySelectorAll('[required]');
                    let isValid = true;
                    requiredFields.forEach(field => {
                        if (!validateField(field)) isValid = false;
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

                // Validasi field
                function validateField(field) {
                    let value = field.value;
                    if (field.type === 'file') value = field.files.length > 0;
                    else value = field.value.trim();
                    const isValid = !!value;
                    field.classList.toggle('field-error', !isValid);
                    field.classList.toggle('field-success', isValid && field.value.trim());
                    return isValid;
                }

                // Validasi Step 3 (members)
                function validateMembersStep() {
                    const memberCards = document.querySelectorAll('.member-card');
                    let isValid = true;
                    memberCards.forEach(card => {
                        const nameInput = card.querySelector('.member-name');
                        const dateInput = card.querySelector('input[type="date"]');
                        const fileInput = card.querySelector('.file-input');
                        if (!validateField(nameInput) || !validateField(dateInput)) isValid = false;
                        if (card.getAttribute('data-saved') !== 'true' && !validateField(fileInput)) isValid =
                            false;
                    });
                    return isValid && memberCards.length > 0;
                }

                // Tampilkan error validasi
                function showValidationError() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Form Belum Lengkap',
                        text: 'Harap lengkapi semua field yang wajib diisi sebelum melanjutkan.',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#4f46e5'
                    });
                }

                // Hitung durasi
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
                                text: 'Tanggal berakhir harus setelah tanggal mulai.'
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
                        durationText.textContent = `${durationParts.join(', ')} (${diffDays} hari total)`;
                        durationIcon.className = 'bi bi-calendar-check';
                        durationText.classList.add('slide-in');
                        setTimeout(() => durationText.classList.remove('slide-in'), 300);
                    } else {
                        durationText.textContent = 'Akan dihitung otomatis';
                        durationIcon.className = 'bi bi-clock';
                    }
                }

                // Tambah anggota baru di Step 3
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

                // Buat card anggota
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

                // Attach listener ke card anggota
                function attachMemberEventListeners(memberCard) {
                    const removeBtn = memberCard.querySelector('.btn-remove-member');
                    const fileInput = memberCard.querySelector('.file-input');
                    const nameInput = memberCard.querySelector('.member-name');
                    const saveBtn = memberCard.querySelector('.btn-save-member');
                    const removeFileBtn = memberCard.querySelector('.btn-remove-file');
                    const dateInput = memberCard.querySelector('input[type="date"]');
                    saveBtn.addEventListener('click', () => saveMember(memberCard));
                    removeBtn.addEventListener('click', () => removeMember(memberCard));
                    fileInput.addEventListener('change', (e) => handleFileUpload(e.target));
                    fileInput.addEventListener('change', () => validateField(fileInput));
                    removeFileBtn.addEventListener('click', () => removeFile(fileInput));
                    nameInput.addEventListener('blur', () => validateField(nameInput));
                    nameInput.addEventListener('input', () => {
                        if (nameInput.classList.contains('field-error') && nameInput.value.trim()) {
                            nameInput.classList.remove('field-error');
                            nameInput.classList.add('field-success');
                        }
                    });
                    dateInput.addEventListener('change', () => validateField(dateInput));
                }

                // Hapus anggota dari Step 3
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
                                autoSaveMembers();
                            }, 300);
                            // Hapus dari server juga
                            deleteMemberByIndex(index);
                        }
                    });
                }

                // Update tombol remove (hide jika hanya 1 anggota)
                function updateRemoveButtons() {
                    const memberCards = document.querySelectorAll('.member-card');
                    memberCards.forEach(card => {
                        const removeBtn = card.querySelector('.btn-remove-member');
                        removeBtn.style.display = memberCards.length > 1 ? 'flex' : 'none';
                    });
                }

                // Reindex card setelah hapus
                function reindexMembers() {
                    const memberCards = document.querySelectorAll('.member-card');
                    memberCards.forEach((card, index) => {
                        card.setAttribute('data-member', index);
                        card.querySelector('.member-label').textContent = `Anggota ke-${index + 1}`;
                        const nameInput = card.querySelector('.member-name');
                        const dateInput = card.querySelector('input[type="date"]');
                        const fileInput = card.querySelector('.file-input');
                        nameInput.name = `members[${index}][name]`;
                        dateInput.name = `members[${index}][signature_date]`;
                        fileInput.name = `files[${index}]`;
                        fileInput.id = `file-${index}`;
                        card.querySelector('.file-upload-label').setAttribute('for', `file-${index}`);
                    });
                    memberCount = memberCards.length;
                    autoSaveMembers();
                }

                // Handle upload file
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
                            text: 'Hanya file PDF yang diperbolehkan.'
                        });
                        fileInput.value = '';
                        return;
                    }
                    const maxSize = 10 * 1024 * 1024;
                    if (file.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 10MB.'
                        });
                        fileInput.value = '';
                        return;
                    }
                    const card = fileInput.closest('.member-card');
                    if (card) {
                        card.setAttribute('data-has-file', 'true');
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

                // Hapus file dari upload area
                function removeFile(fileInput) {
                    const uploadArea = fileInput.closest('.file-upload-area');
                    const uploadLabel = uploadArea.querySelector('.file-upload-label');
                    const uploadInfo = uploadArea.querySelector('.file-upload-info');
                    const card = fileInput.closest('.member-card');
                    if (card) {
                        card.removeAttribute('data-has-file');
                    }
                    fileInput.value = '';
                    uploadLabel.style.display = 'flex';
                    uploadInfo.style.display = 'none';
                    uploadArea.classList.remove('has-file');
                    uploadInfo.classList.remove('file-success');
                    fileInput.classList.remove('field-success');
                    autoSaveMembers();
                }

                // Attach validasi field
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

                // Di fungsi saveMember()
                function saveMember(memberCard) {
                    const index = memberCard.dataset.member;
                    const name = memberCard.querySelector('.member-name').value;
                    const signatureDate = memberCard.querySelector('input[type="date"]').value;
                    const fileInput = memberCard.querySelector('.file-input');
                    const isSaved = memberCard.getAttribute('data-saved') === 'true';

                    if (!name || !signatureDate) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Belum Lengkap',
                            text: 'Isi nama dan tanggal sebelum save.'
                        });
                        return;
                    }

                    const fileInfo = memberCard.querySelector('.file-upload-info');
                    const hasFileInfo = fileInfo.style.display !== 'none' && memberCard.querySelector('.file-name')
                        .textContent.trim() !== '';
                    // Perbaikan: Cek apakah ini Re-Save yang valid (dari server) atau hanya draft
                    if (!isSaved && !fileInput.files[0] && !hasFileInfo) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'File Belum Ada',
                            text: 'Upload file PDF terlebih dahulu karena anggota ini belum disimpan ke server.'
                        });
                        return;
                    }
                    if (isSaved && !fileInput.files[0] && !hasFileInfo) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'File Hilang',
                            text: 'File sebelumnya tidak ditemukan. Silakan unggah ulang file PDF.'
                        });
                        return;
                    }

                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('member_index', index);
                    formData.append('name', name);
                    formData.append('signature_date', signatureDate);
                    formData.append('is_resave', isSaved ? 'true' : 'false');
                    if (fileInput.files[0]) formData.append('file', fileInput.files[0]);

                    // Debug: Log isi FormData
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }

                    const saveBtn = memberCard.querySelector('.btn-save-member');
                    const originalText = saveBtn.textContent;
                    saveBtn.disabled = true;
                    saveBtn.innerHTML = '<i class="bi bi-arrow-clockwise loading-spin me-2"></i>Saving...';

                    fetch('{{ route('pegawai.nda.temp-member') }}', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            saveBtn.disabled = false;
                            saveBtn.innerHTML = originalText;
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: `Anggota ke-${parseInt(index) + 1} tersimpan.`
                                });
                                savedMembers[index] = data.data;
                                memberCard.setAttribute('data-saved', 'true');
                                saveBtn.textContent = 'Re-Save jika Ganti';
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
                            saveBtn.disabled = false;
                            saveBtn.innerHTML = originalText;
                            console.error('Save error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan koneksi.'
                            });
                        });
                }

                // Update tabel di Step 3 dan Step 4 (perbaikan: sorting di Step 4 berdasarkan nama)
                function updateTable() {
                    const savedTableBody = document.getElementById('saved-table-body');
                    const confirmationTableBody = document.getElementById('confirmation-table-body');
                    savedTableBody.innerHTML = '';
                    confirmationTableBody.innerHTML = '';
                    // Tabel saved (Step 3): urutan asli
                    Object.values(savedMembers).forEach((member, idx) => {
                        const row = `
                    <tr>
                        <td>${idx + 1}</td>
                        <td>${member.name}</td>
                        <td>${member.signature_date}</td>
                        <td>${member.file_name}</td>
                    </tr>`;
                        savedTableBody.innerHTML += row;
                    });
                    // Tabel konfirmasi (Step 4): sorted by name A-Z (bahasa Indonesia)
                    const sortedMembers = Object.values(savedMembers).sort((a, b) =>
                        a.name.localeCompare(b.name, 'id', {
                            sensitivity: 'base'
                        })
                    );
                    sortedMembers.forEach((member, idx) => {
                        const actionRow = `
                    <tr data-name="${member.name.toLowerCase()}">
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
                    // Attach listener tombol di Step 4
                    document.querySelectorAll('.btn-edit-member').forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const index = this.getAttribute('data-index');
                            editMember(index);
                        });
                    });
                    document.querySelectorAll('.btn-delete-member').forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const index = this.getAttribute('data-index');
                            deleteMemberByIndex(index);
                        });
                    });
                }

                // Setup search di Step 4
                function setupSearch() {
                    const searchInput = document.getElementById('member-search');
                    searchInput.addEventListener('input', function() {
                        const query = this.value.toLowerCase().trim();
                        const rows = document.querySelectorAll('#confirmation-table-body tr');
                        rows.forEach(row => {
                            const name = row.getAttribute('data-name');
                            row.style.display = name.includes(query) ? '' : 'none';
                        });
                    });
                }

                // Edit anggota dari Step 4 (perbaikan: buat card baru jika belum ada di Step 3)
                function editMember(index) {
                    currentStep = 3;
                    updateStepDisplay();
                    let memberCard = document.querySelector(`.member-card[data-member="${index}"]`);
                    if (!memberCard) {
                        // Buat card baru jika belum ada
                        memberCard = createMemberCard(index);
                        document.getElementById('member-container').appendChild(memberCard);
                        attachMemberEventListeners(memberCard);
                        memberCount = Math.max(memberCount, parseInt(index) + 1);
                        updateRemoveButtons();
                    }
                    // Isi data
                    memberCard.querySelector('.member-name').value = savedMembers[index].name;
                    memberCard.querySelector('input[type="date"]').value = savedMembers[index].signature_date;
                    const uploadInfo = memberCard.querySelector('.file-upload-info');
                    const fileNameSpan = uploadInfo.querySelector('.file-name');
                    fileNameSpan.textContent = savedMembers[index].file_name;
                    uploadInfo.style.display = 'flex';
                    memberCard.querySelector('.file-upload-label').style.display = 'none';
                    memberCard.querySelector('.file-upload-area').classList.add('has-file');
                    memberCard.querySelector('.btn-save-member').textContent = 'Re-Save jika Ganti';
                    memberCard.setAttribute('data-saved', 'true');

                    // Fokus ke card
                    memberCard.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    memberCard.style.backgroundColor = 'var(--primary-bg)';
                    setTimeout(() => memberCard.style.backgroundColor = '', 2000);

                    Swal.fire({
                        icon: 'info',
                        title: 'Edit Anggota',
                        text: 'Edit data lalu klik "Re-Save jika Ganti" untuk update.',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#4f46e5'
                    });
                }

                // Hapus anggota dari server (digunakan di Step 3 dan 4)
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
                                            text: 'Anggota berhasil dihapus.'
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
                                        text: 'Terjadi kesalahan koneksi.'
                                    });
                                });
                        }
                    });
                }

                // Handle submit form
                function handleFormSubmit(e) {
                    e.preventDefault();
                    if (Object.keys(savedMembers).length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Anggota Kosong',
                            text: 'Save minimal 1 anggota di Step 3.'
                        });
                        return;
                    }
                    if (!validateAllSteps()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Form Tidak Valid',
                            text: 'Periksa semua data.'
                        });
                        return;
                    }
                    const projectName = document.getElementById('project_name').value;
                    Swal.fire({
                        title: 'Konfirmasi Pembuatan Proyek',
                        html: `<div style="text-align: left; margin: 1rem 0;"><p><strong>Nama Proyek:</strong> ${projectName}</p><p><strong>Jumlah Anggota:</strong> ${Object.keys(savedMembers).length} orang</p><p style="margin-top: 1rem; color: #6b7280; font-size: 0.9rem;">Pastikan semua data benar.</p></div>`,
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
                        }
                    });
                }

                // Submit form ke server
                function submitForm() {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise loading-spin me-2"></i>Membuat Proyek...';
                    Swal.fire({
                        title: 'Membuat Proyek',
                        html: '<div style="padding: 2rem 0;"><div class="d-flex justify-content-center mb-3"><div class="spinner-border text-primary" role="status"></div></div><p>Mohon tunggu...</p></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                    // Submit form, dan setelah sukses (asumsi route handle clear temp), clear local
                    form.submit();
                    // Jika submit sukses (handle di backend), tambahkan di backend untuk clear localStorage via JS jika perlu
                    localStorage.removeItem('nda-project-draft');
                    localStorage.removeItem('nda-members-draft');
                }

                // Validasi semua step sebelum submit
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

                // Inisialisasi pertama
                const firstMemberCard = document.querySelector('.member-card[data-member="0"]');
                if (firstMemberCard) attachMemberEventListeners(firstMemberCard);
                updateRemoveButtons();
                initializeTooltips();
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
