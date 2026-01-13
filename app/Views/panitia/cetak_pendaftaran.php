<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Cetak Formulir Pendaftaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<style>
    .print-container {
        background-color: white;
        max-width: 210mm;
        height: auto;
        margin: 0 auto;
        padding: 1.5rem;
        box-sizing: border-box;
    }
    
    .form-title {
        text-align: center;
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        margin: 0 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #333;
    }

    .info-box {
        background-color: #f8f9fa;
        border: 1px solid #667eea;
        border-radius: 0.25rem;
        padding: 0.75rem;
        margin-bottom: 1rem;
        text-align: center;
    }

    .nomor-pendaftaran {
        font-size: 1rem;
        font-weight: 700;
        color: #667eea;
    }

    .print-header {
        display: flex;
        align-items: center;
        border-bottom: 2px solid #333;
        padding-bottom: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .school-logo {
        width: 50px;
        height: 50px;
        margin-right: 0.75rem;
        background-color: #f0f0f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
    }

    .school-info {
        flex: 1;
        text-align: center;
    }

    .school-info h2 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: #333;
    }

    .school-info p {
        margin: 0.1rem 0;
        color: #666;
        font-size: 0.75rem;
        line-height: 1.1;
    }

    .status-badge {
        display: inline-block;
        background-color: #28a745;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    .section-title {
        background-color: #667eea;
        color: white;
        padding: 0.4rem 0.75rem;
        margin-top: 0.75rem;
        margin-bottom: 0.5rem;
        font-weight: 700;
        font-size: 0.9rem;
        border-radius: 0.25rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem 1rem;
        margin-bottom: 0.5rem;
    }

    .form-grid.full {
        grid-template-columns: 1fr;
    }

    .form-field {
        display: grid;
        grid-template-columns: 40% 1fr;
        gap: 0.5rem;
        align-items: baseline;
        font-size: 0.9rem;
        line-height: 1.2;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-value {
        color: #555;
        border-bottom: 1px dotted #999;
        padding-bottom: 0.1rem;
        min-height: 1rem;
    }

    .signature-section {
        margin-top: 1.5rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        text-align: center;
        font-size: 0.85rem;
    }

    .signature-box {
        border-top: 1px solid #333;
        margin-top: 2rem;
        padding-top: 0.25rem;
    }

    .signature-label {
        font-weight: 600;
        color: #333;
    }

    .print-footer {
        text-align: center;
        margin-top: 1rem;
        padding-top: 0.5rem;
        border-top: 1px solid #333;
        font-size: 0.75rem;
        color: #666;
    }

    .no-print {
        margin-bottom: 2rem;
    }

    @media print {
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        html {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden !important;
        }
        body {
            width: 100%;
            height: 100%;
            margin: 0 !important;
            padding: 0 !important;
            background: white;
            overflow: hidden !important;
            font-size: 10pt;
            line-height: 1.2;
        }
        ::-webkit-scrollbar {
            display: none !important;
        }
        nav, .navbar, .sidebar, .main-sidebar, .navbar-expand, header, footer, .footer {
            display: none !important;
        }
        .container, .container-fluid, main, [role="main"], .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
            background: white !important;
        }
        .no-print {
            display: none !important;
        }
        .print-container {
            max-width: 210mm;
            width: 210mm;
            margin: 0;
            padding: 12mm;
            box-shadow: none;
            background: white;
            page-break-after: avoid;
        }
        .section-title {
            background-color: #667eea !important;
            color: white !important;
            page-break-inside: avoid;
        }
        .form-grid {
            page-break-inside: avoid;
        }
        .signature-section {
            page-break-inside: avoid;
        }
        @page {
            size: A4;
            margin: 0;
            padding: 0;
        }
    }
</style>

<div class="no-print">
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; align-items: center;">
        <a href="/panitia/lihat_siswa/<?= $applicant['id']; ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Cetak / Simpan PDF
        </button>
    </div>
</div>

