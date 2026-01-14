# Update Ukuran Cetak Bukti Pembayaran - A5 Portrait (Setengah A4)

**Tanggal**: 14 Januari 2026  
**Perubahan**: Mengubah ukuran cetak bukti pembayaran ke **A5 Portrait (148mm x 210mm)** - Setengah A4

---

## 📋 Ringkasan Perubahan

Ukuran cetak bukti pembayaran telah diubah dari ukuran miniatur (21mm x 14mm) menjadi **A5 Portrait (148mm x 210mm)** yang merupakan setengah dari ukuran A4 dan sangat cocok untuk bukti pembayaran/kwitansi.

### Ukuran Baru:
- **Lebar**: 148mm
- **Tinggi**: 210mm
- **Format**: A5 Portrait (setengah A4)
- **Orientasi**: Portrait (vertikal)
- **Area cetak efektif**: 138mm x 190mm (dengan padding 10mm)

---

## 📁 File yang Dimodifikasi

### 1. **bendahara/cetak_bukti_single.php**
**Path**: `c:\xampp\htdocs\SPMB-Plus\app\Views\bendahara\cetak_bukti_single.php`

### 2. **payment/print_receipt.php**
**Path**: `c:\xampp\htdocs\SPMB-Plus\app\Views\payment\print_receipt.php`

---

## 🎨 Spesifikasi Desain

### Page Setup:
```css
@page {
    size: 148mm 210mm; /* A5 Portrait */
    margin: 0;
}

body {
    font-family: 'Times New Roman', Times, serif;
    font-size: 11pt;
    line-height: 1.4;
    padding: 10mm;
    width: 148mm;
    height: 210mm;
}

.receipt-container {
    width: 138mm; /* 148mm - 10mm padding */
    min-height: 190mm;
    border: 2px solid #000;
}
```

### Font Sizes (Readable & Professional):
- **Body text**: 11pt
- **Header H1**: 14pt (Bold, Uppercase)
- **Header H2**: 12pt (Bold, Red)
- **Header H3**: 10pt (Normal)
- **Info table**: 10pt
- **Payment amount**: 20pt (Bold)
- **Payment words**: 9pt (Italic)
- **Note text**: 9pt
- **Signature**: 10pt

### Spacing & Layout:
- **Page padding**: 10mm
- **Header padding**: 8mm x 5mm
- **Body padding**: 5mm x 8mm
- **Table cell padding**: 2mm vertical
- **Payment box padding**: 5mm
- **Payment box margin**: 5mm vertical
- **Signature space**: 20mm height
- **Signature top margin**: 10mm

### Border & Decoration:
- **Main border**: 2px solid #000
- **Header border**: 2px solid #000
- **Payment box border**: 2px solid #000
- **Payment words border**: 1px dashed #999
- **Note border left**: 3px solid #ffd700

### Colors:
- **Header H2**: #c00 (Red)
- **Header background**: #f9f9f9 (Light gray)
- **Payment box background**: #f9f9f9 (Light gray)
- **Note background**: #fffacd (Light yellow)
- **Note border**: #ffd700 (Gold)

---

## 📐 Keuntungan Ukuran A5

### ✅ Kelebihan:
1. **Hemat kertas** - Setengah dari A4, bisa print 2 bukti per sheet A4
2. **Ukuran standar** - A5 adalah ukuran umum untuk kwitansi/nota
3. **Mudah dibaca** - Font 9pt - 20pt sangat readable
4. **Professional** - Ukuran yang tepat untuk dokumen resmi
5. **Easy storage** - Pas untuk arsip kwitansi/bukti pembayaran
6. **Printer friendly** - Semua printer support A5 atau custom 148x210mm

### 📏 Perbandingan Ukuran:
- **A4**: 210mm x 297mm (Full size)
- **A5**: 148mm x 210mm (Setengah A4) ✅ **Pilihan ini**
- **A6**: 105mm x 148mm (Seperti postcard)
- **Kartu nama**: ~90mm x 50mm
- **Label miniatur**: 21mm x 14mm (terlalu kecil)

---

## 🖨️ Cara Print

### Print 1 Bukti per Sheet:
1. Buka halaman cetak bukti
2. Klik tombol **"Cetak Bukti"**
3. Di dialog print:
   - Pilih **Portrait**
   - Paper size: **A5 (148 x 210 mm)** atau **Custom: 148 x 210**
   - Margins: **None** atau **Minimal**
   - Scale: **100%**
4. Print

### Print 2 Bukti per Sheet A4:
1. Di dialog print, pilih:
   - Paper size: **A4**
   - Layout: **2 pages per sheet**
   - Orientation: **Portrait**
