# 🚀 Quick Access Guide - Tambah Siswa

## ⚡ Super Quick Start (3 Steps)

### Step 1: Start Server ▶️
```bash
cd c:\xampp\htdocs\SPMB-Plus
php spark serve
```

### Step 2: Login 🔐
```
URL: http://localhost:8080/login
User: panitia
Pass: [your password]
```

### Step 3: Access Form 📝
```
URL: http://localhost:8080/panitia/tambah-siswa
OR: Click "Tambah Siswa" di sidebar
```

---

## 🎯 Important URLs

| Purpose | URL | Login Required |
|---------|-----|----------------|
| **Login Page** | `http://localhost:8080/login` | ❌ No |
| **Panitia Dashboard** | `http://localhost:8080/panitia` | ✅ Yes (panitia) |
| **Tambah Siswa** | `http://localhost:8080/panitia/tambah-siswa` | ✅ Yes (panitia) |
| **Daftar Siswa** | `http://localhost:8080/panitia/daftar-siswa` | ✅ Yes (panitia) |
| **Preview (No Login)** | `file:///c:/xampp/htdocs/SPMB-Plus/public/preview_modern_design.html` | ❌ No |

---

## 🔐 Default Credentials (Test)

### Panitia Account:
```
Username: panitia
Password: [check database]
Role: panitia
```

### If No Panitia User Exists:
```sql
-- Run in phpMyAdmin or mysql client
USE ppdb_spmb;
INSERT INTO users (username, password, email, role, is_active) 
VALUES (
    'panitia',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: password
    'panitia@test.com',
    'panitia',
    1
);
```

---

## ✅ Visual Checklist

### When Successfully Logged In:
- [ ] Sidebar visible on left (blue gradient)
- [ ] "Tambah Siswa" menu highlighted (white bg)
- [ ] Blue gradient header visible
- [ ] Progress steps showing (5 steps)
- [ ] Form sections loaded (4 cards)
- [ ] No console errors

### If You See:
- ❌ **404 Error** → Check login status
- ❌ **Redirect to login** → Login as panitia
- ❌ **Blank page** → Check server & database
- ❌ **Permission denied** → Check user role

---

## 🐛 Quick Fixes

### Problem: 404 Not Found
```bash
# Solution 1: Login first
Navigate to: http://localhost:8080/login

# Solution 2: Check server
ps aux | grep spark  # Check if server running
php spark serve      # Restart if needed
```

### Problem: Cannot Login
```bash
# Check database
mysql -u root ppdb_spmb -e "SELECT * FROM users WHERE role='panitia';"

# Clear session
rm -rf writable/session/*
php spark cache:clear
```

### Problem: Page Looks Broken
```bash
# Clear browser cache
Ctrl + Shift + Del → Clear cache

# Or use incognito
Ctrl + Shift + N
```

---

## 📱 Browser DevTools

### Open DevTools:
- Press `F12` or `Ctrl + Shift + I`

### Check Console:
- Go to "Console" tab
- Should have NO errors
- If errors exist, report them

### Check Network:
- Go to "Network" tab
- Reload page (Ctrl + R)
- Check for failed requests (red)

### Check Session:
```javascript
// In Console, type:
console.log(document.cookie);
// Should see ci_session cookie
```

---

## 🎨 What Should You See?

### Header:
```
╔═══════════════════════════════════╗
║  📋 TAMBAH SISWA BARU             ║
║  (Blue gradient background)       ║
╚═══════════════════════════════════╝
```

### Progress Steps:
```
① → ② → ③ → ④ → ⑤
Biodata → Asal Sekolah → Orang Tua → Lainnya → Review
```

### Form Sections:
```
╔════════════════════╗
║ 👤 DATA PRIBADI    ║
╠════════════════════╣
║ [Form fields...]   ║
╚════════════════════╝

╔════════════════════╗
║ 🏫 ASAL SEKOLAH    ║
╠════════════════════╣
║ [Form fields...]   ║
╚════════════════════╝

[...more sections...]
```

