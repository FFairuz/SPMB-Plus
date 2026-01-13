<?= $this->extend('layout/app'); ?>

<?= $this->section('content'); ?>
<div class="container py-4">
    <h1><?= $title ?? 'Test Results'; ?></h1>
    <div class="alert alert-info">
        <?= $message ?? 'Test results'; ?>
    </div>
    
    <div class="card">
        <div class="card-body">
            <ul>
                <?php foreach ($results as $result): ?>
                <li><?= htmlspecialchars($result); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="mt-3">
        <a href="/bendahara/verifikasi-pembayaran" class="btn btn-primary">Go to Verifikasi Pembayaran</a>
        <a href="/" class="btn btn-secondary">Home</a>
    </div>
</div>
<?= $this->endSection(); ?>
