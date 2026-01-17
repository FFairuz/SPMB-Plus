# Fitur Manajemen Jurusan dan Kuota Sekolah

## 📋 Deskripsi
Fitur ini memungkinkan admin untuk mengelola kuota jurusan per tahun ajaran dengan pembagian berdasarkan jalur pendaftaran (Reguler, Prestasi, dan Afirmasi).

## 🗂️ Struktur Database

### Tabel: major_quotas
- **id**: Primary key
- **major_id**: Foreign key ke tabel majors
- **tahun_ajaran**: Format YYYY/YYYY (contoh: 2026/2027)
- **kuota_total**: Total kuota untuk jurusan tersebut
- **kuota_terisi**: Jumlah kuota yang sudah terisi (auto-update)
- **jalur_reguler**: Kuota untuk jalur reguler
- **jalur_prestasi**: Kuota untuk jalur prestasi
- **jalur_afirmasi**: Kuota untuk jalur afirmasi
- **status**: aktif/nonaktif
- **keterangan**: Keterangan tambahan
- **created_at** dan **updated_at**

### Update Tabel: majors
Ditambahkan kolom:
- **tahun_ajaran**: Nullable
- **kuota_total**: Default 0
- **kuota_terisi**: Default 0

## 📁 File yang Dibuat

### 1. Migrations
- `2026-01-17-000001_AddQuotaFieldsToMajors.php`
- `2026-01-17-000002_CreateMajorQuotasTable.php`

### 2. Model
- `app/Models/MajorQuota.php`
  - Method `getQuotaWithMajor()` - Ambil kuota dengan info jurusan
  - Method `getQuotaByMajorAndYear()` - Cari kuota berdasar jurusan & tahun
  - Method `getActiveQuotas()` - Ambil kuota yang aktif
  - Method `getQuotaStats()` - Statistik kuota dengan persentase
  - Method `incrementQuotaTerisi()` - Tambah kuota terisi
  - Method `decrementQuotaTerisi()` - Kurangi kuota terisi
  - Method `isQuotaAvailable()` - Cek ketersediaan kuota
  - Method `getAvailableYears()` - Daftar tahun ajaran

### 3. Controller
- `app/Controllers/AdminMajorQuotaController.php`
  - `index()` - Daftar kuota
  - `create()` - Tambah kuota baru
  - `edit($id)` - Edit kuota
  - `delete($id)` - Hapus kuota
  - `resetQuotaTerisi($id)` - Reset kuota terisi ke 0
  - `statistics()` - Statistik lengkap dengan chart

### 4. Views
- `app/Views/admin/quotas/index.php` - Daftar kuota
- `app/Views/admin/quotas/create.php` - Form tambah kuota
- `app/Views/admin/quotas/edit.php` - Form edit kuota
- `app/Views/admin/quotas/statistics.php` - Halaman statistik

## 🔗 Routes
```php
// Admin Major Quota Management Routes
$routes->get('admin/quotas', 'AdminMajorQuotaController::index');
$routes->get('admin/quotas/create', 'AdminMajorQuotaController::create');
$routes->post('admin/quotas/create', 'AdminMajorQuotaController::create');
$routes->get('admin/quotas/edit/(:num)', 'AdminMajorQuotaController::edit/$1');
$routes->post('admin/quotas/edit/(:num)', 'AdminMajorQuotaController::edit/$1');
$routes->post('admin/quotas/delete/(:num)', 'AdminMajorQuotaController::delete/$1');
$routes->post('admin/quotas/reset/(:num)', 'AdminMajorQuotaController::resetQuotaTerisi/$1');
$routes->get('admin/quotas/statistics', 'AdminMajorQuotaController::statistics');
```

## 🎯 Fitur Utama

### 1. Manajemen Kuota
- ✅ Tambah kuota per jurusan dan tahun ajaran
- ✅ Edit kuota dengan validasi
- ✅ Hapus kuota (hanya jika belum terisi)
- ✅ Reset kuota terisi ke 0
- ✅ Filter berdasarkan tahun ajaran

### 2. Pembagian Jalur
- ✅ Jalur Reguler
- ✅ Jalur Prestasi  
- ✅ Jalur Afirmasi
- ✅ Validasi total jalur tidak melebihi kuota total

