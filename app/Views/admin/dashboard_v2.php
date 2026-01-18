<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Command Center - Dashboard Admin<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Import Design System & Dashboard v2 CSS -->
<link rel="stylesheet" href="<?= base_url('css/design-system.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/dashboard-v2.css') ?>">

<div class="dashboard-container">
    
    <!-- ========== COMMAND CENTER HEADER ========== -->
    <div class="command-center-header">
        <h1>
            <i class="bi bi-rocket-takeoff"></i>
            Command Center
        </h1>
        <p>Kelola seluruh sistem PPDB dari satu tempat</p>
        <div class="header-time">
            <i class="bi bi-clock"></i>
            <span>Terakhir diperbarui: <?= date('d M Y, H:i') ?> WIB</span>
        </div>
    </div>

    <!-- ========== QUICK STATS BAR ========== -->
    <div class="quick-stats-grid">
        <!-- Total Pendaftar -->
        <div class="stat-card-modern">
            <div class="stat-card-content">
                <div class="stat-info">
                    <h3><?= number_format($stats['total_applicants']); ?></h3>
                    <p>Total Pendaftar</p>
                </div>
                <div class="stat-icon-modern">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="stat-footer">
                <div class="stat-trend up">
                    <i class="bi bi-arrow-up"></i>
                    <span>+12%</span>
                </div>
                <a href="/admin/applicants" class="stat-link">
                    Lihat Detail <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="stat-card-modern warning">
            <div class="stat-card-content">
                <div class="stat-info">
                    <h3><?= number_format($stats['pending']); ?></h3>
                    <p>Menunggu Verifikasi</p>
                </div>
                <div class="stat-icon-modern">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
            <div class="stat-footer">
                <div class="stat-trend">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Perlu Tindakan</span>
                </div>
                <a href="/admin/applicants?status=pending" class="stat-link">
                    Verifikasi Sekarang <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Terverifikasi -->
        <div class="stat-card-modern success">
            <div class="stat-card-content">
                <div class="stat-info">
                    <h3><?= number_format($stats['verified']); ?></h3>
                    <p>Terverifikasi</p>
                </div>
                <div class="stat-icon-modern">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
            <div class="stat-footer">
                <div class="stat-trend up">
                    <i class="bi bi-arrow-up"></i>
                    <span>+8%</span>
                </div>
                <a href="/admin/applicants?status=verified" class="stat-link">
                    Lihat Detail <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Diterima -->
        <div class="stat-card-modern success">
            <div class="stat-card-content">
                <div class="stat-info">
                    <h3><?= number_format($stats['accepted']); ?></h3>
                    <p>Diterima</p>
                </div>
                <div class="stat-icon-modern">
                    <i class="bi bi-trophy-fill"></i>
                </div>
            </div>
            <div class="stat-footer">
                <div class="stat-trend up">
                    <i class="bi bi-arrow-up"></i>
                    <span>+15%</span>
                </div>
                <a href="/admin/applicants?status=accepted" class="stat-link">
                    Lihat Detail <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- ========== QUICK ACTIONS PANEL ========== -->
    <div class="quick-actions-panel">
        <div class="panel-header">
            <h2>
                <i class="bi bi-lightning-charge-fill"></i>
                Quick Actions
            </h2>
        </div>
        <div class="quick-actions-grid">
            <a href="/admin/applicants/verify-batch" class="action-button">
                <div class="icon">
                    <i class="bi bi-check2-square"></i>
                </div>
                <span class="label">Verifikasi Massal</span>
                <span class="description"><?= $stats['pending']; ?> pending</span>
            </a>

            <a href="/admin/applicants/create" class="action-button">
                <div class="icon">
                    <i class="bi bi-person-plus"></i>
                </div>
                <span class="label">Tambah Pendaftar</span>
                <span class="description">Input manual</span>
            </a>

            <a href="/admin/quotas" class="action-button">
                <div class="icon">
                    <i class="bi bi-bar-chart-line"></i>
                </div>
                <span class="label">Kelola Kuota</span>
                <span class="description">Atur jurusan</span>
            </a>

            <a href="/admin/reports/export" class="action-button">
                <div class="icon">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                </div>
                <span class="label">Export Data</span>
                <span class="description">Excel/PDF</span>
            </a>

            <a href="/admin/announcements" class="action-button">
                <div class="icon">
                    <i class="bi bi-megaphone"></i>
                </div>
                <span class="label">Pengumuman</span>
                <span class="description">Broadcast</span>
            </a>

            <a href="/admin/settings" class="action-button">
                <div class="icon">
                    <i class="bi bi-gear"></i>
                </div>
                <span class="label">Pengaturan</span>
                <span class="description">Konfigurasi</span>
            </a>
        </div>
    </div>

    <!-- ========== AI INSIGHTS PANEL ========== -->
    <div class="ai-insights-panel">
        <div class="panel-header">
            <h2>
                <i class="bi bi-lightbulb-fill"></i>
                Smart Insights
            </h2>
        </div>
        <div class="insights-grid">
            <div class="insight-card">
                <div class="insight-icon">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <h3>Perhatian Khusus</h3>
                <p><?= $stats['pending']; ?> pendaftaran memerlukan verifikasi segera. Rata-rata waktu verifikasi: 2 hari.</p>
            </div>

            <div class="insight-card">
                <div class="insight-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h3>Tren Pendaftaran</h3>
                <p>Peningkatan 12% dari bulan lalu. Prediksi target kuota tercapai dalam 3 minggu.</p>
            </div>

            <div class="insight-card">
                <div class="insight-icon">
                    <i class="bi bi-star"></i>
                </div>
                <h3>Jurusan Favorit</h3>
                <p>Teknik Informatika paling diminati (45% dari total). Pertimbangkan tambahan kuota.</p>
            </div>
        </div>
    </div>

    <!-- ========== QUOTA MONITORING SECTION (NEW!) ========== -->
    <?php if (!empty($activeYear) && !empty($quotaStats)): ?>
    <?php 
        // Calculate quota statistics for monitoring
        $fullQuotas = [];
        $almostFullQuotas = [];
        $availableQuotas = [];
        
        foreach ($quotaStats as $quota) {
            $persentase = $quota['kuota_total'] > 0 ? round(($quota['kuota_terisi'] / $quota['kuota_total']) * 100, 1) : 0;
            
            if ($persentase >= 100) {
                $fullQuotas[] = array_merge($quota, ['persentase' => $persentase]);
            } elseif ($persentase >= 90) {
                $almostFullQuotas[] = array_merge($quota, ['persentase' => $persentase]);
            } elseif ($persentase < 50) {
                $availableQuotas[] = array_merge($quota, ['persentase' => $persentase]);
            }
        }
    ?>
    
    <div class="quota-monitoring-section" style="margin-bottom: var(--space-8);">
        <div class="chart-card-modern col-span-12">
            <div class="chart-header-modern">
                <div>
                    <h3>
                        <i class="bi bi-speedometer2"></i>
                        Monitor Kuota Jurusan
                    </h3>
                    <small>Status Real-Time Kuota - Tahun Ajaran <?= esc($activeYear['tahun_ajaran']); ?></small>
                </div>
            </div>
            
            <!-- Alert Boxes -->
            <div class="quota-alerts" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-4); margin-top: var(--space-6);">
                
                <!-- Full Quotas Alert -->
                <div class="alert-box alert-danger" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-left: 4px solid #dc2626; border-radius: var(--radius-lg); padding: var(--space-4);">
                    <div style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-3);">
                        <div style="width: 48px; height: 48px; background: #dc2626; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: var(--text-2xl);">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0; font-size: var(--text-lg); font-weight: var(--font-bold); color: #991b1b;">
                                Kuota PENUH
                            </h4>
                            <p style="margin: 0; font-size: var(--text-sm); color: #b91c1c;"><?= count($fullQuotas); ?> Jurusan</p>
                        </div>
                    </div>
                    <?php if (!empty($fullQuotas)): ?>
                        <ul style="margin: 0; padding-left: var(--space-5); font-size: var(--text-sm); color: #7f1d1d);">
                            <?php foreach ($fullQuotas as $q): ?>
                                <li style="margin-bottom: var(--space-1);">
                                    <strong><?= esc($q['nama_jurusan']); ?></strong> - <?= $q['persentase']; ?>% (<?= $q['kuota_terisi']; ?>/<?= $q['kuota_total']; ?>)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p style="margin: 0; font-size: var(--text-sm); color: #7f1d1d;">✓ Tidak ada jurusan yang penuh</p>
                    <?php endif; ?>
                </div>

                <!-- Almost Full Alert -->
                <div class="alert-box alert-warning" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-left: 4px solid #d97706; border-radius: var(--radius-lg); padding: var(--space-4);">
                    <div style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-3);">
                        <div style="width: 48px; height: 48px; background: #d97706; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: var(--text-2xl);">
                            <i class="bi bi-exclamation-circle-fill"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0; font-size: var(--text-lg); font-weight: var(--font-bold); color: #92400e;">
                                Hampir Penuh (≥90%)
                            </h4>
                            <p style="margin: 0; font-size: var(--text-sm); color: #b45309;"><?= count($almostFullQuotas); ?> Jurusan</p>
                        </div>
                    </div>
                    <?php if (!empty($almostFullQuotas)): ?>
                        <ul style="margin: 0; padding-left: var(--space-5); font-size: var(--text-sm); color: #78350f);">
                            <?php foreach ($almostFullQuotas as $q): ?>
                                <li style="margin-bottom: var(--space-1);">
                                    <strong><?= esc($q['nama_jurusan']); ?></strong> - <?= $q['persentase']; ?>% (<?= $q['kuota_terisi']; ?>/<?= $q['kuota_total']; ?>)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p style="margin: 0; font-size: var(--text-sm); color: #78350f;">✓ Tidak ada jurusan hampir penuh</p>
                    <?php endif; ?>
                </div>

                <!-- Available Quotas -->
                <div class="alert-box alert-success" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-left: 4px solid #059669; border-radius: var(--radius-lg); padding: var(--space-4);">
                    <div style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-3);">
                        <div style="width: 48px; height: 48px; background: #059669; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: var(--text-2xl);">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0; font-size: var(--text-lg); font-weight: var(--font-bold); color: #065f46;">
                                Masih Tersedia (&lt;50%)
                            </h4>
                            <p style="margin: 0; font-size: var(--text-sm); color: #047857;"><?= count($availableQuotas); ?> Jurusan</p>
                        </div>
                    </div>
                    <?php if (!empty($availableQuotas)): ?>
                        <ul style="margin: 0; padding-left: var(--space-5); font-size: var(--text-sm); color: #064e3b);">
                            <?php foreach (array_slice($availableQuotas, 0, 3) as $q): ?>
                                <li style="margin-bottom: var(--space-1);">
                                    <strong><?= esc($q['nama_jurusan']); ?></strong> - <?= $q['persentase']; ?>% (<?= $q['kuota_sisa']; ?> sisa)
                                </li>
                            <?php endforeach; ?>
                            <?php if (count($availableQuotas) > 3): ?>
                                <li style="color: #047857; font-style: italic;">+<?= count($availableQuotas) - 3; ?> jurusan lainnya</li>
                            <?php endif; ?>
                        </ul>
                    <?php else: ?>
                        <p style="margin: 0; font-size: var(--text-sm); color: #064e3b;">Semua jurusan sudah terisi ≥50%</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Visual Quota Bar Chart -->
            <div style="margin-top: var(--space-8);">
                <canvas id="quotaMonitorChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ========== CHARTS GRID ========== -->
    <div class="charts-grid">
        <!-- Registration Trend Chart -->
        <div class="chart-card-modern col-span-8">
            <div class="chart-header-modern">
                <div>
                    <h3>
                        <i class="bi bi-graph-up"></i>
                        Tren Pendaftaran
                    </h3>
                    <small>6 Bulan Terakhir</small>
                </div>
                <div class="chart-controls">
                    <button class="chart-control-btn active">6M</button>
                    <button class="chart-control-btn">3M</button>
                    <button class="chart-control-btn">1M</button>
                    <button class="chart-control-btn">7D</button>
                </div>
            </div>
            <div style="position: relative; height: 300px;">
                <canvas id="registrationChart"></canvas>
            </div>
        </div>

        <!-- Status Distribution Chart -->
        <div class="chart-card-modern col-span-4">
            <div class="chart-header-modern">
                <div>
                    <h3>
                        <i class="bi bi-pie-chart-fill"></i>
                        Distribusi Status
                    </h3>
                    <small>Status Pendaftar</small>
                </div>
            </div>
            <div style="position: relative; height: 300px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- ========== ACTIVITY TIMELINE ========== -->
    <div class="activity-timeline-panel">
        <div class="panel-header">
            <h2>
                <i class="bi bi-activity"></i>
                Aktivitas Terkini
            </h2>
        </div>
        <div class="timeline-list">
            <div class="timeline-item">
                <div class="timeline-marker pulse"></div>
                <div class="timeline-content">
                    <div class="title">
                        <i class="bi bi-person-check text-success"></i>
                        15 pendaftar baru terverifikasi
                    </div>
                    <div class="description">
                        Verifikasi otomatis berhasil dijalankan untuk batch A-023
                    </div>
                    <div class="meta">
                        <span><i class="bi bi-clock"></i> 5 menit yang lalu</span>
                        <span><i class="bi bi-person"></i> Admin System</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="title">
                        <i class="bi bi-file-earmark-check text-primary"></i>
                        Data berhasil di-export
                    </div>
                    <div class="description">
                        Report pendaftaran bulan Januari 2024 (.xlsx)
                    </div>
                    <div class="meta">
                        <span><i class="bi bi-clock"></i> 2 jam yang lalu</span>
                        <span><i class="bi bi-person"></i> <?= session()->get('name'); ?></span>
                    </div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="title">
                        <i class="bi bi-megaphone text-warning"></i>
                        Pengumuman baru dipublikasikan
                    </div>
                    <div class="description">
                        "Jadwal Tes Masuk Gelombang 2" telah dikirim ke 250 peserta
                    </div>
                    <div class="meta">
                        <span><i class="bi bi-clock"></i> 1 hari yang lalu</span>
                        <span><i class="bi bi-person"></i> Panitia</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="title">
                        <i class="bi bi-shield-check text-success"></i>
                        Backup database berhasil
                    </div>
                    <div class="description">
                        Automatic backup scheduled task completed successfully
                    </div>
                    <div class="meta">
                        <span><i class="bi bi-clock"></i> 1 hari yang lalu</span>
                        <span><i class="bi bi-person"></i> System</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== QUOTA STATISTICS ========== -->
    <?php if (!empty($activeYear) && !empty($quotaStats)): ?>
    <?php 
        $totalKuota = 0;
        $totalTerisi = 0;
        foreach ($quotaStats as $quota) {
            $totalKuota += $quota['kuota_total'];
            $totalTerisi += $quota['kuota_terisi'];
        }
        $totalSisa = $totalKuota - $totalTerisi;
        $persentaseKeseluruhan = $totalKuota > 0 ? round(($totalTerisi / $totalKuota) * 100, 2) : 0;
    ?>

    <!-- Quota Overview Cards -->
    <div class="quick-stats-grid" style="margin-top: var(--space-8);">
        <div class="stat-card-modern">
            <div class="stat-card-content">
                <div class="stat-info">
                    <h3><?= number_format($totalKuota); ?></h3>
                    <p>Total Kuota</p>
                </div>
                <div class="stat-icon-modern">
                    <i class="bi bi-bar-chart-fill"></i>
                </div>
            </div>
        </div>

        <div class="stat-card-modern success">
            <div class="stat-card-content">
                <div class="stat-info">
                    <h3><?= number_format($totalTerisi); ?></h3>
                    <p>Kuota Terisi</p>
                </div>
                <div class="stat-icon-modern">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>

        <div class="stat-card-modern warning">
            <div class="stat-card-content">
                <div class="stat-info">
                    <h3><?= number_format($totalSisa); ?></h3>
                    <p>Sisa Kuota</p>
                </div>
                <div class="stat-icon-modern">
                    <i class="bi bi-inbox"></i>
                </div>
            </div>
        </div>

        <div class="stat-card-modern">
            <div class="stat-card-content">
                <div class="stat-info">
                    <h3><?= $persentaseKeseluruhan; ?>%</h3>
                    <p>Progress Pengisian</p>
                </div>
                <div class="stat-icon-modern">
                    <i class="bi bi-speedometer2"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quota Chart & Table -->
    <div class="charts-grid" style="margin-top: var(--space-6);">
        <div class="chart-card-modern col-span-8">
            <div class="chart-header-modern">
                <div>
                    <h3>
                        <i class="bi bi-mortarboard-fill"></i>
                        Kuota Per Jurusan
                    </h3>
                    <small>Tahun Ajaran <?= esc($activeYear['tahun_ajaran']); ?></small>
                </div>
                <a href="/admin/quotas" class="btn btn-primary btn-sm">
                    <i class="bi bi-gear"></i> Kelola Kuota
                </a>
            </div>
            <div style="position: relative; height: 300px;">
                <canvas id="quotaBarChart"></canvas>
            </div>
        </div>

        <div class="chart-card-modern col-span-4">
            <div class="chart-header-modern">
                <div>
                    <h3>
                        <i class="bi bi-pie-chart-fill"></i>
                        Persentase Kuota
                    </h3>
                    <small>Progress Keseluruhan</small>
                </div>
            </div>
            <div style="position: relative; height: 250px;">
                <canvas id="quotaDoughnutChart"></canvas>
            </div>
            <div class="text-center mt-4">
                <h3 class="mb-0" style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--primary-600);">
                    <?= $persentaseKeseluruhan; ?>%
                </h3>
                <p style="color: var(--neutral-600); margin: 0;">Kuota Terisi</p>
            </div>
        </div>
    </div>

    <!-- Quota Details Table -->
    <div class="chart-card-modern col-span-12" style="margin-top: var(--space-6);">
        <div class="chart-header-modern">
            <div>
                <h3>
                    <i class="bi bi-table"></i>
                    Detail Kuota Jurusan
                </h3>
                <small><?= count($quotaStats); ?> Jurusan Aktif</small>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline btn-sm" onclick="exportToExcel()">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </button>
                <button class="btn btn-outline btn-sm" onclick="exportToPDF()">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table-modern" id="quotaTable">
                <thead>
                    <tr>
                        <th>Jurusan</th>
                        <th>Total Kuota</th>
                        <th>Terisi</th>
                        <th>Sisa</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quotaStats as $quota): ?>
                    <?php 
                        $persentase = $quota['kuota_total'] > 0 
                            ? round(($quota['kuota_terisi'] / $quota['kuota_total']) * 100, 1) 
                            : 0;
                    ?>
                    <tr>
                        <td style="font-weight: var(--font-semibold); color: var(--neutral-900);">
                            <i class="bi bi-book"></i>
                            <?= esc($quota['nama_jurusan']); ?>
                        </td>
                        <td><?= number_format($quota['kuota_total']); ?></td>
                        <td>
                            <span class="badge badge-success">
                                <?= number_format($quota['kuota_terisi']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-warning">
                                <?= number_format($quota['kuota_sisa']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="progress-cell">
                                <div class="progress-bar-cell">
                                    <div class="progress-fill" style="width: <?= $persentase; ?>%;"></div>
                                </div>
                                <span class="progress-text"><?= $persentase; ?>%</span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- Dashboard Charts Script -->
<script>
// Registration Trend Chart
const ctxRegistration = document.getElementById('registrationChart');
if (ctxRegistration) {
    new Chart(ctxRegistration, {
        type: 'line',
        data: {
            labels: ['Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Pendaftaran',
                data: [45, 62, 75, 89, 105, 122],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#e2e8f0' },
                    ticks: { font: { size: 12 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } }
                }
            }
        }
    });
}

// Status Distribution Chart
const ctxStatus = document.getElementById('statusChart');
if (ctxStatus) {
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Verified', 'Accepted', 'Rejected'],
            datasets: [{
                data: [
                    <?= $stats['pending']; ?>,
                    <?= $stats['verified']; ?>,
                    <?= $stats['accepted']; ?>,
                    <?= $stats['rejected'] ?? 0; ?>
                ],
                backgroundColor: ['#f59e0b', '#10b981', '#3b82f6', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 12 },
                        usePointStyle: true
                    }
                }
            }
        }
    });
}

