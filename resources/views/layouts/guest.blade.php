<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - NDA System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1d4ed8;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --bg-light: #f9fafb;
            --danger: #dc2626;
            --success: #059669;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .auth-container {
            width: 100%;
            max-width: 420px;
            padding: 0 20px;
        }

        .auth-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            color: white;
            font-weight: 600;
            font-size: 24px;
        }

        .app-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--primary);
            margin: 0;
        }

        .page-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 8px 0;
        }

        .page-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: var(--text-dark);
            font-size: 14px;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            background: var(--bg-light);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
            background: #fef2f2;
        }

        .error-message {
            color: var(--danger);
            font-size: 13px;
            margin-top: 4px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 16px 0;
        }

        .form-check-input {
            margin: 0;
        }

        .form-check-label {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--primary-dark);
        }

        .btn-primary:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        .btn-outline {
            width: 100%;
            padding: 12px;
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.2s ease;
        }

        .btn-outline:hover {
            background: var(--bg-light);
            border-color: var(--primary);
            text-decoration: none;
            color: var(--primary);
        }

        .divider {
            text-align: center;
            margin: 24px 0;
            position: relative;
            color: var(--text-muted);
            font-size: 13px;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border);
        }

        .divider span {
            background: white;
            padding: 0 12px;
        }

        .text-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
        }

        .text-link:hover {
            text-decoration: underline;
            color: var(--primary-dark);
        }

        .text-center {
            text-align: center;
            margin: 16px 0;
        }

        .footer {
            text-align: center;
            margin-top: 32px;
            color: var(--text-muted);
            font-size: 12px;
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border-radius: 8px;
        }

        .form-loading {
            opacity: 0.7;
            pointer-events: none;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 32px 24px;
            }

            .alert {
                right: 20px;
                left: 20px;
                min-width: auto;
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="logo-section">
                <div class="logo">NDA</div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <strong>✅ Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>❌ Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show">
                    <strong>⚠️ Perhatian!</strong> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('registration_success'))
                <div class="alert alert-info alert-dismissible fade show" style="border-left: 4px solid #0369a1;">
                    <div style="display: flex; align-items: flex-start; gap: 8px;">
                        <span style="font-size: 18px;">🎉</span>
                        <div>
                            <strong>Pendaftaran Berhasil!</strong><br>
                            <small>Akun Anda telah terdaftar. Silakan tunggu persetujuan admin untuk mengakses sistem.
                                Anda akan dihubungi melalui email setelah akun disetujui.</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')

            <div class="footer">
                <p>&copy; {{ date('Y') }} NDA System. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form handling
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                const submitBtn = form.querySelector('button[type="submit"]');

                form.addEventListener('submit', function(e) {
                    if (!validateForm(form)) {
                        e.preventDefault();
                        return false;
                    }

                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Please wait...';
                        form.classList.add('form-loading');
                    }
                });
            });

            // Terms checkbox handling
            const termsCheckbox = document.getElementById('terms');
            if (termsCheckbox) {
                const submitBtn = document.querySelector('button[type="submit"]');
                termsCheckbox.addEventListener('change', function() {
                    if (submitBtn) {
                        submitBtn.disabled = !this.checked;
                    }
                });
            }

            // Input validation
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.hasAttribute('required') && !this.value.trim()) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim()) {
                        this.classList.remove('is-invalid');
                    }
                });
            });

            // Auto hide alerts dengan durasi berbeda
            setTimeout(() => {
                document.querySelectorAll('.alert:not(.alert-info)').forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Auto hide alert info (registration success) lebih lama
            setTimeout(() => {
                document.querySelectorAll('.alert-info').forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 10000);
        });

        function validateForm(form) {
            let isValid = true;

            // Clear previous errors
            form.querySelectorAll('.form-control').forEach(field => {
                field.classList.remove('is-invalid');
            });

            // Check required fields
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                }
            });

            // Email validation
            const emailField = form.querySelector('input[type="email"]');
            if (emailField && emailField.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailField.value)) {
                    emailField.classList.add('is-invalid');
                    isValid = false;
                }
            }

            // Password confirmation
            const password = form.querySelector('input[name="password"]');
            const passwordConfirm = form.querySelector('input[name="password_confirmation"]');
            if (password && passwordConfirm && password.value !== passwordConfirm.value) {
                passwordConfirm.classList.add('is-invalid');
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>

</html>
