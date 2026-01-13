<?php if (session()->get('role') === 'admin' && strpos(current_url(), '/admin/') !== false): ?>
<!-- Admin Sidebar -->
<aside class="sidebar">
    <!-- APLIKASI Section -->
    <div class="ps-3">
        <h6 class="text-uppercase text-muted fw-bold">
            <i class="fas fa-folder-open me-2"></i>Aplikasi
        </h6>
        <a href="<?= base_url('admin/applicants') ?>" class="nav-link <?= (strpos(current_url(), 'admin/applicants') !== false) ? 'active' : '' ?>">
            <i class="fas fa-file-alt"></i>
            <span>Daftar Pendaftar</span>
        </a>
        <a href="<?= base_url('admin/payments') ?>" class="nav-link <?= (strpos(current_url(), 'admin/payments') !== false) ? 'active' : '' ?>">
            <i class="fas fa-credit-card"></i>
            <span>Verifikasi Pembayaran</span>
        </a>
        <a href="<?= base_url('admin/applicant-register') ?>" class="nav-link <?= (current_url() == base_url('admin/applicant-register')) ? 'active' : '' ?>">
            <i class="fas fa-user-plus"></i>
            <span>Daftar Pendaftar Manual</span>
        </a>
    </div>

    <!-- MANAJEMEN Section -->
    <div class="ps-3">
        <h6 class="text-uppercase text-muted fw-bold">
            <i class="fas fa-cog me-2"></i>Manajemen
        </h6>
        <a href="<?= base_url('admin/kelola-akun') ?>" class="nav-link <?= (strpos(current_url(), 'admin/kelola-akun') !== false || strpos(current_url(), 'admin/tambah-akun') !== false || strpos(current_url(), 'admin/edit-akun') !== false) ? 'active' : '' ?>">
            <i class="fas fa-users-cog"></i>
            <span>Kelola Akun</span>
        </a>
        <a href="<?= base_url('admin/kelola-kop-surat') ?>" class="nav-link <?= (strpos(current_url(), 'admin/kelola-kop-surat') !== false) ? 'active' : '' ?>">
            <i class="fas fa-file-earmark-text"></i>
            <span>Kelola Kop Surat</span>
        </a>
        <a href="<?= base_url('admin/schools') ?>" class="nav-link <?= (strpos(current_url(), 'admin/schools') !== false) ? 'active' : '' ?>">
            <i class="fas fa-school"></i>
            <span>Kelola Asal Sekolah</span>
        </a>
    </div>
</aside>
<?php endif; ?>
