<?php
/**
 * Helper function to convert number to Indonesian words
 */
if (!function_exists('terbilang')) {
    function terbilang($angka) {
        $angka = abs($angka);
        $baca = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
        
        if ($angka < 12) {
            return $baca[$angka];
        } elseif ($angka < 20) {
            return terbilang($angka - 10) . ' belas';
        } elseif ($angka < 100) {
            return terbilang($angka / 10) . ' puluh ' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            return 'seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return terbilang($angka / 100) . ' ratus ' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            return 'seribu ' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return terbilang($angka / 1000) . ' ribu ' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return terbilang($angka / 1000000) . ' juta ' . terbilang($angka % 1000000);
        }
        
        return 'angka terlalu besar';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran SPMB - <?= esc($payment['full_name']) ?></title>
    <style>
        @page {
            size: 210mm 148mm; /* A5 Landscape */
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            line-height: 1.3;
            padding: 0;
            background: #fff;
            width: 210mm;
            height: 148mm;
            margin: 0;
        }

        .receipt-container {
            width: 210mm;
            height: 148mm;
            margin: 0;
            background: white;
            border: none;
            padding: 6mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding: 3mm 2mm;
            margin: 0;
            position: relative;
        }

        .header-logo {
            position: absolute;
            left: 5mm;
            top: 50%;
            transform: translateY(-50%);
            height: 15mm;
            width: auto;
            max-width: 20mm;
            object-fit: contain;
        }

        .receipt-header h1 {
            font-size: 13pt;
            font-weight: bold;
            margin: 0.5mm 0;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
        }

        .receipt-header h2 {
            font-size: 11pt;
            font-weight: bold;
            margin: 0.8mm 0 0.5mm 0;
            color: #c00;
        }

        .receipt-header h3 {
            font-size: 9pt;
            font-weight: normal;
            margin: 0.3mm 0;
        }

        /* Body */
        .receipt-body {
            padding: 3mm 8mm;
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        /* Two Column Layout */
        .info-row {
            display: flex;
            gap: 4mm;
            margin-bottom: 2mm;
        }

        /* Info Sections */
        .info-section {
            flex: 1;
            border-bottom: 1px solid #ddd;
            padding-bottom: 2mm;
        }

        .info-section.highlighted {
            background: #f5f5f5;
            padding: 2mm;
            border: 1px solid #ddd;
            border-radius: 1mm;
        }

        .section-title {
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 1mm;
            color: #333;
        }

        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 0.8mm 0;
            vertical-align: top;
            font-size: 9pt;
            line-height: 1.4;
        }

        .info-table .label {
            width: 40%;
            font-weight: normal;
            padding-right: 1mm;
        }

        .info-table .separator {
            width: 3%;
            text-align: center;
        }

        .info-table .value {
            width: 57%;
            font-weight: 600;
        }

        /* Payment Amount Box */
        /* Payment Amount Box */
        .payment-box {
            border: 1px solid #333;
            padding: 2mm 3mm;
            margin: 2mm 0;
            text-align: center;
        }

        .payment-label {
            font-size: 8.5pt;
            margin-bottom: 1mm;
            font-weight: bold;
        }

        .payment-amount {
            font-size: 16pt;
            font-weight: bold;
            margin: 1mm 0;
            color: #000;
        }

        .payment-words {
            font-size: 8pt;
            font-style: italic;
            margin-top: 1mm;
            padding: 1mm 2mm;
            border-top: 1px dashed #999;
        }

        /* Note */
        .note {
            font-size: 8pt;
            margin: 2mm 0;
            padding: 1mm 2mm;
            border-left: 2px solid #999;
            line-height: 1.3;
        }

        .note strong {
            color: #c00;
        }

        /* Footer/Signature */
        .signature-section {
            margin-top: 2mm;
            text-align: right;
            padding-right: 8mm;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 40mm;
        }

        .signature-place {
            margin-bottom: 1mm;
            font-size: 8.5pt;
        }

        .signature-space {
            height: 8mm;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            font-size: 9pt;
            margin-bottom: 0.5mm;
        }

        /* Print Styles */
        @media print {
            body {
                padding: 0;
                margin: 0;
                width: 210mm;
                height: 148mm;
            }

            .receipt-container {
                border: none;
                width: 210mm;
                height: 148mm;
                margin: 0;
                padding: 6mm;
                page-break-after: avoid;
                page-break-inside: avoid;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: 210mm 148mm landscape;
                margin: 0;
            }
        }

        /* Print Button */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .print-button:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.5);
        }

        .print-button i {
            margin-right: 1mm;
        }

        .back-button {
            position: fixed;
            top: 5mm;
            left: 5mm;
            padding: 1mm 2mm;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 1mm;
            font-size: 4pt;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 0.5mm 1.5mm rgba(108, 117, 125, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(108, 117, 125, 0.5);
        }

        .back-button i {
            margin-right: 8px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <!-- Print & Back Buttons -->
    <a href="javascript:history.back()" class="back-button no-print">
        <i class="bi bi-arrow-left"></i>Kembali
    </a>
    <button onclick="window.print()" class="print-button no-print">
        <i class="bi bi-printer-fill"></i>Cetak Bukti
    </button>

    <div class="receipt-container">
        <!-- Header -->
        <div class="receipt-header">
            <?php if (function_exists('app_logo')): ?>
                <img src="<?= app_logo() ?>" alt="Logo" class="header-logo">
            <?php endif; ?>
            <h1>BUKTI PEMBAYARAN SPMB</h1>
            <h2><?= esc($schoolName) ?></h2>
            <h3>TAHUN AJARAN <?= date('Y') ?> - <?= date('Y') + 1 ?></h3>
        </div>

        <!-- Body -->
        <div class="receipt-body">
            <!-- Two Column Layout -->
            <div class="info-row">
                <!-- Applicant Info Section (Left Column) -->
                <div class="info-section">
                    <div class="section-title">Data Calon Siswa</div>
                    <table class="info-table">
                        <tr>
                            <td class="label">Nama Lengkap</td>
                            <td class="separator">:</td>
                            <td class="value"><?= esc($payment['full_name'] ?? $payment['nama_lengkap'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="label">No. Pendaftaran</td>
                            <td class="separator">:</td>
                            <td class="value"><?= esc($payment['registration_number'] ?? $payment['nomor_pendaftaran'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="label">Asal Sekolah</td>
                            <td class="separator">:</td>
                            <td class="value"><?= esc($payment['previous_school'] ?? $payment['asal_sekolah'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="label">Jurusan</td>
                            <td class="separator">:</td>
                            <td class="value"><?= esc($payment['jurusan'] ?? '-') ?></td>
                        </tr>
                    </table>
                </div>

                <!-- Payment Info Section (Right Column) -->
                <div class="info-section highlighted">
                    <div class="section-title">Informasi Pembayaran</div>
                    <table class="info-table">
                        <tr>
                            <td class="label">Jenis Pembayaran</td>
                            <td class="separator">:</td>
                            <td class="value">
                                <?php
                                $paymentType = 'Lunas';
                                if (!empty($payment['payment_type'])) {
                                    switch($payment['payment_type']) {
                                        case 'full':
                                            $paymentType = 'Lunas';
                                            break;
                                        case 'installment':
                                            $installment = $payment['installment_number'] ?? 1;
                                            $paymentType = 'Cicilan ' . $installment;
                                            break;
                                        default:
                                            $paymentType = ucfirst($payment['payment_type']);
                                    }
                                }
                                echo esc($paymentType);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Metode Pembayaran</td>
                            <td class="separator">:</td>
                            <td class="value">
                                <?php
                                $paymentMethod = 'Tunai';
                                if (!empty($payment['payment_method'])) {
                                    if ($payment['payment_method'] === 'transfer' && !empty($payment['bank_name'])) {
                                        $paymentMethod = 'Transfer Bank - ' . trim(esc($payment['bank_name']));
                                    } elseif ($payment['payment_method'] === 'cash') {
                                        $paymentMethod = 'Tunai';
                                    } else {
                                        $paymentMethod = ucfirst($payment['payment_method']);
                                    }
                                }
                                echo trim($paymentMethod);
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Payment Amount -->
            <div class="payment-box">
                <div class="payment-label">Jumlah yang dibayarkan :</div>
                <div class="payment-amount">
                    Rp. <?= number_format($payment['transfer_amount'] ?? $payment['registration_fee'], 0, ',', '.') ?>
                </div>
                <div class="payment-label">Terbilang</div>
                <div class="payment-words">
                    " <?= ucwords(terbilang($payment['transfer_amount'] ?? $payment['registration_fee'])) ?> rupiah "
                </div>
            </div>

            <!-- Note -->
            <div class="note">
                <strong>Note :</strong> bukti pembayaran ini <strong>tidak boleh hilang</strong>.
            </div>

            <!-- Signature -->
            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-place">
                        Jakarta, <?= date('d F Y', strtotime($payment['confirmed_at'] ?? $payment['transfer_date'] ?? 'now')) ?>
                    </div>
                    <div class="signature-space"></div>
                    <div class="signature-name">
                        <?php
                        // Get petugas name
                        $petugasName = 'Ahmad Sahroni';
                        if (!empty($payment['confirmed_by_username'])) {
                            $petugasName = $payment['confirmed_by_username'];
                        }
                        echo esc($petugasName);
                        ?>
                    </div>
                    <div style="margin-top: 0.5mm; font-size: 8.5pt;">Petugas</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto print after page load (optional)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // };
    </script>
</body>
</html>
