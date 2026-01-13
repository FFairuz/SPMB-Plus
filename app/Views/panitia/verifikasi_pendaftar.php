<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Verifikasi Pendaftar<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin: -1.5rem -1.5rem 2rem -1.5rem;
        border-radius: 0 0 1rem 1rem;
    }
    .page-header h2 {
        margin: 0;
        font-weight: 700;
        font-size: 2rem;
    }
    .page-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.95;
    }
    .card-verify {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        transition: all 0.3s ease;
    }
    .card-verify:hover {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }
    .table-striped tbody tr {
        border-bottom: 1px solid #e9ecef;
    }
    .table-striped tbody tr:hover {
        background-color: #f8f9fa;
    }
    .btn-verify {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
        font-weight: 600;
        padding: 0.5rem 0.85rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border-radius: 0.5rem;
    }
    .btn-verify:hover {
        background-color: #218838;
        border-color: #218838;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.25);
    }
    .btn-info {
        border-radius: 0.5rem;
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
        font-weight: 600;
        padding: 0.5rem 0.85rem;
        font-size: 0.9rem;
    }
    .btn-info:hover {
        background-color: #138496;
        border-color: #138496;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(23, 162, 184, 0.25);
    }
    .btn-primary {
        border-radius: 0.5rem;
        font-weight: 600;
        padding: 0.5rem 0.85rem;
        font-size: 0.9rem;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.25);
    }
    .btn-danger {
        border-radius: 0.5rem;
        font-weight: 600;
        padding: 0.5rem 0.85rem;
        font-size: 0.9rem;
    }
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.25);
    }
    .btn-sm {
        padding: 0.35rem 0.6rem !important;
        font-size: 0.8rem !important;
        border-radius: 0.375rem !important;
    }
    .btn-sm i {
        margin: 0 !important;
    }
    .btn-sm[data-bs-toggle="tooltip"] {
        cursor: help;
    }
    .tooltip-inner {
        background-color: #333;
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 0.375rem;
    }
    .tooltip.bs-tooltip-top .tooltip-arrow::before {
        border-top-color: #333;
    }
    .tooltip.bs-tooltip-bottom .tooltip-arrow::before {
        border-bottom-color: #333;
    }
    .tooltip.bs-tooltip-left .tooltip-arrow::before {
        border-left-color: #333;
    }
    .tooltip.bs-tooltip-right .tooltip-arrow::before {
        border-right-color: #333;
    }
    .table-action-cell {
        white-space: nowrap;
        padding: 0.75rem !important;
    }
    .badge-verified {
        background-color: #28a745;
        color: white;
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        border-radius: 0.5rem;
        display: inline-block;
    }
    .badge-pending {
        background-color: #ffc107;
        color: #333;
        padding: 0.35rem 0.75rem;
        border-radius: 0.25rem;
    }
    .stat-box {
        text-align: center;
        padding: 1rem;
        background: white;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #667eea;
    }
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }
    .search-box {
        border-radius: 0.5rem;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    .search-box:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>

<div class="page-header">
    <div class="container-fluid">
        <h2><i class="bi bi-check-circle"></i> Verifikasi Pendaftar</h2>
        <p>Kelola dan verifikasi pendaftar yang telah melakukan pendaftaran lengkap</p>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 2rem;">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill" style="font-size: 1.25rem; margin-right: 0.75rem;"></i>
            <div>
                <strong>Sukses!</strong><br>
                <?= session()->getFlashdata('success'); ?>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 2rem;">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-circle-fill" style="font-size: 1.25rem; margin-right: 0.75rem;"></i>
            <div>
                <strong>Error!</strong><br>
                <?= session()->getFlashdata('error'); ?>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (!empty($applicants)): ?>
<!-- Statistics Row -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-box">
            <div class="stat-number"><?= count($applicants); ?></div>
            <div class="stat-label">Total Pendaftar</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <div class="stat-number" style="color: #ffc107;">
                <?= count(array_filter($applicants, fn($a) => $a['status'] === 'submitted')); ?>
            </div>
            <div class="stat-label">Belum Verifikasi</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <div class="stat-number" style="color: #28a745;">
                <?= count(array_filter($applicants, fn($a) => $a['status'] === 'verified')); ?>
            </div>
            <div class="stat-label">Terverifikasi</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box">
            <div class="stat-number" style="color: #6c757d;">
                <?= intval((count(array_filter($applicants, fn($a) => $a['status'] === 'verified')) / count($applicants)) * 100); ?>%
            </div>
            <div class="stat-label">Progres</div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card card-verify">
    <div class="card-header bg-light border-0" style="padding: 1.5rem;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0" style="font-weight: 600;">Daftar Pendaftar</h5>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control search-box" id="searchTable" placeholder="Cari nama atau nomor pendaftaran...">
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Lengkap</th>
                    <th style="width: 20%;">Nomor Pendaftaran</th>
                    <th style="width: 25%;">Asal Sekolah</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                        <?php $no = 1; foreach ($applicants as $app): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $app['nama_lengkap'] ?? 'N/A'; ?></td>
                            <td><small class="text-monospace"><?= $app['nomor_pendaftaran'] ?? 'N/A'; ?></small></td>
                            <td><?= $app['asal_sekolah'] ?? '-'; ?></td>
                            <td>
                                <span class="badge bg-<?= ($app['status'] == 'verified') ? 'success' : 'warning'; ?>">
                                    <?= ucfirst($app['status'] ?? 'pending'); ?>
                                </span>
                            </td>
                            <td class="table-action-cell">
                                <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                                    <a href="/panitia/lihat_siswa/<?= $app['id']; ?>" class="btn btn-sm btn-info" title="Lihat Detail Siswa" data-bs-toggle="tooltip">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if ($app['status'] !== 'verified'): ?>
                                    <button type="button" class="btn btn-sm btn-verify" data-bs-toggle="modal" data-bs-target="#verifikasiModal<?= $app['id']; ?>" title="Verifikasi Data Siswa" data-bs-toggle="tooltip">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <?php else: ?>
                                    <a href="/panitia/cetak-pendaftaran/<?= $app['id']; ?>" class="btn btn-sm btn-primary" title="Cetak Formulir Pendaftaran" data-bs-toggle="tooltip" target="_blank">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                    <a href="/panitia/batal-verifikasi/<?= $app['id']; ?>" class="btn btn-sm btn-danger" title="Batalkan Verifikasi Siswa" data-bs-toggle="tooltip" onclick="return confirm('Batalkan verifikasi untuk <?= addslashes($app['nama_lengkap']); ?>?');">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Verifikasi untuk setiap pendaftar -->
        <?php foreach ($applicants as $app): ?>
        <div class="modal fade" id="verifikasiModal<?= $app['id']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border: none; border-radius: 1rem;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                        <h5 class="modal-title" style="font-weight: 700;">
                            <i class="bi bi-check-circle"></i> Konfirmasi Verifikasi Pendaftar
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 2rem;">
                        <div style="background-color: #f8f9fa; padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
                            <h6 style="color: #667eea; font-weight: 600; margin-bottom: 0.5rem;">Nama Pendaftar</h6>
                            <p style="font-size: 1.2rem; font-weight: 700; margin: 0; color: #212529;">
                                <?= $app['nama_lengkap'] ?? '-'; ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label style="font-weight: 600; color: #495057;">Nomor Pendaftaran</label>
                            <p style="background-color: #f8f9fa; padding: 0.75rem; border-radius: 0.5rem; font-family: monospace; margin: 0; border-left: 4px solid #667eea;">
                                <?= $app['nomor_pendaftaran'] ?? '-'; ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label style="font-weight: 600; color: #495057;">Asal Sekolah</label>
                            <p style="background-color: #f8f9fa; padding: 0.75rem; border-radius: 0.5rem; margin: 0; border-left: 4px solid #667eea;">
                                <?= $app['asal_sekolah'] ?? '-'; ?>
                            </p>
                        </div>
                        <div class="alert alert-info" style="border: none; background-color: #e7f3ff; color: #004085; margin-top: 1rem;">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Konfirmasi Verifikasi</strong><br>
                            Klik tombol "Verifikasi Sekarang" untuk menandai pendaftar ini sebagai terverifikasi dan tersimpan dalam sistem.
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #e9ecef;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 0.5rem;">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <a href="/panitia/verifikasi-pendaftar/<?= $app['id']; ?>" class="btn btn-success" style="border-radius: 0.5rem; background-color: #28a745; font-weight: 600;">
                            <i class="bi bi-check-circle"></i> Verifikasi Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <?php else: ?>
        <div class="alert alert-warning" style="border: none; background-color: #fff3cd; color: #856404; border-radius: 0.75rem;">
            <i class="bi bi-exclamation-triangle"></i> 
            <strong>Tidak ada data pendaftar</strong><br>
            Saat ini belum ada pendaftar yang perlu diverifikasi. Kembali lagi nanti untuk melihat data pendaftar baru.
        </div>
        <?php endif; ?>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            delay: { show: 300, hide: 100 }
        });
    });
});

// Search functionality
document.getElementById('searchTable')?.addEventListener('keyup', function(e) {
    const searchValue = e.target.value.toLowerCase();
    const tableBody = document.querySelector('table tbody');
    if (!tableBody) return;
    
    const rows = tableBody.querySelectorAll('tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
</script>

<?= $this->endSection(); ?>

