<!-- Applicant Sidebar -->
<aside class="sidebar">
    <div class="ps-3">
        <h6 class="mb-3">
            <i class="fas fa-user me-2"></i>DASHBOARD
        </h6>
        <a href="<?= base_url('applicant/dashboard') ?>" class="nav-link <?= (current_url() == base_url('applicant/dashboard')) ? 'active' : '' ?>">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <div class="ps-3">
        <h6>
            <i class="fas fa-form me-2"></i>APLIKASI
        </h6>
        <a href="<?= base_url('applicant/register') ?>" class="nav-link <?= (strpos(current_url(), 'applicant/register') !== false) ? 'active' : '' ?>">
            <i class="fas fa-file-contract"></i>
            <span>Daftar</span>
        </a>
        <a href="<?= base_url('applicant/edit') ?>" class="nav-link <?= (strpos(current_url(), 'applicant/edit') !== false) ? 'active' : '' ?>">
            <i class="fas fa-edit"></i>
            <span>Edit Data</span>
        </a>
        <a href="<?= base_url('applicant/upload_documents') ?>" class="nav-link <?= (strpos(current_url(), 'applicant/upload_documents') !== false) ? 'active' : '' ?>">
            <i class="fas fa-upload"></i>
            <span>Upload Dokumen</span>
        </a>
        <a href="<?= base_url('applicant/payment') ?>" class="nav-link <?= (strpos(current_url(), 'applicant/payment') !== false) ? 'active' : '' ?>">
            <i class="fas fa-credit-card"></i>
            <span>Pembayaran</span>
        </a>
    </div>
</aside>
