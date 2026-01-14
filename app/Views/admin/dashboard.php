<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Dashboard Admin<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">

<!-- Dashboard Header Section -->
<div class="dashboard-header">
    <h1><i class="bi bi-graph-up me-2"></i>Dashboard Admin</h1>
    <p>Selamat datang, kelola sistem PPDB dengan mudah</p>
    <small style="opacity: 0.8; display: block; margin-top: 1rem;">Terakhir diperbarui: <?= date('d M Y, H:i') ?></small>
</div>

<!-- Statistics Cards Section -->
<div class="row g-4 mb-5" style="margin-top: 2.5rem;">
    <!-- Total Pendaftar -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon">
                    <i class="bi bi-people fs-5"></i>
                </div>
                <div>
                    <div class="stat-value"><?= $stats['total_applicants']; ?></div>
                    <div class="stat-label">Total Pendaftar</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card pending">
            <div class="d-flex align-items-center">
                <div class="stat-icon">
                    <i class="bi bi-clock-history fs-5"></i>
                </div>
                <div>
                    <div class="stat-value"><?= $stats['pending']; ?></div>
                    <div class="stat-label">Menunggu Verifikasi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verified -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card verified">
            <div class="d-flex align-items-center">
                <div class="stat-icon">
                    <i class="bi bi-check-circle fs-5"></i>
                </div>
                <div>
                    <div class="stat-value"><?= $stats['verified']; ?></div>
                    <div class="stat-label">Terverifikasi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accepted -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card accepted">
            <div class="d-flex align-items-center">
                <div class="stat-icon">
                    <i class="bi bi-check-lg fs-5"></i>
                </div>
                <div>
                    <div class="stat-value"><?= $stats['accepted']; ?></div>
                    <div class="stat-label">Diterima</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Graphics Section -->
<div class="row g-4 mb-5">
    <!-- Registration Trend Chart -->
    <div class="col-lg-8">
        <div class="chart-card h-100">
            <div class="chart-header">
                <h5><i class="bi bi-graph-up"></i>Tren Pendaftaran</h5>
                <small>6 Bulan Terakhir</small>
            </div>
            <div class="chart-body">
                <div class="trend-chart">
                    <canvas id="registrationChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Status Distribution Chart -->
    <div class="col-lg-4">
        <div class="chart-card h-100">
            <div class="chart-header">
                <h5><i class="bi bi-pie-chart"></i>Distribusi Status</h5>
                <small>Status Pendaftar</small>
            </div>
            <div class="chart-body">
                <div class="status-donut">
                    <canvas id="statusChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gender Distribution Chart -->
<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="chart-card">
            <div class="chart-header">
                <h5><i class="bi bi-bar-chart"></i>Distribusi Gender</h5>
                <small>Perbandingan Jenis Kelamin</small>
            </div>
            <div class="chart-body">
                <canvas id="genderChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action Buttons -->
<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="chart-card">
            <div class="chart-header">
                <h5><i class="bi bi-lightning-fill" style="color: #f59e0b;"></i>Aksi Cepat</h5>
            </div>
            <div class="chart-body">
                <div class="d-flex flex-wrap gap-2">
                    <a href="/admin/applicants/submitted" class="action-btn warning">
                        <i class="bi bi-clock-history"></i> Verifikasi (<?= $stats['pending']; ?>)
                    </a>
                    <a href="/admin/payments" class="action-btn info">
                        <i class="bi bi-credit-card"></i> Pembayaran
                    </a>
                    <a href="/admin/applicant-register" class="action-btn primary">
                        <i class="bi bi-plus-circle"></i> Tambah Pendaftar
                    </a>
                    <a href="/admin/kelola-akun" class="action-btn secondary">
                        <i class="bi bi-people"></i> Kelola Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Menu Grid -->
<div class="row g-4">
    <!-- Data Pendaftar -->
    <div class="col-md-6 col-lg-4">
        <div class="chart-card h-100">
            <div class="chart-header">
                <h5><i class="bi bi-people-fill"></i>Data Pendaftar</h5>
            </div>
            <div class="chart-body" style="padding: 0;">
                <div class="list-group list-group-flush">
                    <a href="/admin/applicants" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="border: none; padding: 0.875rem 1.5rem;">
                        <span><i class="bi bi-list-ul me-2" style="color: #6b7280;"></i>Semua Pendaftar</span>
                        <i class="bi bi-chevron-right" style="color: #6b7280;"></i>
                    </a>
                    <a href="/admin/applicants/submitted" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="border: none; padding: 0.875rem 1.5rem;">
                        <span><i class="bi bi-clock me-2" style="color: #f59e0b;"></i>Menunggu</span>
                        <span class="badge rounded-pill" style="background: #f59e0b; color: white;"><?= $stats['pending']; ?></span>
                    </a>
                    <a href="/admin/applicants/verified" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="border: none; padding: 0.875rem 1.5rem;">
                        <span><i class="bi bi-check-circle me-2" style="color: #06b6d4;"></i>Terverifikasi</span>
                        <span class="badge rounded-pill" style="background: #06b6d4; color: white;"><?= $stats['verified']; ?></span>
                    </a>
                    <a href="/admin/applicants/accepted" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="border: none; padding: 0.875rem 1.5rem; border-radius: 0 0 0.75rem 0.75rem;">
                        <span><i class="bi bi-check2-all me-2" style="color: #10b981;"></i>Diterima</span>
                        <span class="badge rounded-pill" style="background: #10b981; color: white;"><?= $stats['accepted']; ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pembayaran -->
    <div class="col-md-6 col-lg-4">
        <div class="chart-card h-100">
            <div class="chart-header">
                <h5><i class="bi bi-credit-card-fill"></i>Pembayaran</h5>
            </div>
            <div class="chart-body" style="padding: 0;">
                <div class="list-group list-group-flush">
                    <a href="/admin/payments" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="border: none; padding: 0.875rem 1.5rem;">
                        <span><i class="bi bi-receipt me-2" style="color: #6b7280;"></i>Kelola Pembayaran</span>
                        <i class="bi bi-chevron-right" style="color: #6b7280;"></i>
                    </a>
                    <a href="/admin/manual-payment" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="border: none; padding: 0.875rem 1.5rem;">
                        <span><i class="bi bi-cash-coin me-2" style="color: #6b7280;"></i>Input Manual</span>
                        <i class="bi bi-chevron-right" style="color: #6b7280;"></i>
                    </a>
                    <a href="/admin/verifikasi-pendaftar" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="border: none; padding: 0.875rem 1.5rem; border-radius: 0 0 0.75rem 0.75rem;">
                        <span><i class="bi bi-clipboard-check me-2" style="color: #6b7280;"></i>Verifikasi Pendaftar</span>
                        <i class="bi bi-chevron-right" style="color: #6b7280;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaturan Sistem -->
    <div class="col-md-6 col-lg-4">
        <div class="chart-card h-100">
            <div class="chart-header">
                <h5><i class="bi bi-gear-fill"></i>Pengaturan</h5>
            </div>
            <div class="chart-body" style="padding: 0;">
                <div class="list-group list-group-flush">
                    <a href="/admin/kelola-akun" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="border: none; padding: 0.875rem 1.5rem;">
                        <span><i class="bi bi-person-gear me-2" style="color: #6b7280;"></i>Kelola Akun</span>
                        <i class="bi bi-chevron-right" style="color: #6b7280;"></i>
                    </a>
                    <a href="/admin/kelola-kop-surat" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="border: none; padding: 0.875rem 1.5rem; border-radius: 0 0 0.75rem 0.75rem;">
                        <span><i class="bi bi-file-text me-2" style="color: #6b7280;"></i>Kop Surat</span>
                        <i class="bi bi-chevron-right" style="color: #6b7280;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
.list-group-item {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-left: 3px solid #3b82f6;
    border-right: none;
    padding: 0.875rem 1.5rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #1e293b;
}

.list-group-item:first-child {
    border-top: 1px solid #e5e7eb;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.list-group-item:last-child {
    border-bottom: 1px solid #e5e7eb;
    border-radius: 0 0 12px 12px;
}

.list-group-item:hover {
    background-color: #f8fafc;
    transform: translateX(4px);
    border-left-color: #2563eb;
}

.list-group-item i {
    color: #64748b;
}

.list-group-item:hover i {
    color: #3b82f6;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    border: none;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    text-decoration: none;
    color: inherit;
}
</style>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Registration Trend Chart (Line Chart)
    const registrationCtx = document.getElementById('registrationChart');
    if (registrationCtx) {
        const monthlyData = <?= json_encode($monthlyData ?? []) ?>;
        
        // Format months to readable format
        const months = monthlyData.map(item => {
            const date = new Date(item.month + '-01');
            return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
        });
        const totals = monthlyData.map(item => parseInt(item.total));
        
        new Chart(registrationCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: totals,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#3b82f6',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // Status Distribution Chart (Doughnut Chart)
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statusData = <?= json_encode($statusData ?? []) ?>;
        
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Terverifikasi', 'Diterima', 'Ditolak'],
                datasets: [{
                    data: [
                        statusData.pending || 0,
                        statusData.verified || 0,
                        statusData.accepted || 0,
                        statusData.rejected || 0
                    ],
                    backgroundColor: [
                        '#f59e0b',
                        '#06b6d4',
                        '#10b981',
                        '#ef4444'
                    ],
                    borderWidth: 3,
                    borderColor: '#fff'
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
                            font: {
                                size: 12
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                }
            }
        });
    }
    
    // Gender Distribution Chart (Bar Chart)
    const genderCtx = document.getElementById('genderChart');
    if (genderCtx) {
        const genderData = <?= json_encode($genderData ?? []) ?>;
        
        const maleCount = genderData.find(g => g.jenis_kelamin === 'Laki-laki')?.total || 0;
        const femaleCount = genderData.find(g => g.jenis_kelamin === 'Perempuan')?.total || 0;
        
        new Chart(genderCtx, {
            type: 'bar',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    label: 'Jumlah',
                    data: [maleCount, femaleCount],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    borderColor: [
                        '#3b82f6',
                        '#ec4899'
                    ],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
});
</script>

<?= $this->endSection(); ?>
