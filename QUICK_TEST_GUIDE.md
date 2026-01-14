# 🚀 Quick Start Testing Guide - Redesign Tambah Siswa

## ⚡ Cepat Mulai Testing (5 Menit)

---

## 📋 Pre-requisites

✅ XAMPP running (Apache + MySQL)  
✅ Database configured  
✅ Browser (Chrome/Firefox/Edge)  
✅ Login sebagai Panitia  

---

## 🎯 Quick Test (30 Detik)

### Step 1: Start Server
```bash
cd c:\xampp\htdocs\SPMB-Plus
php spark serve
```

### Step 2: Open Browser
```
http://localhost:8080/panitia/tambah-siswa
```

### Step 3: Visual Check ✅
Lihat apakah tampil:
- [ ] Gradient purple di header
- [ ] Progress steps (4 bulatan)
- [ ] 6 section cards dengan icon
- [ ] Buttons di bottom sticky

**✅ PASS jika semua tampil**

---

## 🧪 Full Test (5 Menit)

### Test 1: Header & Progress (30s)
1. Scroll halaman
2. Lihat header gradient tidak ikut scroll
3. Progress steps terlihat jelas
4. Icons tampil di setiap step

**Expected**: Header fixed, progress visible

---

### Test 2: Form Inputs (1 min)
1. Klik field NIK
2. Lihat border berubah ke purple saat focus
3. Ketik "123" (kurang dari 16 digit)
4. Tab ke field lain
5. Submit form (akan error)
6. Lihat error message merah dengan icon

**Expected**: Focus effect OK, validation OK

---

### Test 3: Hobby Selection ⭐ (2 min)
1. Scroll ke section "Pendidikan & Minat"
2. Klik dropdown "Hobi / Minat"
3. Pilih 2-3 hobi
4. Lihat gradient purple tags muncul
5. Cek counter di bawah: "3 hobi dipilih 🎯"
6. Klik × untuk remove 1 hobi
7. Counter update jadi "2 hobi dipilih"

**Expected**: 
- Dropdown terbuka dengan styling modern
- Tags berwarna purple gradient
- Counter update otomatis

**🔴 FAIL jika**: Tags tidak muncul atau tidak ada warna
**🔧 FIX**: Cek jQuery dan Select2 loaded (F12 Console)

---

### Test 4: School Management (1.5 min)
1. Klik dropdown "Nama Sekolah Asal"
2. Pilih satu sekolah
3. Buka Developer Tools (F12)
4. Tab Elements, cari `#npsn_hidden`
5. Cek value terisi NPSN

6. Klik button "Tambah Sekolah"
7. Modal terbuka dengan gradient hijau
8. Isi form:
   - Nama: "SMP Test 999"
   - Kota: "Jakarta"
   - Provinsi: "DKI Jakarta"
9. Klik "Simpan Sekolah"
10. Tunggu 1.5 detik, modal auto-close
11. Cek dropdown sekolah, ada "SMP Test 999"

**Expected**:
- NPSN auto-fill saat pilih sekolah
- Modal tampil modern
- AJAX save berhasil
- Sekolah baru masuk dropdown

---

### Test 5: Responsive (30s)
1. Buka Developer Tools (F12)
2. Toggle device toolbar (Ctrl+Shift+M)
3. Pilih "iPhone SE"
4. Scroll halaman
5. Cek semua elements visible
6. Buttons full width di mobile

**Expected**: Layout rapi di mobile

---

### Test 6: Complete Submission (OPTIONAL - 3 min)
Jika mau test full flow:

```
NIK: 1234567890123456
Nama: Test Siswa Redesign
Jenis Kelamin: laki-laki
Tempat Lahir: Jakarta
Tanggal Lahir: 2010-01-01
Agama: Islam
Anak Ke: 1
Jumlah Saudara: 2
Alamat Jalan: Jl. Test No. 123
Kelurahan: Test
Kecamatan: Test
Kabupaten: Jakarta
Provinsi: DKI Jakarta
Kode Pos: 12345
Nomor HP: 081234567890
Sekolah Asal: (pilih dari dropdown)
Jurusan: (pilih dari dropdown)
Hobi: (pilih 2-3)
Nama Ayah: Test Ayah
Nama Ibu: Test Ibu
```

Klik "Simpan Data Siswa"

**Expected**: Redirect dengan success message

---

## 🐛 Common Issues & Quick Fixes

### Issue 1: Hobi Select Tidak Ada Warna
**Symptom**: Dropdown hobi tampil tapi tags putih/plain

**Cause**: Select2 CSS tidak load atau order salah

**Fix**:
1. F12 → Network tab
2. Reload page
3. Cek `select2.min.css` loaded (status 200)
4. Cek `select2-bootstrap-5-theme.css` loaded

### Issue 2: Gradient Tidak Tampil
**Symptom**: Header tidak ada warna

**Cause**: Browser tidak support gradient (sangat jarang)

**Fix**:
1. Update browser
2. Test di Chrome terbaru
3. Clear cache (Ctrl+F5)

### Issue 3: Modal Tidak Muncul
**Symptom**: Klik "Tambah Sekolah" tidak ada efek

**Cause**: Bootstrap JS tidak load

**Fix**:
1. F12 → Console
2. Cek error JS
3. Reload page
4. Cek `bootstrap.bundle.min.js` loaded

### Issue 4: AJAX Save Sekolah Error
**Symptom**: Klik "Simpan Sekolah" muncul error

**Cause**: Endpoint tidak ada atau CSRF issue

**Fix**:
1. F12 → Network tab
2. Lihat POST request ke `/panitia/ajax-add-school`
3. Cek response (status 404/500)
4. Pastikan route sudah ada di `app/Config/Routes.php`
5. Pastikan CSRF enabled di config

