<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Cetak Bukti Pembayaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<h2 class="mb-3">
    <i class="bi bi-printer"></i> Cetak Bukti Pembayaran
</h2>
<p class="text-muted">Pilih pembayaran untuk dicetak buktinya</p>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Nomor Pendaftaran</th>
                            <th>Jumlah Pembayaran</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($payments)): ?>
                            <?php $no = 1; foreach ($payments as $payment): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $payment['nama_lengkap'] ?? 'N/A'; ?></td>
                                <td><?= $payment['nomor_pendaftaran'] ?? 'N/A'; ?></td>
                                <td>Rp <?= number_format($payment['transfer_amount'] ?? 0, 0, ',', '.'); ?></td>
                                <td><?= date('d/m/Y', strtotime($payment['transfer_date'] ?? now())); ?></td>
                                <td>
                                    <a href="/bendahara/cetak-bukti/<?= $payment['id']; ?>" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="bi bi-printer"></i> Cetak
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Tidak ada pembayaran yang dikonfirmasi
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

<?= $this->endSection(); ?>
