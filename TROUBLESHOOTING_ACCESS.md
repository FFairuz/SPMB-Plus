# 🔍 Troubleshooting - Access Panitia Tambah Siswa

## Issue: 404 Not Found atau Redirect ke Login

### 📋 Problem Description
Saat mencoba akses `http://localhost:8080/panitia/tambah-siswa`, halaman mengembalikan:
- 404 Not Found error
- Atau redirect ke halaman login
- Atau blank page

---

## ✅ Solutions & Checks

### 1. **Pastikan Server Running**

#### Check if server is running:
```bash
# Method 1: Check curl response
curl -I http://localhost:8080

# Method 2: Check process
netstat -ano | findstr :8080

# Method 3: Try ping
ping localhost
```

#### Start the server:
```bash
cd c:\xampp\htdocs\SPMB-Plus
php spark serve
```

**Expected output:**
```
CodeIgniter 4.x.x Development Server
(http://localhost:8080) started at Tue Jan 14 2026 15:11:51
Press Ctrl-C to quit.
```

---

### 2. **Authentication Required (Most Common)**

#### Problem:
Halaman `panitia/tambah-siswa` memerlukan authentication dengan role **panitia**.

#### Solution:
**Anda HARUS login terlebih dahulu sebagai panitia!**

#### Steps:
1. **Buka halaman login:**
   ```
   http://localhost:8080/login
   ```

2. **Login dengan credentials panitia:**
   - Username: `panitia` (atau username panitia Anda)
   - Password: `[password Anda]`
   - Role: Panitia

3. **Setelah login berhasil:**
   - Akan redirect ke dashboard panitia
   - Sidebar panitia akan muncul di sebelah kiri
   - Sekarang bisa akses: `http://localhost:8080/panitia/tambah-siswa`

4. **Atau klik menu:**
   - Di sidebar, klik menu **"Tambah Siswa"**
   - Menu akan highlight dengan background putih
   - Form akan muncul dengan desain baru

---

### 3. **Check Database & User Panitia**

#### Verify panitia user exists:
```sql
-- Check di database
USE ppdb_spmb;
SELECT * FROM users WHERE role = 'panitia' LIMIT 5;
```

#### If no panitia user exists, create one:
```sql
-- Insert panitia user
INSERT INTO users (username, password, email, role, is_active) 
VALUES (
    'panitia',
    '$2y$10$...', -- Hashed password
    'panitia@example.com',
    'panitia',
    1
);
```

#### Or use PHP to create:
```php
// In tinker or controller
$userModel = new \App\Models\UserModel();
$userModel->insert([
    'username' => 'panitia',
    'password' => password_hash('password123', PASSWORD_DEFAULT),
    'email' => 'panitia@example.com',
    'role' => 'panitia',
    'is_active' => 1
]);
```

---

### 4. **Check Routes Configuration**

#### Verify routes are registered:
```bash
# Check routes file
cat app/Config/Routes.php | grep -A 2 "panitia/tambah-siswa"
```

**Expected output:**
```php
$routes->get('panitia/tambah-siswa', 'PanitiaController::tambah_siswa');
$routes->post('panitia/tambah-siswa', 'PanitiaController::tambah_siswa');
```

#### List all routes:
```bash
php spark routes
```

Look for:
```
+--------+---------------------------+-------------------------------+
| Method | Route                     | Handler                       |
+--------+---------------------------+-------------------------------+
| GET    | panitia/tambah-siswa     | \App\Controllers\Panitia...   |
| POST   | panitia/tambah-siswa     | \App\Controllers\Panitia...   |
+--------+---------------------------+-------------------------------+
```

---

### 5. **Check Controller Method**

#### Verify method exists:
```bash
# Search for method in controller
grep -n "function tambah_siswa" app/Controllers/PanitiaController.php
```

**Expected output:**
```
95:    public function tambah_siswa()
```

