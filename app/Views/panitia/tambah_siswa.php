<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Tambah Siswa Baru<?= $this->endSection(); ?>

<?= $this->section('head'); ?>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
/* --- SCOPING FIX: Ensure all styles apply only within .tambah-siswa-container --- */
.tambah-siswa-container {
    background: #f8f9fa !important;
    min-height: 100vh !important;
    margin: -32px !important;
    padding: 32px !important;
}

/* Scope common blocks */
.tambah-siswa-container :is(.page-header,
                            .page-header-content,
                            .progress-steps,
                            .progress-step,
                            .progress-step-circle,
                            .progress-step-label,
                            .section-card,
                            .section-header,
                            .section-icon,
                            .section-title,
                            .form-label,
                            .input-with-icon,
                            .action-buttons,
                            .btn-modern,
                            .btn-modern-primary,
                            .btn-modern-secondary,
                            .alert-modern,
                            .info-badge) { all: revert; }

/* Re-apply intended styles under scoped container */
.tambah-siswa-container .page-header {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #fff; padding: 2.5rem 0; margin: -1rem -1rem 2rem -1rem;
    box-shadow: 0 4px 20px rgba(59,130,246,.3); position: relative; overflow: hidden;
}
.tambah-siswa-container .page-header::before { content:''; position:absolute; inset:0;
    background:url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.05)"/></svg>');
    background-size:100px 100px; opacity:.3; }
.tambah-siswa-container .page-header-content{position:relative;z-index:1}
.tambah-siswa-container .page-header h1{font-size:2rem;font-weight:700;margin:0;display:flex;align-items:center;gap:1rem}
.tambah-siswa-container .page-header h1 i{font-size:2.5rem;background:rgba(255,255,255,.2);padding:1rem;border-radius:50%;width:70px;height:70px;display:flex;align-items:center;justify-content:center}
.tambah-siswa-container .page-header p{margin:.5rem 0 0;opacity:.95;font-size:1.1rem}

