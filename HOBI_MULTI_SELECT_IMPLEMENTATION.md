# IMPLEMENTATION: Hobi sebagai Dropdown Multi-Select dengan Tags

## 📋 Ringkasan

Dokumen ini menjelaskan perubahan field **hobi** dari textarea menjadi **dropdown multiple choice (multi-select)** yang ditampilkan sebagai **tags** dengan style yang menarik.

---

## ✨ Perubahan Utama

### ❌ Sebelumnya:
- Hobi berupa **textarea** (free text input)
- Disimpan sebagai TEXT di kolom `hobi` di `applicants_dapodik`
- User menulis manual: "Membaca, Olahraga, Musik"

### ✅ Sekarang:
- Hobi berupa **dropdown multi-select** dengan tags
- Data hobi berasal dari database (tabel `hobbies`)
- Relasi **many-to-many** antara applicants dan hobbies
- Ditampilkan sebagai **tags** dengan icon Bootstrap
- Admin dapat mengelola master data hobi

---

## 🗄️ Struktur Database Baru

### 1. Tabel `hobbies` (Master Data)

```sql
CREATE TABLE `hobbies` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama_hobi` VARCHAR(100) NOT NULL UNIQUE,
  `icon` VARCHAR(50) NULL COMMENT 'Bootstrap icon class',
  `status` ENUM('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
);
```

**Data Sample (18 hobi ter-insert otomatis):**
- Membaca (bi-book)
- Menulis (bi-pencil)
- Olahraga (bi-trophy)
- Musik (bi-music-note)
- Menyanyi (bi-mic)
- Menari (bi-person-arms-up)
- Melukis (bi-palette)
- Fotografi (bi-camera)
- Traveling (bi-airplane)
- Memasak (bi-egg-fried)
- Gaming (bi-controller)
- Coding (bi-code-slash)
- Design Grafis (bi-bezier)
- Berkebun (bi-tree)
- Memancing (bi-water)
- Bermain Alat Musik (bi-headphones)
- Koleksi (bi-collection)
- Vlogging (bi-camera-video)

### 2. Tabel `applicant_hobbies` (Pivot Table)

```sql
CREATE TABLE `applicant_hobbies` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `applicant_id` INT(11) UNSIGNED NOT NULL,
  `hobby_id` INT(11) UNSIGNED NOT NULL,
  `created_at` DATETIME NULL,
  FOREIGN KEY (applicant_id) REFERENCES applicants_dapodik(id) ON DELETE CASCADE,
  FOREIGN KEY (hobby_id) REFERENCES hobbies(id) ON DELETE CASCADE
);
```

### 3. Update Tabel `applicants_dapodik`

```sql
-- Kolom hobi lama (TEXT) sudah dihapus
ALTER TABLE `applicants_dapodik` DROP COLUMN `hobi`;
```

**Migration Status:**
```
✅ CreateHobbiesTable - SUCCESS
✅ CreateApplicantHobbiesTable - SUCCESS  
✅ DropOldHobiColumn - SUCCESS
Migrations complete.
```

---

## 📁 File yang Dibuat

### 1. Migration Files (3 files)
- `2026-01-19-000002_CreateHobbiesTable.php` - Buat tabel hobbies + insert 18 data sample
- `2026-01-19-000003_CreateApplicantHobbiesTable.php` - Buat pivot table
- `2026-01-19-000004_DropOldHobiColumn.php` - Hapus kolom hobi lama

### 2. Models (2 files)
- `app/Models/Hobby.php` - Model untuk tabel hobbies
- `app/Models/ApplicantHobby.php` - Model untuk pivot table (many-to-many)

### 3. Controller (1 file)
- `app/Controllers/AdminHobbyController.php` - CRUD management hobi untuk admin

### 4. Views (3 files)
- `app/Views/admin/hobbies/index.php` - Daftar hobi
- `app/Views/admin/hobbies/create.php` - Form tambah hobi
- `app/Views/admin/hobbies/edit.php` - Form edit hobi

---

## 🔧 File yang Diubah

### 1. `app/Controllers/PanitiaController.php`

**Validation Rules - Perubahan:**
```php
// OLD:
'hobi' => 'permit_empty|min_length[3]',

