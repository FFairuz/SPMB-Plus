<?= $this->extend('layout/app'); ?>

<?= $this->section('content'); ?>
<div class="container py-4">
    <h1>Debug - Payment Data</h1>
    
    <div class="alert alert-info">
        <strong>Total Applicants:</strong> <?= $total_applicants; ?><br>
        <strong>Total Payments:</strong> <?= $total_payments; ?><br>
        <strong>Confirmed Payments:</strong> <?= $confirmed_payments; ?><br>
    </div>

    <h2>Payment Status Distribution</h2>
    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payment_statuses as $ps): ?>
                <tr>
                    <td><?= htmlspecialchars($ps['payment_status'] ?? 'NULL'); ?></td>
                    <td><?= $ps['count']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2>Last 20 All Payments (no filter)</h2>
    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Applicant ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Bank/Method</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_payments as $p): ?>
                <tr>
                    <td><?= $p['id']; ?></td>
                    <td><?= $p['applicant_id'] ?? 'NULL'; ?></td>
                    <td>Rp <?= number_format($p['transfer_amount'] ?? 0, 0, ',', '.'); ?></td>
                    <td><span class="badge bg-primary"><?= htmlspecialchars($p['payment_status'] ?? 'NULL'); ?></span></td>
                    <td><?= htmlspecialchars($p['bank_name'] ?? '-'); ?></td>
                    <td><?= $p['created_at']; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($all_payments)): ?>
                <tr><td colspan="6" class="text-center text-muted">No payments</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <h2>Confirmed Payments with Applicant Join</h2>
    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Amount</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $p): ?>
                <tr>
                    <td><?= $p['id']; ?></td>
                    <td><?= htmlspecialchars($p['nama_lengkap'] ?? 'N/A'); ?></td>
                    <td>Rp <?= number_format($p['transfer_amount'] ?? 0, 0, ',', '.'); ?></td>
                    <td><?= $p['created_at']; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($payments)): ?>
                <tr><td colspan="4" class="text-center text-muted">No confirmed payments</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="/bendahara/cetak-bukti" class="btn btn-primary">Go to Cetak Bukti</a>
        <a href="/bendahara/dashboard" class="btn btn-secondary">Go to Dashboard</a>
    </div>
</div>
<?= $this->endSection(); ?>
