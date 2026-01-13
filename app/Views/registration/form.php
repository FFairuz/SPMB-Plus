<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulir pendaftaran PPDB resmi dan terstandar sesuai standar Dapodik dan Dinas Pendidikan">
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

        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            max-width: 1100px;
            margin: 30px auto;
        }

        .form-header {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .form-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .form-header-content {
            position: relative;
            z-index: 1;
        }

        .form-header h1 {
            margin: 0;
            font-weight: 700;
            font-size: 32px;
            letter-spacing: -0.5px;
        }

        .form-header p {
            margin: 15px 0 0 0;
            opacity: 0.95;
            font-size: 16px;
            font-weight: 300;
        }

        .form-header .badge-status {
            display: inline-block;
            background: rgba(255, 255, 255, 0.25);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .form-body {
            padding: 50px;
        }

        /* Progress Bar */
        .progress-bar-container {
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid var(--border-color);
        }

        .progress-bar-wrapper {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 15px;
        }

        .progress-bar-text {
            font-size: 13px;
            font-weight: 600;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .progress-bar-wrapper .progress {
            flex: 1;
            height: 8px;
            background-color: var(--light-bg);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar-wrapper .progress-bar {
            background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
            transition: width 0.4s ease;
        }

        .progress-info {
            font-size: 12px;
            color: #666;
            text-align: center;
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 20px;
            margin-top: 35px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--primary-color);
            display: flex;
            align-items: center;
            gap: 12px;
            scroll-margin-top: 20px;
        }

        .section-title i {
            font-size: 26px;
        }

        .section-subtitle {
            font-size: 13px;
            color: #666;
            margin: -20px 0 20px 0;
            padding-left: 38px;
            font-style: italic;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 10px;
            display: block;
            font-size: 14px;
        }

        .form-label .required {
            color: var(--danger-color);
            font-weight: 700;
        }

        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        .form-control:invalid {
            border-color: var(--danger-color);
        }

        .form-control:valid {
            border-color: var(--success-color);
        }

        .row-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 20px;
        }

        .row-group.full {
            grid-template-columns: 1fr;
        }

        .form-text {
            font-size: 13px;
            color: #64748b;
            margin-top: 8px;
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 13px;
            margin-top: 8px;
            display: block;
        }

        .btn-group-bottom {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 2px solid var(--border-color);
            flex-wrap: wrap;
        }

        .btn-submit {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            border: none;
            padding: 14px 45px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .btn-draft {
            background: var(--light-bg);
            color: #333;
            border: 2px solid var(--border-color);
            padding: 14px 45px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-draft:hover {
            background: white;
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 30px;
            padding: 18px 24px;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #047857;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }

        .info-box {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(139, 92, 246, 0.08) 100%);
            border-left: 4px solid var(--primary-color);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .info-box i {
            color: var(--primary-color);
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .info-box strong {
            color: #1e293b;
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        .form-number {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .form-number i {
            margin-right: 8px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 18px;
        }

        .input-with-icon .form-control {
            padding-left: 45px;
        }

        .helper-text {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #64748b;
            margin-top: 8px;
        }

        .helper-text i {
            color: var(--primary-color);
            font-size: 14px;
            flex-shrink: 0;
        }

        .section-card {
            background: var(--light-bg);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            border: 2px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .section-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
        }

        .checkbox-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .checkbox-item {
            flex: 1;
            min-width: 150px;
        }

        .form-check-input {
            border: 2px solid var(--border-color);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 20px;
            height: 20px;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-check-label {
            cursor: pointer;
            user-select: none;
            font-weight: 500;
            color: #1e293b;
            margin-left: 8px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
            font-family: 'Inter', sans-serif;
        }

        .required-note {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        @media (max-width: 768px) {
            .form-body {
                padding: 30px 20px;
            }

            .form-header {
                padding: 40px 20px;
            }

            .form-header h1 {
                font-size: 24px;
            }

            .row-group {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .btn-group-bottom {
                flex-direction: column;
            }

            .btn-submit, .btn-draft {
                width: 100%;
                justify-content: center;
            }

            .section-title {
                font-size: 18px;
            }

            .progress-bar-wrapper {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container" style="max-width: 1100px;">
            <div class="form-header">
                <div class="form-header-content">
                    <h1><i class="bi bi-file-earmark-text"></i> FORMULIR PENDAFTARAN PPDB</h1>
                    <p>Penerimaan Peserta Didik Baru Tahun Ajaran 2025/2026</p>
                    <div class="badge-status">
                        <i class="bi bi-shield-check"></i> Resmi & Terstandar Dapodik
                    </div>
                </div>
            </div>

            <div class="form-body">
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-circle"></i> 
                        <strong>Terjadi Kesalahan!</strong> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle"></i> 
                        <strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- PROGRESS BAR -->
                <div class="progress-bar-container">
                    <div class="progress-bar-wrapper">
                        <span class="progress-bar-text">Progres Pengisian</span>
                        <div class="progress">
                            <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="progress-info" id="progressText">0%</span>
                    </div>
                </div>

                <!-- INFO BOX -->
                <div class="info-box">
                    <i class="bi bi-lightbulb-fill"></i>
                    <div>
                        <strong>💡 Panduan Pengisian Formulir</strong>
                        <p style="margin: 8px 0 0 0; font-size: 13px; line-height: 1.5;">
                            Mohon isi semua data (<span style="color: var(--danger-color); font-weight: 700;">*</span>) dengan benar dan lengkap sesuai dokumen resmi (KTP/Akta Kelahiran/Rapor). Data yang tidak valid dapat mempengaruhi proses verifikasi dan penerimaan. Anda dapat menyimpan sebagai draft dan melanjutkan kemudian.
                        </p>
                    </div>
                </div>

                <?php if ($edit_mode && $applicant): ?>
                    <div class="form-number">
                        <i class="bi bi-check-circle"></i> No. Pendaftaran: <strong><?= $applicant['nomor_pendaftaran'] ?></strong>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/registration/save" id="registrationForm" novalidate>
                    <?= csrf_field() ?>

                    <!-- BAGIAN 1: DATA PRIBADI PESERTA DIDIK -->
                    <div class="section-card">
                        <div class="section-title">
                            <i class="bi bi-person-circle"></i> Data Pribadi Peserta Didik
                        </div>
                        <div class="section-subtitle">Isi sesuai dengan KTP atau Akta Kelahiran</div>

                        <div class="row-group">
                            <div class="form-group">
                                <label class="form-label">
                                    NIK (Nomor Induk Kependudukan) <span class="required">*</span>
                                </label>
                                <div class="input-with-icon">
                                    <i class="bi bi-card-text input-icon"></i>
                                    <input type="text" class="form-control" name="nik" 
                                           value="<?= old('nik', $applicant['nik'] ?? '') ?>"
                                           placeholder="Contoh: 1234567890123456" maxlength="16" 
                                           inputmode="numeric" required>
                                </div>
                                <div class="helper-text">
                                    <i class="bi bi-info-circle"></i>
                                    16 digit dari KTP/Kartu Keluarga
                                </div>
                                <?php if (isset($errors) && isset($errors['nik'])): ?>
                                    <div class="invalid-feedback"><?= $errors['nik'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    NIS (Nomor Induk Siswa)
                                </label>
                                <input type="text" class="form-control" name="nis"
                                       value="<?= old('nis', $applicant['nis'] ?? '') ?>"
                                       placeholder="Opsional - dari raport siswa">
                                <div class="helper-text">
                                    <i class="bi bi-info-circle"></i>
                                    Jika pernah bersekolah sebelumnya
                                </div>
                            </div>
                        </div>

                        <div class="row-group full">
                            <div class="form-group">
                                <label class="form-label">
                                    Nama Lengkap <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="nama_lengkap"
                                       value="<?= old('nama_lengkap', $applicant['nama_lengkap'] ?? '') ?>"
                                       placeholder="Sesuai KTP/Akta - tanpa gelar" required>
                                <div class="helper-text">
                                    <i class="bi bi-exclamation-circle"></i>
                                    Harus sama persis dengan dokumen resmi
                                </div>
                            </div>
                        </div>

                        <div class="row-group">
                            <div class="form-group">
                                <label class="form-label">Nama Panggilan</label>
                                <input type="text" class="form-control" name="nama_panggilan"
                                       value="<?= old('nama_panggilan', $applicant['nama_panggilan'] ?? '') ?>"
                                       placeholder="Contoh: Budi, Ani, dll">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Jenis Kelamin <span class="required">*</span>
                                </label>
                                <select class="form-select" name="jenis_kelamin" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="laki-laki" <?= old('jenis_kelamin', $applicant['jenis_kelamin'] ?? '') == 'laki-laki' ? 'selected' : '' ?>>
                                        <i class="bi bi-person"></i> Laki-laki
                                    </option>
                                    <option value="perempuan" <?= old('jenis_kelamin', $applicant['jenis_kelamin'] ?? '') == 'perempuan' ? 'selected' : '' ?>>
                                        <i class="bi bi-person"></i> Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row-group">
                            <div class="form-group">
                                <label class="form-label">
                                    Tempat Lahir <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="tempat_lahir"
                                       value="<?= old('tempat_lahir', $applicant['tempat_lahir'] ?? '') ?>"
                                       placeholder="Contoh: Jakarta" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Tanggal Lahir <span class="required">*</span>
                                </label>
                                <input type="date" class="form-control" name="tanggal_lahir"
                                       value="<?= old('tanggal_lahir', $applicant['tanggal_lahir'] ?? '') ?>" 
                                       required>
                                <div class="helper-text">
                                    <i class="bi bi-calendar-event"></i>
                                    Minimal usia 12 tahun saat pendaftaran
                                </div>
                            </div>
                        </div>

                        <div class="row-group">
                            <div class="form-group">
                                <label class="form-label">
                                    Agama <span class="required">*</span>
                                </label>
                                <select class="form-select" name="agama" required>
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam" <?= old('agama', $applicant['agama'] ?? '') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                    <option value="Kristen" <?= old('agama', $applicant['agama'] ?? '') == 'Kristen' ? 'selected' : '' ?>>Kristen Protestan</option>
                                    <option value="Katolik" <?= old('agama', $applicant['agama'] ?? '') == 'Katolik' ? 'selected' : '' ?>>Kristen Katolik</option>
                                    <option value="Hindu" <?= old('agama', $applicant['agama'] ?? '') == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                    <option value="Buddha" <?= old('agama', $applicant['agama'] ?? '') == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                                    <option value="Konghucu" <?= old('agama', $applicant['agama'] ?? '') == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                                    <option value="Lainnya" <?= old('agama', $applicant['agama'] ?? '') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Status dalam Keluarga <span class="required">*</span>
                                </label>
                                <select class="form-select" name="status_keluarga" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="anak_kandung" <?= old('status_keluarga', $applicant['status_keluarga'] ?? '') == 'anak_kandung' ? 'selected' : '' ?>>Anak Kandung</option>
                                    <option value="anak_tiri" <?= old('status_keluarga', $applicant['status_keluarga'] ?? '') == 'anak_tiri' ? 'selected' : '' ?>>Anak Tiri</option>
                                    <option value="anak_angkat" <?= old('status_keluarga', $applicant['status_keluarga'] ?? '') == 'anak_angkat' ? 'selected' : '' ?>>Anak Angkat</option>
                                </select>
                            </div>
                        </div>

                        <div class="row-group">
                            <div class="form-group">
                                <label class="form-label">
                                    Anak Ke <span class="required">*</span>
                                </label>
                                <input type="number" class="form-control" name="anak_ke"
                                       value="<?= old('anak_ke', $applicant['anak_ke'] ?? '') ?>" min="1" 
                                       placeholder="Contoh: 1, 2, 3, dll" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Jumlah Saudara <span class="required">*</span>
                                </label>
                                <input type="number" class="form-control" name="jumlah_saudara"
                                       value="<?= old('jumlah_saudara', $applicant['jumlah_saudara'] ?? '') ?>" min="0" 
                                       placeholder="Contoh: 0, 1, 2, dll" required>
                                <div class="helper-text">
                                    <i class="bi bi-info-circle"></i>
                                    Saudara kandung, tiri, atau angkat
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BAGIAN 2: ALAMAT -->
                    <div class="section-card">
                        <div class="section-title">
                            <i class="bi bi-geo-alt"></i> Alamat Tempat Tinggal
                        </div>
                        <div class="section-subtitle">Isi sesuai dengan KTP atau surat keterangan domisili</div>

                        <div class="form-group">
                            <label class="form-label">
                                Jalan/Jl. <span class="required">*</span>
                            </label>
                            <textarea class="form-control" name="alamat_jalan" rows="2"
                                      placeholder="Contoh: Jl. Merdeka No. 42 Rt. 03 Rw. 05" required><?= old('alamat_jalan', $applicant['alamat_jalan'] ?? '') ?></textarea>
                        </div>

                        <div class="row-group">
                            <div class="form-group">
                                <label class="form-label">Dusun/Lingkungan</label>
                                <input type="text" class="form-control" name="dusun"
                                       value="<?= old('dusun', $applicant['dusun'] ?? '') ?>"
                                       placeholder="Opsional">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Kelurahan <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="kelurahan"
                                       value="<?= old('kelurahan', $applicant['kelurahan'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="row-group">
                            <div class="form-group">
                                <label class="form-label">
                                    Kecamatan <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="kecamatan"
                                       value="<?= old('kecamatan', $applicant['kecamatan'] ?? '') ?>" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Kabupaten/Kota <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="kabupaten"
                                       value="<?= old('kabupaten', $applicant['kabupaten'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="row-group">
                            <div class="form-group">
                                <label class="form-label">
                                    Provinsi <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="provinsi"
                                       value="<?= old('provinsi', $applicant['provinsi'] ?? '') ?>" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Kode Pos <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" name="kode_pos"
                                       value="<?= old('kode_pos', $applicant['kode_pos'] ?? '') ?>"
                                       placeholder="5 digit" maxlength="5" inputmode="numeric" required>
                            </div>
                        </div>

                        <div class="row-group">
                            <div class="form-group">
                                <label class="form-label">Telepon Rumah</label>
                                <input type="tel" class="form-control" name="nomor_telepon"
                                       value="<?= old('nomor_telepon', $applicant['nomor_telepon'] ?? '') ?>"
                                       placeholder="Contoh: 021-123456">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Nomor HP/WhatsApp <span class="required">*</span>
                                </label>
                                <input type="tel" class="form-control" name="nomor_hp"
                                       value="<?= old('nomor_hp', $applicant['nomor_hp'] ?? '') ?>"
                                       placeholder="Contoh: 081234567890" required>
                                <div class="helper-text">
                                    <i class="bi bi-info-circle"></i>
                                    Nomor aktif untuk komunikasi pendaftaran
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Asal Sekolah / NPSN <span class="required">*</span>
                        </label>
                        <select id="schoolSelect" name="asal_sekolah" class="form-control select-school" required>
                            <option value="">-- Pilih Sekolah Asal --</option>
                            <?php if (isset($schools) && !empty($schools)): ?>
                                <?php foreach ($schools as $school): ?>
                                    <option value="<?= $school['nama'] ?>" 
                                            data-npsn="<?= $school['npsn'] ?? '-' ?>"
                                            data-kota="<?= $school['kota'] ?>"
                                            data-provinsi="<?= $school['provinsi'] ?>"
                                            <?= old('asal_sekolah') == $school['nama'] ? 'selected' : '' ?>>
                                        <?= esc($school['nama']) ?> (<?= esc($school['kota']) ?>, <?= esc($school['provinsi']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <option value="">-- Sekolah Tidak Terdaftar? Input Manual --</option>
                        </select>
                        <div id="npsn-display" style="margin-top: 8px; font-size: 0.9rem; color: #6c757d;">
                            <strong>NPSN:</strong> <span id="npsn-value">-</span>
                        </div>
                        <input type="hidden" id="school_npsn" name="npsn_sekolah_asal">
                        <small class="form-text text-muted" style="display: block; margin-top: 8px;">
                            <i class="fas fa-info-circle"></i> Jika sekolah Anda tidak ada dalam daftar, silakan hubungi admin untuk menambahkannya
                        </small>
                    </div>

                    <!-- Manual input for school not in database -->
                    <div id="manual-school-input" style="display: none;">
                        <div class="form-group">
                            <label class="form-label">
                                Nama Sekolah (Input Manual) <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" id="manual_school_name" name="asal_sekolah_manual"
                                   value="<?= old('asal_sekolah_manual', '') ?>"
                                   placeholder="Masukkan nama sekolah Anda">
                        </div>
                        <div class="form-group">
                            <label class="form-label">NPSN Sekolah (Opsional)</label>
                            <input type="text" class="form-control" id="manual_npsn" name="npsn_sekolah_asal_manual"
                                   value="<?= old('npsn_sekolah_asal_manual', '') ?>"
                                   placeholder="Nomor NPSN jika ada">
                        </div>
                    </div>

                    <div class="row-group">
                        <div class="form-group">
                            <label class="form-label">
                                Rata-rata Nilai <span class="required">*</span>
                            </label>
                            <input type="number" class="form-control" name="nilai_rata_rata"
                                   value="<?= old('nilai_rata_rata', $applicant['nilai_rata_rata'] ?? '') ?>"
                                   step="0.01" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="section-title" style="margin-top: 20px;">Nilai Ujian Nasional (Opsional)</div>

                    <div class="row-group">
                        <div class="form-group">
                            <label class="form-label">Nilai UN Bahasa Indonesia</label>
                            <input type="number" class="form-control" name="nilai_un_indo"
                                   value="<?= old('nilai_un_indo', $applicant['nilai_un_indo'] ?? '') ?>"
                                   step="0.01" min="0" max="100">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nilai UN Matematika</label>
                            <input type="number" class="form-control" name="nilai_un_math"
                                   value="<?= old('nilai_un_math', $applicant['nilai_un_math'] ?? '') ?>"
                                   step="0.01" min="0" max="100">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nilai UN Bahasa Inggris</label>
                            <input type="number" class="form-control" name="nilai_un_english"
                                   value="<?= old('nilai_un_english', $applicant['nilai_un_english'] ?? '') ?>"
                                   step="0.01" min="0" max="100">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nilai UN IPA</label>
                            <input type="number" class="form-control" name="nilai_un_science"
                                   value="<?= old('nilai_un_science', $applicant['nilai_un_science'] ?? '') ?>"
                                   step="0.01" min="0" max="100">
                        </div>
                    </div>

                    <!-- BAGIAN 4: DATA ORANG TUA/WALI -->
                    <div class="section-title">
                        <i class="bi bi-people-fill"></i> Data Ayah
                    </div>

                    <div class="row-group">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">
                                Nama Ayah <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" name="nama_ayah"
                                   value="<?= old('nama_ayah', $applicant['nama_ayah'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="row-group">
                        <div class="form-group">
                            <label class="form-label">NIK Ayah</label>
                            <input type="text" class="form-control" name="nik_ayah"
                                   value="<?= old('nik_ayah', $applicant['nik_ayah'] ?? '') ?>"
                                   placeholder="16 digit" maxlength="16">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <select class="form-select" name="pendidikan_ayah">
                                <option value="">-- Pilih --</option>
                                <option value="SD" <?= old('pendidikan_ayah', $applicant['pendidikan_ayah'] ?? '') == 'SD' ? 'selected' : '' ?>>SD</option>
                                <option value="SMP" <?= old('pendidikan_ayah', $applicant['pendidikan_ayah'] ?? '') == 'SMP' ? 'selected' : '' ?>>SMP</option>
                                <option value="SMA" <?= old('pendidikan_ayah', $applicant['pendidikan_ayah'] ?? '') == 'SMA' ? 'selected' : '' ?>>SMA</option>
                                <option value="Diploma" <?= old('pendidikan_ayah', $applicant['pendidikan_ayah'] ?? '') == 'Diploma' ? 'selected' : '' ?>>Diploma</option>
                                <option value="S1" <?= old('pendidikan_ayah', $applicant['pendidikan_ayah'] ?? '') == 'S1' ? 'selected' : '' ?>>S1</option>
                                <option value="S2" <?= old('pendidikan_ayah', $applicant['pendidikan_ayah'] ?? '') == 'S2' ? 'selected' : '' ?>>S2</option>
                                <option value="S3" <?= old('pendidikan_ayah', $applicant['pendidikan_ayah'] ?? '') == 'S3' ? 'selected' : '' ?>>S3</option>
                                <option value="Lainnya" <?= old('pendidikan_ayah', $applicant['pendidikan_ayah'] ?? '') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="row-group">
                        <div class="form-group">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" name="pekerjaan_ayah"
                                   value="<?= old('pekerjaan_ayah', $applicant['pekerjaan_ayah'] ?? '') ?>"
                                   placeholder="Contoh: Pegawai Negeri Sipil">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Penghasilan Bulanan</label>
                            <select class="form-select" name="penghasilan_ayah">
                                <option value="">-- Pilih --</option>
                                <option value="< 500rb" <?= old('penghasilan_ayah', $applicant['penghasilan_ayah'] ?? '') == '< 500rb' ? 'selected' : '' ?>>Kurang dari Rp500.000</option>
                                <option value="500rb-1jt" <?= old('penghasilan_ayah', $applicant['penghasilan_ayah'] ?? '') == '500rb-1jt' ? 'selected' : '' ?>>Rp500.000 - Rp1.000.000</option>
                                <option value="1jt-2jt" <?= old('penghasilan_ayah', $applicant['penghasilan_ayah'] ?? '') == '1jt-2jt' ? 'selected' : '' ?>>Rp1.000.000 - Rp2.000.000</option>
                                <option value="2jt-5jt" <?= old('penghasilan_ayah', $applicant['penghasilan_ayah'] ?? '') == '2jt-5jt' ? 'selected' : '' ?>>Rp2.000.000 - Rp5.000.000</option>
                                <option value="> 5jt" <?= old('penghasilan_ayah', $applicant['penghasilan_ayah'] ?? '') == '> 5jt' ? 'selected' : '' ?>>Lebih dari Rp5.000.000</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor HP Ayah</label>
                        <input type="tel" class="form-control" name="nomor_hp_ayah"
                               value="<?= old('nomor_hp_ayah', $applicant['nomor_hp_ayah'] ?? '') ?>"
                               placeholder="08XXXXXXXXXX">
                    </div>

                    <!-- DATA IBU -->
                    <div class="section-title">
                        <i class="bi bi-people-fill"></i> Data Ibu
                    </div>

                    <div class="row-group">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">
                                Nama Ibu <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control" name="nama_ibu"
                                   value="<?= old('nama_ibu', $applicant['nama_ibu'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="row-group">
                        <div class="form-group">
                            <label class="form-label">NIK Ibu</label>
                            <input type="text" class="form-control" name="nik_ibu"
                                   value="<?= old('nik_ibu', $applicant['nik_ibu'] ?? '') ?>"
                                   placeholder="16 digit" maxlength="16">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <select class="form-select" name="pendidikan_ibu">
                                <option value="">-- Pilih --</option>
                                <option value="SD" <?= old('pendidikan_ibu', $applicant['pendidikan_ibu'] ?? '') == 'SD' ? 'selected' : '' ?>>SD</option>
                                <option value="SMP" <?= old('pendidikan_ibu', $applicant['pendidikan_ibu'] ?? '') == 'SMP' ? 'selected' : '' ?>>SMP</option>
                                <option value="SMA" <?= old('pendidikan_ibu', $applicant['pendidikan_ibu'] ?? '') == 'SMA' ? 'selected' : '' ?>>SMA</option>
                                <option value="Diploma" <?= old('pendidikan_ibu', $applicant['pendidikan_ibu'] ?? '') == 'Diploma' ? 'selected' : '' ?>>Diploma</option>
                                <option value="S1" <?= old('pendidikan_ibu', $applicant['pendidikan_ibu'] ?? '') == 'S1' ? 'selected' : '' ?>>S1</option>
                                <option value="S2" <?= old('pendidikan_ibu', $applicant['pendidikan_ibu'] ?? '') == 'S2' ? 'selected' : '' ?>>S2</option>
                                <option value="S3" <?= old('pendidikan_ibu', $applicant['pendidikan_ibu'] ?? '') == 'S3' ? 'selected' : '' ?>>S3</option>
                                <option value="Lainnya" <?= old('pendidikan_ibu', $applicant['pendidikan_ibu'] ?? '') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="row-group">
                        <div class="form-group">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" name="pekerjaan_ibu"
                                   value="<?= old('pekerjaan_ibu', $applicant['pekerjaan_ibu'] ?? '') ?>"
                                   placeholder="Contoh: Ibu Rumah Tangga">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Penghasilan Bulanan</label>
                            <select class="form-select" name="penghasilan_ibu">
                                <option value="">-- Pilih --</option>
                                <option value="< 500rb" <?= old('penghasilan_ibu', $applicant['penghasilan_ibu'] ?? '') == '< 500rb' ? 'selected' : '' ?>>Kurang dari Rp500.000</option>
                                <option value="500rb-1jt" <?= old('penghasilan_ibu', $applicant['penghasilan_ibu'] ?? '') == '500rb-1jt' ? 'selected' : '' ?>>Rp500.000 - Rp1.000.000</option>
                                <option value="1jt-2jt" <?= old('penghasilan_ibu', $applicant['penghasilan_ibu'] ?? '') == '1jt-2jt' ? 'selected' : '' ?>>Rp1.000.000 - Rp2.000.000</option>
                                <option value="2jt-5jt" <?= old('penghasilan_ibu', $applicant['penghasilan_ibu'] ?? '') == '2jt-5jt' ? 'selected' : '' ?>>Rp2.000.000 - Rp5.000.000</option>
                                <option value="> 5jt" <?= old('penghasilan_ibu', $applicant['penghasilan_ibu'] ?? '') == '> 5jt' ? 'selected' : '' ?>>Lebih dari Rp5.000.000</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor HP Ibu</label>
                        <input type="tel" class="form-control" name="nomor_hp_ibu"
                               value="<?= old('nomor_hp_ibu', $applicant['nomor_hp_ibu'] ?? '') ?>"
                               placeholder="08XXXXXXXXXX">
                    </div>

                    <!-- DATA WALI (Opsional) -->
                    <div class="section-title">
                        <i class="bi bi-shield-fill"></i> Data Wali (Jika Ada)
                    </div>

                    <div class="row-group">
                        <div class="form-group">
                            <label class="form-label">Nama Wali</label>
                            <input type="text" class="form-control" name="nama_wali"
                                   value="<?= old('nama_wali', $applicant['nama_wali'] ?? '') ?>"
                                   placeholder="Opsional">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Hubungan dengan Anak</label>
                            <input type="text" class="form-control" name="hubungan_wali"
                                   value="<?= old('hubungan_wali', $applicant['hubungan_wali'] ?? '') ?>"
                                   placeholder="Contoh: Kakek, Nenek, Paman, Bibi">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nomor HP Wali</label>
                            <input type="tel" class="form-control" name="nomor_hp_wali"
                                   value="<?= old('nomor_hp_wali', $applicant['nomor_hp_wali'] ?? '') ?>"
                                   placeholder="08XXXXXXXXXX">
                        </div>
                    </div>

                    <!-- PRESTASI & KEBUTUHAN KHUSUS -->
                    <div class="section-title">
                        <i class="bi bi-star-fill"></i> Prestasi & Kebutuhan Khusus
                    </div>

                    <div class="form-group">
                        <label class="form-label">Prestasi Akademik</label>
                        <textarea class="form-control" name="prestasi_akademik" rows="3"
                                  placeholder="Daftar prestasi akademik (kompetisi, lomba, dll)"><?= old('prestasi_akademik', $applicant['prestasi_akademik'] ?? '') ?></textarea>
                        <div class="form-text">Contoh: Juara 1 Matematika Tingkat Kab., Juara 2 Sains Nasional, dll</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Prestasi Non-Akademik</label>
                        <textarea class="form-control" name="prestasi_non_akademik" rows="3"
                                  placeholder="Daftar prestasi non-akademik (olahraga, seni, dll)"><?= old('prestasi_non_akademik', $applicant['prestasi_non_akademik'] ?? '') ?></textarea>
                        <div class="form-text">Contoh: Juara Volleyball, Peserta Pramuka, Anggota Marching Band, dll</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kelainan Fisik (Jika Ada)</label>
                        <input type="text" class="form-control" name="kelainan_fisik"
                               value="<?= old('kelainan_fisik', $applicant['kelainan_fisik'] ?? '') ?>"
                               placeholder="Contoh: Buta warna, Tuli, Asma, dll (Opsional)">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kebutuhan Khusus Lainnya</label>
                        <textarea class="form-control" name="kebutuhan_khusus_lainnya" rows="3"
                                  placeholder="Informasi tambahan tentang kebutuhan khusus"><?= old('kebutuhan_khusus_lainnya', $applicant['kebutuhan_khusus_lainnya'] ?? '') ?></textarea>
                    </div>

                    <!-- BUTTONS -->
                    <div class="btn-group-bottom">
                        <a href="/applicant/dashboard" class="btn btn-secondary" role="button">
                            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                        </a>
                        <button type="submit" class="btn btn-draft" name="action" value="draft" id="btnSaveDraft">
                            <i class="bi bi-save"></i> Simpan sebagai Draft
                        </button>
                        <button type="submit" class="btn btn-submit" name="action" value="preview" id="btnPreview">
                            <i class="bi bi-eye"></i> Lihat Preview & Kirim
                        </button>
                    </div>

                    <div class="required-note">
                        <i class="bi bi-info-circle"></i> Kolom yang ditandai dengan tanda <span style="color: var(--danger-color); font-weight: 700;">*</span> harus diisi sebelum melanjutkan
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ============== PROGRESS BAR CALCULATION ==============
        function updateProgressBar() {
            const form = document.getElementById('registrationForm');
            const inputs = form.querySelectorAll('input, select, textarea');
            let filledFields = 0;
            let totalFields = 0;

            inputs.forEach(input => {
                // Exclude buttons and hidden fields
                if (input.type !== 'submit' && input.type !== 'hidden') {
                    totalFields++;
                    const value = input.value.trim();
                    if (value !== '') {
                        filledFields++;
                    }
                }
            });

            const percentage = totalFields > 0 ? Math.round((filledFields / totalFields) * 100) : 0;
            document.getElementById('progressBar').style.width = percentage + '%';
            document.getElementById('progressText').textContent = percentage + '%';
        }

        // ============== FORM VALIDATION ==============
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon isi semua field yang wajib diisi (ditandai dengan *)');
                return false;
            }

            // Check for preview button
            const submitBtn = e.submitter;
            if (submitBtn && submitBtn.value === 'preview') {
                this.action = '<?= base_url('/registration/preview') ?>';
            }
        });

        // ============== REAL-TIME VALIDATION ==============
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                updateProgressBar();
                
                // Remove error styling when user starts typing
                if (this.classList.contains('is-invalid') && this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });

            input.addEventListener('change', function() {
                updateProgressBar();
            });
        });

        // ============== INITIALIZE PROGRESS ==============
        updateProgressBar();

        // ============== KEYBOARD SHORTCUTS ==============
        document.addEventListener('keydown', function(e) {
            // Ctrl+S to save draft
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.getElementById('btnSaveDraft').click();
            }
        });

        // ============== FORM MEMORY (Save to localStorage) ==============
        const formInputs = document.querySelectorAll('input, select, textarea');
        
        // Load saved data on page load
        window.addEventListener('load', function() {
            formInputs.forEach(input => {
                const saved = localStorage.getItem('form_' + input.name);
                if (saved && !input.value) {
                    input.value = saved;
                }
            });
            updateProgressBar();

            // Handle school selection
            handleSchoolSelection();
        });

        // Save data to localStorage as user types
        formInputs.forEach(input => {
            input.addEventListener('change', function() {
                localStorage.setItem('form_' + this.name, this.value);
                if (this.id === 'schoolSelect') {
                    handleSchoolSelection();
                }
            });
        });

        // School selection handler
        function handleSchoolSelection() {
            const schoolSelect = document.getElementById('schoolSelect');
            const manualInput = document.getElementById('manual-school-input');
            const npsn_display = document.getElementById('npsn-display');
            const npsn_value = document.getElementById('npsn-value');
            const school_npsn = document.getElementById('school_npsn');
            const selectedOption = schoolSelect.options[schoolSelect.selectedIndex];

            if (schoolSelect.value === '') {
                // Show manual input if no school selected
                if (selectedOption && selectedOption.text.includes('Input Manual')) {
                    manualInput.style.display = 'block';
                    npsn_display.style.display = 'none';
                } else {
                    manualInput.style.display = 'none';
                    npsn_display.style.display = 'none';
                }
                npsn_value.textContent = '-';
                school_npsn.value = '';
            } else if (selectedOption && selectedOption.dataset.npsn) {
                // Show NPSN from database
                manualInput.style.display = 'none';
                npsn_display.style.display = 'block';
                npsn_value.textContent = selectedOption.dataset.npsn;
                school_npsn.value = selectedOption.dataset.npsn;
            }
        }

        // Clear localStorage when form is successfully submitted
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const submitBtn = e.submitter;
            if (submitBtn && submitBtn.value === 'preview') {
                // Don't clear on preview, user might want to edit again
            } else if (submitBtn && submitBtn.value === 'draft') {
                // Keep saved data for draft
            }
        }, true);

        // ============== ACCESSIBILITY ==============
        // Add focus visible styles
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('using-keyboard');
            }
        });

        document.addEventListener('mousedown', function() {
            document.body.classList.remove('using-keyboard');
        });
    </script>
</body>
</html>
