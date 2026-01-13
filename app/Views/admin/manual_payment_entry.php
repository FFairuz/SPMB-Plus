<?= $this->extend('layout/app') ?>

<?= $this->section('content'); ?>

<!-- Header -->
<div class="mb-4">
                <a href="/admin/payments" class="btn btn-outline-primary btn-sm mb-3">
                    <i class="bi bi-chevron-left"></i> Kembali
                </a>
                <h2 class="mb-1">💳 Input Manual Pembayaran</h2>
                <p class="text-muted">Input data pembayaran yang diterima secara manual (tunai, transfer via WA, dll)</p>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill"></i> <?= session()->getFlashdata('success'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle-fill"></i> <?= session()->getFlashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="/admin/payment-entry" method="post">
                        <div class="mb-3">
                            <label for="applicant_id" class="form-label">
                                <i class="bi bi-person"></i> Pilih Pendaftar <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg" id="applicant_id" name="applicant_id" required>
                                <option value="">-- Pilih Pendaftar --</option>
                                <?php foreach ($applicants as $applicant): ?>
                                    <option value="<?= $applicant['id']; ?>">
                                        <?= htmlspecialchars($applicant['full_name']); ?> 
                                        (<?= htmlspecialchars($applicant['registration_number']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-info-circle"></i> Cari dan pilih pendaftar yang melakukan pembayaran
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="account_holder" class="form-label">
                                <i class="bi bi-person-fill"></i> Nama Pengirim <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg" id="account_holder" 
                                   name="account_holder" placeholder="Nama lengkap pengirim" required>
                        </div>

                        <div class="mb-3">
                            <label for="bank_name" class="form-label">
                                <i class="bi bi-bank"></i> Bank Pengirim <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg" id="bank_name" name="bank_name" required>
                                <option value="">-- Pilih Bank --</option>
                                <option value="BCA">BCA</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="BNI">BNI</option>
                                <option value="CIMB Niaga">CIMB Niaga</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="transfer_date" class="form-label">
                                <i class="bi bi-calendar-event"></i> Tanggal Transfer <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" class="form-control form-control-lg" id="transfer_date" 
                                   name="transfer_date" required>
                        </div>

                        <div class="mb-4">
                            <label for="transfer_amount" class="form-label">
                                <i class="bi bi-cash-coin"></i> Jumlah Transfer (Rp.) <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control form-control-lg" id="transfer_amount" 
                                   name="transfer_amount" placeholder="250000" value="250000" required>
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-info-circle"></i> Masukkan jumlah yang diterima dari pendaftar
                            </small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-lg"></i> Simpan Data Pembayaran
                            </button>
                            <a href="/admin/payments" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Box -->
            <div class="card border-0 shadow-sm mt-4" style="background: linear-gradient(135deg, rgba(13, 110, 253, 0.05) 0%, rgba(11, 94, 215, 0.05) 100%);">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-info-circle" style="color: #0d6efd;"></i> Panduan Input Manual
                    </h6>
                    <ul class="mb-0 ps-3">
                        <li class="mb-2">Gunakan form ini untuk input pembayaran yang diterima tidak melalui upload bukti</li>
                        <li class="mb-2">Misalnya: pembayaran tunai langsung, transfer yang sudah dikonfirmasi via telepon, dll</li>
                        <li class="mb-2">Data akan otomatis ditandai sebagai "Menunggu Konfirmasi" untuk review lebih lanjut</li>
                        <li>Setelah di-review dan dikonfirmasi, pendaftar bisa melanjutkan pendaftaran</li>
                    </ul>
                </div>
            </div>
        </div>

<?= $this->endSection(); ?>
