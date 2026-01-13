<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Kelola Akun<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 fw-bold">
            <i class="bi bi-people-fill text-primary"></i> Kelola Akun User
        </h2>
        <p class="text-muted mb-0">Total <strong><?= count($users) ?> user</strong> terdaftar di sistem</p>
    </div>
    <div>
        <a href="<?= base_url('admin/tambah-akun') ?>" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i>Tambah User
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <tr>
                        <th class="py-3 px-4" width="50">#</th>
                        <th class="py-3 fw-semibold">
                            <i class="bi bi-person text-primary me-1"></i>Username
                        </th>
                        <th class="py-3 fw-semibold">
                            <i class="bi bi-envelope text-primary me-1"></i>Email
                        </th>
                        <th class="py-3 fw-semibold">
                            <i class="bi bi-card-text text-primary me-1"></i>Nama
                        </th>
                        <th class="py-3 fw-semibold">
                            <i class="bi bi-shield-check text-primary me-1"></i>Role
                        </th>
                        <th class="py-3 fw-semibold">
                            <i class="bi bi-flag text-primary me-1"></i>Status
                        </th>
                        <th class="py-3 fw-semibold">
                            <i class="bi bi-calendar text-primary me-1"></i>Terdaftar
                        </th>
                        <th class="py-3 fw-semibold text-center" width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div style="opacity: 0.3;">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
                                </div>
                                <p class="text-muted mt-3 mb-0">Tidak ada user terdaftar</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = ($current_page - 1) * $per_page + 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr class="border-bottom">
                                <td class="px-4">
                                    <span class="badge bg-light text-dark border"><?= $no++ ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </div>
                                        <strong><?= htmlspecialchars($user['username']) ?></strong>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
                                </td>
                                <td><?= htmlspecialchars($user['nama']) ?></td>
                                <td>
                                    <?php
                                    $roleColors = [
                                        'admin' => 'danger',
                                        'panitia' => 'info',
                                        'bendahara' => 'success',
                                        'applicant' => 'secondary',
                                    ];
                                    $roleColor = $roleColors[$user['role']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $roleColor ?> text-uppercase">
                                        <?= $user['role'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['is_active']): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times-circle me-1"></i>Nonaktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d M Y', strtotime($user['created_at'])) ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/edit-akun/' . $user['id']) ?>" 
                                       class="btn btn-sm btn-warning" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if (session()->get('user_id') != $user['id']): ?>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete(<?= $user['id'] ?>, '<?= htmlspecialchars($user['username']) ?>')"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <?php if ($pager): ?>
        <div class="d-flex justify-content-center mt-4">
            <?= $pager->links('default', 'default_full') ?>
        </div>
    <?php endif; ?>
</div>

<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus user <strong id="deleteUsername"></strong>?</p>
                <p class="text-danger small">
                    <i class="fas fa-info-circle me-2"></i>Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a id="deleteLink" href="#" class="btn btn-danger">Hapus User</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(userId, username) {
    document.getElementById('deleteUsername').textContent = username;
    document.getElementById('deleteLink').href = '<?= base_url('admin/hapus-akun/') ?>' + userId;
    new bootstrap.Modal(document.getElementById('confirmDeleteModal')).show();
}
</script>

<?= $this->endSection() ?>
