<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Brosur Digital<?= $this->endSection(); ?>

<?php $this->section('content'); ?>

<!-- Header -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 fw-bold">
                <i class="bi bi-file-earmark-pdf-fill text-info me-2"></i>Brosur Digital
            </h3>
            <p class="text-muted mb-0">Akses dan bagikan brosur sekolah kepada calon siswa</p>
        </div>
        <a href="<?= base_url('sales/dashboard') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<?php if (empty($brochures)): ?>
    <!-- Empty State -->
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="bi bi-file-earmark-pdf text-muted" style="font-size: 5rem;"></i>
            </div>
            <h5 class="fw-semibold mb-2">Belum Ada Brosur</h5>
            <p class="text-muted mb-4">Brosur sekolah belum tersedia saat ini.<br>Silakan hubungi admin untuk menambahkan brosur.</p>
            <a href="<?= base_url('sales/dashboard') ?>" class="btn btn-primary">
                <i class="bi bi-house-door me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>
<?php else: ?>
    <!-- Brochures Grid -->
    <div class="row g-4">
        <?php foreach ($brochures as $index => $brochure): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm card-hover">
                <!-- Preview Image/Icon -->
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center position-relative" style="height: 220px;">
                    <?php 
                    $ext = pathinfo($brochure['file_path'], PATHINFO_EXTENSION);
                    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])): 
                    ?>
                        <img src="<?= base_url('writable/uploads/sales/' . $brochure['file_path']) ?>" 
                             alt="<?= esc($brochure['title']) ?>" 
                             class="w-100 h-100"
                             style="object-fit: cover;">
                    <?php else: ?>
                        <div class="text-center">
                            <i class="bi bi-file-pdf-fill text-danger" style="font-size: 4.5rem;"></i>
                            <div class="mt-2 text-muted small"><?= strtoupper($ext) ?> File</div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Badge Number -->
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-info">#<?= $index + 1 ?></span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-semibold mb-2"><?= esc($brochure['title']) ?></h5>
                    
                    <?php if ($brochure['description']): ?>
                        <p class="card-text text-muted small flex-grow-1">
                            <?= esc(strlen($brochure['description']) > 120 ? substr($brochure['description'], 0, 120) . '...' : $brochure['description']) ?>
                        </p>
                    <?php else: ?>
                        <p class="card-text text-muted small flex-grow-1">
                            Dokumen brosur sekolah untuk memberikan informasi lengkap kepada calon siswa.
                        </p>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 mt-3">
                        <?php if ($brochure['file_path']): ?>
                            <a href="<?= base_url('writable/uploads/sales/' . $brochure['file_path']) ?>" 
                               target="_blank" 
                               class="btn btn-info">
                                <i class="bi bi-eye me-2"></i>Lihat Brosur
                            </a>
                            <a href="<?= base_url('writable/uploads/sales/' . $brochure['file_path']) ?>" 
                               download 
                               class="btn btn-outline-info">
                                <i class="bi bi-download me-2"></i>Download
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer bg-light border-top-0">
                    <div class="d-flex align-items-center text-muted small">
                        <i class="bi bi-file-earmark me-2"></i>
                        <span>Dokumen Digital</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Info Card -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-1 text-center mb-3 mb-md-0">
                            <i class="bi bi-info-circle-fill text-info fs-1"></i>
                        </div>
                        <div class="col-md-11">
                            <h6 class="fw-semibold mb-2">Informasi Penggunaan</h6>
                            <ul class="mb-0 text-muted small">
                                <li>Klik <strong>"Lihat Brosur"</strong> untuk membuka dokumen di tab baru</li>
                                <li>Klik <strong>"Download"</strong> untuk menyimpan file ke perangkat Anda</li>
                                <li>Bagikan brosur ini kepada calon siswa yang berminat</li>
                                <li>Hubungi admin jika ada pertanyaan terkait konten brosur</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<style>
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(23, 162, 184, 0.15) !important;
}
</style>
<?php $this->endSection(); ?>
