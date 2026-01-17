<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Tambah Siswa Baru<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-user-plus text-primary"></i> Tambah Siswa Baru</h3>
            <p class="text-muted mb-0">Formulir Data Pokok Pendidikan Siswa</p>
        </div>
        <div class="text-end">
            <div class="badge bg-info text-white fs-6 px-3 py-2">
                <i class="fas fa-hashtag me-1"></i> No. Pendaftaran: <strong><?= $nomor_pendaftaran_preview ?? 'PPDB-'.date('Y').'-XXXX' ?></strong>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Terdapat kesalahan validasi:</strong>
            <?= $validation->listErrors() ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('panitia/tambah-siswa') ?>" method="post" id="formTambahSiswa">
        <?= csrf_field() ?>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-3" id="formTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="jalur-tab" data-bs-toggle="tab" data-bs-target="#jalur" type="button" role="tab">
                    <i class="fas fa-route me-1"></i> Jalur Pendaftaran
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pribadi-tab" data-bs-toggle="tab" data-bs-target="#pribadi" type="button" role="tab">
                    <i class="fas fa-user me-1"></i> Data Pribadi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="alamat-tab" data-bs-toggle="tab" data-bs-target="#alamat" type="button" role="tab">
                    <i class="fas fa-home me-1"></i> Alamat
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="ortu-tab" data-bs-toggle="tab" data-bs-target="#ortu" type="button" role="tab">
                    <i class="fas fa-users me-1"></i> Data Orang Tua
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="akademik-tab" data-bs-toggle="tab" data-bs-target="#akademik" type="button" role="tab">
                    <i class="fas fa-graduation-cap me-1"></i> Data Akademik
                </button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="formTabsContent">
            
            <!-- Tab 1: Jalur Pendaftaran -->
            <div class="tab-pane fade show active" id="jalur" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-route me-2"></i> Jalur Pendaftaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Pilih Jalur Pendaftaran:</strong> Sesuaikan dengan kategori pendaftaran siswa
                                </div>
                                
                                <div class="row g-3">
                                    <!-- PPDB Bersama -->
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="jalur_pendaftaran" id="jalur1" value="PPDB Bersama" <?= old('jalur_pendaftaran') == 'PPDB Bersama' ? 'checked' : '' ?> required>
                                        <label class="btn btn-outline-primary w-100 h-100 p-4" for="jalur1">
                                            <div class="text-center">
                                                <i class="fas fa-users fa-3x mb-3"></i>
                                                <h5>PPDB Bersama</h5>
                                                <p class="small mb-0">Jalur pendaftaran PPDB umum bersama</p>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <!-- Muhammadiyah -->
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="jalur_pendaftaran" id="jalur2" value="Muhammadiyah" <?= old('jalur_pendaftaran') == 'Muhammadiyah' ? 'checked' : '' ?>>
                                        <label class="btn btn-outline-success w-100 h-100 p-4" for="jalur2">
                                            <div class="text-center">
                                                <i class="fas fa-star-and-crescent fa-3x mb-3"></i>
                                                <h5>Muhammadiyah</h5>
                                                <p class="small mb-0">Jalur pendaftaran khusus siswa Muhammadiyah</p>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <!-- Non Muhammadiyah -->
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="jalur_pendaftaran" id="jalur3" value="Non Muhammadiyah" <?= old('jalur_pendaftaran') == 'Non Muhammadiyah' ? 'checked' : '' ?>>
                                        <label class="btn btn-outline-info w-100 h-100 p-4" for="jalur3">
                                            <div class="text-center">
                                                <i class="fas fa-user-friends fa-3x mb-3"></i>
                                                <h5>Non Muhammadiyah</h5>
                                                <p class="small mb-0">Jalur pendaftaran siswa umum</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-primary btn-lg px-5" onclick="nextTab('pribadi-tab')">
                                        Lanjut ke Data Pribadi <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Data Pribadi -->
            <div class="tab-pane fade" id="pribadi" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i> Data Pribadi Siswa</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- NIK & NIS -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control form-control-lg" value="<?= old('nik') ?>" maxlength="16" placeholder="16 digit NIK" required>
                                <small class="text-muted">Nomor Induk Kependudukan</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIS</label>
                                <input type="text" name="nis" class="form-control form-control-lg" value="<?= old('nis') ?>" placeholder="Nomor Induk Siswa (Opsional)">
                            </div>

                            <!-- Nama Lengkap & Panggilan -->
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control form-control-lg" value="<?= old('nama_lengkap') ?>" placeholder="Sesuai akta kelahiran" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Nama Panggilan</label>
                                <input type="text" name="nama_panggilan" class="form-control form-control-lg" value="<?= old('nama_panggilan') ?>" placeholder="Nama panggilan">
                            </div>

                            <!-- Jenis Kelamin & Tempat Lahir -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-select form-select-lg" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="laki-laki" <?= old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="perempuan" <?= old('jenis_kelamin') == 'perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" class="form-control form-control-lg" value="<?= old('tempat_lahir') ?>" placeholder="Kota/Kabupaten" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control form-control-lg" value="<?= old('tanggal_lahir') ?>" required>
                            </div>

                            <!-- Agama & Status Keluarga -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Agama <span class="text-danger">*</span></label>
                                <select name="agama" class="form-select form-select-lg" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Islam" <?= old('agama') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                    <option value="Kristen" <?= old('agama') == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                                    <option value="Katolik" <?= old('agama') == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                    <option value="Hindu" <?= old('agama') == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                    <option value="Buddha" <?= old('agama') == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                                    <option value="Konghucu" <?= old('agama') == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                                    <option value="Lainnya" <?= old('agama') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Anak Ke <span class="text-danger">*</span></label>
                                <input type="number" name="anak_ke" class="form-control form-control-lg" value="<?= old('anak_ke') ?>" min="1" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Jumlah Saudara <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_saudara" class="form-control form-control-lg" value="<?= old('jumlah_saudara') ?>" min="0" required>
                            </div>

                            <!-- Nomor HP -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nomor HP/WA <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_hp" class="form-control form-control-lg" value="<?= old('nomor_hp') ?>" placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nomor Telepon Rumah</label>
                                <input type="text" name="nomor_telepon" class="form-control form-control-lg" value="<?= old('nomor_telepon') ?>" placeholder="021xxxxxxx (Opsional)">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary btn-lg px-4" onclick="nextTab('jalur-tab')">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary btn-lg px-4" onclick="nextTab('alamat-tab')">
                                Lanjut <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Alamat -->
            <div class="tab-pane fade" id="alamat" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-home me-2"></i> Alamat Tempat Tinggal</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Alamat Jalan -->
                            <div class="col-12">
                                <label class="form-label fw-bold">Alamat Jalan <span class="text-danger">*</span></label>
                                <textarea name="alamat_jalan" class="form-control form-control-lg" rows="3" placeholder="Jalan, RT/RW, Nomor Rumah" required><?= old('alamat_jalan') ?></textarea>
                            </div>

                            <!-- Dusun -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Dusun/Lingkungan</label>
                                <input type="text" name="dusun" class="form-control form-control-lg" value="<?= old('dusun') ?>" placeholder="Opsional">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kelurahan/Desa <span class="text-danger">*</span></label>
                                <input type="text" name="kelurahan" class="form-control form-control-lg" value="<?= old('kelurahan') ?>" required>
                            </div>

                            <!-- Kecamatan & Kabupaten -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" name="kecamatan" class="form-control form-control-lg" value="<?= old('kecamatan') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <input type="text" name="kabupaten" class="form-control form-control-lg" value="<?= old('kabupaten') ?>" required>
                            </div>

                            <!-- Provinsi & Kode Pos -->
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" name="provinsi" class="form-control form-control-lg" value="<?= old('provinsi') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" name="kode_pos" class="form-control form-control-lg" value="<?= old('kode_pos') ?>" maxlength="5" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary btn-lg px-4" onclick="nextTab('pribadi-tab')">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary btn-lg px-4" onclick="nextTab('ortu-tab')">
                                Lanjut <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Data Orang Tua -->
            <div class="tab-pane fade" id="ortu" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i> Data Orang Tua / Wali</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Nama Ayah -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Ayah <span class="text-danger">*</span></label>
                                <input type="text" name="nama_ayah" class="form-control form-control-lg" value="<?= old('nama_ayah') ?>" required>
                            </div>
                            
                            <!-- Nama Ibu -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Ibu <span class="text-danger">*</span></label>
                                <input type="text" name="nama_ibu" class="form-control form-control-lg" value="<?= old('nama_ibu') ?>" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary btn-lg px-4" onclick="nextTab('alamat-tab')">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary btn-lg px-4" onclick="nextTab('akademik-tab')">
                                Lanjut <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 5: Data Akademik -->
            <div class="tab-pane fade" id="akademik" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i> Data Akademik & Minat</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Asal Sekolah -->
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Asal Sekolah <span class="text-danger">*</span></label>
                                <input type="text" name="asal_sekolah" class="form-control form-control-lg" value="<?= old('asal_sekolah') ?>" placeholder="Nama SMP/MTs" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">NPSN Sekolah Asal</label>
                                <input type="text" name="npsn_sekolah_asal" class="form-control form-control-lg" value="<?= old('npsn_sekolah_asal') ?>" placeholder="8 digit (Opsional)" maxlength="8">
                            </div>

                            <!-- Jurusan yang Dipilih -->
