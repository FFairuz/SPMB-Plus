<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/" style="font-size: 1.25rem;">
            <i class="bi bi-mortarboard"></i> PPDB System
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <?php if (session()->has('user_id')): ?>
                    <?php
                        $role = session()->get('role');
                        $dashboardUrl = '/';
                        switch ($role) {
                            case 'admin':
                                $dashboardUrl = '/admin/dashboard';
                                break;
                            case 'panitia':
                                $dashboardUrl = '/panitia/dashboard';
                                break;
                            case 'bendahara':
                                $dashboardUrl = '/bendahara/dashboard';
                                break;
                            case 'sales':
                                $dashboardUrl = '/sales/dashboard';
                                break;
                            default:
                                $dashboardUrl = '/applicant/dashboard';
                                break;
                        }
                    ?>

                    <!-- MAIN MENU DROPDOWN -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="mainMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-grid-3x3-gap"></i> <span class="d-none d-md-inline">Menu</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="<?= $dashboardUrl ?>"><i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard</a></li>
                            <?php if ($role === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/admin/applicants"><i class="bi bi-people me-2 text-primary"></i> Data Pendaftar</a></li>
                                <li><a class="dropdown-item" href="/admin/tambah-siswa"><i class="bi bi-person-plus me-2 text-success"></i> Tambah Siswa</a></li>
                                <li><a class="dropdown-item" href="/admin/daftar-siswa"><i class="bi bi-list-check me-2 text-info"></i> Daftar Siswa</a></li>
                                <li><a class="dropdown-item" href="/admin/payments"><i class="bi bi-credit-card me-2 text-warning"></i> Pembayaran</a></li>
                                <li><a class="dropdown-item" href="/admin/kelola-akun"><i class="bi bi-person-gear me-2 text-secondary"></i> Kelola Akun</a></li>
                            <?php elseif ($role === 'panitia'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/panitia/dashboard"><i class="bi bi-clipboard-check me-2 text-primary"></i> Verifikasi</a></li>
                                <li><a class="dropdown-item" href="/panitia/daftar-siswa"><i class="bi bi-people me-2 text-info"></i> Data Siswa</a></li>
                            <?php elseif ($role === 'bendahara'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/bendahara/dashboard"><i class="bi bi-wallet2 me-2 text-success"></i> Ringkasan</a></li>
                                <li><a class="dropdown-item" href="/bendahara/pembayaran"><i class="bi bi-cash-stack me-2 text-warning"></i> Pembayaran</a></li>
                            <?php elseif ($role === 'sales'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/sales/dashboard"><i class="bi bi-megaphone me-2 text-primary"></i> Sales</a></li>
                                <li><a class="dropdown-item" href="/sales/biaya"><i class="bi bi-journal-text me-2 text-info"></i> Info Biaya</a></li>
                            <?php else: ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/applicant/payment"><i class="bi bi-credit-card me-2 text-success"></i> Pembayaran</a></li>
                                <li><a class="dropdown-item" href="/applicant/register"><i class="bi bi-pencil-square me-2 text-primary"></i> Pendaftaran</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <!-- PAYMENT NOTIFICATION -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="/applicant/payment">
                            <i class="bi bi-bell-fill text-primary"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                <span class="visually-hidden">notifikasi pembayaran</span>
                            </span>
                        </a>
                    </li>
                    
                    <!-- USER PROFILE DROPDOWN -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-1">
                                <i class="bi bi-person-circle text-primary fs-5"></i>
                            </div>
                            <span class="text-dark"><?= substr(session()->get('username'), 0, 12) . (strlen(session()->get('username')) > 12 ? '...' : '') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenu">
                            <li><span class="dropdown-item-text text-muted small">Logged as <strong class="text-primary"><?= ucfirst(session()->get('role')) ?></strong></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/auth/logout"><i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/login" style="color: white !important;"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>