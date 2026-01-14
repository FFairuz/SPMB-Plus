# 🔐 Daftar Akun Pengguna PPDB System

**Status:** ✅ Semua akun tersedia dan siap digunakan  
**Password Umum:** `password123` untuk semua akun

---

## 📋 Akun per Role

### 👤 ADMIN (1 akun)
| Email | Username | Status |
|-------|----------|--------|
| `admin@ppdb.local` | admin | ✅ Aktif |

**Akses:** Dashboard admin, kelola akun, kelola pembayaran, laporan  
**Navigasi:** `/admin/dashboard`

---

### 🏛️ PANITIA (1 akun)
| Email | Username | Status |
|-------|----------|--------|
| `panitia@ppdb.local` | panitia | ✅ Aktif |

**Akses:** Verifikasi siswa, lihat data pendaftar, laporan  
**Navigasi:** `/panitia/dashboard`

---

### 💰 BENDAHARA (1 akun)
| Email | Username | Status |
|-------|----------|--------|
| `bendahara@ppdb.local` | bendahara | ✅ Aktif |

**Akses:** Verifikasi pembayaran, input pembayaran offline, cetak kwitansi  
**Navigasi:** `/bendahara/dashboard`

---

### 📢 SALES (1 akun)
| Email | Username | Status |
|-------|----------|--------|
| `sales@ppdb.local` | sales | ✅ Aktif |

**Akses:** Lihat video promosi, brochure, informasi biaya  
**Navigasi:** `/sales/dashboard`

---

### 👨‍🎓 APPLICANT (6 akun)
| Email | Username | Status |
|-------|----------|--------|
| `john.doe@example.com` | john_doe | ✅ Aktif |
| `jane.smith@example.com` | jane_smith | ✅ Aktif |
| `michael.johnson@example.com` | michael_johnson | ✅ Aktif |
| `sarah.williams@example.com` | sarah_williams | ✅ Aktif |
| `thomas.brown@example.com` | thomas_brown | ✅ Aktif |
| *(generated)* | *(generated)* | ✅ Aktif |

**Akses:** Daftar, upload dokumen, bayar, lihat status  
**Navigasi:** `/applicant/dashboard`

---

## 🔑 Login Credentials

### Format
```
Email:    [email]
Password: password123
```

### Quick Copy-Paste
```
Admin:     admin@ppdb.local / password123
Panitia:   panitia@ppdb.local / password123
Bendahara: bendahara@ppdb.local / password123
Sales:     sales@ppdb.local / password123
Applicant: john.doe@example.com / password123
```

---

## 🌐 Login Page
```
URL: http://localhost:8080/auth/login
```

---

## 📊 Ringkasan
| Role | Count | Default Email |
|------|-------|----------------|
| Admin | 1 | admin@ppdb.local |
| Panitia | 1 | panitia@ppdb.local |
| Bendahara | 1 | bendahara@ppdb.local |
| Sales | 1 | sales@ppdb.local |
| Applicant | 6+ | john.doe@example.com |
| **TOTAL** | **9+** | - |

---

## ✅ Cara Menggunakan

### 1️⃣ Buka Login Page
```
http://localhost:8080/auth/login
```

### 2️⃣ Masukkan Email & Password
- Email dari tabel di atas
- Password: `password123`

### 3️⃣ Klik Login
Sistem akan mengarahkan ke dashboard sesuai role

### 4️⃣ Coba Fitur
- **Admin**: Kelola akun, dashboard, laporan
- **Panitia**: Verifikasi siswa, laporan
- **Bendahara**: Verifikasi pembayaran, cetak kwitansi
- **Sales**: Lihat konten promosi
- **Applicant**: Daftar, bayar, upload dokumen

---

## 🔒 Keamanan

✅ **Password Hashing:** Semua password di-hash dengan `PASSWORD_DEFAULT` (bcrypt)  
✅ **Enkripsi:** Tidak ada password plain text di database  
✅ **Session:** Menggunakan CodeIgniter session system  
✅ **CSRF Protection:** Token CSRF di semua form  

---

## 📝 Catatan

- Password `password123` hanya untuk development
- Untuk production, ubah password semua akun
- Akun-akun ini dapat diedit melalui Admin Panel
- Untuk menambah akun baru, gunakan form registrasi atau admin panel

---

**Created:** 14 Januari 2026  
**Status:** ✅ Production Ready
