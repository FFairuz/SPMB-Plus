# Fitur Cetak Bukti Pembayaran SPMB

## Deskripsi
Fitur ini memungkinkan admin, bendahara, panitia, dan applicant untuk mencetak bukti pembayaran yang sudah dikonfirmasi. Format bukti pembayaran mengikuti standar resmi seperti bukti pembayaran sekolah dengan header, informasi siswa, nominal pembayaran dalam angka dan terbilang, serta tanda tangan petugas.

## Tanggal Implementasi
14 Januari 2026

---

## Fitur Utama

### 1. **Format Bukti Pembayaran**
- Header dengan nama sekolah dan tahun ajaran (dinamis dari settings)
- Informasi lengkap calon siswa:
  - Nama calon siswa
  - Nomor pendaftaran
  - Jurusan
  - Asal sekolah
- Jenis dan metode pembayaran
- Nominal pembayaran dalam angka dan terbilang
- Note/catatan penting
- Tanda tangan petugas dengan nama dan tanggal

### 2. **Hak Akses**
- ✅ **Admin**: Dapat mencetak bukti pembayaran semua siswa
- ✅ **Bendahara**: Dapat mencetak bukti pembayaran semua siswa
- ✅ **Panitia**: Dapat mencetak bukti pembayaran semua siswa
- ✅ **Applicant**: Hanya dapat mencetak bukti pembayaran sendiri
- ❌ **Sales**: Tidak dapat mengakses

### 3. **Syarat Cetak**
- Pembayaran harus berstatus **confirmed** (dikonfirmasi)
- Pembayaran dengan status pending, submitted, atau rejected tidak bisa dicetak

---

## File yang Ditambahkan/Diubah

### 1. **Controller** (`app/Controllers/PaymentController.php`)

#### Method Baru: `printReceipt($paymentId)`
```php
public function printReceipt($paymentId)
{
    // Authorization check
    // Get payment data with applicant info
    // Get application settings (nama sekolah, logo, dll)
    // Render view untuk print
}
```

**Fitur:**
- Authorization: cek role dan kepemilikan data
- Validasi status pembayaran (harus confirmed)
- Load data payment dengan join applicant
- Load settings aplikasi (nama sekolah, logo)
- Render view print_receipt

---

### 2. **Routes** (`app/Config/Routes.php`)

**Routes Baru:**
```php
$routes->get('payment/print-receipt/(:num)', 'PaymentController::printReceipt/$1');
$routes->get('applicant/payment/print-receipt/(:num)', 'PaymentController::printReceipt/$1');
$routes->get('admin/payment/print-receipt/(:num)', 'PaymentController::printReceipt/$1');
```

**URL Format:**
- Admin: `/admin/payment/print-receipt/123`
- Applicant: `/applicant/payment/print-receipt/123`
- General: `/payment/print-receipt/123`

---

### 3. **View** (`app/Views/payment/print_receipt.php`)

**Layout Bukti Pembayaran:**

#### A. Header
```
┌───────────────────────────────────────────┐
│     BUKTI PEMBAYARAN SPMB                 │
│     SMK MUHAMMADIYAH 1 JAKARTA            │
│     TAHUN AJARAN 2026 - 2027              │
└───────────────────────────────────────────┘
```

#### B. Informasi Siswa
```
Nama Calon Siswa  : Fairuz               Jurusan       : Babu Cina
No. Pendaftaran   : SPMB-2026-0001       Asal Sekolah  : Asal-Asalan

Jenis Pembayaran  : Cicilan 1
Metode Pembayaran : Tunai
```

#### C. Box Pembayaran
```
┌─────────────────────────────────────┐
│   Jumlah yang dibayarkan :          │
│                                     │
│       Rp. 1.000.000                 │
│                                     │
│          Terbilang                  │
│   " satu juta rupiah "              │
└─────────────────────────────────────┘
```

