<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * 
 * PPDB Application Routes
 * Organized by functional groups for better maintainability
 */

// ============================================================================
// HOME & PWA ROUTES
// ============================================================================
$routes->get('/', 'Home::index');
$routes->get('manifest.json', 'ManifestController::index'); // Dynamic PWA Manifest

// ============================================================================
// AUTHENTICATION ROUTES
// ============================================================================
$routes->group('auth', function($routes) {
    $routes->match(['get', 'post'], 'login', 'Auth::login');
    $routes->match(['get', 'post'], 'register', 'Auth::register');
    $routes->get('logout', 'Auth::logout');
});

// ============================================================================
// PUBLIC REGISTRATION ROUTES
// ============================================================================
$routes->group('registration', function($routes) {
    $routes->get('/', 'Registration::index');
    $routes->get('wizard', 'Registration::wizard'); // Multi-step wizard form
    $routes->post('save', 'Registration::save');
    $routes->post('save-preview', 'Registration::saveAndPreview');
    $routes->get('preview', 'Registration::preview');
    $routes->post('submit', 'Registration::submit');
    $routes->get('summary', 'Registration::getSummary');
    $routes->get('print', 'Registration::printPreview');
});

// ============================================================================
// APPLICANT ROUTES (Authenticated Users)
// ============================================================================
$routes->group('applicant', function($routes) {
    $routes->get('dashboard', 'ApplicantController::dashboard');
    $routes->get('timeline', 'ApplicantController::timeline'); // Visual status timeline
    $routes->match(['get', 'post'], 'register', 'ApplicantController::register');
    $routes->match(['get', 'post'], 'edit', 'ApplicantController::edit');
    $routes->match(['get', 'post'], 'upload_documents', 'ApplicantController::upload_documents');
    $routes->match(['get', 'post'], 'payment', 'ApplicantController::payment');
    $routes->get('payment/print-receipt/(:num)', 'PaymentController::printReceipt/$1');
});

// ============================================================================
// PROFILE ROUTES
// ============================================================================
$routes->group('profile', function($routes) {
    $routes->get('/', 'ProfileController::edit');
    $routes->get('edit', 'ProfileController::edit');
    $routes->post('update', 'ProfileController::update');
});

