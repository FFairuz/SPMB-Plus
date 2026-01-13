<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Detail Siswa<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin: -1.5rem -1.5rem 2rem -1.5rem;
        border-radius: 0 0 1rem 1rem;
    }
    .page-header a {
        color: white;
        text-decoration: none;
        transition: opacity 0.3s;
    }
    .page-header a:hover {
        opacity: 0.8;
    }
    .form-section {
        background: white;
        border-radius: 0.75rem;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #e9ecef;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    }
    .form-section h5 {
        color: #667eea;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #667eea;
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    .form-group p {
        color: #212529;
        padding: 0.75rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        border-left: 4px solid #667eea;
        margin: 0;
    }
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
    }
    .status-submitted {
        background-color: #ffc107;
        color: #333;
    }
    .status-verified {
        background-color: #28a745;
        color: white;
    }
    .info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 2rem;
    }
    .info-card h6 {
        margin: 0;
        font-weight: 600;
        opacity: 0.9;
    }
    .info-card .big-text {
        font-size: 1.5rem;
        font-weight: 700;
        margin-top: 0.5rem;
    }
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 2rem;
        flex-wrap: wrap;
        padding: 1.5rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        border-left: 4px solid #667eea;
    }
    .action-buttons .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .action-buttons .btn-primary {
        background-color: #0d6efd;
        color: white;
    }
    .action-buttons .btn-primary:hover {
        background-color: #0b5ed7;
    }
    .action-buttons .btn-success {
        background-color: #198754;
        color: white;
    }
    .action-buttons .btn-success:hover {
        background-color: #157347;
    }
    .action-buttons .btn-danger {
        background-color: #dc3545;
        color: white;
    }
    .action-buttons .btn-danger:hover {
        background-color: #bb2d3b;
    }
    .action-buttons .btn-warning {
        background-color: #ffc107;
        color: #000;
    }
    .action-buttons .btn-warning:hover {
        background-color: #ffb800;
    }
    .action-buttons .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .action-buttons .btn-secondary:hover {
        background-color: #5c636a;
    }
</style>

<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 style="margin: 0; font-weight: 700;">
                    <i class="bi bi-person-circle"></i> Detail Siswa Pendaftar
                </h2>
                <p style="margin: 0.5rem 0 0 0; opacity: 0.95;">
                    Lihat informasi lengkap dan verifikasi data pendaftar
                </p>
            </div>
            <a href="/panitia/verifikasi-pendaftar" class="btn btn-light">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<?php if ($applicant): ?>

<!-- Info Card -->
<div class="info-card">
    <div class="row">
        <div class="col-md-8">
            <h6>Nomor Pendaftaran</h6>
            <div class="big-text"><?= $applicant['nomor_pendaftaran'] ?? '-'; ?></div>
        </div>
        <div class="col-md-4 text-end">
            <h6>Status</h6>
            <span class="status-badge status-<?= $applicant['status'] ?? 'submitted'; ?>">
                <i class="bi bi-check-circle"></i> 
                <?= ucfirst($applicant['status'] ?? 'pending'); ?>
            </span>
        </div>
    </div>
</div>

<!-- Data Pribadi -->
<div class="form-section">
    <h5><i class="bi bi-person"></i> Data Pribadi</h5>
    <div class="form-row">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <p><?= $applicant['nama_lengkap'] ?? '-'; ?></p>
        </div>
        <div class="form-group">
            <label>NIK</label>
            <p><?= $applicant['nik'] ?? '-'; ?></p>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <p><?= ucfirst($applicant['jenis_kelamin'] ?? '-'); ?></p>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <p><?= $applicant['tanggal_lahir'] ? date('d M Y', strtotime($applicant['tanggal_lahir'])) : '-'; ?></p>
        </div>
        <div class="form-group">
            <label>Tempat Lahir</label>
            <p><?= $applicant['tempat_lahir'] ?? '-'; ?></p>
        </div>
        <div class="form-group">
            <label>Agama</label>
            <p><?= $applicant['agama'] ?? '-'; ?></p>
        </div>
    </div>
</div>