#### D. Note dan Tanda Tangan
```
Note : bukti pembayaran ini tidak boleh hilang.

                          Jakarta, 23 Februari 2026
                                 Petugas


                              Ahmad Sahroni
```

---

### 4. **View Update** (`app/Views/admin/payments.php`)

**Tombol Cetak Ditambahkan:**
```php
<?php if ($current_status === 'confirmed'): ?>
    <a href="<?= base_url('admin/payment/print-receipt/' . $payment['id']); ?>" 
       class="btn btn-sm btn-primary" target="_blank">
        <i class="bi bi-printer-fill"></i> Cetak Bukti
    </a>
<?php endif; ?>
```

**Lokasi:**
- Kolom "Aksi" pada tabel payments
- Hanya muncul jika status = confirmed
- Link buka di tab baru (target="_blank")

---

## Styling

### 1. **Print-Friendly CSS**
```css
@media print {
    body {
        padding: 0;
    }
    
    .no-print {
        display: none !important;
    }
    
    @page {
        size: A4;
        margin: 10mm;
    }
}
```

### 2. **Border dan Layout**
- Container dengan border 2px solid black
- Header dengan background abu-abu terang
- Box pembayaran dengan border tebal
- Font: Times New Roman (formal)
- Size: 12pt untuk body, 24pt untuk nominal

### 3. **Responsive Design**
- Optimal untuk print A4
- Support portrait orientation
- Auto page break handling

---

## Helper Function

### `terbilang($angka)`
**Fungsi:** Convert angka ke terbilang bahasa Indonesia

**Examples:**
```php
terbilang(1000000) // "satu juta"
terbilang(250000)  // "dua ratus lima puluh ribu"
terbilang(500)     // "lima ratus"
```

**Lokasi:** Defined di `print_receipt.php` view (inline function)

**Future:** Bisa dipindah ke `app/Helpers/number_helper.php`

---

## Cara Menggunakan

### Untuk Admin/Bendahara/Panitia:

1. **Dari Halaman Payments:**
   - Login sebagai Admin/Bendahara/Panitia
   - Buka menu **Kelola Pembayaran** (`/admin/payments`)
   - Pilih filter **Dikonfirmasi** (status=confirmed)
   - Klik tombol **Cetak Bukti** pada row pembayaran
   - Bukti pembayaran akan terbuka di tab baru
   - Klik tombol **Cetak Bukti** atau tekan Ctrl+P

2. **Direct URL:**
   ```
   /admin/payment/print-receipt/{payment_id}
   ```

### Untuk Applicant:

1. **Dari Dashboard Applicant:**
   - Login sebagai Applicant
   - Buka menu **Pembayaran**
   - Jika pembayaran sudah dikonfirmasi, muncul tombol **Cetak Bukti**
   - Klik untuk membuka dan mencetak

2. **Direct URL:**
   ```
   /applicant/payment/print-receipt/{payment_id}
   ```

---

## Customization

### 1. **Mengubah Nama Sekolah**
Edit di menu **Pengaturan Aplikasi** (`/admin/settings`):
- **school_name**: Nama sekolah yang muncul di header
- **app_name**: Nama aplikasi

### 2. **Mengubah Logo**
Upload logo di menu **Pengaturan Aplikasi**:
- Logo akan muncul di header bukti pembayaran (opsional)
- Format: PNG, JPG, SVG
- Size: Max 2MB

### 3. **Mengubah Nama Petugas**
Otomatis menggunakan nama user yang mengkonfirmasi pembayaran:
- Diambil dari `confirmed_by_username`
- Fallback: "Ahmad Sahroni" (default)

### 4. **Mengubah Lokasi/Kota**
Edit di file `print_receipt.php` line 334:
```php
Jakarta, <?= date('d F Y', ...) ?>
```
Ganti "Jakarta" dengan kota sekolah Anda.

---

## Database Schema

