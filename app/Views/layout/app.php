<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Penerimaan Mahasiswa Baru - SPMB Plus untuk mengelola pendaftaran siswa secara online">
    <meta name="theme-color" content="#3b82f6">
    
    <!-- PWA Meta Tags -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="SPMB Plus">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    
    <!-- PWA Icons -->
    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('pwa-icons/icon-192x192.png') ?>">
    <link rel="icon" type="image/png" sizes="512x512" href="<?= base_url('pwa-icons/icon-512x512.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('pwa-icons/icon-192x192.png') ?>">
    
    <title><?= $title ?? app_name() ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="<?= base_url('css/readability.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/dynamic-logo.css') ?>">
    <style>
        :root {
            /* Modern Blue & White - Clean & Professional */
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --primary-light: #60a5fa;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
            --dark-color: #1e293b;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #eff6ff 100%);
            color: #334155;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-bottom: 2px solid #60a5fa;
            padding: 0.5rem 1.5rem;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 56px;
        }

        .navbar * {
            color: white !important;
        }

        .navbar i,
        .navbar .bi,
        .navbar .fas,
        .navbar .far,
        .navbar .fab {
            color: white !important;
        }

        .navbar-brand {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: #ffffff !important;
            transform: translateY(-2px);
        }

        .navbar-brand i {
            font-size: 1.3rem;
            color: #ffffff !important;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 0.875rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
            border: 2px solid #60a5fa;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: #ffffff !important;
            font-size: 0.813rem;
            line-height: 1.2;
        }

        .user-role {
            font-size: 0.688rem;
            color: rgba(255, 255, 255, 0.8) !important;
            color: rgba(255, 255, 255, 0.85);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .navbar-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-navbar {
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.813rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.375rem;
            text-decoration: none;
        }

        .btn-navbar i {
            font-size: 0.875rem;
        }

        .btn-edit-profile {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white !important;
            border: 2px solid #10b981;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-edit-profile * {
            color: white !important;
        }

        .btn-edit-profile i,
        .btn-edit-profile .bi {
            color: white !important;
        }

        .btn-edit-profile:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white !important;
            border-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.5);
        }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white !important;
            border: 2px solid #ef4444;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-logout * {
            color: white !important;
        }

        .btn-logout i,
        .btn-logout .bi {
            color: white !important;
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border-color: #dc2626;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.5);
        }

        /* Digital Clock */
        .digital-clock {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            padding: 0.375rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            margin-right: 0.75rem;
            backdrop-filter: blur(10px);
        }

        .clock-time {
            font-size: 1rem;
            font-weight: 700;
            color: white !important;
            font-family: 'Courier New', monospace;
            letter-spacing: 0.5px;
        }

        .clock-date {
            font-size: 0.688rem;
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin-top: 1px;
        }

        /* PWA Install Button */
        #pwa-install-btn {
            display: none;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white !important;
            border: 1.5px solid #10b981;
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            margin-right: 0.75rem;
            font-size: 0.813rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
        }

        #pwa-install-btn i {
            margin-right: 0.375rem;
            font-size: 0.875rem;
            color: white !important;
        }

        #pwa-install-btn:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        /* PWA Mode Adjustments */
        .pwa-mode #pwa-install-btn {
            display: none !important;
        }

        /* Navbar Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 0.5rem 1rem;
                flex-wrap: wrap;
                min-height: 52px;
            }

            .navbar-brand {
                font-size: 0.938rem;
            }

            .navbar-brand i {
                font-size: 1.125rem;
            }

            .user-details {
                display: none;
            }

            .navbar-actions {
                gap: 0.5rem;
            }

            .digital-clock {
                display: none;
            }

            #pwa-install-btn {
                display: none !important;
            }

            .btn-navbar {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }

            .btn-navbar span {
                display: none;
            }

            .btn-navbar i {
                margin: 0;
            }
        }

        /* Container Layout */
        .main-container {
            display: flex;
            flex: 1;
            min-height: 0;
            width: 100%;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            border-right: 3px solid #60a5fa;
            color: #ffffff;
            padding: 24px 0;
            overflow-y: auto;
            box-shadow: 2px 0 15px rgba(59, 130, 246, 0.3);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar .nav-link i {
            width: 22px;
            font-size: 1.2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.9);
        }

        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .sidebar .nav-link:hover i {
            color: #ffffff;
        }

        .sidebar .nav-link.active {
            color: #3b82f6;
            background-color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .sidebar .nav-link.active i {
            color: #3b82f6;
        }

        .sidebar-divider {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.2);
            margin: 16px 16px;
        }

        .sidebar h6 {
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 24px 20px 12px;
            opacity: 0.95;
        }

        .sidebar h6 i {
            color: #ffffff;
            margin-right: 8px;
            opacity: 0.95;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
            min-width: 0;
            word-wrap: break-word;
            overflow-wrap: break-word;
            background-color: var(--light-bg);
        }

        /* Card Styling */
        .card {
            border: 2px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.1);
            transition: all 0.3s ease;
            background: #ffffff;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2);
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white !important;
            border-bottom: none;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        .card-header * {
            color: white !important;
        }

        .card-header i,
        .card-header .bi {
            color: white !important;
        }

        /* Buttons */
        .btn {
            padding: 0.625rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-primary * {
            color: white !important;
        }

        .btn-primary i,
        .btn-primary .bi {
            color: white !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.5);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.5);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.5);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.5);
        }

        .btn-info {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.5);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .btn i {
            margin-right: 0.5rem;
            transition: transform 0.3s ease;
        }

        .btn:hover i {
            transform: scale(1.1);
        }

        /* Badges */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.75rem;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .badge-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .badge-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white !important;
        }

        .badge-primary * {
            color: white !important;
        }

        .badge-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
            color: white;
        }

        .badge-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
        }

        .badge-secondary {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
        }

        /* Tables */
        .table {
            color: #334155;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white !important;
            border-bottom: none;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .table thead * {
            color: white !important;
        }

        .table thead i,
        .table thead .bi {
            color: white !important;
        }

        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            color: white !important;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 1.125rem 1rem;
            border: none;
        }

        .table th:first-child {
            border-top-left-radius: 12px;
        }

        .table th:last-child {
            border-top-right-radius: 12px;
        }

        .table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: linear-gradient(90deg, #eff6ff 0%, #dbeafe 100%);
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
        }

        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 12px;
        }

        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 12px;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1.125rem 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .alert:hover {
            transform: translateX(4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .alert i {
            font-size: 1.25rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-left-color: #10b981;
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-left-color: #ef4444;
            color: #991b1b;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left-color: #f59e0b;
            color: #92400e;
        }

        .alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left-color: #0ea5e9;
            color: #1e40af;
        }

        /* Forms */
        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border: 2px solid #cbd5e1;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            outline: none;
            background-color: #ffffff;
        }

        .form-control:hover, .form-select:hover {
            border-color: #94a3b8;
        }

        .form-control::placeholder {
            color: #94a3b8;
            opacity: 0.7;
        }

        .form-control:disabled, .form-select:disabled {
            background-color: #f1f5f9;
            border-color: #e2e8f0;
            color: #94a3b8;
            cursor: not-allowed;
        }
            overflow: hidden;
            margin-bottom: 20px;
        }

        h1, h2, h3, h4, h5, h6 {
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        p {
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 1.25rem;
            font-weight: 600;
        }

        /* Form Styling */
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.15);
        }

        /* Table Styling */
        .table {
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-left: 4px solid;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: var(--success-color);
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: var(--danger-color);
            color: #721c24;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: var(--warning-color);
            color: #856404;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: var(--info-color);
            color: #0c5460;
        }

        /* Button Styling */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.4);
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        /* Badge Styling */
        .badge {
            padding: 6px 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Footer Styling */
        footer {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white !important;
            padding: 1.25rem 1.5rem;
            margin-top: auto;
            width: 100%;
            border-top: 3px solid #60a5fa;
        }

        footer * {
            color: white !important;
        }

        footer i,
        footer .bi {
            color: white !important;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .footer-text {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.95;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                min-height: auto;
            }

            .sidebar {
                width: 100%;
                padding: 15px 0;
            }

            .sidebar h6 {
                margin: 20px 15px 10px;
            }

            .sidebar .nav-link {
                padding: 10px 15px;
                margin: 3px 8px;
            }

            .main-content {
                padding: 20px;
                min-width: 100%;
            }

            .card {
                margin-bottom: 15px;
            }

            .table {
                font-size: 0.85rem;
            }

            .table thead th {
                padding: 10px;
            }

            .table tbody td {
                padding: 8px;
            }
        }

        /* Icon Enhancements */
        .icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .icon-circle:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .icon-circle.primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white !important;
        }

        .icon-circle.primary * {
            color: white !important;
        }

        .icon-circle.primary i,
        .icon-circle.primary .bi {
            color: white !important;
        }

        .icon-circle.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .icon-circle.danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        /* Background Primary */
        .bg-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            color: white !important;
        }

        .bg-primary * {
            color: white !important;
        }

        .bg-primary i,
        .bg-primary .bi,
        .bg-primary .fas,
        .bg-primary .far,
        .bg-primary .fab {
            color: white !important;
        }

        .bg-primary h1,
        .bg-primary h2,
        .bg-primary h3,
        .bg-primary h4,
        .bg-primary h5,
        .bg-primary h6,
        .bg-primary p,
        .bg-primary span,
        .bg-primary a,
        .bg-primary div {
            color: white !important;
        }

        .icon-circle.warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .icon-circle.info {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
        }

        .bi, .fas, .fa {
            transition: all 0.3s ease;
        }

        .text-primary .bi, .text-primary .fas {
            color: var(--primary-color);
        }

        .text-success .bi, .text-success .fas {
            color: var(--success-color);
        }

        .text-danger .bi, .text-danger .fas {
            color: var(--danger-color);
        }

        .text-warning .bi, .text-warning .fas {
            color: var(--warning-color);
        }

        .text-info .bi, .text-info .fas {
            color: var(--info-color);
        }

        /* Stats Card Enhancements */
        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            border-left: 4px solid;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .stats-card.primary {
            border-left-color: #3b82f6;
        }

        .stats-card.success {
            border-left-color: #10b981;
        }

        .stats-card.danger {
            border-left-color: #ef4444;
        }

        .stats-card.warning {
            border-left-color: #f59e0b;
        }

        .stats-card.info {
            border-left-color: #0ea5e9;
        }

        /* Dropdown Menu Enhancements */
        .dropdown-menu {
            border: 2px solid #cbd5e1;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #3b82f6;
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        /* Input Group Enhancements */
        .input-group-text {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            font-weight: 600;
        }

        /* Pagination Enhancements */
        .pagination .page-link {
            border: 2px solid #cbd5e1;
            color: #3b82f6;
            border-radius: 8px;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border-color: #3b82f6;
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* Modal Enhancements */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border-radius: 16px 16px 0 0;
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
        }

        /* Progress Bar Enhancements */
        .progress {
            height: 12px;
            border-radius: 25px;
            background-color: #e2e8f0;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .progress-bar {
            background: linear-gradient(90deg, #3b82f6 0%, #60a5fa 100%);
            border-radius: 25px;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
            transition: width 0.6s ease;
        }

        /* List Group Enhancements */
        .list-group-item {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            transform: translateX(5px);
            border-color: #3b82f6;
        }

        .list-group-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-color: #3b82f6;
        }
        .shadow-sm {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
        }

        .shadow {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .fw-bold {
            font-weight: 700;
        }

        .me-2 {
            margin-right: 0.5rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .pb-3 {
            padding-bottom: 1rem;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
        }
    </style>
    <?= $this->renderSection('styles'); ?>
</head>

<body>
    <!-- Navbar -->
    <?php if (session()->get('is_logged_in')): ?>
    <nav class="navbar">
        <a href="<?= base_url('/') ?>" class="navbar-brand">
            <?php 
            $logo = app_logo();
            $appName = app_name();
            ?>
            <?php if (strpos($logo, 'default-logo.png') === false && file_exists(str_replace(base_url(), FCPATH, $logo))): ?>
                <img src="<?= $logo ?>" alt="<?= esc($appName) ?>" style="height: 40px; width: auto; object-fit: contain;">
            <?php else: ?>
                <i class="bi bi-mortarboard-fill"></i>
            <?php endif; ?>
            <span><?= esc($appName) ?></span>
        </a>
        
        <div class="navbar-user">
            <div class="user-info">
                <div class="user-avatar">
                    <?php if (session()->get('profile_picture') && file_exists(FCPATH . 'uploads/profiles/' . session()->get('profile_picture'))): ?>
                        <img src="<?= base_url('uploads/profiles/' . session()->get('profile_picture')) ?>" 
                             alt="Profile" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <?= strtoupper(substr(session()->get('username'), 0, 1)) ?>
                    <?php endif; ?>
                </div>
                <div class="user-details">
                    <span class="user-name"><?= session()->get('username') ?></span>
                    <span class="user-role"><?= session()->get('role') ?></span>
                </div>
            </div>
            
            <div class="navbar-actions">
                <button id="pwa-install-btn" title="Install aplikasi ke perangkat Anda">
                    <i class="bi bi-download"></i>
                    <span>Install App</span>
                </button>
                <div class="digital-clock">
                    <div class="clock-time" id="clockTime">00:00:00</div>
                    <div class="clock-date" id="clockDate">Loading...</div>
                </div>
                <a href="<?= base_url('profile/edit') ?>" class="btn-navbar btn-edit-profile">
                    <i class="bi bi-person-gear"></i>
                    <span>Edit Profile</span>
                </a>
                <a href="<?= base_url('auth/logout') ?>" class="btn-navbar btn-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <?php if (session()->get('is_logged_in') && session()->get('role') === 'admin'): ?>
            <!-- Admin dapat mengakses semua menu dari semua role -->
            <aside class="sidebar" style="overflow-y: auto;">
                <nav class="nav flex-column">
                    <!-- Dashboard Menu -->
                    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= (strpos(current_url(), 'admin/dashboard') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <div class="sidebar-divider"></div>
                    
                    <!-- Admin Menu -->
                    <a href="<?= base_url('admin/applicants') ?>" class="nav-link <?= (strpos(current_url(), 'admin/applicants') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-people"></i>
                        <span>Daftar Pendaftar</span>
                    </a>
                    <a href="<?= base_url('admin/payments') ?>" class="nav-link <?= (strpos(current_url(), 'admin/payments') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-credit-card"></i>
                        <span>Verifikasi Pembayaran</span>
                    </a>
                    <a href="<?= base_url('admin/kelola-akun') ?>" class="nav-link <?= (strpos(current_url(), 'admin/kelola-akun') !== false || strpos(current_url(), 'admin/tambah-akun') !== false || strpos(current_url(), 'admin/edit-akun') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-person-gear"></i>
                        <span>Kelola Akun</span>
                    </a>
                    <a href="<?= base_url('admin/schools') ?>" class="nav-link <?= (strpos(current_url(), 'admin/schools') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-building"></i>
                        <span>Asal Sekolah</span>
                    </a>
                    <a href="<?= base_url('admin/majors') ?>" class="nav-link <?= (strpos(current_url(), 'admin/majors') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-mortarboard"></i>
                        <span>Kelola Jurusan</span>
                    </a>
                    <a href="<?= base_url('admin/quotas') ?>" class="nav-link <?= (strpos(current_url(), 'admin/quotas') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-pie-chart"></i>
                        <span>Kuota Jurusan</span>
                    </a>
                    <a href="<?= base_url('admin/hobbies') ?>" class="nav-link <?= (strpos(current_url(), 'admin/hobbies') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-star"></i>
                        <span>Kelola Hobi</span>
                    </a>
                    <a href="<?= base_url('admin/academic-years') ?>" class="nav-link <?= (strpos(current_url(), 'admin/academic-years') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-calendar-range"></i>
                        <span>Tahun Ajaran</span>
                    </a>
                    <a href="<?= base_url('admin/content-management') ?>" class="nav-link <?= (strpos(current_url(), 'admin/content-management') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-layout-text-sidebar-reverse"></i>
                        <span>Kelola Konten Home</span>
                    </a>
                    <a href="<?= base_url('admin/sales-content') ?>" class="nav-link <?= (strpos(current_url(), 'admin/sales-content') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-camera-video"></i>
                        <span>Kelola Konten Sales</span>
                    </a>
                    <a href="<?= base_url('admin/settings') ?>" class="nav-link <?= (strpos(current_url(), 'admin/settings') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-gear-fill"></i>
                        <span>Pengaturan Aplikasi</span>
                    </a>
                    <a href="<?= base_url('admin/form-management') ?>" class="nav-link <?= (strpos(current_url(), 'admin/form-management') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-ui-checks"></i>
                        <span>Manajemen Formulir</span>
                    </a>

                    <div class="sidebar-divider"></div>

                    <!-- Panitia Menu -->
                    <a href="<?= base_url('panitia/daftar-siswa') ?>" class="nav-link <?= (strpos(current_url(), 'panitia/daftar-siswa') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-list-check"></i>
                        <span>Daftar Siswa</span>
                    </a>
                    <a href="<?= base_url('panitia/tambah-siswa') ?>" class="nav-link <?= (strpos(current_url(), 'panitia/tambah-siswa') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-person-plus"></i>
                        <span>Tambah Siswa</span>
                    </a>

                    <div class="sidebar-divider"></div>

                    <!-- Bendahara Menu -->
                    <a href="<?= base_url('bendahara/verifikasi-pembayaran') ?>" class="nav-link <?= (strpos(current_url(), 'bendahara/verifikasi-pembayaran') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-check-circle"></i>
                        <span>Verifikasi Pembayaran</span>
                    </a>
                    <a href="<?= base_url('bendahara/laporan-keuangan') ?>" class="nav-link <?= (strpos(current_url(), 'bendahara/laporan-keuangan') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-graph-up"></i>
                        <span>Laporan Keuangan</span>
                    </a>

                    <div class="sidebar-divider"></div>

                    <!-- Sales Menu -->
                    <a href="<?= base_url('sales/video') ?>" class="nav-link <?= (strpos(current_url(), 'sales/video') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-play-circle"></i>
                        <span>Video Sekolah</span>
                    </a>
                    <a href="<?= base_url('sales/informasi-biaya') ?>" class="nav-link <?= (strpos(current_url(), 'sales/informasi-biaya') !== false) ? 'active' : '' ?>">
                        <i class="bi bi-cash-stack"></i>
                        <span>Informasi Biaya</span>
                    </a>
                </nav>
            </aside>
        <?php elseif (session()->get('is_logged_in') && session()->get('role') === 'panitia'): ?>
            <?= $this->include('layout/panitia_sidebar'); ?>
        <?php elseif (session()->get('is_logged_in') && session()->get('role') === 'bendahara'): ?>
            <?= $this->include('layout/bendahara_sidebar'); ?>
        <?php elseif (session()->get('is_logged_in') && session()->get('role') === 'sales'): ?>
            <?= $this->include('layout/sales_sidebar'); ?>
        <?php elseif (session()->get('is_logged_in') && session()->get('role') === 'applicant'): ?>
            <?= $this->include('layout/applicant_sidebar'); ?>
        <?php endif; ?>

        <!-- Main Content -->
        <div class="main-content">
            <?= $this->renderSection('content'); ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p class="footer-text">&copy; <?= date('Y') ?> <?= esc(app_name()) ?> - <?= esc(app_description()) ?></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- PWA Registration Script -->
    <script>
        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('<?= base_url('sw.js') ?>')
                    .then(registration => {
                        console.log('✅ Service Worker registered successfully:', registration.scope);
                        
                        // Check for updates periodically
                        setInterval(() => {
                            registration.update();
                        }, 60000); // Check every minute
                    })
                    .catch(error => {
                        console.error('❌ Service Worker registration failed:', error);
                    });
            });
            
            // Handle service worker updates
            navigator.serviceWorker.addEventListener('controllerchange', () => {
                console.log('🔄 New Service Worker activated');
                // Optional: show notification to user about update
            });
        }
        
        // PWA Install Prompt
        let deferredPrompt;
        const installButton = document.getElementById('pwa-install-btn');
        
        window.addEventListener('beforeinstallprompt', (e) => {
            console.log('📱 PWA install prompt available');
            e.preventDefault();
            deferredPrompt = e;
            
            // Show install button
            if (installButton) {
                installButton.style.display = 'inline-block';
            }
        });
        
        // Handle install button click
        if (installButton) {
            installButton.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    console.log(`User response to install prompt: ${outcome}`);
                    deferredPrompt = null;
                    installButton.style.display = 'none';
                }
            });
        }
        
        // Detect if app is installed
        window.addEventListener('appinstalled', () => {
            console.log('✅ PWA installed successfully');
            deferredPrompt = null;
            if (installButton) {
                installButton.style.display = 'none';
            }
        });
        
        // Check if running as PWA
        function isPWA() {
            return window.matchMedia('(display-mode: standalone)').matches ||
                   window.navigator.standalone === true;
        }
        
        if (isPWA()) {
            console.log('🚀 Running as PWA');
            document.body.classList.add('pwa-mode');
        }
    </script>
    
    <!-- Digital Clock Script -->
    <script>
        function updateClock() {
            const now = new Date();
            
            // Format time (HH:MM:SS)
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;
            
            // Format date (Day, DD Month YYYY)
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const date = String(now.getDate()).padStart(2, '0');
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            const dateString = `${dayName}, ${date} ${monthName} ${year}`;
            
            // Update DOM
            const clockTime = document.getElementById('clockTime');
            const clockDate = document.getElementById('clockDate');
            
            if (clockTime) clockTime.textContent = timeString;
            if (clockDate) clockDate.textContent = dateString;
        }
        
        // Update clock immediately and then every second
        updateClock();
        setInterval(updateClock, 1000);
    </script>
    
    <?= $this->renderSection('scripts'); ?>
</body>

</html>
