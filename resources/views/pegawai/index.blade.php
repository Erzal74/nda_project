@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
    <div class="container-fluid py-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="h2 fw-bold text-gray-900 mb-2">Proyek NDA</h1>
                <p class="text-muted mb-0">Kelola dokumen Non-Disclosure Agreement dan detail proyek Anda.</p>
            </div>
            <a href="{{ route('pegawai.nda.create') }}" class="btn btn-primary btn-modern rounded-2">
                <i class="bi bi-plus-lg me-2"></i><span class="d-none d-sm-inline">Proyek Baru</span><span class="d-sm-none">Baru</span>
            </a>
        </div>

        <!-- Stat Cards -->
        <div class="row mb-5">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 rounded-2">
                                <i class="bi bi-folder-fill text-primary fs-5"></i>
                            </div>
                            <div class="ms-3">
                                <div class="stat-number">{{ $ndas->total() }}</div>
                                <div class="stat-label">Total Proyek</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success bg-opacity-10 rounded-2">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            </div>
                            <div class="ms-3">
                                <div class="stat-number">{{ $ndas->where('nda_signature_date', '!=', null)->count() }}</div>
                                <div class="stat-label">NDA Ditandatangani</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-info bg-opacity-10 rounded-2">
                                <i class="bi bi-files text-info fs-5"></i>
                            </div>
                            <div class="ms-3">
                                <div class="stat-number">{{ $ndas->sum(function ($nda) {return $nda->files->count();}) }}
                                </div>
                                <div class="stat-label">Total Berkas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-warning bg-opacity-10 rounded-2">
                                <i class="bi bi-person-fill text-warning fs-5"></i>
                            </div>
                            <div class="ms-3">
                                <div class="stat-number">
                                    {{ $ndas->sum(function ($nda) {
                                        $members = is_array($nda->members)
                                            ? $nda->members
                                            : (is_string($nda->members)
                                                ? json_decode($nda->members, true)
                                                : []);
                                        return count($members);
                                    }) }}
                                </div>
                                <div class="stat-label">Total Anggota</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Project List Container -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="fw-semibold mb-0">Daftar Proyek</h5>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex gap-2 flex-wrap">
                                <!-- Search Bar -->
                                <div class="position-relative">
                                    <input type="search" class="form-control form-control-sm ps-4 rounded-2"
                                        placeholder="Cari proyek..." id="projectSearch" style="min-width: 150px;"
                                        value="{{ request('search') }}">
                                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-2 text-muted"></i>
                                </div>

                                <!-- Month Filter -->
                                <select class="form-select form-select-sm rounded-2" id="monthFilter" style="min-width: 120px;">
                                    <option value="">Semua Bulan</option>
                                    <option value="01" {{ request('month') == '01' ? 'selected' : '' }}>Januari</option>
                                    <option value="02" {{ request('month') == '02' ? 'selected' : '' }}>Februari</option>
                                    <option value="03" {{ request('month') == '03' ? 'selected' : '' }}>Maret</option>
                                    <option value="04" {{ request('month') == '04' ? 'selected' : '' }}>April</option>
                                    <option value="05" {{ request('month') == '05' ? 'selected' : '' }}>Mei</option>
                                    <option value="06" {{ request('month') == '06' ? 'selected' : '' }}>Juni</option>
                                    <option value="07" {{ request('month') == '07' ? 'selected' : '' }}>Juli</option>
                                    <option value="08" {{ request('month') == '08' ? 'selected' : '' }}>Agustus</option>
                                    <option value="09" {{ request('month') == '09' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>Desember</option>
                                </select>

                                <!-- Clear Filters -->
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-2" id="clearFilters">
                                    <i class="bi bi-x-lg"></i><span class="d-none d-md-inline ms-1">Reset</span>
                                </button>

                                <!-- Bulk Delete Button -->
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-2" id="bulkDeleteNdasBtn" disabled>
                                    <i class="bi bi-trash"></i><span class="d-none d-lg-inline ms-1">Hapus Terpilih</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Desktop Table View -->
            <div class="card-body p-0 d-none d-lg-block">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="ndaTable">
                        <thead class="table-light">
                            <tr>
                                <th width="40">No.</th>
                                <th width="40">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="selectAllNdas">
                                    </div>
                                </th>
                                <th>Proyek</th>
                                <th>Durasi</th>
                                <th>NDA Ditandatangani</th>
                                <th>Anggota</th>
                                <th>Berkas</th>
                                <th width="120" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ndas as $key => $nda)
                                <tr class="project-row desktop-row" data-project-id="{{ $nda->id }}" data-nda-month="{{ $nda->nda_signature_date ? $nda->nda_signature_date->format('m') : '' }}">
                                    <td>{{ $ndas->firstItem() + $key }}</td>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input nda-checkbox" value="{{ $nda->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="project-avatar bg-primary bg-opacity-10 rounded-2">
                                                <i class="bi bi-folder-fill text-primary"></i>
                                            </div>
                                            <div class="ms-3">
                                                <div class="fw-semibold text-gray-900 project-name">{{ $nda->project_name }}</div>
                                                <div class="small text-muted project-description">{{ Str::limit($nda->description, 40) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="project-duration">
                                        @if ($nda->start_date && $nda->end_date)
                                            <div class="small text-gray-900">
                                                {{ $nda->start_date->translatedFormat('d M') }} -
                                                {{ $nda->end_date->translatedFormat('d M Y') }}</div>
                                            <div class="small text-muted">{{ $nda->formatted_duration }}</div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="project-nda-date">
                                        @if ($nda->nda_signature_date)
                                            <div class="badge bg-success bg-opacity-10 text-success">
                                                {{ $nda->nda_signature_date->translatedFormat('d M Y') }}</div>
                                        @else
                                            <div class="badge bg-warning bg-opacity-10 text-warning">Menunggu</div>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $members = is_array($nda->members)
                                                ? $nda->members
                                                : (is_string($nda->members) && json_decode($nda->members) !== null
                                                    ? json_decode($nda->members, true)
                                                    : []);
                                            $members = array_map(function ($member) {
                                                return is_array($member) && isset($member['name'])
                                                    ? $member['name']
                                                    : $member;
                                            }, $members);
                                        @endphp
                                        @if (!empty($members))
                                            <ul class="mb-0 small member-list">
                                                @foreach ($members as $member)
                                                    <li>{{ $member }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($nda->files->isNotEmpty())
                                            <ul class="list-unstyled mb-0 file-list">
                                                @foreach ($nda->files as $file)
                                                    <li>
                                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                                                            class="small text-primary text-truncate d-block">
                                                            <i class="bi bi-file-earmark-pdf me-1"></i>{{ basename($file->file_path) }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('pegawai.nda.detail', $nda) }}"
                                                class="btn btn-sm btn-outline-primary rounded-2" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('pegawai.nda.edit', $nda) }}"
                                                class="btn btn-sm btn-outline-warning rounded-2" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('pegawai.nda.delete', $nda) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger delete-single-btn rounded-2"
                                                    data-project-name="{{ $nda->project_name }}" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyStateDesktop">
                                    <td colspan="8" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bi bi-folder-x display-4 text-muted mb-3"></i>
                                            <h5 class="text-muted">Tidak Ada Proyek Ditemukan</h5>
                                            <p class="text-muted mb-3">Mulai dengan membuat proyek NDA pertama Anda.</p>
                                            <a href="{{ route('pegawai.nda.create') }}" class="btn btn-primary btn-modern rounded-2">
                                                <i class="bi bi-plus-lg me-2"></i>Buat Proyek Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="card-body p-3 d-lg-none" id="mobileProjectList">
                @forelse ($ndas as $key => $nda)
                    <div class="project-card mobile-row mb-3" data-project-id="{{ $nda->id }}" data-nda-month="{{ $nda->nda_signature_date ? $nda->nda_signature_date->format('m') : '' }}">
                        <div class="card border shadow-sm rounded-3">
                            <div class="card-body p-3">
                                <!-- Header with checkbox and actions -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input nda-checkbox mobile-checkbox" value="{{ $nda->id }}">
                                        <label class="form-check-label fw-semibold text-gray-900 project-name">
                                            {{ $nda->project_name }}
                                        </label>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary rounded-2" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('pegawai.nda.detail', $nda) }}">
                                                    <i class="bi bi-eye me-2"></i>Lihat Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('pegawai.nda.edit', $nda) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('pegawai.nda.delete', $nda) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="dropdown-item text-danger delete-single-btn" data-project-name="{{ $nda->project_name }}">
                                                        <i class="bi bi-trash me-2"></i>Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Project Description -->
                                <div class="mb-3">
                                    <p class="text-muted small mb-0 project-description">{{ $nda->description }}</p>
                                </div>

                                <!-- Project Info Grid -->
                                <div class="row g-3">
                                    <!-- Duration -->
                                    <div class="col-12">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar3 text-muted me-2"></i>
                                            <div class="project-duration">
                                                @if ($nda->start_date && $nda->end_date)
                                                    <div class="small text-gray-900">
                                                        {{ $nda->start_date->translatedFormat('d M') }} - {{ $nda->end_date->translatedFormat('d M Y') }}
                                                    </div>
                                                    <div class="small text-muted">{{ $nda->formatted_duration }}</div>
                                                @else
                                                    <span class="text-muted small">Durasi belum ditentukan</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- NDA Status -->
                                    <div class="col-12">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-file-text text-muted me-2"></i>
                                            <div class="project-nda-date">
                                                @if ($nda->nda_signature_date)
                                                    <div class="badge bg-success bg-opacity-10 text-success">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        {{ $nda->nda_signature_date->translatedFormat('d M Y') }}
                                                    </div>
                                                @else
                                                    <div class="badge bg-warning bg-opacity-10 text-warning">
                                                        <i class="bi bi-clock me-1"></i>
                                                        Menunggu
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Members -->
                                    <div class="col-12">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-people text-muted me-2 mt-1"></i>
                                            <div>
                                                @php
                                                    $members = is_array($nda->members)
                                                        ? $nda->members
                                                        : (is_string($nda->members) && json_decode($nda->members) !== null
                                                            ? json_decode($nda->members, true)
                                                            : []);
                                                    $members = array_map(function ($member) {
                                                        return is_array($member) && isset($member['name'])
                                                            ? $member['name']
                                                            : $member;
                                                    }, $members);
                                                @endphp
                                                @if (!empty($members))
                                                    <div class="small">
                                                        <span class="fw-medium">Anggota ({{ count($members) }}):</span>
                                                        <div class="mt-1">
                                                            @foreach (array_slice($members, 0, 3) as $member)
                                                                <span class="badge bg-light text-dark me-1 mb-1">{{ $member }}</span>
                                                            @endforeach
                                                            @if (count($members) > 3)
                                                                <span class="small text-muted">+{{ count($members) - 3 }} lainnya</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">Tidak ada anggota</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Files -->
                                    <div class="col-12">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-files text-muted me-2 mt-1"></i>
                                            <div>
                                                @if ($nda->files->isNotEmpty())
                                                    <div class="small">
                                                        <span class="fw-medium">Berkas ({{ $nda->files->count() }}):</span>
                                                        <div class="mt-1">
                                                            @foreach ($nda->files->take(2) as $file)
                                                                <div class="mb-1">
                                                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-primary text-decoration-none small">
                                                                        <i class="bi bi-file-earmark-pdf me-1"></i>
                                                                        {{ Str::limit(basename($file->file_path), 25) }}
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                            @if ($nda->files->count() > 2)
                                                                <span class="small text-muted">+{{ $nda->files->count() - 2 }} berkas lainnya</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">Tidak ada berkas</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div id="emptyStateMobile" class="text-center py-5">
                        <div class="empty-state">
                            <i class="bi bi-folder-x display-4 text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak Ada Proyek Ditemukan</h5>
                            <p class="text-muted mb-3">Mulai dengan membuat proyek NDA pertama Anda.</p>
                            <a href="{{ route('pegawai.nda.create') }}" class="btn btn-primary btn-modern rounded-2">
                                <i class="bi bi-plus-lg me-2"></i>Buat Proyek Pertama
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($ndas->hasPages())
                <div class="card-footer bg-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan {{ $ndas->firstItem() }} sampai {{ $ndas->lastItem() }} dari {{ $ndas->total() }} hasil
                        </div>
                        <div>
                            {{ $ndas->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Hidden form for bulk delete -->
    <form id="bulkDeleteForm" action="{{ route('pegawai.nda.bulk-delete') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <div id="selectedIds"></div>
    </form>

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

            /* Stat Card Styling */
            .stat-card {
                border-radius: var(--radius-lg);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .stat-icon {
                width: 3rem;
                height: 3rem;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
            }

            .stat-number {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--gray-900);
            }

            .stat-label {
                font-size: 0.875rem;
                color: var(--gray-600);
                font-weight: 500;
            }

            /* Table Styling */
            .table th {
                font-weight: 600;
                color: var(--gray-700);
                border-bottom: 1px solid var(--gray-200);
                padding: 1rem;
                font-size: 0.875rem;
            }

            .table td {
                vertical-align: middle;
                border-bottom: 1px solid var(--gray-100);
                padding: 1rem;
                font-size: 0.875rem;
            }

            .table tbody tr:hover {
                background-color: var(--gray-50);
            }

            .project-row {
                transition: opacity 0.3s ease;
            }

            .project-row[style*="none"] {
                opacity: 0;
            }

            .project-avatar {
                width: 2.5rem;
                height: 2.5rem;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.125rem;
            }

            .project-name {
                font-size: 0.875rem;
                font-weight: 600;
            }

            .project-description {
                font-size: 0.75rem;
            }

            /* Mobile Card Styling */
            .project-card {
                transition: opacity 0.3s ease;
            }

            .project-card[style*="none"] {
                opacity: 0;
            }

            .project-card .card {
                transition: all 0.2s ease;
                border: 1px solid var(--gray-200);
            }

            .project-card .card:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                border-color: var(--gray-300);
            }

            .mobile-checkbox + label {
                font-size: 0.9rem;
                cursor: pointer;
                margin-left: 0.25rem;
            }

            .mobile-checkbox:checked + label {
                color: var(--primary);
            }

            /* Lists */
            .member-list {
                padding-left: 1.25rem;
                margin: 0;
                font-size: 0.75rem;
                line-height: 1.2;
                max-height: 100px;
                overflow-y: auto;
            }

            .member-list li {
                margin-bottom: 0.25rem;
            }

            .file-list {
                margin: 0;
                padding: 0;
                font-size: 0.75rem;
                line-height: 1.2;
            }

            .file-list li {
                margin-bottom: 0.25rem;
            }

            .file-list a {
                max-width: 150px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                transition: color 0.2s ease;
            }

            .file-list a:hover {
                color: var(--primary);
            }

            /* Badges */
            .badge {
                font-size: 0.75rem;
                font-weight: 500;
                padding: 0.25rem 0.5rem;
                border-radius: var(--radius);
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
            }

            .btn-outline-warning {
                border: 1px solid var(--warning);
                color: var(--warning);
                background: white;
                transition: all 0.2s ease;
                font-weight: 500;
                font-size: 0.875rem;
            }

            .btn-outline-warning:hover {
                background-color: var(--warning);
                border-color: var(--warning);
                color: white;
            }

            .btn-outline-danger {
                border: 1px solid var(--danger);
                color: var(--danger);
                background: white;
                transition: all 0.2s ease;
                font-weight: 500;
                font-size: 0.875rem;
            }

            .btn-outline-danger:hover {
                background-color: var(--danger);
                border-color: var(--danger);
                color: white;
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

            /* Form Controls */
            .form-control,
            .form-select {
                border-radius: var(--radius);
                border: 1px solid var(--gray-300);
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
                transition: all 0.2s ease;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
                outline: none;
            }

            /* Empty State */
            .empty-state i {
                opacity: 0.5;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .container-fluid {
                    padding-left: 0.75rem;
                    padding-right: 0.75rem;
                }

                .stat-card .card-body {
                    padding: 1rem;
                }

                .stat-number {
                    font-size: 1.25rem;
                }

                .stat-icon {
                    width: 2.5rem;
                    height: 2.5rem;
                    font-size: 1rem;
                }

                .card-header {
                    padding: 1rem;
                }

                .card-header .d-flex.gap-2 {
                    flex-direction: column;
                    gap: 0.5rem;
                }

                .card-header .position-relative,
                .card-header select {
                    width: 100% !important;
                    min-width: auto !important;
                }
            }

            @media (max-width: 576px) {
                .d-flex.justify-content-between.align-items-center.mb-5 {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1rem;
                }

                .d-flex.justify-content-between.align-items-center.mb-5 a {
                    align-self: stretch;
                    text-align: center;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Elements
                const selectAllCheckbox = document.getElementById('selectAllNdas');
                const ndaCheckboxes = document.querySelectorAll('.nda-checkbox');
                const bulkDeleteBtn = document.getElementById('bulkDeleteNdasBtn');
                const projectSearch = document.getElementById('projectSearch');
                const monthFilter = document.getElementById('monthFilter');
                const clearFiltersBtn = document.getElementById('clearFilters');
                const desktopRows = document.querySelectorAll('.desktop-row');
                const mobileRows = document.querySelectorAll('.mobile-row');
                const emptyStateDesktop = document.getElementById('emptyStateDesktop');
                const emptyStateMobile = document.getElementById('emptyStateMobile');

                // Search functionality
                function performSearch() {
                    const searchTerm = projectSearch.value.toLowerCase().trim();
                    const selectedMonth = monthFilter.value;
                    let visibleDesktopCount = 0;
                    let visibleMobileCount = 0;

                    // Filter desktop rows
                    desktopRows.forEach(row => {
                        const projectName = row.querySelector('.project-name')?.textContent.toLowerCase() || '';
                        const projectDescription = row.querySelector('.project-description')?.textContent.toLowerCase() || '';
                        const projectDuration = row.querySelector('.project-duration')?.textContent.toLowerCase() || '';
                        const ndaMonth = row.dataset.ndaMonth || '';

                        const matchesSearch = searchTerm === '' ||
                            projectName.includes(searchTerm) ||
                            projectDescription.includes(searchTerm) ||
                            projectDuration.includes(searchTerm);

                        const matchesMonth = selectedMonth === '' || ndaMonth === selectedMonth;

                        if (matchesSearch && matchesMonth) {
                            row.style.display = '';
                            visibleDesktopCount++;
                        } else {
                            row.style.display = 'none';
                            const checkbox = row.querySelector('.nda-checkbox');
                            if (checkbox) checkbox.checked = false;
                        }
                    });

                    // Filter mobile rows
                    mobileRows.forEach(row => {
                        const projectName = row.querySelector('.project-name')?.textContent.toLowerCase() || '';
                        const projectDescription = row.querySelector('.project-description')?.textContent.toLowerCase() || '';
                        const projectDuration = row.querySelector('.project-duration')?.textContent.toLowerCase() || '';
                        const ndaMonth = row.dataset.ndaMonth || '';

                        const matchesSearch = searchTerm === '' ||
                            projectName.includes(searchTerm) ||
                            projectDescription.includes(searchTerm) ||
                            projectDuration.includes(searchTerm);

                        const matchesMonth = selectedMonth === '' || ndaMonth === selectedMonth;

                        if (matchesSearch && matchesMonth) {
                            row.style.display = '';
                            visibleMobileCount++;
                        } else {
                            row.style.display = 'none';
                            const checkbox = row.querySelector('.nda-checkbox');
                            if (checkbox) checkbox.checked = false;
                        }
                    });

                    // Show/hide empty states
                    if (emptyStateDesktop) {
                        emptyStateDesktop.style.display = visibleDesktopCount === 0 ? '' : 'none';
                    }
                    if (emptyStateMobile) {
                        emptyStateMobile.style.display = visibleMobileCount === 0 ? '' : 'none';
                    }

                    // Update bulk delete button state
                    updateBulkDeleteButton();
                    // Update select all checkbox
                    updateSelectAllCheckbox();
                }

                // Search input event with debounce
                let searchTimeout;
                projectSearch.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        const url = new URL(window.location);
                        if (this.value) {
                            url.searchParams.set('search', this.value);
                        } else {
                            url.searchParams.delete('search');
                        }
                        window.history.pushState({}, '', url);
                        performSearch();
                    }, 300);
                });

                // Month filter event
                monthFilter.addEventListener('change', function() {
                    const url = new URL(window.location);
                    if (this.value) {
                        url.searchParams.set('month', this.value);
                    } else {
                        url.searchParams.delete('month');
                    }
                    window.history.pushState({}, '', url);
                    performSearch();
                });

                // Clear filters
                clearFiltersBtn.addEventListener('click', function() {
                    projectSearch.value = '';
                    monthFilter.value = '';
                    const url = new URL(window.location);
                    url.searchParams.delete('search');
                    url.searchParams.delete('month');
                    window.history.pushState({}, '', url);
                    performSearch();
                });

                // Select all functionality
                selectAllCheckbox.addEventListener('change', function() {
                    const visibleCheckboxes = Array.from(ndaCheckboxes).filter(checkbox => {
                        const row = checkbox.closest('.desktop-row, .mobile-row');
                        return row && row.style.display !== 'none';
                    });

                    visibleCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateBulkDeleteButton();
                });

                // Individual checkbox change
                ndaCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateSelectAllCheckbox();
                        updateBulkDeleteButton();
                    });
                });

                // Update select all checkbox state
                function updateSelectAllCheckbox() {
                    const visibleCheckboxes = Array.from(ndaCheckboxes).filter(checkbox => {
                        const row = checkbox.closest('.desktop-row, .mobile-row');
                        return row && row.style.display !== 'none';
                    });
                    const checkedVisibleCount = visibleCheckboxes.filter(cb => cb.checked).length;

                    if (visibleCheckboxes.length === 0) {
                        selectAllCheckbox.indeterminate = false;
                        selectAllCheckbox.checked = false;
                    } else if (checkedVisibleCount === 0) {
                        selectAllCheckbox.indeterminate = false;
                        selectAllCheckbox.checked = false;
                    } else if (checkedVisibleCount === visibleCheckboxes.length) {
                        selectAllCheckbox.indeterminate = false;
                        selectAllCheckbox.checked = true;
                    } else {
                        selectAllCheckbox.indeterminate = true;
                        selectAllCheckbox.checked = false;
                    }
                }

                // Update bulk delete button state
                function updateBulkDeleteButton() {
                    const checkedCount = Array.from(ndaCheckboxes).filter(cb => cb.checked).length;
                    bulkDeleteBtn.disabled = checkedCount === 0;
                }

                // Bulk delete functionality
                bulkDeleteBtn.addEventListener('click', function() {
                    const checkedBoxes = Array.from(ndaCheckboxes).filter(cb => cb.checked);

                    if (checkedBoxes.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak Ada Pilihan',
                            text: 'Pilih setidaknya satu proyek untuk dihapus.',
                            confirmButtonText: 'Mengerti',
                            confirmButtonColor: '#6366f1'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: `Apakah Anda yakin ingin menghapus ${checkedBoxes.length} proyek yang dipilih? Tindakan ini tidak dapat dibatalkan.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const selectedIdsContainer = document.getElementById('selectedIds');
                            selectedIdsContainer.innerHTML = '';

                            checkedBoxes.forEach(checkbox => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'nda_ids[]';
                                input.value = checkbox.value;
                                selectedIdsContainer.appendChild(input);
                            });

                            document.getElementById('bulkDeleteForm').submit();
                        }
                    });
                });

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

                // Initial search
                performSearch();
            });
        </script>
    @endpush
@endsection