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
            --primary-dark: #3730a3;
            --secondary-color: #6b7280;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-bg: #f8fafc;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-color);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Ensure content takes available space */
        .page-content {
            flex: 1 0 auto;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Header */
        .admin-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 1.5rem 0;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }

        .admin-header h1 {
            color: white;
            font-weight: 600;
            font-size: 1.875rem;
            margin: 0;
        }

        .admin-header .subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Cards */
        .modern-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .modern-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .modern-card .card-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            font-weight: 600;
            font-size: 1.125rem;
            color: var(--dark-color);
        }

        .modern-card .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn-modern {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-modern:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-success-modern {
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            color: white;
        }

        .btn-warning-modern {
            background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
            color: white;
        }

        .btn-danger-modern {
            background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
            color: white;
        }

        .btn-secondary-modern {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #4b5563 100%);
            color: white;
        }

        .btn-outline-modern {
            background: white;
            border: 2px solid var(--border-color);
            color: var(--secondary-color);
        }

        .btn-outline-modern:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* Tables */
        .modern-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .modern-table table {
            margin: 0;
        }

        .modern-table .table thead th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .modern-table .table tbody td {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .modern-table .table tbody tr:hover {
            background-color: rgba(79, 70, 229, 0.02);
        }

        /* Form Controls */
        .form-control-modern {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: white;
        }

        .form-control-modern:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        .form-label-modern {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        /* Alerts */
        .alert-modern {
            border: none;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success-modern {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: #065f46;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger-modern {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }

        /* Status badges */
        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fecaca;
            color: #991b1b;
        }

        .status-disabled {
            background: #f3f4f6;
            color: #374151;
        }

        /* Footer */
        .admin-footer {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            color: white;
            padding: 2rem 0;
            margin-top: 2rem;
            box-shadow: var(--shadow-md);
            flex-shrink: 0;
        }

        .admin-footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .admin-footer a:hover {
            color: white;
            text-decoration: underline;
        }

        .admin-footer .footer-links {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .admin-footer .footer-text {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-header h1 {
                font-size: 1.5rem;
            }

            .modern-card {
                margin-bottom: 1rem;
            }

            .btn-modern {
                padding: 0.625rem 1.25rem;
                font-size: 0.8125rem;
            }

            .modern-table .table thead th,
            .modern-table .table tbody td {
                padding: 0.75rem 1rem;
                font-size: 0.8125rem;
            }

            .admin-footer .footer-links {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }
        }

        /* Loading animation */
        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #f3f4f6;
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Page transitions */
        .page-content {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="admin-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="bi bi-shield-lock me-2"></i>NDA Management System</h1>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white-50">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ Auth::user()->name ?? 'Admin' }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline" id="logout-form">
                        @csrf
                        <button type="submit" class="btn btn-modern btn-danger-modern no-loading logout-btn">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container page-content">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert-modern alert-success-modern">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-modern alert-danger-modern">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
                @if ($errors->any())
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="container">
            <div class="footer-text text-center">
                &copy; {{ date('Y') }} NDA Management System. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Enhanced SweetAlert2 configurations
        const Swal2 = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-modern btn-primary-modern me-2',
                cancelButton: 'btn btn-modern btn-outline-modern'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'animate__animated animate__fadeInDown animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
            }
        });

        // Make Swal2 available globally
        window.Swal2 = Swal2;

        // Add loading states to buttons (except logout)
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-modern:not(.no-loading)');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    if (this.type === 'submit') {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<div class="loading-spinner me-2"></div>Loading...';
                        this.disabled = true;

                        // Re-enable after 3 seconds (fallback)
                        setTimeout(() => {
                            this.innerHTML = originalText;
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
                        title: 'Keluar dari Sistem?',
                        text: 'Anda akan diarahkan ke halaman login.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: '<i class="bi bi-box-arrow-right me-1"></i>Keluar',
                        cancelButtonText: '<i class="bi bi-x me-1"></i>Batal',
                        confirmButtonColor: '#ef4444'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        }
                    });
                });
            }

            // Auto-hide flash messages
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-modern');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                });
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>

</html>
