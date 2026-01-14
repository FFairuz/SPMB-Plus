# Multiple Payments Per Applicant - Implementation

## 📋 Overview
Sistem SPMB-Plus sekarang **mendukung multiple pembayaran** dari satu pendaftar. Ini berguna untuk:
- **Pembayaran cicilan** (installment payments)
- **Pembayaran tambahan** (additional fees)
- **Pembayaran berulang** (re-payment jika ditolak)
- **Multiple jenis pembayaran** (pendaftaran, seragam, dll)

---

## ✅ Status Database

### Tabel Structure
**Tabel `payments` SUDAH mendukung multiple payments:**

```sql
CREATE TABLE `payments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `applicant_id` int(11) unsigned DEFAULT NULL,
  `registration_fee` decimal(10,2) NOT NULL DEFAULT 250000.00,
  `payment_status` enum('pending','submitted','confirmed','rejected'),
  `payment_type` enum('lunas','cicilan') DEFAULT 'lunas',
  `installment_number` tinyint(2) unsigned DEFAULT NULL,
  ...
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `receipt_number` (`receipt_number`),
  -- NO UNIQUE constraint on user_id or applicant_id ✅
  KEY `payments_applicant_id_foreign` (`applicant_id`),
  ...
)
```

**Key Points:**
- ✅ **Tidak ada UNIQUE constraint** pada `user_id`
- ✅ **Tidak ada UNIQUE constraint** pada `applicant_id`
- ✅ **Field `payment_type`** sudah ada: `'lunas'` atau `'cicilan'`
- ✅ **Field `installment_number`** sudah ada untuk nomor cicilan
- ✅ **Field `receipt_number`** UNIQUE untuk setiap pembayaran

**Kesimpulan:** Database **SUDAH siap** untuk multiple payments! 🎉

---

## 🔧 Perubahan Model

### File: `app/Models/PaymentModel.php`

#### ❌ Fungsi Lama (Single Payment)
```php
// Get payment by user (for pre-registration payments)
public function getPaymentByUserId($userId)
{
    return $this->where('user_id', $userId)->first();
}
```
**Masalah:** Hanya mengambil 1 payment pertama, ignore sisanya.

#### ✅ Fungsi Baru (Multiple Payments)

**1. Get ALL Payments by User:**
```php
public function getPaymentsByUserId($userId)
{
    return $this->where('user_id', $userId)
        ->orderBy('created_at', 'DESC')
        ->findAll();
}
```

**2. Get Latest Payment:**
```php
public function getLatestPaymentByUserId($userId)
{
    return $this->where('user_id', $userId)
        ->orderBy('created_at', 'DESC')
        ->first();
}
```

**3. Get Confirmed Payments:**
```php
public function getConfirmedPaymentsByUserId($userId)
{
    return $this->where('user_id', $userId)
        ->where('payment_status', 'confirmed')
        ->orderBy('created_at', 'DESC')
        ->findAll();
}
```

**4. Get ALL Payments by Applicant:**
```php
public function getPaymentsByApplicantId($applicantId)
{
    return $this->where('applicant_id', $applicantId)
        ->orderBy('created_at', 'DESC')
        ->findAll();
}
```

**5. Get Total Paid Amount:**
```php
public function getTotalPaidByUserId($userId)
{
    $result = $this->selectSum('transfer_amount')
        ->where('user_id', $userId)
        ->where('payment_status', 'confirmed')
        ->get()
        ->getRow();
    
    return $result ? (float)$result->transfer_amount : 0;
}

public function getTotalPaidByApplicantId($applicantId)
{
    $result = $this->selectSum('transfer_amount')
        ->where('applicant_id', $applicantId)
        ->where('payment_status', 'confirmed')
        ->get()
        ->getRow();
    
    return $result ? (float)$result->transfer_amount : 0;
}
```

**6. Get Payment Count:**
```php
public function getPaymentCountByUserId($userId, $status = null)
{
    $builder = $this->where('user_id', $userId);
    
    if ($status) {
        $builder->where('payment_status', $status);
    }
    
    return $builder->countAllResults();
}
```

---

## 📊 Use Cases

### 1. **Pembayaran Cicilan**

**Scenario:**
- Biaya pendaftaran total: Rp 1.500.000
- Cicilan 3x: Rp 500.000 per bulan

**Implementation:**
```php
// Cicilan 1
$payment1 = [
    'user_id' => 123,
    'applicant_id' => 456,
    'payment_type' => 'cicilan',
    'installment_number' => 1,
    'transfer_amount' => 500000,
    'payment_status' => 'confirmed',
];

