# Menu Kelola Akun - PPDB System

## 📋 Deskripsi Fitur

Menu **Kelola Akun** adalah fitur manajemen pengguna yang memungkinkan administrator untuk:
- ✅ Melihat daftar semua pengguna dengan pagination
- ✅ Menambah pengguna baru dengan berbagai role
- ✅ Mengedit data pengguna yang sudah ada
- ✅ Menghapus pengguna (dengan proteksi untuk menghindari menghapus akun sendiri)
- ✅ Mengatur status aktif/nonaktif pengguna
- ✅ Filter berdasarkan role dan status

## 🎯 Fitur Utama

### 1. Daftar Pengguna (Halaman Kelola Akun)
**URL:** `/admin/kelola-akun`

Menampilkan tabel lengkap semua pengguna dengan informasi:
- Username
- Email
- Nama Lengkap
- Role (Admin, Panitia, Bendahara, Applicant)
- Status Aktif/Nonaktif
- Tanggal Terdaftar
- Tombol Action (Edit & Hapus)

**Fitur:**
- Pagination otomatis (15 user per halaman)
- Validasi untuk mencegah penghapusan akun sendiri
- Flash message untuk feedback sukses/error
- Interface responsif dengan Bootstrap 5

### 2. Tambah User Baru
**URL:** `/admin/tambah-akun`

Formulir lengkap untuk membuat pengguna baru dengan:
- **Informasi Dasar:**
  - Username (min 3 karakter, unik)
  - Email (valid email, unik)
  - Nama Lengkap
  - Role/Jabatan (Admin, Panitia, Bendahara, Applicant)

- **Password:**
  - Password (min 6 karakter)
  - Konfirmasi Password
  - Toggle visibility untuk password

- **Opsi Lainnya:**
  - Status Aktif (checkbox)

**Validasi:**
- Username harus unik
- Email harus valid dan unik
- Password minimal 6 karakter
- Password confirm harus sesuai
- Role harus dipilih dari list yang tersedia

### 3. Edit User
**URL:** `/admin/edit-akun/{id}`

Memungkinkan admin untuk update data user dengan:
- Edit username, email, nama, role
- Update password (optional - hanya update jika diisi)
- Toggle status aktif/nonaktif
- Validasi unique pada username & email (exclude user saat ini)

### 4. Hapus User
**URL:** `/admin/hapus-akun/{id}`

Fitur penghapusan dengan proteksi:
- Konfirmasi dengan modal dialog
- Proteksi untuk tidak menghapus akun sendiri
- Flash message untuk feedback

## 🛠️ Implementasi Teknis

### Controller Methods
File: `app/Controllers/AdminController.php`

```php
// Menampilkan daftar user
public function kelolaAkun()

// Menambah user baru
public function tambahAkun()

// Edit user
public function editAkun($id)

// Hapus user
public function hapusAkun($id)
```

### Routes
File: `app/Config/Routes.php`

```php
$routes->get('admin/kelola-akun', 'AdminController::kelolaAkun');
$routes->get('admin/tambah-akun', 'AdminController::tambahAkun');
$routes->post('admin/tambah-akun', 'AdminController::tambahAkun');
$routes->get('admin/edit-akun/(:num)', 'AdminController::editAkun/$1');
$routes->post('admin/edit-akun/(:num)', 'AdminController::editAkun/$1');
$routes->get('admin/hapus-akun/(:num)', 'AdminController::hapusAkun/$1');
```

### Views
- `app/Views/admin/kelola_akun.php` - Halaman daftar pengguna
- `app/Views/admin/tambah_akun.php` - Form tambah pengguna
- `app/Views/admin/edit_akun.php` - Form edit pengguna

### Layout
- `app/Views/layout/app.php` - Layout utama dengan sidebar
- `app/Views/layout/admin_sidebar.php` - Sidebar khusus admin dengan menu kelola akun

## 📱 Sidebar Admin

Menu Kelola Akun tersedia di sidebar admin dengan navigasi:

