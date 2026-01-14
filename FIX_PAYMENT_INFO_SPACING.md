# Fix Payment Info Spacing - Bukti Pembayaran

## Masalah
Spacing pada bagian "Jenis Pembayaran" dan "Metode Pembayaran" tidak sejajar dengan bagian atas karena menggunakan struktur tabel yang berbeda (3 kolom vs 6 kolom).

## Screenshot Masalah

**Sebelum:**
```
Nama Calon Siswa    :  John Doe            Asal Sekolah  :  SMP Negeri 1 Jakarta
No. Pendaftaran     :  PPDB-202512-0001

Jenis Pembayaran    :  Lunas
Metode Pembayaran   :  Transfer Bank - Tunai
```

Problem: Label "Jenis Pembayaran" dan "Metode Pembayaran" tidak sejajar dengan "Nama Calon Siswa" karena table structure yang berbeda.

## Solusi

### Struktur Tabel yang Konsisten

**Sebelum:**
```html
<!-- Tabel 1: 6 kolom -->
<table class="info-table">
    <tr>
        <td>Nama Calon Siswa</td>
        <td>:</td>
        <td>John Doe</td>
        <td>Asal Sekolah</td>
        <td>:</td>
        <td>SMP Negeri 1 Jakarta</td>
    </tr>
</table>

<!-- Tabel 2: HANYA 3 kolom - TIDAK SEJAJAR! -->
<table class="info-table">
    <tr>
        <td>Jenis Pembayaran</td>
        <td>:</td>
        <td>Lunas</td>  <!-- Tidak ada colspan -->
    </tr>
</table>
```

**Sesudah:**
```html
<!-- Tabel 1: 6 kolom -->
<table class="info-table">
    <tr>
        <td>Nama Calon Siswa</td>
        <td>:</td>
        <td>John Doe</td>
        <td>Asal Sekolah</td>
        <td>:</td>
        <td>SMP Negeri 1 Jakarta</td>
    </tr>
</table>

<!-- Tabel 2: SAMA 6 kolom dengan colspan - SEJAJAR! -->
<table class="info-table">
    <tr>
        <td>Jenis Pembayaran</td>
        <td>:</td>
        <td colspan="4">Lunas</td>  <!-- colspan="4" untuk span ke kanan -->
    </tr>
</table>
```

## Perubahan Detail

### Jenis Pembayaran Row
```html
<!-- Sebelum -->
<td>
    <?php
    // PHP code...
    ?>
</td>

<!-- Sesudah -->
<td colspan="4">
    <?php
    // PHP code...
    ?>
</td>
```

### Metode Pembayaran Row
```html
<!-- Sebelum -->
<td>
    <?php
    // PHP code...
    ?>
</td>

<!-- Sesudah -->
<td colspan="4">
    <?php
    // PHP code...
    ?>
</td>
```

## Penjelasan Teknis

### Mengapa colspan="4"?

Struktur tabel 6 kolom:
1. **Kolom 1**: Label (24%)
2. **Kolom 2**: Titik dua : (2%)
3. **Kolom 3**: Value (24%)
4. **Kolom 4**: Label kanan (24%)
5. **Kolom 5**: Titik dua : (2%)
6. **Kolom 6**: Value kanan (24%)

Untuk Jenis Pembayaran dan Metode Pembayaran:
- Kolom 1: Label
- Kolom 2: Titik dua :
- **Kolom 3-6**: Value dengan `colspan="4"` (24% + 24% + 2% + 24% = 74%)

Total width tetap konsisten dengan row di atas!

## Hasil Akhir

**Sesudah:**
```
Nama Calon Siswa    :  John Doe            Asal Sekolah  :  SMP Negeri 1 Jakarta
No. Pendaftaran     :  PPDB-202512-0001

Jenis Pembayaran    :  Lunas
Metode Pembayaran   :  Transfer Bank - Tunai
```

### Layout Visual

```
┌─────────────────────────────────────────────────────────────────┐
│  Nama Calon Siswa  :  John Doe        Asal Sekolah  :  SMP ...  │
│  No. Pendaftaran   :  PPDB-202512-0001                           │
│                                                                   │
│  Jenis Pembayaran  :  Lunas                                      │
│  Metode Pembayaran :  Transfer Bank - Tunai                      │
└─────────────────────────────────────────────────────────────────┘
    24%        2%   24%              24%      2%      24%
    [Label]    :    [──────────── Value colspan=4 ────────────]
```

## Keunggulan

✅ **Alignment Konsisten**: Semua label sejajar vertikal  
✅ **Spacing Uniform**: Jarak label ke value sama di semua baris  
✅ **Table Structure**: Semua tabel menggunakan 6 kolom yang konsisten  
✅ **Professional Look**: Tampilan rapi dan terstruktur  
✅ **Easy to Read**: Informasi mudah dibaca dan dipindai  

## File yang Diubah

1. ✅ `app/Views/bendahara/cetak_bukti_single.php`
   - Tambah `colspan="4"` pada Jenis Pembayaran value
   - Tambah `colspan="4"` pada Metode Pembayaran value

2. ✅ `app/Views/payment/print_receipt.php`
   - Tambah `colspan="4"` pada Jenis Pembayaran value
   - Tambah `colspan="4"` pada Metode Pembayaran value

## Perbandingan

| Aspek | Sebelum | Sesudah | Status |
|-------|---------|---------|--------|
| Table Columns | Tabel 1: 6 cols, Tabel 2: 3 cols | Semua: 6 cols | ✅ Fixed |
| Label Alignment | Tidak sejajar | Sejajar vertikal | ✅ Fixed |
| Value Width | 24% (narrow) | 74% (colspan=4) | ✅ Fixed |
| Spacing | Inconsistent | Consistent | ✅ Fixed |

## Testing Checklist

- [x] Visual check: Semua label sejajar vertikal
- [x] Visual check: Spacing konsisten
- [x] Visual check: Value tidak terpotong
- [x] Print test: Layout tetap rapi saat print
- [x] Validation: No PHP errors
- [x] Consistency: Sama di bendahara & payment view

## Catatan

### Best Practice untuk Table Layout:
1. **Konsisten column structure**: Semua tabel dalam satu section harus punya jumlah kolom yang sama
2. **Gunakan colspan**: Untuk cells yang perlu span lebih dari 1 kolom
3. **Maintain alignment**: Pastikan semua label di kolom pertama aligned
4. **Test visual**: Selalu check visual alignment setelah perubahan

### Formula Colspan:
```
Total columns = 6
Columns used = 2 (label + colon)
Colspan needed = 6 - 2 = 4
```

---
**Tanggal**: January 14, 2026  
**Status**: Completed ✅  
**Tested**: Visual + Print ✅  
**Zero Errors**: Validated ✅
