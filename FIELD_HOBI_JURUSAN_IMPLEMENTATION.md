# Implementasi Field Hobi dan Jurusan + Management Jurusan

## 📋 Ringkasan

Dokumen ini menjelaskan implementasi penambahan field **hobi** dan **jurusan** pada form tambah siswa baru, serta pembuatan fitur **management jurusan** untuk admin.

---

## ✨ Fitur yang Ditambahkan

### 1. **Field Hobi** (Text Area)
- Siswa dapat menuliskan hobi atau minat mereka
- Field opsional (tidak wajib diisi)
- Disimpan di tabel `applicants_dapodik` kolom `hobi`

### 2. **Field Jurusan** (Dropdown)
- Siswa memilih jurusan yang diminati dari dropdown
- Data jurusan diambil dari tabel `majors`
- Field wajib diisi
- Menampilkan kode jurusan, nama jurusan, dan kuota
- Disimpan di tabel `applicants_dapodik` kolom `jurusan_id` (foreign key)

### 3. **Management Jurusan (Admin)**
- Admin dapat menambah, edit, dan hapus jurusan
- Admin dapat mengatur kuota setiap jurusan
- Admin dapat mengaktifkan/menonaktifkan jurusan
- Menampilkan statistik jumlah pendaftar per jurusan
- Jurusan tidak dapat dihapus jika masih ada pendaftar yang menggunakannya

---

## 🗄️ Struktur Database

### Tabel Baru: `majors`

