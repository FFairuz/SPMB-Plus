<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Beranda<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Hero Section -->
<div class="hero-section">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-4 text-white">
                    <span class="text-gradient">Sistem PPDB</span><br>
                    Penerimaan Peserta Didik Baru
                </h1>
                <p class="lead text-white-50 mb-4">
                    Platform pendaftaran online yang modern, aman, dan transparan. Daftar dengan mudah dan pantau status Anda secara real-time.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="/auth/register" class="btn btn-light btn-lg px-5">
                        <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                    </a>
                    <a href="/auth/login" class="btn btn-outline-light btn-lg px-5">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <div class="rounded-circle bg-primary-gradient p-4 d-inline-block mb-3">
                                    <i class="bi bi-person-check" style="font-size: 3rem; color: white;"></i>
                                </div>
                            </div>
                            <h3 class="card-title text-center mb-3">Kemudahan Pendaftaran</h3>
                            <p class="card-text text-center text-muted">
                                Proses pendaftaran yang sederhana dengan interface yang user-friendly dan dukungan lengkap dari tim kami.
                            </p>
                            <ul class="list-unstyled mt-4">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Daftar online 24/7</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Pantau status real-time</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Upload dokumen mudah</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold mb-3">Keunggulan Sistem Kami</h2>
            <p class="lead text-muted">Solusi pendaftaran yang dirancang untuk kemudahan dan keamanan maksimal</p>
        </div>

        <div class="row g-4">
            <!-- Feature 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 feature-card">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-4">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h5 class="card-title mb-3 fw-bold">Pendaftaran Cepat</h5>
                        <p class="card-text text-muted">
                            Isi formulir pendaftaran dalam hitungan menit dengan panduan lengkap dan validasi otomatis.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 feature-card">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-4">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h5 class="card-title mb-3 fw-bold">Data Aman Terjamin</h5>
                        <p class="card-text text-muted">
                            Data pribadi Anda dilindungi dengan enkripsi tingkat enterprise dan sistem keamanan berlapis.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 feature-card">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-4">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h5 class="card-title mb-3 fw-bold">Transparansi Penuh</h5>
                        <p class="card-text text-muted">
                            Pantau setiap tahap proses pendaftaran Anda dengan dashboard yang informatif dan real-time.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 feature-card">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-4">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <h5 class="card-title mb-3 fw-bold">Upload Dokumen Mudah</h5>
                        <p class="card-text text-muted">
                            Unggah dokumen penting dengan antarmuka yang intuitif dan dukungan berbagai format file.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 feature-card">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-4">
                            <i class="bi bi-bell"></i>
                        </div>
                        <h5 class="card-title mb-3 fw-bold">Notifikasi Otomatis</h5>
                        <p class="card-text text-muted">
                            Dapatkan pemberitahuan instan untuk setiap update status pendaftaran dan pengumuman penting.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 feature-card">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-4">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h5 class="card-title mb-3 fw-bold">Support 24/7</h5>
                        <p class="card-text text-muted">
                            Tim support kami siap membantu menjawab pertanyaan dan mengatasi kendala Anda kapan saja.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-gradient-primary text-white">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <h3 class="display-6 fw-bold mb-2">1000+</h3>
                <p class="mb-0">Peserta Didik Terdaftar</p>
            </div>
            <div class="col-md-3">
                <h3 class="display-6 fw-bold mb-2">50+</h3>
                <p class="mb-0">Sekolah Mitra</p>
            </div>
            <div class="col-md-3">
                <h3 class="display-6 fw-bold mb-2">99.9%</h3>
                <p class="mb-0">Uptime</p>
            </div>
            <div class="col-md-3">
                <h3 class="display-6 fw-bold mb-2">100%</h3>
                <p class="mb-0">Aman</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 bg-primary rounded-4 text-white p-5">
                    <div class="text-center">
                        <h2 class="fw-bold mb-3">Siap untuk Memulai?</h2>
                        <p class="lead mb-4">Daftarkan diri Anda sekarang dan bergabunglah dengan ribuan peserta didik lainnya.</p>
                        <a href="/auth/register" class="btn btn-light btn-lg px-5">
                            <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>