---

## ✅ Success Checklist

Centang jika PASS:

### Visual
- [ ] Gradient purple di header
- [ ] Progress steps dengan 4 icons
- [ ] 6 section cards dengan shadow
- [ ] Icons di setiap section
- [ ] Required badges merah
- [ ] Modern input styling (rounded, border)
- [ ] Gradient purple tags untuk hobi
- [ ] Sticky buttons di bottom

### Functional
- [ ] Form validation working
- [ ] Error messages tampil
- [ ] Hobi multi-select working
- [ ] Tags muncul dengan warna gradient
- [ ] Counter hobi update
- [ ] School dropdown working
- [ ] NPSN auto-fill working
- [ ] Modal tambah sekolah bisa dibuka
- [ ] AJAX save sekolah berhasil
- [ ] Sekolah baru masuk dropdown
- [ ] Submit form berhasil simpan

### Responsive
- [ ] Desktop (1920px) OK
- [ ] Laptop (1366px) OK
- [ ] Tablet (768px) OK
- [ ] Mobile (375px) OK

### Browser
- [ ] Chrome OK
- [ ] Firefox OK
- [ ] Edge OK

---

## 🎯 Priority Test Cases

**MUST TEST** (Wajib):
1. ✅ Hobi selection dengan gradient tags
2. ✅ Form validation
3. ✅ Modal tambah sekolah
4. ✅ Mobile responsive

**NICE TO TEST** (Optional):
1. School NPSN auto-fill
2. Hover effects
3. Animations
4. Cross-browser compatibility

---

## 📸 Screenshot Points

Ambil screenshot di:
1. **Desktop full view** (home position)
2. **Progress steps** (close-up)
3. **Section card hover** (saat di-hover)
4. **Hobi dengan tags** (ada 3-4 hobi dipilih)
5. **Modal tambah sekolah** (modal open)
6. **Mobile view** (full page di iPhone SE)
7. **Error state** (ada validation error)

---

## 🎨 Visual Inspection Points

Zoom in dan cek:
1. Border radius konsisten (12px inputs, 20px cards)
2. Font weight jelas (labels tebal, text biasa)
3. Spacing rapi (tidak terlalu rapat/renggang)
4. Colors match design (purple gradient, red error, etc)
5. Icons tidak pecah/blur
6. Text readable (tidak terlalu kecil)
7. Buttons aligned (tidak miring/tidak rata)

---

## ⚠️ Red Flags

**🚨 STOP dan report jika**:
1. Hobi tags tidak ada warna (putih polos)
2. Layout broken di mobile (overlap/terpotong)
3. Buttons tidak bisa diklik
4. Modal error saat save
5. Form tidak bisa submit
6. Page load > 5 detik
7. Console penuh error merah

---

## 💡 Pro Tips

### Tip 1: Clear Cache
```
Ctrl + Shift + Delete → Clear cache
atau
Ctrl + F5 (hard reload)
```

### Tip 2: Mobile Testing
```
F12 → Toggle Device Toolbar (Ctrl+Shift+M)
Pilih device: iPhone SE, iPad, Desktop HD
```

### Tip 3: Console Debugging
```
F12 → Console tab
Cek error berwarna merah
Copy paste error untuk troubleshoot
```

### Tip 4: Network Check
```
F12 → Network tab
Filter: CSS, JS, XHR
Cek semua file loaded (status 200)
```

### Tip 5: Compare Before/After
Buka file `BEFORE_AFTER_REDESIGN.md` untuk reference

---

## 📞 Need Help?

### Documentation Files
1. `REDESIGN_COMPLETION_REPORT.md` - Full report
2. `BEFORE_AFTER_REDESIGN.md` - Visual comparison
3. `REDESIGN_IMPLEMENTATION_PLAN.md` - Technical plan
4. `MODERN_HOBBY_DESIGN.md` - Hobby feature detail

### Debug Steps
1. Check console errors (F12)
2. Check network requests (F12 → Network)
3. Verify jQuery loaded (type `$` in console)
4. Verify Select2 loaded (type `$.fn.select2` in console)
5. Check CSS loaded (inspect element → computed styles)

---

## 🏁 Quick Pass/Fail Criteria

### ✅ PASS if:
- Gradient header tampil
- Progress steps visible
- Cards have shadows
- Hobi tags berwarna purple
- All buttons clickable
- Mobile responsive
- No console errors (atau max 1-2 warning)

### ❌ FAIL if:
- Layout broken
- Hobi tags putih/tidak ada
- Buttons tidak berfungsi
- Console error merah banyak
- Mobile overlap/terpotong
- Modal tidak muncul

---

## ⏱️ Time Estimates

| Test | Duration | Priority |
|------|----------|----------|
| Visual Check | 30s | HIGH |
| Form Inputs | 1 min | HIGH |
| Hobby Selection | 2 min | HIGH |
| School Management | 1.5 min | MEDIUM |
| Responsive | 30s | HIGH |
| Complete Submit | 3 min | LOW |
| **TOTAL** | **8-10 min** | - |

**Minimum viable test**: 5 minutes (Visual + Inputs + Hobby + Responsive)

---

## 🎉 Success!

Jika semua test PASS:
1. ✅ Mark ticket as COMPLETE
2. 📸 Attach screenshots
3. 📝 Update documentation
4. 🚀 Ready for UAT/Production

---

**Happy Testing! 🚀**

**Quick Start**: Copy URL → Open Browser → Check Visual → Done!

```
http://localhost:8080/panitia/tambah-siswa
```

---

**Last Updated**: <?= date('Y-m-d H:i:s') ?>