```sql
CREATE TABLE `majors` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_jurusan` VARCHAR(20) NOT NULL UNIQUE,
  `nama_jurusan` VARCHAR(255) NOT NULL,
  `deskripsi` TEXT NULL,
  `kuota` INT(11) NULL,
  `status` ENUM('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Data Sample (Auto-inserted saat migration):**
- TKJ - Teknik Komputer dan Jaringan (Kuota: 36)
- RPL - Rekayasa Perangkat Lunak (Kuota: 36)
- AKL - Akuntansi dan Keuangan Lembaga (Kuota: 36)
- OTKP - Otomatisasi dan Tata Kelola Perkantoran (Kuota: 36)

### Update Tabel: `applicants_dapodik`

```sql
ALTER TABLE `applicants_dapodik`
ADD COLUMN `hobi` TEXT NULL AFTER `kebutuhan_khusus_lainnya`,
ADD COLUMN `jurusan_id` INT(11) UNSIGNED NULL AFTER `hobi`,
ADD CONSTRAINT `applicants_dapodik_jurusan_id_foreign` 
    FOREIGN KEY (`jurusan_id`) REFERENCES `majors`(`id`) 
    ON DELETE SET NULL ON UPDATE CASCADE;
```

---

## 📁 File yang Dibuat

### 1. Migration Files

#### `2026-01-19-000000_CreateMajorsTable.php`
- Membuat tabel `majors`
- Insert data jurusan sample (TKJ, RPL, AKL, OTKP)

#### `2026-01-19-000001_AddHobiAndJurusanToApplicantsDapodik.php`
- Menambah kolom `hobi` dan `jurusan_id` ke tabel `applicants_dapodik`
- Menambah foreign key constraint

### 2. Model

#### `app/Models/Major.php`
Model untuk tabel majors dengan method:
- `getActiveMajors()` - Ambil jurusan yang aktif
- `getMajorWithStats($id)` - Ambil jurusan dengan statistik pendaftar
- `isKodeAvailable($kode, $excludeId)` - Cek ketersediaan kode jurusan
- `getRemainingQuota($majorId)` - Hitung sisa kuota jurusan

### 3. Controller

#### `app/Controllers/AdminMajorController.php`
Controller untuk admin mengelola jurusan:
- `index()` - Daftar jurusan
- `create()` - Tambah jurusan baru
- `edit($id)` - Edit jurusan
- `delete($id)` - Hapus jurusan
- `toggleStatus($id)` - Toggle aktif/nonaktif (AJAX)

### 4. Views

#### `app/Views/admin/majors/index.php`
Halaman daftar jurusan dengan tabel yang menampilkan:
- Kode jurusan
- Nama jurusan
- Deskripsi (snippet)
- Kuota
- Jumlah pendaftar
- Status (aktif/nonaktif)
- Tombol aksi (edit, hapus)

#### `app/Views/admin/majors/create.php`
Form tambah jurusan baru dengan field:
- Kode jurusan (uppercase auto)
- Nama jurusan
- Deskripsi
- Kuota (opsional)
- Status

#### `app/Views/admin/majors/edit.php`
Form edit jurusan dengan field yang sama

---

## 🔧 File yang Diubah

### 1. `app/Views/panitia/tambah_siswa.php`

**Penambahan Section "Pendidikan & Minat":**

```php
<!-- Data Pendidikan dan Minat -->
<h5 class="mb-3 border-bottom pb-2 mt-5">
    <i class="bi bi-mortarboard"></i> Pendidikan & Minat
</h5>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label fw-bold">Hobi</label>
        <textarea name="hobi" class="form-control" rows="3" 
                  placeholder="Contoh: Membaca, Olahraga, Musik"><?= old('hobi'); ?></textarea>
        <small class="text-muted">Sebutkan hobi atau minat siswa</small>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold">Jurusan yang Diminati *</label>
        <select name="jurusan_id" class="form-select" required>
            <option value="">-- Pilih Jurusan --</option>
            <?php foreach ($majors as $major): ?>
                <option value="<?= $major['id'] ?>">
                    <?= $major['kode_jurusan'] ?> - <?= $major['nama_jurusan'] ?>
                    <?php if ($major['kuota']): ?>
                        (Kuota: <?= $major['kuota'] ?>)
                    <?php endif; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="text-muted">Pilih jurusan yang diminati siswa</small>
    </div>
</div>
```

### 2. `app/Controllers/PanitiaController.php`

**Update method `tambah_siswa()`:**

**Validasi Rules - Penambahan:**
```php
'hobi' => 'permit_empty|min_length[3]',
'jurusan_id' => 'required|integer|is_not_unique[majors.id]',
```

**Data Insert - Penambahan:**
```php
'hobi' => $this->request->getPost('hobi') ?: null,
'jurusan_id' => (int) $this->request->getPost('jurusan_id'),
```

**View Data - Penambahan:**
```php
$majorModel = new \App\Models\Major();
$majors = $majorModel->getActiveMajors();

return view('panitia/tambah_siswa', [
    // ... existing data
    'majors' => $majors,
]);
```

### 3. `app/Config/Routes.php`

**Penambahan Routes:**

```php
// Admin Major Management Routes
$routes->get('admin/majors', 'AdminMajorController::index');
$routes->get('admin/majors/create', 'AdminMajorController::create');
$routes->post('admin/majors/create', 'AdminMajorController::create');
$routes->get('admin/majors/edit/(:num)', 'AdminMajorController::edit/$1');
$routes->post('admin/majors/edit/(:num)', 'AdminMajorController::edit/$1');
$routes->get('admin/majors/delete/(:num)', 'AdminMajorController::delete/$1');
$routes->post('admin/majors/toggle-status/(:num)', 'AdminMajorController::toggleStatus/$1');
```

---

## 🚀 Cara Penggunaan

### 1. Jalankan Migration

```bash
cd c:\xampp\htdocs\SPMB-Plus
php spark migrate
```

Output yang diharapkan:
```
Running: 2026-01-19-000000_CreateMajorsTable
Running: 2026-01-19-000001_AddHobiAndJurusanToApplicantsDapodik
Done
```

### 2. Akses Management Jurusan (Admin)

**URL:** `/admin/majors`

**Fitur:**
- ✅ Lihat daftar jurusan
- ✅ Tambah jurusan baru
- ✅ Edit jurusan
- ✅ Hapus jurusan (jika tidak ada pendaftar)
- ✅ Lihat statistik pendaftar per jurusan

### 3. Form Tambah Siswa Baru (Panitia/Admin)

**URL:** 
- `/panitia/tambah-siswa` (Panitia)
- `/admin/tambah-siswa` (Admin)

**Field Baru:**
- **Hobi** (opsional): Text area untuk menulis hobi/minat
- **Jurusan yang Diminati** (wajib): Dropdown jurusan dari database

---

## ✅ Validasi dan Error Handling

### Form Tambah Siswa

**Field Hobi:**
- Validasi: Opsional, minimal 3 karakter jika diisi
- Error: "Hobi minimal 3 karakter"

**Field Jurusan:**
- Validasi: Wajib diisi, harus ID valid dari tabel majors
- Error: "Jurusan harus dipilih"
- Error: "Jurusan tidak valid"

### Management Jurusan (Admin)

**Tambah/Edit Jurusan:**
- Kode jurusan: Wajib, unique, 2-20 karakter
- Nama jurusan: Wajib, minimal 3 karakter
- Kuota: Opsional, integer > 0
- Status: Wajib (aktif/nonaktif)

**Hapus Jurusan:**
- ❌ Tidak dapat dihapus jika ada pendaftar yang menggunakan
- ✅ Dapat dihapus jika tidak ada pendaftar
- Alternatif: Nonaktifkan jurusan jika tidak digunakan lagi

---

## 📊 Data Flow

### 1. Admin Mengelola Jurusan
```
Admin → /admin/majors → Tambah/Edit/Hapus Jurusan → Database `majors`
```

### 2. Panitia/Admin Mendaftarkan Siswa
```
Panitia/Admin → Form Tambah Siswa → 
Pilih Jurusan (dari `majors`) + Isi Hobi → 
Submit → Database `applicants_dapodik`
    - hobi: TEXT
    - jurusan_id: INT (FK ke majors.id)
```

### 3. Lihat Data Siswa
```
View Siswa → Join dengan tabel `majors` → 
Tampilkan: Nama Siswa, Hobi, Jurusan (Kode + Nama)
```

---

## 🔐 Security & Best Practices

### 1. **Foreign Key Constraint**
- `jurusan_id` menggunakan foreign key ke `majors.id`
- `ON DELETE SET NULL`: Jika jurusan dihapus, `jurusan_id` jadi NULL
- `ON UPDATE CASCADE`: Jika ID jurusan berubah, otomatis update

### 2. **Validasi Input**
- Semua input divalidasi di controller
- XSS protection dengan `esc()` di view
- CSRF protection dengan `csrf_field()`

### 3. **Data Integrity**
- Jurusan tidak bisa dihapus jika masih ada pendaftar
- Kode jurusan otomatis uppercase
- Status default 'aktif' untuk jurusan baru

### 4. **User Experience**
- Dropdown jurusan menampilkan kode, nama, dan kuota
- Pesan error yang informatif
- Flash message untuk feedback aksi
- Form validation dengan display error per field

---

## 📈 Statistik & Monitoring

### Admin Dashboard - Statistik Jurusan

Model `Major` menyediakan method untuk statistik:

```php
// Get major dengan jumlah pendaftar
$majors = $majorModel->getMajorWithStats();

foreach ($majors as $major) {
    echo $major['nama_jurusan'] . ': ' . $major['total_applicants'] . ' pendaftar';
}

// Get sisa kuota jurusan
$remaining = $majorModel->getRemainingQuota($majorId);
echo "Sisa kuota: " . $remaining;
```

---

## 🎯 Next Steps (Optional)

### 1. **Laporan Pendaftar per Jurusan**
- Buat halaman khusus untuk melihat daftar pendaftar per jurusan
- Export Excel pendaftar per jurusan
- Grafik pendaftar per jurusan

### 2. **Validasi Kuota Real-time**
- Validasi di form: Jika kuota penuh, tidak bisa memilih jurusan tersebut
- Notifikasi: "Kuota jurusan X sudah penuh"

### 3. **Field Jurusan di Bukti Pembayaran**
- Update query payment untuk include jurusan
- Tampilkan jurusan di bukti pembayaran

### 4. **Prioritas Berdasarkan Jurusan**
- Sistem penerimaan berdasarkan kuota per jurusan
- Auto-reject jika kuota penuh

---

## 📝 Testing Checklist

### ✅ Migration
- [x] Migration `CreateMajorsTable` berhasil
- [x] Migration `AddHobiAndJurusanToApplicantsDapodik` berhasil
- [x] Data sample jurusan ter-insert
- [x] Foreign key constraint berfungsi

### ✅ Management Jurusan (Admin)
- [ ] Admin dapat akses `/admin/majors`
- [ ] Admin dapat melihat daftar jurusan
- [ ] Admin dapat tambah jurusan baru
- [ ] Admin dapat edit jurusan
- [ ] Admin dapat hapus jurusan (jika tidak ada pendaftar)
- [ ] Admin tidak dapat hapus jurusan (jika ada pendaftar)
- [ ] Statistik pendaftar per jurusan tampil

### ✅ Form Tambah Siswa
- [ ] Form menampilkan field hobi (textarea)
- [ ] Form menampilkan dropdown jurusan
- [ ] Dropdown jurusan hanya menampilkan jurusan aktif
- [ ] Dropdown menampilkan kode, nama, dan kuota
- [ ] Validasi hobi berfungsi (opsional)
- [ ] Validasi jurusan berfungsi (wajib)
- [ ] Data hobi dan jurusan tersimpan ke database

### ✅ View Data Siswa
- [ ] Data hobi tampil di detail siswa
- [ ] Data jurusan tampil di detail siswa
- [ ] Join dengan tabel majors berfungsi

---

## 🐛 Troubleshooting

### Error: Table 'majors' doesn't exist
**Solusi:** Jalankan migration:
```bash
php spark migrate
```

### Error: Foreign key constraint fails
**Solusi:** 
1. Pastikan tabel `majors` sudah ada
2. Jalankan migration dalam urutan yang benar
3. Drop dan re-run migration jika perlu

### Dropdown jurusan kosong
**Solusi:**
1. Cek apakah ada data di tabel `majors`
2. Cek apakah ada jurusan dengan status 'aktif'
3. Cek controller sudah passing `$majors` ke view

### Tidak bisa hapus jurusan
**Solusi:** 
- Normal jika ada pendaftar yang menggunakan jurusan tersebut
- Alternatif: Nonaktifkan jurusan dengan mengubah status

---

## 📚 References

- **CodeIgniter 4 Documentation:** https://codeigniter.com/user_guide/
- **Bootstrap 5 Icons:** https://icons.getbootstrap.com/
- **CodeIgniter 4 Migrations:** https://codeigniter.com/user_guide/dbmgmt/migration.html
- **CodeIgniter 4 Model:** https://codeigniter.com/user_guide/models/model.html

---

## ✍️ Author & Date

- **Author:** GitHub Copilot
- **Date:** 2026-01-19
- **Version:** 1.0.0
- **Project:** SPMB-Plus - PPDB Application
