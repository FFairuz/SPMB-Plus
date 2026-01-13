<?= $this->extend('layout/app') ?>

<?= $this->section('content'); ?>

<!-- Header -->
<div class="mb-4">
                <a href="/admin/payments" class="btn btn-outline-primary btn-sm mb-3">
                    <i class="bi bi-chevron-left"></i> Kembali ke Daftar Pembayaran
                </a>
                <h2 class="mb-1">💳 Detail Pembayaran</h2>
                <p class="text-muted">ID Pembayaran: <strong>#<?= $payment['id']; ?></strong></p>
            </div>

            <!-- Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-muted mb-2">Status Pembayaran</h6>
                            <div>
                                <?php
                                $statusColors = [
                                    'pending' => ['bg-warning', 'Menunggu Pembayaran'],
                                    'submitted' => ['bg-info', 'Menunggu Konfirmasi'],
                                    'confirmed' => ['bg-success', 'Dikonfirmasi'],
                                    'rejected' => ['bg-danger', 'Ditolak'],
                                ];
                                $status = $payment['payment_status'] ?? 'pending';
                                $color = $statusColors[$status][0];
                                $label = $statusColors[$status][1];
                                ?>
                                <span class="badge <?= $color; ?> p-3 fs-6">
                                    <?= $label; ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="text-muted d-block">Biaya Pendaftaran</small>
                            <h5 class="fw-bold text-primary mb-0">Rp. <?= number_format($payment['registration_fee'] ?? 250000, 0, ',', '.'); ?></h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applicant Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light py-4">
                    <h6 class="mb-0">Informasi Pendaftar</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Nama Lengkap</small>
                            <p class="fw-500"><?= htmlspecialchars($payment['full_name']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Email</small>
                            <p class="fw-500"><?= htmlspecialchars($payment['email']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Nomor Registrasi</small>
                            <p class="fw-500"><?= htmlspecialchars($payment['registration_number']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">ID Pendaftar</small>
                            <p class="fw-500">#<?= $payment['applicant_id']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light py-4">
                    <h6 class="mb-0">Detail Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Nama Pengirim</small>
                            <p class="fw-500"><?= htmlspecialchars($payment['account_holder'] ?? '-'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Bank Pengirim</small>
                            <p class="fw-500"><?= htmlspecialchars($payment['bank_name'] ?? '-'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Tanggal Transfer</small>
                            <p class="fw-500"><?= $payment['transfer_date'] ? date('d-m-Y H:i', strtotime($payment['transfer_date'])) : '-'; ?></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Jumlah Transfer</small>
                            <p class="fw-500">Rp. <?= number_format($payment['transfer_amount'] ?? 0, 0, ',', '.'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Tanggal Upload</small>
                            <p class="fw-500"><?= $payment['created_at'] ? date('d-m-Y H:i', strtotime($payment['created_at'])) : '-'; ?></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Metode Pembayaran</small>
                            <p class="fw-500"><?= ucfirst(htmlspecialchars($payment['payment_method'] ?? 'transfer')); ?></p>
                        </div>
                    </div>

                    <?php if ($payment['transfer_proof_path']): ?>
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="mb-3">Bukti Transfer</h6>
                            <div class="text-center">
                                <img src="/uploads/payments/<?= htmlspecialchars($payment['transfer_proof_path']); ?>" 
                                     alt="Bukti Transfer" class="img-fluid rounded" style="max-height: 400px;">
                                <div class="mt-2">
                                    <a href="/uploads/payments/<?= htmlspecialchars($payment['transfer_proof_path']); ?>" 
                                       download class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> Download Bukti
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Confirmation Info -->
            <?php if ($payment['payment_status'] === 'confirmed' && $payment['confirmed_at']): ?>
                <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid #28a745;">
                    <div class="card-body">
                        <h6 class="mb-2">✅ Dikonfirmasi Oleh Admin</h6>
                        <p class="text-muted mb-1">Tanggal: <?= date('d-m-Y H:i', strtotime($payment['confirmed_at'])); ?></p>
                        <p class="text-muted mb-0">Admin ID: #<?= $payment['confirmed_by'] ?? '-'; ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Notes -->
            <?php if ($payment['notes']): ?>
                <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid #ffc107;">
                    <div class="card-body">
                        <h6 class="mb-2">📝 Catatan</h6>
                        <p class="text-muted mb-0"><?= nl2br(htmlspecialchars($payment['notes'])); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Actions -->
            <?php if ($payment['payment_status'] === 'submitted'): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">Aksi Pembayaran</h6>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-success btn-lg" 
                                    onclick="confirmPayment(<?= $payment['id']; ?>)">
                                <i class="bi bi-check-circle"></i> Konfirmasi Pembayaran
                            </button>
                            <button type="button" class="btn btn-danger btn-lg" 
                                    data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle"></i> Tolak Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title">Tolak Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Catatan Penolakan</label>
                <textarea class="form-control" id="rejectNotes" rows="3" 
                         placeholder="Jelaskan alasan penolakan pembayaran..."></textarea>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" 
                        onclick="rejectPayment(<?= $payment['id']; ?>)">
                    <i class="bi bi-x-circle"></i> Tolak Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmPayment(paymentId) {
    if (confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?')) {
        fetch(`/admin/payment/${paymentId}/confirm`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => alert('Error: ' + error.message));
    }
}

function rejectPayment(paymentId) {
    const notes = document.getElementById('rejectNotes').value;
    
    if (!notes.trim()) {
        alert('Silakan masukkan catatan penolakan');
        return;
    }

    fetch(`/admin/payment/${paymentId}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ notes: notes })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => alert('Error: ' + error.message));
}
</script>
<?= $this->endSection(); ?>
