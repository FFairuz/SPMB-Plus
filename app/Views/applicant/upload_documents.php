<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Upload Dokumen<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Upload Dokumen Pendaftaran</h4>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">
                        Silakan upload dokumen pendukung berikut untuk melengkapi proses pendaftaran:
                    </p>

                    <form method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="bi bi-file-earmark"></i> Akta Kelahiran
                                        </h6>
                                        <p class="text-muted small mb-3">
                                            Format: PDF, JPG, PNG (Max 5MB)
                                        </p>

                                        <?php if (isset($documents)): ?>
                                            <?php $birth_cert = array_filter($documents, fn($d) => $d['document_type'] === 'birth_certificate'); ?>
                                            <?php if (!empty($birth_cert)): ?>
                                                <div class="alert alert-success mb-3">
                                                    <i class="bi bi-check-circle"></i> Sudah diupload:
                                                    <?= reset($birth_cert)['file_name']; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <input type="file" class="form-control" name="files[birth_certificate]"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="bi bi-file-earmark"></i> Rapor Sekolah
                                        </h6>
                                        <p class="text-muted small mb-3">
                                            Format: PDF, JPG, PNG (Max 5MB)
                                        </p>

                                        <?php if (isset($documents)): ?>
                                            <?php $report = array_filter($documents, fn($d) => $d['document_type'] === 'report_card'); ?>
                                            <?php if (!empty($report)): ?>
                                                <div class="alert alert-success mb-3">
                                                    <i class="bi bi-check-circle"></i> Sudah diupload:
                                                    <?= reset($report)['file_name']; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <input type="file" class="form-control" name="files[report_card]"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="bi bi-file-earmark"></i> Kartu Identitas
                                        </h6>
                                        <p class="text-muted small mb-3">
                                            Format: PDF, JPG, PNG (Max 5MB)
                                        </p>

                                        <?php if (isset($documents)): ?>
                                            <?php $identity = array_filter($documents, fn($d) => $d['document_type'] === 'identity_card'); ?>
                                            <?php if (!empty($identity)): ?>
                                                <div class="alert alert-success mb-3">
                                                    <i class="bi bi-check-circle"></i> Sudah diupload:
                                                    <?= reset($identity)['file_name']; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <input type="file" class="form-control" name="files[identity_card]"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cloud-upload"></i> Upload Dokumen
                            </button>
                            <a href="/applicant/dashboard" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection(); ?>
