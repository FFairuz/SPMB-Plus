<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Form Pendaftaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
            <div class="card">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Form Pendaftaran PPDB</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i> Ada kesalahan:
                            <ul class="mb-0 mt-2">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" class="needs-validation">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="full_name"
                                    value="<?= old('full_name'); ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="date_of_birth"
                                    value="<?= old('date_of_birth'); ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="gender" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="laki-laki" <?= old('gender') === 'laki-laki' ? 'selected' : ''; ?>>
                                        Laki-laki
                                    </option>
                                    <option value="perempuan" <?= old('gender') === 'perempuan' ? 'selected' : ''; ?>>
                                        Perempuan
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" name="phone"
                                    value="<?= old('phone'); ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="form-control" name="address"
                                    value="<?= old('address'); ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kota</label>
                                <input type="text" class="form-control" name="city"
                                    value="<?= old('city'); ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="text" class="form-control" name="province"
                                    value="<?= old('province'); ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" name="postal_code"
                                    value="<?= old('postal_code'); ?>" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Asal Sekolah</label>
                                <input type="text" class="form-control" name="school_origin"
                                    value="<?= old('school_origin'); ?>" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">IPK / Nilai Rata-rata</label>
                                <input type="number" class="form-control" name="gpa" step="0.01" min="0"
                                    max="4" value="<?= old('gpa'); ?>" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Daftar
                            </button>
                            <a href="/applicant/dashboard" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?= $this->endSection(); ?>
