# ✅ REDESIGN TAMBAH SISWA - VISUAL CHECKLIST

## Quick Visual Verification Guide

Gunakan checklist ini untuk verifikasi visual cepat dalam **2 menit**.

---

## 🎯 URL Test

```
http://localhost:8080/panitia/tambah-siswa
```

---

## ✅ Visual Elements Checklist

### 📱 Page Load (First Impression)

Saat halaman pertama kali dimuat, cek:

- [ ] **Background abu-abu terang** (bukan putih polos)
- [ ] **Header dengan gradient purple** tampil di atas
- [ ] **Icon besar di header** (person-plus icon dalam circle)
- [ ] **Judul "Tambah Siswa Baru"** dengan subtitle di bawahnya
- [ ] **Pattern/texture** terlihat di header (subtle circles)

**🚨 FAIL jika**: Header putih polos tanpa gradient

---

### 📊 Progress Steps

Tepat di bawah header, cek:

- [ ] **4 langkah terlihat** dalam satu baris (atau wrap di mobile)
- [ ] **Bulatan dengan angka/icon** untuk setiap step
- [ ] **Step 1 (Data Pribadi)** highlighted dengan warna purple
- [ ] **Line connector** menghubungkan steps (horizontal line)
- [ ] **Label text** di bawah setiap bulatan

**Visual:**
```
 (🟣) ━━━ (⚪) ━━━ (⚪) ━━━ (⚪)
  👤      🏠      🎓      ✅
```

**🚨 FAIL jika**: Tidak ada progress indicator sama sekali

---

### 🃏 Section Cards

Scroll ke bawah, cek ada **6 section cards**:

#### Card 1: Data Pribadi
- [ ] **White card** dengan rounded corners
- [ ] **Shadow** terlihat di bawah card
- [ ] **Icon purple** di header (person icon dalam kotak gradient)
- [ ] **Judul "Data Pribadi"** besar dan bold
- [ ] **Subtitle** kecil di bawah judul
- [ ] **Fields**: NIK, Nama Lengkap, Jenis Kelamin, Tempat Lahir, Tanggal Lahir

#### Card 2: Data Keluarga & Agama
- [ ] **Icon purple** (people/family icon)
- [ ] **Judul "Data Keluarga & Agama"**
- [ ] **Fields**: Agama, Anak Ke, Jumlah Saudara

#### Card 3: Alamat Lengkap
- [ ] **Icon purple** (location/geo icon)
- [ ] **Judul "Alamat Lengkap"**
- [ ] **Fields**: Alamat Jalan, Dusun, Kelurahan, Kecamatan, Kabupaten, Provinsi, Kode Pos

#### Card 4: Informasi Kontak
- [ ] **Icon purple** (phone icon)
- [ ] **Judul "Informasi Kontak"**
- [ ] **Field**: Nomor HP dengan icon di kiri input

#### Card 5: Pendidikan & Minat ⭐
- [ ] **Icon purple** (graduation cap icon)
- [ ] **Judul "Pendidikan & Minat"**
- [ ] **Fields**: Sekolah Asal (dropdown + button), Jurusan, Hobi (multi-select)

#### Card 6: Data Orang Tua
- [ ] **Icon purple** (person-badge icon)
- [ ] **Judul "Data Orang Tua"**
- [ ] **Fields**: Nama Ayah, Nama Ibu
- [ ] **Action buttons** di bottom card (Batal & Simpan)

**🚨 FAIL jika**: Cards tampak flat tanpa shadow atau icon tidak ada

---

### 📝 Form Fields

Cek setiap input field:

- [ ] **Border 2px** solid (bukan 1px tipis)
- [ ] **Rounded corners** (tidak kotak tajam)
- [ ] **Placeholder text** terlihat abu-abu terang
- [ ] **Required badge merah** di label (tulisan "WAJIB")
- [ ] **Focus effect**: Klik field → border jadi purple

**Test Focus:**
1. Klik field NIK
2. Border harus berubah warna purple
3. Ada shadow glow purple di sekitar field

**🚨 FAIL jika**: Border tetap abu-abu saat diklik

---

### ❤️ Hobby Multi-Select ⭐ CRITICAL

Ini fitur paling penting! Cek dengan teliti:

#### Visual Closed (Sebelum diklik)
- [ ] **Dropdown field** dengan border rounded
- [ ] **Label** dengan icon heart (❤️)
- [ ] **Placeholder** "✨ Pilih hobi yang diminati..."

#### Visual Open (Setelah diklik dropdown)
- [ ] **Dropdown list** muncul dengan styling modern
- [ ] **Search box** di atas list
- [ ] **Options** dengan icon kecil di sebelah kiri text

