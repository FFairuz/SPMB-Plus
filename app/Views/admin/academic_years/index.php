<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Kelola Tahun Ajaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-calendar-range"></i> Kelola Tahun Ajaran
    </h2>
    <a href="/admin/academic-years/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Tahun Ajaran
    </a>
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

<!-- Tabel Tahun Ajaran -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($years)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Belum ada data tahun ajaran. <a href="/admin/academic-years/create">Tambah tahun ajaran baru</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Tahun Ajaran</th>
                            <th width="15%">Periode</th>
                            <th width="15%">Tanggal Mulai</th>
                            <th width="15%">Tanggal Selesai</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="10%" class="text-center">Aktif</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($years as $year): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <strong><?= esc($year['tahun_ajaran']); ?></strong>
                                    <?php if ($year['is_active']): ?>
                                        <br><span class="badge bg-success"><i class="bi bi-star-fill"></i> Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($year['tahun_mulai']); ?> - <?= esc($year['tahun_selesai']); ?></td>
                                <td><?= $year['tanggal_mulai'] ? date('d M Y', strtotime($year['tanggal_mulai'])) : '-'; ?></td>
                                <td><?= $year['tanggal_selesai'] ? date('d M Y', strtotime($year['tanggal_selesai'])) : '-'; ?></td>
                                <td class="text-center">
                                    <?php if ($year['status'] === 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php elseif ($year['status'] === 'selesai'): ?>
                                        <span class="badge bg-secondary">Selesai</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($year['is_active']): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Ya</span>
                                    <?php else: ?>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary" 
                                                onclick="setActive(<?= $year['id']; ?>)"
                                                title="Aktifkan">
                                            <i class="bi bi-star"></i> Aktifkan
                                        </button>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="/admin/academic-years/edit/<?= $year['id']; ?>" 
                                           class="btn btn-sm btn-warning" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if (!$year['is_active']): ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="confirmDelete(<?= $year['id']; ?>)"
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

<!-- Form untuk delete dan set active (hidden) -->
<form id="actionForm" method="post" style="display: none;">
    <?= csrf_field(); ?>
</form>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus tahun ajaran ini?')) {
        const form = document.getElementById('actionForm');
        form.action = '/admin/academic-years/delete/' + id;
        form.submit();
    }
}

function setActive(id) {
    if (confirm('Aktifkan tahun ajaran ini? Tahun ajaran lain akan dinonaktifkan.')) {
        const form = document.getElementById('actionForm');
        form.action = '/admin/academic-years/set-active/' + id;
        form.submit();
    }
}
</script>

<?= $this->endSection(); ?>