// Cicilan 2
$payment2 = [
    'user_id' => 123,
    'applicant_id' => 456,
    'payment_type' => 'cicilan',
    'installment_number' => 2,
    'transfer_amount' => 500000,
    'payment_status' => 'confirmed',
];

// Cicilan 3
$payment3 = [
    'user_id' => 123,
    'applicant_id' => 456,
    'payment_type' => 'cicilan',
    'installment_number' => 3,
    'transfer_amount' => 500000,
    'payment_status' => 'confirmed',
];

// Get total paid
$totalPaid = $paymentModel->getTotalPaidByApplicantId(456);
// Result: 1,500,000
```

### 2. **Pembayaran Berulang (Re-payment)**

**Scenario:**
- Pembayaran pertama ditolak (rejected)
- User upload bukti pembayaran lagi

**Implementation:**
```php
// Payment 1 - Rejected
$payment1 = [
    'user_id' => 123,
    'transfer_amount' => 250000,
    'payment_status' => 'rejected',
    'notes' => 'Bukti transfer tidak jelas',
];

// Payment 2 - New submission
$payment2 = [
    'user_id' => 123,
    'transfer_amount' => 250000,
    'payment_status' => 'submitted',
    'notes' => 'Upload ulang dengan bukti yang lebih jelas',
];

// Get latest payment
$latestPayment = $paymentModel->getLatestPaymentByUserId(123);
// Result: payment2 (sorted by created_at DESC)
```

### 3. **Multiple Jenis Pembayaran**

**Scenario:**
- Pembayaran pendaftaran: Rp 250.000
- Pembayaran seragam: Rp 500.000
- Pembayaran buku: Rp 300.000

**Implementation:**
```php
$payment1 = [
    'user_id' => 123,
    'applicant_id' => 456,
    'registration_fee' => 250000,
    'transfer_amount' => 250000,
    'notes' => 'Pembayaran pendaftaran',
];

$payment2 = [
    'user_id' => 123,
    'applicant_id' => 456,
    'registration_fee' => 500000,
    'transfer_amount' => 500000,
    'notes' => 'Pembayaran seragam',
];

$payment3 = [
    'user_id' => 123,
    'applicant_id' => 456,
    'registration_fee' => 300000,
    'transfer_amount' => 300000,
    'notes' => 'Pembayaran buku',
];

// Get all payments
$allPayments = $paymentModel->getPaymentsByUserId(123);
// Result: Array dengan 3 payments

// Get total
$total = $paymentModel->getTotalPaidByUserId(123);
// Result: 1,050,000
```

---

## 🎯 Controller Updates (Required)

### File: `app/Controllers/ApplicantController.php`

#### Before:
```php
$payment = $paymentModel->getPaymentByUserId($user_id);

if ($payment && $payment['payment_status'] === 'confirmed') {
    // Redirect
}
```

#### After (Option 1 - Check Latest):
```php
$latestPayment = $paymentModel->getLatestPaymentByUserId($user_id);

if ($latestPayment && $latestPayment['payment_status'] === 'confirmed') {
    // Redirect
}
```

#### After (Option 2 - Check Any Confirmed):
```php
$confirmedPayments = $paymentModel->getConfirmedPaymentsByUserId($user_id);

if (!empty($confirmedPayments)) {
    // Has at least one confirmed payment
    // Redirect
}
```

#### After (Option 3 - Check Total Paid):
```php
$totalPaid = $paymentModel->getTotalPaidByUserId($user_id);
$requiredAmount = 250000; // or from settings

if ($totalPaid >= $requiredAmount) {
    // Paid enough
    // Redirect
}
```

---

## 📱 View Updates

### Dashboard Applicant - Payment History

**Show All Payments:**
```php
<?php
$payments = $paymentModel->getPaymentsByUserId($userId);
$totalPaid = $paymentModel->getTotalPaidByUserId($userId);
$paymentCount = count($payments);
?>

