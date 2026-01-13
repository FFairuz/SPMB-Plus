<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Detail Pembayaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<h2 class="mb-3">
    <i class="bi bi-file-earmark-text"></i> Detail Pembayaran
</h2>
<div class="mb-3">
    <a href="/bendahara/verifikasi-pembayaran" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row gap-4">
        <!-- Informasi Pembayaran -->
        <div class="col-lg-7">
            <!-- Data Siswa -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-person"></i> Data Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="fw-bold text-muted">Nomor Pendaftaran:</label>
                        </div>
                        <div class="col-sm-8">
                            <span class="text-monospace"><?= $payment['nomor_pendaftaran'] ?? 'Belum mendaftar'; ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="fw-bold text-muted">Nama Siswa:</label>
                        </div>
                        <div class="col-sm-8">
                            <span><?= htmlspecialchars($payment['nama_lengkap'] ?? 'N/A'); ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="fw-bold text-muted">Asal Sekolah:</label>
                        </div>
                        <div class="col-sm-8">
                            <span><?= htmlspecialchars($payment['asal_sekolah'] ?? 'N/A'); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="fw-bold text-muted">Email:</label>
                        </div>
                        <div class="col-sm-8">
                            <span><?= htmlspecialchars($payment['email'] ?? 'N/A'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rincian Pembayaran -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-cash-coin"></i> Rincian Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="fw-bold text-muted">Bank:</label>
                        </div>
                        <div class="col-sm-8">
                            <span><?= htmlspecialchars($payment['bank_name'] ?? 'N/A'); ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="fw-bold text-muted">Nomor Rekening:</label>
                        </div>
                        <div class="col-sm-8">
                            <span class="text-monospace"><?= htmlspecialchars($payment['account_number'] ?? 'N/A'); ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="fw-bold text-muted">Atas Nama:</label>
                        </div>
                        <div class="col-sm-8">
                            <span><?= htmlspecialchars($payment['account_holder'] ?? 'N/A'); ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="fw-bold text-muted">Jumlah Transfer:</label>
                        </div>
                        <div class="col-sm-8">
                            <strong>Rp <?= number_format($payment['transfer_amount'] ?? 0, 0, ',', '.'); ?></strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="fw-bold text-muted">Tanggal Transfer:</label>
                        </div>
                        <div class="col-sm-8">
                            <span><?= date('d-m-Y', strtotime($payment['transfer_date'])); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="fw-bold text-muted">Biaya Pendaftaran:</label>
                        </div>
                        <div class="col-sm-8">
                            <strong>Rp <?= number_format($payment['registration_fee'] ?? 0, 0, ',', '.'); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bukti Transfer -->
            <?php if ($payment['transfer_proof_path']): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-image"></i> Bukti Transfer</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="/<?= $payment['transfer_proof_path']; ?>" alt="Bukti Transfer" class="img-fluid rounded" style="max-height: 400px;">
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Status Verifikasi -->
        <div class="col-lg-5">
            <!-- Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-shield-check"></i> Status Verifikasi</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="fw-bold text-muted">Status Pembayaran:</label>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            $payment_status = $payment['payment_status'];
                            if ($payment_status === 'pending') {
                                $badge = '<span class="badge bg-secondary">Pending</span>';
                            } elseif ($payment_status === 'submitted') {
                                $badge = '<span class="badge bg-warning">Submitted</span>';
                            } elseif ($payment_status === 'confirmed') {
                                $badge = '<span class="badge bg-info">Confirmed</span>';
                            } elseif ($payment_status === 'rejected') {
                                $badge = '<span class="badge bg-danger">Rejected</span>';
                            } else {
                                $badge = '<span class="badge bg-secondary">Unknown</span>';
                            }
                            echo $badge;
                            ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="fw-bold text-muted">Status Verifikasi:</label>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            if ($payment['verified_by_bendahara']) {
                                echo '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Terverifikasi</span>';
                            } else {
                                echo '<span class="badge bg-warning"><i class="bi bi-hourglass-split"></i> Belum Verifikasi</span>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="fw-bold text-muted">Kwitansi:</label>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            if ($payment['receipt_number']) {
                                echo '<span class="badge bg-success">' . $payment['receipt_number'] . '</span>';
                            } else {
                                echo '<span class="badge bg-secondary">Belum dicetak</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-lightning"></i> Aksi</h5>
                </div>
                <div class="card-body">
                    <?php if ($payment['payment_status'] === 'confirmed' && !$payment['verified_by_bendahara']): ?>
                        <form method="post" action="/bendahara/terima_pembayaran/<?= $payment['id']; ?>" class="mb-3">
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Verifikasi pembayaran ini?');">
                                <i class="bi bi-check-circle"></i> Verifikasi Pembayaran
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if ($payment['payment_status'] === 'confirmed' && $payment['verified_by_bendahara']): ?>
                        <a href="/bendahara/cetak-bukti/<?= $payment['id']; ?>" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-printer"></i> Cetak Kwitansi
                        </a>
                    <?php else: ?>
                        <button class="btn btn-primary w-100 mb-3" disabled>
                            <i class="bi bi-printer"></i> Cetak Kwitansi (Verifikasi dulu)
                        </button>
                    <?php endif; ?>

                    <a href="/bendahara/verifikasi-pembayaran" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

<?= $this->endSection(); ?>
