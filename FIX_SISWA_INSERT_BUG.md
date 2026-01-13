# PERBAIKAN: Bug Insert Siswa di Tabel Applicants_Dapodik

## Masalah yang Ditemukan

Ketika panitia menambah siswa, siswa tidak berhasil tersimpan ke database dengan error yang tidak jelas.

### Root Cause Analysis

1. **Type Casting Tidak Konsisten**
   - Field `anak_ke` dan `jumlah_saudara` dari form adalah string, tapi database expect integer
   - Ini bisa menyebabkan validation error di model

2. **Null Value Handling**
   - Field `dusun` dan `npsn_sekolah_asal` adalah optional tapi perlu handling untuk empty string
   - Menggunakan `?? null` tidak konsisten dengan ternary operator yang lebih jelas

3. **Field Mapping Tidak Lengkap**
   - Field `dusun` ada di form tapi tidak di-handle di controller data array
   - Field `tanggal_submit` di-set manual padahal `created_at` sudah auto-timestamp

4. **Error Handling Kurang Detail**
   - Ketika insert gagal, hanya menampilkan generic error message
   - Model validation errors tidak di-capture dan ditampilkan ke user

## Solusi yang Diterapkan

### 1. **Type Casting yang Benar** (PanitiaController.php, line ~138-139)
```php
'anak_ke' => (int) $this->request->getPost('anak_ke'),
'jumlah_saudara' => (int) $this->request->getPost('jumlah_saudara'),
```
Memastikan field numeric di-cast ke integer sesuai dengan tipe database.

### 2. **Null Value Handling yang Jelas** (line ~146-147)
```php
'dusun' => $this->request->getPost('dusun') ?: null,
'npsn_sekolah_asal' => $this->request->getPost('npsn_sekolah_asal') ?: null,
```
Menggunakan ternary operator untuk convert empty string ke null.

### 3. **Complete Field Mapping** (line ~128-152)
- Menambahkan field `dusun` ke data array
- Mempertahankan `tanggal_submit` untuk timestamp manual
- Semua field dari form ter-map dengan benar

### 4. **Better Error Capture & Display** (line ~155-168)
```php
try {
    if ($this->applicantModel->insert($data)) {
        $applicant_id = $this->applicantModel->insertID();
        session()->setFlashdata('success', '...');
        return redirect()->to('/panitia/daftar-siswa');
    } else {
        $errors = $this->applicantModel->errors();
        $errorMsg = is_array($errors) ? implode(', ', $errors) : '...';
        session()->setFlashdata('error', $errorMsg);
        return redirect()->back()->withInput();
    }
} catch (\Exception $e) {
    session()->setFlashdata('error', 'Gagal: ' . $e->getMessage());
    return redirect()->back()->withInput();
}
```
- Check return value dari `insert()` method
- Capture validation errors dari model
- Menampilkan error detail ke user
- Fallback ke exception handling

## Database Schema yang Digunakan

**Tabel**: `applicants_dapodik`

**Field yang dimapping dari form**:
| Field | Type | Database | Nullable |
|-------|------|----------|----------|
| nik | text | VARCHAR(16) | ❌ |
| nama_lengkap | text | VARCHAR(255) | ❌ |
| jenis_kelamin | select | ENUM | ❌ |
| tanggal_lahir | date | DATE | ❌ |
| tempat_lahir | text | VARCHAR(100) | ❌ |
| agama | select | ENUM | ❌ |
| anak_ke | number | INT | ❌ |
| jumlah_saudara | number | INT | ❌ |
| alamat_jalan | text | TEXT | ❌ |
| dusun | text | VARCHAR(100) | ✅ |
| kelurahan | text | VARCHAR(100) | ❌ |
| kecamatan | text | VARCHAR(100) | ❌ |
| kabupaten | text | VARCHAR(100) | ❌ |
| provinsi | text | VARCHAR(100) | ❌ |
| kode_pos | text | VARCHAR(10) | ❌ |
| nomor_hp | text | VARCHAR(20) | ❌ |
| asal_sekolah | text | VARCHAR(255) | ❌ |
| npsn_sekolah_asal | text | VARCHAR(20) | ✅ |
| nama_ayah | text | VARCHAR(255) | ❌ |
| nama_ibu | text | VARCHAR(255) | ❌ |
| nomor_pendaftaran | auto | VARCHAR(50) unique | ❌ |
| status | auto | ENUM | ❌ |
| tanggal_submit | manual | DATETIME | ✅ |
| created_at | auto | DATETIME | ✅ |
| updated_at | auto | DATETIME | ✅ |

