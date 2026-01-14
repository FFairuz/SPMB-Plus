# Fix: Missing Bendahara Cetak Bukti Single View

## Issue
File `app/Views/bendahara/cetak_bukti_single.php` tidak ditemukan, menyebabkan error saat bendahara mencoba mencetak bukti pembayaran single.

## Tanggal Fix
14 Januari 2026

---

## Problem Description

**Error Message:**
```
Invalid file: "bendahara/cetak_bukti_single.php"
```

**Root Cause:**
- Controller `BendaharaController::cetak_bukti()` mereferensi view yang tidak ada
- View file `bendahara/cetak_bukti_single.php` hilang atau belum dibuat

**Impact:**
- Bendahara tidak bisa mencetak bukti pembayaran single
- Error 500 saat akses route `/bendahara/cetak-bukti/{id}`

---

## Solution

### File Created: `app/Views/bendahara/cetak_bukti_single.php`

**Features:**
- ✅ Format bukti pembayaran standar (sesuai gambar referensi)
- ✅ Header dengan nama sekolah (dinamis dari settings)
- ✅ Informasi lengkap siswa dan pembayaran
- ✅ Nominal dalam angka dan terbilang
- ✅ Tanda tangan petugas (nama dari session bendahara)
- ✅ Print-friendly CSS
- ✅ Tombol cetak dan kembali
- ✅ Responsive design

**Layout:**
```
┌─────────────────────────────────────────────────────────┐
│           BUKTI PEMBAYARAN SPMB                         │
│        SMK MUHAMMADIYAH 1 JAKARTA                       │
│         TAHUN AJARAN 2026 - 2027                        │
├─────────────────────────────────────────────────────────┤
│  Nama Calon Siswa : [Nama]         Jurusan : [Jurusan] │
│  No. Pendaftaran  : [No]           Asal Sekolah : [...]│
│                                                         │
│  Jenis Pembayaran : Cicilan 1                          │
│  Metode Pembayaran: Tunai/Transfer                     │
│                                                         │
│  ┌───────────────────────────────────────────┐         │
│  │   Jumlah yang dibayarkan :                │         │
│  │         Rp. 1.000.000                     │         │
│  │          Terbilang                        │         │
│  │   " satu juta rupiah "                    │         │
│  └───────────────────────────────────────────┘         │
│                                                         │
│  Note : bukti pembayaran ini tidak boleh hilang.       │
│                                                         │
│                          Jakarta, [Tanggal]             │
│                                 Petugas                 │
│                              [Nama Bendahara]           │
└─────────────────────────────────────────────────────────┘
```

---

## Technical Details

### Route
```php
// app/Config/Routes.php
$routes->get('bendahara/cetak-bukti/(:num)', 'BendaharaController::cetak_bukti/$1');
```

### Controller Method
```php
// app/Controllers/BendaharaController.php
public function cetak_bukti($paymentId = null)
{
    $this->requireBendahara();

    if ($paymentId) {
        $payment = $this->paymentModel->find($paymentId);

        if (!$payment) {
            session()->setFlashdata('error', 'Data pembayaran tidak ditemukan.');
            return redirect()->to('/bendahara/verifikasi-pembayaran');
        }

        return view('bendahara/cetak_bukti_single', [
            'payment' => $payment,
        ]);
    }
    // ... batch print logic
}
```

### View Variables
```php
$payment = [
    'id' => Payment ID,
    'nama_lengkap' => Nama siswa,
    'nomor_pendaftaran' => No. pendaftaran,
    'jurusan' / 'major' => Jurusan,
    'asal_sekolah' / 'previous_school' => Asal sekolah,
    'payment_type' => Jenis pembayaran,
    'bank_name' => Nama bank (jika transfer),
    'transfer_amount' / 'registration_fee' => Nominal,
    'transfer_date' => Tanggal transfer,
    'confirmed_at' => Tanggal konfirmasi,
    'confirmed_by_username' => Nama petugas yang konfirmasi
]
```

---

## Key Features

### 1. **Dynamic School Name**
```php
<?= function_exists('school_name') ? esc(school_name()) : 'SMK MUHAMMADIYAH 1 JAKARTA' ?>
```
- Menggunakan nama sekolah dari settings jika tersedia
- Fallback ke nama default

### 2. **Flexible Field Names**
```php
<?= esc($payment['nama_lengkap'] ?? '-') ?>
<?= esc($payment['nomor_pendaftaran'] ?? $payment['registration_number'] ?? '-') ?>
<?= esc($payment['major'] ?? $payment['jurusan'] ?? '-') ?>
```
- Support multiple field name variations
- Graceful fallback dengan '-' jika data tidak ada

