<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Dashboard Sales<?= $this->endSection(); ?>

<?php $this->section('content'); ?>

<!-- Header -->
<div class="mb-4">
    <h3 class="mb-1 fw-bold">Dashboard Sales</h3>
    <p class="text-muted mb-0">Informasi pendaftar dan statistik PPDB</p>
</div>

<!-- Statistik Pendaftar -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-person-plus-fill text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Total Pendaftar</small>
                        <h2 class="fw-bold mb-0"><?= $totalApplicants; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Disetujui</small>
                        <h2 class="fw-bold mb-0"><?= $approvedApplicants; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-hourglass-split text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Pending</small>
                        <h2 class="fw-bold mb-0"><?= $pendingApplicants; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-x-circle-fill text-danger" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Ditolak</small>
                        <h2 class="fw-bold mb-0"><?= $rejectedApplicants; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Cards -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-start mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-graph-up-arrow text-info fs-3"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="fw-semibold mb-2">Ringkasan Data</h5>
                        <p class="text-muted mb-0">Data pendaftar diperbarui secara real-time dan dapat digunakan untuk monitoring proses PPDB.</p>
                    </div>
                </div>
                <div class="border-top pt-3">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <h4 class="text-success fw-bold mb-1"><?= $totalApplicants > 0 ? round(($approvedApplicants / $totalApplicants) * 100) : 0 ?>%</h4>
                            <small class="text-muted">Tingkat Penerimaan</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-primary fw-bold mb-1"><?= $totalApplicants ?></h4>
                            <small class="text-muted">Total Registrasi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-start mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-info-circle-fill text-primary fs-3"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="fw-semibold mb-2">Akses Cepat</h5>
                        <p class="text-muted mb-3">Gunakan menu di sidebar untuk mengakses informasi dan materi promosi</p>
                    </div>
                </div>
                <div class="d-flex flex-column gap-2">
                    <a href="<?= base_url('sales/video') ?>" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-play-circle me-2"></i>Video Sekolah
                    </a>
                    <a href="<?= base_url('sales/brochure') ?>" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Brosur Digital
                    </a>
                    <a href="<?= base_url('sales/informasi-biaya') ?>" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-cash-stack me-2"></i>Informasi Biaya
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