### Sidebar Menu (Active):
```
┌─────────────────────┐
│ PENDAFTARAN         │
│ ─────────────       │
│ □ Daftar Siswa      │
│ ■ Tambah Siswa      │ ← White bg, blue text
│ □ Verifikasi        │
│ □ Grafik Siswa      │
└─────────────────────┘
```

---

## 📊 Performance Check

### Page Load Time:
- **Target:** < 2 seconds
- **Acceptable:** < 5 seconds
- **Slow:** > 5 seconds (investigate)

### Check Load Time:
1. Open DevTools (F12)
2. Go to Network tab
3. Reload page (Ctrl + R)
4. Check "Load" time at bottom

---

## 🔗 Related Documentation

- 📖 **Full Testing Guide:** `TESTING_GUIDE.md`
- 🔧 **Troubleshooting:** `TROUBLESHOOTING_ACCESS.md`
- ✅ **Verification Checklist:** `FINAL_VERIFICATION_CHECKLIST.md`
- 🎨 **Visual Comparison:** `VISUAL_COMPARISON.md`
- 📚 **Documentation Index:** `REDESIGN_INDEX.md`

---

## 📞 Emergency Commands

### Server Not Running:
```bash
# Start server
cd c:\xampp\htdocs\SPMB-Plus
php spark serve

# Or specify port
php spark serve --port 8080
```

### Database Issues:
```bash
# Start XAMPP MySQL
# Open XAMPP Control Panel
# Click "Start" on MySQL

# Check database
mysql -u root -e "SHOW DATABASES;"
mysql -u root ppdb_spmb -e "SHOW TABLES;"
```

### Clear Everything:
```bash
# Clear all caches
php spark cache:clear

# Clear sessions
rm -rf writable/session/*

# Clear logs (optional)
rm -rf writable/logs/*
```

### Kill Server:
```bash
# Windows
netstat -ano | findstr :8080
taskkill /PID [PID] /F

# Or just Ctrl+C in terminal
```

---

## 🎯 Success Criteria

### ✅ Everything Working If:
1. Server starts without errors
2. Can access login page
3. Can login as panitia
4. Dashboard loads with sidebar
5. "Tambah Siswa" menu is clickable
6. Form loads with blue theme
7. All sections visible
8. Can interact with inputs
9. No console errors
10. Responsive on mobile

---

## 💡 Pro Tips

### Tip 1: Use Keyboard Shortcuts
- `Alt + Tab` → Switch windows
- `Ctrl + R` → Reload page
- `Ctrl + Shift + R` → Hard reload
- `F12` → Open DevTools
- `Ctrl + Shift + C` → Inspect element

### Tip 2: Bookmark URLs
Save these in browser:
- Login: `http://localhost:8080/login`
- Dashboard: `http://localhost:8080/panitia`
- Tambah Siswa: `http://localhost:8080/panitia/tambah-siswa`

### Tip 3: Multiple Browsers
Test in:
- Chrome (primary)
- Firefox (alternative)
- Edge (Windows default)

### Tip 4: Use Incognito
- No cache issues
- Fresh session each time
- Clean testing environment

### Tip 5: Keep Terminal Open
- See server logs in real-time
- Catch errors immediately
- Monitor requests

---

## 🎓 Learning Path

### For New Users:
1. Read this Quick Guide (5 min)
2. Follow 3-step Quick Start
3. Explore the form interface
4. Try filling out form
5. Check documentation for details

### For Developers:
1. Read `REDESIGN_INDEX.md`
2. Study `REDESIGN_HTML_TEMPLATE.md`
3. Review `app/Views/panitia/tambah_siswa.php`
4. Run full tests from `TESTING_GUIDE.md`
5. Verify with `FINAL_VERIFICATION_CHECKLIST.md`

### For Testers:
1. Follow this Quick Guide
2. Use `QUICK_TEST_GUIDE.md`
3. Document issues found
4. Use `TROUBLESHOOTING_ACCESS.md` for fixes

---

## ✨ Remember

> **Most common issue: Forgot to login! 🔐**

Always login first at `/login` before accessing panitia pages!

---

**Happy Testing! 🚀**

*Quick Access Guide v1.0*  
*Last Updated: January 14, 2026*
