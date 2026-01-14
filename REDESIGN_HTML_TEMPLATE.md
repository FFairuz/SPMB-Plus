# 🎨 Modern Form HTML Template - Tambah Siswa

## Complete HTML Structure

Berikut adalah template HTML lengkap untuk menggantikan bagian content di `tambah_siswa.php`:

```html
<?= $this->section('content'); ?>

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

    <!-- SECTION 1: DATA PRIBADI -->
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

    <!-- SECTION 2: ALAMAT -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div class="section-title">
                <h5>Alamat Lengkap</h5>
                <p>Alamat tempat tinggal saat ini</p>
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
                       placeholder="Nama jalan, nomor rumah, RT/RW" 
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
                    Kelurahan/Desa
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="kelurahan" 
                       class="form-control <?= $validation && $validation->hasError('kelurahan') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama kelurahan atau desa" 
                       value="<?= old('kelurahan'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('kelurahan')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('kelurahan'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
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

            <div class="col-md-6">
                <label class="form-label">
                    Kabupaten/Kota
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="kabupaten" 
                       class="form-control <?= $validation && $validation->hasError('kabupaten') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama kabupaten atau kota" 
                       value="<?= old('kabupaten'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('kabupaten')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('kabupaten'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
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

            <div class="col-md-6">
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

    <!-- SECTION 3: KONTAK -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon">
                <i class="bi bi-telephone-fill"></i>
            </div>
            <div class="section-title">
                <h5>Informasi Kontak</h5>
                <p>Nomor yang dapat dihubungi</p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">
                    Nomor HP/WhatsApp
                    <span class="required-badge">WAJIB</span>
                </label>
                <input type="text" name="nomor_hp" 
                       class="form-control <?= $validation && $validation->hasError('nomor_hp') ? 'is-invalid' : ''; ?>" 
                       placeholder="Contoh: 081234567890" 
                       value="<?= old('nomor_hp'); ?>" 
                       required>
                <?php if ($validation && $validation->hasError('nomor_hp')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('nomor_hp'); ?>
                    </div>
                <?php endif; ?>
                <div class="info-badge mt-2">
                    <i class="bi bi-info-circle-fill"></i>
                    Nomor aktif untuk dihubungi oleh panitia
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: PENDIDIKAN & MINAT -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="section-title">
                <h5>Pendidikan & Minat</h5>
                <p>Informasi hobi dan jurusan yang diminati</p>
            </div>
        </div>

        <div class="row g-3">
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

            <div class="col-md-6">
                <label class="form-label">
                    Jurusan yang Diminati
                    <span class="required-badge">WAJIB</span>
                </label>
                <select name="jurusan_id" 
                        class="form-select <?= $validation && $validation->hasError('jurusan_id') ? 'is-invalid' : ''; ?>" 
                        required>
                    <option value="">-- Pilih Jurusan --</option>
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
                <div class="info-badge mt-2">
                    <i class="bi bi-info-circle-fill"></i>
                    Pilih jurusan yang diminati siswa
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 5: SEKOLAH ASAL -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon">
                <i class="bi bi-building"></i>
            </div>
            <div class="section-title">
                <h5>Sekolah Asal</h5>
                <p>Informasi sekolah sebelumnya</p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">
                    Nama Sekolah
                    <span class="required-badge">WAJIB</span>
                </label>
                <select name="nama_sekolah_asal" id="school_select"
                        class="form-select <?= $validation && $validation->hasError('nama_sekolah_asal') ? 'is-invalid' : ''; ?>" 
                        required>
                    <option value="">-- Pilih Sekolah --</option>
                    <?php if (isset($schools) && !empty($schools)): ?>
                        <?php foreach ($schools as $school): ?>
                            <option value="<?= esc($school['nama']) ?>" 
                                    data-npsn="<?= esc($school['npsn'] ?? '') ?>"
                                    <?= old('nama_sekolah_asal') == $school['nama'] ? 'selected' : ''; ?>>
                                <?= esc($school['nama']) ?> 
                                <?php if (!empty($school['kota'])): ?>
                                    - <?= esc($school['kota']) ?>
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <?php if ($validation && $validation->hasError('nama_sekolah_asal')): ?>
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> <?= $validation->getError('nama_sekolah_asal'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <label class="form-label">NPSN</label>
                <input type="text" name="npsn" id="npsn_hidden"
                       class="form-control" 
                       placeholder="Otomatis terisi" 
                       value="<?= old('npsn'); ?>" 
                       readonly>
            </div>

            <div class="col-12">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                    <i class="bi bi-plus-circle"></i> Tambah Sekolah Baru
                </button>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="<?= base_url('panitia') ?>" class="btn-modern btn-modern-secondary">
            <i class="bi bi-x-circle"></i>
            Batal
        </a>
        <button type="submit" class="btn-modern btn-modern-primary">
            <i class="bi bi-check-circle-fill"></i>
            Simpan Data
        </button>
    </div>
</form>

<!-- Modal Tambah Sekolah (keep existing modal code) -->

<?= $this->endSection(); ?>
```

## Notes:
1. Copy kode HTML di atas untuk menggantikan section content yang lama
2. Pastikan modal tambah sekolah tetap ada di akhir (sebelum endSection)
3. CSS sudah ada dan siap digunakan
4. JavaScript untuk Select2 sudah ada di section scripts

---

**Status**: Ready to implement
**File**: app/Views/panitia/tambah_siswa.php
