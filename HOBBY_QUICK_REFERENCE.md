# 🚀 Quick Reference - Modern Hobby Selection

## Implementasi Cepat

### 1. HTML Structure
```html
<div class="hobby-selector-wrapper">
    <label class="form-label">
        <i class="bi bi-heart-fill"></i>
        Hobi / Minat
    </label>
    <select name="hobbies[]" id="hobbies_select" multiple="multiple">
        <option value="1" data-icon="bi-music">Bermain Musik</option>
        <option value="2" data-icon="bi-soccer">Olahraga</option>
    </select>
    <div class="hobby-help-text">
        <i class="bi bi-info-circle-fill"></i>
        <span>Pilih satu atau lebih hobi</span>
    </div>
</div>
```

### 2. CSS Classes

| Class | Purpose |
|-------|---------|
| `.hobby-selector-wrapper` | Main container |
| `.hobby-option-item` | Dropdown option item |
| `.hobby-option-icon` | Icon badge in dropdown |
| `.hobby-help-text` | Help text container |
| `.hobby-empty-state` | Empty/no results state |

### 3. JavaScript Init
```javascript
$('#hobbies_select').select2({
    theme: 'bootstrap-5',
    placeholder: '✨ Pilih hobi...',
    closeOnSelect: false,
    templateResult: formatHobbyOption,
    templateSelection: formatHobbySelection
});
```

### 4. Custom Animations

| Animation | Trigger | Duration |
|-----------|---------|----------|
| `tagSlideIn` | Tag creation | 0.3s |
| `dropdownSlideDown` | Dropdown open | 0.3s |
| `focusPulse` | Input focus | 0.5s |
| `shimmer` | Loading state | 1.5s |

### 5. Color Variables
```css
Primary: #6366f1
Gradient: #667eea → #764ba2
Border: #e2e8f0
Text: #2c3e50
Muted: #64748b
```

### 6. Icon Usage
- **Label**: `bi-heart-fill`
- **Help**: `bi-info-circle-fill`
- **Empty**: `bi-search` / `bi-hourglass-split`
- **Options**: Custom dari database (data-icon)

### 7. Key Features
- ✅ Multi-select dropdown
- ✅ Gradient tags dengan shadow
- ✅ Smooth animations
- ✅ Icon support
- ✅ Count display
- ✅ Hover effects
- ✅ Responsive

### 8. Dependencies
```html
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Bootstrap 5 Theme -->
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
```

### 9. Controller Data
```php
$data['hobbies'] = $this->hobbyModel->where('status', 'aktif')->findAll();
```

### 10. Form Submission
```php
// Name attribute: hobbies[]
// Data received: array of hobby IDs
$hobbiesData = $this->request->getPost('hobbies');
```

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| No animation | Check CSS loaded, verify @keyframes |
| Tags not showing | Verify Select2 init, check jQuery |
| Icons missing | Check Bootstrap Icons loaded |
| Count not updating | Verify jQuery event handler |
| Validation error | Check form name="hobbies[]" |

---

## Customization

### Change Gradient Colors
```css
background: linear-gradient(135deg, #YOUR_START 0%, #YOUR_END 100%);
```

### Change Border Radius
```css
border-radius: 20px; /* Tags */
border-radius: 12px; /* Input & Dropdown */
```

### Change Animation Speed
```css
transition: all 0.3s ease; /* Default */
animation: tagSlideIn 0.3s ease; /* Default */
```

---

**File**: `app/Views/panitia/tambah_siswa.php`  
**Last Update**: 14 Januari 2026
