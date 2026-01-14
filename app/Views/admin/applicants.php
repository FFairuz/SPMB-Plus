<?= $this->extend('layout/app') ?>

<?= $this->section('title'); ?>Daftar Pendaftar<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="/css/status-badges.css">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 fw-bold">
            <i class="bi bi-people-fill text-primary"></i> Daftar Pendaftar
            <?php if (!empty($filter_status)): ?>
                <span class="text-muted fs-5">/ <?= ucfirst(str_replace('_', ' ', $filter_status)); ?></span>
            <?php endif; ?>
        </h2>
        <p class="text-muted mb-0">Kelola dan monitor semua pendaftar PPDB</p>
    </div>
    <div>
        <a href="/admin/applicant-register" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pendaftar
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Filter Tabs -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <ul class="nav nav-pills gap-2">
            <li class="nav-item">
                <a class="nav-link <?= empty($filter_status) ? 'active' : ''; ?>" href="/admin/applicants">
                    <i class="bi bi-list-ul me-1"></i> Semua
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $filter_status === 'pending' ? 'active' : ''; ?>" href="/admin/applicants/pending">
                    <i class="bi bi-clock me-1"></i> Menunggu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $filter_status === 'verified' ? 'active' : ''; ?>" href="/admin/applicants/verified">
                    <i class="bi bi-check-circle me-1"></i> Terverifikasi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $filter_status === 'accepted' ? 'active' : ''; ?>" href="/admin/applicants/accepted">
                    <i class="bi bi-check2-all me-1"></i> Diterima
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $filter_status === 'rejected' ? 'active' : ''; ?>" href="/admin/applicants/rejected">
                    <i class="bi bi-x-circle me-1"></i> Ditolak
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Applicants Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (!empty($applicants)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <tr>
                            <th class="py-3 px-4 fw-semibold text-center" style="width: 60px;">
                                <i class="bi bi-hash text-primary me-1"></i> No
                            </th>
                            <th class="py-3 fw-semibold">
                                <i class="bi bi-person text-primary me-1"></i> Nama Lengkap
                            </th>
                            <th class="py-3 fw-semibold">
                                <i class="bi bi-envelope text-primary me-1"></i> Email
                            </th>
                            <th class="py-3 fw-semibold">
                                <i class="bi bi-building text-primary me-1"></i> Asal Sekolah
                            </th>
                            <th class="py-3 fw-semibold">
                                <i class="bi bi-flag text-primary me-1"></i> Status
                            </th>
                            <th class="py-3 fw-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applicants as $index => $applicant): ?>
                            <tr class="border-bottom">
                                <td class="px-4 text-center">
                                    <span class="badge bg-light text-dark border fw-bold">
                                        <?= $index + 1 ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </div>
                                        <strong><?= $applicant['nama_lengkap'] ?? 'N/A'; ?></strong>
                                    </div>
                                </td>
                                <td class="text-muted"><?= $applicant['email'] ?? 'N/A'; ?></td>
                                <td><?= $applicant['asal_sekolah'] ?? 'N/A'; ?></td>
                                <td>
                                    <?php
                                    $status_config = [
                                        'draft' => ['label' => 'Draft', 'class' => 'status-draft', 'icon' => 'file-earmark'],
                                        'pending' => ['label' => 'Menunggu', 'class' => 'status-draft', 'icon' => 'clock'],
                                        'submitted' => ['label' => 'Disubmit', 'class' => 'status-submitted', 'icon' => 'send'],
                                        'verified' => ['label' => 'Terverifikasi', 'class' => 'status-verified', 'icon' => 'check-circle'],
                                        'accepted' => ['label' => 'Diterima', 'class' => 'status-accepted', 'icon' => 'check2-all'],
                                        'rejected' => ['label' => 'Ditolak', 'class' => 'status-rejected', 'icon' => 'x-circle'],
                                    ];
                                    $status = $applicant['status'];
                                    $config = $status_config[$status] ?? ['label' => $status, 'class' => 'status-draft', 'icon' => 'question'];
                                    ?>
                                    <span class="status-badge <?= $config['class']; ?>" data-tooltip="Status: <?= $config['label']; ?>">
                                        <i class="bi bi-<?= $config['icon']; ?>"></i>
                                        <?= $config['label']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="/admin/applicants/<?= $applicant['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-5 text-center">
                <div class="mb-3" style="opacity: 0.3;">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: #6c757d;"></i>
                </div>
                <h5 class="text-muted mb-2">Tidak ada pendaftar</h5>
                <p class="text-muted small mb-3">Belum ada pendaftar yang sesuai dengan filter ini</p>
                <a href="/admin/applicants" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i> Lihat Semua
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
        </div>

<?= $this->endSection(); ?>
