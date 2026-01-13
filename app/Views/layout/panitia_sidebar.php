<!-- Panitia Sidebar -->
<?php if (session()->get('role') === 'panitia'): ?>
<aside class="sidebar">
<?php endif; ?>

    <div class="ps-3">
        <h6>
            <i class="fas fa-file-alt me-2"></i>PENDAFTARAN
        </h6>
        <a href="<?= base_url('panitia/daftar-siswa') ?>" class="nav-link <?= (strpos(current_url(), 'panitia/daftar-siswa') !== false) ? 'active' : '' ?>">
            <i class="fas fa-list"></i>
            <span>Daftar Siswa</span>
        </a>
        <a href="<?= base_url('panitia/tambah-siswa') ?>" class="nav-link <?= (strpos(current_url(), 'panitia/tambah-siswa') !== false) ? 'active' : '' ?>">
            <i class="fas fa-user-plus"></i>
            <span>Tambah Siswa</span>
        </a>
        <a href="<?= base_url('panitia/verifikasi-pendaftar') ?>" class="nav-link <?= (strpos(current_url(), 'panitia/verifikasi-pendaftar') !== false) ? 'active' : '' ?>">
            <i class="fas fa-check-circle"></i>
            <span>Verifikasi Pendaftar</span>
        </a>
        <a href="<?= base_url('panitia/grafik-siswa') ?>" class="nav-link <?= (strpos(current_url(), 'panitia/grafik-siswa') !== false) ? 'active' : '' ?>">
            <i class="fas fa-chart-bar"></i>
            <span>Grafik Siswa</span>
        </a>
    </div>

<?php if (session()->get('role') === 'panitia'): ?>
</aside>
<?php endif; ?>
