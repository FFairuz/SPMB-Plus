<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Pendaftaran Siswa Baru - Multi-Step<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Import Design System & Wizard CSS -->
<link rel="stylesheet" href="<?= base_url('css/design-system.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/wizard-form.css') ?>">

<div class="wizard-container">
    
    <!-- ========== WIZARD PROGRESS STEPPER ========== -->
    <div class="wizard-progress">
        <ul class="wizard-steps">
            <li class="wizard-step active" data-step="1">
                <div class="wizard-step-circle">1</div>
                <div class="wizard-step-label">Data Diri</div>
            </li>
            <li class="wizard-step" data-step="2">
                <div class="wizard-step-circle">2</div>
                <div class="wizard-step-label">Data Orang Tua</div>
            </li>
            <li class="wizard-step" data-step="3">
                <div class="wizard-step-circle">3</div>
                <div class="wizard-step-label">Data Sekolah</div>
            </li>
            <li class="wizard-step" data-step="4">
                <div class="wizard-step-circle">4</div>
                <div class="wizard-step-label">Pilihan Jurusan</div>
            </li>
            <li class="wizard-step" data-step="5">
                <div class="wizard-step-circle">5</div>
                <div class="wizard-step-label">Upload Dokumen</div>
            </li>
            <li class="wizard-step" data-step="6">
                <div class="wizard-step-circle"><i class="bi bi-check-lg"></i></div>
                <div class="wizard-step-label">Review & Submit</div>
            </li>
        </ul>
        <div class="wizard-progress-bar" id="wizardProgressBar" style="width: 16.67%;"></div>
    </div>

    <!-- ========== WIZARD CONTENT ========== -->
    <div class="wizard-content">
        <form id="wizardForm" method="POST" action="<?= base_url('/registration/save') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <!-- STEP 1: Data Diri -->
            <div class="wizard-step-content active" data-step="1">
                <div class="wizard-content-header">
                    <h2><i class="bi bi-person-fill"></i> Data Diri Peserta</h2>
                    <p>Lengkapi informasi pribadi Anda dengan benar</p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="required">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control-modern" required>
                        <i class="bi bi-person form-icon-left"></i>
                        <div class="form-feedback valid" style="display: none;">
                            <i class="bi bi-check-circle"></i> Nama valid
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="required">NIK</label>
                        <input type="text" name="nik" class="form-control-modern" maxlength="16" required>
                        <i class="bi bi-credit-card form-icon-left"></i>
                        <div class="form-feedback valid" style="display: none;">
                            <i class="bi bi-check-circle"></i> NIK valid (16 digit)
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="required">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control-modern" required>
                        <i class="bi bi-geo-alt form-icon-left"></i>
                    </div>
                    <div class="form-group">
                        <label class="required">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control-modern" required>
                        <i class="bi bi-calendar form-icon-left"></i>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="required">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control-modern" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <i class="bi bi-gender-ambiguous form-icon-left"></i>
                    </div>
                    <div class="form-group">
                        <label class="required">Agama</label>
                        <select name="agama" class="form-control-modern" required>
                            <option value="">-- Pilih --</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                        <i class="bi bi-book form-icon-left"></i>
                    </div>
                </div>

                <div class="form-row single">
                    <div class="form-group">
                        <label class="required">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="form-control-modern" required style="padding-left: 1rem;"></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="required">No. Telepon</label>
                        <input type="tel" name="no_telepon" class="form-control-modern" required>
                        <i class="bi bi-telephone form-icon-left"></i>
                    </div>
                    <div class="form-group">
                        <label class="required">Email</label>
                        <input type="email" name="email" class="form-control-modern" required>
                        <i class="bi bi-envelope form-icon-left"></i>
                    </div>
                </div>
            </div>

            <!-- STEP 2: Data Orang Tua -->
            <div class="wizard-step-content" data-step="2">
                <div class="wizard-content-header">
                    <h2><i class="bi bi-people-fill"></i> Data Orang Tua / Wali</h2>
                    <p>Informasi orang tua atau wali peserta</p>
                </div>

                <h5 style="margin-bottom: var(--space-4); color: var(--primary-600);">
                    <i class="bi bi-person-square"></i> Data Ayah
                </h5>

                <div class="form-row">
                    <div class="form-group">
                        <label class="required">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control-modern" required>
                        <i class="bi bi-person form-icon-left"></i>
                    </div>
                    <div class="form-group">
                        <label class="required">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" class="form-control-modern" required>
                        <i class="bi bi-briefcase form-icon-left"></i>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="required">No. Telepon Ayah</label>
                        <input type="tel" name="no_telepon_ayah" class="form-control-modern" required>
                        <i class="bi bi-telephone form-icon-left"></i>
                    </div>
                    <div class="form-group">
                        <label>Penghasilan Ayah</label>
                        <select name="penghasilan_ayah" class="form-control-modern">
                            <option value="">-- Pilih --</option>
                            <option value="< 1 Juta">< 1 Juta</option>
                            <option value="1 - 3 Juta">1 - 3 Juta</option>
                            <option value="3 - 5 Juta">3 - 5 Juta</option>
                            <option value="> 5 Juta">> 5 Juta</option>
                        </select>
                        <i class="bi bi-cash form-icon-left"></i>
                    </div>
                </div>

                <h5 style="margin: var(--space-8) 0 var(--space-4); color: var(--accent-600);">
                    <i class="bi bi-person-square"></i> Data Ibu
                </h5>

                <div class="form-row">
                    <div class="form-group">
                        <label class="required">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control-modern" required>
                        <i class="bi bi-person form-icon-left"></i>
                    </div>
                    <div class="form-group">
                        <label class="required">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" class="form-control-modern" required>
                        <i class="bi bi-briefcase form-icon-left"></i>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="required">No. Telepon Ibu</label>
                        <input type="tel" name="no_telepon_ibu" class="form-control-modern" required>
                        <i class="bi bi-telephone form-icon-left"></i>
                    </div>
                    <div class="form-group">
                        <label>Penghasilan Ibu</label>
                        <select name="penghasilan_ibu" class="form-control-modern">
                            <option value="">-- Pilih --</option>
                            <option value="< 1 Juta">< 1 Juta</option>
                            <option value="1 - 3 Juta">1 - 3 Juta</option>
                            <option value="3 - 5 Juta">3 - 5 Juta</option>
                            <option value="> 5 Juta">> 5 Juta</option>
                        </select>
                        <i class="bi bi-cash form-icon-left"></i>
                    </div>
                </div>
            </div>

            <!-- STEP 3: Data Sekolah -->
            <div class="wizard-step-content" data-step="3">
                <div class="wizard-content-header">
                    <h2><i class="bi bi-building"></i> Data Sekolah Asal</h2>
                    <p>Informasi sekolah atau pendidikan terakhir</p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="required">Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" class="form-control-modern" required>
                        <i class="bi bi-building form-icon-left"></i>
                    </div>
                    <div class="form-group">
                        <label class="required">NPSN</label>
                        <input type="text" name="npsn" class="form-control-modern" required>
                        <i class="bi bi-hash form-icon-left"></i>
                    </div>
                </div>

                <div class="form-row single">
                    <div class="form-group">
                        <label class="required">Alamat Sekolah</label>
                        <textarea name="alamat_sekolah" rows="3" class="form-control-modern" required style="padding-left: 1rem;"></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="required">Tahun Lulus</label>
                        <input type="number" name="tahun_lulus" class="form-control-modern" min="2000" max="2030" required>
                        <i class="bi bi-calendar-check form-icon-left"></i>
                    </div>
                    <div class="form-group">
                        <label class="required">Nilai Rata-Rata</label>
                        <input type="number" step="0.01" name="nilai_rata_rata" class="form-control-modern" min="0" max="100" required>
                        <i class="bi bi-star form-icon-left"></i>
                    </div>
                </div>
            </div>

            <!-- STEP 4: Pilihan Jurusan -->
            <div class="wizard-step-content" data-step="4">
                <div class="wizard-content-header">
                    <h2><i class="bi bi-mortarboard-fill"></i> Pilihan Jurusan</h2>
                    <p>Pilih jurusan yang Anda minati (maksimal 2 pilihan)</p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="required">Pilihan Jurusan 1</label>
                        <select name="jurusan_1" class="form-control-modern" required>
                            <option value="">-- Pilih Jurusan --</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Teknik Elektro">Teknik Elektro</option>
                            <option value="Manajemen">Manajemen</option>
                            <option value="Akuntansi">Akuntansi</option>
                            <option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
                        </select>
                        <i class="bi bi-bookmark form-icon-left"></i>
                    </div>
                    <div class="form-group">
                        <label>Pilihan Jurusan 2 (Opsional)</label>
                        <select name="jurusan_2" class="form-control-modern">
                            <option value="">-- Pilih Jurusan --</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Teknik Elektro">Teknik Elektro</option>
                            <option value="Manajemen">Manajemen</option>
                            <option value="Akuntansi">Akuntansi</option>
                            <option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
                        </select>
                        <i class="bi bi-bookmark-star form-icon-left"></i>
                    </div>
                </div>

                <div class="alert" style="background: var(--info-50); border-left: 4px solid var(--info-500); padding: var(--space-4); border-radius: var(--radius-md); margin-top: var(--space-6);">
                    <div style="display: flex; align-items: center; gap: var(--space-3);">
                        <i class="bi bi-info-circle" style="font-size: var(--text-2xl); color: var(--info-600);"></i>
                        <div>
                            <strong style="color: var(--info-700);">Tips Memilih Jurusan:</strong>
                            <p style="margin: 0; font-size: var(--text-sm); color: var(--info-600);">
                                Pilih jurusan sesuai minat dan bakat Anda. Pilihan kedua akan menjadi backup jika pilihan pertama penuh.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 5: Upload Dokumen -->
            <div class="wizard-step-content" data-step="5">
                <div class="wizard-content-header">
                    <h2><i class="bi bi-cloud-upload"></i> Upload Dokumen</h2>
                    <p>Upload dokumen pendukung (JPG, PNG, PDF - Max 2MB)</p>
                </div>

                <div class="form-group">
                    <label class="required">Foto Peserta (3x4)</label>
                    <div class="upload-area" id="uploadFoto">
                        <div class="upload-icon">
                            <i class="bi bi-image"></i>
                        </div>
                        <div class="upload-text">Klik atau drag & drop foto di sini</div>
                        <div class="upload-hint">JPG, PNG • Max 2MB</div>
                        <input type="file" name="foto" accept="image/*" hidden id="inputFoto" required>
                    </div>
                    <div class="upload-preview" id="previewFoto" style="display: none;">
                        <img src="" alt="Preview" id="previewFotoImg">
                        <div class="upload-preview-info">
                            <div class="upload-preview-name" id="previewFotoName">filename.jpg</div>
                            <div class="upload-preview-size" id="previewFotoSize">245 KB</div>
                        </div>
                        <i class="bi bi-x-circle upload-preview-remove" id="removeFoto"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="required">KTP / Kartu Keluarga</label>
                    <div class="upload-area" id="uploadKTP">
                        <div class="upload-icon">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <div class="upload-text">Klik atau drag & drop KTP/KK di sini</div>
                        <div class="upload-hint">PDF, JPG, PNG • Max 2MB</div>
                        <input type="file" name="ktp" accept="image/*,application/pdf" hidden id="inputKTP" required>
                    </div>
                    <div class="upload-preview" id="previewKTP" style="display: none;"></div>
                </div>

                <div class="form-group">
                    <label class="required">Ijazah / Surat Keterangan Lulus</label>
                    <div class="upload-area" id="uploadIjazah">
                        <div class="upload-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="upload-text">Klik atau drag & drop ijazah di sini</div>
                        <div class="upload-hint">PDF, JPG, PNG • Max 2MB</div>
                        <input type="file" name="ijazah" accept="image/*,application/pdf" hidden id="inputIjazah" required>
                    </div>
                    <div class="upload-preview" id="previewIjazah" style="display: none;"></div>
                </div>
            </div>

            <!-- STEP 6: Review & Submit -->
            <div class="wizard-step-content" data-step="6">
                <div class="wizard-content-header">
                    <h2><i class="bi bi-check-circle"></i> Review Data Anda</h2>
                    <p>Pastikan semua informasi sudah benar sebelum submit</p>
                </div>

                <div class="summary-section">
                    <!-- Summary akan di-generate dengan JavaScript -->
                    <div id="summaryContent"></div>
                </div>

                <div class="alert" style="background: var(--success-50); border-left: 4px solid var(--success-500); padding: var(--space-4); border-radius: var(--radius-md); margin-top: var(--space-6);">
                    <div style="display: flex; align-items: center; gap: var(--space-3);">
                        <i class="bi bi-shield-check" style="font-size: var(--text-2xl); color: var(--success-600);"></i>
                        <div>
                            <strong style="color: var(--success-700);">Data Aman & Terenkripsi</strong>
                            <p style="margin: 0; font-size: var(--text-sm); color: var(--success-600);">
                                Semua data Anda disimpan dengan aman dan hanya digunakan untuk proses pendaftaran.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== WIZARD NAVIGATION ========== -->
            <div class="wizard-navigation">
                <div class="wizard-nav-left">
                    <button type="button" class="wizard-btn wizard-btn-back" id="btnBack" style="display: none;">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </button>
                </div>
                <div class="wizard-nav-right">
                    <button type="button" class="wizard-btn wizard-btn-next" id="btnNext">
                        Lanjutkan <i class="bi bi-arrow-right"></i>
                    </button>
                    <button type="submit" class="wizard-btn wizard-btn-submit" id="btnSubmit" style="display: none;">
                        <i class="bi bi-send"></i> Submit Pendaftaran
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Auto-save Indicator -->
    <div class="autosave-indicator" id="autosaveIndicator">
        <div class="autosave-spinner"></div>
        <span>Menyimpan...</span>
    </div>

