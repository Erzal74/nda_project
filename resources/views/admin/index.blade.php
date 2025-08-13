@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container">
        <!-- Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                @if ($errors->any())
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Quick Stats -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="modern-card text-center">
                    <div class="card-body">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);">
                            <i class="bi bi-people-fill text-white fs-4"></i>
                        </div>
                        <h3 class="mb-1">{{ $users->count() }}</h3>
                        <p class="text-muted mb-0">Total Pengguna</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="modern-card text-center">
                    <div class="card-body">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <i class="bi bi-file-earmark-lock-fill text-white fs-4"></i>
                        </div>
                        <h3 class="mb-1">{{ $ndas->count() }}</h3>
                        <p class="text-muted mb-0">Proyek NDA</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="modern-card text-center">
                    <div class="card-body">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                            <i class="bi bi-hourglass-split text-white fs-4"></i>
                        </div>
                        <h3 class="mb-1">{{ $users->where('status', 'pending')->count() }}</h3>
                        <p class="text-muted mb-0">Pengguna Pending</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="modern-card text-center">
                    <div class="card-body">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <i class="bi bi-check-circle-fill text-white fs-4"></i>
                        </div>
                        <h3 class="mb-1">{{ $users->where('status', 'approved')->count() }}</h3>
                        <p class="text-muted mb-0">Pengguna Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Management -->
        <div class="modern-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><i class="bi bi-people me-2"></i>Manajemen Pengguna</h5>
                    <small class="text-muted">Kelola pendaftaran dan izin pengguna</small>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="userStatusFilter" style="width: auto;">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="disabled">Disabled</option>
                    </select>
                    <form action="{{ route('admin.user.bulk-delete') }}" method="POST" id="bulkDeleteUsersForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger-modern" id="bulkDeleteUsersBtn" disabled>
                            <i class="bi bi-trash"></i> Hapus Terpilih
                        </button>
                    </form>
                </div>
            </div>
            <div class="modern-table">
                <table class="table table-hover mb-0" id="usersTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">
                                <input type="checkbox" id="selectAllUsers">
                            </th>
                            <th><i class="bi bi-person me-1"></i>Nama</th>
                            <th><i class="bi bi-envelope me-1"></i>Email</th>
                            <th><i class="bi bi-flag me-1"></i>Status</th>
                            <th><i class="bi bi-calendar me-1"></i>Terdaftar</th>
                            <th class="text-center"><i class="bi bi-gear me-1"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr data-status="{{ $user->status }}">
                                <td>
                                    @if (in_array($user->status, ['rejected', 'disabled']) && $user->role !== 'admin')
                                        <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                            class="user-checkbox" form="bulkDeleteUsersForm">
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $user->name }}</div>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="status-badge status-{{ $user->status }}">
                                        @if ($user->status == 'pending')
                                            <i class="bi bi-clock me-1"></i>
                                        @elseif($user->status == 'approved')
                                            <i class="bi bi-check-circle me-1"></i>
                                        @elseif($user->status == 'rejected')
                                            <i class="bi bi-x-circle me-1"></i>
                                        @elseif($user->status == 'disabled')
                                            <i class="bi bi-pause-circle me-1"></i>
                                        @endif
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div>{{ $user->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        @if ($user->status == 'pending')
                                            <form action="{{ route('admin.user.approve', $user) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="btn btn-sm btn-modern btn-success-modern approve-btn"
                                                    title="Setujui Pengguna">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.user.reject', $user) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="btn btn-sm btn-modern btn-danger-modern reject-btn"
                                                    title="Tolak Pengguna">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </form>
                                        @elseif ($user->status == 'approved')
                                            @if (Route::has('admin.user.disable'))
                                                <form action="{{ route('admin.user.disable', $user) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-modern btn-warning-modern disable-btn"
                                                        title="Nonaktifkan Pengguna">
                                                        <i class="bi bi-pause"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @elseif ($user->status == 'disabled')
                                            @if (Route::has('admin.user.enable'))
                                                <form action="{{ route('admin.user.enable', $user) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-modern btn-success-modern enable-btn"
                                                        title="Aktifkan Pengguna">
                                                        <i class="bi bi-play"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif

                                        @if (in_array($user->status, ['rejected', 'disabled']))
                                            @if (Route::has('admin.user.delete'))
                                                <form action="{{ route('admin.user.delete', $user) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-modern btn-danger-modern delete-btn"
                                                        title="Hapus Pengguna">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 mb-3 d-block"></i>
                                        <p class="mb-0">Tidak ada pengguna ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- NDA Projects -->
        <div class="modern-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><i class="bi bi-file-earmark-lock me-2"></i>Proyek NDA</h5>
                    <small class="text-muted">Kelola dokumen NDA dan detail proyek</small>
                </div>
                <div class="d-flex gap-2">
                    <input type="search" class="form-control form-control-sm" placeholder="Cari proyek..."
                        id="projectSearch" style="width: 200px;">
                    <form action="{{ route('admin.nda.bulk-delete') }}" method="POST" id="bulkDeleteNdasForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger-modern" id="bulkDeleteNdasBtn" disabled>
                            <i class="bi bi-trash"></i> Hapus Terpilih
                        </button>
                    </form>
                    <a href="{{ route('admin.nda.create') }}" class="btn btn-sm btn-modern btn-primary-modern">
                        <i class="bi bi-plus"></i> Proyek Baru
                    </a>
                </div>
            </div>
            <div class="modern-table">
                <table class="table table-hover mb-0" id="ndaTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">
                                <input type="checkbox" id="selectAllNdas">
                            </th>
                            <th><i class="bi bi-folder me-1"></i>Nama Proyek</th>
                            <th><i class="bi bi-calendar-range me-1"></i>Durasi</th>
                            <th><i class="bi bi-calendar-check me-1"></i>Tanda Tangan NDA</th>
                            <th><i class="bi bi-file-pdf me-1"></i>File</th>
                            <th class="text-center"><i class="bi bi-gear me-1"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ndas as $nda)
                            <tr>
                                <td>
                                    <input type="checkbox" name="nda_ids[]" value="{{ $nda->id }}"
                                        class="nda-checkbox" form="bulkDeleteNdasForm">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                                            <i class="bi bi-folder-fill text-warning"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $nda->project_name }}</div>
                                            <small class="text-muted">{{ Str::limit($nda->description, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if ($nda->start_date && $nda->end_date)
                                            <div class="small">{{ $nda->start_date->format('d M Y') }} -
                                                {{ $nda->end_date->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $nda->formatted_duration }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($nda->nda_signature_date)
                                        <div>{{ $nda->nda_signature_date->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $nda->nda_signature_date->diffForHumans() }}</small>
                                    @else
                                        <span class="text-muted">Belum ditandatangani</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($nda->token)
                                        <a href="{{ route('file.preview', $nda->token) }}" target="_blank"
                                            class="btn btn-sm btn-modern btn-outline-modern">
                                            <i class="bi bi-eye"></i> Pratinjau
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada file</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.nda.detail', $nda) }}"
                                            class="btn btn-sm btn-modern btn-primary-modern" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.nda.edit', $nda) }}"
                                            class="btn btn-sm btn-modern btn-warning-modern" title="Edit Proyek">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.nda.delete', $nda) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-modern btn-danger-modern delete-btn"
                                                title="Hapus Proyek">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-folder-x fs-1 mb-3 d-block"></i>
                                        <p class="mb-0">Tidak ada proyek NDA ditemukan</p>
                                        <a href="{{ route('admin.nda.create') }}"
                                            class="btn btn-modern btn-primary-modern mt-2">
                                            <i class="bi bi-plus-circle"></i> Buat Proyek Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .modern-card {
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                border: none;
            }

            .modern-table {
                overflow-x: auto;
            }

            .status-badge {
                padding: 4px 10px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 500;
            }

            .status-pending {
                background: #fef3c7;
                color: #d97706;
            }

            .status-approved {
                background: #d1fae5;
                color: #059669;
            }

            .status-rejected {
                background: #fee2e2;
                color: #dc2626;
            }

            .status-disabled {
                background: #e5e7eb;
                color: #4b5563;
            }

            .btn-modern {
                border-radius: 8px;
                padding: 6px 12px;
                font-weight: 500;
                transition: all 0.2s;
            }

            .btn-primary-modern {
                background: #4f46e5;
                border-color: #4f46e5;
                color: white;
            }

            .btn-primary-modern:hover {
                background: #4338ca;
                border-color: #4338ca;
            }

            .btn-success-modern {
                background: #10b981;
                border-color: #10b981;
                color: white;
            }

            .btn-success-modern:hover {
                background: #059669;
                border-color: #059669;
            }

            .btn-warning-modern {
                background: #f59e0b;
                border-color: #f59e0b;
                color: white;
            }

            .btn-warning-modern:hover {
                background: #d97706;
                border-color: #d97706;
            }

            .btn-danger-modern {
                background: #ef4444;
                border-color: #ef4444;
                color: white;
            }

            .btn-danger-modern:hover {
                background: #dc2626;
                border-color: #dc2626;
            }

            .btn-outline-modern {
                border-color: #4f46e5;
                color: #4f46e5;
            }

            .btn-outline-modern:hover {
                background: #f1f5f9;
                border-color: #4f46e5;
            }

            .alert {
                position: relative;
                z-index: 1000;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Select All untuk User Management
                const selectAllUsers = document.getElementById('selectAllUsers');
                const userCheckboxes = document.querySelectorAll('.user-checkbox');
                const bulkDeleteUsersBtn = document.getElementById('bulkDeleteUsersBtn');
                const bulkDeleteUsersForm = document.getElementById('bulkDeleteUsersForm');

                if (selectAllUsers && userCheckboxes && bulkDeleteUsersBtn) {
                    selectAllUsers.addEventListener('change', function() {
                        userCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                        bulkDeleteUsersBtn.disabled = !Array.from(userCheckboxes).some(cb => cb.checked);
                    });

                    userCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            selectAllUsers.checked = Array.from(userCheckboxes).every(cb => cb.checked);
                            bulkDeleteUsersBtn.disabled = !Array.from(userCheckboxes).some(cb => cb
                                .checked);
                        });
                    });

                    bulkDeleteUsersForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const checkedCount = Array.from(userCheckboxes).filter(cb => cb.checked).length;
                        if (checkedCount === 0) {
                            Swal2.fire({
                                title: 'Pilih Pengguna',
                                text: 'Silakan pilih setidaknya satu pengguna untuk dihapus.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }
                        Swal2.fire({
                            title: `Hapus ${checkedCount} Pengguna?`,
                            text: 'Tindakan ini tidak dapat dibatalkan!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: '<i class="bi bi-trash me-1"></i>Hapus',
                            cancelButtonText: '<i class="bi bi-arrow-left me-1"></i>Batal',
                            confirmButtonColor: '#ef4444'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                }

                // Select All untuk NDA Projects
                const selectAllNdas = document.getElementById('selectAllNdas');
                const ndaCheckboxes = document.querySelectorAll('.nda-checkbox');
                const bulkDeleteNdasBtn = document.getElementById('bulkDeleteNdasBtn');
                const bulkDeleteNdasForm = document.getElementById('bulkDeleteNdasForm');

                if (selectAllNdas && ndaCheckboxes && bulkDeleteNdasBtn) {
                    selectAllNdas.addEventListener('change', function() {
                        ndaCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                        bulkDeleteNdasBtn.disabled = !Array.from(ndaCheckboxes).some(cb => cb.checked);
                    });

                    ndaCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            selectAllNdas.checked = Array.from(ndaCheckboxes).every(cb => cb.checked);
                            bulkDeleteNdasBtn.disabled = !Array.from(ndaCheckboxes).some(cb => cb
                                .checked);
                        });
                    });

                    bulkDeleteNdasForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const checkedCount = Array.from(ndaCheckboxes).filter(cb => cb.checked).length;
                        if (checkedCount === 0) {
                            Swal2.fire({
                                title: 'Pilih Proyek NDA',
                                text: 'Silakan pilih setidaknya satu proyek NDA untuk dihapus.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }
                        Swal2.fire({
                            title: `Hapus ${checkedCount} Proyek NDA?`,
                            text: 'Tindakan ini tidak dapat dibatalkan!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: '<i class="bi bi-trash me-1"></i>Hapus',
                            cancelButtonText: '<i class="bi bi-arrow-left me-1"></i>Batal',
                            confirmButtonColor: '#ef4444'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                }

                // User status filter
                const userStatusFilter = document.getElementById('userStatusFilter');
                const usersTable = document.getElementById('usersTable');

                if (userStatusFilter && usersTable) {
                    userStatusFilter.addEventListener('change', function() {
                        const filterValue = this.value;
                        const rows = usersTable.querySelectorAll('tbody tr[data-status]');
                        rows.forEach(row => {
                            if (filterValue === '' || row.dataset.status === filterValue) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                        // Reset select all dan tombol hapus saat filter berubah
                        selectAllUsers.checked = false;
                        userCheckboxes.forEach(cb => cb.checked = false);
                        bulkDeleteUsersBtn.disabled = true;
                    });
                }

                // Project search
                const projectSearch = document.getElementById('projectSearch');
                const ndaTable = document.getElementById('ndaTable');

                if (projectSearch && ndaTable) {
                    projectSearch.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase();
                        const rows = ndaTable.querySelectorAll('tbody tr');
                        rows.forEach(row => {
                            const projectName = row.querySelector('td:nth-child(2) .fw-medium');
                            if (projectName) {
                                const text = projectName.textContent.toLowerCase();
                                row.style.display = text.includes(searchTerm) ? '' : 'none';
                            }
                        });
                        // Reset select all dan tombol hapus saat pencarian
                        selectAllNdas.checked = false;
                        ndaCheckboxes.forEach(cb => cb.checked = false);
                        bulkDeleteNdasBtn.disabled = true;
                    });
                }

                // SweetAlert untuk tombol aksi individu
                document.querySelectorAll('.approve-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal2.fire({
                            title: 'Setujui Pengguna?',
                            text: 'Pengguna ini akan mendapatkan akses ke sistem.',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: '<i class="bi bi-check me-1"></i>Setujui',
                            cancelButtonText: '<i class="bi bi-x me-1"></i>Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.closest('form').submit();
                            }
                        });
                    });
                });

                document.querySelectorAll('.reject-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal2.fire({
                            title: 'Tolak Pengguna?',
                            text: 'Pengguna ini akan ditolak akses ke sistem.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: '<i class="bi bi-x me-1"></i>Tolak',
                            cancelButtonText: '<i class="bi bi-arrow-left me-1"></i>Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.closest('form').submit();
                            }
                        });
                    });
                });

                document.querySelectorAll('.disable-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal2.fire({
                            title: 'Nonaktifkan Pengguna?',
                            text: 'Pengguna ini akan dinonaktifkan sementara dari sistem.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: '<i class="bi bi-pause me-1"></i>Nonaktifkan',
                            cancelButtonText: '<i class="bi bi-arrow-left me-1"></i>Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.closest('form').submit();
                            }
                        });
                    });
                });

                document.querySelectorAll('.enable-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal2.fire({
                            title: 'Aktifkan Pengguna?',
                            text: 'Pengguna ini akan diaktifkan kembali di sistem.',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: '<i class="bi bi-play me-1"></i>Aktifkan',
                            cancelButtonText: '<i class="bi bi-arrow-left me-1"></i>Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.closest('form').submit();
                            }
                        });
                    });
                });

                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal2.fire({
                            title: 'Hapus Permanen?',
                            text: 'Tindakan ini tidak dapat dibatalkan!',
                            icon: 'error',
                            showCancelButton: true,
                            confirmButtonText: '<i class="bi bi-trash me-1"></i>Hapus',
                            cancelButtonText: '<i class="bi bi-arrow-left me-1"></i>Batal',
                            confirmButtonColor: '#ef4444'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.closest('form').submit();
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
