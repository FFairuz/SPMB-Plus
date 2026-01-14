<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Kelola Jurusan<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-diagram-3"></i> Kelola Jurusan
    </h2>
    <a href="/admin/majors/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Jurusan
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

<!-- Tabel Jurusan -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php if (empty($majors)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Belum ada data jurusan. <a href="/admin/majors/create">Tambah jurusan baru</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Kode</th>
                            <th width="25%">Nama Jurusan</th>
                            <th width="20%">Deskripsi</th>
                            <th width="10%" class="text-center">Kuota</th>
                            <th width="10%" class="text-center">Pendaftar</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($majors as $major): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><strong><?= esc($major['kode_jurusan']); ?></strong></td>
                                <td><?= esc($major['nama_jurusan']); ?></td>
                                <td>
                                    <?php if ($major['deskripsi']): ?>
                                        <?= esc(substr($major['deskripsi'], 0, 50)); ?>...
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($major['kuota']): ?>
                                        <span class="badge bg-info"><?= $major['kuota']; ?> siswa</span>
                                    <?php else: ?>
                                        <span class="text-muted">Tidak dibatasi</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary"><?= $major['total_applicants']; ?> siswa</span>
                                </td>
                                <td class="text-center">
                                    <?php if ($major['status'] === 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/admin/majors/edit/<?= $major['id']; ?>" 
                                           class="btn btn-outline-primary" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger"
                                                onclick="confirmDelete(<?= $major['id']; ?>, '<?= esc($major['nama_jurusan']); ?>')"
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

<!-- Delete Confirmation Modal -->
<form id="deleteForm" method="post" style="display: none;">
    <input type="hidden" name="_method" value="DELETE">
</form>

<script>
function confirmDelete(id, nama) {
    if (confirm(`Apakah Anda yakin ingin menghapus jurusan "${nama}"?\n\nPeringatan: Jurusan tidak dapat dihapus jika masih ada pendaftar yang menggunakan jurusan ini.`)) {
        window.location.href = `/admin/majors/delete/${id}`;
    }
}
</script>

<?= $this->endSection(); ?>