#### Visual Selected (Setelah pilih hobi)
- [ ] **Gradient purple tags** muncul dalam field
- [ ] **Setiap tag** punya icon unik (⚽, 🎵, 🎨, dll)
- [ ] **Remove button (×)** di setiap tag
- [ ] **Counter** di bawah: "X hobi dipilih 🎯"
- [ ] **Tags shine/glossy** (gradient effect visible)

**Visual Check:**
```
┌────────────────────────────────────┐
│ [⚽ Futsal ×] [🎵 Musik ×]         │
│   ^gradient    ^gradient           │
│   purple       purple              │
└────────────────────────────────────┘
ℹ️ 2 hobi dipilih 🎯
```

**Test Actions:**
1. Klik dropdown hobi
2. Pilih "Futsal" → Tag purple muncul
3. Pilih "Musik" → Tag kedua muncul
4. Cek counter: "2 hobi dipilih 🎯"
5. Klik × pada "Futsal" → Tag hilang
6. Counter update: "1 hobi dipilih 🎯"

**🚨 FAIL jika**: 
- Tags muncul tapi **PUTIH** (bukan purple gradient)
- Tags muncul tapi **TIDAK ADA ICON**
- Counter tidak update
- Tidak bisa remove tag

**🔧 FIX**: Cek `FIX_HOBBY_SCRIPT_LOADING.md`

---

### 🏫 School Management

#### Dropdown Sekolah
- [ ] **Dropdown** dengan list sekolah
- [ ] **Button hijau** "Tambah Sekolah" di samping
- [ ] **Info text** di bawah: "NPSN akan terisi otomatis..."

#### Modal Tambah Sekolah
1. Klik button "Tambah Sekolah"
2. Cek modal:
   - [ ] **Header gradient hijau** (bukan purple)
   - [ ] **Icon building** di header
   - [ ] **Judul besar** "Tambah Sekolah Baru"
   - [ ] **Subtitle** di bawah judul
   - [ ] **Info banner biru** dengan icon
   - [ ] **Form fields** dengan styling modern
   - [ ] **Buttons** di footer (Batal & Simpan Sekolah)

**🚨 FAIL jika**: Modal tampil tapi header tidak hijau

---

### 🔘 Action Buttons (Bottom Sticky)

Scroll ke paling bawah:

- [ ] **2 buttons** terlihat: "Batal" (abu) dan "Simpan Data Siswa" (purple)
- [ ] **Buttons sticky** di bottom (tidak scroll)
- [ ] **Gradient purple** di button primary
- [ ] **Shadow** di bawah buttons
- [ ] **Icons** di setiap button (× dan ✓)
- [ ] **Hover effect**: Button terangkat sedikit saat di-hover

**Test Hover:**
1. Hover mouse ke button "Simpan Data Siswa"
2. Button harus terangkat (translateY effect)
3. Shadow bertambah besar

**🚨 FAIL jika**: Buttons scroll hilang atau tidak sticky

---

### 🎨 Color Verification

Cek warna-warna ini ada di halaman:

- [ ] **Purple gradient** (header, icons, tags, buttons)
- [ ] **Green gradient** (modal sekolah)
- [ ] **Red** (required badges, errors)
- [ ] **Gray** (borders, backgrounds)
- [ ] **White** (cards, inputs)
- [ ] **Blue** (info badges)

**🚨 FAIL jika**: Semua warna flat/basic tanpa gradient

---

## 📱 Responsive Check (BONUS - 1 menit)

### Desktop (1920px)
- [ ] Layout **2-3 kolom**
- [ ] Buttons **align right**
- [ ] All cards **side-by-side** (some)

### Mobile (375px)
1. Buka DevTools (F12)
2. Toggle device mode (Ctrl+Shift+M)
3. Pilih "iPhone SE"
4. Cek:
   - [ ] Header **compact** tapi tetap ada gradient
   - [ ] Progress steps **wrap** atau **stack**
   - [ ] Cards **full width**
   - [ ] Form fields **full width** (1 kolom)
   - [ ] Buttons **stack vertical** (Batal di atas, Simpan di bawah)
   - [ ] Buttons **full width**

**🚨 FAIL jika**: Elemen terpotong atau overlap di mobile

---

## ⚡ Super Quick Check (30 Detik)

Jika hanya punya 30 detik, cek 5 hal ini:

1. ✅ **Gradient purple di header** - Pass/Fail?
2. ✅ **Progress steps tampil** - Pass/Fail?
3. ✅ **Cards punya shadow** - Pass/Fail?
4. ✅ **Hobi tags berwarna purple** - Pass/Fail?
5. ✅ **Buttons di bottom sticky** - Pass/Fail?

