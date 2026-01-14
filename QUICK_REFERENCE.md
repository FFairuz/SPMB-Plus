# Quick Reference - SPMB-Plus Features

## 🚀 Quick Start

### 1. Logo & Nama Aplikasi Dinamis
```php
// Di view manapun
<?= app_name() ?>          // Nama aplikasi
<?= app_logo() ?>          // URL logo
<?= app_description() ?>   // Deskripsi
<?= school_name() ?>       // Nama sekolah
```

**Ubah Settings:**
1. Login sebagai Admin
2. Buka `/admin/settings`
3. Edit nama, upload logo, ubah deskripsi
4. Simpan

---

### 2. Cetak Bukti Pembayaran

**URL:**
- Admin: `/admin/payment/print-receipt/{id}`
- Applicant: `/applicant/payment/print-receipt/{id}`

**Requirement:**
- Status harus `confirmed`

**Tombol di View:**
```html
<a href="<?= base_url('admin/payment/print-receipt/' . $payment['id']); ?>" 
   class="btn btn-primary" target="_blank">
    <i class="bi bi-printer-fill"></i> Cetak Bukti
</a>
```

---

### 3. Status Badges

**HTML:**
```html
<span class="status-badge status-pending">
    <i class="bi bi-clock"></i>
    <span class="status-text">Pending</span>
</span>
```

**Classes Available:**
- `status-pending` - Orange
- `status-submitted` - Blue
- `status-verified` - Purple
- `status-accepted` - Green
- `status-rejected` - Red
- `status-waiting-list` - Yellow

**CSS Import:**
```html
<link rel="stylesheet" href="<?= base_url('css/status-badges.css') ?>">
```

---

## 📝 Common Tasks

### Upload Logo Baru
1. Login Admin → `/admin/settings`
2. Scroll ke "Logo Aplikasi"
3. Click "Choose File"
4. Select PNG/JPG (max 2MB)
5. Click "Simpan"
6. Logo langsung berubah di navbar & login

### Cetak Bukti Pembayaran
1. Login Admin → `/admin/payments`
2. Filter "Dikonfirmasi"
3. Click "Cetak Bukti" pada row
4. Window baru terbuka
5. Click "Cetak Bukti" atau Ctrl+P

### Ubah Warna Status Badge
Edit `public/css/status-badges.css`:
```css
.status-badge.status-pending {
    border-color: #YOUR_COLOR;
    color: #YOUR_COLOR;
}
```

---

## 🔍 Troubleshooting

### Logo Tidak Muncul
```bash
# Cek folder exists
ls public/uploads/logo/

# Set permission
chmod 755 public/uploads/logo/

# Clear cache
php spark cache:clear
```

### Bukti Pembayaran Error
```sql
-- Cek status payment
SELECT payment_status FROM payments WHERE id = ?;

-- Harus 'confirmed'
UPDATE payments SET payment_status = 'confirmed' WHERE id = ?;
```

### Helper Function Not Found
```php
// Cek Autoload.php
// app/Config/Autoload.php
public $helpers = ['settings'];
```

---

## 💡 Tips & Tricks

### 1. Custom Nama Petugas
Edit `print_receipt.php` line ~342:
```php
$petugasName = 'Nama Anda';
```

### 2. Custom Lokasi/Kota
Edit `print_receipt.php` line ~334:
```php
Kota Anda, <?= date('d F Y', ...) ?>
```

### 3. Testing Terbilang
```php
echo terbilang(1000000); // "satu juta"
echo terbilang(250000);  // "dua ratus lima puluh ribu"
```

### 4. Force White Status Badge
Add to any page:
```html
<link rel="stylesheet" href="<?= base_url('css/status-badges.css') ?>">
```

### 5. Force Gradient Status Badge
Add to any page:
```html
<link rel="stylesheet" href="<?= base_url('css/status-badges-gradient.css') ?>">
```

---

## 🎨 Color Palette

### Status Colors
| Status | Color | Hex |
|--------|-------|-----|
| Pending | Orange | #f59e0b |
| Submitted | Blue | #3b82f6 |
| Verified | Purple | #8b5cf6 |
| Accepted | Green | #10b981 |
| Rejected | Red | #ef4444 |
| Waiting | Yellow | #eab308 |

### App Colors
| Element | Color | Hex |
|---------|-------|-----|
| Primary | Blue | #3b82f6 |
| Secondary | Gray | #64748b |
| Success | Green | #10b981 |
| Danger | Red | #ef4444 |
| Warning | Orange | #f59e0b |
| Info | Cyan | #06b6d4 |

---

## 📦 Files Quick Access

### Controllers
- `app/Controllers/PaymentController.php` - Payment & print receipt
- `app/Controllers/SettingsController.php` - App settings

### Views
- `app/Views/payment/print_receipt.php` - Bukti pembayaran template
- `app/Views/layout/app.php` - Main layout dengan logo dinamis
- `app/Views/auth/login.php` - Login page dengan logo dinamis

### CSS
- `public/css/status-badges.css` - White badge design
- `public/css/status-badges-gradient.css` - Gradient badge design
- `public/css/dynamic-logo.css` - Logo styling

### Helpers
- `app/Helpers/settings_helper.php` - Settings functions

### Documentation
- `DYNAMIC_LOGO_IMPLEMENTATION.md` - Logo feature docs
- `PRINT_RECEIPT_FEATURE.md` - Print receipt docs
- `IMPLEMENTATION_SUMMARY_2026-01-14.md` - Summary

---

## 🔗 Important URLs

### Admin URLs
- Dashboard: `/admin/dashboard`
- Payments: `/admin/payments`
- Settings: `/admin/settings`
- Print Receipt: `/admin/payment/print-receipt/{id}`

### Applicant URLs
- Dashboard: `/applicant/dashboard`
- Payment: `/applicant/payment`
- Print Receipt: `/applicant/payment/print-receipt/{id}`

### Preview URLs
- Status Badge Preview: `/status-badge-preview.html`
- Badge Comparison: `/status-badge-white-vs-gradient.html`

---

## 🧪 Test Commands

```bash
# Test dynamic logo
php test_dynamic_logo.php

# Clear cache
php spark cache:clear

# Run migration
php spark migrate

# Check routes
php spark routes

# Start server
php spark serve
```

---

## 📞 Quick Support

**Issue:** Logo tidak muncul  
**Fix:** Cek folder `public/uploads/logo/` dan permissions

**Issue:** Print tidak rapi  
**Fix:** Set browser zoom 100%, pilih A4, margins minimal

**Issue:** Helper not found  
**Fix:** Add `'settings'` ke `app/Config/Autoload.php → $helpers`

**Issue:** Status badge tidak colorful  
**Fix:** Import CSS: `<link rel="stylesheet" href="<?= base_url('css/status-badges.css') ?>">`

---

**Last Updated:** 14 Januari 2026  
**Version:** 1.0
