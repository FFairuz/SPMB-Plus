<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Debug route for session testing
$routes->get('test-session', function() {
    return view('test_session');
});

// Debug routes
$routes->get('debug/users', 'Debug::users');
$routes->get('debug/roles', 'Debug::roles');

// Auth Routes
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/register', 'Auth::register');
$routes->get('auth/logout', 'Auth::logout');

// Registration Routes (Main registration form with AJAX support)
$routes->get('registration', 'Registration::index');
$routes->post('registration/save', 'Registration::save');
$routes->post('registration/save-preview', 'Registration::saveAndPreview');
$routes->get('registration/preview', 'Registration::preview');
$routes->post('registration/submit', 'Registration::submit');
$routes->get('registration/summary', 'Registration::getSummary');
$routes->get('registration/print', 'Registration::printPreview');

// Applicant Routes
$routes->get('applicant/dashboard', 'ApplicantController::dashboard');
$routes->get('applicant/register', 'ApplicantController::register');
$routes->post('applicant/register', 'ApplicantController::register');
$routes->get('applicant/edit', 'ApplicantController::edit');
$routes->post('applicant/edit', 'ApplicantController::edit');
$routes->get('applicant/upload_documents', 'ApplicantController::upload_documents');
$routes->post('applicant/upload_documents', 'ApplicantController::upload_documents');
$routes->get('applicant/payment', 'ApplicantController::payment');
$routes->post('applicant/payment', 'ApplicantController::payment');

// Profile Routes
$routes->get('profile/edit', 'ProfileController::edit');
$routes->post('profile/update', 'ProfileController::update');

// Admin Routes
$routes->get('admin/dashboard', 'AdminController::dashboard');
$routes->get('admin/payments', 'AdminController::payments');
$routes->get('admin/manual-payment', 'PaymentController::manualPaymentEntry');
$routes->post('admin/manual-payment', 'PaymentController::manualPaymentEntry');
$routes->get('admin/confirmPayment/(:num)', 'AdminController::confirmPayment/$1');
$routes->post('admin/confirmPayment/(:num)', 'AdminController::confirmPayment/$1');
$routes->get('admin/rejectPayment/(:num)', 'AdminController::rejectPayment/$1');
$routes->post('admin/rejectPayment/(:num)', 'AdminController::rejectPayment/$1');
$routes->post('admin/payment/(:num)/confirm', 'AdminController::confirmPayment/$1');
$routes->post('admin/payment/(:num)/reject', 'AdminController::rejectPayment/$1');
$routes->get('admin/applicant-register', 'AdminController::registerApplicant');
$routes->post('admin/applicant-register', 'AdminController::registerApplicant');
$routes->post('admin/ajax-add-school', 'AdminController::ajax_add_school');
$routes->get('admin/applicants/(:num)', 'AdminController::view_applicant/$1');
$routes->get('admin/applicants', 'AdminController::applicants');
$routes->get('admin/applicants/(:alpha)', 'AdminController::applicants/$1');
$routes->post('admin/applicants/(:num)/status', 'AdminController::update_status/$1');

// Admin School Management Routes
$routes->get('admin/schools', 'AdminSchoolController::index');
$routes->get('admin/schools/add', 'AdminSchoolController::add');
$routes->post('admin/schools/save', 'AdminSchoolController::save');
$routes->get('admin/schools/edit/(:num)', 'AdminSchoolController::edit/$1');
$routes->post('admin/schools/update/(:num)', 'AdminSchoolController::update/$1');
$routes->get('admin/schools/delete/(:num)', 'AdminSchoolController::delete/$1');
$routes->get('admin/schools/search-api', 'AdminSchoolController::searchApi');
$routes->get('admin/schools/detail/(:num)', 'AdminSchoolController::getDetail/$1');
// Import Schools Routes
$routes->get('admin/schools/import-excel', 'AdminSchoolController::importForm');
$routes->post('admin/schools/process-import', 'AdminSchoolController::processImport');
$routes->get('admin/schools/download-template', 'AdminSchoolController::downloadTemplate');

