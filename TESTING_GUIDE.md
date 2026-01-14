# 🧪 Testing Guide - Redesign Tambah Siswa

## Quick Start Testing

### Prerequisites
- ✅ XAMPP dengan MySQL running
- ✅ PHP 7.4 atau lebih tinggi
- ✅ Database sudah setup
- ✅ User panitia sudah ada di database

---

## 🚀 Step-by-Step Testing

### Step 1: Start Server
```bash
# Navigate to project directory
cd c:\xampp\htdocs\SPMB-Plus

# Start CodeIgniter development server
php spark serve
```

**Expected Output:**
```
CodeIgniter 4.x.x Development Server
(http://localhost:8080) started...
Press Ctrl-C to quit.
```

---

### Step 2: Login as Panitia

1. **Open Browser**
   ```
   URL: http://localhost:8080/login
   ```

2. **Login Credentials** (use existing panitia account)
   - Username: `panitia` (or your panitia username)
   - Password: `[your password]`

3. **After Login**
   - Should redirect to panitia dashboard
   - Sidebar should be visible with blue gradient

---

### Step 3: Access Tambah Siswa Page

1. **Click Menu**
   - Look at left sidebar
   - Find "Tambah Siswa" menu item
   - Click it

2. **Alternative Direct Access**
   ```
   URL: http://localhost:8080/panitia/tambah-siswa
   ```

3. **Verify Page Load**
   - Page should load without errors
   - Blue theme should be consistent
   - Modern design should be visible

---

## ✅ Visual Verification Checklist

### A. Sidebar Menu (Left Side)

**Check the following:**
- [ ] Sidebar has blue gradient background
- [ ] "Tambah Siswa" menu is highlighted (white background)
- [ ] Icon for "Tambah Siswa" is blue (fa-user-plus)
- [ ] Text is blue and bold
- [ ] Other menu items are white/transparent
- [ ] Hover effect works (white overlay + slide right)

**Expected Appearance:**
```
┌──────────────────────┐
│ PENDAFTARAN          │
│ ─────────────────    │
│ □ Daftar Siswa       │ ← Transparent
│ ■ Tambah Siswa       │ ← White background, ACTIVE
│ □ Verifikasi         │ ← Transparent
│ □ Grafik Siswa       │ ← Transparent
└──────────────────────┘
```

---

### B. Page Header

**Check the following:**
- [ ] Header has blue gradient background
- [ ] Title "TAMBAH SISWA BARU" is white and centered
- [ ] Icon (📋) is visible
- [ ] Shadow effect visible
- [ ] Border radius on corners
- [ ] Full width layout

**Expected Colors:**
- Background: Gradient from `#3b82f6` to `#2563eb`
- Text: White (`#ffffff`)
- Shadow: Blue tinted

---

### C. Progress Steps

**Check the following:**
- [ ] 5 steps are visible horizontally
- [ ] Each step has an icon
- [ ] Step 1: 👤 Biodata Diri
- [ ] Step 2: 🏫 Asal Sekolah
- [ ] Step 3: 👨‍👩‍👧 Data Orang Tua
- [ ] Step 4: ℹ️ Lainnya
- [ ] Step 5: ✅ Review
- [ ] Line connectors between steps
- [ ] Blue gradient on icons
- [ ] Responsive on mobile (vertical stack)

**Expected Layout:**
```
① ── ② ── ③ ── ④ ── ⑤
Biodata → Asal Sekolah → Orang Tua → Lainnya → Review
```

---

### D. Alert/Information Box

**Check the following:**
- [ ] Alert box is visible below progress steps
- [ ] Has "INFORMASI" badge with blue gradient
- [ ] Close button (×) on the right
- [ ] Border has blue accent
- [ ] List of instructions with bullet points
- [ ] Background is light gray/white
- [ ] Icon (ℹ️) is visible

**Click Test:**
- [ ] Close button (×) hides the alert
- [ ] Alert can be dismissed

---

### E. Form Sections

**Check each section:**

#### 1️⃣ Data Pribadi
- [ ] Card has shadow
- [ ] Header with gradient blue background
- [ ] Icon 👤 visible
- [ ] White text on header
- [ ] Form fields arranged in 2 columns (desktop)
- [ ] All required fields marked with *

**Fields to verify:**
- [ ] Nama Lengkap (with help text)
- [ ] NISN (with help text)
- [ ] NIK
- [ ] Tempat Lahir
- [ ] Tanggal Lahir (date picker)
- [ ] Jenis Kelamin (radio buttons)
- [ ] Agama (dropdown)
- [ ] Alamat (textarea)

