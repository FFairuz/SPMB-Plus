<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Tambah Siswa Baru<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<h2 class="mb-3">
    <i class="bi bi-person-plus"></i> Tambah Siswa Baru
</h2>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="post" action="<?= current_url() ?>" class="card border-0 shadow-sm p-4">
        <?= csrf_field(); ?>

        <!-- Data Dasar -->
        <h5 class="mb-3 border-bottom pb-2">
            <i class="bi bi-info-circle"></i> Data Dasar
        </h5>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">NIK *</label>
                <input type="text" name="nik" class="form-control <?= $validation && $validation->hasError('nik') ? 'is-invalid' : ''; ?>" 
                       placeholder="16 digit NIK" value="<?= old('nik'); ?>" required>
                <?php if ($validation && $validation->hasError('nik')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('nik'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" class="form-control <?= $validation && $validation->hasError('nama_lengkap') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama lengkap siswa" value="<?= old('nama_lengkap'); ?>" required>
                <?php if ($validation && $validation->hasError('nama_lengkap')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('nama_lengkap'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Jenis Kelamin *</label>
                <select name="jenis_kelamin" class="form-select <?= $validation && $validation->hasError('jenis_kelamin') ? 'is-invalid' : ''; ?>" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="laki-laki" <?= old('jenis_kelamin') === 'laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="perempuan" <?= old('jenis_kelamin') === 'perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
                <?php if ($validation && $validation->hasError('jenis_kelamin')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('jenis_kelamin'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Tanggal Lahir *</label>
                <input type="date" name="tanggal_lahir" class="form-control <?= $validation && $validation->hasError('tanggal_lahir') ? 'is-invalid' : ''; ?>" 
                       value="<?= old('tanggal_lahir'); ?>" required>
                <?php if ($validation && $validation->hasError('tanggal_lahir')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('tanggal_lahir'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Tempat Lahir *</label>
                <input type="text" name="tempat_lahir" class="form-control <?= $validation && $validation->hasError('tempat_lahir') ? 'is-invalid' : ''; ?>" 
                       placeholder="Kota/Kabupaten tempat lahir" value="<?= old('tempat_lahir'); ?>" required>
                <?php if ($validation && $validation->hasError('tempat_lahir')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('tempat_lahir'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Agama *</label>
                <select name="agama" class="form-select <?= $validation && $validation->hasError('agama') ? 'is-invalid' : ''; ?>" required>
                    <option value="">Pilih Agama</option>
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
                        <?= $validation->getError('agama'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Data Keluarga -->
        <h5 class="mb-3 border-bottom pb-2 mt-5">
            <i class="bi bi-people"></i> Data Keluarga
        </h5>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Anak Ke- *</label>
                <input type="number" name="anak_ke" class="form-control <?= $validation && $validation->hasError('anak_ke') ? 'is-invalid' : ''; ?>" 
                       placeholder="1, 2, 3, ..." value="<?= old('anak_ke'); ?>" required>
                <?php if ($validation && $validation->hasError('anak_ke')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('anak_ke'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Jumlah Saudara *</label>
                <input type="number" name="jumlah_saudara" class="form-control <?= $validation && $validation->hasError('jumlah_saudara') ? 'is-invalid' : ''; ?>" 
                       placeholder="0, 1, 2, ..." value="<?= old('jumlah_saudara'); ?>" required>
                <?php if ($validation && $validation->hasError('jumlah_saudara')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('jumlah_saudara'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Alamat -->
        <h5 class="mb-3 border-bottom pb-2 mt-5">
            <i class="bi bi-geo-alt"></i> Alamat
        </h5>

        <div class="mb-3">
            <label class="form-label fw-bold">Alamat Jalan *</label>
            <input type="text" name="alamat_jalan" class="form-control <?= $validation && $validation->hasError('alamat_jalan') ? 'is-invalid' : ''; ?>" 
                   placeholder="Nama jalan, nomor rumah, RT/RW" value="<?= old('alamat_jalan'); ?>" required>
            <?php if ($validation && $validation->hasError('alamat_jalan')): ?>
                <div class="invalid-feedback d-block">
                    <?= $validation->getError('alamat_jalan'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Dusun</label>
                <input type="text" name="dusun" class="form-control" placeholder="Nama dusun" value="<?= old('dusun'); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Kelurahan *</label>
                <input type="text" name="kelurahan" class="form-control <?= $validation && $validation->hasError('kelurahan') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama kelurahan" value="<?= old('kelurahan'); ?>" required>
                <?php if ($validation && $validation->hasError('kelurahan')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('kelurahan'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Kecamatan *</label>
                <input type="text" name="kecamatan" class="form-control <?= $validation && $validation->hasError('kecamatan') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama kecamatan" value="<?= old('kecamatan'); ?>" required>
                <?php if ($validation && $validation->hasError('kecamatan')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('kecamatan'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Kabupaten *</label>
                <input type="text" name="kabupaten" class="form-control <?= $validation && $validation->hasError('kabupaten') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama kabupaten" value="<?= old('kabupaten'); ?>" required>
                <?php if ($validation && $validation->hasError('kabupaten')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('kabupaten'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Provinsi *</label>
                <input type="text" name="provinsi" class="form-control <?= $validation && $validation->hasError('provinsi') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama provinsi" value="<?= old('provinsi'); ?>" required>
                <?php if ($validation && $validation->hasError('provinsi')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('provinsi'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Kode Pos *</label>
                <input type="text" name="kode_pos" class="form-control <?= $validation && $validation->hasError('kode_pos') ? 'is-invalid' : ''; ?>" 
                       placeholder="5 digit kode pos" value="<?= old('kode_pos'); ?>" required>
                <?php if ($validation && $validation->hasError('kode_pos')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('kode_pos'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kontak -->
        <h5 class="mb-3 border-bottom pb-2 mt-5">
            <i class="bi bi-telephone"></i> Kontak
        </h5>

        <div class="mb-3">
            <label class="form-label fw-bold">Nomor HP *</label>
            <input type="text" name="nomor_hp" class="form-control <?= $validation && $validation->hasError('nomor_hp') ? 'is-invalid' : ''; ?>" 
                   placeholder="Nomor HP aktif (10-13 digit)" value="<?= old('nomor_hp'); ?>" required>
            <?php if ($validation && $validation->hasError('nomor_hp')): ?>
                <div class="invalid-feedback d-block">
                    <?= $validation->getError('nomor_hp'); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sekolah Asal -->
        <h5 class="mb-3 border-bottom pb-2 mt-5">
            <i class="bi bi-book"></i> Asal Sekolah
        </h5>

        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label fw-bold">Nama Sekolah Asal *</label>
                <div class="input-group">
                    <select name="asal_sekolah" id="school_select" class="form-select <?= $validation && $validation->hasError('asal_sekolah') ? 'is-invalid' : ''; ?>" required>
                        <option value="">-- Pilih Sekolah --</option>
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
                        <?= $validation->getError('asal_sekolah'); ?>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="npsn_sekolah_asal" id="npsn_hidden" value="<?= old('npsn_sekolah_asal'); ?>">
                <small class="text-muted">NPSN akan terisi otomatis dari data sekolah</small>
            </div>
        </div>


        <!-- Data Orang Tua -->
        <h5 class="mb-3 border-bottom pb-2 mt-5">
            <i class="bi bi-person-badge"></i> Data Orang Tua
        </h5>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Nama Ayah *</label>
                <input type="text" name="nama_ayah" class="form-control <?= $validation && $validation->hasError('nama_ayah') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama lengkap ayah" value="<?= old('nama_ayah'); ?>" required>
                <?php if ($validation && $validation->hasError('nama_ayah')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('nama_ayah'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Nama Ibu *</label>
                <input type="text" name="nama_ibu" class="form-control <?= $validation && $validation->hasError('nama_ibu') ? 'is-invalid' : ''; ?>" 
                       placeholder="Nama lengkap ibu" value="<?= old('nama_ibu'); ?>" required>
                <?php if ($validation && $validation->hasError('nama_ibu')): ?>
                    <div class="invalid-feedback d-block">
                        <?= $validation->getError('nama_ibu'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="row mt-5">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-lg me-2">
                    <i class="bi bi-check-circle"></i> Simpan Data
                </button>
                <a href="/panitia/daftar-siswa" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </div>
    </form>

<!-- Modal Tambah Sekolah -->
<div class="modal fade" id="addSchoolModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-building"></i> Tambah Asal Sekolah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="schoolForm">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Tambahkan data sekolah baru. Data tidak akan hilang dari form utama.
                    </div>
                    <div id="schoolFormError" class="alert alert-danger d-none"></div>
                    <div id="schoolFormSuccess" class="alert alert-success d-none"></div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Sekolah *</label>
                        <input type="text" name="nama" id="school_nama" class="form-control" placeholder="Contoh: SMP Negeri 1 Jakarta" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NPSN</label>
                            <input type="text" name="npsn" id="school_npsn" class="form-control" placeholder="8 digit NPSN (opsional)" maxlength="20">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kota/Kabupaten *</label>
                            <input type="text" name="kota" id="school_kota" class="form-control" placeholder="Contoh: Jakarta Selatan" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Provinsi *</label>
                            <input type="text" name="provinsi" id="school_provinsi" class="form-control" placeholder="Contoh: DKI Jakarta" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <input type="text" name="alamat" id="school_alamat" class="form-control" placeholder="Alamat sekolah (opsional)">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
                <button type="button" class="btn btn-success" id="btnSaveSchool">
                    <i class="bi bi-check-circle"></i> Simpan Sekolah
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
