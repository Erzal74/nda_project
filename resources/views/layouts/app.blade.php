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
            --primary-color: #0f172a;
            --primary-light: #1e293b;
            --secondary-color: #64748b;
            --accent-color: #2563eb;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --light-bg: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-600: #475569;
            --gray-900: #0f172a;
            --border-color: #e2e8f0;
            --shadow-xs: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
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
            z-index: 1000;
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
            color: var(--accent-color);
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
            min-height: calc(100vh - 140px);
            padding: 2rem 0;
        }

        /* Cards */
        .card-modern {
            background: var(--light-bg);
            border-radius: 8px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-xs);
            transition: all 0.2s ease;
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
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.875rem;
            border: 1px solid transparent;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            line-height: 1.25;
        }

        .btn-modern:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-primary-modern {
            background-color: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
        }

        .btn-primary-modern:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
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
        }

        .btn-danger-modern:hover {
            background-color: #b91c1c;
            border-color: #b91c1c;
            color: white;
        }

        .btn-secondary-modern {
            background-color: white;
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
            color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-outline-modern:hover {
            background-color: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
        }

        /* Tables */
        .table-modern {
            background: var(--light-bg);
            border-radius: 8px;
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
            border-radius: 6px;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            background-color: var(--light-bg);
        }

        .form-control-modern:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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
            border-radius: 6px;
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
            color: var(--accent-color);
        }

        /* Responsive */
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

            .main-content {
                padding: 1.5rem 0;
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
            border-top: 2px solid var(--accent-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
            border-radius: 6px !important;
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
                    Swal2.fire({
                        title: 'Sign Out',
                        text: 'Are you sure you want to logout?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sign Out',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
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
</body>

</html>