<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="fas fa-school me-2"></i><?= esc($title) ?></h2>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('admin/schools/import-excel') ?>" class="btn btn-info">
                        <i class="fas fa-file-excel me-2"></i>Import Excel
                    </a>
                    <a href="<?= base_url('admin/schools/add') ?>" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Tambah Sekolah
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="keyword" class="form-control" placeholder="Cari nama sekolah, kota, atau NPSN..." 
                       value="<?= esc($keyword) ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
                <?php if ($keyword): ?>
                    <a href="<?= base_url('admin/schools') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Bersihkan
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Total Sekolah: <strong><?= $total ?></strong></h5>
                </div>
                <div class="card-body p-0">
                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (count($schools) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Nama Sekolah</th>
                                        <th style="width: 12%">NPSN</th>
                                        <th>Kota</th>
                                        <th>Provinsi</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($schools as $i => $school): ?>
                                        <tr>
                                            <td><?= ($pager && isset($pager) ? ($pager->getDetails()['currentPage'] - 1) * $pager->getDetails()['perPage'] + $i + 1 : $i + 1) ?></td>
                                            <td><strong><?= esc($school['nama']) ?></strong></td>
                                            <td>
                                                <?php if ($school['npsn']): ?>
                                                    <span class="badge bg-info"><?= esc($school['npsn']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($school['kota']) ?></td>
                                            <td><?= esc($school['provinsi']) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/schools/edit/' . $school['id']) ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/schools/delete/' . $school['id']) ?>" class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Yakin ingin menghapus sekolah ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($pager): ?>
                            <nav aria-label="Page navigation" class="mt-3">
                                <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                    <small class="text-muted">
                                        Menampilkan <?= $pager->getDetails()['from'] ?? 1 ?> hingga <?= $pager->getDetails()['to'] ?? count($schools) ?> dari <?= $total ?> sekolah
                                    </small>
                                    <?= $pager->links() ?>
                                </div>
                            </nav>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-info m-3" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <?php if ($keyword): ?>
                                Tidak ada sekolah yang ditemukan untuk pencarian "<?= esc($keyword) ?>". 
                                <a href="<?= base_url('admin/schools/add') ?>">Tambah sekolah baru</a>
                            <?php else: ?>
                                Belum ada data sekolah. <a href="<?= base_url('admin/schools/add') ?>">Tambah sekolah sekarang</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .card {
        border-radius: 8px;
        border: none;
    }

    .card-header {
        border-radius: 8px 8px 0 0;
    }

    .btn {
        border-radius: 6px;
    }
</style>
<?= $this->endSection() ?>