#### Verify requirePanitia() method:
```bash
grep -n "requirePanitia" app/Controllers/PanitiaController.php
```

This method checks if user is logged in with 'panitia' role.

---

### 6. **Check Session Configuration**

#### Verify session is working:
```php
// In controller or view
echo "Session role: " . session()->get('role');
echo "Session user: " . session()->get('username');
echo "Session logged: " . (session()->get('isLoggedIn') ? 'Yes' : 'No');
```

#### Check session files:
```bash
# Check writable/session directory
ls -la writable/session/
```

#### Clear session cache:
```bash
# Clear all caches
php spark cache:clear

# Or manually delete session files
rm -rf writable/session/*
```

---

### 7. **Browser Issues**

#### Clear browser cache:
- Press `Ctrl + Shift + Del`
- Select "Cached images and files"
- Select "Cookies and other site data"
- Clear data

#### Try Incognito/Private mode:
- Chrome: `Ctrl + Shift + N`
- Firefox: `Ctrl + Shift + P`
- Edge: `Ctrl + Shift + N`

#### Disable browser extensions:
- Some extensions might block requests
- Try disabling ad blockers, privacy extensions

---

### 8. **Port Conflict**

#### If port 8080 is already used:
```bash
# Kill existing process on port 8080 (Windows)
netstat -ano | findstr :8080
taskkill /PID [PID_NUMBER] /F

# Or use different port
php spark serve --port 8081
```

Then access: `http://localhost:8081/panitia/tambah-siswa`

---

### 9. **File Permissions**

#### Check writable directories:
```bash
# Ensure writable folders are writable
chmod -R 777 writable/
chmod -R 777 writable/cache/
chmod -R 777 writable/session/
chmod -R 777 writable/logs/
```

---

### 10. **Environment Configuration**

#### Check .env file:
```bash
cat .env
```

#### Verify important settings:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080'

database.default.hostname = localhost
database.default.database = ppdb_spmb
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi

session.driver = 'CodeIgniter\Session\Handlers\FileHandler'
session.cookieName = 'ci_session'
session.expiration = 7200
session.savePath = WRITEPATH . 'session'
```

---

## 🔍 Debug Checklist

Use this checklist to debug the issue:

- [ ] **Server is running** (php spark serve)
- [ ] **MySQL/Database is running** (XAMPP Control Panel)
- [ ] **Database exists and populated**
- [ ] **Panitia user exists in database**
- [ ] **Logged in as panitia** (check session)
- [ ] **Routes are registered** (php spark routes)
- [ ] **Controller method exists**
- [ ] **View file exists** (app/Views/panitia/tambah_siswa.php)
- [ ] **No PHP errors** (check writable/logs/log-*.log)
- [ ] **Session is working** (check writable/session/)
- [ ] **Browser cache cleared**
- [ ] **Correct URL** (http://localhost:8080/panitia/tambah-siswa)

---

## 🚀 Quick Test Procedure

### Complete Test from Scratch:

```bash
# 1. Navigate to project
cd c:\xampp\htdocs\SPMB-Plus

# 2. Start XAMPP MySQL (if not running)
# Open XAMPP Control Panel -> Start MySQL

# 3. Verify database
mysql -u root -e "USE ppdb_spmb; SHOW TABLES;"