#### 2️⃣ Data Asal Sekolah
- [ ] Card has shadow
- [ ] Header with gradient blue background
- [ ] Icon 🏫 visible
- [ ] Fields arranged properly

**Fields to verify:**
- [ ] Nama Sekolah Asal
- [ ] NPSN
- [ ] Alamat Sekolah

#### 3️⃣ Data Orang Tua
- [ ] Card has shadow
- [ ] Header with gradient blue background
- [ ] Icon 👨‍👩‍👧 visible
- [ ] Two subsections visible (Ayah & Ibu)

**Fields to verify:**
- [ ] Nama Ayah
- [ ] Pekerjaan Ayah
- [ ] Penghasilan Ayah
- [ ] Nama Ibu
- [ ] Pekerjaan Ibu
- [ ] Penghasilan Ibu

#### 4️⃣ Data Lainnya
- [ ] Card has shadow
- [ ] Header with gradient blue background
- [ ] Icon ℹ️ visible

**Fields to verify:**
- [ ] No. Telepon
- [ ] Email
- [ ] Hobi & Minat (multi-select with Select2)
- [ ] Cita-cita

---

### F. Hobby Multi-Select (Special Feature)

**Check the following:**
- [ ] Select2 dropdown is initialized
- [ ] Clicking opens dropdown list
- [ ] Can search in dropdown
- [ ] Selecting adds blue gradient tag
- [ ] Tag shows icon + text
- [ ] Tag has × button to remove
- [ ] Counter shows number of selected hobbies
- [ ] Multiple selections work properly

**Test Interaction:**
1. Click the hobby field
2. Select "Olahraga" → Blue tag appears
3. Select "Seni" → Another blue tag appears
4. Click × on a tag → Tag is removed
5. Counter updates correctly (e.g., "2 hobi dipilih")

**Expected Tag Appearance:**
```
┌────────────────┐
│ ⚽ Olahraga [×]│ ← Blue gradient background
└────────────────┘
```

---

### G. Action Buttons

**Check the following:**
- [ ] Buttons are sticky at bottom
- [ ] Visible when scrolling
- [ ] Two buttons: Reset and Simpan Data
- [ ] Reset button: White background, blue border
- [ ] Simpan button: Blue gradient background
- [ ] Both have icons
- [ ] Hover effect on both buttons
- [ ] Shadow effect visible

**Test Interaction:**
1. Scroll down → Buttons stay at bottom
2. Hover over Simpan → Gradient shifts
3. Hover over Reset → Border becomes darker

---

### H. Input Focus States

