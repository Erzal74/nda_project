@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 text-gray-900 mb-1">Proyek NDA</h1>
                <p class="text-muted mb-0">Kelola dokumen Non-Disclosure Agreement dan detail proyek Anda.</p>
            </div>
            <a href="{{ route('admin.nda.create') }}" class="btn btn-primary btn-modern">
                <i class="bi bi-plus-lg me-2"></i>Proyek Baru
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary-soft">
                                <i class="bi bi-folder-fill text-primary"></i>
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
                <div class="card stat-card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success-soft">
                                <i class="bi bi-check-circle-fill text-success"></i>
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
                <div class="card stat-card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-info-soft">
                                <i class="bi bi-files text-info"></i>
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
                <div class="card stat-card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-warning-soft">
                                <i class="bi bi-person-fill text-warning"></i>
                            </div>
                            <div class="ms-3">
                                <div class="stat-number">
                                    {{ $ndas->sum(function ($nda) {
                                        return is_array($nda->members)
                                            ? count($nda->members)
                                            : (is_string($nda->members) && json_decode($nda->members) !== null
                                                ? count(json_decode($nda->members, true))
                                                : 0);
                                    }) }}
                                </div>
                                <div class="stat-label">Total Anggota</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">Daftar Proyek</h5>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex gap-2 flex-wrap">
                            <!-- Search Bar -->
                            <div class="position-relative">
                                <input type="search" class="form-control form-control-sm ps-4" placeholder="Cari proyek..."
                                    id="projectSearch" style="width: 200px;" value="{{ request('search') }}">
                                <i
                                    class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-2 text-muted"></i>
                            </div>

                            <!-- Month Filter -->
                            <select class="form-select form-select-sm" id="monthFilter" style="width: 150px;">
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
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="clearFilters">
                                <i class="bi bi-x-lg"></i>
                            </button>

                            <!-- Bulk Delete Button -->
                            <button type="button" class="btn btn-outline-danger btn-sm" id="bulkDeleteNdasBtn" disabled>
                                <i class="bi bi-trash me-1"></i>Hapus Terpilih
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
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
                                <tr class="project-row">
                                    <td>{{ $ndas->firstItem() + $key }}</td>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input nda-checkbox"
                                                value="{{ $nda->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="project-avatar">
                                                <i class="bi bi-folder-fill"></i>
                                            </div>
                                            <div class="ms-3">
                                                <div class="fw-semibold text-gray-900 project-name">
                                                    {{ $nda->project_name }}</div>
                                                <div class="small text-muted project-description">
                                                    {{ Str::limit($nda->description, 40) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="project-duration">
                                        @if ($nda->start_date && $nda->end_date)
                                            <div class="small text-gray-900">{{ $nda->start_date->format('d M') }} -
                                                {{ $nda->end_date->format('d M Y') }}</div>
                                            <div class="small text-muted">{{ $nda->formatted_duration }}</div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="project-nda-date"
                                        data-month="{{ $nda->nda_signature_date ? $nda->nda_signature_date->format('m') : '' }}">
                                        @if ($nda->nda_signature_date)
                                            <div class="badge bg-success-soft text-success">
                                                {{ $nda->nda_signature_date->format('d M Y') }}</div>
                                        @else
                                            <div class="badge bg-warning-soft text-warning">Menunggu</div>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $members = is_array($nda->members)
                                                ? $nda->members
                                                : (is_string($nda->members) && json_decode($nda->members) !== null
                                                    ? json_decode($nda->members, true)
                                                    : []);
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
                                                            <i
                                                                class="bi bi-file-earmark-text me-1"></i>{{ basename($file->file_path) }}
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
                                            <a href="{{ route('admin.nda.detail', $nda) }}"
                                                class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.nda.edit', $nda) }}"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.nda.delete', $nda) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger delete-single-btn"
                                                    data-project-name="{{ $nda->project_name }}" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyState">
                                    <td colspan="8" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bi bi-folder-x display-4 text-muted mb-3"></i>
                                            <h5 class="text-muted">Tidak Ada Proyek Ditemukan</h5>
                                            <p class="text-muted mb-3">Mulai dengan membuat proyek NDA pertama Anda.</p>
                                            <a href="{{ route('admin.nda.create') }}" class="btn btn-primary btn-modern">
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

            <!-- Pagination -->
            @if ($ndas->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan {{ $ndas->firstItem() }} sampai {{ $ndas->lastItem() }} dari {{ $ndas->total() }}
                            hasil
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
    <form id="bulkDeleteForm" action="{{ route('admin.nda.bulk-delete') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <div id="selectedIds"></div>
    </form>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>

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

            // Search functionality
            function performSearch() {
                const searchTerm = projectSearch.value.toLowerCase().trim();
                const selectedMonth = monthFilter.value;
                let visibleCount = 0;

                projectRows.forEach(row => {
                    const projectName = row.querySelector('.project-name')?.textContent.toLowerCase() || '';
                    const projectDescription = row.querySelector('.project-description')?.textContent
                        .toLowerCase() || '';
                    const projectDuration = row.querySelector('.project-duration')?.textContent
                        .toLowerCase() || '';
                    const ndaDateElement = row.querySelector('.project-nda-date');
                    const ndaMonth = ndaDateElement?.dataset.month || '';

                    const matchesSearch = searchTerm === '' ||
                        projectName.includes(searchTerm) ||
                        projectDescription.includes(searchTerm) ||
                        projectDuration.includes(searchTerm);

                    const matchesMonth = selectedMonth === '' || ndaMonth === selectedMonth;

                    if (matchesSearch && matchesMonth) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                        // Uncheck hidden rows
                        const checkbox = row.querySelector('.nda-checkbox');
                        if (checkbox) checkbox.checked = false;
                    }
                });

                // Show/hide empty state
                if (emptyState) {
                    emptyState.style.display = visibleCount === 0 ? '' : 'none';
                }

                // Update bulk delete button state
                updateBulkDeleteButton();
                // Update select all checkbox
                updateSelectAllCheckbox();
            }

            // Search input event
            projectSearch.addEventListener('input', performSearch);

            // Month filter event
            monthFilter.addEventListener('change', function() {
                // Update URL with filter parameters
                const url = new URL(window.location);
                if (this.value) {
                    url.searchParams.set('month', this.value);
                } else {
                    url.searchParams.delete('month');
                }
                if (projectSearch.value) {
                    url.searchParams.set('search', projectSearch.value);
                } else {
                    url.searchParams.delete('search');
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
                    return checkbox.closest('.project-row').style.display !== 'none';
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
                    return checkbox.closest('.project-row').style.display !== 'none';
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
                    alert('Pilih setidaknya satu proyek untuk dihapus.');
                    return;
                }

                const deleteMessage =
                    `Apakah Anda yakin ingin menghapus ${checkedBoxes.length} proyek yang dipilih? Tindakan ini akan menghapus data secara permanen.`;
                document.getElementById('deleteMessage').textContent = deleteMessage;

                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();

                document.getElementById('confirmDeleteBtn').onclick = function() {
                    // Clear previous hidden inputs
                    const selectedIdsContainer = document.getElementById('selectedIds');
                    selectedIdsContainer.innerHTML = '';

                    // Add selected IDs to form
                    checkedBoxes.forEach(checkbox => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'nda_ids[]';
                        input.value = checkbox.value;
                        selectedIdsContainer.appendChild(input);
                    });

                    // Submit form
                    document.getElementById('bulkDeleteForm').submit();
                };
            });

            // Single delete functionality
            document.querySelectorAll('.delete-single-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const projectName = this.dataset.projectName;
                    const form = this.closest('form');

                    const deleteMessage =
                        `Apakah Anda yakin ingin menghapus proyek "${projectName}"? Tindakan ini akan menghapus data secara permanen.`;
                    document.getElementById('deleteMessage').textContent = deleteMessage;

                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();

                    document.getElementById('confirmDeleteBtn').onclick = function() {
                        form.submit();
                    };
                });
            });

            // Initial load
            performSearch();
        });
    </script>

    <style>
        .project-row {
            transition: opacity 0.3s ease;
        }

        .project-row[style*="none"] {
            opacity: 0;
        }

        .btn-modern {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 16px;
        }

        .stat-card {
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
        }

        .stat-label {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }

        .project-avatar {
            width: 40px;
            height: 40px;
            background: #f3f4f6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
        }

        .bg-primary-soft {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .bg-success-soft {
            background-color: rgba(34, 197, 94, 0.1);
        }

        .bg-info-soft {
            background-color: rgba(6, 182, 212, 0.1);
        }

        .bg-warning-soft {
            background-color: rgba(245, 158, 11, 0.1);
        }

        .badge.bg-success-soft {
            background-color: rgba(34, 197, 94, 0.1) !important;
            color: #059669 !important;
        }

        .badge.bg-warning-soft {
            background-color: rgba(245, 158, 11, 0.1) !important;
            color: #d97706 !important;
        }

        .table th {
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .table td {
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }

        .table tbody tr:hover {
            background-color: #f9fafb;
        }

        .empty-state i {
            opacity: 0.5;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .member-list {
            padding-left: 20px;
            /* Ruang untuk bullet */
            margin: 0;
            font-size: 0.875rem;
            /* Ukuran font kecil */
            line-height: 1.2;
            /* Jarak antar baris kecil */
            max-height: 100px;
            /* Batas tinggi, scroll jika banyak */
            overflow-y: auto;
        }

        .member-list li {
            margin-bottom: 2px;
            /* Jarak kecil antar item */
        }

        .file-list {
            margin: 0;
            padding: 0;
            font-size: 0.875rem;
            line-height: 1.2;
        }

        .file-list li {
            margin-bottom: 2px;
        }

        .file-list a {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endsection