### 3. **Terbilang Function**
```php
function terbilang($angka) {
    // Convert number to Indonesian words
    // 1000000 => "satu juta"
}
```
- Inline function di view
- Support angka sampai ratusan juta

### 4. **Bendahara Name**
```php
$petugasName = session()->get('username') ?? 'Bendahara';
if (!empty($payment['confirmed_by_username'])) {
    $petugasName = $payment['confirmed_by_username'];
}
```
- Prioritas: confirmed_by_username > session username > 'Bendahara'

### 5. **Print-Friendly**
```css
@media print {
    .no-print { display: none !important; }
    @page { size: A4; margin: 10mm; }
}
```
- Tombol UI hilang saat print
- Optimal untuk A4 portrait

---

## Usage

### For Bendahara:

1. **Single Print:**
   - Login sebagai Bendahara
   - Buka **Verifikasi Pembayaran** (`/bendahara/verifikasi-pembayaran`)
   - Klik tombol **"Cetak Bukti"** pada row pembayaran
   - Bukti terbuka di tab baru
   - Klik **"Cetak Bukti"** atau Ctrl+P

2. **Direct URL:**
   ```
   /bendahara/cetak-bukti/{payment_id}
   ```

3. **Batch Print:**
   ```
   /bendahara/cetak-bukti
   ```
   (Tanpa payment_id untuk cetak multiple)

---

## Comparison with Other Print Views

| Feature | bendahara/cetak_bukti_single | payment/print_receipt | bendahara/cetak_bukti_pembayaran |
|---------|------------------------------|----------------------|----------------------------------|
| **Purpose** | Single receipt untuk bendahara | Single receipt universal | Single receipt alternative |
| **Authorization** | Bendahara only | Admin/Bendahara/Panitia/Applicant | Bendahara only |
| **Field Names** | Flexible (support multiple) | Standard | Standard |
| **Petugas Name** | Session username | confirmed_by_username | Session username |
| **Back Button** | To verifikasi-pembayaran | To previous page | To verifikasi-pembayaran |

---

## Testing

### Test Case 1: Single Print
**Setup:**
- Login sebagai Bendahara
- Pilih pembayaran confirmed

**Steps:**
1. Buka `/bendahara/verifikasi-pembayaran`
2. Klik "Cetak Bukti" pada row
3. Verifikasi bukti terbuka
4. Check semua data tampil benar
5. Test print (Ctrl+P)

**Expected:**
- ✅ Bukti terbuka tanpa error
- ✅ Semua data tampil lengkap
- ✅ Format rapi sesuai gambar
- ✅ Print preview bersih

### Test Case 2: Missing Data
**Setup:**
- Payment dengan field kosong/null

**Expected:**
- ✅ Field kosong tampil '-'
- ✅ Tidak ada error PHP
- ✅ Layout tetap rapi

### Test Case 3: Print Quality
**Setup:**
- Print ke PDF atau printer

**Expected:**
- ✅ Border tajam
- ✅ Text jelas terbaca
- ✅ Layout tidak berantakan
- ✅ Page break proper

---

## Files Modified

### Created:
- ✅ `app/Views/bendahara/cetak_bukti_single.php` - New view file

### Existing (Referenced):
- `app/Controllers/BendaharaController.php` - Controller
- `app/Config/Routes.php` - Routes
- `app/Helpers/settings_helper.php` - For school_name()

---

## Related Documentation

- `PRINT_RECEIPT_FEATURE.md` - Main print receipt documentation
- `IMPLEMENTATION_SUMMARY_2026-01-14.md` - Overall implementation summary
- `QUICK_REFERENCE.md` - Quick guide

---

## Notes

### Why Multiple Print Views?

1. **payment/print_receipt.php**
   - Universal view untuk semua role
   - Authorization check di controller
   - Standard field names

2. **bendahara/cetak_bukti_single.php**
   - Khusus untuk bendahara workflow
   - Flexible field names (support variations)
   - Back to bendahara page

3. **bendahara/cetak_bukti_pembayaran.php**
   - Alternative view dengan format berbeda
   - Bisa punya layout khusus bendahara

### Best Practice
Gunakan view sesuai context:
- Dari menu bendahara → Use `bendahara/*` views
- Dari menu admin → Use `payment/print_receipt`
- Universal → Use `payment/print_receipt`

---

## Changelog

### Version 1.0 (14 Januari 2026)
- ✅ Created missing view file
- ✅ Implemented standard receipt format
- ✅ Added terbilang function
- ✅ Added print-friendly CSS
- ✅ Support flexible field names
- ✅ Dynamic school name integration
- ✅ Session-based petugas name

---

## Status

**Issue:** ❌ Missing file  
**Status:** ✅ **FIXED**  
**Date:** 14 Januari 2026  
**Version:** 1.0  

---

**Problem solved! File created and tested.** ✅
