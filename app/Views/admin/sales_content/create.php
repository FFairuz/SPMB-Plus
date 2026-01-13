<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Tambah Konten Sales<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1 fw-bold">Tambah Konten Sales</h3>
        <p class="text-muted mb-0">Buat konten baru untuk Sales (Video, Brosur, Info Biaya)</p>
    </div>
    <a href="<?= base_url('admin/sales-content') ?>" class="btn btn-secondary">
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
        <form action="<?= base_url('admin/sales-content/store') ?>" method="POST" enctype="multipart/form-data" id="salesContentForm">
            <?= csrf_field() ?>
            
            <div class="row">
                <!-- Type -->
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label fw-semibold">Tipe Konten <span class="text-danger">*</span></label>
                    <select class="form-select" id="type" name="type" required onchange="toggleFields()">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="video" <?= old('type') == 'video' ? 'selected' : '' ?>>Video</option>
                        <option value="brochure" <?= old('type') == 'brochure' ? 'selected' : '' ?>>Brosur/Dokumen</option>
                        <option value="fee_info" <?= old('type') == 'fee_info' ? 'selected' : '' ?>>Informasi Biaya</option>
                        <option value="other" <?= old('type') == 'other' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                    <small class="text-muted">Pilih jenis konten yang akan dibuat</small>
                </div>

                <!-- Display Order -->
                <div class="col-md-6 mb-3">
                    <label for="display_order" class="form-label fw-semibold">Urutan Tampilan</label>
                    <input type="number" class="form-control" id="display_order" name="display_order" 
                           value="<?= old('display_order', 0) ?>" min="0">
                    <small class="text-muted">Urutan tampilan (semakin kecil, semakin awal)</small>
                </div>

                <!-- Title -->
                <div class="col-12 mb-3">
                    <label for="title" class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="<?= old('title') ?>" required maxlength="255"
                           placeholder="Contoh: Video Profil Sekolah 2025">
                </div>

                <!-- Description -->
                <div class="col-12 mb-3">
                    <label for="description" class="form-label fw-semibold">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4"
                              placeholder="Masukkan deskripsi konten"><?= old('description') ?></textarea>
                </div>

                <!-- Video URL (shown for video type) -->
                <div class="col-12 mb-3" id="videoUrlField" style="display: none;">
                    <label for="video_url" class="form-label fw-semibold">URL Video</label>
                    <input type="url" class="form-control" id="video_url" name="video_url" 
                           value="<?= old('video_url') ?>" maxlength="500"
                           placeholder="https://www.youtube.com/watch?v=xxxxx atau https://vimeo.com/xxxxx">
                    <small class="text-muted">Masukkan link YouTube atau Vimeo</small>
                </div>

                <!-- File Upload (shown for brochure type) -->
                <div class="col-12 mb-3" id="fileUploadField" style="display: none;">
                    <label for="file" class="form-label fw-semibold">Upload File</label>
                    <input type="file" class="form-control" id="file" name="file" 
                           accept="application/pdf,image/jpeg,image/jpg,image/png"
                           onchange="previewFile(event)">
                    <small class="text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 5MB</small>
                    
                    <!-- File Preview -->
                    <div id="filePreview" class="mt-3" style="display: none;">
                        <p class="fw-semibold mb-2">File yang dipilih:</p>
                        <div id="fileName" class="alert alert-info"></div>
                    </div>
                </div>

                <!-- Fee Info Fields (shown for fee_info type) -->
                <div id="feeInfoFields" style="display: none;">
                    <div class="col-md-6 mb-3">
                        <label for="fee_category" class="form-label fw-semibold">Kategori Biaya</label>
                        <select class="form-select" id="fee_category" name="fee_category">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Pendaftaran" <?= old('fee_category') == 'Pendaftaran' ? 'selected' : '' ?>>Pendaftaran</option>
                            <option value="SPP" <?= old('fee_category') == 'SPP' ? 'selected' : '' ?>>SPP</option>
                            <option value="Seragam" <?= old('fee_category') == 'Seragam' ? 'selected' : '' ?>>Seragam</option>
                            <option value="Buku" <?= old('fee_category') == 'Buku' ? 'selected' : '' ?>>Buku</option>
                            <option value="Lainnya" <?= old('fee_category') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="fee_amount" class="form-label fw-semibold">Jumlah Biaya</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control" id="fee_amount" name="fee_amount" 
                                   value="<?= old('fee_amount') ?>"
                                   placeholder="0"
                                   onkeyup="formatCurrency(this)">
                        </div>
                        <small class="text-muted">Masukkan nominal biaya</small>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-12 mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                               value="1" <?= old('is_active', 1) == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold" for="is_active">
                            Aktifkan konten ini
                        </label>
                        <small class="d-block text-muted">Konten hanya akan ditampilkan jika diaktifkan</small>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 justify-content-end">
                <a href="<?= base_url('admin/sales-content') ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Simpan Konten
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
// Toggle fields based on content type
function toggleFields() {
    const type = document.getElementById('type').value;
    const videoUrlField = document.getElementById('videoUrlField');
    const fileUploadField = document.getElementById('fileUploadField');
    const feeInfoFields = document.getElementById('feeInfoFields');
    
    // Hide all specific fields
    videoUrlField.style.display = 'none';
    fileUploadField.style.display = 'none';
    feeInfoFields.style.display = 'none';
    
    // Show relevant fields based on type
    if (type === 'video') {
        videoUrlField.style.display = 'block';
    } else if (type === 'brochure') {
        fileUploadField.style.display = 'block';
    } else if (type === 'fee_info') {
        feeInfoFields.style.display = 'contents';
    }
}

// Preview file name
function previewFile(event) {
    const input = event.target;
    const preview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        fileName.textContent = `📄 ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}

// Format currency input
function formatCurrency(input) {
    let value = input.value.replace(/\D/g, '');
    input.value = new Intl.NumberFormat('id-ID').format(value);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleFields();
});
</script>
<?= $this->endSection(); ?>
