<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Edit Data<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
            <div class="card">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Edit Data Pendaftaran</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif; ?>

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

                    <form method="post">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="full_name"
                                    value="<?= $applicant['full_name']; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="date_of_birth"
                                    value="<?= $applicant['date_of_birth']; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="gender" required>
                                    <option value="laki-laki" <?= $applicant['gender'] === 'laki-laki' ? 'selected' : ''; ?>>
                                        Laki-laki
                                    </option>
                                    <option value="perempuan" <?= $applicant['gender'] === 'perempuan' ? 'selected' : ''; ?>>
                                        Perempuan
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" name="phone"
                                    value="<?= $applicant['phone']; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="form-control" name="address"
                                    value="<?= $applicant['address']; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kota</label>
                                <input type="text" class="form-control" name="city"
                                    value="<?= $applicant['city']; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="text" class="form-control" name="province"
                                    value="<?= $applicant['province']; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" name="postal_code"
                                    value="<?= $applicant['postal_code']; ?>" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Asal Sekolah</label>
                                <input type="text" class="form-control" name="school_origin"
                                    value="<?= $applicant['school_origin']; ?>" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">IPK / Nilai Rata-rata</label>
                                <input type="number" class="form-control" name="gpa" step="0.01" min="0"
                                    max="4" value="<?= $applicant['gpa']; ?>" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan Perubahan
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
