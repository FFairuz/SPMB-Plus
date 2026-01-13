<!-- Bendahara Sidebar -->
<?php if (session()->get('role') === 'bendahara'): ?>
<aside class="sidebar">
<?php endif; ?>

    <div class="ps-3">
        <h6>
            <i class="fas fa-money-bill me-2"></i>PEMBAYARAN
        </h6>
        <a href="<?= base_url('bendahara/verifikasi-pembayaran') ?>" class="nav-link <?= (strpos(current_url(), 'bendahara/verifikasi-pembayaran') !== false) ? 'active' : '' ?>">
            <i class="fas fa-check-circle"></i>
            <span>Verifikasi Pembayaran</span>
        </a>
        <a href="<?= base_url('bendahara/pembayaran-offline') ?>" class="nav-link <?= (strpos(current_url(), 'bendahara/pembayaran-offline') !== false) ? 'active' : '' ?>">
            <i class="fas fa-cash-register"></i>
            <span>Pembayaran Offline</span>
        </a>
        <a href="<?= base_url('bendahara/laporan-keuangan') ?>" class="nav-link <?= (strpos(current_url(), 'bendahara/laporan-keuangan') !== false) ? 'active' : '' ?>">
            <i class="fas fa-chart-pie"></i>
            <span>Laporan Keuangan</span>
        </a>
        <a href="<?= base_url('bendahara/cetak-bukti') ?>" class="nav-link <?= (strpos(current_url(), 'bendahara/cetak-bukti') !== false) ? 'active' : '' ?>">
            <i class="fas fa-print"></i>
            <span>Cetak Bukti</span>
        </a>
    </div>

<?php if (session()->get('role') === 'bendahara'): ?>
</aside>
<?php endif; ?>
