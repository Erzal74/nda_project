<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - NDA System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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
            padding: 32px 0;
        }

        .auth-container {
            width: 100%;
            max-width: 520px;
            padding: 0 24px;
        }

        .auth-card {
            background: white;
            padding: 48px 40px;
            border-radius: 16px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            width: 72px;
            height: 72px;
            background: var(--primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-weight: 700;
            font-size: 28px;
            box-shadow: 0 4px 20px rgba(30, 64, 175, 0.2);
        }

        .app-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary);
            margin: 0;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 12px 0;
            line-height: 1.2;
        }

        .page-subtitle {
            font-size: 16px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 15px;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 16px 18px;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 16px;
            background: var(--bg-light);
            transition: all 0.2s ease;
            line-height: 1.5;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.08);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
            background: #fef2f2;
        }

        .form-control::placeholder {
            color: #9ca3af;
            font-size: 15px;
        }

        .error-message {
            color: var(--danger);
            font-size: 14px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0 28px 0;
        }

        .form-check-input {
            margin: 0;
            width: 18px;
            height: 18px;
            border: 2px solid var(--border);
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            font-size: 15px;
            color: var(--text-muted);
            margin: 0;
            font-weight: 500;
        }

        .btn-primary {
            width: 100%;
            padding: 16px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 24px;
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }

        .btn-outline {
            width: 100%;
            padding: 16px 20px;
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--border);
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
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
            transform: translateY(-1px);
        }

        .divider {
            text-align: center;
            margin: 32px 0;
            position: relative;
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 500;
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
            padding: 0 20px;
        }

        .text-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .text-link:hover {
            text-decoration: underline;
            color: var(--primary-dark);
        }

        .text-center {
            text-align: center;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .alert {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            min-width: 320px;
            border-radius: 12px;
            padding: 16px 20px;
            font-size: 14px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }

        .form-loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Enhanced visual feedback */
        .form-control:hover:not(:focus) {
            border-color: #d1d5db;
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.2);
        }

        .btn-outline:focus {
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
        }

        /* Terms checkbox specific styling */
        #terms {
            accent-color: var(--primary);
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            body {
                padding: 24px 0;
            }

            .auth-container {
                max-width: 100%;
                padding: 0 20px;
            }

            .auth-card {
                padding: 36px 28px;
                border-radius: 12px;
            }

            .logo {
                width: 64px;
                height: 64px;
                font-size: 24px;
                margin-bottom: 16px;
            }

            .page-title {
                font-size: 24px;
            }

            .page-subtitle {
                font-size: 15px;
            }

            .form-control {
                padding: 14px 16px;
                font-size: 16px;
            }

            .btn-primary,
            .btn-outline {
                padding: 14px 18px;
                font-size: 16px;
            }

            .alert {
                right: 20px;
                left: 20px;
                min-width: auto;
            }
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 28px 20px;
            }

            .page-header {
                margin-bottom: 32px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .logo-section {
                margin-bottom: 32px;
            }

            .footer {
                margin-top: 32px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="logo-section">
                <div class="logo">NDA</div>
                <p class="app-title">NDA System</p>
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
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <span style="font-size: 20px;">🎉</span>
                        <div>
                            <strong>Pendaftaran Berhasil!</strong><br>
                            <small style="font-size: 13px; line-height: 1.4;">Akun Anda telah terdaftar. Silakan tunggu
                                persetujuan admin untuk mengakses sistem.
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
                        const originalText = submitBtn.textContent;
                        submitBtn.innerHTML = '<span style="opacity: 0.7;">Memproses...</span>';
                        form.classList.add('form-loading');

                        setTimeout(() => {
                            if (submitBtn.disabled) {
                                submitBtn.disabled = false;
                                submitBtn.textContent = originalText;
                                form.classList.remove('form-loading');
                            }
                        }, 10000);
                    }
                });
            });

            const termsCheckbox = document.getElementById('terms');
            if (termsCheckbox) {
                const submitBtn = document.querySelector('button[type="submit"]');

                function toggleSubmitButton() {
                    if (submitBtn) {
                        submitBtn.disabled = !termsCheckbox.checked;
                        submitBtn.style.opacity = termsCheckbox.checked ? '1' : '0.5';
                    }
                }

                termsCheckbox.addEventListener('change', toggleSubmitButton);
                toggleSubmitButton();
            }

            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim()) {
                        this.classList.remove('is-invalid');
                        // Remove error message if exists
                        const errorMsg = this.parentElement.querySelector('.error-message');
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    }
                });

                // Add focus enhancement
                input.addEventListener('focus', function() {
                    this.style.transform = 'translateY(-1px)';
                });

                input.addEventListener('blur', function() {
                    this.style.transform = 'translateY(0)';
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
            }, 12000);
        });

        function validateField(field) {
            const value = field.value.trim();
            let isValid = true;
            let errorMessage = '';

            // Remove existing error message
            const existingError = field.parentElement.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }

            if (field.hasAttribute('required') && !value) {
                isValid = false;
                errorMessage = 'Field ini wajib diisi';
            } else if (field.type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Format email tidak valid';
                }
            } else if (field.type === 'password' && value && value.length < 6) {
                isValid = false;
                errorMessage = 'Password minimal 6 karakter';
            }

            if (isValid) {
                field.classList.remove('is-invalid');
            } else {
                field.classList.add('is-invalid');
                // Add error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.innerHTML = `<span style="color: #ef4444;">⚠️</span> ${errorMessage}`;
                field.parentElement.appendChild(errorDiv);
            }

            return isValid;
        }

        function validateForm(form) {
            let isValid = true;

            // Check required fields
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!validateField(field)) {
                    isValid = false;
                }
            });

            // Password confirmation
            const password = form.querySelector('input[name="password"]');
            const passwordConfirm = form.querySelector('input[name="password_confirmation"]');
            if (password && passwordConfirm && password.value !== passwordConfirm.value) {
                passwordConfirm.classList.add('is-invalid');
                const existingError = passwordConfirm.parentElement.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.innerHTML = '<span style="color: #ef4444;">⚠️</span> Konfirmasi password tidak cocok';
                passwordConfirm.parentElement.appendChild(errorDiv);
                isValid = false;
            }

            return isValid;
        }

        // Smooth scroll untuk form errors
        function scrollToFirstError() {
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                firstError.focus();
            }
        }
    </script>
</body>

</html>
