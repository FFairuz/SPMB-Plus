<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Dashboard Pendaftar<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="/css/status-badges.css">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> <strong>Sukses!</strong>
                <span><?= session()->getFlashdata('success'); ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> <strong>Error!</strong>
                    <span><?= session()->getFlashdata('error'); ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!$applicant): ?>
                <!-- Not Registered - Show Payment Status First -->
                <div class="card border-0 shadow-lg mb-4">
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-3">💳 Pembayaran Pendaftaran</h4>
                                <p class="text-muted mb-4">
                                    Untuk memulai proses pendaftaran, Anda harus melakukan pembayaran biaya pendaftaran terlebih dahulu.
                                    Setelah pembayaran dikonfirmasi oleh admin, Anda dapat mengisi formulir pendaftaran.
                                </p>
                                
                                <?php if (!$payment): ?>
                                    <!-- No Payment Yet -->
                                    <div class="alert alert-warning mb-4">
                                        <i class="bi bi-exclamation-triangle-fill"></i> Anda belum melakukan pembayaran.
                                    </div>
                                    <div class="mb-3">
                                        <p class="fw-bold text-danger mb-2">Biaya Pendaftaran: <strong>Rp 150.000</strong></p>
                                    </div>
                                    <a href="/applicant/payment" class="btn btn-primary btn-lg">
                                        <i class="bi bi-credit-card"></i> Lakukan Pembayaran
                                    </a>
                                <?php elseif ($payment['payment_status'] === 'submitted'): ?>
                                    <!-- Payment Submitted, Waiting for Admin -->
                                    <div class="alert alert-info mb-4">
                                        <i class="bi bi-hourglass-split"></i> Pembayaran Anda sedang ditunggu konfirmasi dari admin.
                                    </div>
                                    <div class="mb-3">
                                        <p><small class="text-muted">Tanggal Transfer:</small> <strong><?= date('d-m-Y', strtotime($payment['transfer_date'])); ?></strong></p>
                                        <p><small class="text-muted">Jumlah:</small> <strong>Rp <?= number_format($payment['transfer_amount'], 0, ',', '.'); ?></strong></p>
                                    </div>
                                    <button class="btn btn-secondary" disabled>
                                        <i class="bi bi-clock"></i> Menunggu Konfirmasi Admin
                                    </button>
                                    <a href="/applicant/payment" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Update Bukti Pembayaran
                                    </a>
                                <?php elseif ($payment['payment_status'] === 'confirmed'): ?>
                                    <!-- Payment Confirmed -->
                                    <div class="alert alert-success mb-4">
                                        <i class="bi bi-check-circle-fill"></i> Pembayaran Anda telah dikonfirmasi!
                                    </div>
                                    <p class="mb-4 text-muted">Anda sekarang dapat mengisi formulir pendaftaran.</p>
                                    <a href="/applicant/register" class="btn btn-success btn-lg">
                                        <i class="bi bi-clipboard-check"></i> Isi Formulir Pendaftaran
                                    </a>
                                <?php elseif ($payment['payment_status'] === 'rejected'): ?>
                                    <!-- Payment Rejected -->
                                    <div class="alert alert-danger mb-4">
                                        <i class="bi bi-x-circle-fill"></i> Pembayaran Anda ditolak.
                                    </div>
                                    <?php if ($payment['notes']): ?>
                                        <p class="mb-3"><small class="text-muted">Alasan:</small> <strong><?= $payment['notes']; ?></strong></p>
                                    <?php endif; ?>
                                    <a href="/applicant/payment" class="btn btn-primary">
                                        <i class="bi bi-arrow-clockwise"></i> Kirim Ulang Bukti Pembayaran
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <div style="background: linear-gradient(135deg, rgba(13, 110, 253, 0.15) 0%, rgba(11, 94, 215, 0.15) 100%); padding: 30px; border-radius: 15px; text-align: center;">
                                    <i class="bi bi-credit-card-2-front" style="font-size: 3rem; color: #0d6efd;"></i>
                                    <h6 class="mt-3 mb-2">Biaya Pendaftaran</h6>
                                    <p class="text-muted mb-0"><small>Untuk tahun ini</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="mb-3">📋 Alur Pendaftaran:</h6>
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="badge bg-primary rounded-circle p-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">1</div>
                            <div>
                                <p class="fw-bold mb-1">Lakukan Pembayaran</p>
                                <p class="text-muted small mb-0">Bayar biaya pendaftaran Rp 150.000</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="badge bg-primary rounded-circle p-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">2</div>
                            <div>
                                <p class="fw-bold mb-1">Tunggu Konfirmasi Admin</p>
                                <p class="text-muted small mb-0">Admin akan mengkonfirmasi pembayaran Anda</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <div class="badge bg-primary rounded-circle p-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">3</div>
                            <div>
                                <p class="fw-bold mb-1">Isi Form Pendaftaran</p>
                                <p class="text-muted small mb-0">Setelah pembayaran dikonfirmasi, isi formulir pendaftaran</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Welcome Section -->
                <div class="mb-4">
                    <h2 class="mb-1">Selamat datang, <strong><?= explode(' ', $applicant['nama_lengkap'] ?? 'Pengguna')[0]; ?></strong>! 👋</h2>
                    <p class="text-muted">Berikut adalah status dan ringkasan data pendaftaran Anda</p>
                </div>

                <!-- Status Cards -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(11, 94, 215, 0.1) 100%); border-left: 4px solid #0d6efd;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <small class="text-muted d-block mb-2">Nomor Registrasi</small>
                                        <h5 class="fw-bold text-primary mb-0"><?= $applicant['nomor_pendaftaran'] ?? 'N/A'; ?></h5>
                                    </div>
                                    <i class="bi bi-hash" style="font-size: 2rem; color: #0d6efd; opacity: 0.2;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <small class="text-muted d-block mb-2">Status Pendaftaran</small>
                                <div class="d-flex align-items-center gap-2">
                                    <?php
                                    $status = strtolower($applicant['status']);
                                    $status_config = [
                                        'draft' => ['label' => 'Draft', 'class' => 'status-draft', 'icon' => 'file-earmark'],
                                        'pending' => ['label' => 'Menunggu Verifikasi', 'class' => 'status-draft', 'icon' => 'clock'],
                                        'submitted' => ['label' => 'Disubmit', 'class' => 'status-submitted', 'icon' => 'send'],
                                        'verified' => ['label' => 'Terverifikasi', 'class' => 'status-verified', 'icon' => 'check-circle'],
                                        'accepted' => ['label' => 'Diterima', 'class' => 'status-accepted', 'icon' => 'check2-all'],
                                        'rejected' => ['label' => 'Ditolak', 'class' => 'status-rejected', 'icon' => 'x-circle'],
                                    ];
                                    $config = $status_config[$status] ?? ['label' => ucfirst($status), 'class' => 'status-draft', 'icon' => 'question'];
                                    ?>
                                    <span class="status-badge <?= $config['class']; ?>" data-tooltip="Status: <?= $config['label']; ?>">
                                        <i class="bi bi-<?= $config['icon']; ?>"></i>
                                        <?= $config['label']; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Section -->
                <?php if ($payment): ?>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-credit-card" style="color: #0d6efd;"></i>
                                <h5 class="mb-0">Status Pembayaran</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div>
                                        <small class="text-muted d-block mb-1">Biaya Pendaftaran</small>
                                        <h5 class="fw-bold text-primary mb-0">Rp. <?= number_format($payment['registration_fee'] ?? 250000, 0, ',', '.'); ?></h5>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <small class="text-muted d-block mb-1">Status</small>
                                        <div>
                                            <?php
                                            $paymentStatusColors = [
                                                'pending' => ['bg-warning', 'Belum Dibayar'],
                                                'submitted' => ['bg-info', 'Menunggu Konfirmasi'],
                                                'confirmed' => ['bg-success', 'Dikonfirmasi'],
                                                'rejected' => ['bg-danger', 'Ditolak'],
                                            ];
                                            $paymentStatus = $payment['payment_status'] ?? 'pending';
                                            $paymentColor = $paymentStatusColors[$paymentStatus][0];
                                            $paymentLabel = $paymentStatusColors[$paymentStatus][1];
                                            ?>
                                            <span class="badge <?= $paymentColor; ?> p-2">
                                                <?= $paymentLabel; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($paymentStatus !== 'confirmed'): ?>
                                <a href="/payment" class="btn btn-primary btn-sm">
                                    <i class="bi bi-credit-card"></i> Kelola Pembayaran
                                </a>
                            <?php else: ?>
                                <div class="alert alert-success border-0">
                                    <i class="bi bi-check-circle-fill"></i> 
                                    Pembayaran sudah dikonfirmasi. Anda bisa mengakses fitur pendaftaran sepenuhnya.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Data Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-0 py-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-vcard" style="color: #0d6efd;"></i>
                            <h5 class="mb-0">Data Pendaftaran</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div>
                                    <small class="text-muted d-block mb-1">Nama Lengkap</small>
                                    <p class="fw-500 mb-0"><?= $applicant['nama_lengkap'] ?? 'N/A'; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <small class="text-muted d-block mb-1">Tanggal Lahir</small>
                                    <p class="fw-500 mb-0"><?= $applicant['tanggal_lahir'] ? date('d-m-Y', strtotime($applicant['tanggal_lahir'])) : 'N/A'; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <small class="text-muted d-block mb-1">Jenis Kelamin</small>
                                    <p class="fw-500 mb-0">
                                        <?php
                                        $gender_icon = $applicant['gender'] === 'laki-laki' ? '👨' : '👩';
                                        echo $gender_icon . ' ' . ucfirst($applicant['gender']);
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <small class="text-muted d-block mb-1">Nomor Telepon</small>
                                    <p class="fw-500 mb-0"><?= $applicant['phone']; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <small class="text-muted d-block mb-1">Asal Sekolah</small>
                                    <p class="fw-500 mb-0"><?= $applicant['school_origin']; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <small class="text-muted d-block mb-1">IPK/Nilai Rata-rata</small>
                                    <p class="fw-500 mb-0"><?= number_format($applicant['gpa'], 2, ',', '.'); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top">
                            <a href="/applicant/edit" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil"></i> Edit Data
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0 py-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-pdf" style="color: #dc3545;"></i>
                            <h5 class="mb-0">Status Dokumen</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if ($applicant['documents_uploaded']): ?>
                            <div class="alert alert-success border-0" role="alert">
                                <i class="bi bi-check-circle-fill"></i> 
                                <strong>Lengkap!</strong> Semua dokumen telah berhasil diupload.
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning border-0" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i> 
                                <strong>Belum Lengkap</strong> Silakan upload dokumen untuk menyelesaikan pendaftaran.
                            </div>
                        <?php endif; ?>
                        
                        <p class="text-muted small mb-4">
                            Dokumen yang diperlukan: KTP, Kartu Keluarga, Kartu Hasil Ujian Nasional, dan Rapor
                        </p>

                        <a href="/applicant/upload_documents" class="btn btn-primary">
                            <i class="bi bi-cloud-upload"></i> 
                            <?= $applicant['documents_uploaded'] ? 'Kelola Dokumen' : 'Upload Dokumen'; ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

<style>
    .fw-500 {
        font-weight: 500;
    }
    .nav-link:hover {
        background: rgba(255,255,255,0.15) !important;
    }
    .status-pending {
        background-color: #fff3cd !important;
        color: #856404 !important;
    }
    .status-verified {
        background-color: #d1ecf1 !important;
        color: #0c5460 !important;
    }
    .status-accepted {
        background-color: #d4edda !important;
        color: #155724 !important;
    }
    .status-rejected {
        background-color: #f8d7da !important;
        color: #721c24 !important;
    }
</style>
<?= $this->endSection(); ?>