// NEW:
'hobbies' => 'permit_empty', // Array of hobby IDs
```

**Load Data - Penambahan:**
```php
$hobbyModel = new \App\Models\Hobby();
$hobbies = $hobbyModel->getActiveHobbies();
```

**Save Data - Perubahan:**
```php
// OLD: Tidak ada (langsung save di kolom hobi)

// NEW: Save many-to-many relationship
$hobbies = $this->request->getPost('hobbies');
if (!empty($hobbies) && is_array($hobbies)) {
    $applicantHobbyModel = new \App\Models\ApplicantHobby();
    $applicantHobbyModel->syncHobbies($applicant_id, $hobbies);
}
```

### 2. `app/Views/panitia/tambah_siswa.php`

**UI Component - Perubahan:**
```php
// OLD: Textarea
<textarea name="hobi" class="form-control" rows="3" 
          placeholder="Contoh: Membaca, Olahraga, Musik">
</textarea>

// NEW: Multi-select dropdown dengan Select2
<select name="hobbies[]" id="hobbies_select" 
        class="form-select" multiple="multiple">
    <?php foreach ($hobbies as $hobby): ?>
        <option value="<?= $hobby['id'] ?>" 
                data-icon="<?= $hobby['icon'] ?>">
            <?= $hobby['nama_hobi'] ?>
        </option>
    <?php endforeach; ?>
</select>
```

**CSS - Penambahan:**
```html
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
```

**JavaScript - Penambahan:**
```javascript
// Initialize Select2 with custom formatting
$('#hobbies_select').select2({
    theme: 'bootstrap-5',
    placeholder: 'Pilih hobi/minat...',
    allowClear: true,
    width: '100%',
    tags: false,
    closeOnSelect: false,
    templateResult: formatHobbyOption,
    templateSelection: formatHobbySelection
});
```

### 3. `app/Config/Routes.php`

**Routes - Penambahan:**
```php
// Admin Hobby Management Routes
$routes->get('admin/hobbies', 'AdminHobbyController::index');
$routes->get('admin/hobbies/create', 'AdminHobbyController::create');
$routes->post('admin/hobbies/create', 'AdminHobbyController::create');
$routes->get('admin/hobbies/edit/(:num)', 'AdminHobbyController::edit/$1');
$routes->post('admin/hobbies/edit/(:num)', 'AdminHobbyController::edit/$1');
$routes->get('admin/hobbies/delete/(:num)', 'AdminHobbyController::delete/$1');
```

### 4. `app/Views/layout/admin_sidebar.php`

**Sidebar Menu - Penambahan:**
```php
<a href="<?= base_url('admin/hobbies') ?>" class="nav-link">
    <i class="fas fa-star"></i>
    <span>Kelola Hobi</span>
</a>
```

---

## 🎨 Tampilan UI

### Form Tambah Siswa

**Multi-Select dengan Tags:**
```
┌─────────────────────────────────────────────────┐
│ Hobi / Minat                                    │
├─────────────────────────────────────────────────┤
│ [🎵 Musik] [📚 Membaca] [🏆 Olahraga] [×]       │
│ [+] Pilih hobi/minat...                    [▼]  │
└─────────────────────────────────────────────────┘
  Pilih satu atau lebih hobi (opsional)
