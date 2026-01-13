<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Edit Konten Home<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1 fw-bold">Edit Konten Home</h3>
        <p class="text-muted mb-0">Perbarui konten untuk halaman home</p>
    </div>
    <a href="<?= base_url('admin/content-management') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-2">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="<?= base_url('admin/content-management/update/' . $content['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <!-- Section -->
                <div class="col-md-6 mb-3">
                    <label for="section" class="form-label fw-semibold">Section <span class="text-danger">*</span></label>
                    <select class="form-select" id="section" name="section" required>
                        <option value="">-- Pilih Section --</option>
                        <option value="hero" <?= old('section', $content['section']) == 'hero' ? 'selected' : '' ?>>Hero Banner</option>
                        <option value="about" <?= old('section', $content['section']) == 'about' ? 'selected' : '' ?>>Tentang Kami</option>
                        <option value="features" <?= old('section', $content['section']) == 'features' ? 'selected' : '' ?>>Fitur/Keunggulan</option>
                        <option value="testimonials" <?= old('section', $content['section']) == 'testimonials' ? 'selected' : '' ?>>Testimoni</option>
                        <option value="gallery" <?= old('section', $content['section']) == 'gallery' ? 'selected' : '' ?>>Galeri</option>
                        <option value="contact" <?= old('section', $content['section']) == 'contact' ? 'selected' : '' ?>>Kontak</option>
                        <option value="other" <?= old('section', $content['section']) == 'other' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                    <small class="text-muted">Pilih bagian mana konten ini akan ditampilkan</small>
                </div>

                <!-- Display Order -->
                <div class="col-md-6 mb-3">
                    <label for="display_order" class="form-label fw-semibold">Urutan Tampilan</label>
                    <input type="number" class="form-control" id="display_order" name="display_order" 
                           value="<?= old('display_order', $content['display_order']) ?>" min="0">
                    <small class="text-muted">Urutan tampilan konten (semakin kecil, semakin awal ditampilkan)</small>
                </div>

                <!-- Title -->
                <div class="col-12 mb-3">
                    <label for="title" class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="<?= old('title', $content['title']) ?>" required maxlength="255"
                           placeholder="Masukkan judul konten">
                </div>

                <!-- Subtitle -->
                <div class="col-12 mb-3">
                    <label for="subtitle" class="form-label fw-semibold">Subjudul</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" 
                           value="<?= old('subtitle', $content['subtitle']) ?>" maxlength="255"
                           placeholder="Masukkan subjudul (opsional)">
                </div>

                <!-- Content -->
                <div class="col-12 mb-3">
                    <label for="content" class="form-label fw-semibold">Konten/Deskripsi</label>
                    <textarea class="form-control" id="content" name="content" rows="5"
                              placeholder="Masukkan deskripsi atau konten detail"><?= old('content', $content['content']) ?></textarea>
                    <small class="text-muted">Deskripsi lengkap konten (opsional)</small>
                </div>

                <!-- Button Text -->
                <div class="col-md-6 mb-3">
                    <label for="button_text" class="form-label fw-semibold">Teks Tombol</label>
                    <input type="text" class="form-control" id="button_text" name="button_text" 
                           value="<?= old('button_text', $content['button_text']) ?>" maxlength="100"
                           placeholder="Contoh: Daftar Sekarang">
                    <small class="text-muted">Teks untuk tombol call-to-action (opsional)</small>
                </div>

                <!-- Button Link -->
                <div class="col-md-6 mb-3">
                    <label for="button_link" class="form-label fw-semibold">Link Tombol</label>
                    <input type="text" class="form-control" id="button_link" name="button_link" 
                           value="<?= old('button_link', $content['button_link']) ?>" maxlength="255"
                           placeholder="Contoh: /register atau https://example.com">
                    <small class="text-muted">URL tujuan tombol (opsional)</small>
                </div>

                <!-- Current Image -->
                <?php if ($content['image']): ?>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Gambar Saat Ini</label>
                        <div>
                            <img src="<?= base_url('writable/uploads/content/' . $content['image']) ?>" 
                                 alt="<?= esc($content['title']) ?>" 
                                 class="img-thumbnail"
                                 style="max-width: 300px;">
                        </div>
                        <small class="text-muted">Upload gambar baru untuk mengganti gambar saat ini</small>
                    </div>
                <?php endif; ?>

                <!-- Image Upload -->
                <div class="col-12 mb-3">
                    <label for="image" class="form-label fw-semibold">Gambar Baru</label>
                    <input type="file" class="form-control" id="image" name="image" 
                           accept="image/jpeg,image/jpg,image/png"
                           onchange="previewImage(event)">
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar</small>
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-3" style="display: none;">
                        <p class="fw-semibold mb-2">Preview Gambar Baru:</p>
                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                    </div>
                </div>

                <!-- Status -->
                <div class="col-12 mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                               value="1" <?= old('is_active', $content['is_active']) == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold" for="is_active">
                            Aktifkan konten ini
                        </label>
                        <small class="d-block text-muted">Konten hanya akan ditampilkan jika diaktifkan</small>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 justify-content-end">
                <a href="<?= base_url('admin/content-management') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Perbarui Konten
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}
</script>
<?= $this->endSection(); ?>
