<?= $this->extend('layout/app') ?>

<?= $this->section('content'); ?>

<!-- Header -->
<div class="mb-4">
                <a href="/admin/applicants" class="btn btn-outline-primary btn-sm mb-3">
                    <i class="bi bi-chevron-left"></i> Kembali ke Daftar Pendaftar
                </a>
                <h2 class="mb-1">👤 Tambah Pendaftar Baru</h2>
                <p class="text-muted">Admin dapat mendaftarkan pendaftar baru dengan mengisi form di bawah ini</p>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle-fill"></i> <strong>Terjadi Kesalahan!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <ul class="mb-0 mt-2 ps-3">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="/admin/applicant-register" method="post">
                        <!-- Section 1: Account Info -->
                        <div class="mb-4">
                            <h6 class="mb-3 pb-2 border-bottom">
                                <i class="bi bi-shield-lock"></i> Informasi Akun
                            </h6>

                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="bi bi-person-fill"></i> Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg" id="username" 
                                       name="username" placeholder="username (tanpa spasi)" 
                                       value="<?= old('username'); ?>" required>
                                <small class="text-muted">Minimal 3 karakter, tanpa spasi</small>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope"></i> Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control form-control-lg" id="email" 
                                       name="email" placeholder="email@example.com" 
                                       value="<?= old('email'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="bi bi-key"></i> Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control form-control-lg" id="password" 
                                       name="password" placeholder="Password (minimal 6 karakter)" required>
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>
                        </div>

                        <!-- Section 2: Personal Data -->
                        <div class="mb-4">
                            <h6 class="mb-3 pb-2 border-bottom">
                                <i class="bi bi-file-earmark-person"></i> Data Pribadi
                            </h6>

                            <div class="mb-3">
                                <label for="full_name" class="form-label">
                                    <i class="bi bi-person-fill"></i> Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg" id="full_name" 
                                       name="full_name" placeholder="Nama lengkap" 
                                       value="<?= old('full_name'); ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date_of_birth" class="form-label">
                                            <i class="bi bi-calendar"></i> Tanggal Lahir <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control form-control-lg" id="date_of_birth" 
                                               name="date_of_birth" value="<?= old('date_of_birth'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">
                                            <i class="bi bi-person"></i> Jenis Kelamin <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select form-select-lg" id="gender" name="gender" required>
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="laki-laki" <?= old('gender') === 'laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                            <option value="perempuan" <?= old('gender') === 'perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    <i class="bi bi-telephone"></i> Nomor Telepon <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control form-control-lg" id="phone" 
                                       name="phone" placeholder="08xxxxxxxxxx" 
                                       value="<?= old('phone'); ?>" required>
                            </div>
                        </div>

                        <!-- Section 3: Address -->
                        <div class="mb-4">
                            <h6 class="mb-3 pb-2 border-bottom">
                                <i class="bi bi-geo-alt"></i> Alamat
                            </h6>

                            <div class="mb-3">
                                <label for="address" class="form-label">
                                    <i class="bi bi-houses"></i> Alamat Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control form-control-lg" id="address" name="address" 
                                         rows="3" placeholder="Jalan, No. Rumah, RT/RW, Kelurahan..." required><?= old('address'); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">
                                            <i class="bi bi-geo-alt"></i> Kota/Kabupaten <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="city" 
                                               name="city" placeholder="Kota/Kabupaten" 
                                               value="<?= old('city'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="province" class="form-label">
                                            <i class="bi bi-geo-alt"></i> Provinsi <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="province" 
                                               name="province" placeholder="Provinsi" 
                                               value="<?= old('province'); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="postal_code" class="form-label">
                                    <i class="bi bi-mailbox"></i> Kode Pos <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg" id="postal_code" 
                                       name="postal_code" placeholder="Kode pos" 
                                       value="<?= old('postal_code'); ?>" required>
                            </div>
                        </div>

                        <!-- Section 4: Education -->
                        <div class="mb-4">
                            <h6 class="mb-3 pb-2 border-bottom">
                                <i class="bi bi-book"></i> Informasi Pendidikan
                            </h6>

                            <div class="mb-3">
                                <label for="school_origin" class="form-label">
                                    <i class="bi bi-building"></i> Asal Sekolah <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <select name="school_origin" id="school_select" class="form-select form-select-lg" required>
                                        <option value="">-- Pilih Sekolah --</option>
                                        <?php if (isset($schools) && !empty($schools)): ?>
                                            <?php foreach ($schools as $school): ?>
                                                <option value="<?= esc($school['nama']) ?>" <?= old('school_origin') === $school['nama'] ? 'selected' : ''; ?>>
                                                    <?= esc($school['nama']) ?> - <?= esc($school['kota']) ?>, <?= esc($school['provinsi']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                                        <i class="bi bi-plus-circle"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="gpa" class="form-label">
                                    <i class="bi bi-star"></i> Nilai Rata-rata (NR) <span class="text-danger">*</span>
                                </label>
                                <input type="number" step="0.01" class="form-control form-control-lg" id="gpa" 
                                       name="gpa" placeholder="0.00" 
                                       value="<?= old('gpa'); ?>" required>
                                <small class="text-muted">Contoh: 8.5, 9.0, dll</small>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-lg"></i> Simpan Data Pendaftar
                            </button>
                            <a href="/admin/applicants" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<!-- Modal Tambah Sekolah -->
<div class="modal fade" id="addSchoolModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-building"></i> Tambah Asal Sekolah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="schoolForm">
                    <div class="alert alert-info"><i class="bi bi-info-circle"></i> Data form utama tidak akan hilang.</div>
                    <div id="schoolFormError" class="alert alert-danger d-none"></div>
                    <div id="schoolFormSuccess" class="alert alert-success d-none"></div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Sekolah *</label>
                        <input type="text" name="nama" id="school_nama" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NPSN</label>
                            <input type="text" name="npsn" id="school_npsn" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kota *</label>
                            <input type="text" name="kota" id="school_kota" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Provinsi *</label>
                            <input type="text" name="provinsi" id="school_provinsi" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <input type="text" name="alamat" id="school_alamat" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Batal</button>
                <button type="button" class="btn btn-success" id="btnSaveSchool"><i class="bi bi-check-circle"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
function saveSchool() {
    const form = document.getElementById('schoolForm');
    const formData = new FormData(form);
    const btn = document.getElementById('btnSaveSchool');
    const errorDiv = document.getElementById('schoolFormError');
    const successDiv = document.getElementById('schoolFormSuccess');
    
    if (!document.getElementById('school_nama').value || !document.getElementById('school_kota').value || !document.getElementById('school_provinsi').value) {
        errorDiv.textContent = 'Nama, Kota, dan Provinsi harus diisi!';
        errorDiv.classList.remove('d-none');
        return;
    }
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    errorDiv.classList.add('d-none');
    successDiv.classList.add('d-none');
    
    fetch('<?= base_url('admin/ajax-add-school') ?>', {
        method: 'POST',
        body: formData,
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            successDiv.textContent = data.message;
            successDiv.classList.remove('d-none');
            const select = document.getElementById('school_select');
            const newOption = new Option(data.school.nama + ' - ' + data.school.kota + ', ' + data.school.provinsi, data.school.nama);
            select.add(newOption);
            select.value = data.school.nama;
            form.reset();
            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('addSchoolModal')).hide();
                successDiv.classList.add('d-none');
            }, 1500);
        } else {
            errorDiv.textContent = data.message || 'Gagal menyimpan';
            errorDiv.classList.remove('d-none');
        }
    })
    .catch(error => {
        errorDiv.textContent = 'Terjadi kesalahan koneksi';
        errorDiv.classList.remove('d-none');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-circle"></i> Simpan';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btnSaveSchool');
    if (btn) btn.addEventListener('click', saveSchool);
});
</script>

<?= $this->endSection(); ?>
