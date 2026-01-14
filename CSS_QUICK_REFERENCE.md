# Dashboard CSS Quick Reference Guide

## 1. Dashboard Header

### Usage
```html
<div class="dashboard-header">
    <h1><i class="bi bi-icon-name"></i>Title</h1>
    <p>Subtitle or description</p>
</div>
```

### CSS Classes
- `.dashboard-header` - Main header container
- Includes gradient background, decorative circle, padding

### Customization
```css
.dashboard-header {
    background: var(--gradient-blue); /* Change gradient */
    padding: 2rem; /* Change padding */
    border-radius: 1rem; /* Change radius */
}
```

---

## 2. Stat Cards

### Basic Usage
```html
<div class="stat-card">
    <div class="d-flex align-items-center">
        <div class="stat-icon">
            <i class="bi bi-icon"></i>
        </div>
        <div>
            <div class="stat-value">123</div>
            <div class="stat-label">Label</div>
        </div>
    </div>
</div>
```

### Status Variants
```html
<!-- Pending -->
<div class="stat-card pending">...</div>

<!-- Verified -->
<div class="stat-card verified">...</div>

<!-- Accepted -->
<div class="stat-card accepted">...</div>

<!-- Rejected -->
<div class="stat-card rejected">...</div>
```

### CSS Classes
- `.stat-card` - Main card container
- `.stat-card.pending` - Orange variant
- `.stat-card.verified` - Cyan variant
- `.stat-card.accepted` - Green variant
- `.stat-card.rejected` - Red variant
- `.stat-icon` - Icon container (60x60px)
- `.stat-value` - Big number (2rem, bold)
- `.stat-label` - Description text (0.875rem)

### Features
- Hover effect: translateY(-4px)
- Colored top border (4px)
- Colored icon background
- Smooth transitions

---

## 3. Chart Cards

### Basic Usage
```html
<div class="chart-card">
    <div class="chart-header">
        <h5><i class="bi bi-icon"></i>Title</h5>
        <small>Subtitle</small>
    </div>
    <div class="chart-body">
        <!-- Chart canvas here -->
        <canvas id="myChart"></canvas>
    </div>
</div>
```

### CSS Classes
- `.chart-card` - Main card container
- `.chart-header` - Header with gradient background
- `.chart-body` - Content area with padding
- `.chart-header h5` - Title with icon styling
- `.chart-header small` - Subtitle text
- `.trend-chart` - Special styling for trend charts

### Features
- Rounded corners (1rem)
- Subtle border bottom
- Gradient header background
- Hover effect: box-shadow enhancement
- Responsive sizing

---

## 4. Action Buttons

### Basic Usage
```html
<a href="#" class="action-btn" style="background: var(--gradient-blue); color: white;">
    <i class="bi bi-icon"></i>
    Button Text
</a>
```

### Gradient Variants
```html
<!-- Blue -->
<a class="action-btn" style="background: var(--gradient-blue); color: white;">

<!-- Warm (Amber) -->
<a class="action-btn" style="background: var(--gradient-warm); color: white;">

<!-- Cool (Cyan) -->
<a class="action-btn" style="background: var(--gradient-cool); color: white;">

<!-- Green -->
<a class="action-btn" style="background: var(--gradient-green); color: white;">

<!-- Red -->
<a class="action-btn" style="background: var(--gradient-red); color: white;">
```

### CSS Classes
- `.action-btn` - Main button class
- Flexbox layout with gap
- Smooth transitions
- Hover: translateY(-2px) + shadow

---

## 5. List Menu Items

### Basic Usage
```html
<div class="list-group list-group-flush">
    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <span><i class="bi bi-icon"></i>Menu Item</span>
        <span class="badge rounded-pill">10</span>
    </a>
</div>
```

### Styling
```css
.list-group-item {
    background-color: transparent;
    border: 1px solid #e5e7eb;
    padding: 0.875rem 1.5rem;
    transition: all 0.2s ease;
}

.list-group-item:hover {
    background-color: #f8fafc;
    transform: translateX(4px);
}
```

