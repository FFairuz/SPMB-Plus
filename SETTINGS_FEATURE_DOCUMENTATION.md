# 🎛️ Fitur Pengaturan Aplikasi (Settings)

## 📋 Overview
Fitur Settings memungkinkan admin untuk mengatur dan mengkustomisasi informasi aplikasi PPDB, termasuk logo aplikasi, nama aplikasi, dan informasi sekolah.

---

## ✨ Fitur Utama

### 1. **Logo Aplikasi**
- Upload logo custom untuk aplikasi
- Preview logo secara real-time
- Reset logo ke default
- Format: JPG, PNG, GIF
- Maksimal ukuran: 2MB
- Auto-delete logo lama saat upload baru

### 2. **Informasi Aplikasi**
- **Nama Aplikasi**: Nama sistem PPDB
- **Deskripsi**: Deskripsi singkat tentang aplikasi

### 3. **Informasi Sekolah**
- **Nama Sekolah**: Nama lengkap sekolah
- **Alamat**: Alamat lengkap sekolah
- **Telepon**: Nomor telepon sekolah
- **Email**: Email sekolah

---

## 📂 File Structure

### Backend Files
```
app/
├── Controllers/
│   └── SettingsController.php          # Controller untuk settings
├── Models/
│   └── SettingModel.php                # Model untuk database settings
├── Database/
│   └── Migrations/
│       └── 2026-01-14-000001_CreateSettingsTable.php
├── Helpers/
│   └── settings_helper.php             # Helper functions
└── Views/
    └── admin/
        └── settings/
            └── index.php               # View halaman settings
```

### Routes
```php
$routes->get('admin/settings', 'SettingsController::index');
$routes->post('admin/settings/update', 'SettingsController::update');
$routes->get('admin/settings/reset-logo', 'SettingsController::resetLogo');
$routes->get('admin/settings/api/(:any)', 'SettingsController::getSetting/$1');
$routes->get('admin/settings/api', 'SettingsController::getAllSettings');
```

---

## 🗄️ Database Structure

### Table: `settings`

| Column         | Type         | Description                    |
|----------------|--------------|--------------------------------|
| id             | INT(11)      | Primary key                    |
| setting_key    | VARCHAR(100) | Unique key identifier          |
| setting_value  | TEXT         | Setting value                  |
| setting_type   | ENUM         | Type: text, image, number, boolean |
| description    | TEXT         | Description of setting         |
| created_at     | DATETIME     | Created timestamp              |
| updated_at     | DATETIME     | Updated timestamp              |

### Default Settings

```sql
- app_name: 'SPMB-Plus'
- app_logo: 'default-logo.png'
- app_description: 'Sistem Penerimaan Peserta Didik Baru Online'
- school_name: 'Sekolah ABC'
- school_address: 'Jl. Pendidikan No. 123'
- school_phone: '021-1234567'
- school_email: 'info@sekolah.com'
```

---

## 🔧 Backend Implementation

### SettingsController

#### Methods:
1. **index()** - Display settings page
   ```php
   GET /admin/settings
   - Shows settings form with current values
   - Admin authentication required
   ```

2. **update()** - Update settings
   ```php
   POST /admin/settings/update
   - Updates text settings
   - Handles logo upload
   - Validates input
   - Returns success/error message
   ```

3. **resetLogo()** - Reset logo to default
   ```php
   GET /admin/settings/reset-logo
   - Deletes current logo file
   - Resets to default-logo.png
   - Confirmation required
   ```

4. **getSetting($key)** - API endpoint for single setting
   ```php
   GET /admin/settings/api/{key}
   - Returns JSON with setting value
   ```

5. **getAllSettings()** - API endpoint for all settings
   ```php
   GET /admin/settings/api
   - Returns JSON with all settings
   ```

### SettingModel

#### Methods:
1. **get($key, $default)** - Get setting value
2. **set($key, $value, $type)** - Set/update setting
3. **getAllSettings()** - Get all settings as array
4. **getByType($type)** - Get settings by type
5. **deleteByKey($key)** - Delete setting
6. **exists($key)** - Check if setting exists

---

## 🎨 Frontend Design

### Design Features:
- **Modern White Theme**: Clean and professional
- **Gradient Header**: Blue gradient dengan icon
- **Section-based Layout**: Organized by categories
- **Real-time Preview**: Logo preview sebelum upload
- **Responsive Design**: Mobile-friendly
- **Form Validation**: Client & server-side validation
- **File Upload**: Drag & drop ready styling

### Style Highlights:
```css
- Border-radius: 16px (modern rounded)
- Color scheme: Blue (#0d6efd) primary
- Shadow: Soft shadows untuk depth
- Transitions: Smooth 0.3s animations
- Icons: Bootstrap Icons
```

---

## 🔨 Helper Functions

### Available Helpers:

```php
// Load helper
helper('settings');

// Get any setting
$value = get_setting('app_name', 'Default Name');

// Get all settings
$settings = get_all_settings();

// Quick access functions
$appName = app_name();                    // Get app name
$logoUrl = app_logo();                    // Get logo URL
$schoolName = school_name();              // Get school name
$description = app_description();         // Get app description
```

### Usage Example:
```php
// In controller
helper('settings');
$data['app_name'] = app_name();
$data['logo_url'] = app_logo();

// In view
<?= app_name() ?>
<img src="<?= app_logo() ?>" alt="Logo">
```

---

## 📝 Usage Guide

### For Admin:

1. **Access Settings**
   - Login as Admin
   - Click "Pengaturan Aplikasi" in sidebar
   - Or navigate to `/admin/settings`