### Table: `payments`
**Field yang Digunakan:**
- `id` - Payment ID
- `applicant_id` - Relasi ke tabel applicants
- `registration_fee` - Biaya pendaftaran
- `transfer_amount` - Jumlah yang dibayarkan
- `transfer_date` - Tanggal transfer
- `bank_name` - Nama bank (jika transfer)
- `account_holder` - Nama pemegang rekening
- `payment_status` - Status (confirmed, pending, dll)
- `payment_type` - Jenis pembayaran (opsional)
- `confirmed_at` - Timestamp konfirmasi
- `confirmed_by` - User ID yang konfirmasi

### Table: `applicants`
**Field yang Digunakan:**
- `id` - Applicant ID
- `user_id` - Relasi ke users
- `full_name` - Nama lengkap
- `registration_number` - No. pendaftaran
- `major` - Jurusan
- `previous_school` - Asal sekolah

### Join Query:
```sql
SELECT 
    p.*,
    a.full_name,
    a.registration_number,
    a.major,
    a.previous_school,
    u.username as confirmed_by_username
FROM payments p
LEFT JOIN applicants a ON p.applicant_id = a.id
LEFT JOIN users u ON p.confirmed_by = u.id
WHERE p.id = ?
```

---

## Testing

### Test Case 1: Admin Print Receipt
**Setup:**
- Login sebagai admin
- Pilih pembayaran dengan status confirmed

**Steps:**
1. Buka `/admin/payments?status=confirmed`
2. Klik tombol "Cetak Bukti" pada salah satu row
3. Verifikasi bukti pembayaran terbuka di tab baru
4. Verifikasi semua data tampil dengan benar
5. Klik tombol "Cetak Bukti" atau Ctrl+P
6. Preview print harus rapi tanpa tombol/elemen UI

**Expected Result:**
- ✅ Bukti terbuka di tab baru
- ✅ Semua data tampil lengkap dan benar
- ✅ Format rapi dan profesional
- ✅ Print preview bersih (no buttons)
- ✅ Terbilang angka benar

### Test Case 2: Applicant Print Own Receipt
**Setup:**
- Login sebagai applicant
- Pembayaran sudah confirmed

**Steps:**
1. Buka dashboard applicant
2. Klik menu "Pembayaran"
3. Klik tombol "Cetak Bukti"
4. Verifikasi bukti pembayaran

**Expected Result:**
- ✅ Hanya bisa print bukti sendiri
- ✅ Data tampil lengkap
- ✅ Dapat print dengan benar

### Test Case 3: Unauthorized Access
**Setup:**
- Login sebagai applicant
- Coba akses print receipt applicant lain

**Steps:**
1. Akses `/applicant/payment/print-receipt/999` (ID orang lain)
2. Should be redirected

**Expected Result:**
- ✅ Redirect ke dashboard
- ✅ Error message "Akses ditolak"

### Test Case 4: Status Not Confirmed
**Setup:**
- Login sebagai admin
- Pilih pembayaran dengan status selain confirmed

**Steps:**
1. Akses URL print untuk payment pending/submitted
2. Should be blocked

**Expected Result:**
- ✅ Redirect back
- ✅ Error: "Bukti pembayaran hanya dapat dicetak untuk pembayaran yang sudah dikonfirmasi"

### Test Case 5: Terbilang Function
**Test Cases:**
```php
1000000   => "satu juta"
250000    => "dua ratus lima puluh ribu"
500       => "lima ratus"
1500000   => "satu juta lima ratus ribu"
100000    => "seratus ribu"
```

**Expected Result:**
- ✅ Semua konversi benar
- ✅ Format sesuai bahasa Indonesia

---

## Print Settings Recommendation

### Browser Settings:
- **Margins**: Minimal (10mm)
- **Orientation**: Portrait
- **Paper Size**: A4
- **Scale**: 100%
- **Background Graphics**: Optional
- **Headers/Footers**: None

### Print Quality:
- **Resolution**: 300 DPI atau lebih tinggi
- **Color**: Hitam putih sudah cukup
- **Paper**: HVS 80gsm

---

## Troubleshooting

