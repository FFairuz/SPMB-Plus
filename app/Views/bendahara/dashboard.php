<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Dashboard Bendahara<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 fw-bold">
            <i class="bi bi-wallet2 text-success"></i> Dashboard Bendahara
        </h2>
        <p class="text-muted mb-0">Kelola pembayaran, verifikasi, dan cetak kwitansi</p>
    </div>
    <div class="text-end">
        <small class="text-muted d-block">Terakhir diperbarui</small>
        <small class="fw-semibold"><?= date('d M Y, H:i') ?></small>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="bi bi-hourglass-split fs-3 text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Pembayaran Pending</small>
                        <h3 class="fw-bold mb-0 text-warning"><?= $stats['total_pending'] ?? 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 rounded p-3">
                            <i class="bi bi-check-circle fs-3 text-info"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Pembayaran Confirmed</small>
                        <h3 class="fw-bold mb-0 text-info"><?= $stats['total_confirmed'] ?? 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="bi bi-shield-check fs-3 text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Terverifikasi</small>
                        <h3 class="fw-bold mb-0 text-success"><?= $stats['total_verified'] ?? 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="bi bi-printer fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Kwitansi Dicetak</small>
                        <h3 class="fw-bold mb-0 text-primary"><?= $stats['total_printed_receipt'] ?? 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Total Collected -->
<div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
    <div class="card-body p-4 text-white">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h5 class="mb-2 d-flex align-items-center">
                    <i class="bi bi-cash-stack me-2 fs-4"></i>
                    Total Terkumpul (Pembayaran Confirmed)
                </h5>
                <p class="mb-0 opacity-75">Ringkasan total biaya pendaftaran yang sudah diterima dan dikonfirmasi</p>
            </div>
            <div class="col-md-4 text-end">
                <h2 class="mb-0 fw-bold">Rp <?= number_format($stats['total_collected'] ?? 0, 0, ',', '.'); ?></h2>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row g-4">
    <div class="col-lg-4">
        <!-- Actions Menu -->
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-menu-button-wide text-success me-2"></i>Menu Bendahara
                </h5>
            </div>
            <div class="card-body p-0">
                    <a href="/bendahara/verifikasi-pembayaran" class="btn btn-outline-primary w-100 text-start rounded-0 border-0 py-3">
                        <i class="bi bi-check-square"></i> Verifikasi Pembayaran
                    </a>
                    <a href="/bendahara/laporan-keuangan" class="btn btn-outline-primary w-100 text-start rounded-0 border-0 border-top py-3">
                        <i class="bi bi-file-earmark-pdf"></i> Laporan Keuangan
                    </a>
                    <a href="/auth/logout" class="btn btn-outline-danger w-100 text-start rounded-0 border-0 border-top py-3">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Recent Payments for Verification -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Pembayaran Menunggu Verifikasi</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($recent_payments)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Username</th>
                                        <th>Nama Siswa</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Confirm</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_payments as $payment): ?>
                                        <tr>
                                            <td>
                                                <small><?= htmlspecialchars($payment['username'] ?? 'N/A'); ?></small>
                                            </td>
                                            <td>
                                                <small><?= htmlspecialchars($payment['nama_lengkap'] ?? $payment['nama'] ?? 'N/A'); ?></small>
                                            </td>
                                            <td>
                                                <strong>Rp <?= number_format($payment['transfer_amount'] ?? 0, 0, ',', '.'); ?></strong>
                                            </td>
                                            <td>
                                                <small><?= date('d-m-Y', strtotime($payment['confirmed_at'])); ?></small>
                                            </td>
                                            <td>
                                                <a href="/bendahara/detail-pembayaran/<?= $payment['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> Tidak ada pembayaran yang menunggu verifikasi.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="/bendahara/verifikasi-pembayaran" class="text-decoration-none">Lihat Semua →</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
