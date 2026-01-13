<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Kelola Pembayaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 fw-bold">
            <i class="bi bi-credit-card text-success"></i> Kelola Pembayaran
        </h2>
        <p class="text-muted mb-0">Monitor dan verifikasi pembayaran pendaftaran</p>
    </div>
    <div>
        <a href="/admin/manual-payment" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Input Manual
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="bi bi-wallet2 fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Total Pembayaran</small>
                        <h4 class="fw-bold mb-0 text-primary"><?= $stats['total_payments']; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="bi bi-clock-history fs-3 text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Menunggu</small>
                        <h4 class="fw-bold mb-0 text-warning"><?= $stats['submitted']; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="bi bi-check-circle fs-3 text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Dikonfirmasi</small>
                        <h4 class="fw-bold mb-0 text-success"><?= $stats['confirmed'] ?? 0; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="bi bi-cash-stack fs-3 text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-muted d-block mb-1">Total Terkumpul</small>
                        <h6 class="fw-bold mb-0 text-success">Rp. <?= number_format($stats['total_collected'], 0, ',', '.'); ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payments Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-list-check text-primary"></i> Daftar Pembayaran - 
                        <?php
                        $statusLabels = [
                            'pending' => 'Pending',
                            'submitted' => 'Menunggu Konfirmasi',
                            'confirmed' => 'Dikonfirmasi',
                            'rejected' => 'Ditolak',
                        ];
                        echo $statusLabels[$current_status] ?? 'Semua';
                        ?>
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Pengguna</th>
                                <th>Status</th>
                                <th>Biaya</th>
                                <th>Nominal Transfer</th>
                                <th>Tanggal</th>
                                <th style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($payments as $payment): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($payment['username'] ?? 'N/A'); ?></strong>
                                        <br>
                                        <small class="text-muted"><?= htmlspecialchars($payment['email'] ?? 'N/A'); ?></small>
                                    </td>
                                    <td>
                                        <?php if ($payment['applicant_id']): ?>
                                            <span class="badge bg-success">Sudah Daftar</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Belum Daftar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>Rp. <?= number_format($payment['registration_fee'], 0, ',', '.'); ?></td>
                                    <td>Rp. <?= number_format($payment['transfer_amount'] ?? 0, 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if ($payment['transfer_date']): ?>
                                            <?= date('d-m-Y H:i', strtotime($payment['transfer_date'])); ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($current_status === 'submitted'): ?>
                                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal<?= $payment['id']; ?>">
                                                <i class="bi bi-check-circle"></i> Terima
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal<?= $payment['id']; ?>">
                                                <i class="bi bi-x-circle"></i> Tolak
                                            </button>
                                        <?php else: ?>
                                            <a href="/admin/payments?status=submitted" class="btn btn-sm btn-secondary">
                                                <i class="bi bi-arrow-left"></i> Kembali
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- Confirm Modal -->
                                <div class="modal fade" id="confirmModal<?= $payment['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title">Konfirmasi Pembayaran</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin mengkonfirmasi pembayaran dari <strong><?= htmlspecialchars($payment['username']); ?></strong>?</p>
                                                <p class="text-muted">Pembayaran sebesar <strong>Rp. <?= number_format($payment['transfer_amount'] ?? 0, 0, ',', '.'); ?></strong> akan disetujui.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <a href="/admin/confirmPayment/<?= $payment['id']; ?>" class="btn btn-success">
                                                    <i class="bi bi-check"></i> Konfirmasi
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal<?= $payment['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Tolak Pembayaran</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="/admin/rejectPayment/<?= $payment['id']; ?>">
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menolak pembayaran dari <strong><?= htmlspecialchars($payment['username']); ?></strong>?</p>
                                                    <div class="mb-3">
                                                        <label for="notes<?= $payment['id']; ?>" class="form-label">Catatan (Opsional)</label>
                                                        <textarea class="form-control" id="notes<?= $payment['id']; ?>" name="notes" rows="3" placeholder="Alasan penolakan..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="bi bi-x"></i> Tolak Pembayaran
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (empty($payments)): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                        <p class="mt-2 mb-0">Tidak ada pembayaran dengan status ini</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        color: white;
    }
    
    .table thead th {
        border: none;
        padding: 15px;
        font-weight: 600;
    }
    
    .table tbody td {
        padding: 12px 15px;
        border-bottom: 1px solid #e0e0e0;
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
<?= $this->endSection(); ?>
