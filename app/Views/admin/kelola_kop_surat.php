<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Kelola Kop Surat Sekolah<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        margin: -1.5rem -1.5rem 2rem -1.5rem;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .page-header h1 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 700;
    }
    .page-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.95;
    }
    .form-card {
        background: white;
        border-radius: 0.5rem;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .form-section {
        margin-bottom: 2rem;
    }
    .form-section:last-child {
        margin-bottom: 0;
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #667eea;
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .form-row.full {
        grid-template-columns: 1fr;
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    .form-control {
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 0.375rem;
        font-size: 0.95rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .form-text {
        font-size: 0.85rem;
        color: #666;
        margin-top: 0.25rem;
    }
    .preview-section {
        background-color: #f8f9fa;
        border: 2px dashed #667eea;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-top: 2rem;
    }
    .preview-header {
        display: flex;
        align-items: center;
        border-bottom: 3px solid #333;
        padding-bottom: 1.5rem;
        margin-bottom: 1rem;
    }
    .preview-logo {
        width: 80px;
        height: 80px;
        margin-right: 1.5rem;
        background-color: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }
    .preview-info {
        flex: 1;
        text-align: center;
    }
    .preview-info h3 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
    }
    .preview-info p {
        margin: 0.3rem 0;
        color: #666;
        font-size: 0.9rem;
    }
    .btn-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.375rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
    }
    .alert {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<div class="form-card">
    <div class="page-header">
        <h1><i class="bi bi-building"></i> Kelola Kop Surat Sekolah</h1>
        <p>Kelola informasi header sekolah yang akan ditampilkan di formulir cetak</p>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span><?= session()->getFlashdata('success'); ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span><?= session()->getFlashdata('error'); ?></span>
        </div>
    <?php endif; ?>

    <form method="post" action="/admin/kelola-kop-surat" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <!-- Informasi Sekolah -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-file-text"></i> Informasi Sekolah
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label class="form-label">Nama Sekolah *</label>
                    <input type="text" class="form-control" name="school_name" 
                        value="<?= old('school_name', $kopSurat['school_name'] ?? 'SEKOLAH MENENGAH ATAS NEGERI'); ?>"
                        placeholder="Nama sekolah" required>
                    <div class="form-text">Nama sekolah yang akan ditampilkan di header dokumen cetak</div>
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control" name="address" 
                        value="<?= old('address', $kopSurat['address'] ?? 'Jl. Pendidikan No. 123, Jakarta Selatan 12000'); ?>"
                        placeholder="Alamat lengkap sekolah">
                    <div class="form-text">Alamat sekolah (opsional)</div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" name="phone" 
                        value="<?= old('phone', $kopSurat['phone'] ?? '(021) 1234-5678'); ?>"
                        placeholder="Nomor telepon" pattern="[0-9\-\(\) ]+">
                    <div class="form-text">Nomor telepon sekolah (opsional)</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" 
                        value="<?= old('email', $kopSurat['email'] ?? 'info@sekolah.sch.id'); ?>"
                        placeholder="Email sekolah">
                    <div class="form-text">Email sekolah (opsional)</div>
                </div>

                <div class="form-group">
                    <label class="form-label">NPSN</label>
                    <input type="text" class="form-control" name="npsn" 
                        value="<?= old('npsn', $kopSurat['npsn'] ?? '20123456'); ?>"
                        placeholder="Nomor Pokok Sekolah Nasional" maxlength="20">
                    <div class="form-text">Nomor Pokok Sekolah Nasional (opsional)</div>
                </div>
            </div>
        </div>

        <!-- Logo -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-image"></i> Logo Sekolah
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label class="form-label">Upload Logo</label>
                    <input type="file" class="form-control" name="logo_path" 
                        accept="image/png,image/jpeg,image/jpg,image/gif"
                        id="logoInput">
                    <div class="form-text">Format: PNG, JPG, GIF (Ukuran maksimal: 5MB)</div>
                </div>
            </div>

            <?php if (!empty($kopSurat['logo_path']) && file_exists(ROOTPATH . $kopSurat['logo_path'])): ?>
                <div style="margin-top: 1rem;">
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Logo saat ini:</p>
                    <img src="/<?= $kopSurat['logo_path']; ?>" alt="Logo" style="max-width: 150px; max-height: 150px;">
                </div>
            <?php endif; ?>
        </div>

        <!-- Preview -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-eye"></i> Preview Kop Surat
            </div>
            
            <div class="preview-section">
                <div class="preview-header">
                    <div class="preview-logo" id="previewLogo">📚</div>
                    <div class="preview-info">
                        <h3 id="previewSchoolName">SEKOLAH MENENGAH ATAS NEGERI</h3>
                        <p id="previewAddress">Jl. Pendidikan No. 123, Jakarta Selatan 12000</p>
                        <p id="previewPhone" style="display: none;"></p>
                        <p id="previewEmail" style="display: none;"></p>
                        <p style="font-weight: 600; color: #333; margin-top: 0.5rem;">NPSN: <span id="previewNpsn">20123456</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="btn-group">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
            <a href="/admin" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

<script>
    // Real-time preview
    const schoolNameInput = document.querySelector('input[name="school_name"]');
    const addressInput = document.querySelector('input[name="address"]');
    const phoneInput = document.querySelector('input[name="phone"]');
    const emailInput = document.querySelector('input[name="email"]');
    const npsnInput = document.querySelector('input[name="npsn"]');
    const logoInput = document.querySelector('input[name="logo_path"]');

    schoolNameInput.addEventListener('input', (e) => {
        document.getElementById('previewSchoolName').textContent = e.target.value || 'SEKOLAH MENENGAH ATAS NEGERI';
    });

    addressInput.addEventListener('input', (e) => {
        document.getElementById('previewAddress').textContent = e.target.value || 'Alamat sekolah';
    });

    phoneInput.addEventListener('input', (e) => {
        const preview = document.getElementById('previewPhone');
        if (e.target.value) {
            preview.textContent = e.target.value;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });

    emailInput.addEventListener('input', (e) => {
        const preview = document.getElementById('previewEmail');
        if (e.target.value) {
            preview.textContent = e.target.value;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });

    npsnInput.addEventListener('input', (e) => {
        document.getElementById('previewNpsn').textContent = e.target.value || '20123456';
    });

    logoInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                const preview = document.getElementById('previewLogo');
                preview.innerHTML = `<img src="${event.target.result}" alt="Logo" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // Initialize phone and email visibility
    if (phoneInput.value) {
        document.getElementById('previewPhone').style.display = 'block';
        document.getElementById('previewPhone').textContent = phoneInput.value;
    }
    if (emailInput.value) {
        document.getElementById('previewEmail').style.display = 'block';
        document.getElementById('previewEmail').textContent = emailInput.value;
    }
</script>

<?= $this->endSection(); ?>
