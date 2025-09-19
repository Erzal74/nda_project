<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - NDA Management System</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5;
            /* Aligned with dashboard */
            --primary-light: #6366f1;
            --primary-dark: #4338ca;
            --secondary-color: #64748b;
            --accent-color: var(--primary-color);
            /* Use primary for consistency */
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-bg: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-900: #111827;
            --border-color: var(--gray-200);
            --shadow-xs: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --radius: 8px;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.5;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }

        /* Header */
        .admin-header {
            background-color: var(--light-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            /* Higher than dashboard z-index */
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        .admin-header .navbar {
            padding: 1rem 0;
            min-height: 70px;
        }

        .admin-header .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 600;
            font-size: 1.25rem;
            color: var(--gray-900);
            text-decoration: none;
        }

        .admin-header .navbar-brand:hover {
            color: var(--gray-900);
        }

        .admin-header .navbar-brand i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 0.75rem;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray-600);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .user-info i {
            color: var(--secondary-color);
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            padding: 0;
            /* Removed fixed padding to allow dashboard control */
        }

        .main-content .container {
            padding: 0 1rem;
            /* Minimal padding for responsiveness */
            max-width: 1400px;
            /* Match dashboard max-width */
            margin: 0 auto;
        }

        /* Cards */
        .card-modern {
            background: var(--light-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-xs);
            transition: var(--transition);
        }

        .card-modern:hover {
            box-shadow: var(--shadow-sm);
        }

        .card-modern .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            font-weight: 600;
            font-size: 1.125rem;
            color: var(--gray-900);
        }

        .card-modern .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn-modern {
            padding: 0.625rem 1.25rem;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.875rem;
            border: 1px solid transparent;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            line-height: 1.25;
        }

        .btn-modern:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(var(--primary-color), 0.1);
        }

        .btn-primary-modern {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-primary-modern:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white;
        }

        .btn-success-modern {
            background-color: var(--success-color);
            color: white;
            border-color: var(--success-color);
        }

        .btn-success-modern:hover {
            background-color: #047857;
            border-color: #047857;
            color: white;
        }

        .btn-warning-modern {
            background-color: var(--warning-color);
            color: white;
            border-color: var(--warning-color);
        }

        .btn-warning-modern:hover {
            background-color: #b45309;
            border-color: #b45309;
            color: white;
        }

        .btn-danger-modern {
            background-color: var(--danger-color);
            color: white;
            border-color: var(--danger-color);
            transition: var(--transition);
        }

        .btn-danger-modern:hover,
        .btn-danger-modern:focus {
            background-color: #b91c1c;
            border-color: #b91c1c;
            color: white;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
        }

        .btn-danger-modern.logout-animating {
            animation: logoutPulse 0.5s;
        }

        @keyframes logoutPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
                transform: scale(1);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(239, 68, 68, 0.2);
                transform: scale(1.05);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.0);
                transform: scale(1);
            }
        }

        .btn-secondary-modern {
            background-color: rgb(255, 0, 0);
            color: var(--gray-600);
            border-color: var(--border-color);
        }

        .btn-secondary-modern:hover {
            background-color: var(--gray-50);
            color: var(--gray-900);
            border-color: var(--gray-300);
        }

        .btn-outline-modern {
            background-color: transparent;
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-modern:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Tables */
        .table-modern {
            background: var(--light-bg);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-xs);
        }

        .table-modern table {
            margin: 0;
        }

        .table-modern .table thead th {
            background-color: var(--gray-50);
            border: none;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: var(--gray-900);
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .table-modern .table tbody td {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .table-modern .table tbody tr:hover {
            background-color: var(--gray-50);
        }

        /* Form Controls */
        .form-control-modern {
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            background-color: var(--light-bg);
        }

        .form-control-modern:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(var(--primary-color), 0.1);
            outline: none;
        }

        .form-label-modern {
            font-weight: 500;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        /* Alerts */
        .alert-modern {
            border: none;
            border-radius: var(--radius);
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert-success-modern {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-danger-modern {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Status badges */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-disabled {
            background-color: var(--gray-100);
            color: var(--gray-600);
        }

        /* Footer */
        .admin-footer {
            background-color: var(--light-bg);
            border-top: 1px solid var(--border-color);
            padding: 1.5rem 0;
            margin-top: auto;
            color: var(--gray-600);
        }

        .admin-footer .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
        }

        .admin-footer .footer-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            color: var(--gray-900);
        }

        .admin-footer .footer-brand i {
            color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .main-content .container {
                padding: 0 0.75rem;
            }
        }

        @media (max-width: 768px) {
            .admin-header .navbar-brand {
                font-size: 1.125rem;
            }

            .user-section {
                gap: 1rem;
            }

            .user-info span {
                display: none;
            }

            .main-content .container {
                padding: 0 0.5rem;
            }

            .card-modern .card-header,
            .card-modern .card-body {
                padding: 1.25rem;
            }

            .table-modern .table thead th,
            .table-modern .table tbody td {
                padding: 0.75rem 1rem;
                font-size: 0.8125rem;
            }

            .admin-footer .footer-content {
                flex-direction: column;
                gap: 0.75rem;
                text-align: center;
            }
        }

        /* Loading animation */
        .loading-spinner {
            width: 16px;
            height: 16px;
            border: 2px solid var(--gray-200);
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Utility classes */
        .text-muted {
            color: var(--gray-600) !important;
        }

        .border-modern {
            border: 1px solid var(--border-color) !important;
        }

        .bg-light-modern {
            background-color: var(--gray-50) !important;
        }

        .rounded-modern {
            border-radius: var(--radius) !important;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header class="admin-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg p-0">
                <a class="navbar-brand" href="#">
                    <i class="bi bi-shield-lock"></i>
                    NDA Management System
                </a>

                <div class="user-section">
                    <div class="user-info">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline" id="logout-form">
                        @csrf
                        <button type="submit" class="btn btn-modern btn-secondary-modern no-loading logout-btn">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="d-none d-sm-inline">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content flex-grow-1">
        <div class="container">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert-modern alert-success-modern">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-modern alert-danger-modern">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>
                        {{ session('error') }}
                        @if ($errors->any())
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <i class="bi bi-shield-lock"></i>
                    <span>NDA Management</span>
                </div>
                <div>
                    &copy; {{ date('Y') }} NDA Management System. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const Swal2 = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-modern btn-primary-modern me-2',
                cancelButton: 'btn btn-modern btn-secondary-modern'
            },
            buttonsStyling: false
        });

        window.Swal2 = Swal2;

        document.addEventListener('DOMContentLoaded', function() {
            // Button loading states
            const buttons = document.querySelectorAll('.btn-modern:not(.no-loading)');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (this.type === 'submit') {
                        e.preventDefault();
                        const originalContent = this.innerHTML;
                        this.innerHTML = '<div class="loading-spinner me-2"></div>Loading...';
                        this.disabled = true;

                        const form = this.closest('form');
                        if (form) {
                            setTimeout(() => {
                                form.submit();
                            }, 300);
                        }

                        setTimeout(() => {
                            this.innerHTML = originalContent;
                            this.disabled = false;
                        }, 3000);
                    }
                });
            });

            // Logout confirmation
            const logoutButton = document.querySelector('.logout-btn');
            const logoutForm = document.getElementById('logout-form');
            if (logoutButton && logoutForm) {
                logoutButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Tambahkan animasi merah pada button
                    logoutButton.classList.add('btn-danger-modern', 'logout-animating');
                    setTimeout(() => {
                        logoutButton.classList.remove('logout-animating');
                    }, 500);
                    Swal2.fire({
                        title: 'Keluar',
                        text: 'Apakah Anda yakin ingin keluar?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Keluar',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        } else {
                            // Kembalikan warna button jika batal
                            logoutButton.classList.remove('btn-danger-modern');
                        }
                    });
                });
            }

            // Auto-dismiss alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-modern');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.3s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                });
            }, 5000);
        });
    </script>

    @stack('scripts')
    @stack('styles') <!-- Added to allow dashboard styles to be pushed -->
</body>

</html>
