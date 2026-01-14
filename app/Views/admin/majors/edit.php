<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Edit Jurusan<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<h2 class="mb-3">
    <i class="bi bi-pencil-square"></i> Edit Jurusan
</h2>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i> <?= session()->getFlashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Form -->
<form method="post" action="/admin/majors/edit/<?= $major['id']; ?>" class="card border-0 shadow-sm p-4">
    <?= csrf_field(); ?>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label fw-bold">Kode Jurusan *</label>
            <input type="text" name="kode_jurusan" 
                   class="form-control <?= $validation && $validation->hasError('kode_jurusan') ? 'is-invalid' : ''; ?>" 
                   placeholder="Contoh: TKJ, RPL, AKL" 
                   value="<?= old('kode_jurusan', $major['kode_jurusan']); ?>" 
                   style="text-transform: uppercase;"
                   required>
            <?php if ($validation && $validation->hasError('kode_jurusan')): ?>
                <div class="invalid-feedback d-block">
                    <?= $validation->getError('kode_jurusan'); ?>
                </div>
            <?php endif; ?>
            <small class="text-muted">Kode singkat untuk jurusan (akan diubah ke huruf besar)</small>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold">Status *</label>
            <select name="status" class="form-select <?= $validation && $validation->hasError('status') ? 'is-invalid' : ''; ?>" required>
                <option value="aktif" <?= old('status', $major['status']) === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                <option value="nonaktif" <?= old('status', $major['status']) === 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
            <?php if ($validation && $validation->hasError('status')): ?>
                <div class="invalid-feedback d-block">
                    <?= $validation->getError('status'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Nama Jurusan *</label>
        <input type="text" name="nama_jurusan" 
               class="form-control <?= $validation && $validation->hasError('nama_jurusan') ? 'is-invalid' : ''; ?>" 
               placeholder="Contoh: Teknik Komputer dan Jaringan" 
               value="<?= old('nama_jurusan', $major['nama_jurusan']); ?>" 
               required>
        <?php if ($validation && $validation->hasError('nama_jurusan')): ?>
            <div class="invalid-feedback d-block">
                <?= $validation->getError('nama_jurusan'); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Deskripsi</label>
        <textarea name="deskripsi" 
                  class="form-control <?= $validation && $validation->hasError('deskripsi') ? 'is-invalid' : ''; ?>" 
                  rows="4" 
                  placeholder="Deskripsi singkat tentang jurusan ini"><?= old('deskripsi', $major['deskripsi']); ?></textarea>
        <?php if ($validation && $validation->hasError('deskripsi')): ?>
            <div class="invalid-feedback d-block">
                <?= $validation->getError('deskripsi'); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Kuota Siswa</label>
        <input type="number" name="kuota" 
               class="form-control <?= $validation && $validation->hasError('kuota') ? 'is-invalid' : ''; ?>" 
               placeholder="Contoh: 36" 
               value="<?= old('kuota', $major['kuota']); ?>" 
               min="1">
        <?php if ($validation && $validation->hasError('kuota')): ?>
            <div class="invalid-feedback d-block">
                <?= $validation->getError('kuota'); ?>
            </div>
        <?php endif; ?>
        <small class="text-muted">Kosongkan jika tidak ada batasan kuota</small>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-lg me-2">
                <i class="bi bi-check-circle"></i> Update Jurusan
            </button>
            <a href="/admin/majors" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </div>
</form>

<?= $this->endSection(); ?>
