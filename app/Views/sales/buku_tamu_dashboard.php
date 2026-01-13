<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-chart-bar me-2"></i><?= esc($title) ?></h2>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-primary mb-2">Total Data</h6>
                            <h3 class="mb-0"><?= $statistics['total'] ?></h3>
                        </div>
                        <div class="text-primary" style="font-size: 3rem; opacity: 0.2;">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-left-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-success mb-2">Data Hari Ini</h6>
                            <h3 class="mb-0"><?= $statistics['today'] ?></h3>
                        </div>
                        <div class="text-success" style="font-size: 3rem; opacity: 0.2;">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-left-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-info mb-2">Data Bulan Ini</h6>
                            <h3 class="mb-0"><?= $statistics['this_month'] ?></h3>
                        </div>
                        <div class="text-info" style="font-size: 3rem; opacity: 0.2;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <!-- Source Info Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Distribusi Sumber Informasi</h5>
                </div>
                <div class="card-body">
                    <canvas id="sourceChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- School Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>10 Sekolah Asal Terbanyak</h5>
                </div>
                <div class="card-body">
                    <canvas id="schoolChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex gap-2">
                <a href="<?= base_url('sales/buku-tamu') ?>" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Tambah Data
                </a>
                <a href="<?= base_url('sales/tracking-form') ?>" class="btn btn-primary">
                    <i class="fas fa-list me-2"></i>Lihat Semua Data
                </a>
                <a href="<?= base_url('sales/export-buku-tamu') ?>" class="btn btn-info">
                    <i class="fas fa-download me-2"></i>Export Data
                </a>
                <a href="<?= base_url('sales/buku-tamu-map') ?>" class="btn btn-warning">
                    <i class="fas fa-map me-2"></i>Lihat Peta
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Source Info Chart
    const sourceCtx = document.getElementById('sourceChart').getContext('2d');
    const sourceData = <?= json_encode($sourceStats) ?>;
    
    const sourceLabels = sourceData.map(item => item.sumber_info);
    const sourceCounts = sourceData.map(item => item.count);
    
    const colors = [
        '#FF6384',
        '#36A2EB',
        '#FFCE56',
        '#4BC0C0',
        '#9966FF',
        '#FF9F40',
        '#FF6384'
    ];
    
    new Chart(sourceCtx, {
        type: 'doughnut',
        data: {
            labels: sourceLabels,
            datasets: [{
                data: sourceCounts,
                backgroundColor: colors.slice(0, sourceLabels.length),
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });

    // School Chart
    const schoolCtx = document.getElementById('schoolChart').getContext('2d');
    const schoolData = <?= json_encode($schoolStats) ?>;
    
    const schoolLabels = schoolData.map(item => item.asal_sekolah);
    const schoolCounts = schoolData.map(item => item.count);
    
    new Chart(schoolCtx, {
        type: 'bar',
        data: {
            labels: schoolLabels,
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: schoolCounts,
                backgroundColor: '#FF9800',
                borderColor: '#F57C00',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>

<style>
    .border-left-primary {
        border-left: 4px solid #007bff;
    }

    .border-left-success {
        border-left: 4px solid #28a745;
    }

    .border-left-info {
        border-left: 4px solid #17a2b8;
    }

    .card {
        border-radius: 8px;
        border: none;
    }

    .card-header {
        border-radius: 8px 8px 0 0;
    }

    h3 {
        color: #333;
        font-weight: 700;
    }

    .btn {
        border-radius: 6px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
    }
</style>
<?= $this->endSection() ?>