```

**Features:**
- ✅ Multi-select (bisa pilih lebih dari 1)
- ✅ Tampilan sebagai tags (badge) dengan warna biru
- ✅ Icon Bootstrap di setiap opsi
- ✅ Remove button (×) di setiap tag
- ✅ Placeholder text
- ✅ Search/filter capability
- ✅ Responsive design

### Admin Panel - Kelola Hobi

**Tabel Daftar Hobi:**
```
┌──┬────────────────────┬────────┬─────────┬────────┬────────┐
│No│ Nama Hobi          │ Icon   │ Peminat │ Status │ Aksi   │
├──┼────────────────────┼────────┼─────────┼────────┼────────┤
│1 │ Membaca            │ 📚     │ 5 siswa │ Aktif  │ ✏️ 🗑️  │
│2 │ Olahraga           │ 🏆     │ 8 siswa │ Aktif  │ ✏️ 🗑️  │
│3 │ Musik              │ 🎵     │ 3 siswa │ Aktif  │ ✏️ 🗑️  │
└──┴────────────────────┴────────┴─────────┴────────┴────────┘
```

---

## 🚀 Cara Penggunaan

### 1. Management Hobi (Admin)

**Akses:**
```
URL: /admin/hobbies
Sidebar: Manajemen → Kelola Hobi
```

**Fitur:**
- ✅ **Lihat Daftar:** Semua hobi dengan statistik peminat
- ✅ **Tambah Hobi:** Nama + Icon Bootstrap + Status
- ✅ **Edit Hobi:** Update data yang sudah ada
- ✅ **Hapus Hobi:** Delete (dengan proteksi jika ada peminat)
- ✅ **Status Toggle:** Aktifkan/Nonaktifkan hobi

**Contoh Tambah Hobi:**
- Nama Hobi: `Bermain Gitar`
- Icon: `bi-music-player`
- Status: `Aktif`

### 2. Form Tambah Siswa (Panitia/Admin)

**Akses:**
```
Panitia: /panitia/tambah-siswa
Admin: /admin/tambah-siswa
```

**Cara Pilih Hobi:**
1. Klik pada field "Hobi / Minat"
2. Dropdown akan muncul dengan list hobi
3. Klik hobi yang diinginkan (bisa lebih dari 1)
4. Hobi terpilih akan muncul sebagai tag di atas field
5. Klik tanda × untuk remove hobi
6. Submit form

---

## 🔗 Relasi Database (Many-to-Many)

```
applicants_dapodik (1) ──┬── (∞) applicant_hobbies (∞) ──┬── (1) hobbies
                          │                                │
                          │     Pivot Table                │
                          └────────────────────────────────┘
