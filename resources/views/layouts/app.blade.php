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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --secondary-color: #6b7280;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-bg: #f9fafb;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.05);
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

        .page-content {
            flex: 1 0 auto;
            padding: 1.5rem 0;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Header */
        .admin-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            padding: 1rem 0;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .admin-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-header .logo {
            display: flex;
            align-items: center;
        }

        .admin-header .logo i {
            font-size: 1.5rem;
            color: white;
            margin-right: 0.5rem;
        }

        .admin-header .logo h1 {
            color: white;
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .admin-header .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .admin-header .nav-links a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .admin-header .nav-links a:hover {
            color: white;
        }

        .admin-header .user-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-header .user-section span {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.9rem;
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
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .modern-card .card-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
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
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
        }

        .btn-primary-modern:hover {
            background: linear-gradient(135deg, #4338ca, #2f2a7d);
        }

        .btn-success-modern {
            background: linear-gradient(135deg, var(--success-color), #059669);
            color: white;
        }

        .btn-success-modern:hover {
            background: linear-gradient(135deg, #0d9a74, #047857);
        }

        .btn-warning-modern {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
            color: white;
        }

        .btn-warning-modern:hover {
            background: linear-gradient(135deg, #e08a0c, #c25b05);
        }

        .btn-danger-modern {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
            color: white;
        }

        .btn-danger-modern:hover {
            background: linear-gradient(135deg, #e53e3e, #b91c1c);
        }

        .btn-secondary-modern {
            background: linear-gradient(135deg, var(--secondary-color), #4b5563);
            color: white;
        }

        .btn-secondary-modern:hover {
            background: linear-gradient(135deg, #4b5563, #374151);
        }

        .btn-outline-modern {
            background: white;
            border: 2px solid var(--border-color);
            color: var(--secondary-color);
        }

        .btn-outline-modern:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: #f3f4f6;
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
            background: linear-gradient(135deg, #f9fafb, #f3f4f6);
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
            background-color: rgba(79, 70, 229, 0.04);
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
            animation: fadeIn 0.3s ease-in;
        }

        .alert-success-modern {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #065f46;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger-modern {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Status badges */
        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
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
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            color: white;
            padding: 2rem 0;
            margin-top: 2rem;
            box-shadow: var(--shadow-md);
            flex-shrink: 0;
        }

        .admin-footer .container {
            text-align: center;
        }

        .admin-footer .footer-logo {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .admin-footer .footer-logo i {
            color: var(--success-color);
        }

        .admin-footer .footer-text {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.75);
            margin-bottom: 0.75rem;
        }

        .admin-footer .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.875rem;
            margin: 0 0.75rem;
            transition: color 0.2s ease;
        }

        .admin-footer .footer-links a:hover {
            color: white;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-header .logo h1 {
                font-size: 1.5rem;
            }

            .admin-header .nav-links {
                display: none;
            }

            .admin-header .user-section {
                gap: 0.75rem;
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
    <header class="admin-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="logo">
                    <i class="bi bi-shield-lock"></i>
                    <h1>NDA Management System</h1>
                </div>
                <div class="user-section">
                    <span>
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
    </header>

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
            <div class="footer-logo">
                <i class="bi bi-shield-lock"></i>
                <span>NDA Management</span>
            </div>
            <div class="footer-text">
                &copy; {{ date('Y') }} NDA Management System. All rights reserved.
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

        window.Swal2 = Swal2;

        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-modern:not(.no-loading)');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (this.type === 'submit') {
                        e.preventDefault();
                        const originalText = this.innerHTML;
                        this.innerHTML = '<div class="loading-spinner me-2"></div>Loading...';
                        this.disabled = true;

                        const form = this.closest('form');
                        if (form) {
                            setTimeout(() => {
                                form.submit();
                            }, 500);
                        }

                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }, 5000);
                    }
                });
            });

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