**Check the following:**
- [ ] Click on any text input
- [ ] Border changes to blue (#3b82f6)
- [ ] Transition is smooth (0.3s)
- [ ] Focus ring is visible
- [ ] Help text appears if available

**Test on these inputs:**
1. Nama Lengkap
2. NISN
3. Email
4. Alamat (textarea)

---

### I. Responsive Design

#### Desktop (> 992px)
- [ ] Sidebar visible on left
- [ ] Form fields in 2 columns
- [ ] Progress steps horizontal
- [ ] All spacing looks good
- [ ] Cards have proper width

#### Tablet (768px - 992px)
**Resize browser to ~800px width**
- [ ] Sidebar still visible
- [ ] Form fields still 2 columns
- [ ] Slightly tighter spacing
- [ ] Still looks professional

#### Mobile (< 768px)
**Resize browser to ~375px width**
- [ ] Form fields stack to 1 column
- [ ] Progress steps stack vertically
- [ ] Cards take full width
- [ ] Buttons stack vertically
- [ ] Touch-friendly sizing
- [ ] No horizontal scroll

**Use Chrome DevTools:**
1. Press F12
2. Toggle device toolbar (Ctrl+Shift+M)
3. Select "iPhone 12 Pro" or "Pixel 5"
4. Verify all elements are responsive

---

## 🎨 Color Verification

### Blue Theme Colors
Verify these colors appear correctly:

**Primary Blue:** `#3b82f6`
- [ ] Sidebar gradient top
- [ ] Section headers
- [ ] Input focus borders
- [ ] Button backgrounds
- [ ] Active menu text
- [ ] Icon colors

**Darker Blue:** `#2563eb`
- [ ] Sidebar gradient bottom
- [ ] Button hover state
- [ ] Gradient ends

**Light Blue:** `#60a5fa`
- [ ] Sidebar border (right edge)
- [ ] Subtle accents
- [ ] Hover highlights

---

## 🧪 Functionality Testing

### A. Form Validation
1. **Try to submit empty form:**
   - [ ] Validation errors should appear
   - [ ] Required fields highlighted
   - [ ] Error messages clear

2. **Fill invalid data:**
   - [ ] Email with wrong format
   - [ ] NISN with wrong length
   - [ ] Should show validation errors

3. **Fill valid data:**
   - [ ] Form should submit successfully
   - [ ] Success message appears
   - [ ] Data saved to database

---

### B. Reset Button
1. **Fill some form fields**
2. **Click "Reset" button:**
   - [ ] All fields cleared
   - [ ] Confirmation prompt (optional)
   - [ ] Form returns to initial state

---

### C. Help Text
1. **Click help icon (❓) on any field:**
   - [ ] Help text appears/toggles
   - [ ] Text is readable
   - [ ] Icon is blue

2. **Hover over help icon:**
   - [ ] Cursor changes to pointer
   - [ ] Slight color change

---

### D. Date Picker
1. **Click on "Tanggal Lahir" field:**
   - [ ] Calendar popup appears
   - [ ] Can select date
   - [ ] Format is correct (YYYY-MM-DD)

---

### E. Dropdown Menus
1. **Test "Agama" dropdown:**
   - [ ] All options visible
   - [ ] Can select option
   - [ ] Selected value displays

2. **Test "Penghasilan" dropdown (Ayah/Ibu):**
   - [ ] Options load correctly
   - [ ] Can select

---

## 🐛 Bug Check

### Common Issues to Check:
- [ ] No JavaScript errors in console (F12)
- [ ] No CSS broken/missing
- [ ] No 404 errors for assets
- [ ] Select2 loads correctly
- [ ] jQuery loads before Select2
- [ ] Images/icons load properly
- [ ] No layout shifts
- [ ] Smooth scrolling
- [ ] No z-index issues

**Open Browser Console:**
1. Press F12
2. Go to Console tab
3. Reload page
4. Check for errors (should be none)

---

## 📊 Performance Check

### Page Load Time
1. **Open DevTools (F12)**
2. **Go to Network tab**
3. **Reload page (Ctrl+R)**
4. **Check load time:**
   - [ ] Should be under 2 seconds
   - [ ] DOMContentLoaded: ~500ms
   - [ ] Load complete: ~1000ms

### Assets Loaded
- [ ] CSS loaded (inline, so immediate)
- [ ] jQuery CDN loaded (~30KB)
- [ ] Select2 CSS loaded (~10KB)
- [ ] Select2 JS loaded (~20KB)
- [ ] Total: ~60KB + HTML

---

## ✅ Final Checklist

### Before Approving:
- [ ] All visual elements match blue theme
- [ ] Sidebar menu active state works
- [ ] Progress steps visible and styled
- [ ] All form sections have proper cards
- [ ] Input focus states work
- [ ] Hobby multi-select works
- [ ] Buttons are sticky and styled
- [ ] Responsive on mobile/tablet
- [ ] No console errors
- [ ] Form validation works
- [ ] Data can be submitted
- [ ] Help texts are useful
- [ ] All icons display correctly

### Sign-Off:
```
Tested by: ___________________
Date: ___________________
Browser: ___________________
Result: [ ] PASS  [ ] FAIL
Notes: ___________________
```

---

## 🔧 Troubleshooting

### Issue: Select2 not working
**Solution:**
1. Check jQuery is loaded first
2. Check Select2 CSS and JS are loaded
3. Check browser console for errors
4. Verify initialization code runs

### Issue: Colors not matching
**Solution:**
1. Hard refresh browser (Ctrl+Shift+R)
2. Clear browser cache
3. Check inline styles in HTML
4. Verify CSS variables

### Issue: Responsive not working
**Solution:**
1. Check viewport meta tag in layout
2. Clear browser cache
3. Test in different browser
4. Check media query breakpoints

### Issue: Form not submitting
**Solution:**
1. Check CodeIgniter CSRF token
2. Verify controller method exists
3. Check validation rules
4. Check database connection

### Issue: Sidebar not showing active state
**Solution:**
1. Check current_url() function
2. Verify route matches
3. Clear route cache: `php spark cache:clear`
4. Check session data

---

## 📞 Support

If you encounter issues:
1. Check browser console for errors
2. Verify all files are properly saved
3. Clear browser cache
4. Restart development server
5. Check database connection

---

## 🎉 Success Criteria

**Redesign is successful if:**
1. ✅ Page loads without errors
2. ✅ Blue theme is consistent throughout
3. ✅ All interactive elements work
4. ✅ Form can be submitted successfully
5. ✅ Responsive design works on all devices
6. ✅ User experience is improved
7. ✅ Professional appearance achieved

---

**Happy Testing! 🚀**

*Testing Guide v1.0*
*Last Updated: 2024*
