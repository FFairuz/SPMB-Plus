# 🔐 Login Error Handling

## 📋 Overview
Sistem login telah diimplementasikan dengan error handling lengkap untuk berbagai scenario.

---

## ✅ Scenario Testing

### 1️⃣ Login Berhasil ✅
**Input:**
- Email: `admin@ppdb.local`
- Password: `password123`

**Output:** 
- ✅ Login berhasil
- 🔄 Redirect ke dashboard sesuai role
- 📍 Session dibuat

**Expected:** Dashboard admin muncul

---

### 2️⃣ Email Salah ❌
**Input:**
- Email: `salah@email.com` (tidak terdaftar)
- Password: `password123`

**Output:**
```
⚠️  Alert: "Email atau password salah"
```

**Behavior:**
- Tetap di halaman login
- Form kosong (tidak ada data tersimpan)
- User tidak bisa akses dashboard
- Log: `LOGIN FAILED - User not found: salah@email.com`

---

### 3️⃣ Password Salah ❌
**Input:**
- Email: `admin@ppdb.local` (benar)
- Password: `passwordsalah` (salah)

**Output:**
```
⚠️  Alert: "Email atau password salah"
```

**Behavior:**
- Tetap di halaman login
- Form kosong
- User tidak bisa akses dashboard
- Log: `LOGIN FAILED - Invalid password: admin@ppdb.local`

**Alasan:** Untuk keamanan, tidak membedakan "email tidak ditemukan" vs "password salah"  
✅ Prevents username enumeration attacks

---

### 4️⃣ Email & Password Kosong ❌
**Input:**
- Email: (kosong)
- Password: (kosong)

**Output:**
```
⚠️  Alert: "Email dan password harus diisi"
```

**Behavior:**
- Tetap di halaman login
- Validation error
- Form tidak di-submit

---

### 5️⃣ Akun Tidak Aktif ❌
**Input:**
- Email: (akun inactive)
- Password: (benar)

**Output:**
```
⚠️  Alert: "Akun Anda tidak aktif. Hubungi administrator"
```

**Behavior:**
- Tetap di halaman login
- Account status dicheck setelah password verify
- Log: `LOGIN FAILED - Account inactive: [email]`

---

## 🔍 Implementation Details

### Flow Diagram
```
┌─────────────────────────────────┐
│   User Submit Login Form         │
└────────────┬──────────────────────┘
             │
             ▼
┌─────────────────────────────────┐
│ Check: Email & Password Empty?  │
├─────────────────────────────────┤
│ YES: Show "harus diisi" error   │
│ NO:  Continue                   │
└────────────┬──────────────────────┘
             │
             ▼
┌─────────────────────────────────┐
│   Query User by Email           │
├─────────────────────────────────┤
│ NOT FOUND: Show generic error   │
│ FOUND: Continue                 │
└────────────┬──────────────────────┘
             │
             ▼
┌─────────────────────────────────┐
│ Verify Password with bcrypt     │
├─────────────────────────────────┤
│ INVALID: Show generic error     │
│ VALID: Continue                 │
└────────────┬──────────────────────┘
             │
             ▼
┌─────────────────────────────────┐
│  Check: Account is_active?      │
├─────────────────────────────────┤
│ INACTIVE: Show "not active"     │
│ ACTIVE: Continue                │
└────────────┬──────────────────────┘
             │
             ▼
┌─────────────────────────────────┐
│   Create Session                │
│   Redirect to Dashboard         │
│   ✅ SUCCESS                    │
└─────────────────────────────────┘
```

### Code Implementation

**Controller:** `app/Controllers/Auth.php`
```php
public function login()
{
    if ($this->request->getMethod() === 'post') {
        return $this->processLogin();
    }
    return view('auth/login');
}

private function processLogin()
{
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // Authenticate via AuthService
    $result = $this->authService->authenticate($email, $password);

    if (!$result['success']) {
        session()->setFlashdata('error', $result['message']);
        return view('auth/login');
    }

    $this->authService->createSession($result['user']);
    return $this->authService->redirectToDashboard($result['user']['role']);
}
```

**Service:** `app/Services/AuthService.php`
```php
public function authenticate(string $email, string $password): array
{
    // Check empty
    if (empty($email) || empty($password)) {
        return $this->failureResponse('Email dan password harus diisi');
    }

    // Get user
    $user = $this->userModel->getByEmail($email);
    if (!$user) {
        log_message('info', 'LOGIN FAILED - User not found: ' . $email);
        return $this->failureResponse('Email atau password salah');
    }

    // Verify password
    if (!password_verify($password, $user['password'])) {
        log_message('info', 'LOGIN FAILED - Invalid password: ' . $email);
        return $this->failureResponse('Email atau password salah');
    }

    // Check active
    if (isset($user['is_active']) && !$user['is_active']) {
        log_message('info', 'LOGIN FAILED - Account inactive: ' . $email);
        return $this->failureResponse('Akun Anda tidak aktif. Hubungi administrator');
    }

    log_message('info', 'LOGIN SUCCESS - Email: ' . $email . ' | Role: ' . $user['role']);

    return [
        'success' => true,
        'message' => 'Login berhasil',
        'user' => $user,
    ];
}
```

**View:** `app/Views/auth/login.php`
```php
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-circle-fill"></i>
        <span><?= session()->getFlashdata('error'); ?></span>
    </div>
<?php endif; ?>
```

---

## 🔐 Security Features

✅ **Generic Error Messages**
- "Email atau password salah" untuk email tidak ditemukan atau password salah
- Mencegah username enumeration attacks

✅ **Password Hashing**
- Password di-hash dengan bcrypt (PASSWORD_DEFAULT)
- Verify menggunakan `password_verify()`
- Tidak ada plaintext password di database

✅ **Session Management**
- Session dibuat hanya setelah semua validasi sukses
- Session mengandung user info dan role

✅ **CSRF Protection**
- Token CSRF di semua form
- Diverifikasi sebelum proses login

✅ **Logging**
- Login attempts dicatat di log
- Failed login dicatat dengan detail
- Successful login dicatat

---

## 📝 Error Messages

| Scenario | Message |
|----------|---------|
| Email tidak diisi | "Email dan password harus diisi" |
| Password tidak diisi | "Email dan password harus diisi" |
| Email tidak terdaftar | "Email atau password salah" |
| Password salah | "Email atau password salah" |
| Akun tidak aktif | "Akun Anda tidak aktif. Hubungi administrator" |
| Login berhasil | "Login berhasil" (redirect) |

---

## 🧪 Testing Instructions

### Manual Test di Browser

1. **Buka Login Page**
   ```
   http://localhost:8080/auth/login
   ```

2. **Test 1: Password Salah**
   - Email: `admin@ppdb.local`
   - Password: `salah`
   - Expected: Alert "Email atau password salah"

3. **Test 2: Email Salah**
   - Email: `tidak@ada.com`
   - Password: `password123`
   - Expected: Alert "Email atau password salah"

4. **Test 3: Berhasil**
   - Email: `admin@ppdb.local`
   - Password: `password123`
   - Expected: Redirect ke `/admin/dashboard`

### Check Logs
```
tail -f writable/logs/log-*.log
```

---

## ✅ Status
- ✅ Error handling implemented
- ✅ Validasi form
- ✅ Password verification
- ✅ Account active check
- ✅ Session creation
- ✅ Logging
- ✅ CSRF protection
- ✅ Generic error messages

---

**Last Updated:** 14 Januari 2026  
**Status:** ✅ Production Ready
