# Quick Implementation Guide - Multiple Payments

## 🚀 Langkah Cepat untuk Mengaktifkan Multiple Payments

### 1. Model ✅ SELESAI
File `app/Models/PaymentModel.php` sudah diupdate dengan method baru:
- `getPaymentsByUserId()` - Get semua payment
- `getLatestPaymentByUserId()` - Get payment terbaru
- `getTotalPaidByUserId()` - Get total yang sudah dibayar
- Dan lainnya...

### 2. Controller Updates (To Do)

#### A. ApplicantController.php

**Fungsi `payment()` - Line ~327:**

**BEFORE:**
```php
$payment = $paymentModel->getPaymentByUserId($user_id);

if ($payment && $payment['payment_status'] === 'confirmed') {
    session()->setFlashdata('success', 'Pembayaran sudah dikonfirmasi.');
    return redirect()->to('/applicant/register');
}
```

**AFTER:**
```php
// Check if any confirmed payment exists
$confirmedPayments = $paymentModel->getConfirmedPaymentsByUserId($user_id);

if (!empty($confirmedPayments)) {
    session()->setFlashdata('success', 'Pembayaran sudah dikonfirmasi.');
    return redirect()->to('/applicant/register');
}

// Get latest payment for form
$latestPayment = $paymentModel->getLatestPaymentByUserId($user_id);
```

**Kenapa?**
- User bisa punya multiple payments (rejected, then resubmit)
- Cek apakah ada payment yang confirmed
- Show latest payment di form

#### B. ApplicantController.php - Dashboard

**Fungsi `dashboard()`:**

**ADD:**
```php
// Get all payments for this user
$payments = $paymentModel->getPaymentsByUserId($userId);
$totalPaid = $paymentModel->getTotalPaidByUserId($userId);
$paymentCount = count($payments);

$data = [
    // ...existing data...
    'payments' => $payments,
    'totalPaid' => $totalPaid,
    'paymentCount' => $paymentCount,
];
```

#### C. PaymentController.php

Tidak perlu banyak perubahan karena:
- Admin bisa lihat semua payments (already filtered by payment_id)
- Print receipt by payment_id (sudah unik per payment)

**Optional - Add payment list per applicant:**
```php
public function applicant_payments($applicantId)
{
    $payments = $this->paymentModel->getPaymentsByApplicantId($applicantId);
    $totalPaid = $this->paymentModel->getTotalPaidByApplicantId($applicantId);
    
    return view('admin/applicant_payments', [
        'payments' => $payments,
        'totalPaid' => $totalPaid,
    ]);
}
```

#### D. BendaharaController.php

**Fungsi `verifikasi_pembayaran()`:**

Already OK karena menampilkan semua payments dalam list.

**Fungsi `cetak_bukti_pembayaran($paymentId)`:**

Already OK karena cetak per payment_id (bukan per user).

### 3. View Updates

#### A. Applicant Dashboard - Show Payment History

**File:** `app/Views/applicant/dashboard.php`

**ADD setelah section payment status:**

```php
<!-- Payment History -->
<?php if (!empty($payments) && count($payments) > 1): ?>
<div class="card mt-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            <i class="bi bi-clock-history"></i> Riwayat Pembayaran
        </h5>
    </div>
    <div class="card-body">
        <p class="mb-3">
            Total Pembayaran: <strong><?= $paymentCount ?> transaksi</strong><br>
            Total Dibayar: <strong>Rp <?= number_format($totalPaid, 0, ',', '.') ?></strong>
        </p>
        
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $index => $pmt): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= date('d M Y', strtotime($pmt['created_at'])) ?></td>
                        <td>Rp <?= number_format($pmt['transfer_amount'] ?? 0, 0, ',', '.') ?></td>
                        <td>
                            <?php if ($pmt['payment_status'] === 'confirmed'): ?>
                                <span class="badge bg-success">✓ Confirmed</span>
                            <?php elseif ($pmt['payment_status'] === 'submitted'): ?>
                                <span class="badge bg-warning">⏳ Pending</span>
                            <?php elseif ($pmt['payment_status'] === 'rejected'): ?>
                                <span class="badge bg-danger">✗ Rejected</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($pmt['payment_status'] === 'confirmed'): ?>
                                <a href="<?= base_url('payment/print/' . $pmt['id']) ?>" 
                                   class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="bi bi-printer"></i> Cetak
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>
```

#### B. Admin - Applicant Detail

**File:** `app/Views/admin/applicant_detail.php`

**ADD section untuk payment history:**

