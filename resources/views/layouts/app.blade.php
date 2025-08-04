<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - NDA Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3b82f6;
            /* Biru modern */
            --secondary-color: #6b7280;
            /* Abu-abu netral */
            --success-color: #10b981;
            --danger-color: #ef4444;
            --light-bg: #f9fafb;
            --border-color: #e5e7eb;
            --shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: #1f2937;
            line-height: 1.5;
        }

        .navbar {
            background-color: white;
            box-shadow: var(--shadow);
            padding: 1rem;
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--primary-color);
        }

        .container {
            max-width: 1200px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: var(--shadow);
            background: white;
        }

        .card-header {
            background: none;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem;
            font-weight: 600;
            color: #1f2937;
        }

        .btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
            background: white;
            box-shadow: var(--shadow);
        }

        .table thead {
            background-color: #f1f5f9;
        }

        .table th,
        .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: #1f2937;
        }

        .alert {
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
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

        @media (max-width: 768px) {

            .table th,
            .table td {
                padding: 0.75rem;
                font-size: 0.875rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">NDA Management System</a>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted"><i
                        class="bi bi-person-circle me-1"></i>{{ Auth::user()->name ?? 'User' }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>

</html>
