<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Edit Tahun Ajaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-pencil"></i> Edit Tahun Ajaran
    </h2>
    <a href="/admin/academic-years" class="btn btn-secondary">
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
        <form method="post" action="/admin/academic-years/edit/<?= $year['id']; ?>">
            <?= csrf_field(); ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tahun_mulai" class="form-label">Tahun Mulai <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="tahun_mulai" 
                               id="tahun_mulai" 
                               class="form-control <?= isset($validation['tahun_mulai']) ? 'is-invalid' : '' ?>" 
                               placeholder="Contoh: 2026"
                               value="<?= old('tahun_mulai', $year['tahun_mulai']); ?>"
                               min="2020"
                               max="2100"
                               required
                               oninput="generateTahunAjaran()">
                        <?php if (isset($validation['tahun_mulai'])): ?>
                            <div class="invalid-feedback"><?= $validation['tahun_mulai']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tahun_selesai" class="form-label">Tahun Selesai <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="tahun_selesai" 
                               id="tahun_selesai" 
                               class="form-control <?= isset($validation['tahun_selesai']) ? 'is-invalid' : '' ?>" 
                               placeholder="Contoh: 2027"
                               value="<?= old('tahun_selesai', $year['tahun_selesai']); ?>"
                               min="2020"
                               max="2100"
                               required
                               oninput="generateTahunAjaran()">
                        <?php if (isset($validation['tahun_selesai'])): ?>
                            <div class="invalid-feedback"><?= $validation['tahun_selesai']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun Ajaran</label>
                <input type="text" 
                       class="form-control" 
                       id="tahun_ajaran_display" 
                       readonly
                       value="<?= old('tahun_ajaran', $year['tahun_ajaran']); ?>"
                       style="background: #f8f9fa;">
                <small class="text-muted">Otomatis tergenerate dari tahun mulai dan selesai</small>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" 
                               name="tanggal_mulai" 
                               id="tanggal_mulai" 
                               class="form-control" 
                               value="<?= old('tanggal_mulai', $year['tanggal_mulai']); ?>">
                        <small class="text-muted">Opsional</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" 
                               name="tanggal_selesai" 
                               id="tanggal_selesai" 
                               class="form-control" 
                               value="<?= old('tanggal_selesai', $year['tanggal_selesai']); ?>">
                        <small class="text-muted">Opsional</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="aktif" <?= old('status', $year['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status', $year['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            <option value="selesai" <?= old('status', $year['status']) == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran Aktif</label>
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   value="1"
                                   <?= old('is_active', $year['is_active']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                Set sebagai tahun ajaran aktif
                            </label>
                        </div>
                        <small class="text-muted">Hanya satu tahun ajaran yang bisa aktif</small>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" 
                          id="keterangan" 
                          class="form-control" 
                          rows="3"
                          placeholder="Keterangan tambahan (opsional)"><?= old('keterangan', $year['keterangan']); ?></textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/academic-years" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function generateTahunAjaran() {
    const tahunMulai = document.getElementById('tahun_mulai').value;
    const tahunSelesai = document.getElementById('tahun_selesai').value;
    
    if (tahunMulai && tahunSelesai) {
        document.getElementById('tahun_ajaran_display').value = tahunMulai + '/' + tahunSelesai;
    } else {
        document.getElementById('tahun_ajaran_display').value = '-';
    }
}

// Initialize
generateTahunAjaran();
</script>

<?= $this->endSection(); ?>