<div class="payment-summary">
    <h4>Riwayat Pembayaran</h4>
    <p>Total Pembayaran: <?= $paymentCount ?> transaksi</p>
    <p>Total Dibayar: Rp <?= number_format($totalPaid, 0, ',', '.') ?></p>
</div>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($payments as $index => $payment): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= date('d M Y', strtotime($payment['created_at'])) ?></td>
            <td>Rp <?= number_format($payment['transfer_amount'], 0, ',', '.') ?></td>
            <td>
                <?php if ($payment['payment_status'] === 'confirmed'): ?>
                    <span class="badge bg-success">Confirmed</span>
                <?php elseif ($payment['payment_status'] === 'submitted'): ?>
                    <span class="badge bg-warning">Pending</span>
                <?php elseif ($payment['payment_status'] === 'rejected'): ?>
                    <span class="badge bg-danger">Rejected</span>
                <?php else: ?>
                    <span class="badge bg-secondary">Pending</span>
                <?php endif; ?>
            </td>
            <td><?= $payment['notes'] ?? '-' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
```

### Admin Dashboard - Payment Management

**Show All Payments per Applicant:**
```php
<?php
$applicantPayments = $paymentModel->getPaymentsByApplicantId($applicantId);
$totalPaid = $paymentModel->getTotalPaidByApplicantId($applicantId);
?>

<div class="card">
    <div class="card-header">
        <h5>Pembayaran: <?= $applicant['full_name'] ?></h5>
        <p class="mb-0">Total: Rp <?= number_format($totalPaid, 0, ',', '.') ?></p>
    </div>
    <div class="card-body">
        <?php foreach ($applicantPayments as $payment): ?>
        <div class="payment-item">
            <div class="d-flex justify-content-between">
                <div>
                    <strong><?= date('d M Y', strtotime($payment['created_at'])) ?></strong>
                    <br>
                    Rp <?= number_format($payment['transfer_amount'], 0, ',', '.') ?>
                </div>
                <div>
                    <span class="badge badge-<?= $payment['payment_status'] ?>">
                        <?= ucfirst($payment['payment_status']) ?>
                    </span>
                </div>
            </div>
            <?php if ($payment['payment_type'] === 'cicilan'): ?>
                <small>Cicilan ke-<?= $payment['installment_number'] ?></small>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
```

---

## 🚀 API Examples

### Get All Payments
```php
// Get all payments by user
$payments = $paymentModel->getPaymentsByUserId(123);

// Response:
[
    [
        'id' => 1,
        'user_id' => 123,
        'transfer_amount' => 250000,
        'payment_status' => 'confirmed',
        'created_at' => '2026-01-14 10:00:00',
    ],
    [
        'id' => 2,
        'user_id' => 123,
        'transfer_amount' => 500000,
        'payment_status' => 'submitted',
        'created_at' => '2026-01-14 11:00:00',
    ],
]
```

### Get Payment Statistics
```php
$userId = 123;

$stats = [
    'total_payments' => $paymentModel->getPaymentCountByUserId($userId),
    'confirmed_payments' => $paymentModel->getPaymentCountByUserId($userId, 'confirmed'),
    'pending_payments' => $paymentModel->getPaymentCountByUserId($userId, 'submitted'),
    'total_paid' => $paymentModel->getTotalPaidByUserId($userId),
];

// Response:
[
    'total_payments' => 3,
    'confirmed_payments' => 1,
    'pending_payments' => 1,
    'total_paid' => 250000,
]
```

---

## ✅ Benefits

### 1. **Flexible Payment Options**
- User dapat bayar cicilan
- User dapat bayar berulang jika ditolak
- User dapat bayar berbagai jenis pembayaran

### 2. **Better Tracking**
- History pembayaran lengkap
- Total paid amount clear
- Status setiap pembayaran tracked

### 3. **Business Logic**
- Support installment payment
- Support partial payment
- Support payment correction

### 4. **Data Integrity**
- Each payment has unique receipt_number
- Foreign key constraints maintained
- Timestamps for audit trail

---

## ⚠️ Important Notes

### 1. **Receipt Number**
- **UNIQUE** untuk setiap pembayaran
- Format: `PAY-YYYY-XXXXX`
- Auto-generated untuk setiap payment

### 2. **Payment Status**
- `pending`: Belum upload bukti
- `submitted`: Sudah upload, tunggu verifikasi
- `confirmed`: Sudah diverifikasi dan approved
- `rejected`: Ditolak, perlu upload ulang

### 3. **Payment Type**
- `lunas`: Pembayaran penuh
- `cicilan`: Pembayaran bertahap/cicilan

### 4. **Installment Number**
- Untuk payment_type = 'cicilan'
- Nomor urut cicilan (1, 2, 3, ...)
- Optional (NULL untuk pembayaran lunas)

---

## 🧪 Testing

### Test Case 1: Multiple Payments
```php
// Insert 3 payments for same user
for ($i = 1; $i <= 3; $i++) {
    $paymentModel->insert([
        'user_id' => 123,
        'transfer_amount' => 500000,
        'payment_type' => 'cicilan',
        'installment_number' => $i,
        'payment_status' => 'confirmed',
    ]);
}

