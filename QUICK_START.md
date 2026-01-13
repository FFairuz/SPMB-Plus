# 🚀 QUICK START - MENU KELOLA AKUN

## ⚡ 5 Menit Setup

### Step 1: Login sebagai Admin
```
URL: http://localhost:8080/auth/login
Email: admin@ppdb.local
Password: password123
```

### Step 2: Akses Menu Kelola Akun
- **Opsi 1:** Klik menu "👤 Kelola Akun" di sidebar (bagian MANAJEMEN)
- **Opsi 2:** Direct URL: `http://localhost:8080/admin/kelola-akun`

### Step 3: Kelola User
```
📊 Daftar User
  ├─ Lihat semua user yang terdaftar
  ├─ Pagination otomatis
  └─ Status aktif/nonaktif

➕ Tambah User Baru
  ├─ Klik tombol "Tambah User Baru"
  ├─ Isi form lengkap
  ├─ Pilih role yang sesuai
  └─ Klik "Simpan User Baru"

✏️ Edit User
  ├─ Klik tombol Edit (pensil)
  ├─ Update informasi
  ├─ Password optional
  └─ Klik "Simpan Perubahan"

🗑️ Hapus User
  ├─ Klik tombol Hapus (trash)
  ├─ Konfirmasi di modal
  └─ User akan dihapus
```

## 📋 Fungsi Utama

### 1️⃣ LIHAT DAFTAR USER
**URL:** `/admin/kelola-akun`

Menampilkan:
- ✅ Semua user dengan info lengkap
- ✅ Pagination (15 user/halaman)
- ✅ Role badge berwarna
- ✅ Status aktif/nonaktif
- ✅ Tanggal terdaftar
- ✅ Tombol Action

### 2️⃣ TAMBAH USER BARU
**URL:** `/admin/tambah-akun`

Form fields:
```
📝 Informasi Dasar
  - Username (min 3 char, unik)
  - Email (valid, unik)
  - Nama Lengkap
  - Role (Admin/Panitia/Bendahara/Applicant)

🔐 Password
  - Password (min 6 char)
  - Konfirmasi Password
  - Toggle show/hide

⚙️ Opsi
  - Status Aktif (checkbox)
```

### 3️⃣ EDIT USER
**URL:** `/admin/edit-akun/{id}`

Update:
- Username (must be unique)
- Email (must be unique)
- Nama
- Role
- Password (optional)
- Status aktif/nonaktif

### 4️⃣ HAPUS USER
**URL:** `/admin/hapus-akun/{id}`

Fitur:
- ✅ Konfirmasi modal
- ✅ Proteksi akun sendiri
- ✅ No recovery (permanent delete)

## 🎯 Role Penjelasan

| Role | Tugas | Akses |
|------|-------|-------|
| **Admin** 🔴 | Kelola pembayaran & aplikasi | Full sistem |
| **Panitia** 🔵 | Kelola data siswa | Verifikasi pendaftar |
| **Bendahara** 🟢 | Verifikasi pembayaran | Kwitansi & laporan |
| **Applicant** ⚫ | Pendaftar siswa | Dashboard pribadi |
| **Sales** (optional) | Info sekolah | Video, brosur, biaya |

## 💻 Contoh Penggunaan

### ✅ Tambah Admin Baru

1. Klik "Tambah User Baru"
2. Isi form:
   ```
   Username: admin2
   Email: admin2@ppdb.local
   Nama: Admin Kedua
   Role: Admin
   Password: admin@123456
   Confirm: admin@123456
   Status: ☑ Aktif
   ```
3. Klik "Simpan User Baru"
4. ✅ User berhasil ditambah

### ✅ Tambah Panitia

1. Klik "Tambah User Baru"
2. Isi form:
   ```
   Username: panitia1
   Email: panitia@ppdb.local
   Nama: Panitia PPDB
   Role: Panitia
   Password: panitia@123456
   Confirm: panitia@123456
   Status: ☑ Aktif
   ```
3. Klik "Simpan User Baru"

### ✅ Update User

