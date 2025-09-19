<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - NDA System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #3b82f6;
            --primary-light: #dbeafe;
            --primary-dark: #2563eb;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg-light: #f8fafc;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 6px 16px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 12px 30px rgba(0, 0, 0, 0.15);
            --radius: 20px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e0f2fe 0%, #f1f5f9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .auth-container {
            width: 100%;
            max-width: 1100px;
            padding: 0 20px;
            animation: fadeIn 0.8s ease-out;
        }

        .auth-card {
            display: flex;
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            animation: slideUp 0.8s ease-out;
        }

        .auth-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        /* Branding Section */
        .brand-section {
            flex: 1;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            padding: 80px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .brand-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            animation: pulse 10s infinite;
        }

        .brand-logo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-md);
            margin-bottom: 30px;
            transition: var(--transition);
            animation: bounceIn 0.8s ease-out;
        }

        .brand-logo:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .brand-logo img {
            max-width: 80%;
            height: auto;
            object-fit: contain;
        }

        .brand-logo.fallback {
            background: var(--primary);
            color: white;
            font-weight: 700;
            font-size: 32px;
        }

        .brand-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 0 0 12px 0;
            text-align: center;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .brand-subtitle {
            font-size: 16px;
            color: var(--text-muted);
            text-align: center;
            line-height: 1.8;
            max-width: 320px;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        /* Form Section */
        .form-section {
            flex: 1;
            padding: 80px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        @media (max-width: 992px) {
            .auth-card {
                flex-direction: column;
            }

            .brand-section,
            .form-section {
                padding: 50px 30px;
            }
        }

        @media (max-width: 576px) {

            .brand-section,
            .form-section {
                padding: 40px 20px;
            }

            .brand-logo {
                width: 100px;
                height: 100px;
            }

            .brand-title {
                font-size: 24px;
            }

            .brand-subtitle {
                font-size: 14px;
            }
        }

        /* Form Styles */
        .form-header {
            margin-bottom: 40px;
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        .form-header h2 {
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 12px 0;
            color: var(--text-dark);
        }

        .form-header p {
            font-size: 16px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.8;
        }

        .form-group {
            margin-bottom: 28px;
            position: relative;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 15px;
            color: var(--text-dark);
            margin-bottom: 10px;
            transition: var(--transition);
        }

        .form-control {
            width: 100%;
            padding: 16px 16px 16px 44px;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            font-size: 15px;
            transition: var(--transition);
            color: var(--text-dark);
            background: white;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .form-control:hover:not(:focus):not(.is-invalid) {
            border-color: #bfdbfe;
        }

        .form-control.is-invalid {
            border-color: var(--danger);
            background: #fef2f2;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: var(--transition);
        }

        .form-control:focus+.form-icon {
            color: var(--primary);
        }

        .error-message {
            color: var(--danger);
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(0.8);
                opacity: 0.3;
            }

            50% {
                transform: scale(1);
                opacity: 0.5;
            }

            100% {
                transform: scale(0.8);
                opacity: 0.3;
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-4px);
            }

            75% {
                transform: translateX(4px);
            }
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
            animation: fadeInUp 0.8s ease-out 0.8s both;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin: 0;
            accent-color: var(--primary);
            border: 2px solid var(--border);
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
        }

        .form-check-label {
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.2s;
        }

        .form-check-label:hover {
            color: var(--text-dark);
        }

        .text-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            position: relative;
            transition: var(--transition);
        }

        .text-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .btn-primary {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            animation: fadeInUp 0.8s ease-out 1s both;
        }

        .btn-primary:hover:not(:disabled) {
            background: linear-gradient(90deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 24px;
            height: 24px;
            border: 3px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            opacity: 0;
        }

        .btn-primary.loading .btn-text {
            opacity: 0;
        }

        .btn-primary.loading .btn-loader {
            opacity: 1;
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: var(--text-muted);
            font-size: 14px;
            animation: fadeInUp 0.8s ease-out 1.2s both;
        }

        /* Alerts */
        .alert {
            position: relative;
            padding: 16px 24px;
            border-radius: var(--radius);
            font-size: 15px;
            margin-bottom: 28px;
            border: none;
            box-shadow: var(--shadow-sm);
            animation: slideInRight 0.5s ease-out;
        }

        .alert-success {
            background: var(--success);
            color: white;
        }

        .alert-danger {
            background: var(--danger);
            color: white;
        }

        .alert-warning {
            background: var(--warning);
            color: white;
        }

        .alert-info {
            background: var(--primary-light);
            color: var(--primary-dark);
            border-left: 5px solid var(--primary);
        }

        .btn-close {
            filter: none;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .form-loading {
            opacity: 0.8;
            pointer-events: none;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <!-- Branding Section -->
            <div class="brand-section">
                <div class="brand-logo">
                    <img src="{{ asset('images/logo_nda.png') }}" alt="NDA Logo"
                        onerror="this.style.display='none'; this.parentElement.classList.add('fallback'); this.parentElement.textContent='NDA'">
                </div>
                <h3 class="brand-title">NDA System</h3>
                <p class="brand-subtitle">Sistem manajemen dokumen dan akses yang aman dan terpercaya.</p>
            </div>

            <!-- Form Section -->
            <div class="form-section">
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
                    <div class="alert alert-info alert-dismissible fade show">
                        <div style="display: flex; align-items: flex-start; gap: 12px; flex-wrap: wrap;">
                            <span>🎉</span>
                            <div>
                                <strong>Pendaftaran Berhasil!</strong><br>
                                <small style="font-size: 12px; opacity: 0.9;">Akun Anda telah terdaftar. Silakan tunggu
                                    persetujuan admin. Anda akan dihubungi via email setelah disetujui.</small>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                const submitBtn = form.querySelector('button[type="submit"]');

                form.addEventListener('submit', function(e) {
                    if (!validateForm(form)) {
                        e.preventDefault();
                        scrollToFirstError();
                        return false;
                    }

                    if (submitBtn && !form.classList.contains('form-loading')) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('loading');
                        form.classList.add('form-loading');

                        setTimeout(() => {
                            if (form.classList.contains('form-loading')) {
                                submitBtn.disabled = false;
                                submitBtn.classList.remove('loading');
                                form.classList.remove('form-loading');
                            }
                        }, 10000);
                    }
                });
            });

            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim()) {
                        this.classList.remove('is-invalid');
                        const errorMsg = this.parentElement.querySelector('.error-message');
                        if (errorMsg) errorMsg.remove();
                    }
                });
            });

            setTimeout(() => {
                document.querySelectorAll('.alert:not(.alert-info)').forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            setTimeout(() => {
                document.querySelectorAll('.alert-info').forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 10000);

            const nipInput = document.getElementById('nip');
            if (nipInput) {
                nipInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '').slice(0, 8);
                    e.target.value = value;
                });
            }
        });

        function validateField(field) {
            const value = field.value.trim();
            let isValid = true;
            let errorMessage = '';

            const existingError = field.parentElement.querySelector('.error-message');
            if (existingError) existingError.remove();

            if (field.hasAttribute('required') && !value) {
                isValid = false;
                errorMessage = 'Wajib diisi';
            } else if (field.id === 'nip' && value && (value.length !== 8 || !/^\d{8}$/.test(value))) {
                isValid = false;
                errorMessage = 'NIP harus 8 digit angka';
            } else if (field.type === 'email' && value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                isValid = false;
                errorMessage = 'Format email tidak valid';
            } else if (field.type === 'password' && value && value.length < 6) {
                isValid = false;
                errorMessage = 'Minimal 6 karakter';
            }

            if (!isValid) {
                field.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${errorMessage}`;
                field.parentElement.appendChild(errorDiv);
            } else {
                field.classList.remove('is-invalid');
            }

            return isValid;
        }

        function validateForm(form) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!validateField(field)) isValid = false;
            });

            const password = form.querySelector('input[name="password"]');
            const passwordConfirm = form.querySelector('input[name="password_confirmation"]');
            if (password && passwordConfirm && password.value !== passwordConfirm.value) {
                validateField(passwordConfirm);
                isValid = false;
            }

            return isValid;
        }

        function scrollToFirstError() {
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                firstError.focus();
                firstError.style.animation = 'shake 0.5s ease-in-out';
                setTimeout(() => firstError.style.animation = '', 500);
            }
        }
    </script>
</body>

</html>
