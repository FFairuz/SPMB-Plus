<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Pembayaran Offline<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<h2 class="mb-3">
    <i class="bi bi-cash"></i> Pembayaran Offline/Di Tempat
</h2>
<p class="text-muted">Catat pembayaran yang diterima secara langsung di lokasi</p>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> <?= session()->getFlashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="post" action="/bendahara/pembayaran-offline">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Siswa Pendaftar <span class="text-danger">*</span></label>
                            <select class="form-control" name="applicant_id" required>
                                <option value="">-- Pilih Siswa --</option>
                                <?php foreach ($applicants as $app): ?>
                                    <option value="<?= $app['id']; ?>">
                                        <?= $app['nama_lengkap'] ?? 'N/A'; ?> (<?= $app['nomor_pendaftaran'] ?? 'N/A'; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jumlah Pembayaran <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="payment_amount" placeholder="Rp. 0" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pembayaran <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                                <button class="btn btn-outline-secondary" type="button" id="btn-today" title="Set tanggal hari ini">
                                    <i class="bi bi-calendar-today"></i> Today
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control" name="payment_method" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Transfer">Transfer Bank</option>
                                <option value="Tunai">Tunai</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control" name="payment_type" id="payment_type" required>
                                <option value="lunas">Lunas</option>
                                <option value="cicilan">Cicilan</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="installment_wrapper" style="display: none;">
                            <label class="form-label">Cicilan Ke- <span class="text-danger">*</span></label>
                            <select class="form-control" name="installment_number" id="installment_number">
                                <option value="">-- Pilih Cicilan --</option>
                                <?php for($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" name="notes" rows="2" placeholder="Tambahkan catatan (opsional)"></textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan Pembayaran
                        </button>
                        <a href="/bendahara/dashboard" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tombol Today - Set tanggal hari ini
    const btnToday = document.getElementById('btn-today');
    const paymentDateInput = document.getElementById('payment_date');
    
    if (btnToday && paymentDateInput) {
        btnToday.addEventListener('click', function() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            
            paymentDateInput.value = `${year}-${month}-${day}`;
        });
    }
    
    // Show/hide installment dropdown based on payment type
    const paymentType = document.getElementById('payment_type');
    const installmentWrapper = document.getElementById('installment_wrapper');
    const installmentNumber = document.getElementById('installment_number');
    
    if (paymentType && installmentWrapper && installmentNumber) {
        paymentType.addEventListener('change', function() {
            if (this.value === 'cicilan') {
                installmentWrapper.style.display = 'block';
                installmentNumber.setAttribute('required', 'required');
            } else {
                installmentWrapper.style.display = 'none';
                installmentNumber.removeAttribute('required');
                installmentNumber.value = '';
            }
        });
    }
});
</script>

<?= $this->endSection(); ?>
