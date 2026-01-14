# 🔧 CSS Conflict Fix - Tambah Siswa

## Problem Identified

Desain modern yang sudah dibuat mengalami conflict dengan CSS global dari `app/Views/layout/app.php`.

### Konflik Utama:
1. `.main-content` di layout memiliki `background-color: var(--light-bg)`
2. CSS di view tidak memiliki specificity yang cukup tinggi
3. Beberapa selector tidak menggunakan scoping prefix

---

## Solution Applied

### 1. Added Wrapper Container
```html
<div class="tambah-siswa-container">
    <!-- All content here -->
</div>
```

### 2. CSS Scoping Strategy
- Gunakan `.tambah-siswa-container` sebagai prefix untuk semua selector
- Ini memberikan specificity lebih tinggi dari CSS global
- Menghindari penggunaan `!important` yang berlebihan

### 3. Key CSS Updates
```css
/* Wrapper dengan background */
.tambah-siswa-container {
    background: #f8f9fa;
    min-height: 100vh;
    margin: -32px;
    padding: 32px;
}

/* Prefix untuk semua child elements */
.tambah-siswa-container .page-header { ... }
.tambah-siswa-container .progress-steps { ... }
.tambah-siswa-container .section-card { ... }
```

---

## Implementation Status

### ✅ Completed:
- [x] Added wrapper div `.tambah-siswa-container`
- [x] Updated `.page-header` selectors
- [x] Updated `.progress-steps` selectors
- [x] Wrapper opening and closing tags added

### ⚠️ In Progress:
- [ ] Need to update ALL remaining selectors with prefix
- [ ] Test in browser to verify no conflicts
- [ ] Optimize for performance

---

## Quick Fix Instructions

If you're still seeing layout issues:

### Option 1: Add !important (Quick but not recommended)
```css
.tambah-siswa-container {
    background: #f8f9fa !important;
    min-height: 100vh !important;
}
```

### Option 2: Use Inline Styles (Temporary)
```html
<div class="tambah-siswa-container" style="background: #f8f9fa; min-height: 100vh; margin: -32px; padding: 32px;">
```

### Option 3: Override in head section (Recommended)
Add this in the `<head>` section of tambah_siswa.php:
```html
<style>
body .main-content {
    background: transparent !important;
}
.tambah-siswa-container {
    background: #f8f9fa !important;
    min-height: 100vh !important;
    margin: -32px !important;
    padding: 32px !important;
}
</style>
```

---

## Testing Checklist

### Visual Verification:
- [ ] Background is light gray (#f8f9fa), not purple/blue
- [ ] Header has blue gradient
- [ ] Progress steps visible and styled
- [ ] Cards have proper shadows and spacing
- [ ] No elements "bleeding" outside container
- [ ] Responsive design works on mobile

### Browser Console:
- [ ] No CSS errors
- [ ] No JavaScript errors
- [ ] Styles are being applied (check DevTools)

---

## Browser DevTools Debug

### How to Debug:
1. **Open page:** `http://localhost:8080/panitia/tambah-siswa`
2. **Press F12** to open DevTools
3. **Go to Elements tab**
4. **Find `.tambah-siswa-container`**
5. **Check Styles panel**

### What to Look For:
- Strikethrough styles = overridden
- Check which rule has higher specificity
- Look for `!important` flags
- Check computed styles

### Quick Fixes in DevTools:
```css
/* If background is wrong */
.tambah-siswa-container {
    background: #f8f9fa !important;
}

/* If margin/padding is wrong */
.tambah-siswa-container {
    margin: -32px !important;
    padding: 32px !important;
}

/* If .main-content is interfering */
body .main-content {
    background: transparent !important;
}
```

---

## Next Steps

1. **Test Current Implementation**
   - Login sebagai panitia
   - Access `/panitia/tambah-siswa`
   - Check if design looks correct

2. **If Still Broken:**
   - Apply quick fix Option 3 above
   - Report specific issues
   - Screenshot problem areas

3. **For Production:**
   - Complete selector prefix updates
   - Remove any !important flags
   - Optimize CSS
   - Minify if needed

---

## Files Modified

- ✅ `app/Views/panitia/tambah_siswa.php`
  - Added wrapper div
  - Updated CSS selectors (partial)
  - Added scoping prefix

---

*CSS Conflict Fix Documentation*
*Last Updated: January 14, 2026*
