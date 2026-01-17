<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Kelola Kuota Jurusan<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-pie-chart"></i> Kelola Kuota Jurusan
    </h2>
    <div>
        <a href="/admin/quotas/statistics" class="btn btn-info me-2">
            <i class="bi bi-bar-chart"></i> Statistik
        </a>
        <a href="/admin/quotas/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kuota
        </a>
    </div>
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

<!-- Filter Tahun Ajaran -->
<?php if (!empty($availableYears)): ?>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="get" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Filter Tahun Ajaran</label>
                <select name="tahun_ajaran" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Tahun Ajaran --</option>
                    <?php foreach ($availableYears as $year): ?>
                        <option value="<?= esc($year) ?>" <?= ($selectedYear == $year) ? 'selected' : '' ?>>
                            <?= esc($year) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Tabel Kuota -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($quotas)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Belum ada data kuota jurusan. <a href="/admin/quotas/create">Tambah kuota baru</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Jurusan</th>
                            <th width="10%">Tahun Ajaran</th>
                            <th width="8%" class="text-center">Total Kuota</th>
                            <th width="8%" class="text-center">Terisi</th>
                            <th width="8%" class="text-center">Sisa</th>
                            <th width="8%" class="text-center">Reguler</th>
                            <th width="8%" class="text-center">Prestasi</th>
                            <th width="8%" class="text-center">Afirmasi</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="12%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($quotas as $quota): ?>
                            <?php 
                                $sisa = $quota['kuota_total'] - $quota['kuota_terisi'];
                                $persentase = $quota['kuota_total'] > 0 ? ($quota['kuota_terisi'] / $quota['kuota_total'] * 100) : 0;
                                
                                // Tentukan warna progress bar
                                if ($persentase >= 90) {
                                    $progressColor = 'bg-danger';
                                } elseif ($persentase >= 70) {
                                    $progressColor = 'bg-warning';
                                } else {
                                    $progressColor = 'bg-success';
                                }
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <strong><?= esc($quota['nama_jurusan']); ?></strong><br>
                                    <small class="text-muted"><?= esc($quota['kode_jurusan']); ?></small>
                                </td>
                                <td><span class="badge bg-primary"><?= esc($quota['tahun_ajaran']); ?></span></td>
                                <td class="text-center">
                                    <strong><?= number_format($quota['kuota_total']); ?></strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info"><?= number_format($quota['kuota_terisi']); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary"><?= number_format($sisa); ?></span>
                                </td>
                                <td class="text-center"><?= number_format($quota['jalur_reguler']); ?></td>
                                <td class="text-center"><?= number_format($quota['jalur_prestasi']); ?></td>
                                <td class="text-center"><?= number_format($quota['jalur_afirmasi']); ?></td>
                                <td class="text-center">
                                    <?php if ($quota['status'] === 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                    
                                    <!-- Progress Bar Mini -->
                                    <div class="progress mt-1" style="height: 5px;">
                                        <div class="progress-bar <?= $progressColor ?>" 
                                             role="progressbar" 
                                             style="width: <?= $persentase ?>%"
                                             aria-valuenow="<?= $persentase ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <small class="text-muted"><?= number_format($persentase, 1) ?>%</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="/admin/quotas/edit/<?= $quota['id']; ?>" 
                                           class="btn btn-sm btn-warning" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($quota['kuota_terisi'] > 0): ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-secondary" 
                                                    onclick="confirmReset(<?= $quota['id']; ?>)"
                                                    title="Reset Kuota Terisi">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                        <?php else: ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="confirmDelete(<?= $quota['id']; ?>)"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Form untuk delete (hidden) -->
<form id="deleteForm" method="post" style="display: none;">
    <?= csrf_field(); ?>
</form>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus kuota ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = '/admin/quotas/delete/' + id;
        form.submit();
    }
}

function confirmReset(id) {
    if (confirm('Apakah Anda yakin ingin mereset kuota terisi ke 0? Data pendaftar tidak akan dihapus.')) {
        const form = document.getElementById('deleteForm');
        form.action = '/admin/quotas/reset/' + id;
        form.submit();
    }
}
</script>

<?= $this->endSection(); ?>