# 4. Clear caches
php spark cache:clear
rm -rf writable/session/*

# 5. Start server
php spark serve

# 6. In browser, open: http://localhost:8080/login

# 7. Login as panitia

# 8. Click "Tambah Siswa" in sidebar
#    OR navigate to: http://localhost:8080/panitia/tambah-siswa

# 9. Verify:
#    - Menu is highlighted (white background)
#    - Form loads with blue gradient header
#    - Progress steps visible
#    - All sections visible
```

---

## 🎯 Expected Behavior

### When Everything Works Correctly:

1. **URL:** `http://localhost:8080/panitia/tambah-siswa`

2. **After Login as Panitia:**
   - Sidebar visible on left with blue gradient
   - Menu "Tambah Siswa" highlighted (white background, blue text)
   - Main content area shows the form

3. **Form Appearance:**
   - ✅ Blue gradient header "TAMBAH SISWA BARU"
   - ✅ Progress steps (5 steps) with icons
   - ✅ Alert box with blue theme
   - ✅ 4 main sections (cards with shadows)
   - ✅ Modern input fields
   - ✅ Multi-select hobby (Select2)
   - ✅ Sticky action buttons at bottom

4. **Response Time:**
   - Page should load in < 2 seconds
   - No console errors
   - Smooth rendering

---

## 📸 Visual Verification

### What You Should See:

```
┌────────────────────────────────────────────────────────────┐
│  [Sidebar - Blue Gradient]  │  [Main Content]             │
│                              │                              │
│  PENDAFTARAN                 │  ╔══════════════════════╗  │
│  ──────────────              │  ║ 📋 TAMBAH SISWA BARU ║  │
│  □ Daftar Siswa              │  ╚══════════════════════╝  │
│  ■ Tambah Siswa ← ACTIVE     │                              │
│  □ Verifikasi                │  ① → ② → ③ → ④ → ⑤         │
│  □ Grafik Siswa              │  [Progress Steps]           │
│                              │                              │
│                              │  ╔══════════════════════╗  │
│                              │  ║ ℹ️ INFORMASI         ║  │
│                              │  ╚══════════════════════╝  │
│                              │                              │
│                              │  ╔══════════════════════╗  │
│                              │  ║ 👤 DATA PRIBADI      ║  │
│                              │  ║ [Form fields...]     ║  │
│                              │  ╚══════════════════════╝  │
│                              │                              │
│                              │  [More sections...]         │
│                              │                              │
│                              │  ╔══════════════════════╗  │
│                              │  ║ 🔄 Reset  💾 Simpan  ║  │
│                              │  ╚══════════════════════╝  │
└────────────────────────────────────────────────────────────┘
```

---

## 🆘 Still Having Issues?

### If nothing works:

1. **Check error logs:**
   ```bash
   tail -f writable/logs/log-$(date +%Y-%m-%d).log
   ```

2. **Enable debugging:**
   ```php
   // In .env
   CI_ENVIRONMENT = development
   
   // Shows detailed errors
   ```

3. **Test basic route:**
   ```
   http://localhost:8080/
   ```
   If this doesn't work, there's a server/config issue.

4. **Reinstall dependencies:**
   ```bash
   composer install
   ```

5. **Check PHP version:**
   ```bash
   php -v
   # Should be >= 7.4
   ```

6. **Check database connection:**
   ```bash
   php spark db:table users
   ```

---

## ✅ Success Indicators

You'll know it's working when:
- ✅ No 404 errors
- ✅ No redirect to login (after logging in)
- ✅ Sidebar shows on left
- ✅ "Tambah Siswa" menu is highlighted
- ✅ Blue gradient header visible
- ✅ Progress steps visible
- ✅ Form sections load properly
- ✅ No console errors (F12)
- ✅ Can interact with form elements

---

## 🎓 Common Mistakes

### 1. **Forgot to Login**
❌ Directly accessing `panitia/tambah-siswa` without login  
✅ Login first at `/login` with panitia credentials

### 2. **Wrong Role**
❌ Logged in as 'admin' or 'applicant'  
✅ Must be logged in as 'panitia'

### 3. **Server Not Running**
❌ Forgot to run `php spark serve`  
✅ Always check server is running

### 4. **Using Production Environment**
❌ `.env` has `CI_ENVIRONMENT = production`  
✅ Use `development` for debugging

### 5. **Browser Cache**
❌ Old cached version showing  
✅ Clear cache or use incognito

---

**Happy Testing! 🚀**

*Troubleshooting Guide v1.0*  
*Last Updated: January 14, 2026*