```
DASHBOARD
├─ Dashboard

APLIKASI  
├─ Daftar Pendaftar
├─ Verifikasi Pembayaran
└─ Daftar Pendaftar Manual

MANAJEMEN
└─ 👤 Kelola Akun  ← MENU BARU

AKUN
└─ Logout
```

## 🔐 Keamanan

1. **Autentikasi:** Hanya admin yang dapat mengakses menu kelola akun
2. **Validasi Input:**
   - Username & email harus unik
   - Password minimal 6 karakter
   - Validasi format email
3. **Proteksi Akun:**
   - Tidak bisa menghapus akun sendiri
   - Konfirmasi sebelum menghapus
4. **Password Hashing:**
   - Menggunakan `password_hash()` dengan PASSWORD_DEFAULT
   - Verifikasi dengan `password_verify()`
5. **CSRF Protection:**
   - Semua form POST dilindungi dengan CSRF token

## 📊 Role dan Permissions

| Role | Akses Kelola Akun |
|------|-------------------|
| Admin | ✅ Penuh (CRUD) |
| Panitia | ❌ Tidak |
| Bendahara | ❌ Tidak |
| Applicant | ❌ Tidak |
| Sales | ❌ Tidak |

## 📝 Tips Penggunaan

### Saat Menambah User
1. Gunakan username yang mudah diingat
2. Pilih role sesuai tanggung jawab:
   - **Admin:** Kelola pembayaran & aplikasi
   - **Panitia:** Kelola data siswa
   - **Bendahara:** Verifikasi & kwitansi
   - **Applicant:** Calon siswa yang mendaftar
3. Password minimal 6 karakter (rekomendasikan password kuat)
4. Pastikan email valid dan unik

### Saat Mengedit User
- Username & email hanya bisa diubah jika tidak ada di user lain
- Password bersifat optional - hanya update jika ingin ganti password
- Role bisa diubah kapan saja

### Saat Menghapus User
- Hati-hati! Penghapusan tidak bisa dibatalkan
- User yang dihapus tidak bisa di-recovery
- Akun sendiri tidak bisa dihapus

## 🎨 UI/UX Features

1. **Responsive Design:** Mobile-friendly interface
2. **Icons:** Font Awesome icons untuk visual clarity
3. **Color Coded Roles:**
   - Danger (Red) - Admin
   - Info (Blue) - Panitia
   - Success (Green) - Bendahara
   - Secondary (Gray) - Applicant
4. **Pagination:** Navigasi mudah untuk banyak user
5. **Flash Messages:** Feedback instant untuk setiap action
6. **Modal Confirmation:** Konfirmasi sebelum delete
7. **Password Toggle:** Show/hide password saat input

## 🚀 Akses Menu

### Dari Sidebar Admin
1. Login sebagai admin
2. Lihat sidebar di sebelah kiri
3. Klik menu **"👤 Kelola Akun"** di bagian MANAJEMEN

### Direct URL
- Daftar: `http://localhost:8080/admin/kelola-akun`
- Tambah: `http://localhost:8080/admin/tambah-akun`
- Edit: `http://localhost:8080/admin/edit-akun/{id}`

## 📊 Database Schema

Tabel `users`:
```sql
id INT PRIMARY KEY
username VARCHAR(100) UNIQUE NOT NULL
email VARCHAR(100) UNIQUE NOT NULL
password VARCHAR(255) NOT NULL
nama VARCHAR(255)
role ENUM('admin', 'panitia', 'bendahara', 'applicant', 'sales')
is_active TINYINT(1) DEFAULT 1
created_at TIMESTAMP
updated_at TIMESTAMP
```

## ⚡ Troubleshooting

### Masalah: Layout tidak muncul sidebar
**Solusi:** Pastikan menggunakan `<?= $this->extend('layout/app') ?>` di awal view

### Masalah: Login tidak masuk ke admin
**Solusi:** Pastikan akun memiliki role = 'admin' di database

### Masalah: Validasi email/username tidak berfungsi
**Solusi:** Cek tabel users sudah sesuai dengan database migration

## 📞 Support

Untuk bantuan lebih lanjut, hubungi tim development atau cek dokumentasi CodeIgniter 4 di https://codeigniter.com/user_guide/
