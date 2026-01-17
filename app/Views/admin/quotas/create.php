<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Tambah Kuota Jurusan<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-plus-circle"></i> Tambah Kuota Jurusan
    </h2>
    <a href="/admin/quotas" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i> <?= session()->getFlashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="post" action="/admin/quotas/create">
            <?= csrf_field(); ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="major_id" class="form-label">Jurusan <span class="text-danger">*</span></label>
                        <select name="major_id" id="major_id" class="form-select <?= isset($validation['major_id']) ? 'is-invalid' : '' ?>" required>
                            <option value="">-- Pilih Jurusan --</option>
                            <?php foreach ($majors as $major): ?>
                                <option value="<?= $major['id']; ?>" <?= old('major_id') == $major['id'] ? 'selected' : '' ?>>
                                    <?= esc($major['kode_jurusan']); ?> - <?= esc($major['nama_jurusan']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($validation['major_id'])): ?>
                            <div class="invalid-feedback"><?= $validation['major_id']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="tahun_ajaran" 
                               id="tahun_ajaran" 
                               class="form-control <?= isset($validation['tahun_ajaran']) ? 'is-invalid' : '' ?>" 
                               placeholder="Contoh: 2026/2027"
                               value="<?= old('tahun_ajaran'); ?>"
                               required>
                        <small class="text-muted">Format: YYYY/YYYY</small>
                        <?php if (isset($validation['tahun_ajaran'])): ?>
                            <div class="invalid-feedback"><?= $validation['tahun_ajaran']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="kuota_total" class="form-label">Kuota Total <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="kuota_total" 
                               id="kuota_total" 
                               class="form-control <?= isset($validation['kuota_total']) ? 'is-invalid' : '' ?>" 
                               placeholder="Masukkan total kuota"
                               value="<?= old('kuota_total'); ?>"
                               min="0"
                               required
                               oninput="updateJalurSuggestion()">
                        <?php if (isset($validation['kuota_total'])): ?>
                            <div class="invalid-feedback"><?= $validation['kuota_total']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="mb-3">Pembagian Kuota Per Jalur (Opsional)</h5>
            <p class="text-muted small">Total kuota per jalur tidak boleh melebihi kuota total</p>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="jalur_reguler" class="form-label">Jalur Reguler</label>
                        <input type="number" 
                               name="jalur_reguler" 
                               id="jalur_reguler" 
                               class="form-control" 
                               placeholder="0"
                               value="<?= old('jalur_reguler', 0); ?>"
                               min="0"
                               oninput="calculateTotal()">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="jalur_prestasi" class="form-label">Jalur Prestasi</label>
                        <input type="number" 
                               name="jalur_prestasi" 
                               id="jalur_prestasi" 
                               class="form-control" 
                               placeholder="0"
                               value="<?= old('jalur_prestasi', 0); ?>"
                               min="0"
                               oninput="calculateTotal()">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="jalur_afirmasi" class="form-label">Jalur Afirmasi</label>
                        <input type="number" 
                               name="jalur_afirmasi" 
                               id="jalur_afirmasi" 
                               class="form-control" 
                               placeholder="0"
                               value="<?= old('jalur_afirmasi', 0); ?>"
                               min="0"
                               oninput="calculateTotal()">
                    </div>
                </div>
            </div>

            <div class="alert alert-info" id="totalJalurInfo">
                <strong>Total Jalur:</strong> <span id="totalJalur">0</span> / <span id="kuotaTotalDisplay">0</span>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="aktif" <?= old('status', 'aktif') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" 
                          id="keterangan" 
                          class="form-control" 
                          rows="3"
                          placeholder="Keterangan tambahan (opsional)"><?= old('keterangan'); ?></textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/quotas" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function calculateTotal() {
    const reguler = parseInt(document.getElementById('jalur_reguler').value) || 0;
    const prestasi = parseInt(document.getElementById('jalur_prestasi').value) || 0;
    const afirmasi = parseInt(document.getElementById('jalur_afirmasi').value) || 0;
    const kuotaTotal = parseInt(document.getElementById('kuota_total').value) || 0;
    
    const total = reguler + prestasi + afirmasi;
    document.getElementById('totalJalur').textContent = total;
    document.getElementById('kuotaTotalDisplay').textContent = kuotaTotal;
    
    const infoDiv = document.getElementById('totalJalurInfo');
    if (total > kuotaTotal) {
        infoDiv.classList.remove('alert-info');
        infoDiv.classList.add('alert-danger');
    } else {
        infoDiv.classList.remove('alert-danger');
        infoDiv.classList.add('alert-info');
    }
}

function updateJalurSuggestion() {
    calculateTotal();
}

// Initialize
calculateTotal();
</script>

<?= $this->endSection(); ?>
