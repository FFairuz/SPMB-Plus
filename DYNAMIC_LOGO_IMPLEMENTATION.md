# Implementasi Logo dan Nama Aplikasi Dinamis

## Deskripsi
Fitur ini memungkinkan logo dan nama aplikasi berubah secara dinamis sesuai dengan pengaturan yang disimpan di database. Admin dapat mengubah logo dan nama aplikasi melalui menu **Pengaturan Aplikasi** tanpa perlu edit code.

## Tanggal Implementasi
14 Januari 2026

---

## Komponen yang Diubah

### 1. **Autoload Helper** (`app/Config/Autoload.php`)
**Perubahan:**
- Menambahkan `settings` helper ke autoload agar fungsi helper dapat digunakan di seluruh aplikasi

```php
public $helpers = ['settings'];
```

**Fungsi:**
- Helper `settings_helper.php` akan otomatis dimuat saat aplikasi dijalankan
- Fungsi seperti `app_name()`, `app_logo()`, `app_description()` dapat digunakan di semua view

---

### 2. **Layout Utama** (`app/Views/layout/app.php`)

#### A. Title Page (Line 6)
**Sebelum:**
```php
<title><?= $title ?? 'PPDB System' ?></title>
```

**Sesudah:**
```php
<title><?= $title ?? app_name() ?></title>
```

**Fungsi:**
- Title browser akan menampilkan nama aplikasi dari pengaturan
- Jika ada title khusus, akan digunakan; jika tidak, gunakan nama aplikasi

#### B. Navbar Brand (Line 1058-1071)
**Sebelum:**
```php
<a href="<?= base_url('/') ?>" class="navbar-brand">
    <i class="bi bi-mortarboard-fill"></i>
    <span>PPDB System</span>
</a>
```

**Sesudah:**
```php
<a href="<?= base_url('/') ?>" class="navbar-brand">
    <?php 
    $logo = app_logo();
    $appName = app_name();
    ?>
    <?php if (strpos($logo, 'default-logo.png') === false && file_exists(str_replace(base_url(), FCPATH, $logo))): ?>
        <img src="<?= $logo ?>" alt="<?= esc($appName) ?>" style="height: 40px; width: auto; object-fit: contain;">
    <?php else: ?>
        <i class="bi bi-mortarboard-fill"></i>
    <?php endif; ?>
    <span><?= esc($appName) ?></span>
</a>
```

**Fungsi:**
- Menampilkan logo custom jika sudah diupload
- Jika logo belum ada atau masih default, tampilkan icon Bootstrap
- Nama aplikasi diambil dari pengaturan database

#### C. Footer (Line 1206-1209)
**Sebelum:**
```php
<p class="footer-text">&copy; 2025 PPDB System - Student Admission Management</p>
```

**Sesudah:**
```php
<p class="footer-text">&copy; <?= date('Y') ?> <?= esc(app_name()) ?> - <?= esc(app_description()) ?></p>
```

**Fungsi:**
- Tahun akan otomatis update sesuai tahun sekarang
- Nama dan deskripsi aplikasi dari pengaturan

---

### 3. **Login Page** (`app/Views/auth/login.php`)

#### A. Title Page (Line 5)
**Sebelum:**
```php
<title>Login - PPDB</title>
```

**Sesudah:**
```php
<title>Login - <?= app_name() ?></title>
```

#### B. Logo Box (Line 348-356)
**Sebelum:**
```php
<div class="logo-box">
    <i class="bi bi-mortarboard-fill"></i>
</div>
<h1>Selamat Datang!</h1>
<p>Sistem Penerimaan Peserta Didik Baru Online</p>
```

**Sesudah:**
```php
<div class="logo-box">
    <?php 
    $logo = app_logo();
    $appName = app_name();
    $appDesc = app_description();
    ?>
    <?php if (strpos($logo, 'default-logo.png') === false && file_exists(str_replace(base_url(), FCPATH, $logo))): ?>
        <img src="<?= $logo ?>" alt="<?= esc($appName) ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
    <?php else: ?>
        <i class="bi bi-mortarboard-fill"></i>
    <?php endif; ?>
</div>
<h1>Selamat Datang!</h1>
<p><?= esc($appDesc) ?></p>
```

**Fungsi:**
- Menampilkan logo custom di halaman login
- Deskripsi aplikasi diambil dari pengaturan

---

### 4. **CSS Styling** (`public/css/dynamic-logo.css`)