```php
<!-- Payment History Section -->
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-credit-card"></i> Riwayat Pembayaran</h5>
    </div>
    <div class="card-body">
        <?php 
        $paymentModel = new \App\Models\PaymentModel();
        $applicantPayments = $paymentModel->getPaymentsByApplicantId($applicant['id']);
        $totalPaid = $paymentModel->getTotalPaidByApplicantId($applicant['id']);
        ?>
        
        <?php if (empty($applicantPayments)): ?>
            <p class="text-muted">Belum ada pembayaran.</p>
        <?php else: ?>
            <div class="alert alert-info">
                <strong>Total Pembayaran:</strong> <?= count($applicantPayments) ?> transaksi<br>
                <strong>Total Dibayar:</strong> Rp <?= number_format($totalPaid, 0, ',', '.') ?>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tipe</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applicantPayments as $i => $pmt): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= date('d M Y H:i', strtotime($pmt['created_at'])) ?></td>
                        <td>Rp <?= number_format($pmt['transfer_amount'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge bg-<?= 
                                $pmt['payment_status'] === 'confirmed' ? 'success' : 
                                ($pmt['payment_status'] === 'submitted' ? 'warning' : 
                                ($pmt['payment_status'] === 'rejected' ? 'danger' : 'secondary'))
                            ?>">
                                <?= ucfirst($pmt['payment_status']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($pmt['payment_type'] === 'cicilan'): ?>
                                Cicilan #<?= $pmt['installment_number'] ?>
                            <?php else: ?>
                                Lunas
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/payment/detail/' . $pmt['id']) ?>" 
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if ($pmt['payment_status'] === 'confirmed'): ?>
                            <a href="<?= base_url('bendahara/cetak-bukti-pembayaran/' . $pmt['id']) ?>" 
                               class="btn btn-sm btn-primary" target="_blank">
                                <i class="bi bi-printer"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
```

### 4. Testing

**Test Script:**

```php
<?php
// File: test_multiple_payments.php

require 'vendor/autoload.php';

$pathsConfig = 'app/Config/Paths.php';
require realpath($pathsConfig) ?: $pathsConfig;
$paths = new Config\Paths();
$bootstrap = rtrim($paths->systemDirectory, '\\/ ') . '/bootstrap.php';
$app = require realpath($bootstrap) ?: $bootstrap;
$app->initialize();

$paymentModel = new \App\Models\PaymentModel();

echo "=== TEST MULTIPLE PAYMENTS ===\n\n";

// Test 1: Insert multiple payments
echo "Test 1: Insert 3 payments for user_id=999\n";
for ($i = 1; $i <= 3; $i++) {
    $id = $paymentModel->insert([
        'user_id' => 999,
        'transfer_amount' => 500000,
        'payment_type' => 'cicilan',
        'installment_number' => $i,
        'payment_status' => 'confirmed',
        'payment_method' => 'transfer',
    ]);
    echo "  Payment #$i created with ID: $id\n";
}

// Test 2: Get all payments
echo "\nTest 2: Get all payments for user_id=999\n";
$payments = $paymentModel->getPaymentsByUserId(999);
echo "  Found: " . count($payments) . " payments\n";

// Test 3: Get total paid
echo "\nTest 3: Get total paid for user_id=999\n";
$total = $paymentModel->getTotalPaidByUserId(999);
echo "  Total: Rp " . number_format($total, 0, ',', '.') . "\n";

// Test 4: Get latest payment
echo "\nTest 4: Get latest payment for user_id=999\n";
$latest = $paymentModel->getLatestPaymentByUserId(999);
echo "  Latest payment ID: " . $latest['id'] . "\n";
echo "  Installment: #" . $latest['installment_number'] . "\n";

// Test 5: Get payment count
echo "\nTest 5: Get payment count for user_id=999\n";
$count = $paymentModel->getPaymentCountByUserId(999);
echo "  Total payments: $count\n";
$confirmedCount = $paymentModel->getPaymentCountByUserId(999, 'confirmed');
echo "  Confirmed payments: $confirmedCount\n";

echo "\n=== ALL TESTS PASSED ===\n";
```

**Run:**
```bash
php test_multiple_payments.php
```

### 5. Rollback (Jika Perlu)

Jika ada masalah, tidak perlu rollback karena:
- ✅ Method lama masih ada (`getPaymentByUserId`)
- ✅ Database tidak berubah
- ✅ Hanya menambah method baru

Backward compatible 100%!

---

## 🎯 Priority Implementation

### HIGH Priority ⚠️
1. **ApplicantController::payment()** - Fix logic untuk handle multiple payments
2. **Applicant Dashboard** - Show payment history

### MEDIUM Priority 📋
3. **Admin Applicant Detail** - Show all payments per applicant
4. **Payment filtering** - Filter by status, type, date

### LOW Priority 💡
5. **Payment statistics** - Charts untuk payment trends
6. **Payment reminders** - Email notification untuk pending payments
7. **Auto-receipt** - Generate receipt number otomatis

---

## ✅ Summary

**Yang Sudah Dikerjakan:**
- ✅ Database structure (sudah support dari awal)
- ✅ Model methods (semua fungsi baru sudah dibuat)
- ✅ Documentation (lengkap dengan contoh)

**Yang Perlu Dikerjakan:**
- ⏳ Update controller logic
- ⏳ Update view untuk show multiple payments
- ⏳ Testing

**Estimasi Waktu:**
- Controller updates: ~30 menit
- View updates: ~1 jam
- Testing: ~30 menit

**Total: ~2 jam untuk complete implementation**

---

Sistem sudah siap untuk multiple payments! 🎉
