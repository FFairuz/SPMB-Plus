# Change No. Registrasi to Sequential Number

## 📋 Overview
Kolom "No. Registrasi" di tabel applicants diubah menjadi nomor urut sederhana (1, 2, 3...) untuk menghindari "N/A" dan lebih mudah dibaca.

---

## 🔧 Changes

### File: `app/Views/admin/applicants.php`

#### ❌ Before:
```php
<th class="py-3 px-4 fw-semibold">
    <i class="bi bi-hash text-primary me-1"></i> No. Registrasi
</th>
...
<?php foreach ($applicants as $applicant): ?>
    <td class="px-4">
        <span class="badge bg-light text-dark border">
            <?= $applicant['nomor_pendaftaran'] ?? 'N/A'; ?>
        </span>
    </td>
```

**Issues:**
- Menampilkan nomor pendaftaran lengkap (SPMB-2025-001)
- Jika tidak ada, muncul "N/A"
- Kolom terlalu lebar untuk format panjang

#### ✅ After:
```php
<th class="py-3 px-4 fw-semibold text-center" style="width: 60px;">
    <i class="bi bi-hash text-primary me-1"></i> No
</th>
...
<?php foreach ($applicants as $index => $applicant): ?>
    <td class="px-4 text-center">
        <span class="badge bg-light text-dark border fw-bold">
            <?= $index + 1 ?>
        </span>
    </td>
```

**Improvements:**
- ✅ Menampilkan nomor urut sederhana (1, 2, 3...)
- ✅ Tidak ada "N/A" lagi
- ✅ Kolom lebih compact (width: 60px)
- ✅ Text center untuk alignment yang rapi
- ✅ Bold untuk emphasis

---

## 🎨 Visual Comparison

### Before:
```
+------------------+------------------+
| No. Registrasi   | Nama Lengkap     |
+------------------+------------------+
| SPMB-2025-001   | Ahmad Fauzi      |
| N/A             | Budi Santoso     |
| SPMB-2025-003   | Citra Dewi       |
+------------------+------------------+
```

### After:
```
+-----+------------------+
| No  | Nama Lengkap     |
+-----+------------------+
|  1  | Ahmad Fauzi      |
|  2  | Budi Santoso     |
|  3  | Citra Dewi       |
+-----+------------------+
```

---

## ✅ Benefits

### 1. **No More N/A**
- Tidak ada lagi "N/A" yang membingungkan
- Setiap row punya nomor unik

### 2. **Cleaner UI**
- Lebih simple dan clean
- Tidak perlu space besar untuk nomor panjang
- Better readability

### 3. **Sequential Order**
- Mudah untuk counting (berapa banyak data)
- Clear order dari top to bottom
- User-friendly untuk reference

### 4. **Space Efficiency**
- Kolom lebih sempit (60px)
- Lebih banyak space untuk kolom penting lainnya
- Better responsive layout

---

## 📊 Use Cases

### 1. Counting Records
```
User: "Berapa banyak pendaftar di halaman ini?"
Answer: Lihat nomor terakhir (misal: 25)
```

### 2. Reference Specific Row
```
Admin: "Cek data nomor 5"
Clear reference tanpa perlu lihat nomor pendaftaran panjang
```

### 3. Pagination Context
```
Page 1: 1-10
Page 2: 11-20
Page 3: 21-30
```

---

## 🎯 Implementation Details

### PHP Logic
```php
<?php foreach ($applicants as $index => $applicant): ?>
    <?= $index + 1 ?>
<?php endforeach; ?>
```

**Notes:**
- `$index` starts from 0
- `$index + 1` converts to 1-based numbering
- Works with array automatically

### CSS Styling
```html
<th class="text-center" style="width: 60px;">No</th>
<td class="text-center">
    <span class="badge bg-light text-dark border fw-bold">1</span>
</td>
```

**Styling:**
- `text-center`: Center alignment
- `width: 60px`: Fixed narrow width
- `badge`: Visual emphasis
- `fw-bold`: Bold font for clarity

---

## ⚠️ Considerations

### Pagination
Jika ada pagination, nomor akan reset setiap halaman:
- Page 1: 1, 2, 3...
- Page 2: 1, 2, 3... (reset)

**Solution (Optional):**
```php
$offset = ($currentPage - 1) * $perPage;
<?= $offset + $index + 1 ?>
```

### Sorting
Jika data di-sort, nomor tetap sequential (bukan ID database).

### Filtering
Nomor akan disesuaikan dengan filtered results.

---

## 🧪 Testing

### Test Case 1: Empty Result
```
Result: No rows shown (table empty state)
No "N/A" akan muncul
```

### Test Case 2: Single Record
```
Result: Tampil nomor "1"
Clean dan jelas
```

### Test Case 3: Multiple Records
```
Result: 1, 2, 3, 4, 5...
Sequential dari atas ke bawah
```

---

## 📝 Alternative Options

### Option 1: Show Both (Number + Registration Number)
```php
<td>
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-primary"><?= $index + 1 ?></span>
        <small class="text-muted"><?= $applicant['nomor_pendaftaran'] ?? '-' ?></small>
    </div>
</td>
```

### Option 2: Show Registration Number on Hover
```php
<td class="text-center" title="<?= $applicant['nomor_pendaftaran'] ?? 'Belum ada' ?>">
    <?= $index + 1 ?>
</td>
```

### Option 3: Conditional Display
```php
<?php if (!empty($applicant['nomor_pendaftaran'])): ?>
    <?= $applicant['nomor_pendaftaran'] ?>
<?php else: ?>
    <?= $index + 1 ?>
<?php endif; ?>
```

---

## ✅ Status: IMPLEMENTED

**Changes Complete!** 🎉

- ✅ Header changed: "No. Registrasi" → "No"
- ✅ Display sequential number instead of registration number
- ✅ Remove "N/A" fallback
- ✅ Add center alignment
- ✅ Set fixed width (60px)
- ✅ No PHP errors

**File Modified:** `app/Views/admin/applicants.php`

**Result:** Clean, simple, no more "N/A"!
