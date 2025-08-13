@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="fw-bold mb-2">
                                <i class="bi bi-speedometer2 me-2 text-primary"></i>
                                Selamat Datang, {{ Auth::user()->name }}
                            </h2>
                            <p class="text-muted mb-0">Kelola dan pantau dokumen NDA Anda dengan mudah</p>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ now()->format('d F Y') }}
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-clock me-1"></i>
                                {{ now()->format('H:i') }} WIB
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="modern-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-text display-4 text-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $ndas->count() }}</h3>
                    <p class="text-muted mb-0 small">Total Proyek NDA</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="modern-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-check-circle display-4 text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $ndas->whereNotNull('nda_signature_date')->count() }}</h3>
                    <p class="text-muted mb-0 small">Telah Ditandatangani</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="modern-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-clock-history display-4 text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $ndas->whereNull('nda_signature_date')->count() }}</h3>
                    <p class="text-muted mb-0 small">Menunggu Tanda Tangan</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="modern-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-download display-4 text-info"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $ndas->whereNotNull('token')->count() }}</h3>
                    <p class="text-muted mb-0 small">File Tersedia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">
                            <i class="bi bi-folder2-open me-2"></i>
                            Daftar Proyek NDA
                        </h5>
                        <small class="text-muted">Kelola semua dokumen NDA Anda</small>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-modern btn-outline-modern btn-sm" onclick="refreshTable()">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-modern btn-outline-modern btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-filter me-1"></i>Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="filterTable('all')">Semua</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterTable('signed')">Sudah TTD</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="filterTable('pending')">Belum TTD</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Search Section -->
                @if ($ndas->count() > 0)
                    <div class="card-body border-bottom">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <div class="position-relative">
                                    <input type="text" class="form-control form-control-lg" id="searchInput"
                                        placeholder="Cari berdasarkan nama proyek, ID, atau tanggal..."
                                        style="padding-left: 45px;">
                                    <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-secondary flex-fill" onclick="clearSearch()">
                                        <i class="bi bi-x-circle me-1"></i>Clear
                                    </button>
                                    <div class="dropdown flex-fill">
                                        <button class="btn btn-outline-primary dropdown-toggle w-100" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-funnel me-1"></i>Search By
                                        </button>
                                        <ul class="dropdown-menu w-100">
                                            <li><a class="dropdown-item" href="#" onclick="setSearchFilter('all')">
                                                    <i class="bi bi-globe me-2"></i>Semua Field
                                                </a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    onclick="setSearchFilter('project')">
                                                    <i class="bi bi-briefcase me-2"></i>Nama Proyek
                                                </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="setSearchFilter('id')">
                                                    <i class="bi bi-hash me-2"></i>ID Proyek
                                                </a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    onclick="setSearchFilter('date')">
                                                    <i class="bi bi-calendar me-2"></i>Tanggal
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Search Results Info -->
                        <div class="mt-3">
                            <div id="searchResults" class="text-muted small" style="display: none;">
                                <i class="bi bi-info-circle me-1"></i>
                                <span id="searchResultsText"></span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card-body p-0">
                    @if ($ndas->count() > 0)
                        <div class="modern-table">
                            <table class="table table-hover mb-0" id="ndaTable">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 25%;">
                                            <i class="bi bi-briefcase me-1"></i>Nama Proyek
                                        </th>
                                        <th style="width: 12%;">
                                            <i class="bi bi-calendar-event me-1"></i>Mulai
                                        </th>
                                        <th style="width: 12%;">
                                            <i class="bi bi-calendar-check me-1"></i>Selesai
                                        </th>
                                        <th style="width: 10%;">
                                            <i class="bi bi-hourglass me-1"></i>Durasi
                                        </th>
                                        <th style="width: 12%;">
                                            <i class="bi bi-pen me-1"></i>Tgl TTD
                                        </th>
                                        <th style="width: 16%;">
                                            <i class="bi bi-gear me-1"></i>Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ndas as $index => $nda)
                                        <tr data-status="{{ $nda->nda_signature_date ? 'signed' : 'pending' }}"
                                            data-project-name="{{ strtolower($nda->project_name) }}"
                                            data-project-id="{{ str_pad($nda->id, 4, '0', STR_PAD_LEFT) }}"
                                            data-start-date="{{ $nda->start_date ? $nda->start_date->format('d/m/Y') : '' }}"
                                            data-end-date="{{ $nda->end_date ? $nda->end_date->format('d/m/Y') : '' }}"
                                            data-signature-date="{{ $nda->nda_signature_date ? $nda->nda_signature_date->format('d/m/Y') : '' }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 40px; height: 40px;">
                                                            <i class="bi bi-briefcase"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $nda->project_name }}</div>
                                                        <small class="text-muted">ID:
                                                            #{{ str_pad($nda->id, 4, '0', STR_PAD_LEFT) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-calendar3 text-success me-2"></i>
                                                    <span>{{ $nda->start_date ? $nda->start_date->format('d/m/Y') : '-' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-calendar-x text-danger me-2"></i>
                                                    <span>{{ $nda->end_date ? $nda->end_date->format('d/m/Y') : '-' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info bg-opacity-10 text-info">
                                                    {{ $nda->formatted_duration }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($nda->nda_signature_date)
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-check-circle text-success me-2"></i>
                                                        <span>{{ $nda->nda_signature_date->format('d/m/Y') }}</span>
                                                    </div>
                                                @else
                                                    <span class="status-badge status-pending">
                                                        <i class="bi bi-clock me-1"></i>Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('user.nda.detail', $nda) }}"
                                                        class="btn btn-modern btn-primary-modern btn-sm"
                                                        data-bs-toggle="tooltip" title="Lihat Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @if ($nda->token)
                                                        <a href="{{ route('file.preview', $nda->token) }}"
                                                            target="_blank"
                                                            class="btn btn-modern btn-secondary-modern btn-sm"
                                                            data-bs-toggle="tooltip" title="Preview File">
                                                            <i class="bi bi-search"></i>
                                                        </a>
                                                        <a href="{{ route('file.download', $nda->token) }}"
                                                            class="btn btn-modern btn-success-modern btn-sm"
                                                            data-bs-toggle="tooltip" title="Download File">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- No Results Message -->
                        <div id="noResults" class="card-body text-center py-5" style="display: none;">
                            <div class="mb-4">
                                <i class="bi bi-search display-1 text-muted opacity-50"></i>
                            </div>
                            <h5 class="text-muted mb-2">Tidak Ada Hasil Ditemukan</h5>
                            <p class="text-muted mb-4">Tidak ada proyek NDA yang sesuai dengan pencarian Anda.</p>
                            <button class="btn btn-modern btn-primary-modern" onclick="clearSearch()">
                                <i class="bi bi-x-circle me-2"></i>Clear Search
                            </button>
                        </div>
                    @else
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-folder2-open display-1 text-muted opacity-50"></i>
                            </div>
                            <h5 class="text-muted mb-2">Belum Ada Proyek NDA</h5>
                            <p class="text-muted mb-4">Anda belum memiliki proyek NDA yang terdaftar dalam sistem.</p>
                            <button class="btn btn-modern btn-primary-modern" onclick="refreshTable()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    @if ($ndas->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="modern-card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-lightning me-2"></i>
                            Aksi Cepat
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-grid">
                                    <button class="btn btn-modern btn-outline-modern" onclick="downloadAllFiles()">
                                        <i class="bi bi-download me-2"></i>
                                        Download Semua File
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-grid">
                                    <button class="btn btn-modern btn-outline-modern" onclick="exportToExcel()">
                                        <i class="bi bi-file-earmark-excel me-2"></i>
                                        Export ke Excel
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-grid">
                                    <button class="btn btn-modern btn-outline-modern" onclick="printReport()">
                                        <i class="bi bi-printer me-2"></i>
                                        Cetak Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        // Search variables
        let searchFilter = 'all';
        let currentFilter = 'all';

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize search functionality
            initializeSearch();
        });

        // Initialize search functionality
        function initializeSearch() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    performSearch();
                });

                // Add keyboard shortcuts
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        clearSearch();
                    }
                });
            }
        }

        // Perform search function
        function performSearch() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const rows = document.querySelectorAll('#ndaTable tbody tr');
            const noResults = document.getElementById('noResults');
            const searchResults = document.getElementById('searchResults');
            const searchResultsText = document.getElementById('searchResultsText');

            let visibleCount = 0;
            let totalRows = rows.length;

            if (searchTerm === '') {
                // No search term, show all rows that match current filter
                rows.forEach(row => {
                    const status = row.getAttribute('data-status');
                    if (currentFilter === 'all' || status === currentFilter) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                searchResults.style.display = 'none';
            } else {
                // Perform search
                rows.forEach(row => {
                    const status = row.getAttribute('data-status');
                    let shouldShow = false;

                    // Check if row matches current filter first
                    if (currentFilter === 'all' || status === currentFilter) {
                        // Then check search criteria
                        shouldShow = matchesSearchCriteria(row, searchTerm);
                    }

                    if (shouldShow) {
                        row.style.display = '';
                        visibleCount++;
                        highlightSearchTerm(row, searchTerm);
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show search results info
                searchResults.style.display = 'block';
                searchResultsText.textContent =
                    `Menampilkan ${visibleCount} dari ${totalRows} proyek untuk "${searchTerm}"`;
            }

            // Show/hide no results message
            if (visibleCount === 0 && searchTerm !== '') {
                noResults.style.display = 'block';
                document.querySelector('.modern-table').style.display = 'none';
            } else {
                noResults.style.display = 'none';
                document.querySelector('.modern-table').style.display = 'block';
            }
        }

        // Check if row matches search criteria
        function matchesSearchCriteria(row, searchTerm) {
            const projectName = row.getAttribute('data-project-name');
            const projectId = row.getAttribute('data-project-id');
            const startDate = row.getAttribute('data-start-date');
            const endDate = row.getAttribute('data-end-date');
            const signatureDate = row.getAttribute('data-signature-date');

            switch (searchFilter) {
                case 'project':
                    return projectName.includes(searchTerm);
                case 'id':
                    return projectId.includes(searchTerm);
                case 'date':
                    return startDate.includes(searchTerm) ||
                        endDate.includes(searchTerm) ||
                        signatureDate.includes(searchTerm);
                case 'all':
                default:
                    return projectName.includes(searchTerm) ||
                        projectId.includes(searchTerm) ||
                        startDate.includes(searchTerm) ||
                        endDate.includes(searchTerm) ||
                        signatureDate.includes(searchTerm);
            }
        }

        // Highlight search term in visible rows
        function highlightSearchTerm(row, searchTerm) {
            // Remove existing highlights
            row.querySelectorAll('.search-highlight').forEach(el => {
                el.outerHTML = el.innerHTML;
            });

            if (searchTerm.length < 2) return; // Don't highlight very short terms

            // Highlight matching text
            const textNodes = getTextNodes(row);
            textNodes.forEach(node => {
                const text = node.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    const regex = new RegExp(`(${escapeRegExp(searchTerm)})`, 'gi');
                    const parent = node.parentNode;
                    const wrapper = document.createElement('span');
                    wrapper.innerHTML = node.textContent.replace(regex,
                        '<span class="search-highlight bg-warning bg-opacity-25">$1</span>');
                    parent.replaceChild(wrapper, node);
                    wrapper.outerHTML = wrapper.innerHTML;
                }
            });
        }

        // Get all text nodes in an element
        function getTextNodes(element) {
            const textNodes = [];
            const walker = document.createTreeWalker(
                element,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );
            let node;
            while (node = walker.nextNode()) {
                if (node.textContent.trim()) {
                    textNodes.push(node);
                }
            }
            return textNodes;
        }

        // Escape special regex characters
        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        // Set search filter
        function setSearchFilter(filter) {
            searchFilter = filter;
            const searchInput = document.getElementById('searchInput');

            // Update placeholder text
            const placeholders = {
                'all': 'Cari berdasarkan nama proyek, ID, atau tanggal...',
                'project': 'Cari berdasarkan nama proyek...',
                'id': 'Cari berdasarkan ID proyek...',
                'date': 'Cari berdasarkan tanggal (dd/mm/yyyy)...'
            };

            searchInput.placeholder = placeholders[filter];

            // Re-perform search if there's a search term
            if (searchInput.value.trim() !== '') {
                performSearch();
            }
        }

        // Clear search
        function clearSearch() {
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            const noResults = document.getElementById('noResults');

            searchInput.value = '';
            searchResults.style.display = 'none';
            noResults.style.display = 'none';
            document.querySelector('.modern-table').style.display = 'block';

            // Remove highlights
            document.querySelectorAll('.search-highlight').forEach(el => {
                el.outerHTML = el.innerHTML;
            });

            // Show all rows that match current filter
            filterTable(currentFilter);

            // Focus back to search input
            searchInput.focus();
        }

        // Refresh table function
        function refreshTable() {
            location.reload();
        }

        // Filter table function (updated to work with search)
        function filterTable(status) {
            currentFilter = status;
            const searchInput = document.getElementById('searchInput');

            if (searchInput && searchInput.value.trim() !== '') {
                // If there's a search term, re-perform search with new filter
                performSearch();
            } else {
                // No search term, just apply filter
                const rows = document.querySelectorAll('#ndaTable tbody tr');
                rows.forEach(row => {
                    if (status === 'all') {
                        row.style.display = '';
                    } else {
                        const rowStatus = row.getAttribute('data-status');
                        row.style.display = rowStatus === status ? '' : 'none';
                    }
                });
            }
        }

        // Quick actions
        function downloadAllFiles() {
            window.location.href = "{{ route('user.download.all') }}";
        }

        function exportToExcel() {
            window.location.href = "{{ route('user.export.excel') }}";
        }

        function printReport() {
            window.location.href = "{{ route('user.print.report') }}";
        }

        // Auto-refresh every 5 minutes
        setInterval(function() {
            console.log('Auto-refresh dashboard...');
            // Uncomment the line below to enable auto-refresh
            // location.reload();
        }, 300000); // 5 minutes
    </script>
@endpush
