<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Pengaturan Aplikasi<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<style>
    .settings-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .settings-card {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .settings-header {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        color: white;
        padding: 2rem;
        border-radius: 16px 16px 0 0;
    }

    .settings-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: white !important;
    }

    .settings-header h1 i {
        color: white !important;
    }

    .settings-header p {
        opacity: 1;
        margin-bottom: 0;
        font-size: 1rem;
        color: white !important;
    }

    .settings-body {
        padding: 2rem;
    }

    .settings-section {
        margin-bottom: 2.5rem;
    }

    .settings-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: #0d6efd;
        font-size: 1.5rem;
    }

    .logo-preview-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .logo-preview-box:hover {
        border-color: #0d6efd;
        background: linear-gradient(135deg, #e7f1ff 0%, #d0e2ff 100%);
    }

    .logo-preview {
        max-width: 200px;
        max-height: 200px;
        margin: 0 auto 1rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        border: none;
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        transition: all 0.3s ease;
        color: white !important;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
        color: white !important;
    }

    .btn-primary i {
        color: white !important;
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
        color: white !important;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white !important;
    }

    .btn-secondary i {
        color: white !important;
    }

    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .alert i {
        font-size: 1.25rem;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .file-input-wrapper {
        position: relative;
    }

    .file-input-label {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background: #0d6efd;
        color: white !important;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .file-input-label:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        color: white !important;
    }

    .file-input-label i {
        margin-right: 0.5rem;
        color: white !important;
    }

    input[type="file"] {
        display: none;
    }

    .file-name {
        display: inline-block;
        margin-left: 1rem;
        color: #6c757d;
        font-size: 0.9rem;
    }
</style>

<div class="settings-container">
    <!-- Header -->
    <div class="settings-card">
        <div class="settings-header">
            <h1><i class="bi bi-gear-fill"></i>Pengaturan Aplikasi</h1>
            <p>Kelola informasi dan tampilan aplikasi PPDB</p>
        </div>

        <div class="settings-body">
            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Settings Form -->
            <form action="<?= base_url('admin/settings/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Logo Section -->
                <div class="settings-section">
                    <h3 class="section-title">
                        <i class="bi bi-image"></i>
                        Logo Aplikasi
                    </h3>

                    <div class="logo-preview-box">
                        <?php 
                        $logoPath = isset($settings['app_logo']) && $settings['app_logo'] !== 'default-logo.png' 
                            ? base_url('uploads/logo/' . $settings['app_logo']) 
                            : base_url('assets/img/default-logo.png');
                        ?>
                        <img src="<?= $logoPath ?>" alt="Logo" class="logo-preview" id="logoPreview">
                        
                        <div class="mt-3">
                            <div class="file-input-wrapper">
                                <label for="app_logo" class="file-input-label">
                                    <i class="bi bi-cloud-upload"></i>
                                    Pilih Logo Baru
                                </label>
                                <input type="file" id="app_logo" name="app_logo" accept="image/*" onchange="previewLogo(event)">
                                <span class="file-name" id="fileName">Belum ada file dipilih</span>
                            </div>
                            <div class="form-text mt-2">
                                <i class="bi bi-info-circle"></i> Format: JPG, PNG, GIF. Maksimal 2MB
                            </div>
                        </div>

                        <?php if (isset($settings['app_logo']) && $settings['app_logo'] !== 'default-logo.png'): ?>
                            <a href="<?= base_url('admin/settings/reset-logo') ?>" class="btn btn-secondary btn-sm mt-3" onclick="return confirm('Yakin ingin mereset logo ke default?')">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset ke Default
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Application Info Section -->
                <div class="settings-section">
                    <h3 class="section-title">
                        <i class="bi bi-info-circle"></i>
                        Informasi Aplikasi
                    </h3>

                    <div class="mb-3">
                        <label for="app_name" class="form-label">
                            <i class="bi bi-tag"></i> Nama Aplikasi *
                        </label>
                        <input type="text" class="form-control" id="app_name" name="app_name" 
                               value="<?= esc($settings['app_name'] ?? 'SPMB-Plus') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="app_description" class="form-label">
                            <i class="bi bi-file-text"></i> Deskripsi Aplikasi
                        </label>
                        <textarea class="form-control" id="app_description" name="app_description" rows="3"><?= esc($settings['app_description'] ?? '') ?></textarea>
                        <div class="form-text">Deskripsi singkat tentang aplikasi</div>
                    </div>
                </div>

                <!-- School Info Section -->
                <div class="settings-section">
                    <h3 class="section-title">
                        <i class="bi bi-building"></i>
                        Informasi Sekolah
                    </h3>

                    <div class="mb-3">
                        <label for="school_name" class="form-label">
                            <i class="bi bi-mortarboard"></i> Nama Sekolah
                        </label>
                        <input type="text" class="form-control" id="school_name" name="school_name" 
                               value="<?= esc($settings['school_name'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="school_address" class="form-label">
                            <i class="bi bi-geo-alt"></i> Alamat Sekolah
                        </label>
                        <textarea class="form-control" id="school_address" name="school_address" rows="2"><?= esc($settings['school_address'] ?? '') ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="school_phone" class="form-label">
                                <i class="bi bi-telephone"></i> Telepon
                            </label>
                            <input type="text" class="form-control" id="school_phone" name="school_phone" 
                                   value="<?= esc($settings['school_phone'] ?? '') ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="school_email" class="form-label">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input type="email" class="form-control" id="school_email" name="school_email" 
                                   value="<?= esc($settings['school_email'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewLogo(event) {
        const file = event.target.files[0];
        const fileName = document.getElementById('fileName');
        const preview = document.getElementById('logoPreview');

        if (file) {
            fileName.textContent = file.name;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            fileName.textContent = 'Belum ada file dipilih';
        }
    }
</script>

<?= $this->endSection(); ?>
