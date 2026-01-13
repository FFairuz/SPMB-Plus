<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Laporan Keuangan<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<h2 class="mb-3">
    <i class="bi bi-file-earmark-pdf"></i> Laporan Keuangan
</h2>
<p class="text-muted">Laporan keuangan pendaftaran siswa baru</p>

<!-- Filter Form -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="get" action="/bendahara/laporan-keuangan" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" name="start_date" value="<?= $start_date; ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" name="end_date" value="<?= $end_date; ?>" required>
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="/bendahara/export-excel-keuangan?start_date=<?= $start_date; ?>&end_date=<?= $end_date; ?>" class="btn btn-success flex-grow-1">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row gap-3 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <h3 class="mb-0">Rp <?= number_format($stats['total_collected'] ?? 0, 0, ',', '.'); ?></h3>
                <small>Total Terkumpul</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <h3 class="mb-0"><?= $stats['total_transactions'] ?? 0; ?></h3>
                <small>Total Transaksi</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <h3 class="mb-0"><?= $stats['total_verified'] ?? 0; ?></h3>
                <small>Pembayaran Terverifikasi</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm bg-warning text-white">
            <div class="card-body">
                <h3 class="mb-0"><?= $stats['total_pending'] ?? 0; ?></h3>
                <small>Menunggu Verifikasi</small>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Report -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-table"></i> Detail Laporan Pembayaran</h5>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($payments)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Siswa</th>
                            <th>No. Pendaftaran</th>
                            <th>Jumlah</th>
                            <th>Tanggal Transfer</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($payments as $payment): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <small><?= htmlspecialchars($payment['username'] ?? 'N/A'); ?></small>
                                </td>
                                <td>
                                    <?= htmlspecialchars($payment['nama_lengkap'] ?? $payment['nama'] ?? 'N/A'); ?>
                                </td>
                                <td>
                                    <small><?= $payment['nomor_pendaftaran'] ?? 'N/A'; ?></small>
                                </td>
                                <td>
                                    <strong>Rp <?= number_format($payment['transfer_amount'] ?? 0, 0, ',', '.'); ?></strong>
                                </td>
                                <td>
                                    <small><?= date('d-m-Y H:i', strtotime($payment['transfer_date'])); ?></small>
                                </td>
                                <td>
                                    <?php if ($payment['payment_status'] === 'confirmed'): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Dikonfirmasi</span>
                                    <?php elseif ($payment['payment_status'] === 'submitted'): ?>
                                        <span class="badge bg-warning"><i class="bi bi-hourglass-split"></i> Menunggu</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ditolak</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle"></i> Tidak ada data pembayaran.
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection(); ?>