<?php if (!empty($quotaStats)): ?>
// Quota Bar Chart
const ctxQuotaBar = document.getElementById('quotaBarChart');
if (ctxQuotaBar) {
    new Chart(ctxQuotaBar, {
        type: 'bar',
        data: {
            labels: [<?php foreach ($quotaStats as $q): ?>'<?= esc($q['nama_jurusan']); ?>',<?php endforeach; ?>],
            datasets: [{
                label: 'Terisi',
                data: [<?php foreach ($quotaStats as $q): ?><?= $q['kuota_terisi']; ?>,<?php endforeach; ?>],
                backgroundColor: '#10b981',
                borderRadius: 8
            }, {
                label: 'Sisa',
                data: [<?php foreach ($quotaStats as $q): ?><?= $q['kuota_sisa']; ?>,<?php endforeach; ?>],
                backgroundColor: '#e2e8f0',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { padding: 15, font: { size: 12 }, usePointStyle: true }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    stacked: true,
                    grid: { color: '#e2e8f0' }
                },
                x: {
                    stacked: true,
                    grid: { display: false }
                }
            }
        }
    });
}

// Quota Doughnut Chart
const ctxQuotaDoughnut = document.getElementById('quotaDoughnutChart');
if (ctxQuotaDoughnut) {
    new Chart(ctxQuotaDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Terisi', 'Sisa'],
            datasets: [{
                data: [<?= $totalTerisi; ?>, <?= $totalSisa; ?>],
                backgroundColor: ['#3b82f6', '#e2e8f0'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });
}

// ========== QUOTA MONITORING CHART (NEW!) ==========
const ctxQuotaMonitor = document.getElementById('quotaMonitorChart');
if (ctxQuotaMonitor) {
    const quotaData = [
        <?php foreach ($quotaStats as $q): ?>
        {
            nama: '<?= esc($q['nama_jurusan']); ?>',
            total: <?= $q['kuota_total']; ?>,
            terisi: <?= $q['kuota_terisi']; ?>,
            sisa: <?= $q['kuota_sisa']; ?>,
            persentase: <?= $q['kuota_total'] > 0 ? round(($q['kuota_terisi'] / $q['kuota_total']) * 100, 1) : 0; ?>
        },
        <?php endforeach; ?>
    ];
    
    // Sort by persentase descending (paling full di kiri)
    quotaData.sort((a, b) => b.persentase - a.persentase);
    
    // Prepare chart data with color coding
    const labels = quotaData.map(q => q.nama);
    const percentages = quotaData.map(q => q.persentase);
    const colors = quotaData.map(q => {
        if (q.persentase >= 100) return '#dc2626'; // Red - Full
        if (q.persentase >= 90) return '#f59e0b';  // Orange - Almost Full
        if (q.persentase >= 70) return '#eab308';  // Yellow - High
        if (q.persentase >= 50) return '#3b82f6';  // Blue - Medium
        return '#10b981'; // Green - Available
    });
    
    new Chart(ctxQuotaMonitor, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Persentase Terisi (%)',
                data: percentages,
                backgroundColor: colors,
                borderRadius: 8,
                borderWidth: 2,
                borderColor: colors.map(c => c)
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y', // Horizontal bar
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 16,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const q = quotaData[index];
                            return [
                                `Terisi: ${q.terisi} dari ${q.total} (${q.persentase}%)`,
                                `Sisa Kuota: ${q.sisa}`,
                                `Status: ${q.persentase >= 100 ? '🔴 PENUH' : q.persentase >= 90 ? '🟠 HAMPIR PENUH' : q.persentase >= 70 ? '🟡 TINGGI' : q.persentase >= 50 ? '🔵 SEDANG' : '🟢 TERSEDIA'}`
                            ];
                        }
                    }
                },
                datalabels: false
            },
            scales: {
                x: {
                    beginAtZero: true,
                    max: 110,
                    grid: { 
                        color: '#e2e8f0',
                        drawBorder: false
                    },
                    ticks: { 
                        font: { size: 11 },
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                y: {
                    grid: { display: false },
                    ticks: { 
                        font: { size: 12, weight: '600' },
                        color: '#334155'
                    }
                }
            },
            // Draw reference lines
            plugins: [{
                afterDraw: (chart) => {
                    const ctx = chart.ctx;
                    const yAxis = chart.scales.y;
                    const xAxis = chart.scales.x;
                    
                    // 100% line (Full)
                    const x100 = xAxis.getPixelForValue(100);
                    ctx.save();
                    ctx.strokeStyle = '#dc2626';
                    ctx.lineWidth = 2;
                    ctx.setLineDash([5, 5]);
                    ctx.beginPath();
                    ctx.moveTo(x100, yAxis.top);
                    ctx.lineTo(x100, yAxis.bottom);
                    ctx.stroke();
                    ctx.restore();
                    
                    // 90% line (Almost Full)
                    const x90 = xAxis.getPixelForValue(90);
                    ctx.save();
                    ctx.strokeStyle = '#f59e0b';
                    ctx.lineWidth = 1;
                    ctx.setLineDash([3, 3]);
                    ctx.beginPath();
                    ctx.moveTo(x90, yAxis.top);
                    ctx.lineTo(x90, yAxis.bottom);
                    ctx.stroke();
                    ctx.restore();
                }
            }]
        }
    });
    
    // Auto-refresh alert if any quota is full or almost full
    const fullCount = quotaData.filter(q => q.persentase >= 100).length;
    const almostFullCount = quotaData.filter(q => q.persentase >= 90 && q.persentase < 100).length;
    
    if (fullCount > 0) {
        console.log(`⚠️ ALERT: ${fullCount} jurusan sudah PENUH!`);
    }
    if (almostFullCount > 0) {
        console.log(`⚠️ WARNING: ${almostFullCount} jurusan hampir penuh (≥90%)`);
    }
}
<?php endif; ?>

// Chart control buttons
document.querySelectorAll('.chart-control-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.chart-control-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        // Add logic to update chart data based on selected period
    });
});
</script>

<?= $this->endSection(); ?>
