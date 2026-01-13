<?= $this->extend('layout/app'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-file-excel me-2"></i><?= $title; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Flash Messages -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('warning')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?= session()->getFlashdata('warning'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php $errors = session()->getFlashdata('import_errors'); ?>
                        <?php if (!empty($errors)): ?>
                            <div class="mt-3">
                                <strong>Detail Kesalahan:</strong>
                                <ul class="small mt-2">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Import Form -->
                    <form action="<?= base_url('admin/schools/process-import'); ?>" method="POST" enctype="multipart/form-data" id="importForm">
                        <?= csrf_field(); ?>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="excel_file" class="form-label fw-bold">Pilih File Excel</label>
                                <input type="file" class="form-control form-control-lg" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv" required>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Format yang diterima: .xlsx, .xls, atau .csv
                                </small>
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div class="alert alert-info" role="alert">
                            <h6 class="alert-heading">
                                <i class="fas fa-book me-2"></i>Panduan Format Excel
                            </h6>
                            <p class="mb-2">File Excel harus memiliki kolom dengan urutan berikut di baris pertama (header):</p>
                            <ol class="small mb-0">
                                <li><strong>Nama Sekolah</strong> - (Required)</li>
                                <li><strong>NPSN</strong> - Nomor Pokok Sekolah Nasional (Optional)</li>
                                <li><strong>Kota</strong> - (Required)</li>
                                <li><strong>Provinsi</strong> - (Required)</li>
                                <li><strong>Alamat</strong> - (Optional)</li>
                            </ol>
                        </div>

                        <!-- Download Template -->
                        <div class="mb-4">
                            <a href="<?= base_url('admin/schools/download-template'); ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-download me-2"></i>Download Template Excel
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-upload me-2"></i>Import Data Sekolah
                            </button>
                            <a href="<?= base_url('admin/schools'); ?>" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Tips -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-lightbulb me-2"></i>Tips & Trik
                    </h6>
                </div>
                <div class="card-body small">
                    <div class="mb-3">
                        <strong>✓ Pastikan:</strong>
                        <ul class="ps-3 mb-0 mt-2">
                            <li>Baris pertama adalah header</li>
                            <li>Nama sekolah dan kota belum terdaftar</li>
                            <li>Data tidak ada yang kosong untuk field required</li>
                            <li>Provinsi ditulis dengan benar</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <strong>⚠️ Perhatian:</strong>
                        <ul class="ps-3 mb-0 mt-2">
                            <li>Duplikasi nama sekolah di kota yang sama akan ditolak</li>
                            <li>Maksimal file 5MB</li>
                            <li>Jika ada error, lihat detail di notifikasi</li>
                        </ul>
                    </div>

                    <div>
                        <strong>💡 Contoh Data:</strong>
                        <table class="table table-sm mt-2 mb-0">
                            <thead>
                                <tr class="text-center">
                                    <td class="border-bottom">Nama</td>
                                    <td class="border-bottom">Kota</td>
                                    <td class="border-bottom">Provinsi</td>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td>SMA Negeri 1</td>
                                    <td>Jakarta</td>
                                    <td>DKI Jakarta</td>
                                </tr>
                                <tr>
                                    <td>SMA Negeri 2</td>
                                    <td>Bandung</td>
                                    <td>Jawa Barat</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: none;
    }
    
    .form-control-lg {
        border-radius: 0.5rem;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
    }
</style>
<?= $this->endSection(); ?>
