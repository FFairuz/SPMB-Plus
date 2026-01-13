<!-- Sales Sidebar -->
<?php if (session()->get('role') === 'sales'): ?>
<aside class="sidebar">
<?php endif; ?>

    <div class="ps-3">
        <h6>
            <i class="fas fa-tachometer-alt me-2"></i>MENU UTAMA
        </h6>
        <a href="<?= base_url('sales/dashboard') ?>" class="nav-link <?= (strpos(current_url(), 'sales/dashboard') !== false) ? 'active' : '' ?>">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <div class="ps-3">
        <h6>
            <i class="fas fa-info-circle me-2"></i>INFORMASI
        </h6>
        <a href="<?= base_url('sales/video') ?>" class="nav-link <?= (strpos(current_url(), 'sales/video') !== false) ? 'active' : '' ?>">
            <i class="fas fa-video"></i>
            <span>Video Sekolah</span>
        </a>
        <a href="<?= base_url('sales/brochure') ?>" class="nav-link <?= (strpos(current_url(), 'sales/brochure') !== false) ? 'active' : '' ?>">
            <i class="fas fa-book"></i>
            <span>Brosur</span>
        </a>
        <a href="<?= base_url('sales/informasi-biaya') ?>" class="nav-link <?= (strpos(current_url(), 'sales/informasi-biaya') !== false) ? 'active' : '' ?>">
            <i class="fas fa-dollar-sign"></i>
            <span>Informasi Biaya</span>
        </a>
    </div>

    <div class="ps-3">
        <h6>
            <i class="fas fa-book-open me-2"></i>BUKU TAMU
        </h6>
        <a href="<?= base_url('sales/buku-tamu') ?>" class="nav-link <?= (strpos(current_url(), 'sales/buku-tamu') !== false) ? 'active' : '' ?>">
            <i class="fas fa-pen-fancy"></i>
            <span>Buku Tamu</span>
        </a>
        <a href="<?= base_url('sales/tracking-form') ?>" class="nav-link <?= (strpos(current_url(), 'sales/tracking-form') !== false) ? 'active' : '' ?>">
            <i class="fas fa-list"></i>
            <span>Tracking Form</span>
        </a>
        <a href="<?= base_url('sales/buku-tamu-map') ?>" class="nav-link <?= (strpos(current_url(), 'sales/buku-tamu-map') !== false) ? 'active' : '' ?>">
            <i class="fas fa-map"></i>
            <span>Peta Sekolah</span>
        </a>
    </div>

<?php if (session()->get('role') === 'sales'): ?>
</aside>
<?php endif; ?>
