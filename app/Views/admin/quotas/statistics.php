<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Statistik Kuota Jurusan<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-bar-chart"></i> Statistik Kuota Jurusan
    </h2>
    <a href="/admin/quotas" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- Filter Tahun Ajaran -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="get" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Pilih Tahun Ajaran</label>
                <select name="tahun_ajaran" class="form-select" onchange="this.form.submit()">
                    <?php foreach ($availableYears as $year): ?>
                        <option value="<?= esc($year) ?>" <?= ($selectedYear == $year) ? 'selected' : '' ?>>
                            <?= esc($year) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-white-50">Total Kuota</h6>
                <h2 class="card-title mb-0"><?= number_format($totalKuota); ?></h2>
                <small>Semua jurusan</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-white-50">Terisi</h6>
                <h2 class="card-title mb-0"><?= number_format($totalTerisi); ?></h2>
                <small><?= number_format($persentaseKeseluruhan, 1); ?>% dari total</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-white-50">Sisa</h6>
                <h2 class="card-title mb-0"><?= number_format($totalSisa); ?></h2>
                <small>Kuota tersedia</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-white-50">Jumlah Jurusan</h6>
                <h2 class="card-title mb-0"><?= count($quotaStats); ?></h2>
                <small>Tahun <?= esc($selectedYear); ?></small>
            </div>
        </div>
    </div>
</div>

<!-- Overall Progress -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title mb-3">Progress Keseluruhan</h5>
        <div class="progress" style="height: 30px;">
            <div class="progress-bar bg-success" 
                 role="progressbar" 
                 style="width: <?= $persentaseKeseluruhan ?>%"
                 aria-valuenow="<?= $persentaseKeseluruhan ?>" 
                 aria-valuemin="0" 
                 aria-valuemax="100">
                <?= number_format($persentaseKeseluruhan, 1) ?>%
            </div>
        </div>
        <p class="text-muted mt-2 mb-0">
            <strong><?= number_format($totalTerisi); ?></strong> dari <strong><?= number_format($totalKuota); ?></strong> kuota telah terisi
        </p>
    </div>
</div>

<!-- Tabel Statistik per Jurusan -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-3">Statistik per Jurusan</h5>
        
        <?php if (empty($quotaStats)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Belum ada data statistik untuk tahun ajaran ini.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Jurusan</th>
                            <th width="10%" class="text-center">Total Kuota</th>
                            <th width="10%" class="text-center">Terisi</th>
                            <th width="10%" class="text-center">Sisa</th>
                            <th width="30%">Progress</th>
                            <th width="10%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($quotaStats as $stat): ?>
                            <?php 
                                $persentase = $stat['persentase_terisi'] ?? 0;
                                
                                // Tentukan warna progress bar
                                if ($persentase >= 90) {
                                    $progressColor = 'bg-danger';
                                    $statusText = 'Hampir Penuh';
                                    $statusBadge = 'badge bg-danger';
                                } elseif ($persentase >= 70) {
                                    $progressColor = 'bg-warning';
                                    $statusText = 'Sedang';
                                    $statusBadge = 'badge bg-warning';
                                } elseif ($persentase >= 30) {
                                    $progressColor = 'bg-info';
                                    $statusText = 'Normal';
                                    $statusBadge = 'badge bg-info';
                                } else {
                                    $progressColor = 'bg-success';
                                    $statusText = 'Tersedia';
                                    $statusBadge = 'badge bg-success';
                                }
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <strong><?= esc($stat['nama_jurusan']); ?></strong><br>
                                    <small class="text-muted"><?= esc($stat['kode_jurusan']); ?></small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-signpost-split"></i>
                                        R: <?= $stat['jalur_reguler']; ?> | 
                                        P: <?= $stat['jalur_prestasi']; ?> | 
                                        A: <?= $stat['jalur_afirmasi']; ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <strong class="text-primary"><?= number_format($stat['kuota_total']); ?></strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info"><?= number_format($stat['kuota_terisi']); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary"><?= number_format($stat['sisa_kuota']); ?></span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar <?= $progressColor ?>" 
                                             role="progressbar" 
                                             style="width: <?= $persentase ?>%"
                                             aria-valuenow="<?= $persentase ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            <?= number_format($persentase, 1) ?>%
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="<?= $statusBadge ?>"><?= $statusText ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="2" class="text-end">Total:</th>
                            <th class="text-center"><?= number_format($totalKuota); ?></th>
                            <th class="text-center"><?= number_format($totalTerisi); ?></th>
                            <th class="text-center"><?= number_format($totalSisa); ?></th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Chart Section (Optional - bisa ditambahkan nanti) -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Catatan</h5>
                <ul>
                    <li><strong>R:</strong> Jalur Reguler</li>
                    <li><strong>P:</strong> Jalur Prestasi</li>
                    <li><strong>A:</strong> Jalur Afirmasi</li>
                </ul>
                <p class="text-muted mb-0">
                    <i class="bi bi-info-circle"></i> 
                    Data statistik ini diperbarui secara otomatis setiap ada perubahan data pendaftar.
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
