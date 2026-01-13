<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Edit Konten Sales<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1 fw-bold">Edit Konten Sales</h3>
        <p class="text-muted mb-0">Perbarui konten untuk Sales</p>
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
        <form action="<?= base_url('admin/sales-content/update/' . $content['id']) ?>" method="POST" enctype="multipart/form-data" id="salesContentForm">
            <?= csrf_field() ?>
            
            <div class="row">
                <!-- Type -->
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label fw-semibold">Tipe Konten <span class="text-danger">*</span></label>
                    <select class="form-select" id="type" name="type" required onchange="toggleFields()">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="video" <?= old('type', $content['type']) == 'video' ? 'selected' : '' ?>>Video</option>
                        <option value="brochure" <?= old('type', $content['type']) == 'brochure' ? 'selected' : '' ?>>Brosur/Dokumen</option>
                        <option value="fee_info" <?= old('type', $content['type']) == 'fee_info' ? 'selected' : '' ?>>Informasi Biaya</option>
                        <option value="other" <?= old('type', $content['type']) == 'other' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>

                <!-- Display Order -->
                <div class="col-md-6 mb-3">
                    <label for="display_order" class="form-label fw-semibold">Urutan Tampilan</label>
                    <input type="number" class="form-control" id="display_order" name="display_order" 
                           value="<?= old('display_order', $content['display_order']) ?>" min="0">
                </div>

                <!-- Title -->
                <div class="col-12 mb-3">
                    <label for="title" class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="<?= old('title', $content['title']) ?>" required maxlength="255">
                </div>

                <!-- Description -->
                <div class="col-12 mb-3">
                    <label for="description" class="form-label fw-semibold">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?= old('description', $content['description']) ?></textarea>
                </div>

                <!-- Video URL -->
                <div class="col-12 mb-3" id="videoUrlField" style="display: none;">
                    <label for="video_url" class="form-label fw-semibold">URL Video</label>
                    <input type="url" class="form-control" id="video_url" name="video_url" 
                           value="<?= old('video_url', $content['video_url']) ?>" maxlength="500"
                           placeholder="https://www.youtube.com/watch?v=xxxxx">
                    <small class="text-muted">Masukkan link YouTube atau Vimeo</small>
                    <?php if ($content['video_url']): ?>
                        <div class="mt-2">
                            <a href="<?= esc($content['video_url']) ?>" target="_blank" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-play-circle me-1"></i>Lihat Video Saat Ini
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- File Upload -->
                <div class="col-12 mb-3" id="fileUploadField" style="display: none;">
                    <?php if ($content['file_path']): ?>
                        <label class="form-label fw-semibold">File Saat Ini</label>
                        <div class="mb-2">
                            <a href="<?= base_url('writable/uploads/sales/' . $content['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-file-pdf me-1"></i>Lihat File Saat Ini
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <label for="file" class="form-label fw-semibold">Upload File Baru</label>
                    <input type="file" class="form-control" id="file" name="file" 
                           accept="application/pdf,image/jpeg,image/jpg,image/png"
                           onchange="previewFile(event)">
                    <small class="text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 5MB. Kosongkan jika tidak ingin mengubah file</small>
                    
                    <div id="filePreview" class="mt-3" style="display: none;">
                        <p class="fw-semibold mb-2">File yang dipilih:</p>
                        <div id="fileName" class="alert alert-info"></div>
                    </div>
                </div>

                <!-- Fee Info Fields -->
                <div id="feeInfoFields" style="display: none;">
                    <div class="col-md-6 mb-3">
                        <label for="fee_category" class="form-label fw-semibold">Kategori Biaya</label>
                        <select class="form-select" id="fee_category" name="fee_category">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Pendaftaran" <?= old('fee_category', $content['fee_category']) == 'Pendaftaran' ? 'selected' : '' ?>>Pendaftaran</option>
                            <option value="SPP" <?= old('fee_category', $content['fee_category']) == 'SPP' ? 'selected' : '' ?>>SPP</option>
                            <option value="Seragam" <?= old('fee_category', $content['fee_category']) == 'Seragam' ? 'selected' : '' ?>>Seragam</option>
                            <option value="Buku" <?= old('fee_category', $content['fee_category']) == 'Buku' ? 'selected' : '' ?>>Buku</option>
                            <option value="Lainnya" <?= old('fee_category', $content['fee_category']) == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="fee_amount" class="form-label fw-semibold">Jumlah Biaya</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control" id="fee_amount" name="fee_amount" 
                                   value="<?= old('fee_amount') ? old('fee_amount') : ($content['fee_amount'] ? number_format($content['fee_amount'], 0, ',', '.') : '') ?>"
                                   placeholder="0"
                                   onkeyup="formatCurrency(this)">
                        </div>
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
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 justify-content-end">
                <a href="<?= base_url('admin/sales-content') ?>" class="btn btn-secondary">
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
function toggleFields() {
    const type = document.getElementById('type').value;
    const videoUrlField = document.getElementById('videoUrlField');
    const fileUploadField = document.getElementById('fileUploadField');
    const feeInfoFields = document.getElementById('feeInfoFields');
    
    videoUrlField.style.display = 'none';
    fileUploadField.style.display = 'none';
    feeInfoFields.style.display = 'none';
    
    if (type === 'video') {
        videoUrlField.style.display = 'block';
    } else if (type === 'brochure') {
        fileUploadField.style.display = 'block';
    } else if (type === 'fee_info') {
        feeInfoFields.style.display = 'contents';
    }
}

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

function formatCurrency(input) {
    let value = input.value.replace(/\D/g, '');
    input.value = new Intl.NumberFormat('id-ID').format(value);
}

document.addEventListener('DOMContentLoaded', function() {
    toggleFields();
});
</script>
<?= $this->endSection(); ?>
