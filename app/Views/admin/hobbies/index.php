<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Kelola Hobi<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-star"></i> Kelola Hobi
    </h2>
    <a href="/admin/hobbies/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Hobi
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

<!-- Tabel Hobi -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($hobbies)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Belum ada data hobi. <a href="/admin/hobbies/create">Tambah hobi baru</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Nama Hobi</th>
                            <th width="15%" class="text-center">Icon</th>
                            <th width="15%" class="text-center">Peminat</th>
                            <th width="15%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($hobbies as $hobby): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><strong><?= esc($hobby['nama_hobi']); ?></strong></td>
                                <td class="text-center">
                                    <?php if ($hobby['icon']): ?>
                                        <i class="bi <?= esc($hobby['icon']); ?> fs-4 text-primary"></i>
                                        <br>
                                        <small class="text-muted"><?= esc($hobby['icon']); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary"><?= $hobby['total_applicants']; ?> siswa</span>
                                </td>
                                <td class="text-center">
                                    <?php if ($hobby['status'] === 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/admin/hobbies/edit/<?= $hobby['id']; ?>" 
                                           class="btn btn-outline-primary" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger"
                                                onclick="confirmDelete(<?= $hobby['id']; ?>, '<?= esc($hobby['nama_hobi']); ?>')"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
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

<script>
function confirmDelete(id, nama) {
    if (confirm(`Apakah Anda yakin ingin menghapus hobi "${nama}"?\n\nPeringatan: Hobi tidak dapat dihapus jika masih ada pendaftar yang menggunakan hobi ini.`)) {
        window.location.href = `/admin/hobbies/delete/${id}`;
    }
}
</script>

<?= $this->endSection(); ?>
