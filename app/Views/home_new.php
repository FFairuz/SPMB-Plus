<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPMB Online - Penerimaan Peserta Didik Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
            --secondary: #6c757d;
            --success: #198754;
            --info: #0dcaf0;
            --warning: #ffc107;
            --danger: #dc3545;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary) !important;
        }

        .nav-link {
            font-weight: 500;
            color: #333 !important;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: #f8f9fa;
            color: var(--primary) !important;
        }

        .btn-nav {
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.95;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* Feature Cards */
        .feature-card {
            border: none;
            border-radius: 20px;
            padding: 2rem;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(13, 110, 253, 0.15) !important;
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon i {
            font-size: 2rem;
            color: white;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1rem;
        }

        .feature-text {
            color: #666;
            line-height: 1.6;
            margin-bottom: 0;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            padding: 80px 0;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* CTA Section */
        .cta-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .cta-card {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            border-radius: 24px;
            padding: 60px 40px;
            text-align: center;
            color: white;
            box-shadow: 0 20px 60px rgba(13, 110, 253, 0.25);
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta-text {
            font-size: 1.125rem;
            opacity: 0.95;
            margin-bottom: 2rem;
        }

        /* Buttons */
        .btn-primary-custom {
            background: white;
            color: var(--primary);
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: #f8f9fa;
        }

        .btn-outline-custom {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            background: #fff;
            border-top: 1px solid #e9ecef;
            padding: 60px 0 30px;
        }

        .footer-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .footer-desc {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            border-top: 1px solid #e9ecef;
            padding-top: 25px;
            margin-top: 40px;
        }

        .footer-copyright {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.125rem;
            }

            .stat-number {
                font-size: 2.5rem;
            }

            .cta-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-mortarboard-fill"></i> SPMB Online
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#keunggulan">Keunggulan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#statistik">Statistik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/login') ?>">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('auth/register') ?>" class="btn btn-primary btn-nav">
                            <i class="bi bi-person-plus me-1"></i> Daftar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="beranda">
        <div class="container">
            <div class="row align-items-center hero-content">
                <div class="col-lg-7">
                    <?php if (!empty($hero)): ?>
                        <h1 class="hero-title"><?= esc($hero[0]['title']) ?></h1>
                        <p class="hero-subtitle"><?= esc($hero[0]['content']) ?></p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="<?= esc($hero[0]['button_link']) ?>" class="btn btn-primary-custom">
                                <i class="bi bi-rocket-takeoff me-2"></i><?= esc($hero[0]['button_text']) ?>
                            </a>
                            <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-custom">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </a>
                        </div>
                    <?php else: ?>
                        <h1 class="hero-title">Sistem SPMB Online</h1>
                        <p class="hero-subtitle">Platform pendaftaran peserta didik baru yang modern dan terpercaya.</p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="/auth/register" class="btn btn-primary-custom">
                                <i class="bi bi-rocket-takeoff me-2"></i>Daftar Sekarang
                            </a>
                            <a href="/auth/login" class="btn btn-outline-custom">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-5 mt-5 mt-lg-0">
                    <div class="text-center">
                        <div class="card border-0 shadow-lg" style="border-radius: 24px; background: rgba(255,255,255,0.95);">
                            <div class="card-body p-5">
                                <i class="bi bi-mortarboard-fill" style="font-size: 5rem; color: var(--primary);"></i>
                                <h4 class="mt-4 mb-3" style="color: #1a1a1a;">Mulai Pendaftaran</h4>
                                <p class="text-muted mb-4">Proses mudah, cepat, dan aman</p>
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('auth/register') ?>" class="btn btn-primary btn-lg">Daftar Baru</a>
                                    <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-primary btn-lg">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="keunggulan" style="padding: 80px 0 !important;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Keunggulan Sistem Kami</h2>
                <p class="lead text-muted">Platform yang dirancang untuk kemudahan dan keamanan maksimal</p>
            </div>

            <div class="row g-4">
                <?php if (!empty($features)): ?>
                    <?php foreach ($features as $feature): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card feature-card shadow-sm">
                                <div class="feature-icon">
                                    <i class="<?= esc($feature['image']) ?>"></i>
                                </div>
                                <h5 class="feature-title"><?= esc($feature['title']) ?></h5>
                                <p class="feature-text"><?= esc($feature['content']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada data keunggulan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section" id="statistik">
        <div class="container">
            <div class="row g-4">
                <?php if (!empty($stats)): ?>
                    <?php foreach ($stats as $stat): ?>
                        <div class="col-6 col-md-3">
                            <div class="stat-card">
                                <i class="<?= esc($stat['image']) ?> stat-icon"></i>
                                <div class="stat-number"><?= esc($stat['title']) ?></div>
                                <div class="stat-label"><?= esc($stat['subtitle']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>Statistik akan segera ditampilkan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <?php if (!empty($cta)): ?>
                        <div class="cta-card">
                            <h2 class="cta-title"><?= esc($cta[0]['title']) ?></h2>
                            <p class="cta-text"><?= esc($cta[0]['content']) ?></p>
                            <a href="<?= esc($cta[0]['button_link']) ?>" class="btn btn-primary-custom btn-lg">
                                <i class="bi bi-arrow-right-circle me-2"></i><?= esc($cta[0]['button_text']) ?>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="cta-card">
                            <h2 class="cta-title">Siap Bergabung?</h2>
                            <p class="cta-text">Daftarkan diri Anda sekarang juga!</p>
                            <a href="/auth/register" class="btn btn-primary-custom btn-lg">
                                <i class="bi bi-arrow-right-circle me-2"></i>Mulai Pendaftaran
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="footer-brand">
                        <i class="bi bi-mortarboard-fill me-2"></i>SPMB Online
                    </div>
                    <p class="footer-desc mb-0">Platform pendaftaran modern untuk generasi masa depan</p>
                </div>
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <ul class="footer-links justify-content-lg-center">
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#keunggulan">Keunggulan</a></li>
                        <li><a href="#statistik">Statistik</a></li>
                        <li><a href="<?= base_url('auth/login') ?>">Login</a></li>
                        <li><a href="<?= base_url('auth/register') ?>">Daftar</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <div class="social-links justify-content-lg-end">
                        <a href="#" class="social-link" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link" title="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-link" title="Email">
                            <i class="bi bi-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <p class="footer-copyright">&copy; <?= date('Y') ?> SPMB Online. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <p class="footer-copyright mb-0">
                            <a href="#" style="color: #6c757d; text-decoration: none;">Privacy Policy</a>
                            <span class="mx-2">•</span>
                            <a href="#" style="color: #6c757d; text-decoration: none;">Terms of Service</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