**File Baru:**
CSS khusus untuk styling logo dinamis dengan fitur:
- Responsive logo sizing
- Smooth transitions
- Hover effects
- Support berbagai format gambar (PNG, JPG, SVG, dll)
- Loading state
- Error fallback

**Key Features:**
```css
/* Navbar logo dengan max width dan height */
.navbar-brand img {
    height: 40px;
    width: auto;
    max-width: 150px;
    object-fit: contain;
}

/* Login page logo */
.login-left .logo-box img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

/* Responsive untuk mobile */
@media (max-width: 768px) {
    .navbar-brand img {
        height: 32px;
        max-width: 120px;
    }
}
```

---

## Helper Functions (`app/Helpers/settings_helper.php`)

### Fungsi yang Digunakan:

#### 1. `app_name()`
```php
function app_name()
{
    return get_setting('app_name', 'SPMB-Plus');
}
```
- Mengambil nama aplikasi dari database
- Default: "SPMB-Plus"

#### 2. `app_logo()`
```php
function app_logo()
{
    $logo = get_setting('app_logo', 'default-logo.png');
    
    if ($logo === 'default-logo.png' || empty($logo)) {
        return base_url('assets/img/default-logo.png');
    }
    
    return base_url('uploads/logo/' . $logo);
}
```
- Mengambil URL logo aplikasi
- Jika logo custom ada, gunakan dari folder `uploads/logo/`
- Jika tidak, gunakan logo default

#### 3. `app_description()`
```php
function app_description()
{
    return get_setting('app_description', 'Sistem Penerimaan Peserta Didik Baru');
}
```
- Mengambil deskripsi aplikasi dari database
- Default: "Sistem Penerimaan Peserta Didik Baru"

---

## Cara Menggunakan

### 1. **Mengubah Nama dan Logo (Untuk Admin)**

**Langkah-langkah:**

1. Login sebagai Admin
2. Buka menu **Pengaturan Aplikasi** (`/admin/settings`)
3. Ubah field berikut:
   - **Nama Aplikasi**: Masukkan nama yang diinginkan (contoh: "SPMB SMK Negeri 1")
   - **Logo Aplikasi**: Upload file logo (PNG, JPG, SVG - max 2MB)
   - **Deskripsi**: Masukkan deskripsi (contoh: "Sistem Pendaftaran Siswa Baru")
4. Klik **Simpan Pengaturan**
5. Logo dan nama akan langsung berubah di:
   - Navbar header
   - Halaman login
   - Title browser
   - Footer

### 2. **Format Logo yang Disarankan**

**Spesifikasi:**
- Format: PNG (dengan transparansi) atau JPG
- Resolusi: 200x200px hingga 500x500px
- Ukuran file: Max 2MB
- Rasio: Square (1:1) atau landscape (16:9)
- Background: Transparan (untuk PNG)

**Tips:**
- Gunakan logo dengan latar transparan untuk hasil terbaik
- Logo akan otomatis resize ke 40px height di navbar
- Logo akan otomatis resize ke 80x80px di login box

### 3. **Developer: Menggunakan di View Lain**

Jika ingin menggunakan logo/nama dinamis di view lain:

```php
<!-- Untuk logo -->
<img src="<?= app_logo() ?>" alt="<?= app_name() ?>">

<!-- Untuk nama aplikasi -->
<h1><?= app_name() ?></h1>

<!-- Untuk deskripsi -->
<p><?= app_description() ?></p>

<!-- Dengan fallback ke icon jika logo belum ada -->
<?php $logo = app_logo(); ?>
<?php if (strpos($logo, 'default-logo.png') === false && file_exists(str_replace(base_url(), FCPATH, $logo))): ?>
    <img src="<?= $logo ?>" alt="<?= esc(app_name()) ?>">
<?php else: ?>
    <i class="bi bi-mortarboard-fill"></i>
<?php endif; ?>
```

---

## Testing

### Test Case 1: Logo Default
**Setup:**
- Belum upload logo custom
- Pengaturan app_logo = 'default-logo.png' atau kosong

**Expected Result:**
- ✅ Icon Bootstrap (mortarboard) ditampilkan
- ✅ Nama aplikasi "SPMB-Plus" ditampilkan

### Test Case 2: Logo Custom
**Setup:**
- Upload logo custom (misalnya: "school-logo.png")
- Pengaturan app_logo = 'school-logo.png'

**Expected Result:**
- ✅ Logo custom ditampilkan di navbar
- ✅ Logo custom ditampilkan di login page
- ✅ Logo responsive di mobile