// Get all payments
$payments = $paymentModel->getPaymentsByUserId(123);
assert(count($payments) === 3);

// Get total
$total = $paymentModel->getTotalPaidByUserId(123);
assert($total === 1500000);
```

### Test Case 2: Payment Count
```php
$userId = 123;

// Create payments with different status
$paymentModel->insert(['user_id' => $userId, 'payment_status' => 'confirmed']);
$paymentModel->insert(['user_id' => $userId, 'payment_status' => 'submitted']);
$paymentModel->insert(['user_id' => $userId, 'payment_status' => 'rejected']);

// Test counts
$total = $paymentModel->getPaymentCountByUserId($userId);
assert($total === 3);

$confirmed = $paymentModel->getPaymentCountByUserId($userId, 'confirmed');
assert($confirmed === 1);
```

---

## 📝 Migration Guide

### For Existing Code

**Step 1: Identify Single Payment Calls**
```bash
grep -r "getPaymentByUserId" app/
grep -r "getPaymentByApplicantId" app/
```

**Step 2: Decide Strategy**
- Use `getLatestPaymentByUserId()` untuk get latest
- Use `getPaymentsByUserId()` untuk get all
- Use `getTotalPaidByUserId()` untuk get sum

**Step 3: Update Controller Logic**
```php
// OLD
$payment = $paymentModel->getPaymentByUserId($userId);
if ($payment) { ... }

// NEW
$payments = $paymentModel->getPaymentsByUserId($userId);
if (!empty($payments)) { ... }

// OR
$latestPayment = $paymentModel->getLatestPaymentByUserId($userId);
if ($latestPayment) { ... }
```

**Step 4: Update Views**
```php
// OLD
<?php if ($payment): ?>
    <div>Payment: <?= $payment['transfer_amount'] ?></div>
<?php endif; ?>

// NEW
<?php foreach ($payments as $payment): ?>
    <div>Payment: <?= $payment['transfer_amount'] ?></div>
<?php endforeach; ?>
```

---

## 🎯 Next Steps

### 1. **Update Controllers** ⏳
- [ ] Update `ApplicantController.php`
- [ ] Update `PaymentController.php`
- [ ] Update `BendaharaController.php`
- [ ] Update `AdminController.php`

### 2. **Update Views** ⏳
- [ ] Update applicant dashboard
- [ ] Update payment history page
- [ ] Update admin payment list
- [ ] Update bendahara verification page

### 3. **Add Features** 📋
- [ ] Payment history timeline
- [ ] Installment payment calculator
- [ ] Payment reminder system
- [ ] Auto receipt generation per payment

### 4. **Testing** 🧪
- [ ] Unit tests for model methods
- [ ] Integration tests for controllers
- [ ] UI tests for views
- [ ] Load testing for multiple payments

---

## ✅ Status: MODEL UPDATED

**Model Changes Complete!** 🎉

PaymentModel sekarang mendukung:
- ✅ Multiple payments per user
- ✅ Multiple payments per applicant
- ✅ Total paid calculation
- ✅ Payment count with status filter
- ✅ Latest payment retrieval
- ✅ Confirmed payments only
- ✅ All helper methods ready

**Next:** Update controllers dan views untuk menggunakan method baru.

**File Modified:** `app/Models/PaymentModel.php`

Database structure **SUDAH mendukung**, tidak perlu migration tambahan!
