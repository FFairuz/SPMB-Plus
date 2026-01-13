<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Kelola Konten Sales<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1 fw-bold">Kelola Konten Sales</h3>
        <p class="text-muted mb-0">Kelola video, brosur, dan informasi biaya untuk Sales</p>
    </div>
    <a href="<?= base_url('admin/sales-content/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Konten
    </a>
</div>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Content Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3" style="width: 5%;">#</th>
                        <th class="py-3" style="width: 12%;">Tipe</th>
                        <th class="py-3" style="width: 25%;">Judul</th>
                        <th class="py-3" style="width: 20%;">Deskripsi</th>
                        <th class="py-3" style="width: 15%;">Detail</th>
                        <th class="py-3 text-center" style="width: 8%;">Urutan</th>
                        <th class="py-3 text-center" style="width: 8%;">Status</th>
                        <th class="py-3 text-center" style="width: 12%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($contents)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    <p class="mb-0">Belum ada konten. Klik tombol "Tambah Konten" untuk membuat konten baru.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $no = 1; 
                        $typeBadges = [
                            'video' => '<span class="badge bg-danger"><i class="bi bi-play-circle me-1"></i>Video</span>',
                            'brochure' => '<span class="badge bg-info"><i class="bi bi-file-pdf me-1"></i>Brosur</span>',
                            'fee_info' => '<span class="badge bg-success"><i class="bi bi-cash-coin me-1"></i>Info Biaya</span>',
                            'other' => '<span class="badge bg-secondary"><i class="bi bi-three-dots me-1"></i>Lainnya</span>'
                        ];
                        foreach ($contents as $content): 
                        ?>
                            <tr>
                                <td class="px-4 py-3 align-middle"><?= $no++ ?></td>
                                <td class="py-3 align-middle">
                                    <?= $typeBadges[$content['type']] ?? $typeBadges['other'] ?>
                                </td>
                                <td class="py-3 align-middle">
                                    <strong><?= esc($content['title']) ?></strong>
                                </td>
                                <td class="py-3 align-middle">
                                    <small class="text-muted">
                                        <?= esc(substr($content['description'] ?? '-', 0, 100)) ?>
                                        <?= strlen($content['description'] ?? '') > 100 ? '...' : '' ?>
                                    </small>
                                </td>
                                <td class="py-3 align-middle">
                                    <?php if ($content['type'] == 'video' && $content['video_url']): ?>
                                        <a href="<?= esc($content['video_url']) ?>" target="_blank" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-play-circle me-1"></i>Lihat Video
                                        </a>
                                    <?php elseif ($content['type'] == 'brochure' && $content['file_path']): ?>
                                        <a href="<?= base_url('writable/uploads/sales/' . $content['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-file-pdf me-1"></i>Lihat File
                                        </a>
                                    <?php elseif ($content['type'] == 'fee_info' && $content['fee_amount']): ?>
                                        <div class="text-success fw-semibold">
                                            Rp <?= number_format($content['fee_amount'], 0, ',', '.') ?>
                                        </div>
                                        <?php if ($content['fee_category']): ?>
                                            <small class="text-muted"><?= esc($content['fee_category']) ?></small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 align-middle text-center">
                                    <span class="badge bg-secondary"><?= $content['display_order'] ?></span>
                                </td>
                                <td class="py-3 align-middle text-center">
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               <?= $content['is_active'] == 1 ? 'checked' : '' ?>
                                               onchange="toggleStatus(<?= $content['id'] ?>)"
                                               style="cursor: pointer;">
                                    </div>
                                </td>
                                <td class="py-3 align-middle text-center">
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/sales-content/edit/' . $content['id']) ?>" 
                                           class="btn btn-sm btn-warning"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger"
                                                onclick="confirmDelete(<?= $content['id'] ?>)"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus konten sales ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
function toggleStatus(id) {
    fetch(`<?= base_url('admin/sales-content/toggle-status/') ?>${id}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
            alert.style.zIndex = '9999';
            alert.innerHTML = `
                <i class="bi bi-check-circle me-2"></i>
                ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 3000);
        } else {
            alert('Gagal mengubah status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function confirmDelete(id) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `<?= base_url('admin/sales-content/delete/') ?>${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
<?= $this->endSection(); ?>