/* Progress */
.tambah-siswa-container .progress-steps{display:flex;justify-content:space-between;margin:2rem 0;position:relative;padding:0}
.tambah-siswa-container .progress-steps::before{content:'';position:absolute;top:25px;left:0;right:0;height:3px;background:#e2e8f0;z-index:0}
.tambah-siswa-container .progress-step{position:relative;z-index:1;text-align:center;flex:1}
.tambah-siswa-container .progress-step-circle{width:50px;height:50px;background:#fff;border:3px solid #e2e8f0;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .5rem;font-weight:700;color:#94a3b8;transition:.3s}
.tambah-siswa-container .progress-step.active .progress-step-circle{background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%);border-color:#3b82f6;color:#fff;box-shadow:0 4px 15px rgba(59,130,246,.4);transform:scale(1.1)}
.tambah-siswa-container .progress-step.completed .progress-step-circle{background:#10b981;border-color:#10b981;color:#fff}
.tambah-siswa-container .progress-step-label{font-size:.875rem;font-weight:500;color:#64748b}
.tambah-siswa-container .progress-step.active .progress-step-label{color:#3b82f6;font-weight:600}

/* Sections */
.tambah-siswa-container .section-card{background:#fff;border-radius:20px;padding:2rem;margin-bottom:1.5rem;box-shadow:0 2px 15px rgba(0,0,0,.05);border:1px solid #e2e8f0;transition:.3s}
.tambah-siswa-container .section-card:hover{box-shadow:0 8px 30px rgba(59,130,246,.15);transform:translateY(-2px)}
.tambah-siswa-container .section-header{display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:2px solid #f1f5f9}
.tambah-siswa-container .section-icon{width:50px;height:50px;background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%);border-radius:15px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem}
.tambah-siswa-container .section-title{flex:1}
.tambah-siswa-container .section-title h5{margin:0;font-size:1.25rem;font-weight:700;color:#1e293b}
.tambah-siswa-container .section-title p{margin:.25rem 0 0;font-size:.875rem;color:#64748b}

/* Form controls */
.tambah-siswa-container .form-label{font-weight:600;color:#334155;margin-bottom:.5rem;display:flex;align-items:center;gap:.5rem}
.tambah-siswa-container .form-label .required-badge{background:#ef4444;color:#fff;font-size:.625rem;padding:.125rem .375rem;border-radius:4px;font-weight:500}
.tambah-siswa-container :is(.form-control,.form-select){border:2px solid #e2e8f0;border-radius:12px;padding:.75rem 1rem;transition:.3s;font-size:.95rem}
.tambah-siswa-container :is(.form-control,.form-select):focus{border-color:#3b82f6;box-shadow:0 0 0 4px rgba(59,130,246,.1)}
.tambah-siswa-container .form-control::placeholder{color:#94a3b8}
.tambah-siswa-container .input-with-icon{position:relative}
.tambah-siswa-container .input-with-icon i{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:1.1rem}
.tambah-siswa-container .input-with-icon .form-control{padding-left:3rem}

/* Actions */
.tambah-siswa-container .action-buttons{position:sticky;bottom:0;background:#fff;padding:1.5rem;margin:2rem -2rem -2rem -2rem;border-top:2px solid #e2e8f0;border-radius:0 0 20px 20px;display:flex;gap:1rem;justify-content:flex-end;z-index:100}
.tambah-siswa-container .btn-modern{padding:.875rem 2rem;border-radius:12px;font-weight:600;display:inline-flex;align-items:center;gap:.5rem;border:none;transition:.3s;font-size:1rem}
.tambah-siswa-container .btn-modern-primary{background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%);color:#fff;box-shadow:0 4px 15px rgba(59,130,246,.3)}
.tambah-siswa-container .btn-modern-primary:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(59,130,246,.4);color:#fff}
.tambah-siswa-container .btn-modern-secondary{background:#f1f5f9;color:#475569}
.tambah-siswa-container .btn-modern-secondary:hover{background:#e2e8f0;color:#334155}

/* Alerts & badges */
.tambah-siswa-container .alert-modern{border:none;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:1rem}
.tambah-siswa-container .alert-modern i{font-size:1.5rem}
.tambah-siswa-container .alert-danger{background:#fee2e2;color:#991b1b}
.tambah-siswa-container .alert-success{background:#d1fae5;color:#065f46}
.tambah-siswa-container .info-badge{display:inline-flex;align-items:center;gap:.5rem;background:#dbeafe;color:#1e40af;padding:.5rem 1rem;border-radius:8px;font-size:.875rem;font-weight:500;margin-top:.5rem}
.tambah-siswa-container .info-badge i{font-size:1rem}

/* Select2 scope */
.tambah-siswa-container .select2-container--bootstrap-5 .select2-selection--multiple{min-height:45px;border:2px solid #e2e8f0;border-radius:12px;padding:.5rem;transition:.3s;background:#fff}
.tambah-siswa-container .select2-container--bootstrap-5.select2-container--focus .select2-selection--multiple,
.tambah-siswa-container .select2-container--bootstrap-5.select2-container--open .select2-selection--multiple{border-color:#3b82f6;box-shadow:0 0 0 4px rgba(59,130,246,.1)}
.tambah-siswa-container .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice{background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%);border:none;color:#fff;padding:.4rem .75rem;border-radius:20px;font-size:.875rem;font-weight:500;margin:.25rem;box-shadow:0 2px 8px rgba(59,130,246,.3);transition:.3s;display:inline-flex;align-items:center;gap:.5rem}
.tambah-siswa-container .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove{color:rgba(255,255,255,.8);margin-right:.3rem;font-size:1rem;font-weight:bold;border:none;background:transparent;transition:.2s;display:inline-flex;align-items:center;justify-content:center;width:18px;height:18px;border-radius:50%}
.tambah-siswa-container .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove:hover{color:#fff;background:rgba(255,255,255,.2);transform:rotate(90deg)}
.tambah-siswa-container .select2-container--bootstrap-5 .select2-dropdown{border:2px solid #e2e8f0;border-radius:12px;box-shadow:0 10px 40px rgba(0,0,0,.1);overflow:hidden;margin-top:.5rem}

/* Responsive */
@media (max-width:768px){
  .tambah-siswa-container .page-header{padding:1.5rem 0;margin:-1rem -.5rem 1.5rem -.5rem}
  .tambah-siswa-container .page-header h1{font-size:1.5rem}
  .tambah-siswa-container .page-header h1 i{font-size:2rem;width:60px;height:60px;padding:.75rem}
  .tambah-siswa-container .progress-steps{flex-wrap:wrap;gap:1rem}
  .tambah-siswa-container .progress-step{flex:1 1 45%}
  .tambah-siswa-container .section-card{padding:1.5rem;border-radius:15px}
  .tambah-siswa-container .section-icon{width:40px;height:40px;font-size:1.25rem}
  .tambah-siswa-container .action-buttons{flex-direction:column-reverse}
  .tambah-siswa-container .btn-modern{width:100%;justify-content:center}
}
@media (max-width:576px){
  .tambah-siswa-container .progress-step{flex:1 1 100%}
  .tambah-siswa-container .progress-steps::before{display:none}
}
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Wrapper untuk scoped styling -->
<div class="tambah-siswa-container">

<!-- Modern Page Header -->
<div class="page-header">
    <div class="container-fluid page-header-content">
        <h1>
            <i class="bi bi-person-plus-fill"></i>
            <div>
                Tambah Siswa Baru
                <p class="mb-0" style="font-size: 1rem; font-weight: 400;">Formulir pendaftaran calon siswa baru</p>
            </div>
        </h1>
    </div>
</div>

<!-- Progress Steps -->
<div class="progress-steps">
    <div class="progress-step active">
        <div class="progress-step-circle">
            <i class="bi bi-person-fill"></i>
        </div>
        <div class="progress-step-label">Data Pribadi</div>
    </div>
    <div class="progress-step">
        <div class="progress-step-circle">
            <i class="bi bi-geo-alt-fill"></i>
        </div>
        <div class="progress-step-label">Alamat</div>
    </div>
    <div class="progress-step">
        <div class="progress-step-circle">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div class="progress-step-label">Pendidikan</div>
    </div>
    <div class="progress-step">
        <div class="progress-step-circle">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="progress-step-label">Selesai</div>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert-modern alert-danger">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>
            <strong>Oops!</strong> <?= session()->getFlashdata('error'); ?>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert-modern alert-success">
        <i class="bi bi-check-circle-fill"></i>
        <div>
            <strong>Berhasil!</strong> <?= session()->getFlashdata('success'); ?>
        </div>
    </div>
<?php endif; ?>

<!-- Form Container -->
<form method="post" action="<?= current_url() ?>">
    <?= csrf_field(); ?>

    <!-- Section 1: Data Pribadi -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="section-title">
                <h5>Data Pribadi</h5>
                <p>Informasi identitas calon siswa</p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">
                    NIK
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="nik" 
                       class="form-control <?= $validation && $validation->hasError('nik') ? 'is-invalid' : ''; ?>" 
                       placeholder="Masukkan 16 digit NIK" 
                       value="<?= old('nik'); ?>" 
                       maxlength="16"
                       required>
                <?php if ($validation && $validation->hasError('nik')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('nik'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    Nama Lengkap
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="nama_lengkap" 
                       class="form-control <?= $validation && $validation->hasError('nama_lengkap') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama lengkap sesuai akta kelahiran" 
                       value="<?= old('nama_lengkap'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('nama_lengkap')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('nama_lengkap'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    Jenis Kelamin
                    <span class="required-badge">WAJIB</span>
                </label>
                <select name="jenis_kelamin" 
                        class="form-select <?= $validation && $validation->hasError('jenis_kelamin') ? 'is-invalid' : ''; ?>" 
                        required>
                    <option value="">Pilih jenis kelamin</option>
                    <option value="laki-laki" <?= old('jenis_kelamin') === 'laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="perempuan" <?= old('jenis_kelamin') === 'perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
                <?php if ($validation && $validation->hasError('jenis_kelamin')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('jenis_kelamin'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-3">
                <label class="form-label">
                    Tempat Lahir
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="tempat_lahir" 
                       class="form-control <?= $validation && $validation->hasError('tempat_lahir') ? 'is-invalid' : ''; ?>" 
                       placeholder="Kota/Kabupaten" 
                       value="<?= old('tempat_lahir'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('tempat_lahir')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('tempat_lahir'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-3">
                <label class="form-label">
                    Tanggal Lahir
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="date" name="tanggal_lahir" 
                       class="form-control <?= $validation && $validation->hasError('tanggal_lahir') ? 'is-invalid' : ''; ?>" 
                       value="<?= old('tanggal_lahir'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('tanggal_lahir')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('tanggal_lahir'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Section 2: Data Keluarga & Agama -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="section-title">
                <h5>Data Keluarga & Agama</h5>
                <p>Informasi keluarga dan agama siswa</p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">
                    Agama
                    <span class="required-badge">WAJIB</span>
                </label>
                <select name="agama" 
                        class="form-select <?= $validation && $validation->hasError('agama') ? 'is-invalid' : ''; ?>" 
                        required>
                    <option value="">Pilih agama</option>
                    <option value="Islam" <?= old('agama') === 'Islam' ? 'selected' : ''; ?>>Islam</option>
                    <option value="Kristen" <?= old('agama') === 'Kristen' ? 'selected' : ''; ?>>Kristen</option>
                    <option value="Katolik" <?= old('agama') === 'Katolik' ? 'selected' : ''; ?>>Katolik</option>
                    <option value="Hindu" <?= old('agama') === 'Hindu' ? 'selected' : ''; ?>>Hindu</option>
                    <option value="Buddha" <?= old('agama') === 'Buddha' ? 'selected' : ''; ?>>Buddha</option>
                    <option value="Konghucu" <?= old('agama') === 'Konghucu' ? 'selected' : ''; ?>>Konghucu</option>
                    <option value="Lainnya" <?= old('agama') === 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                </select>
                <?php if ($validation && $validation->hasError('agama')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('agama'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-3">
                <label class="form-label">
                    Anak Ke-
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="number" name="anak_ke" 
                       class="form-control <?= $validation && $validation->hasError('anak_ke') ? 'is-invalid' : ''; ?>" 
                       placeholder="Contoh: 1" 
                       value="<?= old('anak_ke'); ?>" 
                       min="1"
                       required>
                <?php if ($validation && $validation->hasError('anak_ke')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('anak_ke'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-3">
                <label class="form-label">
                    Jumlah Saudara
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="number" name="jumlah_saudara" 
                       class="form-control <?= $validation && $validation->hasError('jumlah_saudara') ? 'is-invalid' : ''; ?>" 
                       placeholder="Contoh: 2" 
                       value="<?= old('jumlah_saudara'); ?>" 
                       min="0"
                       required>
                <?php if ($validation && $validation->hasError('jumlah_saudara')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('jumlah_saudara'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Section 3: Alamat -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div class="section-title">
                <h5>Alamat Lengkap</h5>
                <p>Alamat tempat tinggal siswa</p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">
                    Alamat Jalan
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="alamat_jalan" 
                       class="form-control <?= $validation && $validation->hasError('alamat_jalan') ? 'is-invalid' : ''; ?>" 
                       placeholder="Contoh: Jl. Merdeka No. 123, RT 01 / RW 05" 
                       value="<?= old('alamat_jalan'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('alamat_jalan')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('alamat_jalan'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label class="form-label">Dusun</label>
                <input type="text" name="dusun" 
                       class="form-control" 
                       placeholder="Nama dusun (opsional)" 
                       value="<?= old('dusun'); ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    Kelurahan
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="kelurahan" 
                       class="form-control <?= $validation && $validation->hasError('kelurahan') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama kelurahan/desa" 
                       value="<?= old('kelurahan'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('kelurahan')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('kelurahan'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Kecamatan
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="kecamatan" 
                       class="form-control <?= $validation && $validation->hasError('kecamatan') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama kecamatan" 
                       value="<?= old('kecamatan'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('kecamatan')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('kecamatan'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Kabupaten
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="kabupaten" 
                       class="form-control <?= $validation && $validation->hasError('kabupaten') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama kabupaten" 
                       value="<?= old('kabupaten'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('kabupaten')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('kabupaten'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Provinsi
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="provinsi" 
                       class="form-control <?= $validation && $validation->hasError('provinsi') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama provinsi" 
                       value="<?= old('provinsi'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('provinsi')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('provinsi'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Kode Pos
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="kode_pos" 
                       class="form-control <?= $validation && $validation->hasError('kode_pos') ? 'is-invalid' : ''; ?>" 
                       placeholder="5 digit kode pos" 
                       value="<?= old('kode_pos'); ?>" 
                       maxlength="5"
                       required>
                <?php if ($validation && $validation->hasError('kode_pos')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('kode_pos'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Section 4: Kontak -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon">
                <i class="bi bi-telephone-fill"></i>
            </div>
            <div class="section-title">
                <h5>Informasi Kontak</h5>
                <p>Nomor telepon yang dapat dihubungi</p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">
                    Nomor HP
                    <span class="required-badge">WAJIB</span>
                </label>
                <div class="input-with-icon">
                    <i class="bi bi-phone"></i>
                    <input type="text" name="nomor_hp" 
                           class="form-control <?= $validation && $validation->hasError('nomor_hp') ? 'is-invalid' : ''; ?>" 
                           placeholder="Contoh: 081234567890" 
                           value="<?= old('nomor_hp'); ?>" 
                           required>
                </div>
                <?php if ($validation && $validation->hasError('nomor_hp')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('nomor_hp'); ?>
                    </div>
                <?php endif; ?>
                <div class="info-badge mt-2">
                    <i class="bi bi-info-circle"></i>
                    Pastikan nomor HP aktif untuk notifikasi
                </div>
            </div>
        </div>
    </div>

    <!-- Section 5: Pendidikan & Minat -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="section-title">
                <h5>Pendidikan & Minat</h5>
                <p>Sekolah asal, jurusan, dan hobi siswa</p>
            </div>
        </div>

        <div class="row g-3">
            <!-- Sekolah Asal -->
            <div class="col-12">
                <label class="form-label">
                    Nama Sekolah Asal
                    <span class="required-badge">WAJIB</span>
                </label>
                <div class="input-group">
                    <select name="asal_sekolah" id="school_select" 
                            class="form-select <?= $validation && $validation->hasError('asal_sekolah') ? 'is-invalid' : ''; ?>" 
                            required>
                        <option value="">Pilih sekolah asal</option>
                        <?php if (isset($schools) && !empty($schools)): ?>
                            <?php foreach ($schools as $school): ?>
                                <option value="<?= esc($school['nama']) ?>" 
                                        data-npsn="<?= esc($school['npsn'] ?? '') ?>"
                                        <?= old('asal_sekolah') === $school['nama'] ? 'selected' : ''; ?>>
                                    <?= esc($school['nama']) ?> - <?= esc($school['kota']) ?>, <?= esc($school['provinsi']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                        <i class="bi bi-plus-circle"></i> Tambah Sekolah
                    </button>
                </div>
                <?php if ($validation && $validation->hasError('asal_sekolah')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('asal_sekolah'); ?>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="npsn_sekolah_asal" id="npsn_hidden" value="<?= old('npsn_sekolah_asal'); ?>">
                <small class="text-muted">
                    <i class="bi bi-lightbulb-fill"></i> NPSN akan terisi otomatis dari data sekolah
                </small>
            </div>

            <!-- Jurusan -->
            <div class="col-md-6">
                <label class="form-label">
                    Jurusan yang Diminati
                    <span class="required-badge">WAJIB</span>
                </label>
                <select name="jurusan_id" 
                        class="form-select <?= $validation && $validation->hasError('jurusan_id') ? 'is-invalid' : ''; ?>" 
                        required>
                    <option value="">Pilih jurusan</option>
                    <?php if (isset($majors) && !empty($majors)): ?>
                        <?php foreach ($majors as $major): ?>
                            <option value="<?= esc($major['id']) ?>" <?= old('jurusan_id') == $major['id'] ? 'selected' : ''; ?>>
                                <?= esc($major['kode_jurusan']) ?> - <?= esc($major['nama_jurusan']) ?>
                                <?php if ($major['kuota']): ?>
                                    (Kuota: <?= $major['kuota'] ?>)
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <?php if ($validation && $validation->hasError('jurusan_id')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('jurusan_id'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Hobi -->
            <div class="col-md-6">
                <div class="hobby-selector-wrapper">
                    <label class="form-label">
                        <i class="bi bi-heart-fill"></i>
                        Hobi / Minat
                    </label>
                    <select name="hobbies[]" id="hobbies_select" 
                            class="form-select <?= $validation && $validation->hasError('hobbies') ? 'is-invalid' : ''; ?>" 
                            multiple="multiple">
                        <?php if (isset($hobbies) && !empty($hobbies)): ?>
                            <?php 
                            $oldHobbies = old('hobbies', []);
                            foreach ($hobbies as $hobby): 
                            ?>
                                <option value="<?= esc($hobby['id']) ?>" 
                                        data-icon="<?= esc($hobby['icon'] ?? 'bi-star') ?>"
                                        <?= in_array($hobby['id'], $oldHobbies) ? 'selected' : ''; ?>>
                                    <?= esc($hobby['nama_hobi']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>Belum ada data hobi</option>
                        <?php endif; ?>
                    </select>
                    <?php if ($validation && $validation->hasError('hobbies')): ?>
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle"></i>
                            <?= $validation->getError('hobbies'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="hobby-help-text">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>Pilih satu atau lebih hobi yang diminati siswa</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 6: Data Orang Tua -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <div class="section-title">
                <h5>Data Orang Tua</h5>
                <p>Informasi orang tua/wali siswa</p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">
                    Nama Ayah
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="nama_ayah" 
                       class="form-control <?= $validation && $validation->hasError('nama_ayah') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama lengkap ayah" 
                       value="<?= old('nama_ayah'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('nama_ayah')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('nama_ayah'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    Nama Ibu
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="nama_ibu" 
                       class="form-control <?= $validation && $validation->hasError('nama_ibu') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama lengkap ibu" 
                       value="<?= old('nama_ibu'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('nama_ibu')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('nama_ibu'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="/panitia/daftar-siswa" class="btn-modern btn-modern-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn-modern btn-modern-primary">
                <i class="bi bi-check-circle"></i> Simpan Data Siswa
            </button>
        </div>
    </div>
</form>

<!-- Modern Modal Tambah Sekolah -->
<div class="modal fade" id="addSchoolModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 1.5rem 2rem; border: none;">
                <div>
                    <h5 class="modal-title mb-0" style="font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="bi bi-building" style="font-size: 1.75rem;"></i>
                        Tambah Sekolah Baru
                    </h5>
                    <p class="mb-0 mt-1" style="font-size: 0.9rem; opacity: 0.9;">Tambahkan data sekolah yang belum ada dalam daftar</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form id="schoolForm">
                    <div class="alert-modern" style="background: #dbeafe; color: #1e40af; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;">
                        <i class="bi bi-info-circle-fill" style="font-size: 1.25rem;"></i>
                        <span>Data yang Anda masukkan akan otomatis tersimpan dan dapat dipilih untuk siswa lain</span>
                    </div>
                    <div id="schoolFormError" class="alert-modern alert-danger d-none" style="margin-bottom: 1rem;"></div>
                    <div id="schoolFormSuccess" class="alert-modern alert-success d-none" style="margin-bottom: 1rem;"></div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            Nama Sekolah
                            <span class="required-badge">WAJIB</span>
                        </label>
                        <input type="text" name="nama" id="school_nama" 
                               class="form-control" 
                               placeholder="Contoh: SMP Negeri 1 Jakarta" 
                               style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 0.75rem 1rem;"
                               required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NPSN (Opsional)</label>
                            <input type="text" name="npsn" id="school_npsn" 
                                   class="form-control" 
                                   placeholder="8 digit NPSN" 
                                   style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 0.75rem 1rem;"
                                   maxlength="20">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                Kota/Kabupaten
                                <span class="required-badge">WAJIB</span>
                            </label>
                            <input type="text" name="kota" id="school_kota" 
                                   class="form-control" 
                                   placeholder="Contoh: Jakarta Selatan" 
                                   style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 0.75rem 1rem;"
                                   required>
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label">
                                Provinsi
                                <span class="required-badge">WAJIB</span>
                            </label>
                            <input type="text" name="provinsi" id="school_provinsi" 
                                   class="form-control" 
                                   placeholder="Contoh: DKI Jakarta" 
                                   style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 0.75rem 1rem;"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alamat (Opsional)</label>
                            <input type="text" name="alamat" id="school_alamat" 
                                   class="form-control" 
                                   placeholder="Alamat lengkap sekolah" 
                                   style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 0.75rem 1rem;">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="padding: 1.5rem 2rem; border-top: 2px solid #f1f5f9;">
                <button type="button" class="btn-modern btn-modern-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
                <button type="button" class="btn-modern" id="btnSaveSchool" 
                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                    <i class="bi bi-check-circle"></i> Simpan Sekolah
                </button>
            </div>
        </div>
    </div>
</div>

</div><!-- End .tambah-siswa-container -->

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<!-- Select2 JS (jQuery sudah dimuat di layout) -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // MODERN SELECT2 INITIALIZATION FOR HOBBIES
    // ========================================
    
    const hobbiesSelect = document.getElementById('hobbies_select');
    
    if (hobbiesSelect) {
        // Initialize Select2 with modern configuration
        $('#hobbies_select').select2({
            theme: 'bootstrap-5',
            placeholder: '✨ Pilih hobi yang diminati...',
            allowClear: true,
            width: '100%',
            tags: false,
            closeOnSelect: false,
            dropdownCssClass: 'hobby-dropdown-modern',
            selectionCssClass: 'hobby-selection-modern',
            templateResult: formatHobbyOption,
            templateSelection: formatHobbySelection,
            language: {
                noResults: function() {
                    return '<div class="hobby-empty-state"><i class="bi bi-search"></i><p>Tidak ada hobi yang ditemukan</p></div>';
                },
                searching: function() {
                    return '<div class="hobby-empty-state"><i class="bi bi-hourglass-split"></i><p>Mencari...</p></div>';
                },
                maximumSelected: function(args) {
                    return 'Maksimal ' + args.maximum + ' hobi dapat dipilih';
                }
            }
        });

        // Enhanced option formatting with modern icon badge
        function formatHobbyOption(hobby) {
            if (!hobby.id) {
                return hobby.text;
            }
            
            var $option = $(hobby.element);
            var icon = $option.data('icon') || 'bi-star';
            var isSelected = $option.is(':selected');
            
            var $result = $(
                '<div class="hobby-option-item">' +
                    '<span class="hobby-option-icon">' +
                        '<i class="bi ' + icon + '"></i>' +
                    '</span>' +
                    '<span class="hobby-option-text">' + hobby.text + '</span>' +
                    (isSelected ? '<span class="hobby-option-badge">✓</span>' : '') +
                '</div>'
            );
            
            return $result;
        }

        // Enhanced selection formatting with icon and animation
        function formatHobbySelection(hobby) {
            if (!hobby.id) {
                return hobby.text;
            }
            
            var $option = $(hobby.element);
            var icon = $option.data('icon') || 'bi-star';
            
            return $('<span><i class="bi ' + icon + ' me-1"></i>' + hobby.text + '</span>');
        }

        // Add animation when selecting/deselecting
        $('#hobbies_select').on('select2:select', function(e) {
            // Add subtle animation
            setTimeout(function() {
                $('.select2-selection__choice').last().css({
                    'animation': 'tagSlideIn 0.3s ease'
                });
            }, 10);
        });

        // Add hover effect for dropdown items
        $(document).on('mouseenter', '.select2-results__option', function() {
            $(this).css('transform', 'translateX(5px)');
        }).on('mouseleave', '.select2-results__option', function() {
            $(this).css('transform', 'translateX(0)');
        });

        // Show count of selected hobbies
        $('#hobbies_select').on('change', function() {
            var selectedCount = $(this).val() ? $(this).val().length : 0;
            var $helpText = $('.hobby-help-text span');
            
            if (selectedCount > 0) {
                $helpText.html('<strong>' + selectedCount + '</strong> hobi dipilih 🎯');
                $helpText.parent().css('color', '#3b82f6');
            } else {
                $helpText.html('Pilih satu atau lebih hobi yang diminati siswa');
                $helpText.parent().css('color', '#64748b');
            }
        });

        // Trigger initial count
        $('#hobbies_select').trigger('change');
    }

    // Update hidden NPSN field when school is selected
    const schoolSelect = document.getElementById('school_select');
    const npsnHidden = document.getElementById('npsn_hidden');
    
    if (schoolSelect && npsnHidden) {
        schoolSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const npsn = selectedOption.getAttribute('data-npsn') || '';
            npsnHidden.value = npsn;
        });
    }
    
    // Handle save school button
    const btnSaveSchool = document.getElementById('btnSaveSchool');
    if (btnSaveSchool) {
        btnSaveSchool.addEventListener('click', function() {
            saveSchool();
        });
    }
});

function saveSchool() {
    const form = document.getElementById('schoolForm');
    const formData = new FormData(form);
    const btn = document.getElementById('btnSaveSchool');
    const errorDiv = document.getElementById('schoolFormError');
    const successDiv = document.getElementById('schoolFormSuccess');
    
    // Validate required fields
    const nama = document.getElementById('school_nama').value.trim();
    const kota = document.getElementById('school_kota').value.trim();
    const provinsi = document.getElementById('school_provinsi').value.trim();
    
    if (!nama || !kota || !provinsi) {
        errorDiv.textContent = 'Nama Sekolah, Kota, dan Provinsi harus diisi!';
        errorDiv.classList.remove('d-none');
        successDiv.classList.add('d-none');
        return;
    }
    
    // Disable button
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    errorDiv.classList.add('d-none');
    successDiv.classList.add('d-none');
    
    // Send AJAX request
    fetch('<?= base_url('panitia/ajax-add-school') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            successDiv.textContent = data.message;
            successDiv.classList.remove('d-none');
            
            // Add new option to select
            const select = document.getElementById('school_select');
            const newOption = new Option(
                data.school.nama + ' - ' + data.school.kota + ', ' + data.school.provinsi,
                data.school.nama
            );
            newOption.setAttribute('data-npsn', data.school.npsn || '');
            select.add(newOption);
            select.value = data.school.nama;
            
            // Update NPSN hidden field
            document.getElementById('npsn_hidden').value = data.school.npsn || '';
            
            // Reset form
            form.reset();
            
            // Close modal after 1.5 seconds
            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('addSchoolModal')).hide();
                successDiv.classList.add('d-none');
            }, 1500);
        } else {
            errorDiv.textContent = data.message || 'Gagal menyimpan data sekolah';
            errorDiv.classList.remove('d-none');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        errorDiv.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
        errorDiv.classList.remove('d-none');
    })
    .finally(() => {
        // Re-enable button
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-circle"></i> Simpan Sekolah';
    });
}
</script>
<?= $this->endSection(); ?>
