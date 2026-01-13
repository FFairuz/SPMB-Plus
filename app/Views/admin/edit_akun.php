<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-4 py-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">
                <i class="fas fa-user-edit me-2"></i>Edit Akun User
            </h2>
            <p class="text-muted small">Update informasi user: <strong><?= htmlspecialchars($user['username']) ?></strong></p>
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
                    <form action="<?= base_url('admin/edit-akun/' . $user['id']) ?>" method="POST">
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
                                value="<?= old('username', $user['username']) ?>"
                                required>
                            <small class="text-muted">Min 3 karakter</small>
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
                                value="<?= old('email', $user['email']) ?>"
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
                                value="<?= old('nama', $user['nama']) ?>"
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
                                <option value="admin" <?= (old('role', $user['role']) === 'admin') ? 'selected' : '' ?>>
                                    Admin - Kelola Pembayaran & Aplikasi
                                </option>
                                <option value="panitia" <?= (old('role', $user['role']) === 'panitia') ? 'selected' : '' ?>>
                                    Panitia - Kelola Data Siswa
                                </option>
                                <option value="bendahara" <?= (old('role', $user['role']) === 'bendahara') ? 'selected' : '' ?>>
                                    Bendahara - Verifikasi & Kwitansi
                                </option>
                                <option value="applicant" <?= (old('role', $user['role']) === 'applicant') ? 'selected' : '' ?>>
                                    Applicant - Calon Siswa
                                </option>
                            </select>
                        </div>

                        <!-- Section: Password (Optional) -->
                        <h5 class="mb-3 pb-3 border-bottom mt-4">
                            <i class="fas fa-lock me-2 text-primary"></i>Password
                            <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small>
                        </h5>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">
                                Password Baru
                            </label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Kosongkan jika tidak ingin mengubah">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Min 6 karakter</small>
                        </div>

                        <!-- Password Confirm -->
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label fw-bold">
                                Konfirmasi Password Baru
                            </label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                                    id="password_confirm" 
                                    name="password_confirm" 
                                    placeholder="Ketik ulang password baru">
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
                                    <?= (old('is_active', $user['is_active']) == '1') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_active">
                                    <strong>User Aktif</strong>
                                    <br>
                                    <small class="text-muted">User dapat login jika status aktif</small>
                                </label>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Informasi Sistem:</strong>
                            <ul class="mb-0 mt-2">
                                <li>User dibuat: <?= date('d M Y H:i', strtotime($user['created_at'])) ?></li>
                                <li>Terakhir update: <?= date('d M Y H:i', strtotime($user['updated_at'])) ?></li>
                            </ul>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
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
                        <li class="mb-2">Ubah username dan email dengan hati-hati</li>
                        <li class="mb-2">Perubahan role akan berpengaruh ke akses menu</li>
                        <li class="mb-2">Kosongkan password jika tidak ingin mengubahnya</li>
                        <li>Nonaktifkan user jika sudah tidak perlu login</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">
                        <i class="fas fa-user-circle me-2 text-primary"></i>User Info
                    </h6>
                    <table class="small mb-0 w-100">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td class="fw-bold text-end"><?= $user['id'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Username:</td>
                            <td class="fw-bold text-end"><?= htmlspecialchars($user['username']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Role:</td>
                            <td class="text-end">
                                <span class="badge bg-secondary"><?= $user['role'] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status:</td>
                            <td class="text-end">
                                <?php if ($user['is_active']): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
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
</script>

<?= $this->endSection() ?>