### Features
- Transparent background default
- Border styling
- Smooth hover animation
- Color-coded badges

---

## 6. Color Variables

### Primary Colors
```css
--primary-blue: #2563eb
--primary-dark: #1e40af
--primary-light: #3b82f6
```

### Status Colors
```css
--status-pending: #f59e0b
--status-verified: #06b6d4
--status-accepted: #10b981
--status-rejected: #ef4444
```

### Gradient Definitions
```css
--gradient-blue: linear-gradient(135deg, #2563eb 0%, #1e40af 100%)
--gradient-warm: linear-gradient(135deg, #f59e0b 0%, #d97706 100%)
--gradient-cool: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%)
--gradient-green: linear-gradient(135deg, #10b981 0%, #059669 100%)
--gradient-red: linear-gradient(135deg, #ef4444 0%, #dc2626 100%)
```

### Usage
```css
background: var(--gradient-blue);
color: var(--primary-blue);
border-color: var(--status-pending);
```

---

## 7. Responsive Grid

### Bootstrap Grid Classes
```html
<!-- Full width on mobile, 2 columns on tablet, 4 on desktop -->
<div class="row g-4">
    <div class="col-md-6 col-xl-3">...</div>
    <div class="col-md-6 col-xl-3">...</div>
    <div class="col-md-6 col-xl-3">...</div>
    <div class="col-md-6 col-xl-3">...</div>
</div>
```

### Gap Values
- `g-3` - 1rem gap
- `g-4` - 1.5rem gap
- `g-5` - 3rem gap

### Breakpoints
- `col-*` - Default (mobile)
- `col-md-*` - 768px and up
- `col-lg-*` - 992px and up
- `col-xl-*` - 1200px and up

---

## 8. Icon Integration

### Bootstrap Icons
```html
<!-- Icon styles -->
<i class="bi bi-people"></i>
<i class="bi bi-clock-history"></i>
<i class="bi bi-check-circle"></i>
<i class="bi bi-graph-up"></i>

<!-- With color -->
<i class="bi bi-icon" style="color: #2563eb;"></i>

<!-- With size -->
<i class="bi bi-icon fs-5"></i> <!-- 1rem -->
<i class="bi bi-icon fs-4"></i> <!-- 1.25rem -->
<i class="bi bi-icon fs-3"></i> <!-- 1.5rem -->
```

---

## 9. Spacing System

### Margin Utilities
```css
mb-1 = margin-bottom: 0.25rem
mb-2 = margin-bottom: 0.5rem
mb-3 = margin-bottom: 1rem
mb-4 = margin-bottom: 1.5rem
mb-5 = margin-bottom: 3rem
```

### Padding Utilities
```css
p-1 = padding: 0.25rem
p-2 = padding: 0.5rem
p-3 = padding: 1rem
p-4 = padding: 1.5rem
p-5 = padding: 3rem
```

### Gap for Grid/Flex
```css
g-1 = gap: 0.25rem
g-2 = gap: 0.5rem
g-3 = gap: 1rem
g-4 = gap: 1.5rem
g-5 = gap: 3rem
```

---

## 10. Example: Creating New Component

### Step 1: Create Container
```html
<div class="my-custom-card">
    <!-- Content -->
</div>
```

### Step 2: Add Base Styling
```css
.my-custom-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    transition: all 0.3s ease;
}
```

### Step 3: Add Hover Effects
```css
.my-custom-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}
```

### Step 4: Use Variables
```css
.my-custom-card {
    border-top: 4px solid var(--primary-blue);
}
```

### Step 5: Add Responsive Rules
```css
@media (max-width: 768px) {
    .my-custom-card {
        padding: 1rem;
    }
}
```

---

## 11. Common Patterns

### Card with Icon
```html
<div class="stat-card">
    <div class="d-flex align-items-center">
        <div class="stat-icon">
            <i class="bi bi-icon fs-5"></i>
        </div>
        <div>
            <div class="stat-value">Value</div>
            <div class="stat-label">Label</div>
        </div>
    </div>
</div>
```