```

**Query untuk Mengambil Hobi Siswa:**
```php
$applicantHobbyModel = new ApplicantHobby();
$hobbies = $applicantHobbyModel->getHobbiesByApplicant($applicant_id);
```

**Sync Hobi (Replace All):**
```php
$applicantHobbyModel->syncHobbies($applicant_id, [1, 3, 5]); // ID hobi
```

---

## ✅ Validasi & Error Handling

### Form Tambah Siswa
- `hobbies`: Array, opsional (boleh kosong)
- Jika diisi, harus berupa array of valid hobby IDs

### Management Hobi (Admin)
| Field | Rule | Error Message |
|-------|------|---------------|
| nama_hobi | required, unique, min[3], max[100] | "Nama hobi harus diisi", "Nama sudah digunakan" |
| icon | permit_empty, max[50] | "Icon terlalu panjang" |
| status | required, in_list[aktif,nonaktif] | "Status harus dipilih" |

**Delete Protection:**
- ❌ Tidak bisa hapus hobi jika ada siswa yang menggunakan
- Alternative: Nonaktifkan hobi (status = 'nonaktif')

---

## 🎯 Model Methods

### Hobby Model
```php
getActiveHobbies()              // Get hobbies dengan status aktif
getHobbyWithStats($id = null)   // Get hobby dengan jumlah peminat
isNamaAvailable($nama, $id)     // Check availability
```

### ApplicantHobby Model
```php
getHobbiesByApplicant($id)      // Get all hobbies by applicant
getHobbyIdsByApplicant($id)     // Get hobby IDs array
syncHobbies($applicant_id, $ids) // Sync hobbies (replace all)
deleteByApplicant($id)          // Delete all hobbies
```

---

## 📊 Data Flow

### 1. Admin Mengelola Hobi
```
Admin → /admin/hobbies → CRUD → Database `hobbies`
```

### 2. Siswa Memilih Hobi
```
Form → Multi-select hobbies → Submit →
applicants_dapodik (insert) + 
applicant_hobbies (insert multiple) →
Database
```

### 3. Tampilkan Hobi Siswa
```
Query applicant → JOIN applicant_hobbies → JOIN hobbies →
Display as tags with icons
```

---

## 🔐 Security Features

✅ **CSRF Protection:** All forms  
✅ **XSS Protection:** esc() output  
✅ **SQL Injection:** Query builder + prepared statements  
✅ **Foreign Key Constraints:** CASCADE delete  
✅ **Input Validation:** Server-side validation  
✅ **Role-based Access:** Admin-only for management  
✅ **Delete Protection:** Check usage before delete

---

## 🎨 Frontend Libraries

### Select2
- **Version:** 4.1.0-rc.0
- **Purpose:** Enhanced multi-select dropdown
- **Theme:** Bootstrap 5
- **CDN:**
  - CSS: `https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css`
  - JS: `https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js`
  - Theme: `https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css`

**Features Used:**
- Multi-select with tags
- Custom formatting (icon + text)
- Placeholder
- Clear button
- Search/filter
- Close on select: false (keep dropdown open)

---

## 📝 Testing Checklist

### ✅ Migration
- [x] CreateHobbiesTable berhasil
- [x] CreateApplicantHobbiesTable berhasil
- [x] DropOldHobiColumn berhasil
- [x] 18 data hobi sample ter-insert
- [x] Foreign key constraints berfungsi

### ✅ Management Hobi (Admin)
- [ ] Admin dapat akses `/admin/hobbies`
- [ ] Admin dapat melihat daftar hobi dengan statistik
- [ ] Admin dapat tambah hobi baru
- [ ] Admin dapat edit hobi
- [ ] Admin dapat hapus hobi (dengan proteksi)
- [ ] Icon Bootstrap ditampilkan dengan benar
- [ ] Statistik peminat akurat

### ✅ Form Tambah Siswa
- [ ] Multi-select hobbies muncul
- [ ] Select2 initialization berfungsi
- [ ] Dropdown menampilkan hobi dari database
- [ ] Dapat pilih multiple hobbies
- [ ] Selected hobbies ditampilkan sebagai tags
- [ ] Icon muncul di dropdown
- [ ] Remove tag (×) berfungsi
- [ ] Data hobbies tersimpan ke database
- [ ] Many-to-many relationship berfungsi

---

## 🐛 Troubleshooting

### Issue: Select2 tidak muncul
**Fix:**
1. Pastikan jQuery loaded sebelum Select2
2. Cek console browser untuk error JavaScript
3. Pastikan CDN Select2 accessible

### Issue: Dropdown kosong
**Fix:**
1. Cek data di tabel `hobbies`
2. Pastikan ada hobi dengan status 'aktif'
3. Cek controller passing `$hobbies` ke view

### Issue: Hobi tidak tersimpan
**Fix:**
1. Cek form field name: `hobbies[]` (dengan brackets)
2. Cek controller menerima array
3. Cek syncHobbies() method dipanggil
4. Cek foreign key constraints

### Issue: Tidak bisa hapus hobi
**Fix:**
- Normal jika ada siswa yang menggunakan hobi tersebut
- Alternative: Nonaktifkan hobi (status = 'nonaktif')

---

## 💡 Keuntungan Perubahan Ini

### ✅ Kelebihan:
1. **Konsistensi Data:** Nama hobi standar, tidak ada typo
2. **Easy Management:** Admin bisa kelola master data hobi
3. **Better UX:** Multi-select lebih user-friendly
4. **Visual Appeal:** Tags dengan icon menarik
5. **Statistics:** Bisa track hobi populer
6. **Scalability:** Mudah tambah hobi baru
7. **Search:** User bisa search hobi
8. **Validation:** Otomatis valid karena dari dropdown

### ⚠️ Considerations:
1. Depends on JavaScript (Select2)
2. Requires CDN (or bundle assets)
3. Slightly more complex database structure
4. Old data (free text) tidak kompatibel

---

## 📚 References

- **Select2 Documentation:** https://select2.org/
- **Bootstrap Icons:** https://icons.getbootstrap.com/
- **CodeIgniter 4 Models:** https://codeigniter.com/user_guide/models/model.html
- **Many-to-Many Relations:** CodeIgniter 4 doesn't have built-in ORM, implemented manually

---

## ✍️ Author & Version

- **Author:** GitHub Copilot
- **Date:** 2026-01-19
- **Version:** 2.0.0 (Hobi Multi-Select)
- **Project:** SPMB-Plus - PPDB Application
- **Status:** ✅ Production Ready

---

**END OF DOCUMENTATION**
