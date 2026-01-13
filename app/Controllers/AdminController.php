<?php

namespace App\Controllers;

use App\Services\AdminService;
use App\Traits\AuthTrait;
use App\Traits\ResponseTrait;

/**
 * Admin Controller
 * 
 * Controller untuk menangani dashboard dan management applicants oleh admin.
 * Menggunakan AdminService untuk business logic dan Repository untuk data access.
 */
class AdminController extends BaseController
{
    use AuthTrait;
    use ResponseTrait;

    /**
     * @var AdminService
     */
    protected $adminService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->adminService = new AdminService();
    }

    /**
     * Dashboard admin
     * 
     * @return mixed
     */
    public function dashboard()
    {
        $this->requireAdmin();

        $stats = $this->adminService->getDashboardStats();
        $recentApplicants = $this->adminService->getApplicantsByStatus('submitted', 5);
        $topApplicants = $this->adminService->getTopApplicants(5);

        // Get chart data
        $applicantModel = new \App\Models\Applicant();
        
        // Monthly registration data (last 6 months)
        $monthlyData = $applicantModel
            ->select("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->where('created_at >=', date('Y-m-d', strtotime('-6 months')))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->findAll();
        
        // Status distribution
        $statusData = [
            'pending' => $stats['pending'] ?? 0,
            'verified' => $stats['verified'] ?? 0,
            'accepted' => $stats['accepted'] ?? 0,
            'rejected' => $stats['rejected'] ?? 0,
        ];
        
        // Gender distribution
        $genderData = $applicantModel
            ->select('jenis_kelamin, COUNT(*) as total')
            ->groupBy('jenis_kelamin')
            ->findAll();
        
        $data = [
            'title' => 'Dashboard Admin PPDB',
            'stats' => $stats,
            'recent_applicants' => $recentApplicants,
            'top_applicants' => $topApplicants,
            'monthlyData' => $monthlyData,
            'statusData' => $statusData,
            'genderData' => $genderData,
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Tampilkan daftar applicants dengan filter dan pagination
     * 
     * @param string|null $status Filter by status (optional)
     * @return mixed
     */
    public function applicants($status = null)
    {
        $this->requireAdmin();

        // Get filters from request
        $filters = [
            'status' => $status ?? $this->request->getGet('status'),
            'provinsi' => $this->request->getGet('provinsi'),
            'kabupaten' => $this->request->getGet('kabupaten'),
        ];

        // Get pagination
        $page = (int) $this->request->getGet('page') ?? 1;
        $limit = (int) $this->request->getGet('limit') ?? 15;

        // Get applicants
        $result = $this->adminService->getApplicants($filters, $page, $limit);

        $data = [
            'title' => 'Daftar Applicants',
            'applicants' => $result['data'],
            'total' => $result['total'],
            'pages' => $result['pages'],
            'current_page' => $result['current_page'],
            'per_page' => $result['per_page'],
            'filters' => $filters,
            'filter_status' => $status ?? $filters['status'], // Use filter_status from request or parameter
        ];

        return view('admin/applicants', $data);
    }

    /**
     * Tampilkan detail applicant
     * 
     * @param int $id Applicant ID
     * @return mixed
     */
    public function viewApplicant($id)
    {
        $this->requireAdmin();

        $applicant = $this->adminService->getApplicantDetail($id);

        if (!$applicant) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Applicant tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Applicant',
            'applicant' => $applicant,
        ];

        return view('admin/view_applicant', $data);
    }

    /**
     * Verify applicant (AJAX)
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function verifyApplicant()
    {
        if (!$this->request->isAJAX()) {
            return $this->errorResponse('Invalid request', null, 400);
        }

        $this->requireAdmin();

        $id = $this->request->getPost('id');
        $catatan = $this->request->getPost('catatan');

        if (!$id) {
            return $this->errorResponse('Applicant ID required', null, 400);
        }

        // Verify applicant
        if ($this->adminService->verifyApplicant($id, $catatan)) {
            return $this->successResponse('Applicant berhasil diverifikasi');
        } else {
            return $this->errorResponse('Gagal melakukan verifikasi', null, 500);
        }
    }

    /**
     * Accept applicant (AJAX)
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function acceptApplicant()
    {
        if (!$this->request->isAJAX()) {
            return $this->errorResponse('Invalid request', null, 400);
        }

        $this->requireAdmin();

        $id = $this->request->getPost('id');
        $catatan = $this->request->getPost('catatan');

        if (!$id) {
            return $this->errorResponse('Applicant ID required', null, 400);
        }

        // Accept applicant
        if ($this->adminService->acceptApplicant($id, $catatan)) {
            return $this->successResponse('Applicant diterima');
        } else {
            return $this->errorResponse('Gagal menerima applicant', null, 500);
        }
    }

    /**
     * Reject applicant (AJAX)
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function rejectApplicant()
    {
        if (!$this->request->isAJAX()) {
            return $this->errorResponse('Invalid request', null, 400);
        }

        $this->requireAdmin();

        $id = $this->request->getPost('id');
        $alasan = $this->request->getPost('alasan');

        if (!$id || !$alasan) {
            return $this->errorResponse('ID dan alasan penolakan harus diisi', null, 400);
        }

        // Reject applicant
        if ($this->adminService->rejectApplicant($id, $alasan)) {
            return $this->successResponse('Applicant ditolak');
        } else {
            return $this->errorResponse('Gagal menolak applicant', null, 500);
        }
    }

    /**
     * Search applicant (AJAX)
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function searchApplicant()
    {
        if (!$this->request->isAJAX()) {
            return $this->errorResponse('Invalid request', null, 400);
        }

        $this->requireAdmin();

        $query = $this->request->getPost('query');

        if (!$query) {
            return $this->errorResponse('Query required', null, 400);
        }

        $results = $this->adminService->searchApplicant($query);

        return $this->successResponse('Search results', $results);
    }

    /**
     * Export applicants to CSV
     * 
     * @return mixed
     */
    public function exportCSV()
    {
        $this->requireAdmin();

        // Get filters from request
        $filters = [
            'status' => $this->request->getGet('status'),
            'provinsi' => $this->request->getGet('provinsi'),
        ];

        // Export to CSV
        $csv = $this->adminService->exportToCSV($filters);

        // Return as file download
        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="applicants_' . date('Y-m-d') . '.csv"')
            ->setBody($csv);
    }

    /**
     * Get statistics (AJAX)
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function getStats()
    {
        if (!$this->request->isAJAX()) {
            return $this->errorResponse('Invalid request', null, 400);
        }

        $this->requireAdmin();

        $stats = $this->adminService->getDashboardStats();

        return $this->successResponse('Statistics retrieved', $stats);
    }

    /**
     * Get report data
     * 
     * @return mixed
     */
    public function report()
    {
        $this->requireAdmin();

        $report = $this->adminService->generateReport();

        $data = [
            'title' => 'Laporan PPDB',
            'report' => $report,
        ];

        return view('admin/report', $data);
    }

    /**
     * Admin manual applicant registration
     * Allow admin to register applicants directly
     * 
     * @return mixed
     */
    public function registerApplicant()
    {
        $this->requireAdmin();

        if ($this->request->getMethod() === 'post') {
            // Get post data
            $nik = $this->request->getPost('nik');
            $nama_lengkap = $this->request->getPost('nama_lengkap');
            $email = $this->request->getPost('email');
            
            // Validate required fields
            if (empty($nik) || empty($nama_lengkap) || empty($email)) {
                session()->setFlashdata('error', 'NIK, Nama, dan Email harus diisi');
                return redirect()->back()->withInput();
            }

            try {
                // Register new applicant via service
                $applicantId = $this->adminService->registerApplicantManually([
                    'nik' => $nik,
                    'nama_lengkap' => $nama_lengkap,
                    'email' => $email,
                    'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                    'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                    'asal_sekolah' => $this->request->getPost('asal_sekolah'),
                    'provinsi' => $this->request->getPost('provinsi'),
                    'kabupaten' => $this->request->getPost('kabupaten'),
                ]);

                session()->setFlashdata('success', 'Pendaftar berhasil ditambahkan dengan ID: ' . $applicantId);
                return redirect()->to('/admin/applicants');
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Error: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        // Get schools for dropdown
        $schoolModel = new \App\Models\School();
        $schools = $schoolModel->orderBy('nama', 'ASC')->findAll();
        
        $data = [
            'title' => 'Daftar Pendaftar Baru',
            'schools' => $schools,
        ];

        return view('admin/register_applicant', $data);
    }

    /**
     * Admin payments management - View list of pending payments
     * 
     * @return mixed
     */
    /**
     * Payment management page
     * 
     * @return mixed
     */
    public function payments()
    {
        $this->requireAdmin();

        $paymentModel = new \App\Models\PaymentModel();
        $status = $this->request->getGet('status') ?? 'submitted';
        
        // Get payments with user info using custom query
        $payments = $paymentModel->select('payments.*, users.email, users.username')
            ->join('users', 'users.id = payments.user_id', 'left')
            ->join('applicants_dapodik', 'applicants_dapodik.id = payments.applicant_id', 'left')
            ->where('payments.payment_status', $status)
            ->orderBy('payments.created_at', 'DESC')
            ->findAll();

        // Get payment stats
        $stats = $paymentModel->getPaymentStats();

        $data = [
            'title' => 'Manajemen Pembayaran',
            'payments' => $payments,
            'stats' => $stats,
            'current_status' => $status,
        ];

        return view('admin/payments', $data);
    }

    /**
     * Confirm/verify payment
     * 
     * @param int $paymentId Payment ID
     * @return mixed
     */
    public function confirmPayment($paymentId)
    {
        $this->requireAdmin();

        $paymentModel = new \App\Models\PaymentModel();
        $payment = $paymentModel->find($paymentId);

        if (!$payment) {
            session()->setFlashdata('error', 'Pembayaran tidak ditemukan');
            return redirect()->to('/admin/payments');
        }

        try {
            $paymentModel->update($paymentId, [
                'payment_status' => 'confirmed',
                'confirmed_by' => session()->get('user_id'),
                'confirmed_at' => date('Y-m-d H:i:s'),
            ]);

            session()->setFlashdata('success', 'Pembayaran berhasil dikonfirmasi');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->to('/admin/payments');
    }

    /**
     * Reject payment
     * 
     * @param int $paymentId Payment ID
     * @return mixed
     */
    public function rejectPayment($paymentId)
    {
        $this->requireAdmin();

        $paymentModel = new \App\Models\PaymentModel();
        $payment = $paymentModel->find($paymentId);

        if (!$payment) {
            session()->setFlashdata('error', 'Pembayaran tidak ditemukan');
            return redirect()->to('/admin/payments');
        }

        $notes = $this->request->getPost('notes') ?? 'Pembayaran ditolak oleh admin';

        try {
            $paymentModel->update($paymentId, [
                'payment_status' => 'rejected',
                'notes' => $notes,
            ]);

            session()->setFlashdata('success', 'Pembayaran berhasil ditolak');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->to('/admin/payments');
    }

    /**
     * Kelola Akun - Tampilkan daftar semua user
     * 
     * @return mixed
     */
    public function kelolaAkun()
    {
        $this->requireAdmin();

        $userModel = new \App\Models\User();
        $page = (int) $this->request->getGet('page') ?? 1;
        $limit = 15;
        
        $users = $userModel->paginate($limit, 'default', $page);
        $pager = $userModel->pager;

        $data = [
            'title' => 'Kelola Akun User',
            'users' => $users,
            'pager' => $pager,
            'per_page' => $limit,
            'current_page' => $page,
        ];

        return view('admin/kelola_akun', $data);
    }

    /**
     * Tambah User Baru
     * 
     * @return mixed
     */
    public function tambahAkun()
    {
        $this->requireAdmin();

        if ($this->request->getMethod() === 'post') {
            $userModel = new \App\Models\User();

            $rules = [
                'username' => 'required|min_length[3]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]',
                'nama' => 'required|min_length[3]',
                'role' => 'required|in_list[admin,applicant,panitia,bendahara]',
            ];

            if (!$this->validate($rules)) {
                return view('admin/tambah_akun', [
                    'title' => 'Tambah Akun User',
                    'errors' => $this->validator->getErrors(),
                    'old' => $this->request->getPost(),
                ]);
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'nama' => $this->request->getPost('nama'),
                'role' => $this->request->getPost('role'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            ];

            if ($userModel->insert($data)) {
                session()->setFlashdata('success', 'User berhasil ditambahkan');
                return redirect()->to('/admin/kelola-akun');
            } else {
                session()->setFlashdata('error', 'Gagal menambahkan user');
            }
        }

        return view('admin/tambah_akun', [
            'title' => 'Tambah Akun User',
            'errors' => [],
        ]);
    }

    /**
     * Edit User
     * 
     * @param int $id User ID
     * @return mixed
     */
    public function editAkun($id)
    {
        $this->requireAdmin();

        $userModel = new \App\Models\User();
        $user = $userModel->find($id);

        if (!$user) {
            session()->setFlashdata('error', 'User tidak ditemukan');
            return redirect()->to('/admin/kelola-akun');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'username' => "required|min_length[3]|is_unique[users.username,id,{$id}]",
                'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
                'nama' => 'required|min_length[3]',
                'role' => 'required|in_list[admin,applicant,panitia,bendahara]',
            ];

            // Tambah password validation jika ada input password baru
            if ($this->request->getPost('password')) {
                $rules['password'] = 'min_length[6]';
                $rules['password_confirm'] = 'matches[password]';
            }

            if (!$this->validate($rules)) {
                return view('admin/edit_akun', [
                    'title' => 'Edit Akun User',
                    'user' => $user,
                    'errors' => $this->validator->getErrors(),
                    'old' => $this->request->getPost(),
                ]);
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'nama' => $this->request->getPost('nama'),
                'role' => $this->request->getPost('role'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            ];

            // Update password jika ada input password baru
            if ($this->request->getPost('password')) {
                $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }

            if ($userModel->update($id, $data)) {
                session()->setFlashdata('success', 'User berhasil diupdate');
                return redirect()->to('/admin/kelola-akun');
            } else {
                session()->setFlashdata('error', 'Gagal mengupdate user');
            }
        }

        return view('admin/edit_akun', [
            'title' => 'Edit Akun User',
            'user' => $user,
            'errors' => [],
        ]);
    }

    /**
     * Hapus User
     * 
     * @param int $id User ID
     * @return mixed
     */
    public function hapusAkun($id)
    {
        $this->requireAdmin();

        // Prevent deleting own account
        if ($id == session()->get('user_id')) {
            session()->setFlashdata('error', 'Anda tidak bisa menghapus akun sendiri');
            return redirect()->to('/admin/kelola-akun');
        }

        $userModel = new \App\Models\User();
        $user = $userModel->find($id);

        if (!$user) {
            session()->setFlashdata('error', 'User tidak ditemukan');
            return redirect()->to('/admin/kelola-akun');
        }

        if ($userModel->delete($id)) {
            session()->setFlashdata('success', 'User berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus user');
        }

        return redirect()->to('/admin/kelola-akun');
    }

    /**
     * Manage Kop Surat (School Header)
     * 
     * @return mixed
     */
    public function kelola_kop_surat()
    {
        $this->requireAdmin();

        $kopSuratModel = new \App\Models\KopSurat();

        // Handle POST request (save data)
        if ($this->request->getMethod() === 'post') {
            $schoolName = $this->request->getPost('school_name');
            $address = $this->request->getPost('address');
            $phone = $this->request->getPost('phone');
            $email = $this->request->getPost('email');
            $npsn = $this->request->getPost('npsn');

            // Validate
            $validation = \Config\Services::validation();
            $validation->setRules([
                'school_name' => 'required|string|max_length[255]',
                'email' => 'permit_empty|valid_email',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                session()->setFlashdata('error', 'Validasi gagal: ' . implode(', ', $validation->getErrors()));
                return redirect()->back()->withInput();
            }

            // Handle logo upload
            $logoPath = null;
            $logoFile = $this->request->getFile('logo_path');
            if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
                // Validate file
                if (!$logoFile->isValid()) {
                    session()->setFlashdata('error', 'File logo tidak valid');
                    return redirect()->back()->withInput();
                }

                // Move file
                $newName = $logoFile->getRandomName();
                $logoFile->move(ROOTPATH . 'public/uploads/logo', $newName);
                $logoPath = 'uploads/logo/' . $newName;
            }

            // Get existing data
            $existing = $kopSuratModel->first();

            if ($existing) {
                // Update
                $updateData = [
                    'school_name' => $schoolName,
                    'address' => $address,
                    'phone' => $phone,
                    'email' => $email,
                    'npsn' => $npsn,
                ];

                if ($logoPath) {
                    $updateData['logo_path'] = $logoPath;
                }

                if ($kopSuratModel->update($existing['id'], $updateData)) {
                    session()->setFlashdata('success', 'Kop surat berhasil diperbarui');
                } else {
                    session()->setFlashdata('error', 'Gagal menyimpan perubahan');
                }
            } else {
                // Insert
                $insertData = [
                    'school_name' => $schoolName,
                    'address' => $address,
                    'phone' => $phone,
                    'email' => $email,
                    'npsn' => $npsn,
                    'logo_path' => $logoPath,
                ];

                if ($kopSuratModel->insert($insertData)) {
                    session()->setFlashdata('success', 'Kop surat berhasil disimpan');
                } else {
                    session()->setFlashdata('error', 'Gagal menyimpan kop surat');
                }
            }

            return redirect()->to('/admin/kelola-kop-surat');
        }

        // Handle GET request (display form)
        $kopSurat = $kopSuratModel->first() ?? [
            'school_name' => 'SEKOLAH MENENGAH ATAS NEGERI',
            'address' => 'Jl. Pendidikan No. 123, Jakarta Selatan 12000',
            'phone' => '(021) 1234-5678',
            'email' => 'info@sekolah.sch.id',
            'npsn' => '20123456',
            'logo_path' => null,
        ];

            return view('admin/kelola_kop_surat', [
                'kopSurat' => $kopSurat,
            ]);
        }

    /**
     * Show import Excel form
     * 
     * @return mixed
     */
    public function importForm()
    {
        $this->requireAdmin();

        return view('admin/import_excel', [
            'title' => 'Import Data Pendaftar dari Excel',
        ]);
    }

    /**
     * Process Excel file upload and import data
     * 
     * @return mixed
     */
    public function processImport()
    {
        $this->requireAdmin();

        $file = $this->request->getFile('excel_file');

        // Validate file
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid atau tidak ada');
        }

        // Check file extension
        $allowedExtensions = ['xlsx', 'xls', 'csv'];
        if (!in_array(strtolower($file->getClientExtension()), $allowedExtensions)) {
            return redirect()->back()->with('error', 'Format file harus Excel (.xlsx, .xls) atau CSV');
        }

        try {
            $filePath = $file->getTempName();
            
            // Load Excel file
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            
            $rows = $worksheet->toArray();
            
            if (empty($rows)) {
                return redirect()->back()->with('error', 'File Excel kosong');
            }

            // Skip header row
            $headerRow = array_shift($rows);
            
            $applicantModel = new \App\Models\Applicant();
            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            // Process each row
            foreach ($rows as $index => $row) {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                $rowNumber = $index + 2; // +2 because we removed header and arrays are 0-indexed

                // Map Excel columns to database fields
                $data = [
                    'nik' => isset($row[0]) ? (string)$row[0] : null,
                    'nama_lengkap' => isset($row[1]) ? (string)$row[1] : null,
                    'jenis_kelamin' => isset($row[2]) ? (string)$row[2] : null,
                    'tanggal_lahir' => isset($row[3]) ? $this->convertExcelDate($row[3]) : null,
                    'tempat_lahir' => isset($row[4]) ? (string)$row[4] : null,
                    'agama' => isset($row[5]) ? (string)$row[5] : null,
                    'anak_ke' => isset($row[6]) ? (int)$row[6] : null,
                    'jumlah_saudara' => isset($row[7]) ? (int)$row[7] : null,
                    'alamat_jalan' => isset($row[8]) ? (string)$row[8] : null,
                    'kelurahan' => isset($row[9]) ? (string)$row[9] : null,
                    'kecamatan' => isset($row[10]) ? (string)$row[10] : null,
                    'kabupaten' => isset($row[11]) ? (string)$row[11] : null,
                    'provinsi' => isset($row[12]) ? (string)$row[12] : null,
                    'kode_pos' => isset($row[13]) ? (string)$row[13] : null,
                    'nomor_hp' => isset($row[14]) ? (string)$row[14] : null,
                    'asal_sekolah' => isset($row[15]) ? (string)$row[15] : null,
                    'npsn_sekolah_asal' => isset($row[16]) ? (string)$row[16] : null,
                    'nilai_rata_rata' => isset($row[17]) ? (float)$row[17] : null,
                    'nama_ayah' => isset($row[18]) ? (string)$row[18] : null,
                    'nama_ibu' => isset($row[19]) ? (string)$row[19] : null,
                    'status' => 'submitted',
                    'tanggal_submit' => date('Y-m-d H:i:s'),
                ];

                // Validate required fields
                if (empty($data['nik']) || empty($data['nama_lengkap']) || empty($data['nomor_hp'])) {
                    $errorCount++;
                    $errors[] = "Baris {$rowNumber}: NIK, Nama Lengkap, dan Nomor HP harus diisi";
                    continue;
                }

                // Check if NIK already exists
                if ($applicantModel->where('nik', $data['nik'])->first()) {
                    $errorCount++;
                    $errors[] = "Baris {$rowNumber}: NIK {$data['nik']} sudah terdaftar";
                    continue;
                }

                // Insert data
                if ($applicantModel->insert($data)) {
                    $successCount++;
                } else {
                    $errorCount++;
                    $errors[] = "Baris {$rowNumber}: Gagal menyimpan data ({$data['nama_lengkap']})";
                }
            }

            // Prepare message
            $message = "Berhasil import {$successCount} data pendaftar";
            if ($errorCount > 0) {
                $message .= " ({$errorCount} data gagal)";
                session()->setFlashdata('warning', $message);
                session()->setFlashdata('import_errors', $errors);
            } else {
                session()->setFlashdata('success', $message);
            }

            return redirect()->to('admin/applicants');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error membaca file: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel for import
     * 
     * @return mixed
     */
    public function downloadTemplate()
    {
        $this->requireAdmin();

        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set header row
            $headers = [
                'NIK',
                'Nama Lengkap',
                'Jenis Kelamin',
                'Tanggal Lahir',
                'Tempat Lahir',
                'Agama',
                'Anak Ke',
                'Jumlah Saudara',
                'Alamat Jalan',
                'Kelurahan',
                'Kecamatan',
                'Kabupaten',
                'Provinsi',
                'Kode Pos',
                'Nomor HP',
                'Asal Sekolah',
                'NPSN Sekolah Asal',
                'Nilai Rata-Rata',
                'Nama Ayah',
                'Nama Ibu'
            ];
            
            // Write headers
            for ($col = 0; $col < count($headers); $col++) {
                $sheet->setCellValueByColumnAndRow($col + 1, 1, $headers[$col]);
                
                // Style header
                $cell = $sheet->getCellByColumnAndRow($col + 1, 1);
                $cell->getStyle()->getFont()->setBold(true);
                $cell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $cell->getStyle()->getFill()->getStartColor()->setARGB('FF4472C4');
                $cell->getStyle()->getFont()->getColor()->setARGB('FFFFFFFF');
                $cell->getStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }
            
            // Add example data
            $sheet->setCellValue('A2', '1234567890123456');
            $sheet->setCellValue('B2', 'Budi Santoso');
            $sheet->setCellValue('C2', 'Laki-laki');
            $sheet->setCellValue('D2', '2006-01-15');
            $sheet->setCellValue('E2', 'Jakarta');
            $sheet->setCellValue('F2', 'Islam');
            $sheet->setCellValue('G2', 1);
            $sheet->setCellValue('H2', 2);
            $sheet->setCellValue('I2', 'Jl. Merdeka No. 123');
            $sheet->setCellValue('J2', 'Kelapa Gading');
            $sheet->setCellValue('K2', 'Penjaringan');
            $sheet->setCellValue('L2', 'Jakarta Utara');
            $sheet->setCellValue('M2', 'DKI Jakarta');
            $sheet->setCellValue('N2', '14450');
            $sheet->setCellValue('O2', '081234567890');
            $sheet->setCellValue('P2', 'SMA Negeri 1 Jakarta');
            $sheet->setCellValue('Q2', '20123456');
            $sheet->setCellValue('R2', 8.5);
            $sheet->setCellValue('S2', 'Haji Santoso');
            $sheet->setCellValue('T2', 'Haji Santiah');
            
            // Set column widths
            foreach (range('A', 'T') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Create writer
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            
            // Send to browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Template_Import_Pendaftar.xlsx"');
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
            exit;
            
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal membuat template: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Convert Excel date format to Y-m-d
     * 
     * @param mixed $excelDate
     * @return string|null
     */
    private function convertExcelDate($excelDate)
    {
        if (empty($excelDate)) {
            return null;
        }

        // If it's already a date string
        if (is_string($excelDate)) {
            if (strtotime($excelDate) !== false) {
                return date('Y-m-d', strtotime($excelDate));
            }
        }

        // If it's Excel numeric date
        if (is_numeric($excelDate)) {
            $excelEpoch = 25569; // Days between 1900-01-01 and 1970-01-01
            $unixDate = ($excelDate - $excelEpoch) * 86400;
            return date('Y-m-d', $unixDate);
        }

        return null;
    }

    /**
     * AJAX: Add new school
     */
    public function ajax_add_school()
    {
        $this->requireAdmin();
        
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }

        $schoolModel = new \App\Models\School();
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'npsn' => $this->request->getPost('npsn'),
            'kota' => $this->request->getPost('kota'),
            'provinsi' => $this->request->getPost('provinsi'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        try {
            if ($schoolModel->insert($data)) {
                $newId = $schoolModel->insertID();
                $newSchool = $schoolModel->find($newId);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Sekolah berhasil ditambahkan',
                    'school' => $newSchool
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menyimpan: ' . implode(', ', $schoolModel->errors())
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    }
