@extends('layouts.app')

@section('title', 'Detail Proyek NDA')

@section('content')
    <div class="container-fluid py-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="h2 fw-bold text-gray-900 mb-2">Detail Proyek NDA</h1>
                <p class="text-muted mb-0">Informasi lengkap dan terperinci tentang proyek</p>
            </div>
            
        </div>

        <!-- Project Overview Card -->
        <div class="card border-0 shadow-sm rounded-3 mb-5">
            <div class="card-header bg-primary bg-gradient text-white p-4 border-bottom-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="project-icon bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-folder-fill fs-3 text-white"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1">{{ $nda->project_name }}</h3>
                        <div class="d-flex align-items-center gap-3 opacity-90">
                            <span class="badge bg-white bg-opacity-25 text-white px-3 py-2">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $nda->start_date ? $nda->start_date->translatedFormat('d M Y') : 'Belum ditentukan' }}
                            </span>
                            @if ($nda->end_date)
                                <span class="badge bg-white bg-opacity-25 text-white px-3 py-2">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    {{ $nda->end_date->translatedFormat('d M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Project Information -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white p-4 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="section-icon bg-info bg-opacity-10 rounded-2">
                                <i class="bi bi-info-circle text-info fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-1">Informasi Proyek</h5>
                                <p class="text-muted small mb-0">Detail dan spesifikasi proyek</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Project Name -->
                            <div class="col-12">
                                <div class="info-item">
                                    <label class="info-label">Nama Proyek</label>
                                    <div class="info-value">{{ $nda->project_name }}</div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <div class="info-item">
                                    <label class="info-label">Deskripsi Proyek</label>
                                    <div class="info-value">
                                        @if ($nda->description)
                                            <p class="mb-0">{{ $nda->description }}</p>
                                        @else
                                            <span class="text-muted">Tidak ada deskripsi</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline -->
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="info-label">Tanggal Mulai</label>
                                    <div class="info-value">
                                        @if ($nda->start_date)
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-calendar-event text-success"></i>
                                                <span>{{ $nda->start_date->translatedFormat('d F Y') }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">Belum ditentukan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="info-label">Tanggal Berakhir</label>
                                    <div class="info-value">
                                        @if ($nda->end_date)
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-calendar-check text-danger"></i>
                                                <span>{{ $nda->end_date->translatedFormat('d F Y') }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">Belum ditentukan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="info-label">Durasi Proyek</label>
                                    <div class="info-value">
                                        @if ($nda->formatted_duration)
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-clock text-primary"></i>
                                                <span>{{ $nda->formatted_duration }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">Belum dihitung</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- NDA Signature Date -->
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="info-label">Tanggal Penandatanganan NDA</label>
                                    <div class="info-value">
                                        @if ($nda->nda_signature_date)
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-pen text-success"></i>
                                                <span>{{ $nda->nda_signature_date->translatedFormat('d F Y') }}</span>
                                            </div>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                Belum ditandatangani
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Members with Individual Documents -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white p-4 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="section-icon bg-purple bg-opacity-10 rounded-2">
                                <i class="bi bi-people text-purple fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-1">Anggota Tim & Dokumen NDA</h5>
                                <p class="text-muted small mb-0">
                                    @php
                                        $memberCount = 0;
                                        if (is_array($nda->members)) {
                                            $memberCount = count($nda->members);
                                        } elseif (is_string($nda->members) && json_decode($nda->members) !== null) {
                                            $memberCount = count(json_decode($nda->members, true));
                                        }
                                    @endphp
                                    {{ $memberCount }} anggota terlibat dalam proyek
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $members = [];
                            if (is_array($nda->members)) {
                                $members = array_map(function ($member) {
                                    return is_array($member) && isset($member['name']) ? $member['name'] : $member;
                                }, $nda->members);
                            } elseif (is_string($nda->members) && json_decode($nda->members) !== null) {
                                $members = array_map(function ($member) {
                                    return is_array($member) && isset($member['name']) ? $member['name'] : $member;
                                }, json_decode($nda->members, true));
                            }
                        @endphp

                        @if (!empty($members))
                            <div class="members-list">
                                @foreach ($members as $index => $member)
                                    <div class="member-section mb-4">
                                        <!-- Member Info -->
                                        <div class="member-header d-flex align-items-center gap-3 p-4 bg-light rounded-3 mb-3">
                                            <div class="member-avatar bg-primary bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person text-primary fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="member-name fw-bold fs-5 text-gray-900">{{ $member }}</div>
                                                <div class="member-role text-muted">Anggota Tim {{ $index + 1 }}</div>
                                            </div>
                                            <div class="member-status">
                                                @php
                                                    // Get documents for this member
                                                    $memberFiles = $nda->files->filter(function($file) use ($member, $index) {
                                                        // Assuming there's a member_name or member_index field in files
                                                        // You might need to adjust this based on your actual database structure
                                                        return isset($file->member_name) && $file->member_name === $member ||
                                                               isset($file->member_index) && $file->member_index === $index ||
                                                               str_contains(strtolower($file->file_path), strtolower(str_replace(' ', '_', $member)));
                                                    });
                                                @endphp
                                                
                                                @if ($memberFiles->count() > 0)
                                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        {{ $memberFiles->count() }} Dokumen
                                                    </span>
                                                @else
                                                    
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Member Documents -->
                                        <div class="member-documents">
                                            @if ($memberFiles->count() > 0)
                                                <div class="documents-grid">
                                                    @foreach ($memberFiles as $file)
                                                        <div class="document-card border rounded-3 p-3 mb-3">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="document-icon bg-danger bg-opacity-10 rounded-2 p-2">
                                                                    <i class="bi bi-file-earmark-pdf text-danger fs-4"></i>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <div class="document-name fw-semibold text-gray-800 mb-1">
                                                                        {{ basename($file->file_path) }}
                                                                    </div>
                                                                    <div class="document-meta text-muted small">
                                                                        <i class="bi bi-calendar3 me-1"></i>
                                                                        Upload: {{ $file->created_at ? $file->created_at->translatedFormat('d M Y') : 'Tidak diketahui' }}
                                                                    </div>
                                                                </div>
                                                                <div class="document-actions">
                                                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                                                                        class="btn btn-sm btn-outline-primary rounded-2">
                                                                        <i class="bi bi-eye me-1"></i>Lihat
                                                                    </a>
                                                                    <a href="{{ Storage::url($file->file_path) }}" download
                                                                        class="btn btn-sm btn-outline-secondary rounded-2 ms-1">
                                                                        <i class="bi bi-download me-1"></i>Download
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="empty-documents text-center py-4 border rounded-3 bg-light bg-opacity-50">
                                                    <i class="bi bi-file-earmark-x text-muted fs-2 mb-2"></i>
                                                    <p class="text-muted mb-1">Belum ada dokumen NDA</p>
                                                    <small class="text-muted">{{ $member }} belum mengupload dokumen</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state text-center py-5">
                                <i class="bi bi-people text-muted fs-1"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada anggota tim yang ditambahkan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- NDA Status Card -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white p-4 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="section-icon bg-success bg-opacity-10 rounded-2">
                                <i class="bi bi-shield-check text-success fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-1">Status NDA</h5>
                                <p class="text-muted small mb-0">Status penandatanganan</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if ($nda->nda_signature_date)
                            <div class="status-item">
                                <div class="status-indicator bg-success bg-opacity-10 rounded-3 p-3 text-center">
                                    <i class="bi bi-check-circle-fill text-success fs-2"></i>
                                    <h6 class="fw-semibold text-success mt-2 mb-1">Sudah Ditandatangani</h6>
                                    <p class="small text-muted mb-0">
                                        {{ $nda->nda_signature_date->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="status-item">
                                <div class="status-indicator bg-warning bg-opacity-10 rounded-3 p-3 text-center">
                                    <i class="bi bi-exclamation-triangle-fill text-warning fs-2"></i>
                                    <h6 class="fw-semibold text-warning mt-2 mb-1">Belum Ditandatangani</h6>
                                    <p class="small text-muted mb-0">Menunggu penandatanganan</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white p-4 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="section-icon bg-info bg-opacity-10 rounded-2">
                                <i class="bi bi-graph-up text-info fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-1">Statistik Dokumen</h5>
                                <p class="text-muted small mb-0">Ringkasan status dokumen</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $totalMembers = count($members);
                            $membersWithDocs = 0;
                            $totalDocs = $nda->files->count();
                            
                            foreach ($members as $index => $member) {
                                $memberFiles = $nda->files->filter(function($file) use ($member, $index) {
                                    return isset($file->member_name) && $file->member_name === $member ||
                                           isset($file->member_index) && $file->member_index === $index ||
                                           str_contains(strtolower($file->file_path), strtolower(str_replace(' ', '_', $member)));
                                });
                                if ($memberFiles->count() > 0) {
                                    $membersWithDocs++;
                                }
                            }
                            
                            $completionPercentage = $totalMembers > 0 ? ($membersWithDocs / $totalMembers) * 100 : 0;
                        @endphp
                        
                        <div class="stats-grid">
                            <div class="stat-item text-center mb-3">
                                <div class="stat-number h3 fw-bold text-primary mb-1">{{ $totalDocs }}</div>
                                <div class="stat-label small text-muted">Total Dokumen</div>
                            </div>
                            
                            <div class="stat-item text-center mb-3">
                                <div class="stat-number h3 fw-bold text-success mb-1">{{ $membersWithDocs }}</div>
                                <div class="stat-label small text-muted">Sudah Upload</div>
                            </div>
                            
                           
                            
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-gradient" style="width: {{ $completionPercentage }}%"></div>
                            </div>
                            <div class="text-center small text-muted">
                                {{ round($completionPercentage) }}% Kelengkapan Dokumen
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white p-4 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="section-icon bg-primary bg-opacity-10 rounded-2">
                                <i class="bi bi-lightning text-primary fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold mb-1">Tindakan Cepat</h5>
                                <p class="text-muted small mb-0">Aksi yang tersedia</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('pegawai.nda.edit', $nda) }}" class="btn btn-warning btn-modern rounded-2">
                                <i class="bi bi-pencil-square me-2"></i>Edit Proyek
                            </a>
                            <form action="{{ route('pegawai.nda.delete', $nda) }}" method="POST"
                                class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-modern rounded-2 delete-single-btn w-100"
                                    data-project-name="{{ $nda->project_name }}">
                                    <i class="bi bi-trash me-2"></i>Hapus Proyek
                                </button>
                            </form>
                            <a href="{{ route('pegawai.dashboard') }}" class="btn btn-outline-secondary rounded-2">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
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

            /* Card Styling */
            .card {
                border-radius: var(--radius-lg);
                border: 1px solid var(--gray-200);
                box-shadow: var(--shadow);
                transition: all 0.3s ease;
            }

            .card:hover {
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            }

            .card-header {
                border-bottom: 1px solid var(--gray-200);
                background-color: white;
                padding: 1.5rem;
            }

            .bg-gradient {
                background: linear-gradient(135deg, var(--primary), #4f46e5);
            }

            /* Project Icon */
            .project-icon {
                width: 3rem;
                height: 3rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Section Icons */
            .section-icon {
                width: 2.5rem;
                height: 2.5rem;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.125rem;
            }

            /* Info Items */
            .info-item {
                margin-bottom: 1.5rem;
            }

            .info-item:last-child {
                margin-bottom: 0;
            }

            .info-label {
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--gray-600);
                margin-bottom: 0.5rem;
                display: block;
            }

            .info-value {
                font-size: 0.875rem;
                color: var(--gray-800);
                font-weight: 500;
            }

            /* Member Section Styling */
            .member-section {
                border-bottom: 1px solid var(--gray-200);
                padding-bottom: 1.5rem;
            }

            .member-section:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }

            .member-header {
                background: linear-gradient(135deg, var(--gray-50), #ffffff);
                border: 1px solid var(--gray-200);
                transition: all 0.3s ease;
            }

            .member-header:hover {
                box-shadow: var(--shadow-sm);
                transform: translateY(-1px);
            }

            .member-avatar {
                width: 3rem;
                height: 3rem;
                border-radius: 50%;
                font-size: 1.25rem;
            }

            .member-name {
                font-size: 1.125rem;
                color: var(--gray-900);
            }

            .member-role {
                font-size: 0.875rem;
            }

            /* Document Card Styling */
            .document-card {
                border: 1px solid var(--gray-200);
                background: white;
                transition: all 0.2s ease;
            }

            .document-card:hover {
                border-color: var(--primary);
                box-shadow: var(--shadow-sm);
                transform: translateY(-1px);
            }

            .document-icon {
                width: 2.5rem;
                height: 2.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .document-name {
                color: var(--gray-800);
                font-weight: 600;
            }

            .document-meta {
                color: var(--gray-500);
            }

            /* Empty Documents */
            .empty-documents {
                border: 2px dashed var(--gray-300);
                transition: all 0.3s ease;
            }

            .empty-documents:hover {
                border-color: var(--gray-400);
                background-color: var(--gray-100);
            }

            /* Status Indicators */
            .status-indicator {
                transition: all 0.3s ease;
            }

            .status-indicator:hover {
                transform: translateY(-2px);
            }

            /* Statistics */
            .stats-grid {
                text-align: center;
            }

            .stat-item {
                padding: 1rem;
                border-radius: var(--radius);
                background: var(--gray-50);
                margin-bottom: 1rem;
            }

            .stat-number {
                font-size: 1.875rem;
                line-height: 1;
            }

            .progress {
                border-radius: 1rem;
                background-color: var(--gray-200);
            }

            .progress-bar {
                border-radius: 1rem;
                background: linear-gradient(135deg, var(--success), #0d9488);
            }

            /* Empty States */
            .empty-state {
                padding: 2rem;
                color: var(--gray-500);
            }

            .empty-state i {
                font-size: 3rem;
                margin-bottom: 1rem;
                opacity: 0.5;
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

            .btn-warning.btn-modern {
                background-color: var(--warning);
                box-shadow: 0 2px 4px 0 rgba(245, 158, 11, 0.1);
            }

            .btn-warning.btn-modern:hover {
                background-color: #e08a0c;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px 0 rgba(245, 158, 11, 0.2);
            }

            .btn-danger.btn-modern {
                background-color: var(--danger);
                box-shadow: 0 2px 4px 0 rgba(239, 68, 68, 0.1);
            }

            .btn-danger.btn-modern:hover {
                background-color: #dc2626;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px 0 rgba(239, 68, 68, 0.2);
            }

            .btn-outline-primary {
                border: 1px solid var(--primary);
                color: var(--primary);
                background: white;
                transition: all 0.2s ease;
                font-weight: 500;
                font-size: 0.875rem;
            }

            .btn-outline-primary:hover {
                background-color: var(--primary);
                border-color: var(--primary);
                color: white;
                transform: translateY(-1px);
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

            /* Badges */
            .badge {
                font-size: 0.75rem;
                font-weight: 500;
                padding: 0.5rem 0.75rem;
                border-radius: var(--radius);
            }

            /* Responsive */
            @media (max-width: 768px) {
                .container-fluid {
                    padding-left: 1.5rem;
                    padding-right: 1.5rem;
                }

                .d-flex.justify-content-between {
                    flex-direction: column;
                    gap: 1rem;
                    align-items: flex-start;
                }

                .project-icon {
                    width: 2.5rem;
                    height: 2.5rem;
                }

                .member-header {
                    flex-direction: column;
                    text-align: center;
                    gap: 1rem;
                }

                .document-actions {
                    flex-direction: column;
                    gap: 0.5rem;
                }

                .d-grid.gap-2>* {
                    width: 100%;
                }
            }

            @media (max-width: 576px) {
                .d-flex.align-items-center.gap-3 {
                    flex-direction: column;
                    align-items: flex-start;
                    text-align: left;
                }

                .document-card {
                    flex-direction: column;
                    text-align: center;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Single delete functionality
                document.querySelectorAll('.delete-single-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();

                        const projectName = this.dataset.projectName;
                        const form = this.closest('form');

                        Swal.fire({
                            title: 'Konfirmasi Hapus',
                            text: `Apakah Anda yakin ingin menghapus proyek "${projectName}"? Tindakan ini tidak dapat dibatalkan.`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection