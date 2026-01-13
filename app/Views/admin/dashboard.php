<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Dashboard Admin<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1 fw-bold">Dashboard Admin</h3>
        <p class="text-muted mb-0">Selamat datang, kelola sistem PPDB dengan mudah</p>
    </div>
    <div class="text-end">
        <small class="text-muted d-block">Terakhir diperbarui</small>
        <small class="fw-semibold"><?= date('d M Y, H:i') ?></small>
    </div>
</div>

<!-- Statistics Cards (Simplified) -->
<div class="row g-3 mb-4">
    <!-- Total Pendaftar -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-lg bg-primary bg-opacity-10 text-primary rounded">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="mb-0 fw-bold"><?= $stats['total_applicants']; ?></h4>
                        <small class="text-muted">Total Pendaftar</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-lg bg-warning bg-opacity-10 text-warning rounded">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="mb-0 fw-bold"><?= $stats['pending']; ?></h4>
                        <small class="text-muted">Menunggu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verified -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-lg bg-info bg-opacity-10 text-info rounded">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="mb-0 fw-bold"><?= $stats['verified']; ?></h4>
                        <small class="text-muted">Terverifikasi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accepted -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-lg bg-success bg-opacity-10 text-success rounded">
                            <i class="bi bi-check-lg fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="mb-0 fw-bold"><?= $stats['accepted']; ?></h4>
                        <small class="text-muted">Diterima</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Graphics Section -->
<div class="row g-3 mb-4">
    <!-- Registration Trend Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-graph-up text-primary me-2"></i>
                    Tren Pendaftaran
                </h5>
                <small class="text-muted">6 Bulan Terakhir</small>
            </div>
            <div class="card-body">
                <canvas id="registrationChart" height="80"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Status Distribution Chart -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pie-chart text-primary me-2"></i>
                    Status Pendaftar
                </h5>
                <small class="text-muted">Distribusi Status</small>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Gender Distribution Chart -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-bar-chart text-primary me-2"></i>
                    Distribusi Gender
                </h5>
                <small class="text-muted">Perbandingan Jenis Kelamin</small>
            </div>
            <div class="card-body">
                <canvas id="genderChart" height="60"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action Buttons -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <h5 class="mb-3 fw-semibold"><i class="bi bi-lightning-fill text-warning me-2"></i>Aksi Cepat</h5>
        <div class="d-flex flex-wrap gap-2">
            <a href="/admin/applicants/submitted" class="btn btn-warning">
                <i class="bi bi-clock-history me-1"></i> Verifikasi (<?= $stats['pending']; ?>)
            </a>
            <a href="/admin/payments" class="btn btn-info">
                <i class="bi bi-credit-card me-1"></i> Pembayaran
            </a>
            <a href="/admin/applicant-register" class="btn btn-dark">
                <i class="bi bi-plus-circle me-1"></i> Tambah Pendaftar
            </a>
            <a href="/admin/kelola-akun" class="btn btn-secondary">
                <i class="bi bi-people me-1"></i> Kelola Akun
            </a>
        </div>
    </div>
</div>

<!-- Main Menu Grid -->
<div class="row g-3">
    <!-- Data Pendaftar -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-people-fill text-primary me-2"></i>Data Pendaftar</h6>
            </div>
            <div class="list-group list-group-flush">
                <a href="/admin/applicants" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-list-ul me-2 text-muted"></i>Semua Pendaftar</span>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
                <a href="/admin/applicants/submitted" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clock me-2 text-warning"></i>Menunggu</span>
                    <span class="badge bg-warning rounded-pill"><?= $stats['pending']; ?></span>
                </a>
                <a href="/admin/applicants/verified" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-check-circle me-2 text-info"></i>Terverifikasi</span>
                    <span class="badge bg-info rounded-pill"><?= $stats['verified']; ?></span>
                </a>
                <a href="/admin/applicants/accepted" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-check2-all me-2 text-success"></i>Diterima</span>
                    <span class="badge bg-success rounded-pill"><?= $stats['accepted']; ?></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Pembayaran -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-credit-card-fill text-success me-2"></i>Pembayaran</h6>
            </div>
            <div class="list-group list-group-flush">
                <a href="/admin/payments" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-receipt me-2 text-muted"></i>Kelola Pembayaran</span>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
                <a href="/admin/manual-payment" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-cash-coin me-2 text-muted"></i>Input Manual</span>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
                <a href="/admin/verifikasi-pendaftar" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clipboard-check me-2 text-muted"></i>Verifikasi Pendaftar</span>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Pengaturan Sistem -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-gear-fill text-danger me-2"></i>Pengaturan</h6>
            </div>
            <div class="list-group list-group-flush">
                <a href="/admin/kelola-akun" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-person-gear me-2 text-muted"></i>Kelola Akun</span>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
                <a href="/admin/kelola-kop-surat" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-file-text me-2 text-muted"></i>Kop Surat</span>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.avatar {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.card-header {
    padding: 1rem 1.25rem;
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