2. **Update Logo**
   - Click "Pilih Logo Baru" button
   - Select image file (JPG, PNG, GIF)
   - Preview will show immediately
   - Click "Simpan Perubahan" to upload

3. **Reset Logo**
   - Click "Reset ke Default" button under logo
   - Confirm the action
   - Logo will revert to default

4. **Update Information**
   - Fill in form fields
   - All fields are optional except "Nama Aplikasi"
   - Click "Simpan Perubahan"
   - Success message will appear

---

## 🔒 Security Features

### Access Control:
- Admin-only access
- Session validation
- Role checking

### File Upload Security:
- File type validation (JPG, PNG, GIF only)
- File size limit (2MB max)
- Random filename generation
- Secure upload directory
- Old file deletion

### Input Validation:
- Required field validation
- Email format validation
- Max length validation
- CSRF protection
- XSS prevention (esc() function)

---

## 📱 API Endpoints

### Get Single Setting
```http
GET /admin/settings/api/app_name

Response:
{
  "success": true,
  "key": "app_name",
  "value": "SPMB-Plus"
}
```

### Get All Settings
```http
GET /admin/settings/api

Response:
{
  "success": true,
  "settings": {
    "app_name": "SPMB-Plus",
    "app_logo": "logo_abc123.png",
    "school_name": "Sekolah ABC",
    ...
  }
}
```

---

## 🚀 Installation

### Step 1: Run Migration
```bash
php spark migrate
```

### Step 2: Create Upload Directory
```bash
mkdir -p public/uploads/logo
chmod 777 public/uploads/logo
```

### Step 3: Add Default Logo (Optional)
Place `default-logo.png` in:
```
public/assets/img/default-logo.png
```

### Step 4: Load Helper (If needed globally)
In `app/Config/Autoload.php`:
```php
public $helpers = ['settings'];
```

---

## 🎯 Integration Examples

### Display Logo in Sidebar
```php
<!-- In layout/app.php -->
<div class="sidebar-brand">
    <img src="<?= app_logo() ?>" alt="Logo" class="logo-img">
    <span><?= app_name() ?></span>
</div>
```

### Display in Login Page
```php
<!-- In auth/login.php -->
<div class="logo-box">
    <img src="<?= app_logo() ?>" alt="<?= app_name() ?>">
</div>
<h1><?= app_name() ?></h1>
<p><?= app_description() ?></p>
```

### Display School Info
```php
<div class="school-info">
    <h3><?= school_name() ?></h3>
    <p><?= get_setting('school_address') ?></p>
    <p>Tel: <?= get_setting('school_phone') ?></p>
    <p>Email: <?= get_setting('school_email') ?></p>
</div>
```

---

## 📊 Database Operations

### Manual Settings Update (via Database)
```sql
-- Update app name
UPDATE settings 
SET setting_value = 'New School Name' 
WHERE setting_key = 'app_name';

-- View all settings
SELECT * FROM settings;

-- Add new setting
INSERT INTO settings (setting_key, setting_value, setting_type, description)
VALUES ('new_setting', 'value', 'text', 'Description');
```

---

## 🐛 Troubleshooting

### Logo Not Uploading
- Check folder permissions: `chmod 777 public/uploads/logo`
- Verify file size < 2MB
- Check file format (JPG, PNG, GIF only)
- Check PHP upload_max_filesize in php.ini

### Settings Not Saving
- Check database connection
- Verify migration was run
- Check validation rules
- Review error logs in `writable/logs/`

### Logo Not Displaying
- Verify file exists in `public/uploads/logo/`
- Check file permissions
- Verify correct path in database
- Clear browser cache

---

## ✅ Testing Checklist

- [ ] Migration runs successfully
- [ ] Settings table created with defaults
- [ ] Can access `/admin/settings` as admin
- [ ] Non-admin redirected to login
- [ ] Logo upload works
- [ ] Logo preview displays correctly
- [ ] Old logo deleted on new upload
- [ ] Reset logo works
- [ ] Text fields save correctly
- [ ] Email validation works
- [ ] Form validation displays errors
- [ ] Success message shows after update
- [ ] Helper functions return correct values
- [ ] API endpoints return JSON
- [ ] Sidebar menu link works

---

## 🎨 Customization

### Add New Setting Type:

1. **Update Migration:**
```php
'setting_type' => [
    'type' => 'ENUM',
    'constraint' => ['text', 'image', 'number', 'boolean', 'json'],
    'default' => 'text',
],
```

2. **Add to Controller:**
```php
$jsonSettings = ['feature_flags'];
foreach ($jsonSettings as $key) {
    $value = $this->request->getPost($key);
    if ($value !== null) {
        $this->settingModel->set($key, json_encode($value), 'json');
    }
}
```

3. **Add to View:**
```php
<div class="mb-3">
    <label for="new_setting">New Setting</label>
    <input type="text" name="new_setting" value="<?= esc($settings['new_setting'] ?? '') ?>">
</div>
```

---

## 📈 Future Enhancements

- [ ] Multi-language support
- [ ] Theme color customization
- [ ] Multiple logo support (favicon, header, footer)
- [ ] Advanced logo editor (crop, resize)
- [ ] Settings export/import
- [ ] Settings history/versioning
- [ ] Role-based settings access
- [ ] Email template settings
- [ ] Payment gateway settings
- [ ] Social media links

---

## 📚 Related Documentation

- [Database Migrations Guide](MIGRATIONS.md)
- [File Upload Guide](FILE_UPLOAD.md)
- [Helper Functions](HELPERS.md)
- [Admin Panel Guide](ADMIN_PANEL.md)

---

**Created**: January 14, 2026  
**Version**: 1.0  
**Status**: ✅ Complete & Production Ready  
**Author**: Development Team