### 3. Statistik & Monitoring
- ✅ Dashboard statistik kuota
- ✅ Progress bar per jurusan
- ✅ Persentase terisi
- ✅ Total keseluruhan (kuota, terisi, sisa)
- ✅ Status indikator (Tersedia, Normal, Sedang, Hampir Penuh)

### 4. Validasi & Keamanan
- ✅ Kuota total tidak boleh < kuota terisi
- ✅ Total jalur tidak boleh > kuota total
- ✅ Kombinasi major_id + tahun_ajaran harus unik
- ✅ Tidak bisa hapus kuota yang sudah terisi
- ✅ CSRF protection pada semua form

## 📊 Cara Penggunaan

### Menambah Kuota
1. Login sebagai Admin
2. Akses menu: **Admin > Kelola Kuota Jurusan**
3. Klik tombol **"Tambah Kuota"**
4. Isi form:
   - Pilih Jurusan
   - Masukkan Tahun Ajaran (contoh: 2026/2027)
   - Tentukan Kuota Total
   - Opsional: Bagi kuota per jalur pendaftaran
   - Pilih Status (Aktif/Nonaktif)
5. Klik **"Simpan"**

### Melihat Statistik
1. Dari halaman Kelola Kuota, klik tombol **"Statistik"**
2. Pilih tahun ajaran untuk melihat detail
3. Dashboard menampilkan:
   - Summary cards (Total, Terisi, Sisa, Jumlah Jurusan)
   - Progress keseluruhan
   - Tabel detail per jurusan dengan progress bar

### Edit Kuota
1. Dari daftar kuota, klik icon **pensil** pada baris yang ingin diedit
2. Update data yang diperlukan
3. Sistem akan validasi agar kuota total tidak < kuota terisi
4. Klik **"Update"**

### Reset Kuota Terisi
- Jika kuota sudah terisi dan ingin direset, klik icon **refresh**
- Ini akan mengubah kuota_terisi menjadi 0
- Data pendaftar tidak akan dihapus

## 🔧 Integrasi dengan Modul Lain

### Untuk Integrasi dengan Form Pendaftaran:
```php
// Contoh penggunaan di controller pendaftaran
use App\Models\MajorQuota;

$quotaModel = new MajorQuota();

// Cek ketersediaan kuota
$majorId = $this->request->getPost('major_id');
$tahunAjaran = '2026/2027';

if (!$quotaModel->isQuotaAvailable($majorId, $tahunAjaran)) {
    return $this->response->setJSON([
        'success' => false,
        'message' => 'Kuota untuk jurusan ini sudah penuh!'
    ]);
}

// Jika pendaftar diterima, increment kuota terisi
$quota = $quotaModel->getQuotaByMajorAndYear($majorId, $tahunAjaran);
if ($quota) {
    $quotaModel->incrementQuotaTerisi($quota['id']);
}
```

## 🎨 UI/UX Features
- ✅ Responsive design (mobile-friendly)
- ✅ Bootstrap 5 icons
- ✅ Color-coded progress bars
- ✅ Real-time calculation pada form
- ✅ Confirmation dialogs untuk aksi penting
- ✅ Flash messages untuk feedback
- ✅ Loading states & tooltips

## 🚀 Pengembangan Selanjutnya
Beberapa enhancement yang bisa ditambahkan:
1. Export data kuota ke Excel/PDF
2. Chart visualisasi (pie chart, bar chart)
3. Notifikasi otomatis saat kuota hampir penuh
4. History tracking perubahan kuota
5. Bulk update kuota untuk multiple jurusan
6. API endpoint untuk integrasi eksternal

## 📝 Catatan Penting
- Migration sudah dijalankan dan tabel sudah dibuat di database
- Fitur ini memerlukan role **Admin** untuk akses
- Data kuota_terisi akan otomatis ter-update saat ada pendaftar baru (perlu integrasi)
- Pastikan tahun ajaran konsisten di seluruh sistem

## 🔒 Security
- Menggunakan trait `RoleAuthTrait` dengan method `requireAdmin()`
- CSRF protection pada semua form POST
- Input validation menggunakan CodeIgniter validation rules
- Prepared statements untuk query database (built-in CI4 Model)

## ✅ Status
**COMPLETED** - Fitur sudah siap digunakan!

Akses melalui: `/admin/quotas`
