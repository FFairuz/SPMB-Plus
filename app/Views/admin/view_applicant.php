<?= $this->extend('layout/app') ?>

<?= $this->section('content'); ?>

<a href="/admin/applicants" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <h2 class="mb-4"><?= $applicant['full_name']; ?></h2>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted mb-3">Nomor Registrasi</h6>
                            <p class="fs-5 fw-bold"><?= $applicant['nomor_pendaftaran'] ?? 'N/A'; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted mb-3">Email</h6>
                            <p class="fs-5"><?= $applicant['email']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Data Pribadi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Tanggal Lahir:</strong>
                            <p><?= date('d-m-Y', strtotime($applicant['date_of_birth'])); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Jenis Kelamin:</strong>
                            <p><?= ucfirst($applicant['gender']); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Telepon:</strong>
                            <p><?= $applicant['phone']; ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Alamat:</strong>
                            <p><?= $applicant['address']; ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Kota:</strong>
                            <p><?= $applicant['city']; ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Provinsi:</strong>
                            <p><?= $applicant['province']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Data Akademik</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Asal Sekolah:</strong>
                            <p><?= $applicant['school_origin']; ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>IPK:</strong>
                            <p><?= number_format($applicant['gpa'], 2, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Status Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Ubah Status</label>
                        <form method="post" action="/admin/applicants/<?= $applicant['id']; ?>/status"
                            class="d-flex gap-2">
                            <select class="form-select" name="status" required>
                                <option value="pending" <?= $applicant['status'] === 'pending' ? 'selected' : ''; ?>>
                                    Menunggu Verifikasi
                                </option>
                                <option value="verified" <?= $applicant['status'] === 'verified' ? 'selected' : ''; ?>>
                                    Terverifikasi
                                </option>
                                <option value="accepted" <?= $applicant['status'] === 'accepted' ? 'selected' : ''; ?>>
                                    Diterima
                                </option>
                                <option value="rejected" <?= $applicant['status'] === 'rejected' ? 'selected' : ''; ?>>
                                    Ditolak
                                </option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check"></i> Simpan
                            </button>
                        </form>
                    </div>

                    <p class="text-muted mb-0">
                        Status saat ini: <strong class="badge badge-status status-<?= strtolower($applicant['status']); ?>">
                            <?php
                            $status_label = [
                                'pending' => 'Menunggu Verifikasi',
                                'verified' => 'Terverifikasi',
                                'accepted' => 'Diterima',
                                'rejected' => 'Ditolak',
                            ];
                            echo $status_label[$applicant['status']] ?? $applicant['status'];
                            ?>
                        </strong>
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Dokumen</h5>
                </div>
                <div class="card-body">
                    <?php if ($applicant['documents_uploaded']): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> Semua dokumen telah diupload
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> Dokumen belum lengkap
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

<?= $this->endSection(); ?>