<div class="print-container">
    <!-- Header Kop Sekolah -->
    <div class="print-header">
        <div class="school-logo">
            <?php if (!empty($kopSurat['logo_path']) && file_exists(ROOTPATH . $kopSurat['logo_path'])): ?>
                <img src="/<?= $kopSurat['logo_path']; ?>" alt="Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            <?php else: ?>
                📚
            <?php endif; ?>
        </div>
        <div class="school-info">
            <h2><?= $kopSurat['school_name'] ?? 'SEKOLAH MENENGAH ATAS NEGERI'; ?></h2>
            <?php if (!empty($kopSurat['address'])): ?>
                <p><?= $kopSurat['address']; ?></p>
            <?php endif; ?>
            <?php if (!empty($kopSurat['phone']) || !empty($kopSurat['email'])): ?>
                <p>
                    <?php if (!empty($kopSurat['phone'])): ?>
                        Telp: <?= $kopSurat['phone']; ?>
                    <?php endif; ?>
                    <?php if (!empty($kopSurat['email'])): ?>
                        <?php if (!empty($kopSurat['phone'])): ?> | <?php endif; ?>
                        <?= $kopSurat['email']; ?>
                    <?php endif; ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Title -->
    <div class="form-title">FORMULIR PENDAFTARAN SISWA BARU</div>

    <!-- Status Badge -->
    <div style="text-align: center; margin-bottom: 0.75rem;">
        <span class="status-badge">
            <i class="bi bi-check-circle-fill"></i> SUDAH TERVERIFIKASI
        </span>
    </div>

    <!-- Nomor Pendaftaran -->
    <div class="info-box">
        <div style="font-size: 0.7rem; color: #666; margin-bottom: 0.2rem;">NOMOR PENDAFTARAN</div>
        <div class="nomor-pendaftaran"><?= $applicant['nomor_pendaftaran'] ?? '-'; ?></div>
    </div>

    <!-- I. DATA PRIBADI -->
    <div class="section-title">I. DATA PRIBADI</div>
    <div class="form-grid">
        <div class="form-field">
            <span class="form-label">Nama Lengkap</span>
            <span class="form-value"><?= $applicant['nama_lengkap'] ?? '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">NIK</span>
            <span class="form-value"><?= $applicant['nik'] ?? '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">Jenis Kelamin</span>
            <span class="form-value"><?= ucfirst($applicant['jenis_kelamin'] ?? '-'); ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">Tanggal Lahir</span>
            <span class="form-value"><?= $applicant['tanggal_lahir'] ? date('d-m-Y', strtotime($applicant['tanggal_lahir'])) : '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">Tempat Lahir</span>
            <span class="form-value"><?= $applicant['tempat_lahir'] ?? '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">Agama</span>
            <span class="form-value"><?= $applicant['agama'] ?? '-'; ?></span>
        </div>
    </div>

    <!-- II. DATA KELUARGA -->
    <div class="section-title">II. DATA KELUARGA</div>
    <div class="form-grid">
        <div class="form-field">
            <span class="form-label">Anak Ke-</span>
            <span class="form-value"><?= $applicant['anak_ke'] ?? '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">Jumlah Saudara</span>
            <span class="form-value"><?= $applicant['jumlah_saudara'] ?? '-'; ?></span>
        </div>
    </div>

    <!-- III. ALAMAT -->
    <div class="section-title">III. ALAMAT</div>
    <div class="form-grid full">
        <div class="form-field">
            <span class="form-label">Alamat Jalan</span>
            <span class="form-value"><?= $applicant['alamat_jalan'] ?? '-'; ?></span>
        </div>
    </div>
    <div class="form-grid">
        <div class="form-field">
            <span class="form-label">Dusun</span>
            <span class="form-value"><?= $applicant['dusun'] ?? '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">Kelurahan</span>
            <span class="form-value"><?= $applicant['kelurahan'] ?? '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">Kecamatan</span>
            <span class="form-value"><?= $applicant['kecamatan'] ?? '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">Kabupaten</span>
            <span class="form-value"><?= $applicant['kabupaten'] ?? '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">Provinsi</span>
            <span class="form-value"><?= $applicant['provinsi'] ?? '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">Kode Pos</span>
            <span class="form-value"><?= $applicant['kode_pos'] ?? '-'; ?></span>
        </div>
    </div>

    <!-- IV. KONTAK -->
    <div class="section-title">IV. KONTAK</div>
    <div class="form-grid">
        <div class="form-field">
            <span class="form-label">Nomor HP</span>
            <span class="form-value"><?= $applicant['nomor_hp'] ?? '-'; ?></span>
        </div>
    </div>

    <!-- V. ASAL SEKOLAH -->
    <div class="section-title">V. ASAL SEKOLAH</div>
    <div class="form-grid">
        <div class="form-field">
            <span class="form-label">Nama Sekolah</span>
            <span class="form-value"><?= $applicant['asal_sekolah'] ?? '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">NPSN</span>
            <span class="form-value"><?= $applicant['npsn_sekolah_asal'] ?? '-'; ?></span>
        </div>
    </div>

    <!-- VI. DATA ORANG TUA -->
    <div class="section-title">VI. DATA ORANG TUA</div>
    <div class="form-grid">
        <div class="form-field">
            <span class="form-label">Nama Ayah</span>
            <span class="form-value"><?= $applicant['nama_ayah'] ?? '-'; ?></span>
        </div>
        <div class="form-field">
            <span class="form-label">Nama Ibu</span>
            <span class="form-value"><?= $applicant['nama_ibu'] ?? '-'; ?></span>
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div>
            <div class="signature-label">Kepala Sekolah</div>
            <div class="signature-box"></div>
        </div>
        <div>
            <div class="signature-label">Panitia Pendaftaran</div>
            <div class="signature-box"></div>
        </div>
        <div>
            <div class="signature-label">Orang Tua / Wali</div>
            <div class="signature-box"></div>
        </div>
    </div>

    <!-- Footer -->
    <div class="print-footer">
        Dokumen dicetak dari Sistem PPDB - <?= date('d M Y H:i'); ?>
    </div>
</div>

<?= $this->endSection(); ?>