// Kelola Akun Routes
$routes->get('admin/kelola-akun', 'AdminController::kelolaAkun');
$routes->get('admin/tambah-akun', 'AdminController::tambahAkun');
// Kelola Siswa Routes (Admin can access Panitia features)
$routes->get('admin/tambah-siswa', 'PanitiaController::tambah_siswa');
$routes->post('admin/tambah-siswa', 'PanitiaController::tambah_siswa');
$routes->get('admin/daftar-siswa', 'PanitiaController::daftar_siswa');
$routes->get('admin/verifikasi-pendaftar', 'PanitiaController::verifikasi_pendaftar');

// Admin Major Management Routes
$routes->get('admin/majors', 'AdminMajorController::index');
$routes->get('admin/majors/create', 'AdminMajorController::create');
$routes->post('admin/majors/create', 'AdminMajorController::create');
$routes->get('admin/majors/edit/(:num)', 'AdminMajorController::edit/$1');
$routes->post('admin/majors/edit/(:num)', 'AdminMajorController::edit/$1');
$routes->get('admin/majors/delete/(:num)', 'AdminMajorController::delete/$1');
$routes->post('admin/majors/toggle-status/(:num)', 'AdminMajorController::toggleStatus/$1');

// Admin Hobby Management Routes
$routes->get('admin/hobbies', 'AdminHobbyController::index');
$routes->get('admin/hobbies/create', 'AdminHobbyController::create');
$routes->post('admin/hobbies/create', 'AdminHobbyController::create');
$routes->get('admin/hobbies/edit/(:num)', 'AdminHobbyController::edit/$1');
$routes->post('admin/hobbies/edit/(:num)', 'AdminHobbyController::edit/$1');
$routes->get('admin/hobbies/delete/(:num)', 'AdminHobbyController::delete/$1');

// Kop Surat Routes
$routes->get('admin/kelola-kop-surat', 'AdminController::kelola_kop_surat');
$routes->post('admin/kelola-kop-surat', 'AdminController::kelola_kop_surat');

// Import Excel Routes
$routes->get('admin/import-excel', 'AdminController::importForm');
$routes->post('admin/process-import', 'AdminController::processImport');
$routes->get('admin/download-template', 'AdminController::downloadTemplate');

$routes->post('admin/tambah-akun', 'AdminController::tambahAkun');
$routes->get('admin/edit-akun/(:num)', 'AdminController::editAkun/$1');
$routes->post('admin/edit-akun/(:num)', 'AdminController::editAkun/$1');
$routes->get('admin/hapus-akun/(:num)', 'AdminController::hapusAkun/$1');

// Admin Content Management Routes
$routes->get('admin/content-management', 'ContentController::index');
$routes->get('admin/content-management/create', 'ContentController::create');
$routes->post('admin/content-management/store', 'ContentController::store');
$routes->get('admin/content-management/edit/(:num)', 'ContentController::edit/$1');
$routes->post('admin/content-management/update/(:num)', 'ContentController::update/$1');
$routes->post('admin/content-management/delete/(:num)', 'ContentController::delete/$1');
$routes->post('admin/content-management/toggle-status/(:num)', 'ContentController::toggleStatus/$1');

// Admin Settings Routes
$routes->get('admin/settings', 'SettingsController::index');
$routes->post('admin/settings/update', 'SettingsController::update');
$routes->get('admin/settings/reset-logo', 'SettingsController::resetLogo');
$routes->get('admin/settings/api/(:any)', 'SettingsController::getSetting/$1');
$routes->get('admin/settings/api', 'SettingsController::getAllSettings');

// Admin Sales Content Management Routes
$routes->get('admin/sales-content', 'SalesContentController::index');
$routes->get('admin/sales-content/create', 'SalesContentController::create');
$routes->post('admin/sales-content/store', 'SalesContentController::store');
$routes->get('admin/sales-content/edit/(:num)', 'SalesContentController::edit/$1');
$routes->post('admin/sales-content/update/(:num)', 'SalesContentController::update/$1');
$routes->post('admin/sales-content/delete/(:num)', 'SalesContentController::delete/$1');
$routes->post('admin/sales-content/toggle-status/(:num)', 'SalesContentController::toggleStatus/$1');

