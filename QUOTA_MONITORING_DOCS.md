# 📊 QUOTA MONITORING DASHBOARD

## Overview
Sistem monitoring kuota jurusan real-time untuk membantu admin PPDB melihat status pengisian kuota dengan cepat dan mudah.

---

## ✨ Features

### 1. **Visual Alert System**
Tiga kategori alert dengan color coding:

#### 🔴 **KUOTA PENUH (≥100%)**
- Background: Red gradient
- Icon: Warning triangle
- Auto-pulse animation
- Lists all majors at 100%+ capacity
- Critical attention required

#### 🟠 **HAMPIR PENUH (90-99%)**
- Background: Orange gradient  
- Icon: Exclamation circle
- Pulse animation (slower)
- Lists all majors near capacity
- Action recommended soon

#### 🟢 **MASIH TERSEDIA (<50%)**
- Background: Green gradient
- Icon: Check circle
- Lists majors with good availability
- Shows top 3 + count if more

---

### 2. **Interactive Horizontal Bar Chart**

#### Features:
- **Sorted by Fullness**: Most full quotas appear first
- **Color Coding**:
  - 🔴 Red: 100% (FULL)
  - 🟠 Orange: 90-99% (ALMOST FULL)
  - 🟡 Yellow: 70-89% (HIGH)
  - 🔵 Blue: 50-69% (MEDIUM)
  - 🟢 Green: 0-49% (AVAILABLE)

#### Visual Elements:
- **Reference Lines**:
  - Solid red dashed line at 100%
  - Orange dashed line at 90%
- **Interactive Tooltips**:
  - Shows: Terisi/Total (percentage)
  - Shows: Sisa Kuota
  - Shows: Status emoji indicator

#### Chart Configuration:
```javascript
type: 'bar',
indexAxis: 'y', // Horizontal
borderRadius: 8,
responsive: true
```

---

### 3. **Auto-Categorization Logic**

```php
foreach ($quotaStats as $quota) {
    $persentase = ($quota['kuota_terisi'] / $quota['kuota_total']) * 100;
    
    if ($persentase >= 100) {
        $fullQuotas[] = $quota; // CRITICAL
    } elseif ($persentase >= 90) {
        $almostFullQuotas[] = $quota; // WARNING
    } elseif ($persentase < 50) {
        $availableQuotas[] = $quota; // OK
    }
}
```

---

## 🎨 Design System

### Colors
```css
/* Alert Colors */
--danger-bg: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
--danger-border: #dc2626;
--danger-icon-bg: #dc2626;

--warning-bg: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
--warning-border: #d97706;
--warning-icon-bg: #d97706;

--success-bg: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
--success-border: #059669;
--success-icon-bg: #059669;
```

### Animations
```css
/* Pulse Animation for Critical Alerts */
@keyframes pulse-danger {
    0%, 100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
    50% { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
}

/* Slide In Animation */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
```

---

## 📱 Responsive Design

### Desktop (≥768px)
- 3-column alert grid
- Full horizontal chart
- All details visible

### Mobile (<768px)
- 1-column alert stack
- Scrollable chart
- Condensed info display

---

## 🔔 Console Logging

Automatic alerts in browser console:
```javascript
if (fullCount > 0) {
    console.log(`⚠️ ALERT: ${fullCount} jurusan sudah PENUH!`);
}
if (almostFullCount > 0) {
    console.log(`⚠️ WARNING: ${almostFullCount} jurusan hampir penuh (≥90%)`);
}
```

---

## 🎯 Use Cases

### 1. **Quick Status Check**
Admin can instantly see:
- How many majors are full
- Which majors need attention
- Available capacity overview

### 2. **Capacity Planning**
Helps decide:
- When to close registration for specific majors
- Whether to add more quota
- Which majors to promote more

### 3. **Real-Time Monitoring**
During peak registration:
- Watch quotas fill in real-time
- Get visual alerts before full
- Plan interventions

---

## 📊 Data Flow

