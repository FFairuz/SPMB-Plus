<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-<?= $action === 'add' ? 'plus-circle' : 'edit' ?> me-2"></i><?= esc($title) ?>
                    </h5>
                </div>
                <div class="card-body">
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

                    <form method="POST" action="<?= $action === 'add' ? base_url('admin/schools/save') : base_url('admin/schools/update/' . $school['id']) ?>" class="needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nama" 
                                   name="nama" 
                                   value="<?= old('nama', $school['nama'] ?? '') ?>"
                                   placeholder="Masukkan nama lengkap sekolah"
                                   required>
                            <div class="invalid-feedback">
                                Nama sekolah harus diisi
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="npsn" class="form-label">NPSN (Nomor Pokok Sekolah Nasional)</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="npsn" 
                                   name="npsn" 
                                   value="<?= old('npsn', $school['npsn'] ?? '') ?>"
                                   placeholder="Contoh: 20101234">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Opsional, hanya jika sekolah memiliki NPSN
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kota" class="form-label">Kota <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="kota" 
                                       name="kota" 
                                       value="<?= old('kota', $school['kota'] ?? '') ?>"
                                       placeholder="Masukkan nama kota"
                                       required>
                                <div class="invalid-feedback">
                                    Kota harus diisi
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="provinsi" 
                                       name="provinsi" 
                                       value="<?= old('provinsi', $school['provinsi'] ?? '') ?>"
                                       placeholder="Masukkan nama provinsi"
                                       required>
                                <div class="invalid-feedback">
                                    Provinsi harus diisi
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" 
                                      id="alamat" 
                                      name="alamat" 
                                      rows="3"
                                      placeholder="Masukkan alamat lengkap sekolah"><?= old('alamat', $school['alamat'] ?? '') ?></textarea>
                        </div>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-end mt-4">
                            <a href="<?= base_url('admin/schools') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i><?= $action === 'add' ? 'Tambah' : 'Simpan Perubahan' ?>
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

    .btn {
        border-radius: 6px;
    }

    .invalid-feedback {
        display: block;
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