// ============================================================================
// ADMIN ROUTES
// ============================================================================
$routes->group('admin', function($routes) {
    // Dashboard & Command Center
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('command-center', 'AdminController::commandCenter'); // Modern Dashboard v2
    
    // Payment Management
    $routes->get('payments', 'AdminController::payments');
    $routes->match(['get', 'post'], 'manual-payment', 'PaymentController::manualPaymentEntry');
    $routes->match(['get', 'post'], 'confirmPayment/(:num)', 'AdminController::confirmPayment/$1');
    $routes->match(['get', 'post'], 'rejectPayment/(:num)', 'AdminController::rejectPayment/$1');
    $routes->post('payment/(:num)/confirm', 'AdminController::confirmPayment/$1');
    $routes->post('payment/(:num)/reject', 'AdminController::rejectPayment/$1');
    $routes->get('payment/print-receipt/(:num)', 'PaymentController::printReceipt/$1');
    
    // Applicant Management
    $routes->match(['get', 'post'], 'applicant-register', 'AdminController::registerApplicant');
    $routes->post('ajax-add-school', 'AdminController::ajax_add_school');
    $routes->get('applicants', 'AdminController::applicants');
    $routes->get('applicants/(:alpha)', 'AdminController::applicants/$1');
    $routes->get('applicants/(:num)', 'AdminController::view_applicant/$1');
    $routes->post('applicants/(:num)/status', 'AdminController::update_status/$1');

    // School Management
    $routes->group('schools', function($routes) {
        $routes->get('/', 'AdminSchoolController::index');
        $routes->get('add', 'AdminSchoolController::add');
        $routes->post('save', 'AdminSchoolController::save');
        $routes->get('edit/(:num)', 'AdminSchoolController::edit/$1');
        $routes->post('update/(:num)', 'AdminSchoolController::update/$1');
        $routes->get('delete/(:num)', 'AdminSchoolController::delete/$1');
        $routes->get('search-api', 'AdminSchoolController::searchApi');
        $routes->get('detail/(:num)', 'AdminSchoolController::getDetail/$1');
        // Import functionality
        $routes->get('import-excel', 'AdminSchoolController::importForm');
        $routes->post('process-import', 'AdminSchoolController::processImport');
        $routes->get('download-template', 'AdminSchoolController::downloadTemplate');
    });

    // Account Management
    $routes->get('kelola-akun', 'AdminController::kelolaAkun');
    $routes->match(['get', 'post'], 'tambah-akun', 'AdminController::tambahAkun');
    $routes->match(['get', 'post'], 'edit-akun/(:num)', 'AdminController::editAkun/$1');
    $routes->get('hapus-akun/(:num)', 'AdminController::hapusAkun/$1');
    
    // Student Management (Admin can access Panitia features)
    $routes->match(['get', 'post'], 'tambah-siswa', 'PanitiaController::tambah_siswa');
    $routes->get('daftar-siswa', 'PanitiaController::daftar_siswa');
    $routes->get('verifikasi-pendaftar', 'PanitiaController::verifikasi_pendaftar');

    // Major Management
    $routes->group('majors', function($routes) {
        $routes->get('/', 'AdminMajorController::index');
        $routes->match(['get', 'post'], 'create', 'AdminMajorController::create');
        $routes->match(['get', 'post'], 'edit/(:num)', 'AdminMajorController::edit/$1');
        $routes->get('delete/(:num)', 'AdminMajorController::delete/$1');
        $routes->post('toggle-status/(:num)', 'AdminMajorController::toggleStatus/$1');
    });

    // Hobby Management
    $routes->group('hobbies', function($routes) {
        $routes->get('/', 'AdminHobbyController::index');
        $routes->match(['get', 'post'], 'create', 'AdminHobbyController::create');
        $routes->match(['get', 'post'], 'edit/(:num)', 'AdminHobbyController::edit/$1');
        $routes->get('delete/(:num)', 'AdminHobbyController::delete/$1');
    });

    // Quota Management
    $routes->group('quotas', function($routes) {
        $routes->get('/', 'AdminMajorQuotaController::index');
        $routes->match(['get', 'post'], 'create', 'AdminMajorQuotaController::create');
        $routes->match(['get', 'post'], 'edit/(:num)', 'AdminMajorQuotaController::edit/$1');
        $routes->post('delete/(:num)', 'AdminMajorQuotaController::delete/$1');
        $routes->post('reset/(:num)', 'AdminMajorQuotaController::resetQuotaTerisi/$1');
        $routes->get('statistics', 'AdminMajorQuotaController::statistics');
    });

    // Academic Year Management
    $routes->group('academic-years', function($routes) {
        $routes->get('/', 'AdminAcademicYearController::index');
        $routes->match(['get', 'post'], 'create', 'AdminAcademicYearController::create');
        $routes->match(['get', 'post'], 'edit/(:num)', 'AdminAcademicYearController::edit/$1');
        $routes->post('delete/(:num)', 'AdminAcademicYearController::delete/$1');
        $routes->post('set-active/(:num)', 'AdminAcademicYearController::setActive/$1');
    });

    // Kop Surat (Letterhead) Management
    $routes->match(['get', 'post'], 'kelola-kop-surat', 'AdminController::kelola_kop_surat');
    
    // Import Excel functionality
    $routes->get('import-excel', 'AdminController::importForm');
    $routes->post('process-import', 'AdminController::processImport');
    $routes->get('download-template', 'AdminController::downloadTemplate');

    // Content Management
    $routes->group('content-management', function($routes) {
        $routes->get('/', 'ContentController::index');
        $routes->get('create', 'ContentController::create');
        $routes->post('store', 'ContentController::store');
        $routes->get('edit/(:num)', 'ContentController::edit/$1');
        $routes->post('update/(:num)', 'ContentController::update/$1');
        $routes->post('delete/(:num)', 'ContentController::delete/$1');
        $routes->post('toggle-status/(:num)', 'ContentController::toggleStatus/$1');
    });

    // Settings Management
    $routes->group('settings', function($routes) {
        $routes->get('/', 'SettingsController::index');
        $routes->post('update', 'SettingsController::update');
        $routes->get('reset-logo', 'SettingsController::resetLogo');
        $routes->get('api/(:any)', 'SettingsController::getSetting/$1');
        $routes->get('api', 'SettingsController::getAllSettings');
    });

    // Sales Content Management
    $routes->group('sales-content', function($routes) {
        $routes->get('/', 'SalesContentController::index');
        $routes->get('create', 'SalesContentController::create');
        $routes->post('store', 'SalesContentController::store');
        $routes->get('edit/(:num)', 'SalesContentController::edit/$1');
        $routes->post('update/(:num)', 'SalesContentController::update/$1');
        $routes->post('delete/(:num)', 'SalesContentController::delete/$1');
        $routes->post('toggle-status/(:num)', 'SalesContentController::toggleStatus/$1');
    });
    
    // Form Management
    $routes->group('form-management', function($routes) {
        $routes->get('/', 'FormManagementController::index');
        $routes->post('update', 'FormManagementController::update');
        $routes->post('update-bulk', 'FormManagementController::updateBulk');
        $routes->post('update-required-fields', 'FormManagementController::updateRequiredFields');
        $routes->post('toggle-status', 'FormManagementController::toggleStatus');
        $routes->get('statistics', 'FormManagementController::statistics');
    });
});