2. Print

### Print Setting Recommended:
```
Paper Size: A5 (148mm x 210mm)
Orientation: Portrait
Margins: None
Scale: 100%
Color: Color (untuk highlight note)
Quality: Normal/High
```

---

## 🧪 Testing

### Test Checklist:
- [x] ✅ Ukuran halaman: 148mm x 210mm (A5)
- [x] ✅ Font readable: 9pt - 20pt
- [x] ✅ Border & spacing proper
- [x] ✅ Payment box highlighted
- [x] ✅ Signature section: 20mm space
- [x] ✅ Print preview correct
- [x] ✅ No PHP errors
- [x] ✅ Responsive button placement

### Test URLs:
- **Bendahara**: `http://localhost:8080/bendahara/cetak-bukti-single/1`
- **Payment**: `http://localhost:8080/payment/print-receipt/1`

---

## 📝 Print Media Query

```css
@media print {
    body {
        padding: 0;
        margin: 0;
        width: 148mm;
        height: 210mm;
    }

    .receipt-container {
        border: 2px solid #000;
        width: 148mm;
        min-height: 210mm;
        margin: 0;
        page-break-after: avoid;
    }

    .no-print {
        display: none !important;
    }

    @page {
        size: 148mm 210mm; /* A5 Portrait */
        margin: 0;
    }
}
```

---

## 🔄 History Perubahan

### Version 1 (Awal):
- Ukuran: 21cm x 14cm (A5 Landscape)
- Font: 9pt - 18pt
- Status: ❌ Terlalu besar

### Version 2 (Percobaan):
- Ukuran: 21mm x 14mm (Miniatur)
- Font: 2.5pt - 5pt
- Status: ❌ Terlalu kecil, tidak bisa dibaca

### Version 3 (Current): ✅
- Ukuran: **148mm x 210mm (A5 Portrait)**
- Font: **9pt - 20pt**
- Status: ✅ **PERFECT** - Readable, professional, printer-friendly

---

## 🎯 Rekomendasi Implementasi

### Untuk Bukti Pembayaran:
✅ **A5 Portrait (148mm x 210mm)** - Pilihan TERBAIK
- Ukuran standar kwitansi
- Hemat kertas (setengah A4)
- Sangat readable
- Professional appearance

### Alternatif Lain:
- **A4 Portrait (210mm x 297mm)** - Jika butuh space lebih
- **A6 Portrait (105mm x 148mm)** - Untuk mini receipt

---

## ✅ Validasi

**File Validation:**
```bash
✅ bendahara/cetak_bukti_single.php - No errors
✅ payment/print_receipt.php - No errors
```

**CSS Validation:**
- ✅ @page size: 148mm x 210mm
- ✅ Font sizes: 9pt - 20pt (readable)
- ✅ Spacing: proper padding & margins
- ✅ Border: 2px solid (professional)
- ✅ Print media query: complete

**Visual Validation:**
- ✅ Header section: clear & bold
- ✅ Info section: well-spaced
- ✅ Payment box: highlighted & prominent
- ✅ Signature section: 20mm space for signature
- ✅ Overall layout: professional & readable

---

## 💾 Rollback Instructions

Jika ingin kembali ke ukuran lain, ubah nilai berikut:

### Untuk A4 Portrait (210mm x 297mm):
```css
@page { size: 210mm 297mm; }
body { width: 210mm; height: 297mm; padding: 15mm; }
.receipt-container { width: 180mm; min-height: 267mm; }
```

### Untuk A5 Landscape (210mm x 148mm):
```css
@page { size: 210mm 148mm; }
body { width: 210mm; height: 148mm; }
.receipt-container { width: 190mm; height: 128mm; }
```

---

## 📚 Referensi

- **ISO 216 Paper Sizes**: https://en.wikipedia.org/wiki/ISO_216
- **A5 Dimensions**: 148mm × 210mm (5.8" × 8.3")
- **Print CSS**: https://www.w3.org/TR/css-page-3/
- **CSS Units**: pt (point), mm (millimeter), px (pixel)

---

## 🎉 Kesimpulan

Ukuran **A5 Portrait (148mm x 210mm)** adalah pilihan **TERBAIK** untuk bukti pembayaran:
- ✅ Ukuran standar & profesional
- ✅ Hemat kertas (setengah A4)
- ✅ Sangat mudah dibaca (font 9-20pt)
- ✅ Printer friendly
- ✅ Mudah disimpan & diarsip

**Status**: ✅ **PRODUCTION READY**
