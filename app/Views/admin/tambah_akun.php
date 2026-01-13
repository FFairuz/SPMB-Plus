<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-4 py-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">
                <i class="fas fa-user-plus me-2"></i>Tambah Akun User Baru
            </h2>
            <p class="text-muted small">Isi form di bawah untuk membuat akun user baru</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/kelola-akun') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="<?= base_url('admin/tambah-akun') ?>" method="POST">
                        <?= csrf_field() ?>

                        <!-- Error Messages -->
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h5 class="alert-heading">
                                    <i class="fas fa-exclamation-circle me-2"></i>Validasi Gagal
                                </h5>
                                <ul class="mb-0">
                                    <?php foreach ($errors as $field => $error): ?>
                                        <li><?= ucfirst(str_replace('_', ' ', $field)) ?>: <?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Section: Informasi Dasar -->
                        <h5 class="mb-3 pb-3 border-bottom">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Informasi Dasar
                        </h5>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">
                                Username <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                                id="username" 
                                name="username" 
                                placeholder="username123"
                                value="<?= old('username', $old['username'] ?? '') ?>"
                                required>
                            <small class="text-muted">Min 3 karakter, hanya huruf, angka, underscore</small>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="email" 
                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                id="email" 
                                name="email" 
                                placeholder="user@example.com"
                                value="<?= old('email', $old['email'] ?? '') ?>"
                                required>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" 
                                id="nama" 
                                name="nama" 
                                placeholder="Nama Lengkap"
                                value="<?= old('nama', $old['nama'] ?? '') ?>"
                                required>
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold">
                                <i class="fas fa-shield-alt me-1"></i>Role/Jabatan <span class="text-danger">*</span>
                            </label>
                            <select 
                                class="form-select <?= isset($errors['role']) ? 'is-invalid' : '' ?>" 
                                id="role" 
                                name="role" 
                                required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" <?= (old('role', $old['role'] ?? '') === 'admin') ? 'selected' : '' ?>>
                                    Admin - Kelola Pembayaran & Aplikasi
                                </option>
                                <option value="panitia" <?= (old('role', $old['role'] ?? '') === 'panitia') ? 'selected' : '' ?>>
                                    Panitia - Kelola Data Siswa
                                </option>
                                <option value="bendahara" <?= (old('role', $old['role'] ?? '') === 'bendahara') ? 'selected' : '' ?>>
                                    Bendahara - Verifikasi & Kwitansi
                                </option>
                                <option value="applicant" <?= (old('role', $old['role'] ?? '') === 'applicant') ? 'selected' : '' ?>>
                                    Applicant - Calon Siswa
                                </option>
                            </select>
                            <small class="text-muted d-block mt-2" id="roleDescription"></small>
                        </div>

                        <!-- Section: Password -->
                        <h5 class="mb-3 pb-3 border-bottom mt-4">
                            <i class="fas fa-lock me-2 text-primary"></i>Password
                        </h5>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Masukkan password (min 6 karakter)"
                                    required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Min 6 karakter</small>
                        </div>

                        <!-- Password Confirm -->
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label fw-bold">
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                                    id="password_confirm" 
                                    name="password_confirm" 
                                    placeholder="Ketik ulang password"
                                    required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Section: Opsi Lainnya -->
                        <h5 class="mb-3 pb-3 border-bottom mt-4">
                            <i class="fas fa-cog me-2 text-primary"></i>Opsi Lainnya
                        </h5>

                        <!-- Status Aktif -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    id="is_active" 
                                    name="is_active" 
                                    value="1"
                                    <?= (old('is_active', $old['is_active'] ?? '1') == '1') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_active">
                                    <strong>User Aktif</strong>
                                    <br>
                                    <small class="text-muted">User dapat login jika status aktif</small>
                                </label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan User Baru
                            </button>
                            <a href="<?= base_url('admin/kelola-akun') ?>" class="btn btn-secondary btn-lg ms-2">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="col-lg-4">
            <div class="card shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">
                        <i class="fas fa-lightbulb me-2 text-warning"></i>Tips
                    </h6>
                    <ul class="small mb-0">
                        <li class="mb-2">Username harus unik dan tidak boleh sama dengan user lain</li>
                        <li class="mb-2">Email juga harus unik dan valid</li>
                        <li class="mb-2">Pilih role sesuai dengan tanggung jawab user</li>
                        <li class="mb-2">Password minimal 6 karakter</li>
                        <li>Pastikan user aktif agar dapat login</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">
                        <i class="fas fa-info-circle me-2 text-info"></i>Penjelasan Role
                    </h6>
                    <div id="roleDescriptionPanel">
                        <small class="text-muted">Pilih role di atas untuk melihat penjelasannya</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const input = document.getElementById('password');
    const icon = this.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
    const input = document.getElementById('password_confirm');
    const icon = this.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Role descriptions
const roleDescriptions = {
    'admin': '<strong>Administrator</strong><br>Mengelola pembayaran, aplikasi, dan user system.',
    'panitia': '<strong>Panitia</strong><br>Mengelola data calon siswa dan monitoring status.',
    'bendahara': '<strong>Bendahara</strong><br>Verifikasi pembayaran dan cetak kwitansi.',
    'applicant': '<strong>Applicant</strong><br>Calon siswa yang mendaftar dan membayar.',
    '': '<small class="text-muted">Pilih role di atas</small>'
};

document.getElementById('role').addEventListener('change', function() {
    const description = roleDescriptions[this.value] || '';
    document.getElementById('roleDescriptionPanel').innerHTML = description;
});
</script>

<?= $this->endSection() ?>