// ============================================================================
// PANITIA ROUTES (Committee - Student Registration Management)
// ============================================================================
$routes->group('panitia', function($routes) {
    $routes->get('dashboard', 'PanitiaController::dashboard');
    
    // Student List Management
    $routes->get('siswa', 'PanitiaController::daftar_siswa'); // Alias
    $routes->get('daftar-siswa', 'PanitiaController::daftar_siswa');
    $routes->get('lihat_siswa/(:num)', 'PanitiaController::lihat_siswa/$1');
    $routes->match(['get', 'post'], 'edit_siswa/(:num)', 'PanitiaController::edit_siswa/$1');
    $routes->get('hapus_siswa/(:num)', 'PanitiaController::hapus_siswa/$1');
    
    // Student Registration
    $routes->match(['get', 'post'], 'tambah-siswa', 'PanitiaController::tambah_siswa');
    $routes->post('ajax-add-school', 'PanitiaController::ajax_add_school');
    
    // Verification
    $routes->get('verifikasi-pendaftar', 'PanitiaController::verifikasi_pendaftar');
    $routes->get('verifikasi-pendaftar/(:num)', 'PanitiaController::verifikasi_pendaftar/$1');
    $routes->get('batal-verifikasi/(:num)', 'PanitiaController::batal_verifikasi/$1');
    
    // Printing & Statistics
    $routes->get('cetak-pendaftaran/(:num)', 'PanitiaController::cetak_pendaftaran/$1');
    $routes->get('grafik-siswa', 'PanitiaController::grafik_siswa');
});

// ============================================================================
// BENDAHARA ROUTES (Treasurer - Payment Verification)
// ============================================================================
$routes->group('bendahara', function($routes) {
    $routes->get('dashboard', 'BendaharaController::dashboard');
    
    // Payment Verification
    $routes->get('verifikasi-pembayaran', 'BendaharaController::verifikasi_pembayaran');
    $routes->get('detail-pembayaran/(:num)', 'BendaharaController::detail_pembayaran/$1');
    $routes->post('terima-pembayaran/(:num)', 'BendaharaController::terima_pembayaran/$1');
    
    // Offline Payment Entry
    $routes->match(['get', 'post'], 'pembayaran-offline', 'BendaharaController::pembayaran_offline');
    
    // Receipt Printing
    $routes->get('cetak-bukti', 'BendaharaController::cetak_bukti');
    $routes->get('cetak-bukti/(:num)', 'BendaharaController::cetak_bukti/$1');
    $routes->get('cetak-bukti-pembayaran/(:num)', 'BendaharaController::cetak_bukti_pembayaran/$1');
    
    // Financial Reports
    $routes->get('laporan-keuangan', 'BendaharaController::laporan_keuangan');
    $routes->get('export-excel-keuangan', 'BendaharaController::export_excel_keuangan');
});

// ============================================================================
// SALES ROUTES (Marketing & Guest Management)
// ============================================================================
$routes->group('sales', function($routes) {
    $routes->get('dashboard', 'SalesController::dashboard');
    
    // Content Display
    $routes->get('video', 'SalesController::video');
    $routes->get('brochure', 'SalesController::brochure');
    $routes->get('informasi-biaya', 'SalesController::informasi_biaya');
    
    // Guest Book Management
    $routes->get('buku-tamu', 'SalesController::buku_tamu');
    $routes->post('save-buku-tamu', 'SalesController::save_buku_tamu');
    $routes->get('tracking-form', 'SalesController::tracking_form');
    $routes->get('buku-tamu-dashboard', 'SalesController::buku_tamu_dashboard');
    $routes->get('buku-tamu-map', 'SalesController::buku_tamu_map');
    $routes->get('export-buku-tamu', 'SalesController::export_buku_tamu');
});