**ENUM Values Valid:**
- `jenis_kelamin`: 'laki-laki', 'perempuan'
- `agama`: 'Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'
- `status`: 'draft', 'submitted', 'verified', 'lulus', 'tidak_lulus', 'diterima', 'ditolak'

## Checklist Validasi Form

Sebelum submit, form harus valid:
- [ ] NIK: 16 digit, numeric, unique di database
- [ ] Nama Lengkap: min 3 karakter
- [ ] Jenis Kelamin: pilih dari enum
- [ ] Tanggal Lahir: format valid Y-m-d
- [ ] Tempat Lahir: min 3 karakter
- [ ] Agama: pilih dari enum
- [ ] Anak Ke: integer > 0
- [ ] Jumlah Saudara: integer >= 0
- [ ] Alamat Jalan: min 5 karakter
- [ ] Kelurahan: tidak boleh kosong
- [ ] Kecamatan: tidak boleh kosong
- [ ] Kabupaten: tidak boleh kosong
- [ ] Provinsi: tidak boleh kosong
- [ ] Kode Pos: 5 digit numeric
- [ ] Nomor HP: 10-13 digit numeric
- [ ] Asal Sekolah: min 5 karakter
- [ ] NPSN: optional, tapi jika diisi harus 8 digit numeric
- [ ] Nama Ayah: min 3 karakter
- [ ] Nama Ibu: min 3 karakter

## Testing Manual

### Step 1: Siapkan Data Test

```
NIK: 3173011234567890
Nama: Budi Santoso
Jenis Kelamin: Laki-laki
Tanggal Lahir: 2008-05-15
Tempat Lahir: Jakarta Selatan
Agama: Islam
Anak Ke: 2
Jumlah Saudara: 1
Alamat: Jl. Merdeka No. 42 RT 01 RW 02
Dusun: Dusun Sentosa
Kelurahan: Kelurahan Maju
Kecamatan: Kecamatan Utama
Kabupaten: Jakarta Selatan
Provinsi: DKI Jakarta
Kode Pos: 12120
Nomor HP: 081234567890
Asal Sekolah: SMP Negeri 1 Jakarta
NPSN: 20123456
Nama Ayah: Santoso
Nama Ibu: Nurhaliza
```

### Step 2: Login Sebagai Panitia

- URL: `http://localhost:8080/auth/login`
- Username: `panitia`
- Password: `password123`

### Step 3: Akses Form Tambah Siswa

- URL: `http://localhost:8080/panitia/tambah-siswa`
- Atau klik tombol "Tambah Siswa Baru" di daftar siswa

### Step 4: Isi Form & Submit

- Isi semua field dengan data test
- Klik tombol "Simpan Data"

### Step 5: Verifikasi Hasil

**Jika Berhasil:**
- ✅ Redirect ke `/panitia/daftar-siswa`
- ✅ Flash message hijau dengan nomor pendaftaran
- ✅ Siswa baru muncul di daftar (paling atas)
- ✅ Data lengkap terbaca di daftar

**Jika Error:**
- Check flash error message di form
- Lihat console/error log di `writable/logs/`
- Verifikasi field validation rules
- Check database schema dengan query

## Rekomendasi Tambahan

1. **Client-side Validation**: Tambahkan JavaScript validation untuk UX lebih baik
2. **NIK Format**: Validasi format NIK yang lebih ketat (16 digit, tidak dimulai dengan 0)
3. **Duplicate Check**: Tambahkan AJAX untuk check NIK duplicate sebelum submit
4. **Loading State**: Tambahkan spinner/loading indicator saat form submit
5. **Success Redirect**: Pertimbangkan redirect ke lihat_siswa untuk preview data

## Files Modified

- [app/Controllers/PanitiaController.php](app/Controllers/PanitiaController.php) - Perbaikan insert data

## Related Files

- [app/Views/panitia/tambah_siswa.php](app/Views/panitia/tambah_siswa.php) - Form input
- [app/Models/Applicant.php](app/Models/Applicant.php) - Model dengan validation rules
- [app/Database/Migrations/2025-12-15-000005_CreateApplicantsDapodikTable.php](app/Database/Migrations/2025-12-15-000005_CreateApplicantsDapodikTable.php) - Database schema

---
**Status**: ✅ Fixed  
**Tested**: Pending manual test  
**Date**: 2025-12-18  
**Last Updated**: 2025-12-18 18:00 UTC

