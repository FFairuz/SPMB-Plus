<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Register - PPDB<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Header -->
            <div class="text-center mb-4">
                <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-person-plus" style="font-size: 2.5rem; color: white;"></i>
                </div>
                <h1 class="h3 fw-700">Daftar Akun Baru</h1>
                <p class="text-muted">Bergabunglah dengan PPDB kami</p>
            </div>

            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle-fill"></i> <strong>Ada kesalahan:</strong>
                            <ul class="mb-0 mt-2 ms-3">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle-fill"></i> 
                            <span><?= session()->getFlashdata('error'); ?></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" class="needs-validation">
                        <div class="mb-4">
                            <label for="username" class="form-label">
                                <i class="bi bi-person"></i> Username
                            </label>
                            <input type="text" class="form-control form-control-lg" id="username" name="username" 
                                   value="<?= old('username'); ?>" placeholder="username123" required>
                            <small class="form-text text-muted">Min 3 karakter, hanya huruf dan angka</small>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                   value="<?= old('email'); ?>" placeholder="your@email.com" required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="bi bi-key"></i> Password
                            </label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" 
                                   placeholder="••••••••" required>
                            <small class="form-text text-muted">Min 6 karakter, gunakan kombinasi karakter unik</small>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirm" class="form-label">
                                <i class="bi bi-key-fill"></i> Konfirmasi Password
                            </label>
                            <input type="password" class="form-control form-control-lg" id="password_confirm" 
                                   name="password_confirm" placeholder="••••••••" required>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="mb-4">
                            <div class="password-strength">
                                <div class="strength-bar" id="strengthBar" style="height: 4px; background: #e0e0e0; border-radius: 2px; overflow: hidden;">
                                    <div class="strength-fill" id="strengthFill" style="height: 100%; width: 0%; background: #dc3545; transition: width 0.3s, background 0.3s;"></div>
                                </div>
                                <small id="strengthText" class="form-text text-muted mt-1">Kekuatan: -</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100 mb-4">
                            <i class="bi bi-person-check"></i> Daftar Sekarang
                        </button>
                    </form>

                    <div class="d-grid gap-3">
                        <hr class="my-2">
                        <p class="text-center mb-0">
                            <small class="text-muted">Sudah punya akun?</small><br>
                            <a href="/auth/login" class="btn btn-link btn-sm fw-bold text-decoration-none">
                                Masuk ke Akun Anda
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="mt-4 p-4 bg-info bg-opacity-10 border border-info border-opacity-25 rounded-3">
                <small class="text-dark">
                    <i class="bi bi-info-circle"></i> <strong>Perhatian:</strong> 
                    Pastikan data yang Anda daftarkan benar dan sesuai dengan dokumen. 
                    Data tidak bisa diubah setelah submission.
                </small>
            </div>
        </div>
    </div>
</div>

<script>
    // Password strength indicator
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');
        let strength = 0;
        let strengthLabel = 'Lemah';
        let strengthColor = '#dc3545';

        if (password.length >= 6) strength++;
        if (password.length >= 10) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;

        if (strength <= 2) {
            strengthLabel = 'Lemah';
            strengthColor = '#dc3545';
        } else if (strength <= 3) {
            strengthLabel = 'Cukup';
            strengthColor = '#ffc107';
        } else {
            strengthLabel = 'Kuat';
            strengthColor = '#28a745';
        }

        strengthFill.style.width = (strength * 20) + '%';
        strengthFill.style.background = strengthColor;
        strengthText.textContent = 'Kekuatan: ' + strengthLabel;
    });
</script>

<style>
    .btn-link {
        color: #0d6efd;
    }
    .btn-link:hover {
        color: #0b5ed7;
    }
</style>
<?= $this->endSection(); ?>
