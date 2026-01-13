<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Daftar Siswa<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 fw-bold">
            <i class="bi bi-people-fill text-primary"></i> Daftar Siswa Terdaftar
        </h2>
        <p class="text-muted mb-0">Kelola dan monitor data siswa yang terdaftar</p>
    </div>
    <div>
        <a href="/panitia/tambah-siswa" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i> Tambah Siswa
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i> <?= session()->getFlashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Filter & Search -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form method="get" class="row g-3 align-items-center">
            <div class="col-md-5">
                <label class="form-label small text-muted mb-1">Pencarian</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama atau nomor pendaftaran...">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted mb-1">Filter Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= $current_status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="submitted" <?= $current_status === 'submitted' ? 'selected' : ''; ?>>Submitted</option>
                    <option value="accepted" <?= $current_status === 'accepted' ? 'selected' : ''; ?>>Diterima</option>
                    <option value="rejected" <?= $current_status === 'rejected' ? 'selected' : ''; ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (!empty($applicants)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <tr>
                            <th class="py-3 px-4 fw-semibold">
                                <i class="bi bi-hash text-primary me-1"></i> No. Pendaftaran
                            </th>
                            <th class="py-3 fw-semibold">
                                <i class="bi bi-person text-primary me-1"></i> Nama Lengkap
                            </th>
                            <th class="py-3 fw-semibold">
                                <i class="bi bi-building text-primary me-1"></i> Asal Sekolah
                            </th>
                            <th class="py-3 fw-semibold">
                                <i class="bi bi-flag text-primary me-1"></i> Status
                            </th>
                            <th class="py-3 fw-semibold">
                                <i class="bi bi-calendar text-primary me-1"></i> Tanggal Daftar
                            </th>
                            <th class="py-3 fw-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applicants as $applicant): ?>
                            <tr class="border-bottom">
                                <td class="px-4">
                                    <span class="badge bg-light text-dark border" style="font-family: monospace;">
                                        <?= $applicant['nomor_pendaftaran'] ?? 'N/A'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </div>
                                        <strong><?= htmlspecialchars($applicant['nama_lengkap']); ?></strong>
                                    </div>
                                </td>
                                <td class="text-muted"><?= htmlspecialchars($applicant['asal_sekolah']); ?></td>
                                <td>
                                    <?php 
                                    $status_config = [
                                        'pending' => ['label' => 'Pending', 'class' => 'bg-secondary', 'icon' => 'clock'],
                                        'submitted' => ['label' => 'Submitted', 'class' => 'bg-info', 'icon' => 'send'],
                                        'accepted' => ['label' => 'Diterima', 'class' => 'bg-success', 'icon' => 'check-circle'],
                                        'rejected' => ['label' => 'Ditolak', 'class' => 'bg-danger', 'icon' => 'x-circle'],
                                    ];
                                    $status = $applicant['status'] ?? '';
                                    $config = $status_config[$status] ?? ['label' => $status, 'class' => 'bg-secondary', 'icon' => 'question'];
                                    ?>
                                    <span class="badge <?= $config['class']; ?> px-3 py-2">
                                        <i class="bi bi-<?= $config['icon']; ?> me-1"></i>
                                        <?= $config['label']; ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?= date('d M Y', strtotime($applicant['created_at'])); ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="/panitia/lihat_siswa/<?= $applicant['id']; ?>" class="btn btn-outline-primary" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="/panitia/edit_siswa/<?= $applicant['id']; ?>" class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="/panitia/hapus_siswa/<?= $applicant['id']; ?>" class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle"></i> Tidak ada siswa terdaftar.
                </div>
            <?php endif; ?>
        </div>
        <?php if (!empty($pager)): ?>
            <div class="card-footer bg-light">
                <?= $pager->links(); ?>
            </div>
        <?php endif; ?>
    </div>

<?= $this->endSection(); ?>