// ============================================================================
// PAYMENT RECEIPT ROUTES (Accessible from multiple roles)
// ============================================================================
$routes->get('payment/print-receipt/(:num)', 'PaymentController::printReceipt/$1');

// ============================================================================
// TEST & DEBUG ROUTES (Development Only)
// ============================================================================

// Session & Login Tests
$routes->get('test-session', function() {
    return view('test_session');
});
$routes->get('test-login', function() {
    return view('test_login_access');
});
$routes->get('fix-session', 'FixSession::index');

// View Tests (No Auth Required)
$routes->get('test-tambah-siswa-view', function() {
    $majorModel = new \App\Models\Major();
    $hobbyModel = new \App\Models\Hobby();
    $schoolModel = new \App\Models\School();
    
    return view('panitia/tambah_siswa', [
        'title' => 'Test Tambah Siswa',
        'majors' => $majorModel->getActiveMajors(),
        'hobbies' => $hobbyModel->getActiveHobbies(),
        'schools' => $schoolModel->findAll(),
        'validation' => null
    ]);
});

$routes->get('test-lihat-siswa/(:num)', function($id) {
    $applicantModel = new \App\Models\Applicant();
    $paymentModel = new \App\Models\PaymentModel();
    
    $applicant = $applicantModel->find($id);
    if (!$applicant) {
        return "Data siswa dengan ID $id tidak ditemukan";
    }
    
    $payment = $paymentModel->where('applicant_id', $id)->first();
    
    return view('panitia/lihat_siswa', [
        'title' => 'Detail Siswa',
        'applicant' => $applicant,
        'payment' => $payment
    ]);
});

$routes->get('test-cetak-pendaftaran/(:num)', function($id) {
    $applicantModel = new \App\Models\Applicant();
    
    $applicant = $applicantModel->find($id);
    if (!$applicant) {
        return "Data siswa dengan ID $id tidak ditemukan";
    }
    
    $kopSuratModel = new \App\Models\KopSurat();
    $kopSurat = $kopSuratModel->first() ?? [
        'school_name' => 'SEKOLAH MENENGAH ATAS NEGERI',
        'address' => 'Jl. Pendidikan No. 123, Jakarta Selatan 12000',
        'phone' => '(021) 1234-5678',
        'email' => 'info@sekolah.sch.id',
        'npsn' => '20123456',
        'logo_path' => null,
    ];
    
    return view('panitia/cetak_pendaftaran', [
        'title' => 'Cetak Formulir Pendaftaran',
        'applicant' => $applicant,
        'kopSurat' => $kopSurat,
    ]);
});

$routes->get('test-form-management', function() {
    $formSettingModel = new \App\Models\FormSettingModel();
    $applicantModel = new \App\Models\Applicant();
    
    return view('admin/form_management/index', [
        'title' => 'Test Manajemen Formulir',
        'settings' => $formSettingModel->findAll(),
        'allSettings' => $formSettingModel->getAllSettings(),
        'totalApplicants' => $applicantModel->countAllResults(),
        'formStatus' => $formSettingModel->isFormActive(),
    ]);
});

// Debug Routes
$routes->get('debug/users', 'Debug::users');
$routes->get('debug/roles', 'Debug::roles');
$routes->get('debug/session', 'CheckSession::index');
$routes->get('debug/payments', 'DebugPayment::check_payments');
$routes->get('debug/payments-json', 'DebugApi::payments_json');
$routes->get('debug/form-management/check', 'DebugFormManagement::checkAccess');
$routes->get('debug/form-management/test', 'DebugFormManagement::testDirect');
$routes->get('debug/form-management/users', 'DebugFormManagement::checkUsers');

// Test Routes
$routes->get('test/insert-pembayaran', 'TestBendahara::insert_test_payments');
$routes->get('test/sidebar', 'SidebarTest::index');
$routes->get('test/sidebar-inspect', 'SidebarTest::inspect');