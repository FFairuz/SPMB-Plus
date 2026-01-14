# Fix Info Table Alignment - Bukti Pembayaran

## Masalah
Pada tampilan bukti pembayaran, bagian info siswa (Nama Calon Siswa dan Asal Sekolah) tidak sejajar dengan baik karena:
1. Width kolom tidak proporsional (28%, 35%, 15%, 18%)
2. Asal Sekolah menggunakan inline style yang inconsistent
3. Vertical alignment menggunakan `top` sehingga tidak sejajar horizontal
4. No. Pendaftaran memiliki kolom kosong yang tidak perlu

## Screenshot Masalah

**Sebelum:**
```
Nama Calon Siswa    : John Doe              Asal Sekolah  :  SMP Negeri
                                                                1 Jakarta
No. Pendaftaran     : PPDB-202512-0001
```

Masalah:
- "Asal Sekolah" tidak sejajar dengan "John Doe"
- Width tidak proporsional
- Spacing tidak rapi

## Solusi

### 1. Perbaikan CSS Width Kolom

**Sebelum:**
```css
.info-table td:first-child {
    width: 28%;
}
.info-table td:nth-child(3) {
    width: 35%;
}
.info-table td:nth-child(4) {
    width: 15%;
    text-align: right;
}
.info-table td:nth-child(6) {
    width: 18%;
}
```

**Sesudah:**
```css
.info-table td:first-child {
    width: 24%;  /* Label kiri */
}
.info-table td:nth-child(3) {
    width: 24%;  /* Value kiri */
}
.info-table td:nth-child(4) {
    width: 24%;  /* Label kanan */
    text-align: right;
    padding-right: 2mm;
}
.info-table td:nth-child(6) {
    width: 24%;  /* Value kanan */
}
```

**Distribusi Width:**
- Setiap kolom data: **24%** (4 x 24% = 96%)
- Titik dua (:): **2%** (2 x 2% = 4%)
- **Total: 100%** (perfectly balanced)

### 2. Perbaikan Vertical Alignment

**Sebelum:**
```css
.info-table td {
    vertical-align: top;
    padding: 0.8mm 0;
    line-height: 1.4;
}
```

**Sesudah:**
```css
.info-table td {
    vertical-align: middle;  /* Sejajar horizontal */
    padding: 1mm 0;          /* Spacing lebih generous */
    line-height: 1.5;        /* Line height optimal */
}
```

### 3. Perbaikan HTML Structure

**Sebelum:**
```html
<tr>
    <td>Nama Calon Siswa</td>
    <td>:</td>
    <td><?= $payment['nama_lengkap'] ?></td>
    <td style="width: 20%; text-align: right;">
        <strong>Asal Sekolah</strong>
    </td>
    <td style="width: 5%; text-align: center;">:</td>
    <td style="width: 30%;">
        <strong><?= $payment['asal_sekolah'] ?></strong>
    </td>
</tr>
<tr>
    <td>No. Pendaftaran</td>
    <td>:</td>
    <td><?= $payment['nomor_pendaftaran'] ?></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
```

**Sesudah:**
```html
<tr>
    <td>Nama Calon Siswa</td>
    <td>:</td>
    <td><?= $payment['nama_lengkap'] ?></td>
    <td>Asal Sekolah</td>
    <td>:</td>
    <td><?= $payment['asal_sekolah'] ?></td>
</tr>
<tr>
    <td>No. Pendaftaran</td>
    <td>:</td>
    <td colspan="4"><?= $payment['nomor_pendaftaran'] ?></td>
</tr>
```

**Perubahan:**
- ✅ Hapus inline style di HTML (konsisten dengan CSS)
- ✅ Hapus tag `<strong>` pada label "Asal Sekolah" (sudah di CSS)
- ✅ No. Pendaftaran menggunakan `colspan="4"` untuk span ke kanan
- ✅ Tidak ada cell kosong yang tidak perlu

## Hasil Akhir

**Sesudah:**
```
Nama Calon Siswa    :  John Doe            Asal Sekolah  :  SMP Negeri 1 Jakarta
No. Pendaftaran     :  PPDB-202512-0001
```

### Keunggulan:
✅ **Sejajar horizontal**: Semua text pada baris pertama aligned sempurna  
✅ **Width proporsional**: 24%-24%-24%-24% (balanced)  
✅ **Spacing konsisten**: Padding dan line-height optimal  
✅ **Clean HTML**: Tidak ada inline style yang override CSS  
✅ **Responsive**: Colspan pada No. Pendaftaran expand properly  

## Layout Visual

```
┌─────────────────────────────────────────────────────────────────┐
│  Nama Calon Siswa  :  John Doe        Asal Sekolah  :  SMP ...  │
│  No. Pendaftaran   :  PPDB-202512-0001                           │
└─────────────────────────────────────────────────────────────────┘

  24%        2%   24%              24%      2%      24%
  [Label]    :    [Value]          [Label]  :       [Value]
```

## File yang Diubah

1. ✅ `app/Views/bendahara/cetak_bukti_single.php`
   - CSS: Width kolom, vertical-align, padding, line-height
   - HTML: Remove inline styles, clean structure

2. ✅ `app/Views/payment/print_receipt.php`
   - CSS: Width kolom, vertical-align, padding, line-height
   - HTML: Remove inline styles, clean structure

## Testing Checklist

- [x] Visual check: Text sejajar horizontal
- [x] Visual check: Spacing proporsional
- [x] Visual check: Tidak ada overlap
- [x] Print test: Layout tetap rapi saat print
- [x] Responsive: Colspan berfungsi dengan baik
- [x] Validation: No PHP errors

## Perbandingan Detail

| Aspek | Sebelum | Sesudah | Improvement |
|-------|---------|---------|-------------|
| Width Balance | Tidak seimbang (28-35-15-18) | Seimbang (24-24-24-24) | ✅ Perfect balance |
| Vertical Align | `top` (tidak sejajar) | `middle` (sejajar) | ✅ Aligned |
| Inline Styles | Ada (inconsistent) | Tidak ada (clean) | ✅ Clean code |
| Padding | 0.8mm | 1mm | ✅ Better spacing |
| Line Height | 1.4 | 1.5 | ✅ More readable |
| Empty Cells | 3 cells kosong | 0 cells kosong | ✅ Clean HTML |

## Catatan Teknis

### Kenapa 24% untuk setiap kolom?
- Total ada 6 kolom: 4 data + 2 titik dua
- Data kolom: 24% x 4 = 96%
- Titik dua: 2% x 2 = 4%
- Total: 100% (perfect fit)

### Kenapa vertical-align: middle?
- Memastikan semua text pada baris yang sama sejajar horizontal
- Lebih baik untuk multi-line content
- Professional appearance

### Kenapa padding 1mm dan line-height 1.5?
- 1mm padding memberikan breathing room yang cukup
- Line-height 1.5 adalah standard untuk readability
- Balance antara compact dan readable

## Konsistensi

Perubahan ini diterapkan konsisten di:
- ✅ Bendahara cetak bukti single
- ✅ Payment print receipt
- ✅ CSS styling
- ✅ HTML structure

## Maintenance

Untuk perubahan di masa depan:
1. Gunakan CSS untuk styling, bukan inline style
2. Pertahankan width balance 24-24-24-24
3. Gunakan colspan untuk row yang tidak perlu 6 kolom
4. Test visual alignment setiap kali mengubah width

---
**Tanggal**: January 14, 2026  
**Status**: Completed ✅  
**Tested**: Visual + Print ✅  
**Zero Errors**: Validated ✅
