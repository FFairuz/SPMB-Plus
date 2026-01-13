<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="fas fa-list me-2"></i><?= esc($title) ?></h2>
                <div>
                    <a href="<?= base_url('sales/buku-tamu') ?>" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Tambah Data
                    </a>
                    <a href="<?= base_url('sales/export-buku-tamu') ?>" class="btn btn-info">
                        <i class="fas fa-download me-2"></i>Export CSV
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Total Data: <strong><?= $total ?></strong></h5>
                </div>
                <div class="card-body p-0">
                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (count($guestBooks) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Nama</th>
                                        <th>Asal Sekolah</th>
                                        <th>Kota</th>
                                        <th style="width: 12%">No HP</th>
                                        <th>Sumber Info</th>
                                        <th style="width: 15%">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($guestBooks as $i => $guest): ?>
                                        <tr>
                                            <td><?= ($pager->getDetails()['currentPage'] - 1) * $pager->getDetails()['perPage'] + $i + 1 ?></td>
                                            <td><strong><?= esc($guest['nama']) ?></strong></td>
                                            <td><?= esc($guest['asal_sekolah'] ?? 'N/A') ?></td>
                                            <td><?= esc($guest['kota'] ?? '-') ?></td>
                                            <td><?= esc($guest['no_hp']) ?></td>
                                            <td>
                                                <span class="badge bg-info"><?= esc($guest['sumber_info']) ?></span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d M Y H:i', strtotime($guest['created_at'])) ?>
                                                </small>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation" class="mt-3">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                <small class="text-muted">
                                    Menampilkan <?= $pager->getDetails()['from'] ?? 1 ?> hingga <?= $pager->getDetails()['to'] ?? count($guestBooks) ?> dari <?= $total ?> data
                                </small>
                                <?= $pager->links() ?>
                            </div>
                        </nav>
                    <?php else: ?>
                        <div class="alert alert-info m-3" role="alert">
                            <i class="fas fa-info-circle me-2"></i>Belum ada data buku tamu. <a href="<?= base_url('sales/buku-tamu') ?>">Tambah data sekarang</a>
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

    .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
    }

    .card {
        border-radius: 8px;
        border: none;
    }

    .card-header {
        border-radius: 8px 8px 0 0;
    }
</style>
<?= $this->endSection() ?>
