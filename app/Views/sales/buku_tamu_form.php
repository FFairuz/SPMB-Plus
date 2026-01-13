<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-pen-fancy me-2"></i><?= esc($title) ?></h5>
                </div>
                <div class="card-body">
                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>Ada kesalahan dalam pengisian form:
                            <ul class="mt-2 mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('sales/save-buku-tamu') ?>" method="POST" class="needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= (isset($errors) && isset($errors['nama'])) ? 'is-invalid' : '' ?>" 
                                   id="nama" 
                                   name="nama" 
                                   value="<?= old('nama') ?>"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            <div class="invalid-feedback">
                                <?= isset($errors['nama']) ? $errors['nama'] : 'Nama harus diisi' ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="school_id" class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                            <select class="form-select <?= (isset($errors) && isset($errors['school_id'])) ? 'is-invalid' : '' ?>" 
                                    id="school_id" 
                                    name="school_id"
                                    required>
                                <option value="">-- Pilih Sekolah Asal --</option>
                                <?php if (isset($schools) && !empty($schools)): ?>
                                    <?php foreach ($schools as $school): ?>
                                        <option value="<?= $school['id'] ?>" <?= old('school_id') == $school['id'] ? 'selected' : '' ?>>
                                            <?= esc($school['nama']) ?> - <?= esc($school['kota']) ?>, <?= esc($school['provinsi']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= isset($errors['school_id']) ? $errors['school_id'] : 'Asal sekolah harus dipilih' ?>
                            </div>
                            <small class="form-text text-muted d-block mt-1">
                                <i class="fas fa-info-circle"></i> Pilih sekolah dari daftar yang tersedia. Jika sekolah Anda tidak ada, hubungi admin.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   class="form-control <?= (isset($errors) && isset($errors['no_hp'])) ? 'is-invalid' : '' ?>" 
                                   id="no_hp" 
                                   name="no_hp" 
                                   value="<?= old('no_hp') ?>"
                                   placeholder="Contoh: 08123456789"
                                   required>
                            <div class="invalid-feedback">
                                <?= isset($errors['no_hp']) ? $errors['no_hp'] : 'Nomor HP harus diisi' ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sumber_info" class="form-label">Tahu Sekolah Ini Dari Mana? <span class="text-danger">*</span></label>
                            <select class="form-select <?= (isset($errors) && isset($errors['sumber_info'])) ? 'is-invalid' : '' ?>" 
                                    id="sumber_info" 
                                    name="sumber_info"
                                    required>
                                <option value="">-- Pilih Sumber Informasi --</option>
                                <option value="Teman" <?= old('sumber_info') === 'Teman' ? 'selected' : '' ?>>Teman</option>
                                <option value="Guru" <?= old('sumber_info') === 'Guru' ? 'selected' : '' ?>>Guru/Sekolah</option>
                                <option value="Media Sosial" <?= old('sumber_info') === 'Media Sosial' ? 'selected' : '' ?>>Media Sosial (Instagram, Facebook, TikTok)</option>
                                <option value="Website" <?= old('sumber_info') === 'Website' ? 'selected' : '' ?>>Website</option>
                                <option value="Iklan" <?= old('sumber_info') === 'Iklan' ? 'selected' : '' ?>>Iklan/Brosur</option>
                                <option value="Internet/Google" <?= old('sumber_info') === 'Internet/Google' ? 'selected' : '' ?>>Internet/Google</option>
                                <option value="Lainnya" <?= old('sumber_info') === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= isset($errors['sumber_info']) ? $errors['sumber_info'] : 'Sumber informasi harus dipilih' ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-end mt-4">
                            <a href="<?= base_url('sales/tracking-form') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        font-weight: 500;
        color: #333;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .card {
        border-radius: 8px;
        border: none;
    }
    
    .card-header {
        border-radius: 8px 8px 0 0;
    }
</style>

<script>
    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    }());
</script>
<?= $this->endSection() ?>
