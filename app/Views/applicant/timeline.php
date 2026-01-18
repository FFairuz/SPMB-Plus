<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Timeline Status Pendaftaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Import Status Timeline CSS -->
<link rel="stylesheet" href="<?= base_url('css/design-system.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/status-timeline.css') ?>">

<div class="status-timeline-container">
    
    <!-- ========== TIMELINE HEADER ========== -->
    <div class="timeline-header">
        <h1>
            <i class="bi bi-clock-history"></i>
            Timeline Status Pendaftaran
        </h1>
        <p>Lacak progress pendaftaran Anda secara real-time</p>
    </div>

    <!-- ========== TIMELINE TRACK ========== -->
    <div class="timeline-track">
        <div class="timeline-line">
            <div class="timeline-line-progress" style="height: <?= isset($progress) ? $progress : 50 ?>%;"></div>
        </div>

        <!-- STEP 1: Pendaftaran -->
        <div class="timeline-item left status-completed">
            <div class="timeline-content">
                <div class="timeline-card">
                    <div class="timeline-card-header">
                        <div class="timeline-card-title">
                            <i class="bi bi-check-circle-fill"></i>
                            Pendaftaran Berhasil
                        </div>
                        <span class="status-badge completed">
                            <i class="bi bi-check-lg"></i> Selesai
                        </span>
                    </div>
                    <div class="timeline-card-body">
                        <div class="timeline-card-description">
                            Formulir pendaftaran Anda telah berhasil disubmit ke sistem. Nomor pendaftaran Anda adalah <strong>#<?= $applicant['nomor_pendaftaran'] ?? 'N/A' ?></strong>.
                        </div>
                        <div class="timeline-card-meta">
                            <div class="timeline-meta-item">
                                <i class="bi bi-calendar-check"></i>
                                <span><?= date('d M Y, H:i', strtotime($applicant['created_at'] ?? 'now')) ?> WIB</span>
                            </div>
                            <div class="timeline-meta-item">
                                <i class="bi bi-person"></i>
                                <span><?= esc($applicant['nama_lengkap'] ?? 'User') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-card-footer">
                        <div class="timeline-card-date">
                            <i class="bi bi-clock"></i>
                            <span>2 hari yang lalu</span>
                        </div>
                        <div class="timeline-card-actions">
                            <a href="<?= base_url('/applicant/dashboard') ?>" class="btn btn-sm btn-outline">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="timeline-marker-wrapper">
                <div class="timeline-marker">
                    <i class="bi bi-check-lg"></i>
                </div>
            </div>
            <div class="timeline-content-empty"></div>
        </div>

        <!-- STEP 2: Verifikasi Dokumen -->
        <div class="timeline-item right status-active">
            <div class="timeline-content-empty"></div>
            <div class="timeline-marker-wrapper">
                <div class="timeline-marker">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
            <div class="timeline-content">
                <div class="timeline-card">
                    <div class="timeline-card-header">
                        <div class="timeline-card-title">
                            <i class="bi bi-file-earmark-check"></i>
                            Verifikasi Dokumen
                        </div>
                        <span class="status-badge active">
                            <i class="bi bi-hourglass-split"></i> Sedang Diproses
                        </span>
                    </div>
                    <div class="timeline-card-body">
                        <div class="timeline-card-description">
                            Tim admin sedang memverifikasi kelengkapan dan keabsahan dokumen yang Anda upload. Proses ini memakan waktu 1-3 hari kerja.
                        </div>
                        <div class="timeline-card-meta">
                            <div class="timeline-meta-item">
                                <i class="bi bi-calendar-check"></i>
                                <span>Dimulai: <?= date('d M Y, H:i') ?> WIB</span>
                            </div>
                            <div class="timeline-meta-item">
                                <div class="countdown-timer">
                                    <i class="bi bi-alarm"></i>
                                    <span>Estimasi: 1-2 hari</span>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: var(--space-4);">
                            <div class="progress-modern">
                                <div class="progress-bar-modern" style="width: 65%;"></div>
                            </div>
                            <p style="font-size: var(--text-sm); color: var(--neutral-600); margin-top: var(--space-2);">
                                65% dokumen telah diverifikasi
                            </p>
                        </div>
                    </div>
                    <div class="timeline-card-footer">
                        <div class="timeline-card-date">
                            <i class="bi bi-clock"></i>
                            <span>Dalam proses</span>
                        </div>
                        <div class="timeline-card-actions">
                            <button class="btn btn-sm btn-primary" onclick="showToast('Info sedang diproses', 'info')">
                                <i class="bi bi-bell"></i> Notifikasi Saya
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 3: Pembayaran -->
        <div class="timeline-item left status-pending">
            <div class="timeline-content">
                <div class="timeline-card">
                    <div class="timeline-card-header">
                        <div class="timeline-card-title">
                            <i class="bi bi-credit-card"></i>
                            Pembayaran
                        </div>
                        <span class="status-badge pending">
                            <i class="bi bi-hourglass"></i> Menunggu
                        </span>
                    </div>
                    <div class="timeline-card-body">
                        <div class="timeline-card-description">
                            Setelah dokumen terverifikasi, Anda akan diminta untuk melakukan pembayaran biaya pendaftaran sebesar <strong>Rp 250.000</strong>.
                        </div>
                        <div class="timeline-card-meta">
                            <div class="timeline-meta-item">
                                <i class="bi bi-cash"></i>
                                <span>Biaya: Rp 250.000</span>
                            </div>
                            <div class="timeline-meta-item">
                                <i class="bi bi-building"></i>
                                <span>Transfer Bank / E-Wallet</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-card-footer">
                        <div class="timeline-card-date">
                            <i class="bi bi-clock"></i>
                            <span>Belum dimulai</span>
                        </div>
                        <div class="timeline-card-actions">
                            <button class="btn btn-sm btn-outline" disabled>
                                <i class="bi bi-credit-card"></i> Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="timeline-marker-wrapper">
                <div class="timeline-marker">
                    3
                </div>
            </div>
            <div class="timeline-content-empty"></div>
        </div>

        <!-- STEP 4: Verifikasi Pembayaran -->
        <div class="timeline-item right status-pending">
            <div class="timeline-content-empty"></div>
            <div class="timeline-marker-wrapper">
                <div class="timeline-marker">
                    4
                </div>
            </div>
            <div class="timeline-content">
                <div class="timeline-card">
                    <div class="timeline-card-header">
                        <div class="timeline-card-title">
                            <i class="bi bi-check2-square"></i>
                            Verifikasi Pembayaran
                        </div>
                        <span class="status-badge pending">
                            <i class="bi bi-hourglass"></i> Menunggu
                        </span>
                    </div>
                    <div class="timeline-card-body">
                        <div class="timeline-card-description">
                            Bendahara akan memverifikasi bukti transfer Anda. Proses ini memakan waktu 1-2 hari kerja setelah pembayaran.
                        </div>
                        <div class="timeline-card-meta">
                            <div class="timeline-meta-item">
                                <i class="bi bi-hourglass-split"></i>
                                <span>Estimasi: 1-2 hari kerja</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 5: Tes Masuk -->
        <div class="timeline-item left status-pending">
            <div class="timeline-content">
                <div class="timeline-card">
                    <div class="timeline-card-header">
                        <div class="timeline-card-title">
                            <i class="bi bi-pencil-square"></i>
                            Tes Masuk
                        </div>
                        <span class="status-badge pending">
                            <i class="bi bi-hourglass"></i> Menunggu
                        </span>
                    </div>
                    <div class="timeline-card-body">
                        <div class="timeline-card-description">
                            Anda akan mengikuti tes masuk sesuai jadwal yang telah ditentukan. Informasi detail akan dikirimkan via email.
                        </div>
                        <div class="timeline-card-meta">
                            <div class="timeline-meta-item">
                                <i class="bi bi-calendar-event"></i>
                                <span>Jadwal: TBA</span>
                            </div>
                            <div class="timeline-meta-item">
                                <i class="bi bi-geo-alt"></i>
                                <span>Lokasi: TBA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="timeline-marker-wrapper">
                <div class="timeline-marker">
                    5
                </div>
            </div>
            <div class="timeline-content-empty"></div>
        </div>

        <!-- STEP 6: Pengumuman -->
        <div class="timeline-item right status-pending">
            <div class="timeline-content-empty"></div>
            <div class="timeline-marker-wrapper">
                <div class="timeline-marker">
                    <i class="bi bi-trophy"></i>
                </div>
            </div>
            <div class="timeline-content">
                <div class="timeline-card">
                    <div class="timeline-card-header">
                        <div class="timeline-card-title">
                            <i class="bi bi-megaphone"></i>
                            Pengumuman Hasil
                        </div>
                        <span class="status-badge pending">
                            <i class="bi bi-hourglass"></i> Menunggu
                        </span>
                    </div>
                    <div class="timeline-card-body">
                        <div class="timeline-card-description">
                            Pengumuman hasil seleksi akan diumumkan pada tanggal yang telah ditentukan. Anda akan menerima notifikasi via email dan SMS.
                        </div>
                        <div class="timeline-card-meta">
                            <div class="timeline-meta-item">
                                <i class="bi bi-calendar-check"></i>
                                <span>Estimasi: 2 minggu setelah tes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ========== NEXT STEPS PANEL ========== -->
    <div class="next-steps-panel">
        <div class="next-steps-header">
            <div class="next-steps-icon">
                <i class="bi bi-lightbulb"></i>
            </div>
            <div>
                <div class="next-steps-title">Yang Perlu Anda Lakukan</div>
                <p style="color: var(--primary-600); margin: 0; font-size: var(--text-base);">
                    Tips untuk mempercepat proses pendaftaran
                </p>
            </div>
        </div>
        <ul class="next-steps-list">
            <li>
                <strong>Periksa Email Secara Berkala</strong><br>
                <span style="color: var(--neutral-600); font-size: var(--text-sm);">
                    Pastikan Anda memeriksa inbox dan folder spam untuk update terbaru
                </span>
            </li>
            <li>
                <strong>Siapkan Dokumen Tambahan (Jika Diminta)</strong><br>
                <span style="color: var(--neutral-600); font-size: var(--text-sm);">
                    Jika admin meminta dokumen tambahan, segera upload untuk mempercepat verifikasi
                </span>
            </li>
            <li>
                <strong>Hubungi Admin Jika Ada Kendala</strong><br>
                <span style="color: var(--neutral-600); font-size: var(--text-sm);">
                    Jangan ragu menghubungi kami via WhatsApp: 0812-3456-7890
                </span>
            </li>
        </ul>
    </div>

</div>

<script>
// Auto-update progress based on status
document.addEventListener('DOMContentLoaded', function() {
    // Calculate progress based on completed steps
    const completedSteps = document.querySelectorAll('.timeline-item.status-completed').length;
    const activeSteps = document.querySelectorAll('.timeline-item.status-active').length;
    const totalSteps = document.querySelectorAll('.timeline-item').length;
    
    const progress = ((completedSteps + (activeSteps * 0.5)) / totalSteps) * 100;
    
    const progressBar = document.querySelector('.timeline-line-progress');
    if (progressBar) {
        setTimeout(() => {
            progressBar.style.height = progress + '%';
        }, 500);
    }
    
    console.log(`Timeline Progress: ${progress.toFixed(0)}%`);
});
</script>

<?= $this->endSection(); ?>