</div>

<script>
// Wizard Multi-Step Form Script
(function() {
    let currentStep = 1;
    const totalSteps = 6;
    const form = document.getElementById('wizardForm');
    const btnBack = document.getElementById('btnBack');
    const btnNext = document.getElementById('btnNext');
    const btnSubmit = document.getElementById('btnSubmit');
    const progressBar = document.getElementById('wizardProgressBar');
    
    // Initialize
    updateStepDisplay();
    
    // Next Button
    btnNext.addEventListener('click', function() {
        if (validateCurrentStep()) {
            if (currentStep < totalSteps) {
                currentStep++;
                updateStepDisplay();
                saveToLocalStorage(); // Auto-save
            }
        }
    });
    
    // Back Button
    btnBack.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
        }
    });
    
    // Update Step Display
    function updateStepDisplay() {
        // Update progress bar
        const progress = (currentStep / totalSteps) * 100;
        progressBar.style.width = progress + '%';
        
        // Update step indicators
        document.querySelectorAll('.wizard-step').forEach((step, index) => {
            const stepNum = index + 1;
            step.classList.remove('active', 'completed');
            
            if (stepNum < currentStep) {
                step.classList.add('completed');
                step.querySelector('.wizard-step-circle').innerHTML = '<i class="bi bi-check-lg"></i>';
            } else if (stepNum === currentStep) {
                step.classList.add('active');
                step.querySelector('.wizard-step-circle').textContent = stepNum;
            } else {
                step.querySelector('.wizard-step-circle').textContent = stepNum;
            }
        });
        
        // Update content visibility
        document.querySelectorAll('.wizard-step-content').forEach((content, index) => {
            content.classList.remove('active');
            if (index + 1 === currentStep) {
                content.classList.add('active');
            }
        });
        
        // Update navigation buttons
        btnBack.style.display = currentStep === 1 ? 'none' : 'inline-flex';
        btnNext.style.display = currentStep === totalSteps ? 'none' : 'inline-flex';
        btnSubmit.style.display = currentStep === totalSteps ? 'inline-flex' : 'none';
        
        // Generate summary on last step
        if (currentStep === totalSteps) {
            generateSummary();
        }
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    // Validate Current Step
    function validateCurrentStep() {
        const currentContent = document.querySelector(`.wizard-step-content[data-step="${currentStep}"]`);
        const requiredInputs = currentContent.querySelectorAll('[required]');
        let isValid = true;
        
        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
            } else {
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            showToast('Harap lengkapi semua field yang wajib diisi', 'error');
        }
        
        return isValid;
    }
    
    // Generate Summary
    function generateSummary() {
        const formData = new FormData(form);
        let html = '';
        
        // Data Diri
        html += `
        <div class="summary-card">
            <div class="summary-card-header">
                <div class="summary-card-title">
                    <i class="bi bi-person-fill"></i> Data Diri
                </div>
                <button type="button" class="summary-edit-btn" onclick="goToStep(1)">
                    <i class="bi bi-pencil"></i> Edit
                </button>
            </div>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-label">Nama Lengkap</div>
                    <div class="summary-value">${formData.get('nama_lengkap') || '-'}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">NIK</div>
                    <div class="summary-value">${formData.get('nik') || '-'}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Tempat, Tanggal Lahir</div>
                    <div class="summary-value">${formData.get('tempat_lahir') || '-'}, ${formData.get('tanggal_lahir') || '-'}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Jenis Kelamin</div>
                    <div class="summary-value">${formData.get('jenis_kelamin') || '-'}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Email</div>
                    <div class="summary-value">${formData.get('email') || '-'}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">No. Telepon</div>
                    <div class="summary-value">${formData.get('no_telepon') || '-'}</div>
                </div>
            </div>
        </div>
        `;
        
        // Data Orang Tua
        html += `
        <div class="summary-card">
            <div class="summary-card-header">
                <div class="summary-card-title">
                    <i class="bi bi-people-fill"></i> Data Orang Tua
                </div>
                <button type="button" class="summary-edit-btn" onclick="goToStep(2)">
                    <i class="bi bi-pencil"></i> Edit
                </button>
            </div>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-label">Nama Ayah</div>
                    <div class="summary-value">${formData.get('nama_ayah') || '-'}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Nama Ibu</div>
                    <div class="summary-value">${formData.get('nama_ibu') || '-'}</div>
                </div>
            </div>
        </div>
        `;
        
        // Pilihan Jurusan
        html += `
        <div class="summary-card">
            <div class="summary-card-header">
                <div class="summary-card-title">
                    <i class="bi bi-mortarboard-fill"></i> Pilihan Jurusan
                </div>
                <button type="button" class="summary-edit-btn" onclick="goToStep(4)">
                    <i class="bi bi-pencil"></i> Edit
                </button>
            </div>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-label">Pilihan 1</div>
                    <div class="summary-value">${formData.get('jurusan_1') || '-'}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Pilihan 2</div>
                    <div class="summary-value">${formData.get('jurusan_2') || '(Tidak ada)'}</div>
                </div>
            </div>
        </div>
        `;
        
        document.getElementById('summaryContent').innerHTML = html;
    }
    
    // Go to specific step
    window.goToStep = function(step) {
        currentStep = step;
        updateStepDisplay();
    };
    
    // Auto-save to localStorage
    function saveToLocalStorage() {
        const formData = new FormData(form);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        localStorage.setItem('wizardFormData', JSON.stringify(data));
        showAutosaveIndicator('saved');
    }
    
    // Show autosave indicator
    function showAutosaveIndicator(status) {
        const indicator = document.getElementById('autosaveIndicator');
        indicator.classList.add('show', status);
        setTimeout(() => {
            indicator.classList.remove('show', status);
        }, 2000);
    }
    
    // Load from localStorage
    function loadFromLocalStorage() {
        const saved = localStorage.getItem('wizardFormData');
        if (saved) {
            const data = JSON.parse(saved);
            Object.keys(data).forEach(key => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) input.value = data[key];
            });
        }
    }
    
    // Load saved data on init
    loadFromLocalStorage();
    
    // Upload handling
    setupUploadArea('uploadFoto', 'inputFoto', 'previewFoto');
    setupUploadArea('uploadKTP', 'inputKTP', 'previewKTP');
    setupUploadArea('uploadIjazah', 'inputIjazah', 'previewIjazah');
    
    function setupUploadArea(areaId, inputId, previewId) {
        const area = document.getElementById(areaId);
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        
        area.addEventListener('click', () => input.click());
        
        area.addEventListener('dragover', (e) => {
            e.preventDefault();
            area.classList.add('dragover');
        });
        
        area.addEventListener('dragleave', () => {
            area.classList.remove('dragover');
        });
        
        area.addEventListener('drop', (e) => {
            e.preventDefault();
            area.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                handleFileSelect(input, preview, area);
            }
        });
        
        input.addEventListener('change', () => {
            handleFileSelect(input, preview, area);
        });
    }
    
    function handleFileSelect(input, preview, area) {
        const file = input.files[0];
        if (file) {
            area.style.display = 'none';
            preview.style.display = 'flex';
            
            // Show preview for images
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = preview.querySelector('img') || document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '80px';
                    img.style.height = '80px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = 'var(--radius)';
                    if (!preview.querySelector('img')) preview.insertBefore(img, preview.firstChild);
                };
                reader.readAsDataURL(file);
            }
            
            preview.innerHTML += `
                <div class="upload-preview-info">
                    <div class="upload-preview-name">${file.name}</div>
                    <div class="upload-preview-size">${(file.size / 1024).toFixed(0)} KB</div>
                </div>
                <i class="bi bi-x-circle upload-preview-remove"></i>
            `;
            
            preview.querySelector('.upload-preview-remove').addEventListener('click', () => {
                input.value = '';
                preview.style.display = 'none';
                preview.innerHTML = '';
                area.style.display = 'block';
            });
        }
    }
    
    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (validateCurrentStep()) {
            showLoading();
            
            // Simulate submission (replace with actual AJAX call)
            setTimeout(() => {
                hideLoading();
                localStorage.removeItem('wizardFormData'); // Clear saved data
                showSuccess('Pendaftaran berhasil disimpan!', 'Data Anda akan diverifikasi oleh admin.');
                setTimeout(() => {
                    window.location.href = '/applicant/dashboard';
                }, 2000);
            }, 2000);
        }
    });
    
})();
</script>

<?= $this->endSection(); ?>
