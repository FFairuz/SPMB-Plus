# 🔧 Settings Model - Method Name Fix

## 📋 Issue
Fatal error terjadi karena method `set()` di `SettingModel` konflik dengan method `set()` bawaan dari parent class `CodeIgniter\Model`.

```php
Fatal error: Declaration of App\Models\SettingModel::set($key, $value, $type = 'text') 
must be compatible with CodeIgniter\Model::set($key, $value = '', ?bool $escape = null)
```

---

## ✅ Solution
Rename method `set()` menjadi `setSetting()` untuk menghindari konflik dengan parent class.

---

## 🔄 Changes Made

### 1. SettingModel.php
**Before:**
```php
public function set($key, $value, $type = 'text')
{
    // ...
}
```

**After:**
```php
public function setSetting($key, $value, $type = 'text')
{
    // ...
}
```

### 2. SettingsController.php
**Before:**
```php
$this->settingModel->set($key, $value, 'text');
$this->settingModel->set('app_logo', $logoName, 'image');
$this->settingModel->set('app_logo', 'default-logo.png', 'image');
```

**After:**
```php
$this->settingModel->setSetting($key, $value, 'text');
$this->settingModel->setSetting('app_logo', $logoName, 'image');
$this->settingModel->setSetting('app_logo', 'default-logo.png', 'image');
```

---

## 📝 Updated Usage

### Model Methods
```php
// Get setting (no change)
$value = $settingModel->get('app_name', 'Default');

// Set setting (CHANGED)
$settingModel->setSetting('app_name', 'New Name', 'text');

// Other methods (no change)
$settings = $settingModel->getAllSettings();
$exists = $settingModel->exists('app_name');
```

### Helper Functions (No Change)
```php
// Helper functions still work the same
helper('settings');

$name = app_name();
$logo = app_logo();
$school = school_name();
$desc = app_description();

// Get custom setting
$value = get_setting('app_name', 'Default');

// No set_setting() helper (use model directly if needed)
```

---

## 🎯 Why This Fix?

### CodeIgniter\Model::set()
The parent `Model` class already has a `set()` method with this signature:
```php
public function set($key, $value = '', ?bool $escape = null)
```

This is used internally by CodeIgniter for query building.

### Our setSetting()
Our custom method has a different purpose and signature:
```php
public function setSetting($key, $value, $type = 'text')
```

This is specifically for updating application settings in the database.

### Avoiding Conflict
By renaming to `setSetting()`, we:
- ✅ Avoid method signature conflict
- ✅ Make the purpose clearer
- ✅ Follow naming conventions (descriptive names)
- ✅ Prevent PHP fatal errors

---

## ✅ Testing

### Test the fix:
```bash
# Restart server
php spark serve

# Access settings page
# Should load without errors now
http://localhost:8080/admin/settings
```

### Verify methods work:
```php
// In controller or test
$settingModel = new \App\Models\SettingModel();

// Get (works)
$name = $settingModel->get('app_name');

// Set (now using setSetting)
$settingModel->setSetting('app_name', 'Test App', 'text');

// Verify
$newName = $settingModel->get('app_name');
echo $newName; // Should output: Test App
```

---

## 📊 Files Modified

1. ✅ `app/Models/SettingModel.php`
   - Method `set()` → `setSetting()`

2. ✅ `app/Controllers/SettingsController.php`
   - 3 instances of `set()` → `setSetting()`
   - Line 80: Text settings update
   - Line 107: Logo upload
   - Line 140: Logo reset

3. ℹ️ `app/Helpers/settings_helper.php`
   - No changes needed (doesn't use set method)

---

## 🎓 Lesson Learned

### Best Practices:
1. **Avoid overriding parent methods** unless intentional
2. **Use descriptive method names** (setSetting vs set)
3. **Check parent class signatures** before creating methods
4. **Follow CodeIgniter conventions**

### Naming Conventions:
```php
// Good - Descriptive
setSetting()
getSetting()
saveSetting()
updateSetting()

// Avoid - Too generic (might conflict)
set()
get()
save()
update()
```

---

## 🔍 Related Methods

### SettingModel Methods (Complete List):
```php
// Getters
get($key, $default = null)              // Get single setting
getAllSettings()                         // Get all as array
getByType($type)                        // Get by type

// Setters
setSetting($key, $value, $type)         // Set/update setting (RENAMED)

// Utilities
exists($key)                            // Check if exists
deleteByKey($key)                       // Delete setting
```

---

## ✅ Status
- [x] Error identified
- [x] Method renamed in Model
- [x] All usages updated in Controller
- [x] Tested and verified working
- [x] Documentation updated
- [x] No breaking changes in helpers

---

## 🚀 Ready to Use

The settings feature is now fully functional with the fixed method name!

```bash
# Start/restart server
php spark serve

# Test the feature
# Login as admin → Pengaturan Aplikasi
```

---

**Fixed**: January 14, 2026  
**Issue**: Method signature conflict  
**Solution**: Renamed `set()` to `setSetting()`  
**Status**: ✅ Resolved