### Problem 1: Bukti Tidak Muncul
**Possible Causes:**
- Payment ID salah
- Status bukan confirmed
- Tidak ada authorization

**Solution:**
```php
// Cek status pembayaran
SELECT payment_status FROM payments WHERE id = ?;

// Harus 'confirmed'
UPDATE payments SET payment_status = 'confirmed' WHERE id = ?;
```

### Problem 2: Terbilang Salah
**Possible Causes:**
- Angka terlalu besar (> 1 miliar)
- Format angka salah

**Solution:**
- Maksimal 999.999.999 (sembilan ratus sembilan puluh sembilan juta)
- Jika lebih besar, perlu extend function

### Problem 3: Logo Tidak Muncul
**Possible Causes:**
- Logo belum diupload
- Path logo salah

**Solution:**
```php
// Cek settings
SELECT * FROM settings WHERE setting_key = 'app_logo';

// Upload logo baru via /admin/settings
```

### Problem 4: Print Layout Berantakan
**Possible Causes:**
- Browser zoom bukan 100%
- Page size bukan A4

**Solution:**
- Reset browser zoom ke 100%
- Pilih paper size A4 di print settings
- Clear browser cache

---

## Future Enhancements

### Planned Features:
1. ✅ QR Code untuk verifikasi bukti
2. ✅ Watermark "LUNAS" atau "VALID"
3. ✅ Export ke PDF langsung
4. ✅ Email bukti pembayaran otomatis
5. ✅ Multiple template (formal, modern, minimalist)
6. ✅ Barcode untuk scan
7. ✅ Digital signature
8. ✅ Print preview before print
9. ✅ Batch print (multiple receipts)
10. ✅ Duplicate check (cegah print ganda)

---

## Security

### 1. **Authorization**
```php
// Check role
if ($role === 'applicant') {
    // Cek kepemilikan
    if ($applicant['id'] !== $payment['applicant_id']) {
        return redirect()->to('/applicant/dashboard')
            ->with('error', 'Akses ditolak');
    }
}
```

### 2. **Status Validation**
```php
// Only confirmed payments
if ($payment['payment_status'] !== 'confirmed') {
    return redirect()->back()
        ->with('error', 'Hanya pembayaran confirmed yang bisa dicetak');
}
```

### 3. **XSS Prevention**
```php
// Escape all output
<?= esc($payment['full_name']) ?>
<?= htmlspecialchars($payment['email']) ?>
```

### 4. **SQL Injection Prevention**
- Menggunakan Query Builder CodeIgniter
- Prepared statements
- Parameter binding

---

## API Endpoints

### GET `/payment/print-receipt/{id}`
**Description:** Print payment receipt

**Parameters:**
- `id` (required) - Payment ID

**Response:**
- HTML page dengan bukti pembayaran
- Ready to print

**Authorization:**
- Admin, Bendahara, Panitia: All receipts
- Applicant: Own receipt only

**Status Codes:**
- 200: Success
- 302: Redirect (unauthorized or invalid status)
- 404: Payment not found

---

## Changelog

### Version 1.0 (14 Januari 2026)
- ✅ Implementasi print receipt
- ✅ Format sesuai standar bukti pembayaran sekolah
- ✅ Authorization by role
- ✅ Status validation (confirmed only)
- ✅ Terbilang function
- ✅ Print-friendly CSS
- ✅ Responsive design
- ✅ Dynamic school name dari settings

---

## Credits

**Developer:** GitHub Copilot AI Assistant  
**Project:** SPMB-Plus (Sistem PPDB)  
**Framework:** CodeIgniter 4  
**Design Reference:** Bukti Pembayaran SMK Muhammadiyah 1 Jakarta  
**Date:** 14 Januari 2026  

---

## Support

Jika ada pertanyaan atau masalah:
1. Baca dokumentasi ini
2. Cek troubleshooting section
3. Test dengan berbagai browser
4. Hubungi tim developer

---

**Selamat menggunakan fitur Cetak Bukti Pembayaran! 🖨️**