### Button with Icon
```html
<a href="#" class="action-btn" style="background: var(--gradient-blue); color: white;">
    <i class="bi bi-icon"></i>
    Button Text
</a>
```

### Menu List
```html
<div class="list-group list-group-flush">
    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between">
        <span><i class="bi bi-icon"></i>Item</span>
        <i class="bi bi-chevron-right"></i>
    </a>
</div>
```

### Header Section
```html
<div class="chart-card">
    <div class="chart-header">
        <h5><i class="bi bi-icon"></i>Title</h5>
        <small>Subtitle</small>
    </div>
    <div class="chart-body">
        <!-- Content -->
    </div>
</div>
```

---

## 12. CSS Loading

### In HTML
```html
<link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
```

### File Location
```
SPMB-Plus/
└── public/
    └── css/
        ├── dashboard.css (Main dashboard styles)
        ├── readability.css (Text improvements)
        └── [Other CSS files]
```

---

## 13. Troubleshooting

### Gradients Not Showing
- Ensure `var(--gradient-blue)` is defined
- Check CSS file is properly linked
- Verify modern browser support

### Icons Not Displaying
- Check Bootstrap Icons CDN is loaded
- Verify icon class names (bi bi-*)
- Check font-size with `fs-*` classes

### Colors Not Matching
- Check CSS variables are correct
- Verify hex codes match design
- Use developer tools to inspect

### Responsive Issues
- Check Bootstrap grid classes
- Verify breakpoint usage
- Test on different screen sizes

### Shadow Effects Not Working
- Ensure box-shadow syntax is correct
- Check color values (rgba format)
- Verify z-index if needed

---

## 14. Performance Tips

1. **Use CSS Variables** for easy maintenance
2. **Minimize Recalculations** by grouping rules
3. **Optimize Shadows** - use subtle effects
4. **Cache Images** - consider CDN
5. **Minify CSS** for production
6. **Use Hardware Acceleration** with transform
7. **Lazy Load** heavy components
8. **Test Performance** regularly

---

## 15. Browser DevTools Tips

### Inspect Elements
```
Right-click → Inspect → Elements tab
```

### Debug Styling
```
Elements tab → Styles panel → Click class names
```

### Responsive Testing
```
DevTools → Toggle device toolbar (Ctrl+Shift+M)
```

### Performance
```
DevTools → Lighthouse → Run audit
```

---

## Quick Copy-Paste Templates

### New Stat Card
```html
<div class="col-md-6 col-xl-3">
    <div class="stat-card [pending|verified|accepted|rejected]">
        <div class="d-flex align-items-center">
            <div class="stat-icon">
                <i class="bi bi-icon fs-5"></i>
            </div>
            <div>
                <div class="stat-value">VALUE</div>
                <div class="stat-label">LABEL</div>
            </div>
        </div>
    </div>
</div>
```

### New Chart
```html
<div class="col-lg-4">
    <div class="chart-card h-100">
        <div class="chart-header">
            <h5><i class="bi bi-icon"></i>TITLE</h5>
            <small>SUBTITLE</small>
        </div>
        <div class="chart-body">
            <canvas id="CHART_ID"></canvas>
        </div>
    </div>
</div>
```

### New Menu Section
```html
<div class="col-md-6 col-lg-4">
    <div class="chart-card h-100">
        <div class="chart-header">
            <h5><i class="bi bi-icon"></i>TITLE</h5>
        </div>
        <div class="chart-body" style="padding: 0;">
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <span><i class="bi bi-icon"></i>ITEM</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
```

---

## Support

For questions or issues:
1. Check DASHBOARD_REDESIGN.md for detailed docs
2. Review CSS comments in dashboard.css
3. Check responsive breakpoints
4. Test in different browsers
5. Use DevTools to debug

**Last Updated**: Dashboard Redesign Phase  
**File**: public/css/dashboard.css  
**Size**: ~25KB (minified)
