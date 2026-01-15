<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Manajemen Formulir<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-cogs text-primary"></i> Manajemen Formulir Pendaftaran</h3>
            <p class="text-muted mb-0">Kelola pengaturan formulir pendaftaran siswa baru</p>
        </div>
        <div>
            <a href="<?= base_url('admin/form-management/statistics') ?>" class="btn btn-info">
                <i class="fas fa-chart-bar me-1"></i> Statistik
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($debug_role_error) && $debug_role_error): ?>
        <div class="alert alert-warning alert-dismissible fade show border-warning">
            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>DEBUG MODE - Role Mismatch!</h5>
            <p class="mb-2"><strong><?= $debug_role_error ?></strong></p>
            <hr>
            <p class="mb-2"><strong>Role Anda saat ini:</strong> <span class="badge bg-dark"><?= esc($current_role ?? 'unknown') ?></span></p>
            <p class="mb-2"><strong>Cara Fix:</strong></p>
            <ol class="mb-2">
                <li>Buka: <a href="<?= base_url('debug/form-management/users') ?>" target="_blank" class="alert-link">Debug Users Page</a></li>
                <li>Update role Anda di database menjadi: <code>admin</code>, <code>admin_sekolah</code>, atau <code>panitia</code></li>
                <li>Logout dan login ulang</li>
            </ol>
            <p class="mb-0"><small><strong>Note:</strong> Halaman ini sementara bisa diakses untuk debugging. Setelah role diupdate, pesan ini akan hilang.</small></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Form Status Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Status Formulir</h5>
                            <p class="text-muted mb-0">
                                Formulir saat ini: 
                                <span id="status-badge" class="badge <?= $formStatus ? 'bg-success' : 'bg-danger' ?>">
                                    <?= $formStatus ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </p>
                        </div>
                        <div>
                            <button type="button" id="toggle-status-btn" class="btn <?= $formStatus ? 'btn-danger' : 'btn-success' ?>">
                                <i class="fas fa-power-off me-1"></i>
                                <span id="toggle-text"><?= $formStatus ? 'Nonaktifkan' : 'Aktifkan' ?> Formulir</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pendaftar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($totalApplicants) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Batas Maksimal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $allSettings['max_applicants'] > 0 ? number_format($allSettings['max_applicants']) : 'Unlimited' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tanggal Mulai</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?= date('d M Y', strtotime($allSettings['form_start_date'])) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tanggal Akhir</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?= date('d M Y', strtotime($allSettings['form_end_date'])) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Settings -->
    <form action="<?= base_url('admin/form-management/update-bulk') ?>" method="post">
        <?= csrf_field() ?>

        <!-- Card 1: Pengaturan Umum -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i> Pengaturan Umum</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Formulir <span class="text-danger">*</span></label>
                        <select name="form_status" class="form-select" required>
                            <option value="1" <?= $allSettings['form_status'] ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= !$allSettings['form_status'] ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                        <small class="text-muted">Jika nonaktif, siswa tidak bisa mendaftar</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Maksimal Pendaftar <span class="text-danger">*</span></label>
                        <input type="number" name="max_applicants" class="form-control" value="<?= $allSettings['max_applicants'] ?>" min="0" required>
                        <small class="text-muted">Isi 0 untuk unlimited</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Mulai Pendaftaran <span class="text-danger">*</span></label>
                        <input type="date" name="form_start_date" class="form-control" value="<?= $allSettings['form_start_date'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Akhir Pendaftaran <span class="text-danger">*</span></label>
                        <input type="date" name="form_end_date" class="form-control" value="<?= $allSettings['form_end_date'] ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Judul Formulir <span class="text-danger">*</span></label>
                        <input type="text" name="form_title" class="form-control" value="<?= esc($allSettings['form_title']) ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Deskripsi Formulir</label>
                        <textarea name="form_description" class="form-control" rows="3"><?= esc($allSettings['form_description']) ?></textarea>
                        <small class="text-muted">Deskripsi akan ditampilkan di halaman formulir</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Field Required -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-list-check me-2"></i> Field yang Wajib Diisi (Required)</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Centang field yang wajib diisi oleh pendaftar:</p>
                
                <?php
                $allFields = [
                    'Data Pribadi' => [
                        'nik' => 'NIK',
                        'nis' => 'NIS',
                        'nama_lengkap' => 'Nama Lengkap',
                        'nama_panggilan' => 'Nama Panggilan',
                        'jenis_kelamin' => 'Jenis Kelamin',
                        'tempat_lahir' => 'Tempat Lahir',
                        'tanggal_lahir' => 'Tanggal Lahir',
                        'agama' => 'Agama',
                        'status_keluarga' => 'Status Keluarga',
                        'nomor_telepon' => 'Nomor Telepon Rumah',
                        'anak_ke' => 'Anak Ke',
                        'jumlah_saudara' => 'Jumlah Saudara',
                    ],
                    'Alamat' => [
                        'alamat_jalan' => 'Alamat Jalan',
                        'dusun' => 'Dusun',
                        'kelurahan' => 'Kelurahan',
                        'kecamatan' => 'Kecamatan',
                        'kabupaten' => 'Kabupaten',
                        'provinsi' => 'Provinsi',
                        'kode_pos' => 'Kode Pos',
                        'nomor_hp' => 'Nomor HP',
                    ],
                    'Data Orang Tua' => [
                        'nama_ayah' => 'Nama Ayah',
                        'nik_ayah' => 'NIK Ayah',
                        'pendidikan_ayah' => 'Pendidikan Ayah',
                        'pekerjaan_ayah' => 'Pekerjaan Ayah',
                        'penghasilan_ayah' => 'Penghasilan Ayah',
                        'nomor_hp_ayah' => 'Nomor HP Ayah',
                        'nama_ibu' => 'Nama Ibu',
                        'nik_ibu' => 'NIK Ibu',
                        'pendidikan_ibu' => 'Pendidikan Ibu',
                        'pekerjaan_ibu' => 'Pekerjaan Ibu',
                        'penghasilan_ibu' => 'Penghasilan Ibu',
                        'nomor_hp_ibu' => 'Nomor HP Ibu',
                    ],
                    'Data Sekolah' => [
                        'asal_sekolah' => 'Asal Sekolah',
                        'npsn_sekolah_asal' => 'NPSN Sekolah',
                        'nilai_rata_rata' => 'Nilai Rata-rata',
                        'jurusan_id' => 'Jurusan',
                    ],
                ];
                
                $requiredFields = $allSettings['required_fields'];
                ?>

                <?php foreach ($allFields as $category => $fields): ?>
                    <div class="mb-4">
                        <h6 class="text-primary border-bottom pb-2"><?= $category ?></h6>
                        <div class="row">
                            <?php foreach ($fields as $fieldName => $fieldLabel): ?>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="required_fields[]" 
                                               value="<?= $fieldName ?>" 
                                               id="field_<?= $fieldName ?>"
                                               <?= in_array($fieldName, $requiredFields) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="field_<?= $fieldName ?>">
                                            <?= $fieldLabel ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian:</strong> Field yang di-uncheck akan menjadi opsional (tidak wajib diisi).
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" onclick="window.location.reload()">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript for Toggle Status -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggle-status-btn');
    const statusBadge = document.getElementById('status-badge');
    const toggleText = document.getElementById('toggle-text');

    toggleBtn.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin mengubah status formulir?')) {
            fetch('<?= base_url('admin/form-management/toggle-status') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    if (data.new_status == 1) {
                        statusBadge.className = 'badge bg-success';
                        statusBadge.textContent = 'Aktif';
                        toggleBtn.className = 'btn btn-danger';
                        toggleText.textContent = 'Nonaktifkan Formulir';
                    } else {
                        statusBadge.className = 'badge bg-danger';
                        statusBadge.textContent = 'Nonaktif';
                        toggleBtn.className = 'btn btn-success';
                        toggleText.textContent = 'Aktifkan Formulir';
                    }
                    
                    // Show success message
                    alert(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengubah status');
            });
        }
    });
});
</script>

<style>
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}
.border-left-success {
    border-left: 4px solid #1cc88a !important;
}
.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}
.border-left-danger {
    border-left: 4px solid #e74a3b !important;
}
</style>

<?= $this->endSection(); ?>
