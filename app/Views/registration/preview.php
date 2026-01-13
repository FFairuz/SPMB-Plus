<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Preview dan verifikasi data pendaftaran PPDB">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #8b5cf6;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }

        html, body {
            scroll-behavior: smooth;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px 0 40px 0;
        }

        .preview-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            max-width: 1100px;
            margin: 30px auto;
            overflow: hidden;
        }

        .preview-header {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .preview-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .preview-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .preview-header-content {
            position: relative;
            z-index: 1;
        }

        .preview-header h1 {
            margin: 0;
            font-weight: 700;
            font-size: 32px;
            letter-spacing: -0.5px;
        }

        .preview-header p {
            margin: 15px 0 0 0;
            opacity: 0.95;
            font-size: 16px;
            font-weight: 300;
        }

        .preview-body {
            padding: 50px;
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 30px;
            padding: 18px 24px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .alert-info {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            border-left: 4px solid var(--primary-color);
        }

        .alert i {
            font-size: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .form-number {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .form-number i {
            margin-right: 8px;
        }

        .section-header {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 18px;
            margin-top: 35px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--primary-color);
            display: flex;
            align-items: center;
            gap: 12px;
            scroll-margin-top: 20px;
        }

        .section-header i {
            font-size: 24px;
        }

        .preview-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 20px;
        }

        .preview-row.full {
            grid-template-columns: 1fr;
        }

        .preview-field {
            margin-bottom: 15px;
        }

        .preview-label {
            font-weight: 600;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .preview-value {
            color: #1e293b;
            font-size: 15px;
            padding: 12px 15px;
            background: var(--light-bg);
            border-radius: 8px;
            border-left: 3px solid var(--primary-color);
            min-height: 40px;
            display: flex;
            align-items: center;
            line-height: 1.5;
        }

        .preview-value:empty::before {
            content: '—';
            color: #a0aec0;
            font-style: italic;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid var(--border-color);
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 35px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .btn-secondary {
            background: var(--light-bg);
            color: #333;
            border: 2px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: white;
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        .summary-box {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(139, 92, 246, 0.08) 100%);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .summary-box h5 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        @media print {
            body {
                background: white;
            }
            .btn-group {
                display: none;
            }
            .alert {
                display: none;
            }
            .preview-container {
                box-shadow: none;
                margin: 0;
            }
        }

        @media (max-width: 768px) {
            .preview-body {
                padding: 30px 20px;
            }

            .preview-header {
                padding: 40px 20px;
            }

            .preview-header h1 {
                font-size: 24px;
            }

            .preview-row {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .section-header {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="preview-container">
            <div class="preview-header">
                <div class="preview-header-content">
                    <h1><i class="bi bi-file-earmark-check"></i> VERIFIKASI DATA PENDAFTARAN</h1>
                    <p>Periksa kembali semua data Anda sebelum mengirimkan</p>
                </div>
            </div>

            <div class="preview-body">
                <!-- INFO ALERT -->
                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        <strong>Pastikan semua data sudah benar!</strong> Jika ada yang perlu diubah, klik tombol <strong>"Edit Data"</strong> untuk kembali ke formulir dan melakukan perbaikan. Setelah Anda yakin, klik <strong>"Kirim Pendaftaran"</strong> untuk menyelesaikan proses.
                    </div>
                </div>

                <!-- REGISTRATION NUMBER -->
                <div class="form-number">
                    <i class="bi bi-check-circle"></i> No. Pendaftaran: <strong><?= $applicant['nomor_pendaftaran'] ?></strong>
                </div>

                <!-- DATA PRIBADI -->
                <div class="section-header">
                    <i class="bi bi-person-fill"></i> Data Pribadi Peserta Didik
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">NIK</div>
                        <div class="preview-value"><?= $applicant['nik'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">NIS</div>
                        <div class="preview-value"><?= $applicant['nis'] ?></div>
                    </div>
                </div>

                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Nama Lengkap</div>
                        <div class="preview-value"><?= $applicant['nama_lengkap'] ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">Nama Panggilan</div>
                        <div class="preview-value"><?= $applicant['nama_panggilan'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Jenis Kelamin</div>
                        <div class="preview-value"><?= ucfirst($applicant['jenis_kelamin']) ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">Tempat Lahir</div>
                        <div class="preview-value"><?= $applicant['tempat_lahir'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Tanggal Lahir</div>
                        <div class="preview-value"><?= date('d-m-Y', strtotime($applicant['tanggal_lahir'])) ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">Agama</div>
                        <div class="preview-value"><?= $applicant['agama'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Status dalam Keluarga</div>
                        <div class="preview-value"><?= str_replace('_', ' ', ucfirst($applicant['status_keluarga'])) ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">Anak Ke</div>
                        <div class="preview-value"><?= $applicant['anak_ke'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Jumlah Saudara</div>
                        <div class="preview-value"><?= $applicant['jumlah_saudara'] ?></div>
                    </div>
                </div>

                <!-- ALAMAT -->
                <div class="section-header">
                    <i class="bi bi-geo-alt-fill"></i> Alamat Tempat Tinggal
                </div>

                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Alamat Jalan</div>
                        <div class="preview-value"><?= $applicant['alamat_jalan'] ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">Dusun</div>
                        <div class="preview-value"><?= $applicant['dusun'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Kelurahan</div>
                        <div class="preview-value"><?= $applicant['kelurahan'] ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">Kecamatan</div>
                        <div class="preview-value"><?= $applicant['kecamatan'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Kabupaten/Kota</div>
                        <div class="preview-value"><?= $applicant['kabupaten'] ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">Provinsi</div>
                        <div class="preview-value"><?= $applicant['provinsi'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Kode Pos</div>
                        <div class="preview-value"><?= $applicant['kode_pos'] ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">Telepon Rumah</div>
                        <div class="preview-value"><?= $applicant['nomor_telepon'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Nomor HP</div>
                        <div class="preview-value"><?= $applicant['nomor_hp'] ?></div>
                    </div>
                </div>

                <!-- SEKOLAH ASAL -->
                <div class="section-header">
                    <i class="bi bi-building"></i> Data Sekolah Asal
                </div>

                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Nama Sekolah Asal</div>
                        <div class="preview-value"><?= $applicant['asal_sekolah'] ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">NPSN Sekolah Asal</div>
                        <div class="preview-value"><?= $applicant['npsn_sekolah_asal'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Rata-rata Nilai</div>
                        <div class="preview-value"><?= $applicant['nilai_rata_rata'] ?></div>
                    </div>
                </div>

                <?php if($applicant['nilai_un_indo'] || $applicant['nilai_un_math'] || $applicant['nilai_un_english'] || $applicant['nilai_un_science']): ?>
                <div class="section-header" style="margin-top: 15px;">Nilai Ujian Nasional</div>
                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">UN Bahasa Indonesia</div>
                        <div class="preview-value"><?= $applicant['nilai_un_indo'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">UN Matematika</div>
                        <div class="preview-value"><?= $applicant['nilai_un_math'] ?></div>
                    </div>
                </div>
                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">UN Bahasa Inggris</div>
                        <div class="preview-value"><?= $applicant['nilai_un_english'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">UN IPA</div>
                        <div class="preview-value"><?= $applicant['nilai_un_science'] ?></div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- DATA AYAH -->
                <div class="section-header">
                    <i class="bi bi-people-fill"></i> Data Ayah
                </div>

                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Nama Ayah</div>
                        <div class="preview-value"><?= $applicant['nama_ayah'] ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">NIK Ayah</div>
                        <div class="preview-value"><?= $applicant['nik_ayah'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Pendidikan Terakhir</div>
                        <div class="preview-value"><?= $applicant['pendidikan_ayah'] ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">Pekerjaan</div>
                        <div class="preview-value"><?= $applicant['pekerjaan_ayah'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Penghasilan Bulanan</div>
                        <div class="preview-value"><?= $applicant['penghasilan_ayah'] ?></div>
                    </div>
                </div>

                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Nomor HP Ayah</div>
                        <div class="preview-value"><?= $applicant['nomor_hp_ayah'] ?></div>
                    </div>
                </div>

                <!-- DATA IBU -->
                <div class="section-header">
                    <i class="bi bi-people-fill"></i> Data Ibu
                </div>

                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Nama Ibu</div>
                        <div class="preview-value"><?= $applicant['nama_ibu'] ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">NIK Ibu</div>
                        <div class="preview-value"><?= $applicant['nik_ibu'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Pendidikan Terakhir</div>
                        <div class="preview-value"><?= $applicant['pendidikan_ibu'] ?></div>
                    </div>
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">Pekerjaan</div>
                        <div class="preview-value"><?= $applicant['pekerjaan_ibu'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Penghasilan Bulanan</div>
                        <div class="preview-value"><?= $applicant['penghasilan_ibu'] ?></div>
                    </div>
                </div>

                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Nomor HP Ibu</div>
                        <div class="preview-value"><?= $applicant['nomor_hp_ibu'] ?></div>
                    </div>
                </div>

                <!-- DATA WALI -->
                <?php if($applicant['nama_wali']): ?>
                <div class="section-header">
                    <i class="bi bi-shield-fill"></i> Data Wali
                </div>

                <div class="preview-row">
                    <div class="preview-field">
                        <div class="preview-label">Nama Wali</div>
                        <div class="preview-value"><?= $applicant['nama_wali'] ?></div>
                    </div>
                    <div class="preview-field">
                        <div class="preview-label">Hubungan dengan Anak</div>
                        <div class="preview-value"><?= $applicant['hubungan_wali'] ?></div>
                    </div>
                </div>

                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Nomor HP Wali</div>
                        <div class="preview-value"><?= $applicant['nomor_hp_wali'] ?></div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- PRESTASI & KEBUTUHAN KHUSUS -->
                <?php if($applicant['prestasi_akademik'] || $applicant['prestasi_non_akademik'] || $applicant['kelainan_fisik'] || $applicant['kebutuhan_khusus_lainnya']): ?>
                <div class="section-header">
                    <i class="bi bi-star-fill"></i> Prestasi & Kebutuhan Khusus
                </div>

                <?php if($applicant['prestasi_akademik']): ?>
                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Prestasi Akademik</div>
                        <div class="preview-value"><?= nl2br($applicant['prestasi_akademik']) ?></div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($applicant['prestasi_non_akademik']): ?>
                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Prestasi Non-Akademik</div>
                        <div class="preview-value"><?= nl2br($applicant['prestasi_non_akademik']) ?></div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($applicant['kelainan_fisik']): ?>
                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Kelainan Fisik</div>
                        <div class="preview-value"><?= $applicant['kelainan_fisik'] ?></div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($applicant['kebutuhan_khusus_lainnya']): ?>
                <div class="preview-row full">
                    <div class="preview-field">
                        <div class="preview-label">Kebutuhan Khusus Lainnya</div>
                        <div class="preview-value"><?= nl2br($applicant['kebutuhan_khusus_lainnya']) ?></div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>

                <!-- BUTTONS -->
                <div class="btn-group">
                    <a href="/registration" class="btn btn-secondary" role="button">
                        <i class="bi bi-pencil-square"></i> Edit Data
                    </a>
                    <form method="POST" action="/registration/submit" style="display: inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-check-circle"></i> Kirim Pendaftaran
                        </button>
                    </form>
                    <button class="btn btn-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Cetak Preview
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Confirm before submitting
        document.querySelector('form').addEventListener('submit', function(e) {
            const confirmed = confirm('Apakah Anda yakin ingin mengirimkan pendaftaran? Data tidak dapat diubah setelah dikirim.');
            if (!confirmed) {
                e.preventDefault();
            }
        });

        // Add keyboard shortcut for printing
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html>