<div class="col-12">
                                <label class="form-label fw-bold">Jurusan yang Dipilih <span class="text-danger">*</span></label>
                                <select name="jurusan_id" class="form-select form-select-lg" required>
                                    <option value="">-- Pilih Jurusan --</option>
                                    <?php if (isset($majors) && !empty($majors)): ?>
                                        <?php foreach ($majors as $major): ?>
                                            <option value="<?= $major['id'] ?>" <?= old('jurusan_id') == $major['id'] ? 'selected' : '' ?>>
                                                <?= esc($major['nama_jurusan'] ?? $major['nama']) ?><?= isset($major['kode_jurusan']) ? ' (' . esc($major['kode_jurusan']) . ')' : '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Hobi/Minat -->
                            <div class="col-12">
                                <label class="form-label fw-bold">Hobi / Minat Bakat</label>
                                <div class="row g-2">
                                    <?php if (isset($hobbies) && !empty($hobbies)): ?>
                                        <?php foreach ($hobbies as $hobby): ?>
                                            <div class="col-md-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hobbies[]" value="<?= $hobby['id'] ?>" id="hobby<?= $hobby['id'] ?>" <?= (is_array(old('hobbies')) && in_array($hobby['id'], old('hobbies'))) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="hobby<?= $hobby['id'] ?>">
                                                        <?= esc($hobby['nama_hobi'] ?? $hobby['nama']) ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="col-12">
                                            <p class="text-muted">Belum ada data hobi/minat tersedia.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary btn-lg px-4" onclick="nextTab('ortu-tab')">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </button>
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fas fa-save me-2"></i> Simpan Data Siswa
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
function nextTab(tabId) {
    const tab = new bootstrap.Tab(document.getElementById(tabId));
    tab.show();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Auto-scroll to top when tab changes
document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(button => {
    button.addEventListener('shown.bs.tab', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
</script>

<style>
/* Custom styling for radio button cards */
.btn-check:checked + .btn-outline-primary {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.btn-check:checked + .btn-outline-success {
    background-color: #198754;
    color: white;
    border-color: #198754;
}

.btn-check:checked + .btn-outline-info {
    background-color: #0dcaf0;
    color: white;
    border-color: #0dcaf0;
}

/* Form styling */
.form-control-lg, .form-select-lg {
    font-size: 1rem;
}

.tab-content {
    min-height: 500px;
}

.nav-tabs .nav-link {
    color: #6c757d;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    font-weight: 600;
}
</style>

<?= $this->endSection(); ?>
