<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Pembayaran Pendaftaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/applicant/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
        <li class="breadcrumb-item active">Pembayaran</li>
    </ol>
</nav>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 fw-bold">
            <i class="bi bi-credit-card text-success"></i> Pembayaran Pendaftaran
        </h2>
        <p class="text-muted mb-0">Lakukan pembayaran untuk memulai proses pendaftaran PPDB</p>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i> <?= session()->getFlashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Payment Info Card -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h5 class="fw-semibold mb-4">
                    <i class="bi bi-info-circle text-primary me-2"></i>Informasi Pembayaran
                </h5>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Email Pendaftar</small>
                    <p class="mb-0 fw-semibold"><?= esc($user['email'] ?? '-'); ?></p>
                </div>
                <div class="mb-0">
                    <small class="text-muted d-block mb-1">Biaya Pendaftaran</small>
                    <h3 class="mb-0 text-danger fw-bold">Rp <?= number_format($registration_fee, 0, ',', '.'); ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h5 class="fw-semibold mb-4">
                    <i class="bi bi-flag text-primary me-2"></i>Status Pembayaran
                </h5>
                <div class="text-center py-3">
                    <?php if (!$payment): ?>
                        <div class="bg-warning bg-opacity-10 rounded p-4">
                            <i class="bi bi-exclamation-triangle fs-1 text-warning d-block mb-3"></i>
                            <span class="badge bg-warning text-dark px-4 py-2 fs-6">Belum Membayar</span>
                        </div>
                    <?php elseif (isset($payment['payment_status']) && $payment['payment_status'] === 'submitted'): ?>
                        <div class="bg-info bg-opacity-10 rounded p-4">
                            <i class="bi bi-clock-history fs-1 text-info d-block mb-3"></i>
                            <span class="badge bg-info px-4 py-2 fs-6">Menunggu Konfirmasi</span>
                        </div>
                    <?php elseif (isset($payment['payment_status']) && $payment['payment_status'] === 'confirmed'): ?>
                        <div class="bg-success bg-opacity-10 rounded p-4">
                            <i class="bi bi-check-circle fs-1 text-success d-block mb-3"></i>
                            <span class="badge bg-success px-4 py-2 fs-6">Sudah Dikonfirmasi</span>
                        </div>
                    <?php else: ?>
                        <div class="bg-danger bg-opacity-10 rounded p-4">
                            <i class="bi bi-x-circle fs-1 text-danger d-block mb-3"></i>
                            <span class="badge bg-danger px-4 py-2 fs-6">Ditolak</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Form -->
<?php if (!$payment || (isset($payment['payment_status']) && in_array($payment['payment_status'], ['rejected', 'submitted']))): ?>
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-cloud-upload text-primary me-2"></i>Unggah Bukti Pembayaran
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="/applicant/payment" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Bank <span class="text-danger">*</span></label>
                        <select name="bank_name" class="form-select form-select-lg" required>
                            <option value="">-- Pilih Bank --</option>
                            <option value="BCA" <?= ($payment && isset($payment['bank_name']) && $payment['bank_name'] === 'BCA') ? 'selected' : ''; ?>>BCA</option>
                            <option value="Mandiri" <?= ($payment && isset($payment['bank_name']) && $payment['bank_name'] === 'Mandiri') ? 'selected' : ''; ?>>Mandiri</option>
                            <option value="BNI" <?= ($payment && isset($payment['bank_name']) && $payment['bank_name'] === 'BNI') ? 'selected' : ''; ?>>BNI</option>
                            <option value="BTN" <?= ($payment && isset($payment['bank_name']) && $payment['bank_name'] === 'BTN') ? 'selected' : ''; ?>>BTN</option>
                            <option value="Lainnya" <?= ($payment && isset($payment['bank_name']) && $payment['bank_name'] === 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Bank yang Anda gunakan untuk transfer</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor Rekening <span class="text-danger">*</span></label>
                        <input type="text" name="account_number" class="form-control form-control-lg" 
                            value="<?= esc($payment['account_number'] ?? old('account_number') ?? ''); ?>" required>
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Nomor rekening sumber transfer</small>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Atas Nama <span class="text-danger">*</span></label>
                        <input type="text" name="account_holder" class="form-control form-control-lg" 
                            value="<?= esc($payment['account_holder'] ?? old('account_holder') ?? ''); ?>" required>
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Nama pemilik rekening</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jumlah Transfer <span class="text-danger">*</span></label>
                                    <input type="number" name="transfer_amount" class="form-control" 
                                        value="<?= esc($payment['transfer_amount'] ?? $registration_fee ?? 150000); ?>" required>
                                    <small class="text-muted">Minimal Rp <?= number_format($registration_fee, 0, ',', '.'); ?></small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Transfer <span class="text-danger">*</span></label>
                                <input type="date" name="transfer_date" class="form-control" 
                                    value="<?= esc($payment['transfer_date'] ?? old('transfer_date') ?? ''); ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Bukti Transfer (Screenshot/PDF) <span class="text-danger">*</span></label>
                                <div class="border-2 border-dashed p-4 rounded text-center" style="border: 2px dashed #dee2e6; cursor: pointer;" id="dropZone">
                                    <i class="bi bi-cloud-upload" style="font-size: 2rem; color: #6c757d;"></i>
                                    <p class="mt-3 mb-0">
                                        <strong>Drag & drop file di sini atau</strong><br>
                                        <a href="#" class="text-primary" onclick="document.getElementById('transfer_proof').click(); return false;">Klik untuk memilih</a>
                                    </p>
                                    <small class="text-muted d-block mt-2">Format: JPG, JPEG, PNG, PDF | Max: 2MB</small>
                                </div>
                                <input type="file" id="transfer_proof" name="transfer_proof" class="form-control d-none" accept="image/*,.pdf">
                                <div id="fileName" class="mt-2"></div>
                            </div>

                            <div class="alert alert-info mb-4">
                                <i class="bi bi-info-circle-fill"></i>
                                <strong>Catatan:</strong> Pastikan bukti pembayaran jelas dan lengkap menunjukkan nomor rekening, nama, dan jumlah transfer.
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-upload"></i> Unggah Bukti Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            <?php elseif (isset($payment['payment_status']) && $payment['payment_status'] === 'confirmed'): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5 text-center">
                        <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: #d4edda; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-check-circle" style="font-size: 2.5rem; color: #28a745;"></i>
                        </div>
                        <h4 class="mb-3">Pembayaran Dikonfirmasi! ✅</h4>
                        <p class="text-muted mb-4">Pembayaran Anda telah dikonfirmasi oleh admin. Anda sekarang dapat mengisi formulir pendaftaran.</p>
                        <a href="/applicant/register" class="btn btn-success btn-lg px-5">
                            <i class="bi bi-clipboard-check"></i> Isi Formulir Pendaftaran
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Drag & Drop Handler
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('transfer_proof');
const fileNameDiv = document.getElementById('fileName');

if (dropZone) {
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.style.backgroundColor = '#f8f9fa';
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.style.backgroundColor = 'transparent';
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.style.backgroundColor = 'transparent';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            updateFileName();
        }
    });

    fileInput.addEventListener('change', updateFileName);
}

function updateFileName() {
    const file = fileInput.files[0];
    if (file) {
        fileNameDiv.innerHTML = `
            <div class="alert alert-success alert-sm mt-2 mb-0">
                <i class="bi bi-check-circle"></i> File dipilih: <strong>${file.name}</strong> (${(file.size / 1024).toFixed(2)} KB)
            </div>
        `;
    }
}
</script>
                </div>
            </div>
        </div>

<?= $this->endSection(); ?>
