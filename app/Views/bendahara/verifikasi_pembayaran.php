<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Verifikasi Pembayaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<h2 class="mb-3">
    <i class="bi bi-check-square"></i> Verifikasi Pembayaran
</h2>
<p class="text-muted">Review dan verifikasi pembayaran dari calon siswa</p>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filter Tabs -->
    <ul class="nav nav-pills mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link <?= $current_status === 'unverified' ? 'active' : ''; ?>" href="/bendahara/verifikasi-pembayaran?status=unverified">
                <i class="bi bi-hourglass-split"></i> Belum Diverifikasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $current_status === 'verified' ? 'active' : ''; ?>" href="/bendahara/verifikasi-pembayaran?status=verified">
                <i class="bi bi-check-circle"></i> Sudah Diverifikasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $current_status === 'receipt_printed' ? 'active' : ''; ?>" href="/bendahara/verifikasi-pembayaran?status=receipt_printed">
                <i class="bi bi-printer"></i> Kwitansi Dicetak
            </a>
        </li>
    </ul>

    <!-- Data Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <?php if (!empty($payments)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Username</th>
                                <th>Nama Siswa</th>
                                <th>No. Pendaftaran</th>
                                <th>Jumlah</th>
                                <th>Tanggal Confirm</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payments as $payment): ?>
                                <tr>
                                    <td>
                                        <small><?= htmlspecialchars($payment['username'] ?? 'N/A'); ?></small>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($payment['nama_lengkap'] ?? $payment['nama'] ?? 'N/A'); ?>
                                    </td>
                                    <td>
                                        <small class="text-monospace"><?= $payment['nomor_pendaftaran'] ?? 'N/A'; ?></small>
                                    </td>
                                    <td>
                                        <strong>Rp <?= number_format($payment['transfer_amount'] ?? 0, 0, ',', '.'); ?></strong>
                                    </td>
                                    <td>
                                        <small><?= date('d-m-Y H:i', strtotime($payment['confirmed_at'])); ?></small>
                                    </td>
                                    <td>
                                        <?php
                                        if ($payment['verified_by_bendahara']) {
                                            $status_badge = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Terverifikasi</span>';
                                        } else {
                                            $status_badge = '<span class="badge bg-warning"><i class="bi bi-hourglass-split"></i> Belum Verifikasi</span>';
                                        }
                                        echo $status_badge;
                                        ?>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                                            <a href="/bendahara/detail-pembayaran/<?= $payment['id']; ?>" class="btn btn-sm btn-outline-primary" title="Lihat Detail" data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <?php if ($payment['verified_by_bendahara']): ?>
                                            <a href="/bendahara/cetak-bukti-pembayaran/<?= $payment['id']; ?>" class="btn btn-sm btn-primary" title="Cetak Bukti" data-bs-toggle="tooltip" target="_blank">
                                                <i class="bi bi-printer"></i>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle"></i> Tidak ada pembayaran untuk ditampilkan.
                </div>
            <?php endif; ?>
        </div>
        <?php if (!empty($pager)): ?>
            <div class="card-footer bg-light">
                <?= $pager->links(); ?>
            </div>
        <?php endif; ?>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            delay: { show: 300, hide: 100 }
        });
    });
});
</script>

<?= $this->endSection(); ?>
