# Perubahan Ukuran Cetak Bukti Pembayaran - 21mm x 14mm

**Tanggal**: 14 Januari 2026  
**Perubahan**: Mengubah ukuran cetak bukti pembayaran menjadi **21mm x 14mm** (format miniatur/label kecil)

---

## 📋 Ringkasan Perubahan

Ukuran cetak bukti pembayaran telah diubah dari **21cm x 14cm (A5 landscape)** menjadi **21mm x 14mm** yang merupakan ukuran sangat kecil seperti label atau stiker kecil.

### Ukuran Baru:
- **Lebar**: 21mm
- **Tinggi**: 14mm
- **Format**: Miniatur/Label kecil
- **Orientasi**: Landscape

---

## 📁 File yang Dimodifikasi

### 1. **bendahara/cetak_bukti_single.php**
**Path**: `c:\xampp\htdocs\SPMB-Plus\app\Views\bendahara\cetak_bukti_single.php`

**Perubahan CSS:**
```css
@page {
    size: 21mm 14mm;
    margin: 0;
}

body {
    font-family: 'Arial', sans-serif;
    font-size: 3pt;
    line-height: 1.1;
    padding: 0;
    width: 21mm;
    height: 14mm;
}

.receipt-container {
    width: 21mm;
    height: 14mm;
    border: 0.3mm solid #000;
}
```

### 2. **payment/print_receipt.php**
**Path**: `c:\xampp\htdocs\SPMB-Plus\app\Views\payment\print_receipt.php`

**Perubahan CSS yang sama seperti di atas**

---

## 🎨 Penyesuaian Detail

### Font Size:
- **Body**: 3pt (sangat kecil)
- **Header H1**: 4pt
- **Header H2**: 3.5pt
- **Header H3**: 3pt
- **Info table**: 3pt
- **Payment amount**: 5pt (bold)
- **Payment words**: 2.5pt
- **Note**: 2.5pt
- **Signature**: 3pt

### Spacing & Padding:
- **Border width**: 0.3mm (dari 2px)
- **Body padding**: 0 (dari 0.8cm)
- **Header padding**: 0.3mm (dari 8px)
- **Body padding**: 0.5mm x 1mm (dari 12px x 20px)
- **Table cell padding**: 0.2mm (dari 3px)
- **Payment box padding**: 0.5mm (dari 10px)
- **Payment box margin**: 0.5mm (dari 12px)
- **Signature height**: 2mm (dari 50px)

### Button Sizes:
- **Print button position**: top 5mm, right 5mm
- **Button padding**: 1mm x 2mm
- **Button font**: 4pt
- **Button border-radius**: 1mm
- **Button shadow**: 0 0.5mm 1.5mm
- **Hover transform**: translateY(-0.3mm)

### Print Media Query:
```css
@media print {
    body {
        width: 21mm;
        height: 14mm;
    }
    
    .receipt-container {
        width: 21mm;
        height: 14mm;
        border: 0.3mm solid #000;
    }
    
    @page {
        size: 21mm 14mm;
        margin: 0;
    }
}
```

---

## 🔍 Catatan Penting

### ⚠️ Ukuran Sangat Kecil
Ukuran **21mm x 14mm** adalah ukuran yang **sangat kecil** (seukuran label kecil atau stiker). Pada ukuran ini:
- Text sangat sulit dibaca (font 2.5pt - 5pt)
- Cocok untuk **label produk**, **barcode label**, atau **stiker identifikasi**
- **TIDAK cocok** untuk dokumen pembayaran resmi yang perlu dibaca manusia

### 📐 Perbandingan Ukuran:
- **Kartu nama**: ~90mm x 50mm (5-6x lebih besar)
- **Kartu kredit**: 85.6mm x 53.98mm (4-5x lebih besar)
- **Perangko**: ~25mm x 30mm (sedikit lebih besar)
- **Label harga kecil**: ~20mm x 10mm (mendekati ukuran ini)

### 💡 Rekomendasi:
Jika bukti pembayaran ini untuk:
- ✅ **Label/stiker** → Ukuran 21mm x 14mm OK
- ❌ **Dokumen resmi** → Gunakan minimal A6 (105mm x 148mm) atau setengah A5
- ❌ **Bukti pembayaran** → Gunakan A5 (148mm x 210mm) atau A4

---

## 🧪 Testing

### Cara Test:
1. Akses halaman cetak:
   - Bendahara: `http://localhost:8080/bendahara/cetak-bukti-single/{id}`
   - Payment: `http://localhost:8080/payment/print-receipt/{id}`
2. Klik tombol **"Cetak Bukti"**
3. Di dialog print, cek:
   - ✅ Ukuran halaman: 21mm x 14mm
   - ✅ Font sangat kecil (3-5pt)
   - ✅ Border 0.3mm
   - ✅ No margins

### Print Preview:
- Gunakan **browser print preview** (Ctrl+P)
- Pastikan printer support ukuran custom 21mm x 14mm
- Untuk label printer, pastikan label roll sesuai ukuran

---

## 📝 Validasi

### Status: ✅ **BERHASIL**

**File Validation:**
```bash
✅ bendahara/cetak_bukti_single.php - No errors
✅ payment/print_receipt.php - No errors
```

**CSS Validation:**
- ✅ Semua ukuran dalam mm (millimeter)
- ✅ Font size 2.5pt - 5pt
- ✅ @page size 21mm x 14mm
- ✅ Border 0.3mm
- ✅ Print media query updated

---

## 🔄 Rollback (Jika Diperlukan)

Jika ingin kembali ke ukuran **A5 landscape (21cm x 14cm)**, ubah:

```css
@page {
    size: 21cm 14cm;  /* dari 21mm 14mm */
}

body {
    font-size: 9pt;   /* dari 3pt */
    width: 21cm;      /* dari 21mm */
    height: 14cm;     /* dari 14mm */
}

/* Dan semua size lainnya dikembalikan ke satuan cm/px */
```

---

## 📚 Referensi

- **Print CSS Units**: mm (millimeter), cm (centimeter), pt (point)
- **Label Size Standards**: 
  - Small product label: 20mm x 10mm
  - Barcode label: 25mm x 15mm
  - Price tag: 30mm x 20mm

---

## ✅ Checklist Implementasi

- [x] Update CSS @page size ke 21mm x 14mm
- [x] Update body width & height
- [x] Update semua font sizes (2.5pt - 5pt)
- [x] Update semua padding & margins ke mm
- [x] Update border widths ke 0.3mm
- [x] Update button sizes & positions
- [x] Update signature section
- [x] Update print media query
- [x] Validasi PHP (no errors)
- [x] Dokumentasi lengkap

---

**Catatan Akhir**: Ukuran 21mm x 14mm sangat kecil dan mungkin tidak praktis untuk bukti pembayaran. Pertimbangkan untuk menggunakan ukuran yang lebih besar seperti A6 (105mm x 148mm) atau minimal setengah A5 untuk keterbacaan yang lebih baik.
