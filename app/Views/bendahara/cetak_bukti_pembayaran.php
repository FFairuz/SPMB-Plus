<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Cetak Bukti Pembayaran<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div style="max-width: 100%; margin: 0 auto;">
    <div style="text-align: right; margin-bottom: 1rem;">
        <button class="btn btn-primary btn-sm" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak
        </button>
        <a href="/bendahara/verifikasi-pembayaran" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Cetak Area - Kwitansi 148mm × 105mm (Landscape) -->
    <div id="receipt-area" style="
        width: 148mm;
        height: 105mm;
        margin: 0 auto;
        padding: 0.5cm;
        background: white;
        border: 1px solid #ddd;
        font-family: Arial, sans-serif;
        font-size: 10pt;
        line-height: 1.1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    ">
        <!-- Kop Surat -->
        <div style="
            text-align: center;
            margin-bottom: 0.2cm;
            padding-bottom: 0.15cm;
            border-bottom: 1.5px solid #333;
        ">
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.2cm; margin-bottom: 0.1cm;">
                <?php if (!empty($kopSurat['logo_path'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $kopSurat['logo_path']); ?>" 
                         alt="Logo" 
                         style="height: 0.6cm; width: auto;">
                <?php else: ?>
                    <div style="width: 0.6cm; height: 0.6cm; background: #f0f0f0; border-radius: 50%;"></div>
                <?php endif; ?>
                <div style="text-align: left; flex: 1;">
                    <strong style="font-size: 9pt; display: block;"><?= $kopSurat['school_name']; ?></strong>
                    <small style="font-size: 7pt; display: block;"><?= $kopSurat['address']; ?></small>
                </div>
            </div>
        </div>

        <!-- Judul -->
        <div style="text-align: center; margin-bottom: 0.15cm;">
            <strong style="font-size: 10pt; display: block;">BUKTI PEMBAYARAN</strong>
            <strong style="font-size: 9pt; display: block;">PENDAFTARAN SISWA BARU</strong>
        </div>

        <!-- Nomor dan Tanggal - Dua kolom -->
        <div style="margin-bottom: 0.1cm; font-size: 9pt; display: grid; grid-template-columns: 1fr 1fr; gap: 0.5cm;">
            <div>
                <div style="display: grid; grid-template-columns: 35% 65%;">
                    <span>No. Bukti</span>
                    <span>: <?= htmlspecialchars($payment['receipt_number'] ?? $payment['id']); ?></span>
                </div>
                <div style="display: grid; grid-template-columns: 35% 65%;">
                    <span>Tanggal</span>
                    <span>: <?= date('d-m-Y', strtotime($payment['verified_at'] ?? $payment['created_at'])); ?></span>
                </div>
            </div>
            <div>
                <div style="display: grid; grid-template-columns: 40% 60%;">
                    <span><strong>Nama</strong></span>
                    <span>: <?= htmlspecialchars($payment['nama_lengkap'] ?? '-'); ?></span>
                </div>
                <div style="display: grid; grid-template-columns: 40% 60%;">
                    <span><strong>No. Daftar</strong></span>
                    <span>: <?= htmlspecialchars($payment['nomor_pendaftaran'] ?? '-'); ?></span>
                </div>
            </div>
        </div>

        <!-- Garis -->
        <div style="border-top: 1px solid #333; margin-bottom: 0.1cm;"></div>

        <!-- Jumlah Pembayaran - Centered -->
        <div style="margin-bottom: 0.1cm; text-align: center;">
            <div style="font-size: 10pt; font-weight: bold;">
                Jumlah Pembayaran: Rp <?= number_format($payment['transfer_amount'] ?? 0, 0, ',', '.'); ?>
            </div>
            <small style="font-size: 8pt; color: #666;">Metode: <?= htmlspecialchars($payment['bank_name'] ?? 'Transfer'); ?></small>
        </div>

        <!-- Garis -->
        <div style="border-top: 1px solid #333; margin-bottom: 0.1cm;"></div>

        <!-- Status & Tanda Tangan -->
        <div style="display: grid; grid-template-columns: 1.5fr 1fr 1fr; gap: 0.3cm; align-items: flex-end;">
            <!-- Status -->
            <div style="
                background: #d4edda;
                border: 1px solid #28a745;
                padding: 0.1cm 0.2cm;
                text-align: center;
                font-size: 8pt;
                font-weight: bold;
                color: #155724;
                border-radius: 3px;
            ">
                ✓ TERVERIFIKASI
            </div>
            
            <!-- Bendahara -->
            <div style="text-align: center; font-size: 7pt;">
                <div style="height: 0.35cm; border-bottom: 1px solid #333; margin-bottom: 0.05cm;"></div>
                <strong>Bendahara</strong>
            </div>
            
            <!-- Penerima -->
            <div style="text-align: center; font-size: 7pt;">
                <div style="height: 0.35cm; border-bottom: 1px solid #333; margin-bottom: 0.05cm;"></div>
                <strong>Penerima</strong>
            </div>
        </div>

        <!-- Nomor Referensi -->
        <div style="text-align: center; font-size: 7pt; color: #999; margin-top: 0.1cm;">
            ID: <?= htmlspecialchars($payment['id']); ?> | <?= date('d-m-Y H:i', strtotime($payment['verified_at'] ?? $payment['created_at'])); ?>
        </div>
    </div>
</div>

<!-- Print Stylesheet -->
<style media="print">
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        width: 148mm;
        height: 105mm;
        margin: 0;
        padding: 0;
        background: white;
        font-family: Arial, sans-serif;
    }
    
    .navbar, .sidebar, header, footer, .btn, a[href]:not(#receipt-area a) {
        display: none !important;
    }
    
    #receipt-area {
        width: 148mm !important;
        height: 105mm !important;
        margin: 0 !important;
        padding: 0.5cm !important;
        box-shadow: none !important;
        border: none !important;
    }
    
    @page {
        size: 148mm 105mm;
        margin: 0;
        padding: 0;
    }
</style>

<?= $this->endSection(); ?>
