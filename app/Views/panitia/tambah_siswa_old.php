<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Tambah Siswa Baru<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-user-plus text-primary"></i> Tambah Siswa Baru</h3>
            <p class="text-muted mb-0">Formulir Data Pokok Pendidikan Siswa - Sesuai Standar Dapodik</p>
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

    <form action="<?= base_url('panitia/tambah-siswa') ?>" method="post">
        <?= csrf_field() ?>

        <!-- Card 1: Data Pribadi Siswa -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-primary"><i class="fas fa-user me-2"></i> Data Pribadi Siswa</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" class="form-control" value="<?= old('nik') ?>" maxlength="16" placeholder="16 digit NIK" required>
                        <small class="text-muted">Nomor Induk Kependudukan</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">NIS</label>
                        <input type="text" name="nis" class="form-control" value="<?= old('nis') ?>" placeholder="Nomor Induk Siswa">
                        <small class="text-muted">Opsional - akan dibuat otomatis jika dikosongkan</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap') ?>" placeholder="Nama lengkap sesuai akta kelahiran" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" class="form-control" value="<?= old('nama_panggilan') ?>" placeholder="Nama panggilan">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status Dalam Keluarga</label>
                        <select name="status_keluarga" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="Anak Kandung" <?= old('status_keluarga') == 'Anak Kandung' ? 'selected' : '' ?>>Anak Kandung</option>
                            <option value="Anak Tiri" <?= old('status_keluarga') == 'Anak Tiri' ? 'selected' : '' ?>>Anak Tiri</option>
                            <option value="Anak Angkat" <?= old('status_keluarga') == 'Anak Angkat' ? 'selected' : '' ?>>Anak Angkat</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nomor Telepon Rumah</label>
                        <input type="text" name="nomor_telepon" class="form-control" value="<?= old('nomor_telepon') ?>" placeholder="021xxxxxxx">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="laki-laki" <?= old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="perempuan" <?= old('jenis_kelamin') == 'perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" class="form-control" value="<?= old('tempat_lahir') ?>" placeholder="Kota/Kabupaten" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="<?= old('tanggal_lahir') ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Agama <span class="text-danger">*</span></label>
                        <select name="agama" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Islam" <?= old('agama') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                            <option value="Kristen" <?= old('agama') == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                            <option value="Katolik" <?= old('agama') == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                            <option value="Hindu" <?= old('agama') == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                            <option value="Buddha" <?= old('agama') == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                            <option value="Konghucu" <?= old('agama') == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Anak Ke- <span class="text-danger">*</span></label>
                        <input type="number" name="anak_ke" class="form-control" value="<?= old('anak_ke') ?>" min="1" placeholder="Contoh: 1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jumlah Saudara <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_saudara" class="form-control" value="<?= old('jumlah_saudara', '0') ?>" min="0" placeholder="Contoh: 2" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan" class="form-control" value="<?= old('tinggi_badan') ?>" placeholder="Contoh: 165">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" class="form-control" value="<?= old('berat_badan') ?>" placeholder="Contoh: 55">
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Alamat Lengkap -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i> Alamat Lengkap</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Alamat Jalan <span class="text-danger">*</span></label>
                        <input type="text" name="alamat_jalan" class="form-control" value="<?= old('alamat_jalan') ?>" placeholder="Jl. Contoh No. 123, RT/RW" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Dusun</label>
                        <input type="text" name="dusun" class="form-control" value="<?= old('dusun') ?>" placeholder="Nama dusun">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Kelurahan/Desa <span class="text-danger">*</span></label>
                        <input type="text" name="kelurahan" class="form-control" value="<?= old('kelurahan') ?>" placeholder="Nama kelurahan" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Kecamatan <span class="text-danger">*</span></label>
                        <input type="text" name="kecamatan" class="form-control" value="<?= old('kecamatan') ?>" placeholder="Nama kecamatan" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Kabupaten/Kota <span class="text-danger">*</span></label>
                        <input type="text" name="kabupaten" class="form-control" value="<?= old('kabupaten') ?>" placeholder="Nama kabupaten" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Provinsi <span class="text-danger">*</span></label>
                        <input type="text" name="provinsi" class="form-control" value="<?= old('provinsi') ?>" placeholder="Nama provinsi" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kode Pos <span class="text-danger">*</span></label>
                        <input type="text" name="kode_pos" class="form-control" value="<?= old('kode_pos') ?>" maxlength="5" placeholder="12345" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nomor HP <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_hp" class="form-control" value="<?= old('nomor_hp') ?>" placeholder="08xxxxxxxxxx" required>
                        <small class="text-muted">Nomor HP siswa/orang tua yang dapat dihubungi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Data Orang Tua / Wali -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-primary"><i class="fas fa-users me-2"></i> Data Orang Tua / Wali</h5>
            </div>
            <div class="card-body">
                <!-- Data Ayah -->
                <h6 class="text-secondary mb-3 border-bottom pb-2"><i class="fas fa-male me-2"></i> Data Ayah Kandung</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Ayah <span class="text-danger">*</span></label>
                        <input type="text" name="nama_ayah" class="form-control" value="<?= old('nama_ayah') ?>" placeholder="Nama lengkap ayah" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NIK Ayah</label>
                        <input type="text" name="nik_ayah" class="form-control" value="<?= old('nik_ayah') ?>" maxlength="16" placeholder="16 digit NIK ayah">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Pendidikan Ayah</label>
                        <select name="pendidikan_ayah" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="SD/Sederajat" <?= old('pendidikan_ayah') == 'SD/Sederajat' ? 'selected' : '' ?>>SD/Sederajat</option>
                            <option value="SMP/Sederajat" <?= old('pendidikan_ayah') == 'SMP/Sederajat' ? 'selected' : '' ?>>SMP/Sederajat</option>
                            <option value="SMA/Sederajat" <?= old('pendidikan_ayah') == 'SMA/Sederajat' ? 'selected' : '' ?>>SMA/Sederajat</option>
                            <option value="D1/D2/D3" <?= old('pendidikan_ayah') == 'D1/D2/D3' ? 'selected' : '' ?>>D1/D2/D3</option>
                            <option value="S1" <?= old('pendidikan_ayah') == 'S1' ? 'selected' : '' ?>>S1</option>
                            <option value="S2" <?= old('pendidikan_ayah') == 'S2' ? 'selected' : '' ?>>S2</option>
                            <option value="S3" <?= old('pendidikan_ayah') == 'S3' ? 'selected' : '' ?>>S3</option>
                            <option value="Tidak Sekolah" <?= old('pendidikan_ayah') == 'Tidak Sekolah' ? 'selected' : '' ?>>Tidak Sekolah</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" class="form-control" value="<?= old('pekerjaan_ayah') ?>" placeholder="Contoh: PNS, Wiraswasta">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Penghasilan Ayah</label>
                        <select name="penghasilan_ayah" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="< Rp 1.000.000" <?= old('penghasilan_ayah') == '< Rp 1.000.000' ? 'selected' : '' ?>>< Rp 1.000.000</option>
                            <option value="Rp 1.000.000 - Rp 2.000.000" <?= old('penghasilan_ayah') == 'Rp 1.000.000 - Rp 2.000.000' ? 'selected' : '' ?>>Rp 1.000.000 - Rp 2.000.000</option>
                            <option value="Rp 2.000.000 - Rp 3.000.000" <?= old('penghasilan_ayah') == 'Rp 2.000.000 - Rp 3.000.000' ? 'selected' : '' ?>>Rp 2.000.000 - Rp 3.000.000</option>
                            <option value="Rp 3.000.000 - Rp 5.000.000" <?= old('penghasilan_ayah') == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' ?>>Rp 3.000.000 - Rp 5.000.000</option>
                            <option value="> Rp 5.000.000" <?= old('penghasilan_ayah') == '> Rp 5.000.000' ? 'selected' : '' ?>>> Rp 5.000.000</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Nomor HP Ayah</label>
                        <input type="text" name="nomor_hp_ayah" class="form-control" value="<?= old('nomor_hp_ayah') ?>" placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <!-- Data Ibu -->
                <h6 class="text-secondary mb-3 border-bottom pb-2"><i class="fas fa-female me-2"></i> Data Ibu Kandung</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Ibu <span class="text-danger">*</span></label>
                        <input type="text" name="nama_ibu" class="form-control" value="<?= old('nama_ibu') ?>" placeholder="Nama lengkap ibu" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NIK Ibu</label>
                        <input type="text" name="nik_ibu" class="form-control" value="<?= old('nik_ibu') ?>" maxlength="16" placeholder="16 digit NIK ibu">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Pendidikan Ibu</label>
                        <select name="pendidikan_ibu" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="SD/Sederajat" <?= old('pendidikan_ibu') == 'SD/Sederajat' ? 'selected' : '' ?>>SD/Sederajat</option>
                            <option value="SMP/Sederajat" <?= old('pendidikan_ibu') == 'SMP/Sederajat' ? 'selected' : '' ?>>SMP/Sederajat</option>
                            <option value="SMA/Sederajat" <?= old('pendidikan_ibu') == 'SMA/Sederajat' ? 'selected' : '' ?>>SMA/Sederajat</option>
                            <option value="D1/D2/D3" <?= old('pendidikan_ibu') == 'D1/D2/D3' ? 'selected' : '' ?>>D1/D2/D3</option>
                            <option value="S1" <?= old('pendidikan_ibu') == 'S1' ? 'selected' : '' ?>>S1</option>
                            <option value="S2" <?= old('pendidikan_ibu') == 'S2' ? 'selected' : '' ?>>S2</option>
                            <option value="S3" <?= old('pendidikan_ibu') == 'S3' ? 'selected' : '' ?>>S3</option>
                            <option value="Tidak Sekolah" <?= old('pendidikan_ibu') == 'Tidak Sekolah' ? 'selected' : '' ?>>Tidak Sekolah</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" class="form-control" value="<?= old('pekerjaan_ibu') ?>" placeholder="Contoh: Ibu Rumah Tangga">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Penghasilan Ibu</label>
                        <select name="penghasilan_ibu" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="< Rp 1.000.000" <?= old('penghasilan_ibu') == '< Rp 1.000.000' ? 'selected' : '' ?>>< Rp 1.000.000</option>
                            <option value="Rp 1.000.000 - Rp 2.000.000" <?= old('penghasilan_ibu') == 'Rp 1.000.000 - Rp 2.000.000' ? 'selected' : '' ?>>Rp 1.000.000 - Rp 2.000.000</option>
                            <option value="Rp 2.000.000 - Rp 3.000.000" <?= old('penghasilan_ibu') == 'Rp 2.000.000 - Rp 3.000.000' ? 'selected' : '' ?>>Rp 2.000.000 - Rp 3.000.000</option>
                            <option value="Rp 3.000.000 - Rp 5.000.000" <?= old('penghasilan_ibu') == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' ?>>Rp 3.000.000 - Rp 5.000.000</option>
                            <option value="> Rp 5.000.000" <?= old('penghasilan_ibu') == '> Rp 5.000.000' ? 'selected' : '' ?>>> Rp 5.000.000</option>
                            <option value="Tidak Berpenghasilan" <?= old('penghasilan_ibu') == 'Tidak Berpenghasilan' ? 'selected' : '' ?>>Tidak Berpenghasilan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Nomor HP Ibu</label>
                        <input type="text" name="nomor_hp_ibu" class="form-control" value="<?= old('nomor_hp_ibu') ?>" placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <!-- Data Wali -->
                <h6 class="text-secondary mb-3 border-bottom pb-2"><i class="fas fa-user-shield me-2"></i> Data Wali (Jika Tinggal dengan Wali)</h6>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nama Wali</label>
                        <input type="text" name="nama_wali" class="form-control" value="<?= old('nama_wali') ?>" placeholder="Nama lengkap wali">
                        <small class="text-muted">Kosongkan jika tinggal dengan orang tua</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Hubungan dengan Wali</label>
                        <input type="text" name="hubungan_wali" class="form-control" value="<?= old('hubungan_wali') ?>" placeholder="Contoh: Paman, Bibi, Kakek">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nomor HP Wali</label>
                        <input type="text" name="nomor_hp_wali" class="form-control" value="<?= old('nomor_hp_wali') ?>" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Data Sekolah & Nilai -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-primary"><i class="fas fa-school me-2"></i> Data Sekolah & Nilai</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Asal Sekolah <span class="text-danger">*</span></label>
                        <input type="text" name="asal_sekolah" class="form-control" value="<?= old('asal_sekolah') ?>" placeholder="Nama sekolah asal" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">NPSN Sekolah</label>
                        <input type="text" name="npsn_sekolah_asal" class="form-control" value="<?= old('npsn_sekolah_asal') ?>" maxlength="8" placeholder="8 digit NPSN">
                        <small class="text-muted">Opsional</small>
                    </div>
                </div>

                <!-- Nilai Rapor dan UN -->
                <h6 class="text-secondary mb-3 border-bottom pb-2"><i class="fas fa-file-alt me-2"></i> Nilai Rapor & UN</h6>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Nilai Rata-rata Rapor</label>
                        <input type="number" step="0.01" name="nilai_rata_rata" class="form-control" value="<?= old('nilai_rata_rata') ?>" placeholder="0.00" min="0" max="100">
                        <small class="text-muted">Nilai rata-rata rapor semester 1-5</small>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">UN Bahasa Indonesia</label>
                        <input type="number" step="0.01" name="nilai_un_indo" class="form-control" value="<?= old('nilai_un_indo') ?>" placeholder="0.00" min="0" max="100">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">UN Matematika</label>
                        <input type="number" step="0.01" name="nilai_un_math" class="form-control" value="<?= old('nilai_un_math') ?>" placeholder="0.00" min="0" max="100">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">UN Bahasa Inggris</label>
                        <input type="number" step="0.01" name="nilai_un_english" class="form-control" value="<?= old('nilai_un_english') ?>" placeholder="0.00" min="0" max="100">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">UN IPA</label>
                        <input type="number" step="0.01" name="nilai_un_science" class="form-control" value="<?= old('nilai_un_science') ?>" placeholder="0.00" min="0" max="100">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jurusan yang Dipilih <span class="text-danger">*</span></label>
                        <select name="jurusan_id" class="form-select" required>
                            <option value="">-- Pilih Jurusan --</option>
                            <?php if (isset($majors) && is_array($majors)): ?>
                                <?php foreach ($majors as $major): ?>
                                    <option value="<?= $major['id'] ?>" <?= old('jurusan_id') == $major['id'] ? 'selected' : '' ?>>
                                        <?= esc($major['nama_jurusan']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Hobi</label>
                        <select name="hobbies[]" class="form-select">
                            <option value="">-- Pilih Hobi (Opsional) --</option>
                            <?php if (isset($hobbies) && is_array($hobbies)): ?>
                                <?php foreach ($hobbies as $hobby): ?>
                                    <option value="<?= $hobby['id'] ?>" <?= old('hobbies') == $hobby['id'] ? 'selected' : '' ?>>
                                        <?= esc($hobby['nama_hobi']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5: Prestasi & Kebutuhan Khusus -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-primary"><i class="fas fa-trophy me-2"></i> Prestasi & Kebutuhan Khusus</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prestasi Akademik</label>
                        <textarea name="prestasi_akademik" class="form-control" rows="3" placeholder="Sebutkan prestasi akademik (jika ada)&#10;Contoh: Juara 1 Olimpiade Matematika tingkat kabupaten"><?= old('prestasi_akademik') ?></textarea>
                        <small class="text-muted">Kosongkan jika tidak ada</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prestasi Non-Akademik</label>
                        <textarea name="prestasi_non_akademik" class="form-control" rows="3" placeholder="Sebutkan prestasi non-akademik (jika ada)&#10;Contoh: Juara 1 Futsal antar sekolah"><?= old('prestasi_non_akademik') ?></textarea>
                        <small class="text-muted">Kosongkan jika tidak ada</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kelainan Fisik / Disabilitas</label>
                        <input type="text" name="kelainan_fisik" class="form-control" value="<?= old('kelainan_fisik') ?>" placeholder="Sebutkan jika ada (Contoh: Tunanetra, Tunarungu)">
                        <small class="text-muted">Kosongkan jika tidak ada</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kebutuhan Khusus Lainnya</label>
                        <input type="text" name="kebutuhan_khusus_lainnya" class="form-control" value="<?= old('kebutuhan_khusus_lainnya') ?>" placeholder="Sebutkan kebutuhan khusus lainnya">
                        <small class="text-muted">Misalnya: alergi, penyakit tertentu</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Field bertanda <span class="text-danger fw-bold">*</span> wajib diisi
                    </small>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('panitia/daftar-siswa') ?>" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Data Siswa
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
<?= $this->endSection(); ?>
