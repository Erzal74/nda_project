@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
    <div class="main-container">
        <!-- Header Section -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-text">
                    <h1 class="page-title">Proyek NDA</h1>
                    <p class="page-subtitle">Kelola semua dokumen Non-Disclosure Agreement dan detail proyek Anda dengan
                        mudah dan
                        efisien.</p>
                </div>
                <div class="header-action">
                    <a href="{{ route('pegawai.nda.create') }}" class="btn btn-primary btn-create">
                        <i class="bi bi-plus-circle me-2"></i>
                        <span>Proyek Baru</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards (diperbaiki untuk kesatuan NDA per anggota) -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon stat-icon-primary">
                        <i class="bi bi-collection-fill"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $ndas->total() }}</div>
                        <div class="stat-label">Total Proyek</div>
                    </div>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon stat-icon-success">
                        <i class="bi bi-shield-check-fill"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">
                            {{ $ndas->filter(function ($nda) {
                                    return $nda->files->every(fn($file) => $file->signature_date !== null) && $nda->files->count() > 0;
                                })->count() }}
                        </div>
                        <div class="stat-label">Proyek Selesai NDA</div>
                    </div>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar bg-success"
                        style="width: {{ $ndas->total() > 0 ? ($ndas->filter(fn($nda) => $nda->files->every(fn($file) => $file->signature_date !== null) && $nda->files->count() > 0)->count() / $ndas->total()) * 100 : 0 }}%">
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon stat-icon-info">
                        <i class="bi bi-files-alt"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $ndas->sum(fn($nda) => $nda->files->count()) }}</div>
                        <div class="stat-label">Total Berkas</div>
                    </div>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar bg-info" style="width: 85%"></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon stat-icon-warning">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-info">
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
                <div class="stat-progress">
                    <div class="progress-bar bg-warning" style="width: 70%"></div>
                </div>
            </div>
        </div>

        <!-- Projects Table Section -->
        <div class="table-section">
            <div class="table-header">
                <div class="table-title">
                    <h2>Daftar Proyek</h2>
                    <p>Kelola semua proyek Anda dalam satu tempat</p>
                </div>

                <!-- Filters & Actions -->
                <div class="table-controls">
                    <div class="search-controls">
                        <div class="search-input-wrapper">
                            <i class="bi bi-search search-icon"></i>
                            <input type="search" class="search-input" placeholder="Cari proyek..." id="projectSearch"
                                value="{{ request('search') }}">
                        </div>

                        <div class="filter-wrapper">
                            <select class="filter-select" id="monthFilter">
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
                        </div>
                    </div>

                    <div class="action-controls">
                        <button type="button" class="btn btn-secondary btn-reset" id="clearFilters">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Reset
                        </button>
                        <button type="button" class="btn btn-danger btn-bulk-delete" id="bulkDeleteNdasBtn" disabled>
                            <i class="bi bi-trash me-1"></i>
                            Hapus Terpilih
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="table-container">
                <div class="table-wrapper">
                    <table class="projects-table" id="ndaTable">
                        <thead>
                            <tr>
                                <th class="th-number">No.</th>
                                <th class="th-checkbox">
                                    <div class="checkbox-wrapper">
                                        <input type="checkbox" class="table-checkbox" id="selectAllNdas">
                                        <label for="selectAllNdas"></label>
                                    </div>
                                </th>
                                <th class="th-project">Proyek</th>
                                <th class="th-duration">Durasi</th>
                                <th class="th-status">Status NDA</th>
                                <th class="th-members-files">Anggota & Berkas</th>
                                <th class="th-actions">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ndas as $key => $nda)
                                <tr class="project-row" data-project-id="{{ $nda->id }}">
                                    <td class="td-number">{{ $ndas->firstItem() + $key }}</td>
                                    <td class="td-checkbox">
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" class="table-checkbox nda-checkbox"
                                                id="nda-{{ $nda->id }}" value="{{ $nda->id }}">
                                            <label for="nda-{{ $nda->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="td-project">
                                        <div class="project-info">
                                            <div class="project-icon">
                                                <i class="bi bi-folder-fill"></i>
                                            </div>
                                            <div class="project-details">
                                                <div class="project-name">{{ $nda->project_name }}</div>
                                                <div class="project-description">{{ Str::limit($nda->description, 50) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="td-duration project-duration">
                                        @if ($nda->start_date && $nda->end_date)
                                            <div class="duration-info">
                                                <div class="duration-dates">
                                                    {{ $nda->start_date->translatedFormat('d M') }} -
                                                    {{ $nda->end_date->translatedFormat('d M Y') }}
                                                </div>
                                                <div class="duration-length">{{ $nda->formatted_duration }}</div>
                                            </div>
                                        @else
                                            <span class="text-muted">Tidak diatur</span>
                                        @endif
                                    </td>
                                    <td class="td-status project-nda-date">
                                        @php
                                            $signedCount = $nda->files
                                                ->filter(fn($file) => $file->signature_date !== null)
                                                ->count();
                                            $totalFiles = $nda->files->count();
                                            $ndaMonth = $nda->files->first()?->signature_date?->format('m') ?? '';
                                        @endphp
                                        <div data-month="{{ $ndaMonth }}">
                                            @if ($totalFiles > 0 && $signedCount === $totalFiles)
                                                <div class="status-badge status-signed">
                                                    <i class="bi bi-check-circle-fill me-1"></i>
                                                    Semua Ditandatangani
                                                </div>
                                            @else
                                                <div class="status-badge status-pending">
                                                    <i class="bi bi-clock-fill me-1"></i>
                                                    Menunggu ({{ $signedCount }}/{{ $totalFiles }})
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="td-members-files">
                                        @php
                                            $members = is_array($nda->members)
                                                ? $nda->members
                                                : (is_string($nda->members)
                                                    ? json_decode($nda->members, true)
                                                    : []);
                                            $members = array_map(function ($member) {
                                                return is_array($member) && isset($member['name'])
                                                    ? $member['name']
                                                    : $member;
                                            }, $members);
                                            $files = $nda->files;
                                            $memberCount = count($members);
                                            $fileCount = $files->count();
                                            $maxDisplay = 5; // Batasi tampilan maksimal 5 item
                                        @endphp
                                        @if (!empty($members) || $files->isNotEmpty())
                                            <div class="members-files-list">
                                                @for ($i = 0; $i < min($memberCount, $maxDisplay); $i++)
                                                    <div class="member-file-item">
                                                        <div class="member-name">
                                                            <i class="bi bi-person-circle me-1"></i>
                                                            {{ $members[$i] ?? 'Anggota ' . ($i + 1) }}
                                                        </div>
                                                        <div class="file-info">
                                                            @if (isset($files[$i]))
                                                                <a href="{{ Storage::url($files[$i]->file_path) }}"
                                                                    target="_blank" class="file-link">
                                                                    <i class="bi bi-file-earmark-pdf me-1"></i>
                                                                    {{ Str::limit(basename($files[$i]->file_path), 20) }}
                                                                </a>
                                                                <span class="signature-date">
                                                                    ({{ $files[$i]->signature_date ? $files[$i]->signature_date->translatedFormat('d M Y') : 'Belum ditandatangani' }})
                                                                </span>
                                                            @else
                                                                <span class="text-muted">Tidak ada berkas</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endfor
                                                @if ($memberCount > $maxDisplay)
                                                    <div class="member-file-more">
                                                        <a href="{{ route('pegawai.nda.detail', $nda) }}"
                                                            class="text-primary text-decoration-underline">
                                                            +{{ $memberCount - $maxDisplay }} lainnya (Lihat Selengkapnya)
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($memberCount !== $fileCount)
                                                <div class="text-warning small mt-1"
                                                    title="Data mungkin tidak sinkron, periksa edit form">
                                                    âš ï¸ {{ $memberCount }} anggota, {{ $fileCount }} berkas
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted">Belum ada anggota atau berkas</span>
                                        @endif
                                    </td>
                                    <td class="td-actions">
                                        <div class="action-buttons">
                                            <a href="{{ route('pegawai.nda.detail', $nda) }}" class="btn-action btn-view"
                                                title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('pegawai.nda.edit', $nda) }}" class="btn-action btn-edit"
                                                title="Edit Proyek">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('pegawai.nda.delete', $nda) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-action btn-delete delete-single-btn"
                                                    data-project-name="{{ $nda->project_name }}" title="Hapus Proyek">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Tidak ada data proyek NDA.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards (Hidden on desktop) (diperbaiki serupa dengan tabel) -->
                <div class="mobile-cards">
                    @forelse ($ndas as $key => $nda)
                        <div class="mobile-card project-row" data-project-id="{{ $nda->id }}">
                            <div class="mobile-card-header">
                                <div class="mobile-checkbox">
                                    <div class="checkbox-wrapper">
                                        <input type="checkbox" class="table-checkbox nda-checkbox"
                                            id="mobile-nda-{{ $nda->id }}" value="{{ $nda->id }}">
                                        <label for="mobile-nda-{{ $nda->id }}"></label>
                                    </div>
                                </div>
                                <div class="mobile-project-info">
                                    <div class="mobile-project-icon">
                                        <i class="bi bi-folder-fill"></i>
                                    </div>
                                    <div class="mobile-project-details">
                                        <h4 class="mobile-project-name">{{ $nda->project_name }}</h4>
                                        <p class="mobile-project-description">{{ Str::limit($nda->description, 60) }}</p>
                                    </div>
                                </div>
                                <div class="mobile-actions">
                                    <div class="dropdown">
                                        <button class="btn-mobile-menu" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('pegawai.nda.detail', $nda) }}">
                                                    <i class="bi bi-eye me-2"></i>Lihat Detail</a></li>
                                            <li><a class="dropdown-item" href="{{ route('pegawai.nda.edit', $nda) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit Proyek</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('pegawai.nda.delete', $nda) }}" method="POST"
                                                    class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="dropdown-item text-danger delete-single-btn"
                                                        data-project-name="{{ $nda->project_name }}">
                                                        <i class="bi bi-trash me-2"></i>Hapus Proyek
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="mobile-card-content">
                                <div class="mobile-info-grid">
                                    <div class="mobile-info-item">
                                        <div class="mobile-info-label">Status NDA</div>
                                        <div class="mobile-info-value project-nda-date">
                                            @php
                                                $signedCount = $nda->files
                                                    ->filter(fn($file) => $file->signature_date !== null)
                                                    ->count();
                                                $totalFiles = $nda->files->count();
                                                $ndaMonth = $nda->files->first()?->signature_date?->format('m') ?? '';
                                            @endphp
                                            <div data-month="{{ $ndaMonth }}">
                                                @if ($totalFiles > 0 && $signedCount === $totalFiles)
                                                    <div class="status-badge status-signed">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        Semua Ditandatangani
                                                    </div>
                                                @else
                                                    <div class="status-badge status-pending">
                                                        <i class="bi bi-clock-fill me-1"></i>
                                                        Menunggu ({{ $signedCount }}/{{ $totalFiles }})
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mobile-info-item">
                                        <div class="mobile-info-label">Durasi Proyek</div>
                                        <div class="mobile-info-value project-duration">
                                            @if ($nda->start_date && $nda->end_date)
                                                <div class="duration-info">
                                                    <div class="duration-dates">
                                                        {{ $nda->start_date->translatedFormat('d M') }} -
                                                        {{ $nda->end_date->translatedFormat('d M Y') }}
                                                    </div>
                                                    <div class="duration-length">{{ $nda->formatted_duration }}</div>
                                                </div>
                                            @else
                                                <span class="text-muted">Tidak diatur</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mobile-info-item">
                                        <div class="mobile-info-label">Anggota & Berkas</div>
                                        <div class="mobile-info-value">
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
                                                $files = $nda->files;
                                                $memberCount = count($members);
                                                $fileCount = $files->count();
                                                $maxDisplay = 5; // Batasi tampilan maksimal 5 item
                                            @endphp
                                            @if (!empty($members) || $files->isNotEmpty())
                                                <div class="members-files-list">
                                                    @for ($i = 0; $i < min($memberCount, $maxDisplay); $i++)
                                                        <div class="member-file-item">
                                                            <div class="member-name">
                                                                <i class="bi bi-person-circle me-1"></i>
                                                                {{ $members[$i] ?? 'Anggota ' . ($i + 1) }}
                                                            </div>
                                                            <div class="file-info">
                                                                @if (isset($files[$i]))
                                                                    <a href="{{ Storage::url($files[$i]->file_path) }}"
                                                                        target="_blank" class="file-link">
                                                                        <i class="bi bi-file-earmark-pdf me-1"></i>
                                                                        {{ Str::limit(basename($files[$i]->file_path), 20) }}
                                                                    </a>
                                                                    <span class="signature-date">
                                                                        ({{ $files[$i]->signature_date ? $files[$i]->signature_date->translatedFormat('d M Y') : 'Belum ditandatangani' }})
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted">Tidak ada berkas</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endfor
                                                    @if ($memberCount > $maxDisplay)
                                                        <div class="member-file-more">
                                                            <a href="{{ route('pegawai.nda.detail', $nda) }}"
                                                                class="text-primary text-decoration-underline">
                                                                +{{ $memberCount - $maxDisplay }} lainnya (Lihat
                                                                Selengkapnya)
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if ($memberCount !== $fileCount)
                                                    <div class="text-warning small mt-1"
                                                        title="Data mungkin tidak sinkron, periksa edit form">
                                                        âš ï¸ {{ $memberCount }} anggota, {{ $fileCount }} berkas
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted">Belum ada anggota atau berkas</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="mobile-empty-state" id="mobileEmptyState">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-folder-x"></i>
                                </div>
                                <h3 class="empty-title">Belum Ada Proyek</h3>
                                <p class="empty-subtitle">Mulai dengan membuat proyek NDA pertama Anda.</p>
                                <a href="{{ route('pegawai.nda.create') }}" class="btn btn-primary btn-create">
                                    <i class="bi bi-plus-circle me-2"></i>
                                    Buat Proyek Pertama
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if ($ndas->hasPages())
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Menampilkan {{ $ndas->firstItem() }} sampai {{ $ndas->lastItem() }} dari {{ $ndas->total() }}
                        hasil
                    </div>
                    <div class="pagination-links">
                        {{ $ndas->appends(request()->query())->links('pagination::bootstrap-4') }}
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
            /* CSS Variables */
            :root {
                --primary: #4f46e5;
                --primary-light: #6366f1;
                --primary-dark: #4338ca;
                --primary-bg: rgba(79, 70, 229, 0.08);

                --success: #10b981;
                --success-bg: rgba(16, 185, 129, 0.08);

                --warning: #f59e0b;
                --warning-bg: rgba(245, 158, 11, 0.08);

                --danger: #ef4444;
                --danger-bg: rgba(239, 68, 68, 0.08);

                --info: #0ea5e9;
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

                --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                --transition-fast: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
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
                max-width: 1400px;
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
                position: relative;
                overflow: hidden;
            }

            .btn:focus {
                outline: 2px solid transparent;
                outline-offset: 2px;
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
            }

            .btn-danger {
                background: var(--danger);
                color: white;
            }

            .btn-danger:hover {
                background: #dc2626;
                transform: translateY(-1px);
            }

            .btn-danger:disabled {
                background: var(--gray-300);
                color: var(--gray-500);
                cursor: not-allowed;
                transform: none;
            }

            .btn-create {
                padding: 1rem 2rem;
                font-size: 1rem;
                border-radius: var(--radius-lg);
                box-shadow: var(--shadow-md);
            }

            /* Statistics Grid */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2.5rem;
            }

            .stat-card {
                background: white;
                padding: 2rem;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-sm);
                border: 1px solid var(--gray-100);
                transition: var(--transition);
                position: relative;
                overflow: hidden;
            }

            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow-md);
            }

            .stat-content {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .stat-icon {
                width: 3.5rem;
                height: 3.5rem;
                border-radius: var(--radius-lg);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                flex-shrink: 0;
            }

            .stat-icon-primary {
                background: var(--primary-bg);
                color: var(--primary);
            }

            .stat-icon-success {
                background: var(--success-bg);
                color: var(--success);
            }

            .stat-icon-info {
                background: var(--info-bg);
                color: var(--info);
            }

            .stat-icon-warning {
                background: var(--warning-bg);
                color: var(--warning);
            }

            .stat-info {
                flex: 1;
            }

            .stat-number {
                font-size: 2rem;
                font-weight: 800;
                color: var(--gray-900);
                line-height: 1;
                margin-bottom: 0.25rem;
            }

            .stat-label {
                font-size: 0.875rem;
                color: var(--gray-600);
                font-weight: 500;
            }

            .stat-progress {
                height: 4px;
                background: var(--gray-100);
                border-radius: 2px;
                overflow: hidden;
            }

            .progress-bar {
                height: 100%;
                border-radius: 2px;
                transition: width 0.6s ease;
            }

            .bg-primary {
                background-color: var(--primary) !important;
            }

            .bg-success {
                background-color: var(--success) !important;
            }

            .bg-info {
                background-color: var(--info) !important;
            }

            .bg-warning {
                background-color: var(--warning) !important;
            }

            /* Table Section */
            .table-section {
                background: white;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-sm);
                border: 1px solid var(--gray-100);
                overflow: hidden;
            }

            .table-header {
                padding: 2rem;
                border-bottom: 1px solid var(--gray-100);
                background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            }

            .table-title h2 {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--gray-900);
                margin: 0 0 0.25rem 0;
            }

            .table-title p {
                font-size: 0.875rem;
                color: var(--gray-600);
                margin: 0 0 1.5rem 0;
            }

            .table-controls {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
                flex-wrap: wrap;
            }

            .search-controls {
                display: flex;
                gap: 1rem;
                flex-wrap: wrap;
            }

            .search-input-wrapper {
                position: relative;
            }

            .search-icon {
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                color: var(--gray-400);
                font-size: 0.875rem;
            }

            .search-input {
                padding: 0.75rem 1rem 0.75rem 2.5rem;
                border: 1px solid var(--gray-300);
                border-radius: var(--radius);
                font-size: 0.875rem;
                width: 280px;
                transition: var(--transition);
                background: white;
            }

            .search-input:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px var(--primary-bg);
            }

            .filter-wrapper {
                position: relative;
            }

            .filter-select {
                padding: 0.75rem 1rem;
                border: 1px solid var(--gray-300);
                border-radius: var(--radius);
                font-size: 0.875rem;
                background: white;
                cursor: pointer;
                transition: var(--transition);
                min-width: 150px;
            }

            .filter-select:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px var(--primary-bg);
            }

            .action-controls {
                display: flex;
                gap: 0.75rem;
            }

            .btn-reset {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                background-color: #6c757d;
                color: #fff;
                border: 1px solid #6c757d;
            }

            .btn-reset:hover,
            .btn-reset:focus,
            .btn-reset:active,
            .btn-reset:focus:active {
                background-color: #6c757d !important;
                color: #fff !important;
                opacity: 1 !important;
                box-shadow: none !important;
            }

            .btn-bulk-delete {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }

            /* Table Container */
            .table-container {
                position: relative;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            /* Desktop Table */
            .projects-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.875rem;
            }

            .projects-table th {
                background: var(--gray-50);
                padding: 1rem;
                text-align: left;
                font-weight: 600;
                color: var(--gray-700);
                border-bottom: 1px solid var(--gray-200);
                white-space: nowrap;
            }

            .projects-table td {
                padding: 1rem;
                vertical-align: middle;
                border-bottom: 1px solid var(--gray-100);
            }

            .projects-table tbody tr {
                transition: var(--transition-fast);
            }

            .projects-table tbody tr:hover {
                background: var(--gray-50);
            }

            .th-number,
            .td-number {
                width: 60px;
                text-align: center;
                font-weight: 600;
                color: var(--gray-500);
            }

            .th-checkbox,
            .td-checkbox {
                width: 50px;
                text-align: center;
            }

            .th-actions,
            .td-actions {
                width: 120px;
                text-align: center;
            }

            .th-members-files,
            .td-members-files {
                width: 300px;
            }

            /* Checkbox Styling */
            .checkbox-wrapper {
                position: relative;
                display: inline-block;
            }

            .table-checkbox {
                width: 18px;
                height: 18px;
                opacity: 0;
                position: absolute;
                top: 0;
                left: 0;
                margin: 0;
                cursor: pointer;
            }

            .table-checkbox+label {
                position: relative;
                display: inline-block;
                width: 18px;
                height: 18px;
                border: 2px solid var(--gray-300);
                border-radius: 4px;
                background: white;
                cursor: pointer;
                transition: var(--transition);
            }

            .table-checkbox:checked+label {
                background: var(--primary);
                border-color: var(--primary);
            }

            .table-checkbox:checked+label::after {
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

            .table-checkbox:focus+label {
                box-shadow: 0 0 0 3px var(--primary-bg);
            }

            /* Project Info */
            .project-info {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .project-icon {
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

            .project-details {
                flex: 1;
                min-width: 0;
            }

            .project-name {
                font-weight: 600;
                color: var(--gray-900);
                margin-bottom: 0.25rem;
                line-height: 1.4;
            }

            .project-description {
                font-size: 0.8125rem;
                color: var(--gray-600);
                line-height: 1.3;
            }

            /* Duration Info */
            .duration-info {
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
            }

            .duration-dates {
                font-weight: 500;
                color: var(--gray-900);
                font-size: 0.8125rem;
            }

            .duration-length {
                font-size: 0.75rem;
                color: var(--gray-500);
            }

            /* Status Badges */
            .status-badge {
                display: inline-flex;
                align-items: center;
                padding: 0.375rem 0.75rem;
                border-radius: var(--radius-sm);
                font-size: 0.8125rem;
                font-weight: 500;
                white-space: nowrap;
            }

            .status-signed {
                background: var(--success-bg);
                color: var(--success);
            }

            .status-pending {
                background: var(--warning-bg);
                color: var(--warning);
            }

            /* Members & Files List */
            .members-files-list {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .member-file-item {
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
                font-size: 0.8125rem;
                color: var(--gray-700);
            }

            */ .member-file-more a {
                font-weight: 600;
                font-size: 0.8125rem;
            }

            .member-file-more a:hover {
                text-decoration: none;
                color: var(--primary-dark);
            }

            .member-name {
                display: flex;
                align-items: center;
                font-weight: 500;
            }

            .file-info {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding-left: 1.5rem;
                /* Indent to align under member */
            }

            .file-link {
                color: var(--primary);
                text-decoration: none;
                display: flex;
                align-items: center;
                transition: var(--transition);
            }

            .file-link:hover {
                color: var(--primary-dark);
                text-decoration: underline;
            }

            .signature-date {
                font-size: 0.75rem;
                color: var(--gray-500);
                white-space: nowrap;
            }

            .member-file-more {
                font-size: 0.75rem;
                color: var(--gray-500);
                font-style: italic;
            }

            /* Action Buttons */
            .action-buttons {
                display: flex;
                justify-content: center;
                gap: 0.5rem;
            }

            .btn-action {
                width: 32px;
                height: 32px;
                border: none;
                border-radius: var(--radius-sm);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: var(--transition);
                text-decoration: none;
                font-size: 0.875rem;
            }

            .btn-view {
                background: var(--primary-bg);
                color: var(--primary);
            }

            .btn-view:hover {
                background: var(--primary);
                color: white;
            }

            .btn-edit {
                background: var(--warning-bg);
                color: var(--warning);
            }

            .btn-edit:hover {
                background: var(--warning);
                color: white;
            }

            .btn-delete {
                background: var(--danger-bg);
                color: var(--danger);
            }

            .btn-delete:hover {
                background: var(--danger);
                color: white;
            }

            /* Mobile Cards (Hidden on desktop) */
            .mobile-cards {
                display: none;
            }

            .mobile-card {
                background: white;
                border: 1px solid var(--gray-200);
                border-radius: var(--radius-lg);
                margin-bottom: 1rem;
                overflow: hidden;
                transition: var(--transition);
            }

            .mobile-card:hover {
                box-shadow: var(--shadow-md);
                transform: translateY(-1px);
            }

            .mobile-card-header {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1.5rem;
                border-bottom: 1px solid var(--gray-100);
            }

            .mobile-checkbox {
                margin-top: 0.25rem;
            }

            .mobile-project-info {
                flex: 1;
                display: flex;
                gap: 1rem;
                min-width: 0;
            }

            .mobile-project-icon {
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

            .mobile-project-details {
                flex: 1;
                min-width: 0;
            }

            .mobile-project-name {
                font-size: 1rem;
                font-weight: 600;
                color: var(--gray-900);
                margin: 0 0 0.25rem 0;
                line-height: 1.4;
            }

            .mobile-project-description {
                font-size: 0.875rem;
                color: var(--gray-600);
                margin: 0;
                line-height: 1.4;
            }

            .mobile-actions {
                position: relative;
            }

            .btn-mobile-menu {
                width: 32px;
                height: 32px;
                border: none;
                background: var(--gray-100);
                border-radius: var(--radius-sm);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: var(--transition);
                color: var(--gray-600);
            }

            .btn-mobile-menu:hover {
                background: var(--gray-200);
                color: var(--gray-800);
            }

            .mobile-card-content {
                padding: 1.5rem;
            }

            .mobile-info-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            .mobile-info-item {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .mobile-info-label {
                font-size: 0.75rem;
                font-weight: 600;
                color: var(--gray-500);
                text-transform: uppercase;
                letter-spacing: 0.025em;
            }

            .mobile-info-value {
                font-size: 0.875rem;
                color: var(--gray-900);
            }

            .mobile-members-files-list {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .mobile-empty-state {
                display: none;
            }

            /* Empty State */
            .empty-state {
                text-align: center;
                padding: 3rem 2rem;
            }

            .empty-state-cell {
                border: none !important;
            }

            .empty-icon {
                font-size: 4rem;
                color: var(--gray-300);
                margin-bottom: 1rem;
            }

            .empty-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--gray-700);
                margin: 0 0 0.5rem 0;
            }

            .empty-subtitle {
                font-size: 0.875rem;
                color: var(--gray-500);
                margin: 0 0 1.5rem 0;
                line-height: 1.5;
            }

            /* Pagination */
            .pagination-wrapper {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.5rem 2rem;
                border-top: 1px solid var(--gray-200);
                background: var(--gray-50);
            }

            .pagination-info {
                font-size: 0.875rem;
                color: var(--gray-600);
            }

            .pagination-links .pagination {
                margin: 0;
            }

            .pagination .page-link {
                border: 1px solid var(--gray-300);
                color: var(--gray-600);
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
                transition: var(--transition);
            }

            .pagination .page-link:hover {
                background: var(--gray-50);
                border-color: var(--gray-400);
                color: var(--gray-700);
            }

            .pagination .page-item.active .page-link {
                background: var(--primary);
                border-color: var(--primary);
                color: white;
            }

            /* Utility Classes */
            .text-muted {
                color: var(--gray-500) !important;
            }

            .d-inline {
                display: inline !important;
            }

            .me-1 {
                margin-right: 0.25rem !important;
            }

            .me-2 {
                margin-right: 0.5rem !important;
            }

            .ms-2 {
                margin-left: 0.5rem !important;
            }

            /* Responsive Design */
            @media (max-width: 1024px) {
                .main-container {
                    padding: 1.5rem 1rem;
                }

                .stats-grid {
                    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                    gap: 1rem;
                }

                .stat-card {
                    padding: 1.5rem;
                }

                .table-header {
                    padding: 1.5rem;
                }

                .table-controls {
                    flex-direction: column;
                    align-items: stretch;
                    gap: 1rem;
                }

                .search-controls {
                    flex-direction: column;
                    gap: 1rem;
                }

                .search-input {
                    width: 100%;
                }

                .action-controls {
                    justify-content: flex-end;
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

                .stats-grid {
                    grid-template-columns: 1fr;
                    gap: 1rem;
                }

                .stat-card {
                    padding: 1.25rem;
                }

                .stat-content {
                    gap: 0.75rem;
                }

                .stat-icon {
                    width: 3rem;
                    height: 3rem;
                    font-size: 1.25rem;
                }

                .stat-number {
                    font-size: 1.75rem;
                }

                /* Hide desktop table, show mobile cards */
                .table-wrapper {
                    display: none;
                }

                .mobile-cards {
                    display: block;
                    padding: 1rem;
                }

                .mobile-empty-state {
                    display: block;
                }

                .pagination-wrapper {
                    flex-direction: column;
                    gap: 1rem;
                    text-align: center;
                    padding: 1rem;
                }

                .mobile-info-grid {
                    grid-template-columns: 1fr;
                    gap: 0.75rem;
                }

                .search-controls {
                    width: 100%;
                }

                .action-controls {
                    width: 100%;
                    justify-content: stretch;
                }

                .action-controls .btn {
                    flex: 1;
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

                .page-subtitle {
                    font-size: 0.875rem;
                }

                .btn-create {
                    padding: 0.75rem 1.5rem;
                    font-size: 0.875rem;
                }

                .mobile-card-header,
                .mobile-card-content {
                    padding: 1rem;
                }

                .mobile-project-info {
                    gap: 0.75rem;
                }

                .mobile-project-icon {
                    width: 2rem;
                    height: 2rem;
                    font-size: 1rem;
                }

                .mobile-project-name {
                    font-size: 0.925rem;
                }

                .mobile-project-description {
                    font-size: 0.8125rem;
                }
            }

            /* Animation for filtered rows */
            .project-row {
                transition: opacity 0.3s ease, transform 0.3s ease;
            }

            .project-row[style*="display: none"] {
                opacity: 0;
                transform: scale(0.95);
            }

            /* Loading state */
            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }
            }

            .loading {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            /* Focus styles for better accessibility */
            .btn:focus-visible,
            .search-input:focus-visible,
            .filter-select:focus-visible {
                outline: 2px solid var(--primary);
                outline-offset: 2px;
            }

            /* Dropdown improvements */
            .dropdown-menu {
                border: 1px solid var(--gray-200);
                border-radius: var(--radius);
                box-shadow: var(--shadow-lg);
                padding: 0.5rem 0;
                margin-top: 0.25rem;
            }

            .dropdown-item {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                color: var(--gray-700);
                transition: var(--transition-fast);
                display: flex;
                align-items: center;
            }

            .dropdown-item:hover {
                background: var(--gray-50);
                color: var(--gray-900);
            }

            .dropdown-item.text-danger {
                color: var(--danger);
            }

            .dropdown-item.text-danger:hover {
                background: var(--danger-bg);
                color: var(--danger);
            }

            .dropdown-divider {
                margin: 0.25rem 0;
                border-color: var(--gray-200);
            }

            /* Custom scrollbar */
            .table-wrapper::-webkit-scrollbar {
                height: 6px;
            }

            .table-wrapper::-webkit-scrollbar-track {
                background: var(--gray-100);
                border-radius: 3px;
            }

            .table-wrapper::-webkit-scrollbar-thumb {
                background: var(--gray-300);
                border-radius: 3px;
            }

            .table-wrapper::-webkit-scrollbar-thumb:hover {
                background: var(--gray-400);
            }

            .warning-sync {
                color: var(--warning);
                font-size: 0.75rem;
                margin-top: 0.25rem;
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
                const projectRows = document.querySelectorAll('.project-row');
                const emptyState = document.getElementById('emptyState');
                const mobileEmptyState = document.getElementById('mobileEmptyState');

                // Search functionality with improved performance
                function performSearch() {
                    const searchTerm = projectSearch.value.toLowerCase().trim();
                    const selectedMonth = monthFilter.value;
                    let visibleCount = 0;

                    // Add loading state
                    document.body.classList.add('loading');

                    // Use requestAnimationFrame for smooth animations
                    requestAnimationFrame(() => {
                        projectRows.forEach(row => {
                            const projectName = row.querySelector('.project-name, .mobile-project-name')
                                ?.textContent.toLowerCase() || '';
                            const projectDescription = row.querySelector(
                                    '.project-description, .mobile-project-description')?.textContent
                                .toLowerCase() || '';
                            const projectDuration = row.querySelector('.project-duration')?.textContent
                                .toLowerCase() || '';
                            const ndaDateElement = row.querySelector('.project-nda-date');
                            const ndaMonth = ndaDateElement?.dataset.month ||
                                ''; // Gunakan data-month dari signature_date pertama

                            const matchesSearch = searchTerm === '' || projectName.includes(
                                    searchTerm) || projectDescription.includes(searchTerm) ||
                                projectDuration.includes(searchTerm);
                            const matchesMonth = selectedMonth === '' || ndaMonth === selectedMonth;

                            if (matchesSearch && matchesMonth) {
                                row.style.display = '';
                                visibleCount++;
                            } else {
                                row.style.display = 'none';
                                const checkbox = row.querySelector('.nda-checkbox');
                                if (checkbox) checkbox.checked = false;
                            }
                        });

                        // Show/hide empty states
                        if (emptyState) {
                            emptyState.style.display = visibleCount === 0 ? '' : 'none';
                        }
                        if (mobileEmptyState) {
                            mobileEmptyState.style.display = visibleCount === 0 ? 'block' : 'none';
                        }

                        // Update UI state
                        updateBulkDeleteButton();
                        updateSelectAllCheckbox();

                        // Remove loading state
                        document.body.classList.remove('loading');
                    });
                }

                // Improved debounced search
                let searchTimeout;
                projectSearch.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        const url = new URL(window.location);
                        if (this.value.trim()) {
                            url.searchParams.set('search', this.value.trim());
                        } else {
                            url.searchParams.delete('search');
                        }
                        window.history.replaceState({}, '', url);
                        performSearch();
                    }, 300);
                });

                // Month filter with immediate response
                monthFilter.addEventListener('change', function() {
                    const url = new URL(window.location);
                    if (this.value) {
                        url.searchParams.set('month', this.value);
                    } else {
                        url.searchParams.delete('month');
                    }
                    window.history.replaceState({}, '', url);
                    performSearch();
                });

                // Clear filters with animation
                clearFiltersBtn.addEventListener('click', function() {
                    projectSearch.value = '';
                    monthFilter.value = '';

                    const url = new URL(window.location);
                    url.searchParams.delete('search');
                    url.searchParams.delete('month');
                    window.history.replaceState({}, '', url);

                    // Add a small delay for better UX
                    setTimeout(() => {
                        performSearch();
                    }, 100);
                });

                // Enhanced select all functionality
                selectAllCheckbox.addEventListener('change', function() {
                    const visibleCheckboxes = Array.from(ndaCheckboxes).filter(checkbox => {
                        const row = checkbox.closest('.project-row');
                        return row && row.style.display !== 'none';
                    });

                    visibleCheckboxes.forEach((checkbox, index) => {
                        setTimeout(() => {
                            checkbox.checked = this.checked;
                        }, index * 20); // Staggered animation
                    });

                    setTimeout(() => {
                        updateBulkDeleteButton();
                    }, visibleCheckboxes.length * 20);
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
                        const row = checkbox.closest('.project-row');
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

                // Update bulk delete button state with count
                function updateBulkDeleteButton() {
                    const checkedCount = Array.from(ndaCheckboxes).filter(cb => cb.checked).length;
                    bulkDeleteBtn.disabled = checkedCount === 0;

                    // Update button text with count
                    const buttonText = bulkDeleteBtn.querySelector('span') || bulkDeleteBtn;
                    if (checkedCount > 0) {
                        buttonText.textContent = `Hapus ${checkedCount} Terpilih`;
                        bulkDeleteBtn.classList.add('btn-danger-active');
                    } else {
                        buttonText.textContent = 'Hapus Terpilih';
                        bulkDeleteBtn.classList.remove('btn-danger-active');
                    }
                }

                // Enhanced bulk delete functionality with better UX
                bulkDeleteBtn.addEventListener('click', function() {
                    const checkedBoxes = Array.from(ndaCheckboxes).filter(cb => cb.checked);

                    if (checkedBoxes.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak Ada Pilihan',
                            text: 'Pilih setidaknya satu proyek untuk dihapus.',
                            confirmButtonText: 'Mengerti',
                            confirmButtonColor: '#4f46e5',
                            customClass: {
                                popup: 'swal-custom-popup',
                                title: 'swal-custom-title',
                                content: 'swal-custom-content'
                            }
                        });
                        return;
                    }

                    // Get project names for better confirmation message
                    const projectNames = checkedBoxes.map(cb => {
                        const row = cb.closest('.project-row');
                        const nameElement = row.querySelector('.project-name, .mobile-project-name');
                        return nameElement ? nameElement.textContent.trim() : '';
                    }).filter(name => name);

                    const projectList = projectNames.length <= 3 ?
                        projectNames.join(', ') :
                        `${projectNames.slice(0, 3).join(', ')} dan ${projectNames.length - 3} lainnya`;

                    Swal.fire({
                        title: 'Konfirmasi Hapus Batch',
                        html: `
                            <div style="text-align: left; margin: 1rem 0;">
                                <p>Anda akan menghapus <strong>${checkedBoxes.length} proyek</strong>:</p>
                                <p style="color: #6b7280; font-size: 0.9rem; margin-top: 0.5rem;">${projectList}</p>
                                <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 1rem; margin-top: 1rem;">
                                    <p style="color: #92400e; font-size: 0.85rem; margin: 0;">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait proyek.
                                    </p>
                                </div>
                            </div>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: `Ya, Hapus ${checkedBoxes.length} Proyek`,
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            popup: 'swal-custom-popup',
                            title: 'swal-custom-title',
                            htmlContainer: 'swal-custom-html',
                            confirmButton: 'swal-custom-confirm',
                            cancelButton: 'swal-custom-cancel'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.fire({
                                title: 'Menghapus Proyek...',
                                html: 'Mohon tunggu, sedang memproses penghapusan.',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

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

                // Enhanced single delete functionality
                document.querySelectorAll('.delete-single-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();

                        const projectName = this.dataset.projectName;
                        const form = this.closest('form');

                        Swal.fire({
                            title: 'Konfirmasi Hapus Proyek',
                            html: `
                                <div style="text-align: left; margin: 1rem 0;">
                                    <p>Anda akan menghapus proyek:</p>
                                    <p style="font-weight: 600; color: #374151; background: #f3f4f6; padding: 0.75rem; border-radius: 6px; margin: 0.5rem 0;">
                                        "${projectName}"
                                    </p>
                                    <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 1rem; margin-top: 1rem;">
                                        <p style="color: #92400e; font-size: 0.85rem; margin: 0;">
                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                            Tindakan ini akan menghapus semua data proyek termasuk NDA, berkas, dan anggota tim.
                                        </p>
                                    </div>
                                </div>
                            `,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Hapus Proyek',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            customClass: {
                                popup: 'swal-custom-popup',
                                title: 'swal-custom-title',
                                htmlContainer: 'swal-custom-html',
                                confirmButton: 'swal-custom-confirm',
                                cancelButton: 'swal-custom-cancel'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Show loading state
                                Swal.fire({
                                    title: 'Menghapus Proyek...',
                                    html: 'Mohon tunggu, sedang memproses penghapusan.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                                form.submit();
                            }
                        });
                    });
                });

                // Keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    // Ctrl/Cmd + K to focus search
                    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                        e.preventDefault();
                        projectSearch.focus();
                        projectSearch.select();
                    }

                    // Escape to clear search
                    if (e.key === 'Escape' && document.activeElement === projectSearch) {
                        projectSearch.value = '';
                        projectSearch.blur();
                        performSearch();
                    }
                });

                // Smooth scroll to top when filters change
                function smoothScrollToTop() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }

                // Enhanced mobile responsiveness
                function handleResize() {
                    const isMobile = window.innerWidth <= 768;

                    if (isMobile) {
                        // Ensure mobile cards are visible
                        document.querySelector('.mobile-cards').style.display = 'block';
                        document.querySelector('.table-wrapper').style.display = 'none';
                    } else {
                        // Ensure desktop table is visible
                        document.querySelector('.mobile-cards').style.display = 'none';
                        document.querySelector('.table-wrapper').style.display = 'block';
                    }
                }

                // Handle window resize
                let resizeTimeout;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(handleResize, 250);
                });

                // Intersection Observer for animation on scroll
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-in');
                        }
                    });
                }, observerOptions);

                // Observe stat cards and project rows for animation
                document.querySelectorAll('.stat-card, .project-row, .mobile-card').forEach(el => {
                    observer.observe(el);
                });

                // Touch gestures for mobile
                let touchStartX = 0;
                let touchStartY = 0;

                document.addEventListener('touchstart', function(e) {
                    touchStartX = e.touches[0].clientX;
                    touchStartY = e.touches[0].clientY;
                }, {
                    passive: true
                });

                document.addEventListener('touchend', function(e) {
                    if (!touchStartX || !touchStartY) return;

                    const touchEndX = e.changedTouches[0].clientX;
                    const touchEndY = e.changedTouches[0].clientY;

                    const diffX = touchStartX - touchEndX;
                    const diffY = touchStartY - touchEndY;

                    // Horizontal swipe on mobile cards for actions
                    if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                        const card = e.target.closest('.mobile-card');
                        if (card && window.innerWidth <= 768) {
                            if (diffX > 0) {
                                // Swipe left - show actions
                                card.classList.add('swiped-left');
                            } else {
                                // Swipe right - hide actions
                                card.classList.remove('swiped-left');
                            }
                        }
                    }

                    touchStartX = 0;
                    touchStartY = 0;
                }, {
                    passive: true
                });

                // Initialize
                performSearch();
                handleResize();
                updateBulkDeleteButton();

                // Add loading states for better UX
                function addLoadingState(element, text = 'Loading...') {
                    element.disabled = true;
                    element.innerHTML = `
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        ${text}
                    `;
                }

                // Success messages with better styling
                function showSuccessMessage(title, text) {
                    Swal.fire({
                        icon: 'success',
                        title: title,
                        text: text,
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal-custom-popup',
                            title: 'swal-custom-title',
                            content: 'swal-custom-content'
                        }
                    });
                }

                // Auto-save search and filter preferences
                function saveFilterPreferences() {
                    const preferences = {
                        search: projectSearch.value,
                        month: monthFilter.value
                    };
                    localStorage.setItem('nda-filter-preferences', JSON.stringify(preferences));
                }

                function loadFilterPreferences() {
                    const saved = localStorage.getItem('nda-filter-preferences');
                    if (saved) {
                        try {
                            const preferences = JSON.parse(saved);
                            if (preferences.search && !projectSearch.value) {
                                projectSearch.value = preferences.search;
                            }
                            if (preferences.month && !monthFilter.value) {
                                monthFilter.value = preferences.month;
                            }
                        } catch (e) {
                            console.warn('Failed to load filter preferences:', e);
                        }
                    }
                }

                // Load preferences on page load
                loadFilterPreferences();

                // Save preferences when filters change
                projectSearch.addEventListener('input', saveFilterPreferences);
                monthFilter.addEventListener('change', saveFilterPreferences);
            });

            // Custom SweetAlert styles
            const swalStyles = document.createElement('style');
            swalStyles.innerHTML = `
                .swal-custom-popup {
                    border-radius: 16px !important;
                    padding: 0 !important;
                }

                .swal-custom-title {
                    font-size: 1.25rem !important;
                    font-weight: 700 !important;
                    color: #1f2937 !important;
                    margin-bottom: 0.5rem !important;
                }

                .swal-custom-content {
                    font-size: 0.9rem !important;
                    line-height: 1.5 !important;
                    color: #4b5563 !important;
                }

                .swal-custom-html {
                    margin: 0 !important;
                    padding: 0 !important;
                }

                .swal-custom-confirm {
                    border-radius: 8px !important;
                    padding: 0.75rem 1.5rem !important;
                    font-weight: 600 !important;
                    font-size: 0.875rem !important;
                }

                .swal-custom-cancel {
                    border-radius: 8px !important;
                    padding: 0.75rem 1.5rem !important;
                    font-weight: 600 !important;
                    font-size: 0.875rem !important;
                }

                .swal2-actions {
                    gap: 0.75rem !important;
                    margin-top: 1.5rem !important;
                }

                .swal2-loader {
                    border-color: #4f46e5 transparent #4f46e5 transparent !important;
                }
            `;
            document.head.appendChild(swalStyles);

            // Add animation styles
            const animationStyles = document.createElement('style');
            animationStyles.innerHTML = `
                /* Animation classes */
                .animate-in {
                    animation: slideInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                }

                @keyframes slideInUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                /* Mobile swipe states */
                .mobile-card.swiped-left {
                    transform: translateX(-60px);
                    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                }

                .mobile-card.swiped-left::after {
                    content: '';
                    position: absolute;
                    right: -60px;
                    top: 0;
                    width: 60px;
                    height: 100%;
                    background: linear-gradient(90deg, #ef4444, #dc2626);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-family: 'bootstrap-icons';
                    font-size: 1.25rem;
                }

                /* Button active states */
                .btn-danger-active {
                    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
                    color: white !important;
                    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
                    transform: translateY(-1px);
                }

                /* Loading spinner */
                .spinner-border-sm {
                    width: 1rem;
                    height: 1rem;
                    border-width: 0.15em;
                }

                /* Enhanced focus states */
                .btn:focus-visible,
                .search-input:focus-visible,
                .filter-select:focus-visible,
                .table-checkbox:focus-visible + label {
                    outline: 2px solid #4f46e5 !important;
                    outline-offset: 2px !important;
                    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12) !important;
                }

                /* Improved table hover states */
                .projects-table tbody tr:hover .btn-action {
                    transform: scale(1.1);
                }

                /* Better mobile card interactions */
                .mobile-card:active {
                    transform: scale(0.98);
                }

                /* Status badge animations */
                .status-badge {
                    animation: fadeIn 0.3s ease-in-out;
                }

                @keyframes fadeIn {
                    from { opacity: 0; transform: scale(0.9); }
                    to { opacity: 1; transform: scale(1); }
                }
            `;
            document.head.appendChild(animationStyles);
        </script>
    @endpush
@endsection
