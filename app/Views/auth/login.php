<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= app_name() ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('css/readability.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/dynamic-logo.css') ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.05) 25%, 
                transparent 50%,
                rgba(255, 255, 255, 0.05) 75%,
                transparent 100%);
            animation: shimmer 15s linear infinite;
            pointer-events: none;
        }

        @keyframes shimmer {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1000px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-left {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 8s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }

        .login-left-content {
            position: relative;
            z-index: 1;
        }

        .logo-box {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .logo-box i {
            font-size: 2.5rem;
            color: white;
        }

        .login-left h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: white;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .login-left p {
            font-size: 1.1rem;
            color: white;
            opacity: 1;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-list li {
            padding: 12px 0;
            display: flex;
            align-items: center;
            font-size: 1rem;
            color: white;
            opacity: 1;
        }

        .feature-list li i {
            font-size: 1.25rem;
            margin-right: 12px;
            background: rgba(255, 255, 255, 0.2);
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: white;
        }

        .feature-list li span {
            color: white;
        }

        .login-right {
            padding: 60px 50px;
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-control {
            padding: 14px 18px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
            outline: none;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1.1rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            border: none;
            color: white;
            padding: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.5);
            background: linear-gradient(135deg, #0b5ed7 0%, #0d6efd 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 30px 0;
            color: #999;
            font-size: 0.9rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }

        .divider span {
            padding: 0 15px;
        }

        .btn-register {
            background: white;
            border: 2px solid #0d6efd;
            color: #0d6efd;
            padding: 14px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            background: #0d6efd;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95rem;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
        }

        .alert-success {
            background: #efe;
            color: #3c3;
        }

        .alert i {
            font-size: 1.25rem;
        }

        .footer-text {
            text-align: center;
            margin-top: 30px;
            color: #999;
            font-size: 0.9rem;
        }

        .footer-text a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-left {
                display: none;
            }

            .login-right {
                padding: 40px 30px;
            }

            .login-header h2 {
                font-size: 1.75rem;
            }
        }

        /* Show password toggle */
        .password-toggle {
            cursor: pointer;
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="row g-0">
                <!-- Left Side -->
                <div class="col-lg-5 login-left">
                    <div class="login-left-content">
                        <div class="logo-box">
                            <?php 
                            $logo = app_logo();
                            $appName = app_name();
                            $appDesc = app_description();
                            ?>
                            <?php if (strpos($logo, 'default-logo.png') === false && file_exists(str_replace(base_url(), FCPATH, $logo))): ?>
                                <img src="<?= $logo ?>" alt="<?= esc($appName) ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            <?php else: ?>
                                <i class="bi bi-mortarboard-fill"></i>
                            <?php endif; ?>
                        </div>
                        <h1>Selamat Datang!</h1>
                        <p><?= esc($appDesc) ?></p>
                        
                        <ul class="feature-list">
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Pendaftaran Online 24/7</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Proses Verifikasi Cepat</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Informasi Real-Time</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Aman & Terpercaya</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-lg-7 login-right">
                    <div class="login-header">
                        <h2>Login ke Akun Anda</h2>
                        <p>Masukkan email dan password untuk melanjutkan</p>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <span><?= session()->getFlashdata('error'); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill"></i>
                            <span><?= session()->getFlashdata('success'); ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('auth/login') ?>">
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope-fill"></i> Email Address
                            </label>
                            <div class="input-icon">
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="nama@email.com" required autocomplete="email">
                                <i class="bi bi-person-circle"></i>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock-fill"></i> Password
                            </label>
                            <div class="input-icon">
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Masukkan password" required autocomplete="current-password">
                                <i class="bi bi-eye-slash password-toggle" id="togglePassword"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login Sekarang
                        </button>
                    </form>

                    <div class="divider">
                        <span>atau</span>
                    </div>

                    <a href="<?= base_url('auth/register') ?>" class="btn btn-register">
                        <i class="bi bi-person-plus me-2"></i>Daftar Akun Baru
                    </a>

                    <div class="footer-text">
                        <p>Butuh bantuan? <a href="#">Hubungi Admin</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        }

        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
