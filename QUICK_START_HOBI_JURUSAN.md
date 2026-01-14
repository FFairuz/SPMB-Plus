# Quick Start: Field Hobi dan Jurusan

## 🚀 Langkah Cepat Implementasi

### 1. Jalankan Migration

```bash
cd c:\xampp\htdocs\SPMB-Plus
php spark migrate
```

✅ **Expected Output:**
```
CodeIgniter v4.x Migrations

Running: 2026-01-19-000000_CreateMajorsTable
  Migration: 2026-01-19-000000_CreateMajorsTable ran successfully.

Running: 2026-01-19-000001_AddHobiAndJurusanToApplicantsDapodik
  Migration: 2026-01-19-000001_AddHobiAndJurusanToApplicantsDapodik ran successfully.

Migration completed successfully!
```

### 2. Cek Database

```sql
-- Cek tabel majors
SELECT * FROM majors;

-- Cek kolom baru di applicants_dapodik
DESCRIBE applicants_dapodik;
```

✅ **Expected:**
- Tabel `majors` ada dengan 4 data sample (TKJ, RPL, AKL, OTKP)
- Tabel `applicants_dapodik` memiliki kolom `hobi` dan `jurusan_id`

### 3. Test Management Jurusan (Admin)

**Login sebagai Admin:**
- URL: http://localhost/SPMB-Plus/public/admin/majors
- Test: Lihat, tambah, edit, hapus jurusan

**Contoh Tambah Jurusan Baru:**
- Kode: `MM` (otomatis jadi uppercase)
- Nama: `Multimedia`
- Deskripsi: `Program keahlian yang mempelajari tentang desain grafis, video editing, dan animasi.`
- Kuota: `36`
- Status: `Aktif`

### 4. Test Form Tambah Siswa

**Login sebagai Panitia atau Admin:**
- URL: http://localhost/SPMB-Plus/public/panitia/tambah-siswa

**Test Field Baru:**
1. **Field Hobi**: Isi dengan "Membaca, Olahraga, Musik"
2. **Field Jurusan**: Pilih salah satu jurusan (contoh: TKJ)
3. Submit form
4. Cek data tersimpan di database

### 5. Verify Data

```sql
-- Cek data siswa dengan jurusan
SELECT 
    a.nama_lengkap,
    a.hobi,
    m.kode_jurusan,
    m.nama_jurusan
FROM applicants_dapodik a
LEFT JOIN majors m ON a.jurusan_id = m.id
WHERE a.hobi IS NOT NULL OR a.jurusan_id IS NOT NULL
LIMIT 10;
```

---

## 🎯 Fitur Utama

### ✅ Field Hobi
- Textarea untuk menulis hobi/minat siswa
- **Opsional** (tidak wajib diisi)
- Validasi: Min 3 karakter jika diisi

### ✅ Field Jurusan
- Dropdown jurusan dari database
- **Wajib diisi**
- Menampilkan: Kode + Nama + Kuota
- Hanya menampilkan jurusan dengan status "Aktif"

### ✅ Management Jurusan (Admin)
- **CRUD Jurusan**: Create, Read, Update, Delete
- **Toggle Status**: Aktifkan/Nonaktifkan jurusan
- **Statistik**: Lihat jumlah pendaftar per jurusan
- **Kuota Management**: Set dan monitor kuota
- **Protection**: Tidak bisa hapus jurusan jika ada pendaftar

---

## 📋 URL Reference

| Role | Feature | URL |
|------|---------|-----|
| Admin | Kelola Jurusan | `/admin/majors` |
| Admin | Tambah Jurusan | `/admin/majors/create` |
| Admin | Edit Jurusan | `/admin/majors/edit/{id}` |
| Admin | Hapus Jurusan | `/admin/majors/delete/{id}` |
| Panitia | Tambah Siswa | `/panitia/tambah-siswa` |
| Admin | Tambah Siswa | `/admin/tambah-siswa` |

---

## 🐛 Common Issues

### ❌ Issue: "Table 'majors' doesn't exist"
**Fix:**
```bash
php spark migrate
```

### ❌ Issue: "Foreign key constraint fails"
**Fix:**
```bash
php spark migrate:rollback
php spark migrate
```

### ❌ Issue: Dropdown jurusan kosong
**Fix:**
1. Cek data di tabel `majors`: `SELECT * FROM majors WHERE status='aktif';`
2. Pastikan ada jurusan dengan status 'aktif'
3. Re-run migration jika perlu

### ❌ Issue: Tidak bisa hapus jurusan
**Note:** Ini normal jika ada pendaftar yang menggunakan jurusan tersebut.
**Alternative:** Nonaktifkan jurusan dengan mengubah status ke 'nonaktif'

---

## 📝 Testing Checklist

- [ ] Migration berhasil dijalankan
- [ ] Tabel `majors` ada dengan data sample
- [ ] Kolom `hobi` dan `jurusan_id` ada di `applicants_dapodik`
- [ ] Admin dapat akses `/admin/majors`
- [ ] Admin dapat tambah jurusan baru
- [ ] Admin dapat edit jurusan
- [ ] Admin dapat hapus jurusan (jika tidak ada pendaftar)
- [ ] Form tambah siswa menampilkan field hobi dan jurusan
- [ ] Dropdown jurusan menampilkan data dari database
- [ ] Data hobi dan jurusan tersimpan saat submit form
- [ ] Validasi field hobi dan jurusan berfungsi

---

## 💡 Tips

1. **Data Sample Otomatis**
   - Migration otomatis insert 4 jurusan sample (TKJ, RPL, AKL, OTKP)
   - Gunakan sebagai template untuk menambah jurusan lain

2. **Kode Jurusan Uppercase**
   - Input kode jurusan akan otomatis diubah ke uppercase
   - Contoh: input `tkj` → saved as `TKJ`

3. **Kuota Opsional**
   - Jika kuota tidak diisi, artinya tidak ada batasan
   - Cocok untuk jurusan dengan kapasitas fleksibel

4. **Status Aktif/Nonaktif**
   - Jurusan nonaktif tidak muncul di dropdown form
   - Gunakan untuk jurusan yang temporary tidak dibuka

5. **Statistik Real-time**
   - Halaman kelola jurusan menampilkan jumlah pendaftar real-time
   - Monitoring kuota dan sisa slot otomatis

---

## 📚 Documentation

Dokumentasi lengkap: `FIELD_HOBI_JURUSAN_IMPLEMENTATION.md`

---

**Created:** 2026-01-19  
**Version:** 1.0.0  
**Project:** SPMB-Plus
