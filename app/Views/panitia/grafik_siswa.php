<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Grafik Siswa Pendaftar<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<h2 class="mb-3">
    <i class="bi bi-graph-up"></i> Grafik Siswa Pendaftar
</h2>
<p class="text-muted">Visualisasi data pendaftar siswa</p>

        <div class="row gap-3 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <h3 class="mb-0"><?= $stats['total_pendaftar'] ?? 0; ?></h3>
                        <small>Total Pendaftar</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm bg-warning text-white">
                    <div class="card-body">
                        <h3 class="mb-0"><?= $stats['pending'] ?? 0; ?></h3>
                        <small>Menunggu Verifikasi</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body">
                        <h3 class="mb-0"><?= $stats['verified'] ?? 0; ?></h3>
                        <small>Terverifikasi</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm bg-danger text-white">
                    <div class="card-body">
                        <h3 class="mb-0"><?= $stats['rejected'] ?? 0; ?></h3>
                        <small>Ditolak</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Distribusi Status Pendaftar</h5>
                <div id="chartContainer" style="height: 300px; display: flex; align-items: center; justify-content: center;">
                    <p class="text-muted">Grafik akan ditampilkan di sini</p>
                </div>
            </div>
        </div>

<?= $this->endSection(); ?>