1. Klik tombol Edit pada user
2. Update data yang diperlukan
3. Password hanya update jika diisi baru
4. Klik "Simpan Perubahan"

### ✅ Nonaktifkan User

1. Edit user
2. Uncheck "User Aktif"
3. Klik "Simpan Perubahan"
4. User tidak bisa login lagi

## ⚠️ PENTING

### ❌ Jangan Lakukan

```
❌ Menghapus akun admin sendiri
❌ Menggunakan password yang mudah
❌ Memberikan email yang sama untuk 2 user
❌ Menggunakan username duplikat
❌ Login dengan akun bukan admin
```

### ✅ Lakukan

```
✅ Gunakan password kuat (min 6 char, lebih baik 8+)
✅ Gunakan email yang valid
✅ Pilih role sesuai tanggung jawab
✅ Pastikan user aktif jika ingin login
✅ Backup password di tempat aman
```

## 🔒 Keamanan

- ✅ Password di-hash dengan algoritma aman
- ✅ Username & email unique (tidak duplikat)
- ✅ CSRF token protection
- ✅ Input validation lengkap
- ✅ Akun sendiri tidak bisa dihapus

## 📞 Troubleshooting

### ❓ Sidebar tidak muncul
**A:** Pastikan sudah login sebagai admin

### ❓ Menu Kelola Akun tidak ada
**A:** Reload halaman atau clear cache browser (Ctrl+Shift+Del)

### ❓ Tidak bisa menambah user
**A:** 
- Pastikan email & username tidak sudah dipakai
- Password minimal 6 karakter
- Semua field required terisi

### ❓ Lupa password admin
**A:** 
- Reset via database atau admin lain
- Hubungi developer untuk password recovery

## 📊 Menu Navigation

Sidebar Admin:
```
DASHBOARD
└─ 📊 Dashboard

APLIKASI
├─ 📋 Daftar Pendaftar
├─ 💳 Verifikasi Pembayaran  
└─ 👤 Daftar Pendaftar Manual

MANAJEMEN
└─ 👥 Kelola Akun        ← DISINI!

AKUN
└─ 🚪 Logout
```

## 🎓 File Penting

```
📁 app/
├── Controllers/
│   └── AdminController.php (method: kelolaAkun, tambahAkun, editAkun, hapusAkun)
├── Models/
│   └── User.php
├── Views/
│   ├── layout/
│   │   ├── app.php (LAYOUT UTAMA BARU)
│   │   └── admin_sidebar.php (SIDEBAR ADMIN BARU)
│   └── admin/
│       ├── kelola_akun.php
│       ├── tambah_akun.php
│       └── edit_akun.php
└── Config/
    └── Routes.php (routes sudah ada)

📄 MENU_KELOLA_AKUN.md (dokumentasi lengkap)
📄 KELOLA_AKUN_SUMMARY.md (ringkasan fitur)
📄 QUICK_START.md (file ini)
```

## 🚀 Akses Cepat

```
Login Admin:
http://localhost:8080/auth/login

Dashboard:
http://localhost:8080/admin/dashboard

Kelola Akun:
http://localhost:8080/admin/kelola-akun

Tambah User:
http://localhost:8080/admin/tambah-akun

Edit User (ID=2):
http://localhost:8080/admin/edit-akun/2

Hapus User (ID=2):
http://localhost:8080/admin/hapus-akun/2
```

## ✅ Checklist Verifikasi

- [ ] Aplikasi berjalan di http://localhost:8080
- [ ] Bisa login dengan admin@ppdb.local / password123
- [ ] Sidebar muncul setelah login
- [ ] Menu "Kelola Akun" ada di sidebar
- [ ] Bisa lihat daftar user
- [ ] Bisa tambah user baru
- [ ] Bisa edit user
- [ ] Bisa hapus user (dengan konfirmasi)
- [ ] Flash message muncul untuk feedback
- [ ] Validasi form berfungsi

## 🎉 SELESAI!

Menu Kelola Akun sudah siap digunakan. Nikmati! 🎊

---

**Pertanyaan?** Lihat dokumentasi lengkap di `MENU_KELOLA_AKUN.md`
