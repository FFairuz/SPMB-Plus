<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Detail Siswa<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">
                <i class="fas fa-user-circle text-primary"></i> Detail Siswa
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('panitia/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('panitia/daftar-siswa') ?>">Daftar Siswa</a></li>
                    <li class="breadcrumb-item active">Detail Siswa</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?= base_url('panitia/daftar-siswa') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <a href="<?= base_url('panitia/edit_siswa/' . $applicant['id']) ?>" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="<?= base_url('panitia/cetak-pendaftaran/' . $applicant['id']) ?>" class="btn btn-primary" target="_blank">
                <i class="fas fa-print me-1"></i> Cetak
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
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

    <div class="row">
        <!-- Left Column: Student Info -->
        <div class="col-lg-8">
            <!-- Card 1: Data Pribadi -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i> Data Pribadi Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Nomor Pendaftaran</label>
                            <h6 class="fw-bold text-primary"><?= esc($applicant['nomor_pendaftaran'] ?? '-') ?></h6>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Status Pendaftaran</label>
                            <h6>
                                <?php
                                $status = $applicant['status'] ?? 'pending';
                                $statusClass = [
                                    'pending' => 'warning',
                                    'verified' => 'success',
                                    'rejected' => 'danger',
                                    'draft' => 'secondary'
                                ];
                                $statusText = [
                                    'pending' => 'Menunggu Verifikasi',
                                    'verified' => 'Terverifikasi',
                                    'rejected' => 'Ditolak',
                                    'draft' => 'Draft'
                                ];
                                ?>
                                <span class="badge bg-<?= $statusClass[$status] ?? 'secondary' ?>">
                                    <?= $statusText[$status] ?? ucfirst($status) ?>
                                </span>
                            </h6>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">NIK</label>
                            <p class="mb-0 fw-semibold"><?= esc($applicant['nik'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">NIS</label>
                            <p class="mb-0 fw-semibold"><?= esc($applicant['nis'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-12">
                            <label class="text-muted small mb-1">Nama Lengkap</label>
                            <p class="mb-0 fw-semibold fs-5 text-primary"><?= esc($applicant['nama_lengkap'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Nama Panggilan</label>
                            <p class="mb-0"><?= esc($applicant['nama_panggilan'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Jenis Kelamin</label>
                            <p class="mb-0">
                                <i class="fas fa-<?= ($applicant['jenis_kelamin'] ?? '') === 'laki-laki' ? 'mars text-primary' : 'venus text-danger' ?>"></i>
                                <?= esc(ucwords($applicant['jenis_kelamin'] ?? '-')) ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Tempat Lahir</label>
                            <p class="mb-0"><?= esc($applicant['tempat_lahir'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Tanggal Lahir</label>
                            <p class="mb-0">
                                <?php
                                if (!empty($applicant['tanggal_lahir'])) {
                                    $tgl = date_create($applicant['tanggal_lahir']);
                                    echo date_format($tgl, 'd F Y');
                                    
                                    // Calculate age
                                    $today = date_create('today');
                                    $age = date_diff($tgl, $today)->y;
                                    echo " <span class='text-muted'>($age tahun)</span>";
                                } else {
                                    echo '-';
                                }
                                ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Agama</label>
                            <p class="mb-0"><?= esc($applicant['agama'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Status Keluarga</label>
                            <p class="mb-0"><?= esc($applicant['status_keluarga'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">Anak Ke-</label>
                            <p class="mb-0 fw-semibold"><?= esc($applicant['anak_ke'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">Jumlah Saudara</label>
                            <p class="mb-0 fw-semibold"><?= esc($applicant['jumlah_saudara'] ?? '0') ?></p>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">Tinggi Badan</label>
                            <p class="mb-0"><?= !empty($applicant['tinggi_badan']) ? esc($applicant['tinggi_badan']) . ' cm' : '-' ?></p>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">Berat Badan</label>
                            <p class="mb-0"><?= !empty($applicant['berat_badan']) ? esc($applicant['berat_badan']) . ' kg' : '-' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Alamat -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i> Alamat Lengkap</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="text-muted small mb-1">Alamat Jalan</label>
                            <p class="mb-0"><?= esc($applicant['alamat_jalan'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Dusun</label>
                            <p class="mb-0"><?= esc($applicant['dusun'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Kelurahan/Desa</label>
                            <p class="mb-0"><?= esc($applicant['kelurahan'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Kecamatan</label>
                            <p class="mb-0"><?= esc($applicant['kecamatan'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Kabupaten/Kota</label>
                            <p class="mb-0"><?= esc($applicant['kabupaten'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Provinsi</label>
                            <p class="mb-0"><?= esc($applicant['provinsi'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Kode Pos</label>
                            <p class="mb-0"><?= esc($applicant['kode_pos'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Nomor Telepon</label>
                            <p class="mb-0">
                                <?php if (!empty($applicant['nomor_telepon'])): ?>
                                    <i class="fas fa-phone me-1"></i><?= esc($applicant['nomor_telepon']) ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Nomor HP</label>
                            <p class="mb-0">
                                <?php if (!empty($applicant['nomor_hp'])): ?>
                                    <i class="fas fa-mobile-alt me-1"></i><?= esc($applicant['nomor_hp']) ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Data Orang Tua -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i> Data Orang Tua / Wali</h5>
                </div>
                <div class="card-body">
                    <!-- Data Ayah -->
                    <h6 class="text-secondary border-bottom pb-2 mb-3">
                        <i class="fas fa-male me-2"></i> Data Ayah Kandung
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Nama Ayah</label>
                            <p class="mb-0 fw-semibold"><?= esc($applicant['nama_ayah'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">NIK Ayah</label>
                            <p class="mb-0"><?= esc($applicant['nik_ayah'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Pendidikan Ayah</label>
                            <p class="mb-0"><?= esc($applicant['pendidikan_ayah'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Pekerjaan Ayah</label>
                            <p class="mb-0"><?= esc($applicant['pekerjaan_ayah'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Penghasilan Ayah</label>
                            <p class="mb-0"><?= esc($applicant['penghasilan_ayah'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Nomor HP Ayah</label>
                            <p class="mb-0">
                                <?php if (!empty($applicant['nomor_hp_ayah'])): ?>
                                    <i class="fas fa-mobile-alt me-1"></i><?= esc($applicant['nomor_hp_ayah']) ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <!-- Data Ibu -->
                    <h6 class="text-secondary border-bottom pb-2 mb-3">
                        <i class="fas fa-female me-2"></i> Data Ibu Kandung
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Nama Ibu</label>
                            <p class="mb-0 fw-semibold"><?= esc($applicant['nama_ibu'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">NIK Ibu</label>
                            <p class="mb-0"><?= esc($applicant['nik_ibu'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Pendidikan Ibu</label>
                            <p class="mb-0"><?= esc($applicant['pendidikan_ibu'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Pekerjaan Ibu</label>
                            <p class="mb-0"><?= esc($applicant['pekerjaan_ibu'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Penghasilan Ibu</label>
                            <p class="mb-0"><?= esc($applicant['penghasilan_ibu'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Nomor HP Ibu</label>
                            <p class="mb-0">
                                <?php if (!empty($applicant['nomor_hp_ibu'])): ?>
                                    <i class="fas fa-mobile-alt me-1"></i><?= esc($applicant['nomor_hp_ibu']) ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <!-- Data Wali (jika ada) -->
                    <?php if (!empty($applicant['nama_wali'])): ?>
                        <h6 class="text-secondary border-bottom pb-2 mb-3">
                            <i class="fas fa-user-shield me-2"></i> Data Wali
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Nama Wali</label>
                                <p class="mb-0 fw-semibold"><?= esc($applicant['nama_wali']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Hubungan dengan Wali</label>
                                <p class="mb-0"><?= esc($applicant['hubungan_wali'] ?? '-') ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Nomor HP Wali</label>
                                <p class="mb-0">
                                    <?php if (!empty($applicant['nomor_hp_wali'])): ?>
                                        <i class="fas fa-mobile-alt me-1"></i><?= esc($applicant['nomor_hp_wali']) ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card 4: Data Sekolah & Akademik -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-school me-2"></i> Data Sekolah & Akademik</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="text-muted small mb-1">Asal Sekolah</label>
                            <p class="mb-0 fw-semibold"><?= esc($applicant['asal_sekolah'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small mb-1">NPSN</label>
                            <p class="mb-0"><?= esc($applicant['npsn_sekolah_asal'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-12">
                            <label class="text-muted small mb-1">Nilai Rata-rata Raport</label>
                            <p class="mb-0 fs-5 fw-bold text-success">
                                <?= !empty($applicant['nilai_rata_rata']) ? number_format($applicant['nilai_rata_rata'], 2) : '-' ?>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <label class="text-muted small mb-1 fw-semibold">Nilai UN/Ujian Akhir:</label>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">B. Indonesia</label>
                            <p class="mb-0"><?= !empty($applicant['nilai_un_indo']) ? number_format($applicant['nilai_un_indo'], 2) : '-' ?></p>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">Matematika</label>
                            <p class="mb-0"><?= !empty($applicant['nilai_un_math']) ? number_format($applicant['nilai_un_math'], 2) : '-' ?></p>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">B. Inggris</label>
                            <p class="mb-0"><?= !empty($applicant['nilai_un_english']) ? number_format($applicant['nilai_un_english'], 2) : '-' ?></p>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">IPA</label>
                            <p class="mb-0"><?= !empty($applicant['nilai_un_science']) ? number_format($applicant['nilai_un_science'], 2) : '-' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 5: Prestasi & Lainnya -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-trophy me-2"></i> Prestasi & Informasi Tambahan</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="text-muted small mb-1">Prestasi Akademik</label>
                            <p class="mb-0"><?= !empty($applicant['prestasi_akademik']) ? nl2br(esc($applicant['prestasi_akademik'])) : '<em class="text-muted">Tidak ada</em>' ?></p>
                        </div>
                        <div class="col-md-12">
                            <label class="text-muted small mb-1">Prestasi Non-Akademik</label>
                            <p class="mb-0"><?= !empty($applicant['prestasi_non_akademik']) ? nl2br(esc($applicant['prestasi_non_akademik'])) : '<em class="text-muted">Tidak ada</em>' ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Kelainan Fisik</label>
                            <p class="mb-0"><?= !empty($applicant['kelainan_fisik']) ? esc($applicant['kelainan_fisik']) : '<em class="text-muted">Tidak ada</em>' ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">Kebutuhan Khusus</label>
                            <p class="mb-0"><?= !empty($applicant['kebutuhan_khusus_lainnya']) ? esc($applicant['kebutuhan_khusus_lainnya']) : '<em class="text-muted">Tidak ada</em>' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 6: Catatan Verifikasi -->
            <?php if (!empty($applicant['catatan_verifikasi'])): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i> Catatan Verifikasi</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?= nl2br(esc($applicant['catatan_verifikasi'])) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Column: Summary & Actions -->
        <div class="col-lg-4">
            <!-- Status Summary Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Ringkasan Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Status Pendaftaran</label>
                        <h5>
                            <span class="badge bg-<?= $statusClass[$status] ?? 'secondary' ?> w-100 py-2">
                                <?= $statusText[$status] ?? ucfirst($status) ?>
                            </span>
                        </h5>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Tanggal Daftar</label>
                        <p class="mb-0">
                            <i class="fas fa-calendar me-1"></i>
                            <?php
                            if (!empty($applicant['created_at'])) {
                                echo date('d F Y, H:i', strtotime($applicant['created_at']));
                            } else {
                                echo '-';
                            }
                            ?>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Tanggal Submit</label>
                        <p class="mb-0">
                            <i class="fas fa-calendar-check me-1"></i>
                            <?php
                            if (!empty($applicant['tanggal_submit'])) {
                                echo date('d F Y, H:i', strtotime($applicant['tanggal_submit']));
                            } else {
                                echo '<em class="text-muted">Belum submit</em>';
                            }
                            ?>
                        </p>
                    </div>
                    <div>
                        <label class="text-muted small mb-1">Terakhir Update</label>
                        <p class="mb-0">
                            <i class="fas fa-clock me-1"></i>
                            <?php
                            if (!empty($applicant['updated_at'])) {
                                echo date('d F Y, H:i', strtotime($applicant['updated_at']));
                            } else {
                                echo '-';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Payment Info Card -->
            <?php if (isset($payment) && !empty($payment)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i> Informasi Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small mb-1">Status Pembayaran</label>
                            <h5>
                                <?php
                                $paymentStatus = $payment['status'] ?? 'pending';
                                $paymentStatusClass = [
                                    'pending' => 'warning',
                                    'confirmed' => 'success',
                                    'rejected' => 'danger'
                                ];
                                $paymentStatusText = [
                                    'pending' => 'Menunggu Konfirmasi',
                                    'confirmed' => 'Sudah Dikonfirmasi',
                                    'rejected' => 'Ditolak'
                                ];
                                ?>
                                <span class="badge bg-<?= $paymentStatusClass[$paymentStatus] ?? 'secondary' ?> w-100 py-2">
                                    <?= $paymentStatusText[$paymentStatus] ?? ucfirst($paymentStatus) ?>
                                </span>
                            </h5>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small mb-1">Jumlah Pembayaran</label>
                            <p class="mb-0 fs-5 fw-bold text-success">
                                Rp <?= number_format($payment['amount'] ?? 0, 0, ',', '.') ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small mb-1">Metode Pembayaran</label>
                            <p class="mb-0"><?= esc(ucwords($payment['payment_method'] ?? '-')) ?></p>
                        </div>
                        <div>
                            <label class="text-muted small mb-1">Tanggal Bayar</label>
                            <p class="mb-0">
                                <?php
                                if (!empty($payment['payment_date'])) {
                                    echo date('d F Y, H:i', strtotime($payment['payment_date']));
                                } else {
                                    echo '-';
                                }
                                ?>
                            </p>
                        </div>
                        <?php if (!empty($payment['bukti_transfer'])): ?>
                            <hr>
                            <a href="<?= base_url('uploads/payments/' . $payment['bukti_transfer']) ?>" class="btn btn-sm btn-primary w-100" target="_blank">
                                <i class="fas fa-image me-1"></i> Lihat Bukti Transfer
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow-sm mb-4 border-warning">
                    <div class="card-body text-center">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                        <h6 class="text-muted">Belum Ada Pembayaran</h6>
                        <p class="small text-muted mb-0">Siswa belum melakukan pembayaran</p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Actions Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i> Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('panitia/edit_siswa/' . $applicant['id']) ?>" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit Data Siswa
                        </a>
                        <a href="<?= base_url('panitia/cetak-pendaftaran/' . $applicant['id']) ?>" class="btn btn-primary" target="_blank">
                            <i class="fas fa-print me-1"></i> Cetak Formulir
                        </a>
                        <?php if ($status === 'pending'): ?>
                            <a href="<?= base_url('panitia/verifikasi-pendaftar/' . $applicant['id']) ?>" class="btn btn-success">
                                <i class="fas fa-check-circle me-1"></i> Verifikasi
                            </a>
                        <?php elseif ($status === 'verified'): ?>
                            <a href="<?= base_url('panitia/batal-verifikasi/' . $applicant['id']) ?>" class="btn btn-secondary">
                                <i class="fas fa-undo me-1"></i> Batal Verifikasi
                            </a>
                        <?php endif; ?>
                        <hr class="my-2">
                        <a href="<?= base_url('panitia/hapus_siswa/' . $applicant['id']) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                            <i class="fas fa-trash me-1"></i> Hapus Data
                        </a>
                    </div>
                </div>
            </div>

            <!-- Documents Card -->
            <?php if (!empty($applicant['dokumen_upload'])): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i> Dokumen</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $documents = json_decode($applicant['dokumen_upload'], true);
                        if (is_array($documents) && count($documents) > 0):
                        ?>
                            <ul class="list-unstyled mb-0">
                                <?php foreach ($documents as $doc): ?>
                                    <li class="mb-2">
                                        <a href="<?= base_url('uploads/documents/' . $doc) ?>" class="text-decoration-none" target="_blank">
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <?= esc(basename($doc)) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted small mb-0 text-center">Tidak ada dokumen</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 8px;
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-2px);
}
.card-header h5 {
    font-size: 1.1rem;
}
label.small {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>
<?= $this->endSection(); ?>
