<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Informasi Biaya Pendaftaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<h2 class="mb-1">
    <i class="bi bi-cash-coin"></i> Informasi Biaya Pendaftaran
</h2>
<p class="text-muted mb-4">Rincian lengkap biaya pendaftaran dan administrasi</p>

<?php if (empty($feeInfoList)): ?>
    <!-- No Fee Info Message -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-cash-coin text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 text-muted">Belum ada informasi biaya yang tersedia</h5>
                    <p class="text-muted">Informasi biaya akan segera ditambahkan</p>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-semibold">
                        <i class="bi bi-list text-primary me-2"></i> Rincian Biaya
                    </h5>
                    <div class="list-group list-group-flush">
                        <?php 
                        $badgeColors = ['primary', 'success', 'info', 'warning', 'danger'];
                        $colorIndex = 0;
                        foreach ($feeInfoList as $fee): 
                            $badge = $badgeColors[$colorIndex % count($badgeColors)];
                            $colorIndex++;
                        ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1 fw-semibold"><?= esc($fee['title']) ?></h6>
                                    <?php if ($fee['description']): ?>
                                        <small class="text-muted"><?= esc($fee['description']) ?></small>
                                    <?php elseif ($fee['fee_category']): ?>
                                        <small class="text-muted"><?= esc($fee['fee_category']) ?></small>
                                    <?php endif; ?>
                                </div>
                                <span class="badge bg-<?= $badge ?> rounded-pill fs-6">
                                    Rp <?= number_format($fee['fee_amount'] ?? 0, 0, ',', '.') ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-semibold">
                        <i class="bi bi-info-circle text-info me-2"></i> Informasi Penting
                    </h5>
                    <ul class="list-unstyled mb-0" style="line-height: 1.8;">
                        <li><i class="bi bi-check-circle text-success"></i> Pembayaran dapat dilakukan secara online atau offline</li>
                        <li><i class="bi bi-check-circle text-success"></i> Bukti pembayaran akan diberikan setelah verifikasi</li>
                        <li><i class="bi bi-check-circle text-success"></i> Biaya dapat disesuaikan berdasarkan program khusus</li>
                        <li><i class="bi bi-check-circle text-success"></i> Hubungi bagian admisi untuk informasi lebih lanjut</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-2 fw-semibold">Total Biaya</h6>
                    <h3 class="text-primary mb-0 fw-bold">
                        Rp <?= number_format(array_sum($biaya), 0, ',', '.') ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3 fw-semibold">
                <i class="bi bi-credit-card text-success me-2"></i> Metode Pembayaran
            </h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="p-3 border rounded text-center h-100">
                        <i class="bi bi-bank text-primary" style="font-size: 3rem;"></i>
                        <h6 class="mt-2 fw-semibold">Transfer Bank</h6>
                        <small class="text-muted">Ke rekening sekolah</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 border rounded text-center h-100">
                        <i class="bi bi-cash-coin text-success" style="font-size: 3rem;"></i>
                        <h6 class="mt-2 fw-semibold">Tunai</h6>
                        <small class="text-muted">Di kantor admisi sekolah</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 border rounded text-center h-100">
                        <i class="bi bi-credit-card text-warning" style="font-size: 3rem;"></i>
                        <h6 class="mt-2 fw-semibold">EDC/Kartu</h6>
                        <small class="text-muted">Debit/Kredit di sekolah</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
                            <h6 class="mt-2">Kartu Kredit</h6>
                            <small class="text-muted">Melalui gateway pembayaran</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>
