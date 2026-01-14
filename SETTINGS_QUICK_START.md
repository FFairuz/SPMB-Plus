# 🚀 Quick Start - Settings Feature

## Setup dalam 3 Langkah

### 1️⃣ Jalankan Database Migration
```bash
php spark migrate
```
✅ Ini akan membuat tabel `settings` dengan data default

### 2️⃣ Buat Folder Upload
```bash
mkdir -p public/uploads/logo
chmod 777 public/uploads/logo
```
✅ Folder untuk menyimpan logo yang diupload

### 3️⃣ Akses Settings
- Login sebagai **Admin**
- Klik menu **"Pengaturan Aplikasi"** di sidebar
- Atau buka: `http://localhost/SPMB-Plus/admin/settings`

---

## 📝 Cara Menggunakan

### Mengganti Logo
1. Klik tombol **"Pilih Logo Baru"**
2. Pilih file gambar (JPG/PNG/GIF, max 2MB)
3. Preview akan muncul otomatis
4. Klik **"Simpan Perubahan"**

### Mengubah Nama Aplikasi
1. Edit field **"Nama Aplikasi"**
2. Klik **"Simpan Perubahan"**

### Mengisi Info Sekolah
1. Isi form **Nama Sekolah**, **Alamat**, **Telepon**, **Email**
2. Klik **"Simpan Perubahan"**

### Reset Logo ke Default
1. Klik tombol **"Reset ke Default"** di bawah preview logo
2. Konfirmasi action
3. Logo akan kembali ke default

---

## 🔧 Menggunakan Settings di Kode

### Load Helper
```php
helper('settings');
```

### Contoh Penggunaan
```php
// Di Controller atau View
echo app_name();           // Output: SPMB-Plus
echo app_logo();           // Output: URL logo
echo school_name();        // Output: Sekolah ABC
echo app_description();    // Output: Sistem Penerimaan...

// Custom setting
$email = get_setting('school_email', 'default@email.com');
```

### Dalam View (Sidebar/Header)
```php
<div class="logo-area">
    <img src="<?= app_logo() ?>" alt="Logo">
    <h1><?= app_name() ?></h1>
</div>
```

---

## 🎯 Features

✅ Upload logo custom  
✅ Preview real-time  
✅ Auto-delete logo lama  
✅ Reset ke default  
✅ Update nama aplikasi  
✅ Update info sekolah  
✅ Validasi file & form  
✅ Responsive design  
✅ Helper functions  
✅ API endpoints  

---

## 📱 API Usage

```javascript
// Get single setting
fetch('/admin/settings/api/app_name')
    .then(res => res.json())
    .then(data => console.log(data.value));

// Get all settings
fetch('/admin/settings/api')
    .then(res => res.json())
    .then(data => console.log(data.settings));
```

---

## 🐛 Troubleshooting

### Logo tidak bisa diupload?
```bash
# Fix permissions
chmod 777 public/uploads/logo
```

### Settings tidak tersimpan?
```bash
# Check migration
php spark migrate:status

# Re-run migration jika perlu
php spark migrate:refresh
```

### Error 404?
Pastikan routes sudah ditambahkan di `app/Config/Routes.php`

---

## 📖 Dokumentasi Lengkap
Lihat: `SETTINGS_FEATURE_DOCUMENTATION.md`

---

**Ready to use!** 🎉