<!-- Data Keluarga -->
<div class="form-section">
    <h5><i class="bi bi-people"></i> Data Keluarga</h5>
    <div class="form-row">
        <div class="form-group">
            <label>Anak Ke-</label>
            <p><?= $applicant['anak_ke'] ?? '-'; ?></p>
        </div>
        <div class="form-group">
            <label>Jumlah Saudara</label>
            <p><?= $applicant['jumlah_saudara'] ?? '-'; ?></p>
        </div>
    </div>
</div>

<!-- Alamat -->
<div class="form-section">
    <h5><i class="bi bi-geo-alt"></i> Alamat</h5>
    <div class="form-row">
        <div class="form-group">
            <label>Alamat Jalan</label>
            <p><?= $applicant['alamat_jalan'] ?? '-'; ?></p>
        </div>
        <div class="form-group">
            <label>Dusun</label>
            <p><?= $applicant['dusun'] ?? '-'; ?></p>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Kelurahan</label>
            <p><?= $applicant['kelurahan'] ?? '-'; ?></p>
        </div>
        <div class="form-group">
            <label>Kecamatan</label>
            <p><?= $applicant['kecamatan'] ?? '-'; ?></p>
        </div>
        <div class="form-group">
            <label>Kabupaten</label>
            <p><?= $applicant['kabupaten'] ?? '-'; ?></p>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Provinsi</label>
            <p><?= $applicant['provinsi'] ?? '-'; ?></p>
        </div>
        <div class="form-group">
            <label>Kode Pos</label>
            <p><?= $applicant['kode_pos'] ?? '-'; ?></p>
        </div>
    </div>
</div>

<!-- Kontak -->
<div class="form-section">
    <h5><i class="bi bi-telephone"></i> Kontak</label>
    <div class="form-row">
        <div class="form-group">
            <label>Nomor HP</label>
            <p><?= $applicant['nomor_hp'] ?? '-'; ?></p>
        </div>
    </div>
</div>

<!-- Asal Sekolah -->
<div class="form-section">
    <h5><i class="bi bi-book"></i> Asal Sekolah</h5>
    <div class="form-row">
        <div class="form-group">
            <label>Nama Sekolah</label>
            <p><?= $applicant['asal_sekolah'] ?? '-'; ?></p>
        </div>
        <div class="form-group">
            <label>NPSN Sekolah</label>
            <p><?= $applicant['npsn_sekolah_asal'] ?? '-'; ?></p>
        </div>
    </div>
</div>

<!-- Data Orang Tua -->
<div class="form-section">
    <h5><i class="bi bi-person-badge"></i> Data Orang Tua</h5>
    <div class="form-row">
        <div class="form-group">
            <label>Nama Ayah</label>
            <p><?= $applicant['nama_ayah'] ?? '-'; ?></p>
        </div>
        <div class="form-group">
            <label>Nama Ibu</label>
            <p><?= $applicant['nama_ibu'] ?? '-'; ?></p>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="action-buttons">
    <a href="/panitia/edit_siswa/<?= $applicant['id']; ?>" class="btn btn-warning">
        <i class="bi bi-pencil"></i> Edit Data
    </a>
    <?php if ($applicant['status'] !== 'verified'): ?>
    <a href="/panitia/verifikasi-pendaftar/<?= $applicant['id']; ?>" class="btn btn-success">
        <i class="bi bi-check-circle"></i> Verifikasi
    </a>
    <?php else: ?>
    <a href="/panitia/cetak-pendaftaran/<?= $applicant['id']; ?>" class="btn btn-primary">
        <i class="bi bi-printer"></i> Cetak Formulir
    </a>
    <a href="/panitia/batal-verifikasi/<?= $applicant['id']; ?>" class="btn btn-danger" onclick="return confirm('Batalkan verifikasi? Data akan kembali ke status Submitted.');">
        <i class="bi bi-arrow-counterclockwise"></i> Batal Verifikasi
    </a>
    <?php endif; ?>
    <a href="/panitia/daftar-siswa" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<?php else: ?>
<div class="alert alert-danger">
    <i class="bi bi-exclamation-circle-fill"></i> Data siswa tidak ditemukan.
</div>
<?php endif; ?>

<?= $this->endSection(); ?>
