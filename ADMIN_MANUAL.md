# 👨‍💼 Admin Manual - PPDB Plus

> Panduan Lengkap untuk Administrator

---

## 📑 Table of Contents

1. [Login Admin](#login-admin)
2. [Dashboard](#dashboard)
3. [Kelola Pendaftar](#kelola-pendaftar)
4. [Kelola Pembayaran](#kelola-pembayaran)
5. [Kelola Sekolah](#kelola-sekolah)
6. [Kelola Jurusan & Kuota](#kelola-jurusan-kuota)
7. [Kelola Akun User](#kelola-akun-user)
8. [Settings](#settings)
9. [Import Data](#import-data)
10. [Laporan & Export](#laporan-export)

---

## 🔐 Login Admin

**URL**: `/auth/login`

Credentials:
- Username: `admin`
- Password: (sesuai setup)

Setelah login → Redirect ke `/admin/dashboard`

---

## 📊 Dashboard

### Command Center (`/admin/command-center`)

**Statistik Real-time**:

```
┌──────────────────┬──────────────────┬──────────────────┐
│ Total Pendaftar  │ Pembayaran       │ Diterima         │
│      245         │     89 pending   │     156          │
└──────────────────┴──────────────────┴──────────────────┘

┌────────────────────────────────────────────────────────┐
│  Grafik Trend Pendaftaran (7 Hari Terakhir)          │
│  ▁▃▅▇█▇▅                                              │
└────────────────────────────────────────────────────────┘

┌────────────────────────────────────────────────────────┐
│  Monitoring Kuota Jurusan                             │
│  ⚠️ IPA: 87/90 (97%) - HAMPIR PENUH!                  │
│  ✓ IPS: 45/90 (50%) - Aman                            │
│  ✓ Bahasa: 12/30 (40%) - Aman                         │
└────────────────────────────────────────────────────────┘
```

**Quick Actions**:
- ➕ Tambah Siswa Manual
- ✅ Verifikasi Pembayaran
- 📋 Lihat Pendaftar
- ⚙️ Settings

---

## 👥 Kelola Pendaftar

### Lihat Daftar (`/admin/applicants`)

**Filter Status**:
- All (Semua)
- Pending (Belum Verifikasi)
- Submitted (Sudah Submit)
- Accepted (Diterima)
- Rejected (Ditolak)

**Search**:
- Nama
- NIK
- Nomor Pendaftaran
- Email

**Kolom Tabel**:
| No | Nama | NIK | Jurusan | Status | Bayar | Action |
|----|------|-----|---------|--------|-------|--------|
| 1  | Ahmad | 123... | IPA | Pending | ✓ | 👁️ ✏️ ❌ |

---

### View Detail Pendaftar

**URL**: `/admin/applicants/{id}`

**Tab yang Tersedia**:

#### 1️⃣ Data Pribadi
- NIK
- Nama Lengkap
- TTL
- Jenis Kelamin
- Agama
- Alamat
- No. HP

#### 2️⃣ Data Orang Tua
- Data Ayah (Nama, NIK, Pekerjaan, Penghasilan)
- Data Ibu (Nama, NIK, Pekerjaan, Penghasilan)

#### 3️⃣ Asal Sekolah
- Nama Sekolah
- NPSN
- Alamat
- Tahun Lulus

#### 4️⃣ Jurusan & Hobi
- Jurusan Pilihan 1
- Jurusan Pilihan 2
- Hobi/Minat

#### 5️⃣ Dokumen
- Akta Kelahiran → [View/Download]
- Kartu Keluarga → [View/Download]
- Ijazah → [View/Download]
- Raport → [View/Download]
- Foto 3x4 → [View/Download]
- KTP Ortu → [View/Download]

#### 6️⃣ Riwayat Pembayaran
| Tanggal | Jumlah | Bank | Status | Bukti |
|---------|--------|------|--------|-------|
| 15/01/26 | 150K | BCA | Confirmed | 📄 |

---

### Verifikasi Pendaftar

**Langkah-langkah**:

1. **Periksa Kelengkapan Data**
   ```
   ✓ Data Pribadi lengkap
   ✓ Data Orang Tua lengkap
   ✓ Asal Sekolah terisi
   ✓ Dokumen upload lengkap
   ✓ Pembayaran sudah konfirmasi
   ```

2. **Cek Kebenaran Dokumen**
   - Download semua dokumen
   - Periksa keaslian
   - Cocokkan dengan data yang diinput

3. **Update Status**
   ```
   Status: [dropdown]
   ├─ Pending (Menunggu Verifikasi)
   ├─ Submitted (Sudah Submit, Sedang Diverifikasi)
   ├─ Accepted (Diterima)
   └─ Rejected (Ditolak)
   
   Catatan: [textarea] (opsional, wajib jika Rejected)
   ```

4. **Submit Perubahan**
   - Klik "Update Status"
   - Notifikasi email otomatis terkirim ke applicant

---

### Tambah Siswa Manual

**URL**: `/admin/applicant-register`

Untuk siswa yang daftar offline/langsung:

**Form Input** (sama seperti form pendaftaran online):
- Data Pribadi
- Data Orang Tua
- Asal Sekolah
- Jurusan
- Upload Dokumen (opsional, bisa di upload nanti)

**Submit** → Siswa langsung terdaftar dengan status "Submitted"

---

## 💰 Kelola Pembayaran

### Daftar Pembayaran (`/admin/payments`)

**Filter Status**:
- Submitted (Menunggu Konfirmasi)
- Confirmed (Sudah Dikonfirmasi)
- Rejected (Ditolak)

**Kolom Tabel**:
| Pendaftar | Bank | Jumlah | Tanggal | Status | Action |
|-----------|------|--------|---------|--------|--------|
| Ahmad Zaki | BCA | 150K | 15/01 | Submitted | ✅ ❌ 👁️ |

---

### Verifikasi Pembayaran

**Langkah-langkah**:

1. **Klik View pada pembayaran**

2. **Periksa Detail**:
   ```
   Pendaftar: Ahmad Zaki
   Email: ahmad@email.com
   
   Detail Transfer:
   Bank Pengirim: BCA
   No. Rekening: 1234567890
   Atas Nama: Ahmad Zaki
   Jumlah: Rp 150.000
   Tanggal: 15 Januari 2026
   
   Bukti Transfer:
   [IMAGE PREVIEW]
   [Download PDF]
   ```

3. **Cocokkan dengan Rekening Koran**
   - Buka rekening koran bank sekolah
   - Cari transaksi dengan detail yang sama
   - Pastikan jumlah, tanggal, nama sesuai

4. **Konfirmasi atau Tolak**:

   **✅ KONFIRMASI** jika:
   - Data sesuai dengan rekening koran
   - Jumlah tepat (Rp 150.000)
   - Bukti transfer jelas dan valid
   
   ```
   Action: Confirm
   Catatan: "Pembayaran valid, sudah terverifikasi dengan rekening koran"
   [Submit]
   ```

   **❌ TOLAK** jika:
   - Data tidak cocok
   - Jumlah tidak sesuai
   - Bukti transfer tidak jelas/palsu
   
   ```
   Action: Reject
   Alasan: [wajib diisi]
   Contoh: "Bukti transfer tidak jelas, mohon upload ulang"
          "Jumlah transfer kurang (hanya Rp 100.000)"
          "Nama rekening tidak sesuai"
   [Submit]
   ```

5. **Notifikasi**
   - Email otomatis terkirim ke applicant
   - Status di dashboard applicant ter-update

---

### Input Pembayaran Manual

**URL**: `/admin/manual-payment`

Untuk siswa yang bayar langsung (cash/tunai) di sekolah:

**Form Input**:
```
Data Siswa:
- NIK / Nomor Pendaftaran (untuk cari siswa)
- Auto-fill: Nama, Email

Data Pembayaran:
- Metode Bayar: [Cash/Transfer]
- Jumlah: Rp 150.000
- Tanggal Bayar: [date picker]
- Nomor Kwitansi: [auto/manual]
- Catatan: [opsional]

Upload Bukti (opsional):
- Foto kwitansi
- Foto bukti transfer
```

**Submit** → Pembayaran langsung "Confirmed"

---

## 🏫 Kelola Sekolah

### Daftar Sekolah (`/admin/schools`)

**Actions**:
- ➕ Tambah Sekolah Baru
- 📥 Import dari Excel
- 📤 Export ke Excel
- 🔍 Search & Filter

**Tabel Sekolah**:
| NPSN | Nama Sekolah | Jenjang | Provinsi | Kota | Action |
|------|--------------|---------|----------|------|--------|
| 20123456 | SMPN 1 Jakarta | SMP | DKI Jakarta | Jaksel | ✏️ 🗑️ |

---

### Tambah Sekolah

**URL**: `/admin/schools/add`

**Form**:
```
NPSN: [text] (opsional)
Nama Sekolah: [text] (wajib)
Jenjang: [dropdown] SD/SMP/MTS/SMA/SMK/MA (wajib)
Status: [dropdown] Negeri/Swasta (wajib)
Alamat: [textarea]
Provinsi: [dropdown]
Kota/Kabupaten: [dropdown]
Kode Pos: [text]
Telepon: [text]
Email: [email]
Website: [url]
```

**Submit** → Sekolah tersimpan, bisa dipilih di form pendaftaran

---

### Import Sekolah Excel

**URL**: `/admin/schools/import-excel`

**Langkah**:

1. **Download Template**
   - Klik "Download Template Excel"
   - File: `template_sekolah.xlsx`

2. **Isi Template**
   Format kolom:
   ```
   | NPSN | Nama | Jenjang | Status | Provinsi | Kota | Alamat |
   |------|------|---------|--------|----------|------|--------|
   ```

3. **Upload File**
   - Pilih file Excel yang sudah diisi
   - Max: 5MB
   - Format: .xlsx atau .xls

4. **Validasi**
   - Sistem cek format
   - Cek duplikat NPSN
   - Preview data

5. **Import**
   - Klik "Import Data"
   - Progress bar muncul
   - Laporan: Sukses / Gagal / Skip

---

## 🎓 Kelola Jurusan & Kuota

### Manajemen Jurusan (`/admin/majors`)

**Daftar Jurusan**:
| Kode | Nama Jurusan | Deskripsi | Status | Action |
|------|--------------|-----------|--------|--------|
| IPA | IPA (Ilmu Alam) | Jurusan IPA | Active | ✏️ 🗑️ 🔄 |
| IPS | IPS (Sosial) | Jurusan IPS | Active | ✏️ 🗑️ 🔄 |

**Actions**:
- ➕ Tambah Jurusan
- ✏️ Edit
- 🗑️ Delete
- 🔄 Toggle Status (Active/Inactive)

---

### Tambah Jurusan

**Form**:
```
Kode Jurusan: [text, max 10 char] (misal: IPA, IPS, BHS)
Nama Jurusan: [text] (misal: Ilmu Pengetahuan Alam)
Deskripsi: [textarea]
Status: [checkbox] Aktif
```

---

### Manajemen Kuota (`/admin/quotas`)

**Monitoring Kuota per Tahun Ajaran**:

```
Tahun Ajaran: [2024/2025 ▼]

┌────────────────────────────────────────────────────────┐
│  Jurusan IPA                                          │
│  ████████████████████░░  87/90 (97%)                  │
│  ⚠️ Warning: Hampir Penuh!                            │
└────────────────────────────────────────────────────────┘

┌────────────────────────────────────────────────────────┐
│  Jurusan IPS                                          │
│  ██████████░░░░░░░░░░  45/90 (50%)                    │
│  ✓ Status: Aman                                       │
└────────────────────────────────────────────────────────┘

┌────────────────────────────────────────────────────────┐
│  Jurusan Bahasa                                       │
│  ████░░░░░░░░░░░░░░░░  12/30 (40%)                    │
│  ✓ Status: Aman                                       │
└────────────────────────────────────────────────────────┘
```

---

### Set Kuota Jurusan

**URL**: `/admin/quotas/create`

**Form**:
```
Tahun Ajaran: [dropdown] (2024/2025, 2025/2026, dst)
Jurusan: [dropdown] (IPA, IPS, Bahasa, dst)
Kuota Total: [number] (misal: 90)

[Submit]
```

**Edit Kuota**:
- Bisa tambah kuota kapan saja
- Kuota terisi otomatis update saat ada pendaftar baru

**Reset Kuota Terisi**:
- Klik "Reset" untuk set kuota terisi = 0
- Biasanya dilakukan awal tahun ajaran baru

---

## 👤 Kelola Akun User

### Daftar Akun (`/admin/kelola-akun`)

**Tabel User**:
| Username | Email | Role | Status | Action |
|----------|-------|------|--------|--------|
| admin | admin@sekolah.id | Admin | Active | ✏️ 🔒 🗑️ |
| bendahara1 | bendahara@sekolah.id | Bendahara | Active | ✏️ 🔒 🗑️ |

**Filter by Role**:
- All
- Admin
- Panitia
- Bendahara
- Applicant

---

### Tambah Akun

**URL**: `/admin/tambah-akun`

**Form**:
```
Username: [text, min 3 char]
Email: [email, unique]
Password: [password, min 6 char]
Confirm Password: [password]

Role: [dropdown]
├─ Admin (Full Access)
├─ Panitia (Kelola Siswa)
└─ Bendahara (Kelola Keuangan)

Nama Lengkap: [text]
No. HP: [text]

Status: [checkbox] Aktif

[Submit]
```

---

### Edit Akun

**Actions**:
- Edit Data (username, email, nama, HP)
- Reset Password
- Toggle Status (Aktif/Nonaktif)
- Hapus Akun (soft delete)

---

## ⚙️ Settings

### Pengaturan Sistem (`/admin/settings`)

**Tab Settings**:

#### 1️⃣ Informasi Sekolah
```
Nama Sekolah: [text]
NPSN: [text]
Akreditasi: [dropdown] A/B/C
Alamat Lengkap: [textarea]
Provinsi: [dropdown]
Kota/Kab: [dropdown]
Kode Pos: [text]
Telepon: [text]
Email: [email]
Website: [url]
Logo Sekolah: [upload image]
```

#### 2️⃣ Konfigurasi PPDB
```
Tahun Ajaran Aktif: [dropdown]
Gelombang: [text] (misal: Gelombang 1)

Periode Pendaftaran:
- Tanggal Buka: [date]
- Tanggal Tutup: [date]

Status Pendaftaran: [toggle]
├─ 🟢 BUKA (Siswa bisa daftar)
└─ 🔴 TUTUP (Pendaftaran ditutup)

Biaya Pendaftaran: Rp [number]

Rekening Tujuan:
- Bank: [dropdown] BCA/Mandiri/BNI/BRI
- No. Rekening: [text]
- Atas Nama: [text]
```

#### 3️⃣ Kop Surat
```
Logo: [upload]
Nama Sekolah: [text]
Alamat: [textarea]
Telepon: [text]
Email: [email]
Website: [url]
```

#### 4️⃣ Email Configuration
```
SMTP Host: [text] (misal: smtp.gmail.com)
SMTP Port: [number] (587/465)
SMTP User: [email]
SMTP Password: [password]
From Email: [email]
From Name: [text]

[Test Connection]
```

#### 5️⃣ Notifikasi Template
```
Email Registrasi Berhasil:
Subject: [text]
Body: [rich text editor]

Email Pembayaran Dikonfirmasi:
Subject: [text]
Body: [rich text editor]

Email Diterima:
Subject: [text]
Body: [rich text editor]

Email Ditolak:
Subject: [text]
Body: [rich text editor]
```

**Variable Template**:
- `{nama}` - Nama pendaftar
- `{email}` - Email
- `{nomor_pendaftaran}` - No pendaftaran
- `{jurusan}` - Jurusan pilihan
- `{tanggal}` - Tanggal
- `{sekolah}` - Nama sekolah

---

## 📥 Import Data

### Import Sekolah

(Sudah dijelaskan di section [Kelola Sekolah](#import-sekolah-excel))

---

### Import Siswa (Batch)

**URL**: `/admin/import-excel`

**Untuk import banyak siswa sekaligus**:

1. **Download Template**
   ```
   | NIK | Nama | TTL | JK | Agama | Alamat | HP | ... |
   ```

2. **Isi Template**
   - Sesuaikan format
   - Pastikan tidak ada yang kosong

3. **Upload & Import**
   - Validasi otomatis
   - Preview data
   - Import

**Catatan**:
- Max 500 rows per import
- Duplikat NIK akan di-skip
- Error log akan ditampilkan

---

## 📊 Laporan & Export

### Generate Laporan

**Menu**: Dashboard → Laporan

**Jenis Laporan**:

#### 1️⃣ Laporan Pendaftar
```
Filter:
- Periode: [date range]
- Status: [All/Pending/Accepted/Rejected]
- Jurusan: [All/IPA/IPS/Bahasa]

Format Export:
[📄 PDF] [📊 Excel] [🖨️ Print]
```

**Isi Laporan**:
- Total pendaftar
- Breakdown per status
- Breakdown per jurusan
- Grafik trend
- Detail pendaftar (tabel)

---

#### 2️⃣ Laporan Keuangan
```
Filter:
- Periode: [date range]
- Status: [All/Submitted/Confirmed/Rejected]

Format Export:
[📄 PDF] [📊 Excel]
```

**Isi Laporan**:
- Total pemasukan
- Breakdown per status
- Detail transaksi
- Rekap harian/bulanan

---

#### 3️⃣ Laporan Kuota
```
Tahun Ajaran: [dropdown]

Format Export:
[📄 PDF] [📊 Excel] [🖨️ Print]
```

**Isi Laporan**:
- Kuota per jurusan
- Sisa kuota
- Grafik visualisasi
- Persentase terisi

---

### Export Data

**Quick Export**:

Dari setiap halaman list (applicants, payments, schools):
- Tombol **"Export Excel"** di pojok kanan atas
- Export sesuai filter yang aktif
- Format: .xlsx

**Columns Exported**:
- Semua kolom yang tampil di tabel
- Data lengkap (termasuk yang hidden)

---

## 🛠️ Maintenance & Backup

### Backup Database

**Manual Backup**:
1. Akses phpMyAdmin
2. Pilih database: `ppdb_plus`
3. Tab "Export"
4. Format: SQL
5. Klik "Go"
6. Save file .sql

**Automated Backup** (recommended):
- Setup cron job untuk backup otomatis
- Frekuensi: Harian (tengah malam)
- Simpan di cloud storage (Google Drive/Dropbox)

---

### Clear Cache

Jika sistem lemot atau data tidak update:

```bash
# Via Terminal
cd /path/to/SPMB-Plus
php spark cache:clear

# Via Browser
Akses: /admin/clear-cache (jika ada)
```

---

### Update System

**Cek Update**:
- Dashboard → Settings → About
- Cek versi terbaru di GitHub

**Manual Update**:
1. Backup database dulu!
2. Download update dari GitHub
3. Extract dan replace files
4. Run migration jika ada:
   ```bash
   php spark migrate
   ```
5. Clear cache

---

## 🚨 Error Handling

### Email Tidak Terkirim

**Cek**:
1. Settings → Email Configuration
2. Test Connection
3. Pastikan SMTP credentials benar
4. Cek firewall/port blocked

**Fix**:
- Update SMTP password jika berubah
- Gunakan App Password untuk Gmail
- Coba provider lain (SendGrid, Mailgun)

---

### Import Gagal

**Cek**:
1. Format Excel sesuai template?
2. Ada cell kosong pada kolom wajib?
3. Ukuran file terlalu besar?
4. Encoding file (gunakan UTF-8)

**Fix**:
- Download template baru
- Isi ulang dengan benar
- Split file jika terlalu besar (max 500 rows)

---

### Dashboard Tidak Update

**Cek**:
1. Refresh browser (Ctrl+F5)
2. Clear browser cache
3. Cek koneksi internet

**Fix**:
```bash
php spark cache:clear
php spark cache:info
```

---

## 📞 Support

**Developer Support**:
- Email: dev@ppdb-plus.com
- GitHub Issues: github.com/yourrepo/issues
- Documentation: docs.ppdb-plus.com

**Business Hours**:
- Senin - Jumat: 09:00 - 17:00 WIB
- Response Time: < 24 jam

---

## 📝 Checklist Harian Admin

**Morning Check** (09:00):
- [ ] Cek dashboard - ada anomali?
- [ ] Verifikasi pembayaran baru
- [ ] Cek pending applicants
- [ ] Monitor kuota jurusan

**Noon Check** (12:00):
- [ ] Reply email/WA dari pendaftar
- [ ] Verifikasi dokumen upload baru

**Evening Check** (16:00):
- [ ] Rekapitulasi pembayaran hari ini
- [ ] Update status applicants
- [ ] Backup data (optional)

---

## 🎯 Best Practices

✅ **DO**:
- Backup database SETIAP HARI
- Verifikasi pembayaran max 1 hari
- Respon cepat ke pertanyaan pendaftar
- Monitor kuota secara berkala
- Update settings sebelum periode buka
- Test email notifikasi sebelum periode
- Clear cache setelah update data besar

❌ **DON'T**:
- Share password admin ke banyak orang
- Edit database langsung via phpMyAdmin
- Hapus data tanpa backup
- Buka banyak tab admin sekaligus
- Lupa logout setelah selesai

---

*Admin Manual v2.0*  
*Last Updated: January 2026*
