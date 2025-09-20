@extends('layouts.app')

@section('title', 'Edit Proyek')

@section('content')
    <div class="main-container">
        <!-- Header Section -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-text">
                    <h1 class="page-title">Edit Proyek</h1>
                    <p class="page-subtitle">Perbarui informasi dan pengaturan proyek NDA dengan mudah dan cepat</p>
                </div>
                <div class="header-action">
                    <a href="{{ route('pegawai.dashboard') }}" class="btn btn-secondary btn-back">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Project Status Banner -->
        <div class="status-banner">
            <div class="status-content">
                <div class="status-info">
                    <div class="status-icon">
                        <i class="bi bi-folder-open"></i>
                    </div>
                    <div class="status-details">
                        <h3 class="status-title">{{ $nda->project_name }}</h3>
                        <div class="status-meta">
                            <span class="meta-item">
                                <i class="bi bi-calendar-event me-1"></i>
                                @if ($nda->start_date && $nda->end_date)
                                    {{ $nda->start_date->translatedFormat('d M Y') }} -
                                    {{ $nda->end_date->translatedFormat('d M Y') }}
                                @else
                                    Timeline belum diatur
                                @endif
                            </span>
                            <span class="meta-item">
                                <i class="bi bi-people me-1"></i>
                                {{ is_array($nda->members) ? count($nda->members) : (is_string($nda->members) ? count(json_decode($nda->members, true) ?? []) : 0) }}
                                Anggota
                            </span>
                            <span class="meta-item nda-status-indicator">
                                @if ($nda->nda_signature_date)
                                    <i class="bi bi-shield-check me-1 text-success"></i>
                                    NDA Ditandatangani
                                @else
                                    <i class="bi bi-shield-exclamation me-1 text-warning"></i>
                                    NDA Belum Ditandatangani
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="status-actions">
                    <div class="quick-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ $nda->files->count() }}</div>
                            <div class="stat-label">Berkas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Edit Form -->
        <div class="form-container">
            <form method="POST" action="{{ route('pegawai.nda.update', $nda) }}" enctype="multipart/form-data"
                id="projectForm">
                @csrf
                @method('PUT')

                <!-- Section 1: Basic Information -->
                <div class="form-section">
                    <div class="section-card">
                        <div class="section-header">
                            <div class="section-icon section-icon-info">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div class="section-content">
                                <h3 class="section-title">Informasi Dasar</h3>
                                <p class="section-description">Perbarui nama dan deskripsi proyek</p>
                            </div>
                        </div>

                        <div class="section-body">
                            <div class="form-grid">
                                <div class="form-field col-span-2">
                                    <label for="project_name" class="field-label required">Nama Proyek</label>
                                    <div class="field-wrapper">
                                        <div class="field-icon">
                                            <i class="bi bi-folder"></i>
                                        </div>
                                        <input type="text" name="project_name" id="project_name"
                                            class="field-input @error('project_name') field-error @enderror"
                                            value="{{ old('project_name', $nda->project_name) }}"
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
                                            rows="4" placeholder="Deskripsikan tujuan, lingkup, dan detail penting dari proyek ini..." maxlength="1000">{{ old('description', $nda->description) }}</textarea>
                                        <div class="textarea-counter">
                                            <span
                                                id="descriptionCount">{{ strlen(old('description', $nda->description ?? '')) }}</span>/1000
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

                <!-- Section 2: Timeline -->
                <div class="form-section">
                    <div class="section-card">
                        <div class="section-header">
                            <div class="section-icon section-icon-warning">
                                <i class="bi bi-calendar-range"></i>
                            </div>
                            <div class="section-content">
                                <h3 class="section-title">Timeline Proyek</h3>
                                <p class="section-description">Perbarui periode pelaksanaan proyek</p>
                            </div>
                        </div>

                        <div class="section-body">
                            <div class="form-grid">
                                <div class="form-field">
                                    <label for="start_date" class="field-label required">Tanggal Mulai</label>
                                    <div class="field-wrapper">
                                        <div class="field-icon">
                                            <i class="bi bi-calendar-event"></i>
                                        </div>
                                        <input type="date" name="start_date" id="start_date"
                                            class="field-input @error('start_date') field-error @enderror"
                                            value="{{ old('start_date', $nda->start_date ? $nda->start_date->format('Y-m-d') : '') }}"
                                            required>
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
                                            value="{{ old('end_date', $nda->end_date ? $nda->end_date->format('Y-m-d') : '') }}"
                                            required>
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
                                    <div class="duration-value" id="duration-text">
                                        {{ $nda->formatted_duration ?? 'Akan dihitung otomatis' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: NDA Information -->
                <div class="form-section">
                    <div class="section-card">
                        <div class="section-header">
                            <div class="section-icon section-icon-success">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="section-content">
                                <h3 class="section-title">Informasi NDA</h3>
                                <p class="section-description">Detail terkait Non-Disclosure Agreement</p>
                            </div>
                        </div>

                        <div class="section-body">
                            <div class="form-grid">
                                <div class="form-field">
                                    <label for="nda_signature_date" class="field-label required">Tanggal Penandatanganan
                                        NDA</label>
                                    <div class="field-wrapper">
                                        <div class="field-icon">
                                            <i class="bi bi-pen"></i>
                                        </div>
                                        <input type="date" name="nda_signature_date" id="nda_signature_date"
                                            class="field-input @error('nda_signature_date') field-error @enderror"
                                            value="{{ old('nda_signature_date', $nda->nda_signature_date ? $nda->nda_signature_date->format('Y-m-d') : '') }}"
                                            required>
                                    </div>
                                    @error('nda_signature_date')
                                        <div class="field-feedback field-feedback-error">{{ $message }}</div>
                                    @else
                                        <div class="field-hint">Tanggal ketika NDA resmi ditandatangani</div>
                                    @enderror
                                </div>

                                <div class="form-field">
                                    <div class="nda-status-card" id="nda-status-card">
                                        <div class="status-icon status-icon-success">
                                            <i class="bi bi-shield-check"></i>
                                        </div>
                                        <div class="status-content">
                                            <div class="status-label">Status NDA Saat Ini</div>
                                            <div class="status-value" id="nda-status-text">
                                                @if ($nda->nda_signature_date)
                                                    Ditandatangani pada
                                                    {{ $nda->nda_signature_date->translatedFormat('d F Y') }}
                                                @else
                                                    Belum ditandatangani
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Team & Files -->
                <div class="form-section">
                    <div class="section-card">
                        <div class="section-header">
                            <div class="section-icon section-icon-primary">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="section-content">
                                <h3 class="section-title">Anggota Tim & Berkas NDA</h3>
                                <p class="section-description">Perbarui anggota tim dan berkas NDA yang diperlukan</p>
                            </div>
                            <div class="section-action">
                                <button type="button" class="btn btn-primary btn-add-member" id="add-member">
                                    <i class="bi bi-person-plus me-2"></i>
                                    Tambah Anggota
                                </button>
                            </div>
                        </div>

                        <div class="section-body">
                            <div class="members-container" id="member-container">
                                @php
                                    $members = is_array($nda->members) ? $nda->members : [];
                                    if (is_string($nda->members)) {
                                        $members = json_decode($nda->members, true) ?? [];
                                    }
                                    $membersWithFiles = [];
                                    foreach ($members as $index => $member) {
                                        $file = null;
                                        if (isset($member['file_id'])) {
                                            $file = $nda->files->firstWhere('id', $member['file_id']);
                                        }
                                        $membersWithFiles[] = [
                                            'name' => $member['name'] ?? '',
                                            'file' => $file,
                                            'file_id' => $member['file_id'] ?? null,
                                        ];
                                    }
                                @endphp

                                @forelse ($membersWithFiles as $index => $member)
                                    @if ($errors->has("files.{$index}"))
                                        <div class="field-feedback field-feedback-error">
                                            {{ $errors->first("files.{$index}") }}</div>
                                    @endif
                                    <div class="member-card" data-member="{{ $index }}">
                                        <div class="member-header">
                                            <div class="member-avatar">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div class="member-info">
                                                <div class="member-label">Anggota{{ $index + 1 }}</div>
                                            </div>
                                            <button type="button" class="btn-remove-member"
                                                style="{{ count($membersWithFiles) > 1 ? '' : 'display: none;' }}">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                        <div class="member-body">
                                            <div class="member-fields">
                                                <div class="member-field">
                                                    <label class="field-label required">Nama Lengkap</label>
                                                    <div class="field-wrapper">
                                                        <input type="text" name="members[{{ $index }}][name]"
                                                            class="field-input member-name"
                                                            value="{{ old('members.' . $index . '.name', $member['name'] ?? '') }}"
                                                            placeholder="Masukkan nama lengkap anggota tim"
                                                            maxlength="100" required>
                                                    </div>
                                                </div>
                                                <div class="member-field">
                                                    <label class="field-label">Berkas NDA (PDF)</label>

                                                    @if (isset($member['file']) && $member['file'])
                                                        <!-- Existing File Display -->
                                                        <div class="existing-file-display"
                                                            id="existing-file-{{ $index }}">
                                                            <div class="file-card">
                                                                <div class="file-info">
                                                                    <div class="file-icon">
                                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                                    </div>
                                                                    <div class="file-details">
                                                                        <div class="file-name">
                                                                            {{ basename($member['file']->file_path) }}
                                                                        </div>
                                                                        <div class="file-actions">
                                                                            <a href="{{ Storage::url($member['file']->file_path) }}"
                                                                                target="_blank" class="file-action-link">
                                                                                <i class="bi bi-eye me-1"></i>Lihat File
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="file-replace-option">
                                                                    <label class="replace-checkbox">
                                                                        <input type="checkbox"
                                                                            class="replace-file-checkbox"
                                                                            data-member="{{ $index }}">
                                                                        <span class="checkmark"></span>
                                                                        <span class="checkbox-label">Ganti file</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- File Upload Area (hidden if existing file and not replacing) -->
                                                    <div class="file-upload-area" id="file-upload-{{ $index }}"
                                                        style="{{ isset($member['file']) && $member['file'] ? 'display: none;' : '' }}">
                                                        <input type="file" name="files[{{ $index }}]"
                                                            class="file-input" id="file-{{ $index }}"
                                                            accept="application/pdf"
                                                            {{ !isset($member['file']) || !$member['file'] ? 'required' : '' }}>
                                                        <label for="file-{{ $index }}" class="file-upload-label">
                                                            <div class="file-upload-icon">
                                                                <i class="bi bi-cloud-upload"></i>
                                                            </div>
                                                            <div class="file-upload-text">
                                                                <div class="file-upload-title">
                                                                    {{ isset($member['file']) && $member['file'] ? 'Pilih File Pengganti' : 'Pilih atau Seret File PDF' }}
                                                                </div>
                                                                <div class="file-upload-subtitle">Maksimal 10MB</div>
                                                            </div>
                                                        </label>
                                                        <div class="file-upload-info" style="display: none;">
                                                            <div class="file-info">
                                                                <i class="bi bi-file-earmark-pdf"></i>
                                                                <span class="file-name"></span>
                                                            </div>
                                                            <button type="button" class="btn-remove-file">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    @error("files.{$index}")
                                                        <div class="field-feedback field-feedback-error">{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <!-- Fallback if no members -->
                                    <div class="member-card" data-member="0">
                                        <div class="member-header">
                                            <div class="member-avatar">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div class="member-info">
                                                <div class="member-label">Anggota</div>
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
                                                            placeholder="Masukkan nama lengkap anggota tim"
                                                            maxlength="100" required>
                                                    </div>
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
                                                                <div class="file-upload-title">Pilih atau Seret File PDF
                                                                </div>
                                                                <div class="file-upload-subtitle">Maksimal 2MB</div>
                                                            </div>
                                                        </label>
                                                        <div class="file-upload-info" style="display: none;">
                                                            <div class="file-info">
                                                                <i class="bi bi-file-earmark-pdf"></i>
                                                                <span class="file-name"></span>
                                                            </div>
                                                            <button type="button" class="btn-remove-file">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <div class="members-hint">
                                <div class="hint-icon">
                                    <i class="bi bi-info-circle"></i>
                                </div>
                                <div class="hint-text">
                                    Setiap anggota tim harus memiliki berkas NDA dalam format PDF.
                                    File yang sudah ada bisa dipertahankan atau diganti dengan yang baru.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-navigation">
                    <div class="nav-buttons">
                        <a href="{{ route('pegawai.dashboard') }}" class="btn btn-secondary btn-nav">
                            <i class="bi bi-x-circle me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-success btn-nav" id="submitBtn">
                            <i class="bi bi-check-circle me-2"></i>
                            Perbarui Proyek
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <style>
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

            /* Status Banner */
            .status-banner {
                background: linear-gradient(135deg, var(--primary-bg) 0%, var(--info-bg) 100%);
                border: 1px solid var(--gray-200);
                border-radius: var(--radius-xl);
                padding: 2rem;
                margin-bottom: 2rem;
                box-shadow: var(--shadow-sm);
            }

            .status-content {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 2rem;
            }

            .status-info {
                display: flex;
                align-items: flex-start;
                gap: 1.5rem;
                flex: 1;
            }

            .status-icon {
                width: 4rem;
                height: 4rem;
                background: white;
                color: var(--primary);
                border-radius: var(--radius-lg);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                flex-shrink: 0;
                box-shadow: var(--shadow-sm);
            }

            .status-details {
                flex: 1;
            }

            .status-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--gray-900);
                margin: 0 0 0.75rem 0;
                line-height: 1.2;
            }

            .status-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 1.5rem;
            }


            .nda-status-indicator.text-warning {
                color: var(--warning-dark) !important;
            }

            .status-actions {
                display: flex;
                align-items: center;
            }

            .quick-stats {
                display: flex;
                gap: 1.5rem;
            }

            .stat-item {
                text-align: center;
                padding: 1rem;
                background: white;
                border-radius: var(--radius);
                box-shadow: var(--shadow-xs);
                min-width: 80px;
            }

            .stat-number {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--primary);
                line-height: 1;
                margin-bottom: 0.25rem;
            }

            .stat-label {
                font-size: 0.75rem;
                color: var(--gray-600);
                font-weight: 500;
            }

            /* Form Container */
            .form-container {
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }

            /* Form Sections */
            .form-section {
                display: flex;
                flex-direction: column;
            }

            .section-card {
                background: white;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-sm);
                border: 1px solid var(--gray-200);
                overflow: hidden;
                transition: var(--transition);
            }

            .section-card:hover {
                box-shadow: var(--shadow-md);
            }

            .section-header {
                display: flex;
                align-items: flex-start;
                gap: 1.5rem;
                padding: 2rem 2.5rem;
                border-bottom: 1px solid var(--gray-200);
                background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            }

            .section-icon {
                width: 3.5rem;
                height: 3.5rem;
                border-radius: var(--radius-lg);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                flex-shrink: 0;
            }

            .section-icon-primary {
                background: var(--primary-bg);
                color: var(--primary);
            }

            .section-icon-success {
                background: var(--success-bg);
                color: var(--success);
            }

            .section-icon-warning {
                background: var(--warning-bg);
                color: var(--warning);
            }

            .section-icon-info {
                background: var(--info-bg);
                color: var(--info);
            }

            .section-content {
                flex: 1;
            }

            .section-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--gray-900);
                margin: 0 0 0.5rem 0;
            }

            .section-description {
                font-size: 1rem;
                color: var(--gray-600);
                margin: 0;
                line-height: 1.5;
            }

            .section-action {
                display: flex;
                align-items: center;
            }

            .section-body {
                padding: 2.5rem;
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
                background: var(--success-bg);
                border: 1px solid var(--success);
                border-radius: var(--radius-lg);
                padding: 1.5rem;
                display: flex;
                align-items: center;
                gap: 1rem;
                transition: var(--transition);
            }

            .nda-status-card.status-warning {
                background: var(--warning-bg);
                border-color: var(--warning);
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

            .status-icon-success {
                background: var(--success);
                color: white;
            }

            .status-icon-warning {
                background: var(--warning);
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

            /* Existing File Display */
            .existing-file-display {
                margin-bottom: 1rem;
            }

            .file-card {
                background: white;
                border: 1px solid var(--gray-200);
                border-radius: var(--radius);
                padding: 1rem;
                transition: var(--transition);
            }

            .file-card:hover {
                border-color: var(--gray-300);
                box-shadow: var(--shadow-sm);
            }

            .file-info {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .file-icon {
                width: 2.5rem;
                height: 2.5rem;
                background: var(--danger-bg);
                color: var(--danger);
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.125rem;
                flex-shrink: 0;
            }

            .file-details {
                flex: 1;
            }

            .file-name {
                font-size: 0.875rem;
                font-weight: 600;
                color: var(--gray-900);
                margin-bottom: 0.5rem;
            }

            .file-actions {
                display: flex;
                gap: 0.75rem;
            }

            .file-action-link {
                font-size: 0.75rem;
                color: var(--primary);
                text-decoration: none;
                font-weight: 500;
                display: flex;
                align-items: center;
                transition: var(--transition);
            }

            .file-action-link:hover {
                color: var(--primary-dark);
                text-decoration: underline;
            }

            .file-replace-option {
                border-top: 1px solid var(--gray-200);
                padding-top: 1rem;
            }

            .replace-checkbox {
                display: flex;
                align-items: center;
                cursor: pointer;
                gap: 0.5rem;
            }

            .replace-checkbox input[type="checkbox"] {
                display: none;
            }

            .checkmark {
                width: 18px;
                height: 18px;
                border: 2px solid var(--gray-300);
                border-radius: 4px;
                position: relative;
                transition: var(--transition);
            }

            .replace-checkbox input[type="checkbox"]:checked+.checkmark {
                background: var(--primary);
                border-color: var(--primary);
            }

            .replace-checkbox input[type="checkbox"]:checked+.checkmark::after {
                content: '';
                position: absolute;
                left: 3px;
                top: 0px;
                width: 6px;
                height: 10px;
                border: 2px solid white;
                border-top: 0;
                border-left: 0;
                transform: rotate(45deg);
            }

            .checkbox-label {
                font-size: 0.875rem;
                color: var(--gray-700);
                font-weight: 500;
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
                border-radius: var(--radius-xl);
                margin-top: 1rem;
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

                .section-header,
                .section-body {
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

                .status-content {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1.5rem;
                }

                .status-meta {
                    gap: 1rem;
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

                .status-banner {
                    padding: 1.5rem;
                }

                .status-info {
                    flex-direction: column;
                    text-align: center;
                    gap: 1rem;
                }

                .status-icon {
                    width: 3rem;
                    height: 3rem;
                    font-size: 1.25rem;
                }

                .status-title {
                    font-size: 1.25rem;
                }

                .status-meta {
                    flex-direction: column;
                    gap: 0.75rem;
                    align-items: center;
                }

                .section-header {
                    flex-direction: column;
                    text-align: center;
                    gap: 1rem;
                    padding: 1.5rem;
                }

                .section-body {
                    padding: 1.5rem;
                }

                .section-title {
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

                .header-content,
                .status-banner {
                    padding: 1rem;
                }

                .page-title {
                    font-size: 1.5rem;
                }

                .section-header,
                .section-body {
                    padding: 1rem;
                }

                .section-icon {
                    width: 3rem;
                    height: 3rem;
                    font-size: 1.25rem;
                }

                .section-title {
                    font-size: 1.125rem;
                }

                .section-description {
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
            .file-input:focus-visible+.file-upload-label,
            .replace-checkbox:focus-visible .checkmark {
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

            .file-upload-area.field-error {
                border-color: var(--danger) !important;
                background: var(--danger-bg);
            }

            .file-upload-area.field-error .file-upload-label {
                border-color: var(--danger);
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Calculate initial member count safely
                let memberCount = @php
                    $memberCount = 0;
                    if (is_array($nda->members)) {
                        echo count($nda->members);
                    } elseif (is_string($nda->members) && json_decode($nda->members) !== null) {
                        echo count(json_decode($nda->members, true));
                    } else {
                        echo 1;
                    }
                @endphp;

                // Initialize character counter
                initializeCharacterCounter();
                // Initialize all event listeners
                initializeEventListeners();
                // Initialize file replacement toggles
                initializeFileReplacementToggles();
                // Set up form validation
                setupFormValidation();
                // Initialize remove buttons for existing members
                initializeRemoveButtons();
                // Update UI on load
                updateRemoveButtons();
                attachFileValidationToAll();
                calculateDuration();
                updateNDAStatus();

                function initializeCharacterCounter() {
                    const descriptionTextarea = document.getElementById('description');
                    const descriptionCounter = document.getElementById('descriptionCount');
                    if (descriptionTextarea && descriptionCounter) {
                        const updateCount = () => {
                            const count = descriptionTextarea.value.length;
                            descriptionCounter.textContent = count;
                            if (count > 900) {
                                descriptionCounter.style.color = 'var(--danger)';
                            } else if (count > 700) {
                                descriptionCounter.style.color = 'var(--warning)';
                            } else {
                                descriptionCounter.style.color = 'var(--gray-500)';
                            }
                        };
                        descriptionTextarea.addEventListener('input', updateCount);
                        updateCount();
                    }
                }

                function initializeEventListeners() {
                    document.getElementById('start_date').addEventListener('change', calculateDuration);
                    document.getElementById('end_date').addEventListener('change', calculateDuration);
                    document.getElementById('nda_signature_date').addEventListener('change', updateNDAStatus);
                    document.getElementById('add-member').addEventListener('click', addMember);
                    document.getElementById('projectForm').addEventListener('submit', handleFormSubmit);
                }

                function initializeFileReplacementToggles() {
                    document.querySelectorAll('.replace-file-checkbox').forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            const memberIndex = this.dataset.member;
                            const existingFileDiv = document.getElementById(
                                `existing-file-${memberIndex}`);
                            const uploadDiv = document.getElementById(`file-upload-${memberIndex}`);
                            const fileInput = document.querySelector(
                                `input[name="files[${memberIndex}]"]`);
                            if (this.checked) {
                                existingFileDiv.style.display = 'none';
                                uploadDiv.style.display = 'block';
                                fileInput.required = true;
                                uploadDiv.classList.add('slide-in');
                                setTimeout(() => uploadDiv.classList.remove('slide-in'), 300);
                            } else {
                                existingFileDiv.style.display = 'block';
                                uploadDiv.style.display = 'none';
                                fileInput.required = false;
                                fileInput.value = '';
                                const uploadLabel = uploadDiv.querySelector('.file-upload-label');
                                const uploadInfo = uploadDiv.querySelector('.file-upload-info');
                                if (uploadLabel && uploadInfo) {
                                    uploadLabel.style.display = 'flex';
                                    uploadInfo.style.display = 'none';
                                }
                                existingFileDiv.classList.add('slide-in');
                                setTimeout(() => existingFileDiv.classList.remove('slide-in'), 300);
                            }
                        });
                    });
                }

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
                            <div class="member-label">Anggota ${index + 1}</div>
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
                                    <input type="text" name="members[${index}][name]" class="field-input member-name"
                                           placeholder="Masukkan nama lengkap anggota tim" maxlength="100" required>
                                </div>
                            </div>
                            <div class="member-field">
                                <label class="field-label required">Berkas NDA (PDF)</label>
                                <div class="file-upload-area">
                                    <input type="file" name="files[${index}]" class="file-input" id="file-${index}"
                                           accept="application/pdf" required>
                                    <label for="file-${index}" class="file-upload-label">
                                        <div class="file-upload-icon">
                                            <i class="bi bi-cloud-upload"></i>
                                        </div>
                                        <div class="file-upload-text">
                                            <div class="file-upload-title">Pilih atau Seret File PDF</div>
                                            <div class="file-upload-subtitle">Maksimal 10MB</div> <!-- Ubah di sini -->
                                        </div>
                                    </label>
                                    <div class="file-upload-info" style="display: none;">
                                        <div class="file-info">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                            <span class="file-name"></span>
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

                function attachMemberEventListeners(memberCard) {
                    const removeBtn = memberCard.querySelector('.btn-remove-member');
                    const fileInput = memberCard.querySelector('.file-input');
                    const nameInput = memberCard.querySelector('.member-name');
                    removeBtn.addEventListener('click', () => removeMember(memberCard));
                    fileInput.addEventListener('change', (e) => handleFileUpload(e.target));
                    const removeFileBtn = memberCard.querySelector('.btn-remove-file');
                    if (removeFileBtn) {
                        removeFileBtn.addEventListener('click', () => removeFile(fileInput));
                    }
                    nameInput.addEventListener('blur', () => validateField(nameInput));
                    nameInput.addEventListener('input', () => {
                        if (nameInput.classList.contains('field-error') && nameInput.value.trim()) {
                            nameInput.classList.remove('field-error');
                        }
                    });
                    fileInput.addEventListener('change', () => validateField(fileInput));
                }

                function initializeRemoveButtons() {
                    document.querySelectorAll('.btn-remove-member').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const memberCard = this.closest('.member-card');
                            removeMember(memberCard);
                        });
                    });
                }

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
                            memberCard.style.opacity = '0';
                            memberCard.style.transform = 'translateX(-20px)';
                            setTimeout(() => {
                                memberCard.remove();
                                memberCount--;
                                reindexMembers();
                                updateRemoveButtons();
                            }, 300);
                        }
                    });
                }

                function updateRemoveButtons() {
                    const memberCards = document.querySelectorAll('.member-card');
                    memberCards.forEach((card, index) => {
                        const removeBtn = card.querySelector('.btn-remove-member');
                        if (removeBtn) {
                            removeBtn.style.display = memberCards.length > 1 ? 'flex' : 'none';
                        }
                    });
                }

                function reindexMembers() {
                    const memberCards = document.querySelectorAll('.member-card');
                    memberCards.forEach((card, index) => {
                        card.setAttribute('data-member', index);
                        card.querySelector('.member-label').textContent = `Anggota ${index + 1}`;
                        const nameInput = card.querySelector('.member-name');
                        const fileInput = card.querySelector('.file-input');
                        const fileLabel = card.querySelector('.file-upload-label');
                        if (nameInput) nameInput.name = `members[${index}][name]`;
                        if (fileInput) {
                            fileInput.name = `files[${index}]`;
                            fileInput.id = `file-${index}`;
                            if (fileLabel) fileLabel.setAttribute('for', `file-${index}`);
                        }
                        // Reattach event listeners for file replacement toggles
                        const replaceCheckbox = card.querySelector('.replace-file-checkbox');
                        if (replaceCheckbox) {
                            replaceCheckbox.dataset.member = index;
                            replaceCheckbox.removeEventListener('change', initializeFileReplacementToggles);
                            replaceCheckbox.addEventListener('change', function() {
                                const memberIndex = this.dataset.member;
                                const existingFileDiv = document.getElementById(
                                    `existing-file-${memberIndex}`);
                                const uploadDiv = document.getElementById(`file-upload-${memberIndex}`);
                                const fileInput = document.querySelector(
                                    `input[name="files[${memberIndex}]"]`);
                                if (this.checked) {
                                    existingFileDiv.style.display = 'none';
                                    uploadDiv.style.display = 'block';
                                    fileInput.required = true;
                                    uploadDiv.classList.add('slide-in');
                                    setTimeout(() => uploadDiv.classList.remove('slide-in'), 300);
                                } else {
                                    existingFileDiv.style.display = 'block';
                                    uploadDiv.style.display = 'none';
                                    fileInput.required = false;
                                    fileInput.value = '';
                                    const uploadLabel = uploadDiv.querySelector('.file-upload-label');
                                    const uploadInfo = uploadDiv.querySelector('.file-upload-info');
                                    if (uploadLabel && uploadInfo) {
                                        uploadLabel.style.display = 'flex';
                                        uploadInfo.style.display = 'none';
                                    }
                                    existingFileDiv.classList.add('slide-in');
                                    setTimeout(() => existingFileDiv.classList.remove('slide-in'), 300);
                                }
                            });
                        }
                    });
                }

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

                function updateNDAStatus() {
                    const ndaDate = document.getElementById('nda_signature_date').value;
                    const statusCard = document.getElementById('nda-status-card');
                    const statusIcon = statusCard.querySelector('.status-icon i');
                    const statusText = document.getElementById('nda-status-text');
                    if (ndaDate) {
                        statusCard.className = 'nda-status-card';
                        statusCard.querySelector('.status-icon').className = 'status-icon status-icon-success';
                        statusIcon.className = 'bi bi-shield-check';
                        statusText.textContent = `Ditandatangani pada ${formatDate(ndaDate)}`;
                        statusCard.classList.add('slide-in');
                        setTimeout(() => statusCard.classList.remove('slide-in'), 300);
                    } else {
                        statusCard.className = 'nda-status-card status-warning';
                        statusCard.querySelector('.status-icon').className = 'status-icon status-icon-warning';
                        statusIcon.className = 'bi bi-shield-exclamation';
                        statusText.textContent = 'Belum ditandatangani';
                    }
                }

                function formatDate(dateString) {
                    const date = new Date(dateString);
                    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                        'September', 'Oktober', 'November', 'Desember'
                    ];
                    return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
                }

                function handleFileUpload(fileInput) {
                    const file = fileInput.files[0];
                    const uploadArea = fileInput.closest('.file-upload-area');
                    const uploadLabel = uploadArea.querySelector('.file-upload-label');
                    const uploadInfo = uploadArea.querySelector('.file-upload-info');
                    const fileName = uploadInfo.querySelector('.file-name');
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
                    const maxSize = 10 * 1024 * 1024; // Ubah dari 2MB ke 10MB
                    if (file.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 10MB.', // Perbarui pesan error
                            confirmButtonText: 'Mengerti',
                            confirmButtonColor: '#4f46e5'
                        });
                        fileInput.value = '';
                        return;
                    }
                    fileName.textContent = file.name;
                    uploadLabel.style.display = 'none';
                    uploadInfo.style.display = 'flex';
                    uploadArea.classList.add('has-file');
                    fileInput.classList.remove('field-error');
                    uploadInfo.classList.add('fade-in');
                    setTimeout(() => uploadInfo.classList.remove('fade-in'), 300);
                }

                function removeFile(fileInput) {
                    const uploadArea = fileInput.closest('.file-upload-area');
                    const uploadLabel = uploadArea.querySelector('.file-upload-label');
                    const uploadInfo = uploadArea.querySelector('.file-upload-info');
                    fileInput.value = '';
                    uploadLabel.style.display = 'flex';
                    uploadInfo.style.display = 'none';
                    uploadArea.classList.remove('has-file');
                }

                function validateField(field) {
                    const value = field.type === 'file' ? field.files.length > 0 : field.value.trim();
                    const isValid = field.required ? !!value : true;
                    field.classList.toggle('field-error', !isValid);
                    return isValid;
                }

                function attachFileValidationToAll() {
                    document.querySelectorAll('.file-input').forEach(input => {
                        input.addEventListener('change', (e) => handleFileUpload(e.target));
                        const removeBtn = input.closest('.file-upload-area').querySelector('.btn-remove-file');
                        if (removeBtn) {
                            removeBtn.addEventListener('click', () => removeFile(input));
                        }
                    });
                }

                function setupFormValidation() {
                    document.querySelectorAll('input[required], textarea[required]').forEach(input => {
                        input.addEventListener('blur', () => validateField(input));
                        input.addEventListener('input', () => {
                            if (input.classList.contains('field-error') && input.value.trim()) {
                                input.classList.remove('field-error');
                            }
                        });
                    });
                }

                function validateForm() {
                    const form = document.getElementById('projectForm');
                    const inputs = form.querySelectorAll('input[required], textarea[required]');
                    let isValid = true;
                    let missingFiles = [];
                    inputs.forEach(input => {
                        if (!validateField(input)) {
                            isValid = false;
                        }
                    });
                    document.querySelectorAll('.member-card').forEach(card => {
                        const index = card.dataset.member;
                        const nameInput = card.querySelector('.member-name');
                        const fileInput = card.querySelector(`input[name="files[${index}]"]`);
                        const memberName = nameInput.value.trim();
                        let hasFile = false;
                        const existingDisplay = card.querySelector('.existing-file-display');
                        const replaceCheckbox = card.querySelector('.replace-file-checkbox');
                        if (existingDisplay && !replaceCheckbox?.checked) {
                            hasFile = true;
                        } else if (fileInput?.files.length > 0) {
                            hasFile = true;
                        }
                        if (!hasFile && memberName) {
                            missingFiles.push(memberName);
                            isValid = false;
                            const uploadArea = card.querySelector('.file-upload-area');
                            if (uploadArea) uploadArea.classList.add('field-error');
                        }
                    });
                    if (!isValid && missingFiles.length > 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Berkas NDA Tidak Lengkap',
                            html: `Member berikut belum punya berkas: <strong>${missingFiles.join(', ')}</strong><br>Silakan upload berkas PDF.`,
                            confirmButtonText: 'Perbaiki',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                    return isValid;
                }

                function handleFormSubmit(e) {
                    e.preventDefault();
                    if (!validateForm()) {
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
                        title: 'Konfirmasi Perubahan',
                        html: `
                    <div style="text-align: left; margin: 1rem 0;">
                        <p><strong>Proyek:</strong> ${projectName}</p>
                        <p><strong>Jumlah Anggota :</strong> ${memberCards.length} orang</p>
                        <p style="margin-top: 1rem; color: #6b7280; font-size: 0.9rem;">
                            Pastikan semua perubahan sudah benar sebelum menyimpan.
                        </p>
                    </div>
                `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Perbarui Proyek',
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

                function submitForm() {
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<i class="bi bi-arrow-clockwise loading-spin me-2"></i>Memperbarui Proyek...';
                    Swal.fire({
                        title: 'Memperbarui Proyek',
                        html: `
                    <div style="padding: 2rem 0;">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <p>Mohon tunggu, sedang memproses perubahan proyek dan berkas...</p>
                    </div>
                `,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal-modern-popup'
                        }
                    });
                    setTimeout(() => {
                        document.getElementById('projectForm').submit();
                    }, 1000);
                }

                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                        e.preventDefault();
                        handleFormSubmit(e);
                    }
                });
            });

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
        .text-success {
            color: #10b981 !important;
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