**If ALL PASS → SUCCESS! ✅**

---

## 🎯 Critical Elements (MUST PASS)

Ini 3 elemen yang WAJIB pass:

### 1. Gradient Header ⭐
```
╔════════════════════════════════════╗
║ 🎨 PURPLE GRADIENT                ║
║ 👤 Tambah Siswa Baru              ║
╚════════════════════════════════════╝
```
**Status**: [ ] Pass / [ ] Fail

### 2. Gradient Hobby Tags ⭐⭐⭐
```
[⚽ Futsal ×] [🎵 Musik ×]
 ^purple      ^purple
```
**Status**: [ ] Pass / [ ] Fail

### 3. Modern Cards ⭐
```
╔════════════════════════════════════╗
║ 👤 Data Pribadi                   ║
║ [form fields]                     ║
╚════════════════════════════════════╝
└─ Has shadow & hover effect
```
**Status**: [ ] Pass / [ ] Fail

**🚨 If ANY of these 3 FAIL → STOP and fix immediately!**

---

## 🐛 Common Visual Bugs

### Bug 1: Hobi Tags Putih (Tidak Ada Gradient)
**What you see**: Tags muncul tapi warna putih/abu
**Expected**: Tags berwarna purple gradient

**Cause**: Select2 CSS tidak load atau override issue

**Quick check**: F12 → Elements → Inspect tag → Computed styles
- Look for: `background: linear-gradient(...)`
- Should be: purple gradient values

### Bug 2: Header Tidak Ada Gradient
**What you see**: Header putih atau solid color
**Expected**: Purple gradient background

**Cause**: CSS tidak load atau browser cache

**Quick fix**: Hard reload (Ctrl+F5)

### Bug 3: Cards Flat (No Shadow)
**What you see**: Cards terlihat flat/datar
**Expected**: Cards punya shadow di bawah

**Cause**: box-shadow CSS tidak apply

**Quick check**: Inspect card → Computed → box-shadow should exist

### Bug 4: Buttons Tidak Sticky
**What you see**: Buttons scroll hilang
**Expected**: Buttons tetap di bottom saat scroll

**Cause**: position: sticky tidak apply

**Quick check**: Scroll halaman, buttons harus tetap visible

---

## 📸 Screenshot Checklist

Ambil screenshot untuk dokumentasi:

- [ ] Full page view (desktop)
- [ ] Header close-up (show gradient)
- [ ] Progress steps (show active state)
- [ ] Section cards (show shadow on hover)
- [ ] Hobby tags (show gradient purple tags)
- [ ] Modal sekolah (show green gradient)
- [ ] Mobile view (full page iPhone SE)
- [ ] Error state (if applicable)

---

## ✅ Final Verification

Sebelum declare "PASS", pastikan:

- [ ] ✅ Visual appeal: Modern & beautiful
- [ ] ✅ All gradients present (purple, green)
- [ ] ✅ All icons visible
- [ ] ✅ All shadows visible
- [ ] ✅ Hobby tags with gradient
- [ ] ✅ Responsive on mobile
- [ ] ✅ No console errors (major)
- [ ] ✅ All buttons clickable

**Overall Status**: [ ] PASS ✅ / [ ] FAIL ❌

---

## 🎊 Success Criteria

**PASS Grade A+** if:
- All visual elements present ✅
- Gradient effects visible ✅
- Hobby tags gradient purple ✅
- Responsive works ✅
- No major bugs ✅

**PASS Grade A** if:
- Minor visual issues (1-2)
- All core features work
- Hobby tags gradient present

**PASS Grade B** if:
- Some visual polish needed
- All features functional

**FAIL** if:
- Hobby tags tidak ada gradient
- Layout broken
- Major bugs present

---

## 🚀 Quick Action Items

After visual check, if:

### All PASS ✅
- [ ] Mark as verified
- [ ] Take screenshots
- [ ] Proceed to functional testing
- [ ] Ready for UAT

### Some FAIL ❌
- [ ] Document specific issues
- [ ] Check browser console
- [ ] Review CSS loading
- [ ] Clear cache and retry
- [ ] Check `QUICK_TEST_GUIDE.md` troubleshooting

---

**Quick Visual Check Complete!** 🎨✅

**Time**: 2-5 minutes  
**Focus**: Visual appearance only  
**Next**: Functional testing (see `QUICK_TEST_GUIDE.md`)

---

**Last Updated**: <?= date('Y-m-d H:i:s') ?>
