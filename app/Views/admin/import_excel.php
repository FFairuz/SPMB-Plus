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
                    <form action="<?= base_url('admin/process-import'); ?>" method="POST" enctype="multipart/form-data" id="importForm">
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
                                <li><strong>NIK</strong> - 16 digit (Required)</li>
                                <li><strong>Nama Lengkap</strong> - (Required)</li>
                                <li><strong>Jenis Kelamin</strong> - laki-laki/perempuan</li>
                                <li><strong>Tanggal Lahir</strong> - format YYYY-MM-DD</li>
                                <li><strong>Tempat Lahir</strong></li>
                                <li><strong>Agama</strong> - Islam, Kristen, Katolik, Hindu, Buddha, Konghucu, Lainnya</li>
                                <li><strong>Anak Ke</strong> - angka</li>
                                <li><strong>Jumlah Saudara</strong> - angka</li>
                                <li><strong>Alamat Jalan</strong></li>
                                <li><strong>Kelurahan</strong></li>
                                <li><strong>Kecamatan</strong></li>
                                <li><strong>Kabupaten</strong></li>
                                <li><strong>Provinsi</strong></li>
                                <li><strong>Kode Pos</strong> - 5 digit</li>
                                <li><strong>Nomor HP</strong> - (Required)</li>
                                <li><strong>Asal Sekolah</strong> - nama sekolah</li>
                                <li><strong>NPSN Sekolah Asal</strong> - (Optional)</li>
                                <li><strong>Nilai Rata-Rata</strong> - angka desimal</li>
                                <li><strong>Nama Ayah</strong></li>
                                <li><strong>Nama Ibu</strong></li>
                            </ol>
                        </div>

                        <!-- Download Template -->
                        <div class="mb-4">
                            <a href="<?= base_url('admin/download-template'); ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-download me-2"></i>Download Template Excel
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-upload me-2"></i>Import Data
                            </button>
                            <a href="<?= base_url('admin/applicants'); ?>" class="btn btn-secondary btn-lg">
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
                            <li>NIK belum terdaftar di sistem</li>
                            <li>Format tanggal: YYYY-MM-DD</li>
                            <li>Data tidak ada yang kosong untuk field required</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <strong>⚠️ Perhatian:</strong>
                        <ul class="ps-3 mb-0 mt-2">
                            <li>Duplikasi NIK akan ditolak</li>
                            <li>Maksimal file 5MB</li>
                            <li>Jika ada error, lihat detail di notifikasi</li>
                        </ul>
                    </div>

                    <div>
                        <strong>💡 Contoh Data:</strong>
                        <table class="table table-sm mt-2 mb-0">
                            <thead>
                                <tr class="text-center">
                                    <td class="border-bottom">NIK</td>
                                    <td class="border-bottom">Nama</td>
                                    <td class="border-bottom">HP</td>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td>1234567890123456</td>
                                    <td>Budi Santoso</td>
                                    <td>081234567890</td>
                                </tr>
                                <tr>
                                    <td>2345678901234567</td>
                                    <td>Siti Nurhaliza</td>
                                    <td>082345678901</td>
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
