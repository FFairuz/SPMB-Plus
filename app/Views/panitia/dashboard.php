<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Dashboard Panitia<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 fw-bold">
            <i class="bi bi-clipboard-check text-primary"></i> Dashboard Panitia
        </h2>
        <p class="text-muted mb-0">Kelola pendaftaran calon siswa dan pantau status pembayaran</p>
    </div>
    <div class="text-end">
        <small class="text-muted d-block">Terakhir diperbarui</small>
        <small class="fw-semibold"><?= date('d M Y, H:i') ?></small>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-people-fill fs-4 text-primary"></i>
                </div>
                <h3 class="fw-bold mb-1"><?= $stats['total_registered'] ?? 0; ?></h3>
                <small class="text-muted">Total Terdaftar</small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                </div>
                <h3 class="fw-bold mb-1"><?= $stats['total_pending_payment'] ?? 0; ?></h3>
                <small class="text-muted">Pembayaran Pending</small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                </div>
                <h3 class="fw-bold mb-1"><?= $stats['total_confirmed_payment'] ?? 0; ?></h3>
                <small class="text-muted">Pembayaran Confirmed</small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-send-fill fs-4 text-info"></i>
                </div>
                <h3 class="fw-bold mb-1"><?= $stats['total_submitted'] ?? 0; ?></h3>
                <small class="text-muted">Form Submitted</small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-check2-all fs-4 text-success"></i>
                </div>
                <h3 class="fw-bold mb-1"><?= $stats['total_accepted'] ?? 0; ?></h3>
                <small class="text-muted">Diterima</small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-x-circle-fill fs-4 text-danger"></i>
                </div>
                <h3 class="fw-bold mb-1"><?= $stats['total_rejected'] ?? 0; ?></h3>
                <small class="text-muted">Ditolak</small>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->\n<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <h5 class="mb-3 fw-semibold"><i class="bi bi-lightning-fill text-warning me-2"></i>Aksi Cepat</h5>
        <div class="d-flex flex-wrap gap-2">
            <a href="/panitia/tambah-siswa" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i> Tambah Siswa Baru
            </a>
            <a href="/panitia/daftar-siswa" class="btn btn-info">
                <i class="bi bi-list-ul me-1"></i> Lihat Daftar Siswa
            </a>
            <a href="/panitia/verifikasi-pendaftar" class="btn btn-success">
                <i class="bi bi-clipboard-check me-1"></i> Verifikasi Pendaftar
            </a>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-lg-4">
            <!-- Actions Menu -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-menu-button"></i> Menu Panitia</h5>
                </div>
                <div class="card-body p-0">
                    <a href="/panitia/daftar-siswa" class="btn btn-outline-primary w-100 text-start rounded-0 border-0 py-3">
                        <i class="bi bi-list"></i> Daftar Siswa
                    </a>
                    <a href="/panitia/tambah-siswa" class="btn btn-outline-primary w-100 text-start rounded-0 border-0 border-top py-3">
                        <i class="bi bi-person-plus"></i> Tambah Siswa Baru
                    </a>
                    <a href="/auth/logout" class="btn btn-outline-danger w-100 text-start rounded-0 border-0 border-top py-3">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Recent Applicants -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Pendaftar Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($recent_applicants)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Pendaftaran</th>
                                        <th>Nama Lengkap</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_applicants as $index => $applicant): ?>
                                        <tr>
                                            <td>
                                                <small class="text-monospace"><?= $applicant['nomor_pendaftaran'] ?? 'N/A'; ?></small>
                                            </td>
                                            <td><?= htmlspecialchars($applicant['nama_lengkap']); ?></td>
                                            <td>
                                                <?php 
                                                $status = $applicant['status'] ?? '';
                                                if ($status === 'pending') {
                                                    $badge_class = 'bg-secondary';
                                                } elseif ($status === 'submitted') {
                                                    $badge_class = 'bg-info';
                                                } elseif ($status === 'accepted') {
                                                    $badge_class = 'bg-success';
                                                } elseif ($status === 'rejected') {
                                                    $badge_class = 'bg-danger';
                                                } else {
                                                    $badge_class = 'bg-secondary';
                                                }
                                                ?>
                                                <span class="badge <?= $badge_class; ?>"><?= ucfirst($status); ?></span>
                                            </td>
                                            <td>
                                                <a href="/panitia/lihat_siswa/<?= $applicant['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> Belum ada pendaftar terbaru.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="/panitia/daftar-siswa" class="text-decoration-none">Lihat Semua →</a>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection(); ?>
