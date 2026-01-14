<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Edit Hobi<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<h2 class="mb-3">
    <i class="bi bi-pencil-square"></i> Edit Hobi
</h2>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i> <?= session()->getFlashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Form -->
<form method="post" action="/admin/hobbies/edit/<?= $hobby['id']; ?>" class="card border-0 shadow-sm p-4">
    <?= csrf_field(); ?>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label fw-bold">Nama Hobi *</label>
            <input type="text" name="nama_hobi" 
                   class="form-control <?= $validation && $validation->hasError('nama_hobi') ? 'is-invalid' : ''; ?>" 
                   placeholder="Contoh: Membaca, Olahraga, Musik" 
                   value="<?= old('nama_hobi', $hobby['nama_hobi']); ?>" 
                   required>
            <?php if ($validation && $validation->hasError('nama_hobi')): ?>
                <div class="invalid-feedback d-block">
                    <?= $validation->getError('nama_hobi'); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold">Status *</label>
            <select name="status" class="form-select <?= $validation && $validation->hasError('status') ? 'is-invalid' : ''; ?>" required>
                <option value="aktif" <?= old('status', $hobby['status']) === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                <option value="nonaktif" <?= old('status', $hobby['status']) === 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
            <?php if ($validation && $validation->hasError('status')): ?>
                <div class="invalid-feedback d-block">
                    <?= $validation->getError('status'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Icon Bootstrap</label>
        <input type="text" name="icon" 
               class="form-control <?= $validation && $validation->hasError('icon') ? 'is-invalid' : ''; ?>" 
               placeholder="Contoh: bi-book, bi-music-note, bi-trophy" 
               value="<?= old('icon', $hobby['icon']); ?>">
        <?php if ($validation && $validation->hasError('icon')): ?>
            <div class="invalid-feedback d-block">
                <?= $validation->getError('icon'); ?>
            </div>
        <?php endif; ?>
        <small class="text-muted">
            Opsional. Lihat icon Bootstrap: 
            <a href="https://icons.getbootstrap.com/" target="_blank">https://icons.getbootstrap.com/</a>
        </small>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-lg me-2">
                <i class="bi bi-check-circle"></i> Update Hobi
            </button>
            <a href="/admin/hobbies" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </div>
</form>

<?= $this->endSection(); ?>