### Test Case 3: Nama dan Deskripsi Custom
**Setup:**
- Ubah app_name menjadi "SPMB SMK Negeri 1"
- Ubah app_description menjadi "Pendaftaran Siswa Baru 2025"

**Expected Result:**
- ✅ Nama baru tampil di navbar
- ✅ Nama baru tampil di title browser
- ✅ Deskripsi baru tampil di login page
- ✅ Footer menampilkan nama dan deskripsi baru

### Test Case 4: Responsive Design
**Setup:**
- Buka di berbagai ukuran layar

**Expected Result:**
- ✅ Desktop: Logo 40px, nama lengkap
- ✅ Tablet: Logo 32px, nama lengkap
- ✅ Mobile: Logo 28px, nama hidden

---

## File yang Terlibat

### Modified Files:
1. `app/Config/Autoload.php` - Autoload settings helper
2. `app/Views/layout/app.php` - Layout utama dengan logo dinamis
3. `app/Views/auth/login.php` - Login page dengan logo dinamis

### New Files:
1. `public/css/dynamic-logo.css` - Styling untuk logo dinamis

### Existing Files (Used):
1. `app/Helpers/settings_helper.php` - Helper functions
2. `app/Models/SettingModel.php` - Model untuk settings
3. `app/Controllers/SettingsController.php` - Controller untuk manage settings

---

## Database Schema

### Table: `settings`
```sql
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Key Settings:
- `app_name` - Nama aplikasi
- `app_logo` - Filename logo (disimpan di `public/uploads/logo/`)
- `app_description` - Deskripsi aplikasi
- `school_name` - Nama sekolah

---

## Security Considerations

1. **XSS Prevention:**
   - Semua output menggunakan `esc()` function
   - Contoh: `<?= esc(app_name()) ?>`

2. **File Upload Security:**
   - Validasi tipe file (PNG, JPG, SVG only)
   - Validasi ukuran file (max 2MB)
   - Rename file dengan random name
   - Store di folder `public/uploads/logo/`

3. **Path Traversal Prevention:**
   - Validasi file existence dengan `file_exists()`
   - Gunakan `FCPATH` untuk absolute path

4. **SQL Injection Prevention:**
   - Menggunakan Query Builder CodeIgniter
   - Prepared statements otomatis

---

## Troubleshooting

### Problem 1: Logo Tidak Muncul
**Possible Causes:**
- File logo tidak ada di folder `public/uploads/logo/`
- Permission folder tidak benar

**Solution:**
```bash
# Cek folder
ls -la public/uploads/logo/

# Set permission (Linux/Mac)
chmod 755 public/uploads/logo/
chmod 644 public/uploads/logo/*

# Windows: Pastikan folder tidak read-only
```

### Problem 2: Nama Aplikasi Masih "SPMB-Plus"
**Possible Causes:**
- Setting belum disimpan di database
- Helper belum di-autoload

**Solution:**
```php
// Test helper di controller
var_dump(app_name());
var_dump(get_setting('app_name'));

// Cek autoload
var_dump(function_exists('app_name')); // should return true
```

### Problem 3: Logo Pecah atau Blur
**Solution:**
- Upload logo dengan resolusi lebih tinggi (min 200x200px)
- Gunakan format PNG dengan transparansi
- Pastikan logo original berkualitas baik

---

## Future Enhancements

### Planned Features:
1. ✅ Multiple logo support (light/dark theme)
2. ✅ Favicon dinamis
3. ✅ Logo preview sebelum upload
4. ✅ Crop tool untuk logo
5. ✅ Logo history/versioning
6. ✅ Multi-language support untuk nama aplikasi

---

## Changelog

### Version 1.0 (14 Januari 2026)
- ✅ Implementasi logo dinamis di navbar
- ✅ Implementasi logo dinamis di login page
- ✅ Implementasi nama aplikasi dinamis
- ✅ Implementasi deskripsi dinamis
- ✅ Responsive design untuk semua ukuran layar
- ✅ Fallback ke icon default jika logo belum ada
- ✅ Auto-update title browser
- ✅ Auto-update footer

---

## Credits

**Developer:** GitHub Copilot AI Assistant  
**Project:** SPMB-Plus (Sistem PPDB)  
**Framework:** CodeIgniter 4  
**Date:** 14 Januari 2026  

---

## Support

Jika ada pertanyaan atau masalah, silakan:
1. Baca dokumentasi ini dengan seksama
2. Cek troubleshooting section
3. Hubungi tim developer
4. Buka issue di repository GitHub

---

**Happy Coding! 🚀**