// Panitia Routes (untuk mendaftarkan siswa)
$routes->get('panitia/dashboard', 'PanitiaController::dashboard');
$routes->get('panitia/daftar-siswa', 'PanitiaController::daftar_siswa');
$routes->get('panitia/tambah-siswa', 'PanitiaController::tambah_siswa');
$routes->post('panitia/tambah-siswa', 'PanitiaController::tambah_siswa');
$routes->post('panitia/ajax-add-school', 'PanitiaController::ajax_add_school');
$routes->get('panitia/verifikasi-pendaftar', 'PanitiaController::verifikasi_pendaftar');
$routes->get('panitia/verifikasi-pendaftar/(:num)', 'PanitiaController::verifikasi_pendaftar/$1');
$routes->get('panitia/batal-verifikasi/(:num)', 'PanitiaController::batal_verifikasi/$1');
$routes->get('panitia/cetak-pendaftaran/(:num)', 'PanitiaController::cetak_pendaftaran/$1');
$routes->get('panitia/grafik-siswa', 'PanitiaController::grafik_siswa');
$routes->get('panitia/lihat_siswa/(:num)', 'PanitiaController::lihat_siswa/$1');
$routes->get('panitia/edit_siswa/(:num)', 'PanitiaController::edit_siswa/$1');
$routes->post('panitia/edit_siswa/(:num)', 'PanitiaController::edit_siswa/$1');
$routes->get('panitia/hapus_siswa/(:num)', 'PanitiaController::hapus_siswa/$1');

// Bendahara Routes (untuk verifikasi pembayaran dan cetak bukti)
$routes->get('bendahara/dashboard', 'BendaharaController::dashboard');
$routes->get('bendahara/verifikasi-pembayaran', 'BendaharaController::verifikasi_pembayaran');
$routes->get('bendahara/detail-pembayaran/(:num)', 'BendaharaController::detail_pembayaran/$1');
$routes->post('bendahara/terima-pembayaran/(:num)', 'BendaharaController::terima_pembayaran/$1');
$routes->get('bendahara/laporan-keuangan', 'BendaharaController::laporan_keuangan');
$routes->get('bendahara/export-excel-keuangan', 'BendaharaController::export_excel_keuangan');
$routes->get('bendahara/pembayaran-offline', 'BendaharaController::pembayaran_offline');
$routes->post('bendahara/pembayaran-offline', 'BendaharaController::pembayaran_offline');
$routes->get('bendahara/cetak-bukti', 'BendaharaController::cetak_bukti');
$routes->get('bendahara/cetak-bukti/(:num)', 'BendaharaController::cetak_bukti/$1');
$routes->get('bendahara/cetak-bukti-pembayaran/(:num)', 'BendaharaController::cetak_bukti_pembayaran/$1');;

// Sales Routes (untuk melihat video, brosur, dan informasi biaya)
$routes->get('sales/dashboard', 'SalesController::dashboard');
$routes->get('sales/video', 'SalesController::video');
$routes->get('sales/brochure', 'SalesController::brochure');
$routes->get('sales/informasi-biaya', 'SalesController::informasi_biaya');
$routes->get('sales/buku-tamu', 'SalesController::buku_tamu');
$routes->post('sales/save-buku-tamu', 'SalesController::save_buku_tamu');
$routes->get('sales/tracking-form', 'SalesController::tracking_form');
$routes->get('sales/buku-tamu-dashboard', 'SalesController::buku_tamu_dashboard');
$routes->get('sales/buku-tamu-map', 'SalesController::buku_tamu_map');
$routes->get('sales/export-buku-tamu', 'SalesController::export_buku_tamu');

// Test route for pembayaran offline
$routes->get('test/insert-pembayaran', 'TestBendahara::insert_test_payments');
$routes->get('debug/payments', 'DebugPayment::check_payments');
$routes->get('debug/payments-json', 'DebugApi::payments_json');

// Test routes for sidebar diagnostic
$routes->get('test/sidebar', 'SidebarTest::index');
$routes->get('test/sidebar-inspect', 'SidebarTest::inspect');

// Payment Receipt Routes
$routes->get('payment/print-receipt/(:num)', 'PaymentController::printReceipt/$1');
$routes->get('applicant/payment/print-receipt/(:num)', 'PaymentController::printReceipt/$1');
$routes->get('admin/payment/print-receipt/(:num)', 'PaymentController::printReceipt/$1');