```
Database (quota_stats)
    ↓
AdminController::commandCenter()
    ↓
Calculate percentages & categorize
    ↓
Pass to View (dashboard_v2.php)
    ↓
Render Alert Boxes + Chart
    ↓
Chart.js draws horizontal bars
    ↓
User sees visual status
```

---

## 🚀 Implementation Details

### Files Modified:

1. **app/Views/admin/dashboard_v2.php**
   - Added quota monitoring section (lines ~200-340)
   - Alert boxes with categorization
   - Canvas element for chart
   - Chart.js script for rendering

2. **public/css/dashboard-v2.css**
   - Alert box styling
   - Pulse animations
   - Responsive grid
   - Hover effects

### Chart.js Configuration:
```javascript
new Chart(ctxQuotaMonitor, {
    type: 'bar',
    data: {
        labels: sortedMajorNames,
        datasets: [{
            data: sortedPercentages,
            backgroundColor: colorArray,
            borderRadius: 8
        }]
    },
    options: {
        indexAxis: 'y', // Horizontal
        scales: {
            x: { max: 110 }, // Show beyond 100%
            y: { grid: { display: false } }
        },
        plugins: {
            tooltip: { /* Custom callbacks */ }
        }
    }
});
```

---

## 💡 Best Practices

### For Admins:
1. Check monitoring section daily
2. Address "Almost Full" warnings early
3. Review "Full" majors for capacity increase
4. Monitor trends during peak periods

### For Developers:
1. Keep color coding consistent
2. Maintain sort order (fullest first)
3. Update thresholds if needed (90%, 100%)
4. Test with various data scenarios

---

## 🔧 Customization

### Change Alert Thresholds:
```php
// In dashboard_v2.php
if ($persentase >= 95) {  // Change from 100
    $fullQuotas[] = $quota;
} elseif ($persentase >= 85) {  // Change from 90
    $almostFullQuotas[] = $quota;
}
```

### Adjust Color Scheme:
```javascript
// In Chart.js script
const colors = quotaData.map(q => {
    if (q.persentase >= 100) return '#dc2626'; // Your red
    if (q.persentase >= 90) return '#f59e0b';  // Your orange
    // ... etc
});
```

---

## 📈 Future Enhancements

### Potential Additions:
1. **Email Alerts**: Send notifications when quota ≥90%
2. **Historical Tracking**: Show quota fill rate over time
3. **Predictive Analytics**: Estimate when quotas will fill
4. **Export Feature**: Download monitoring report as PDF
5. **Real-Time Updates**: WebSocket for live updates
6. **Comparison View**: Compare with previous years
7. **Mobile App**: Push notifications for critical alerts

---

## 🎓 Example Scenarios

### Scenario 1: All Quotas Healthy
```
🔴 KUOTA PENUH: 0 Jurusan
   ✓ Tidak ada jurusan yang penuh

🟠 HAMPIR PENUH: 0 Jurusan
   ✓ Tidak ada jurusan hampir penuh

🟢 MASIH TERSEDIA: 5 Jurusan
   - Teknik Informatika: 35% (13 sisa)
   - Teknik Elektro: 42% (17 sisa)
   - Manajemen: 28% (25 sisa)
```

### Scenario 2: Critical Alert
```
🔴 KUOTA PENUH: 2 Jurusan (PULSING!)
   - Teknik Informatika: 100% (40/40)
   - Kedokteran: 105% (42/40) ⚠️ OVER

🟠 HAMPIR PENUH: 1 Jurusan
   - Arsitektur: 92% (37/40)

🟢 MASIH TERSEDIA: 2 Jurusan
   - Ilmu Komunikasi: 45% (22 sisa)
   - Psikologi: 38% (19 sisa)
```

---

## 📞 Support

For issues or questions:
- Check browser console for errors
- Verify quota data in database
- Ensure Chart.js library is loaded
- Test with sample data first

---

## 📝 Changelog

### Version 1.0 (January 2026)
- Initial release
- 3-tier alert system
- Horizontal bar chart
- Color-coded indicators
- Responsive design
- Console logging
- Pulse animations

---

**Made with ❤️ for SPMB Plus PPDB System**
