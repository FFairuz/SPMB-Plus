<?php

namespace App\Controllers;

use App\Models\FormSettingModel;
use App\Models\Applicant;

class FormManagementController extends BaseController
{
    protected $formSettingModel;
    protected $applicantModel;

    public function __construct()
    {
        $this->formSettingModel = new FormSettingModel();
        $this->applicantModel = new Applicant();
    }

    /**
     * Index - Display form settings
     */
    public function index()
    {
        // Check if user is logged in first
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Anda harus login terlebih dahulu');
        }
        
        // Debug: Log session data
        $currentRole = $session->get('role');
        log_message('debug', 'FormManagement::index - isLoggedIn: true');
        log_message('debug', 'FormManagement::index - role: ' . $currentRole);
        log_message('debug', 'FormManagement::index - isAdmin: ' . ($this->isAdmin() ? 'true' : 'false'));
        
        // TEMPORARY: Show error message but still display the page for debugging
        $errorMessage = null;
        if (!$this->isAdmin()) {
            log_message('debug', 'FormManagement::index - Access denied but showing page for debugging');
            $errorMessage = 'PERHATIAN: Role Anda "' . $currentRole . '" tidak termasuk dalam daftar yang diizinkan. Halaman ditampilkan untuk debugging. Silakan update role Anda ke: admin, admin_sekolah, atau panitia';
        } else {
            log_message('debug', 'FormManagement::index - Access granted, showing view');
        }
        
        $data = [
            'title' => 'Manajemen Formulir',
            'settings' => $this->formSettingModel->findAll(),
            'allSettings' => $this->formSettingModel->getAllSettings(),
            'totalApplicants' => $this->applicantModel->countAllResults(),
            'formStatus' => $this->formSettingModel->isFormActive(),
            'debug_role_error' => $errorMessage,
            'current_role' => $currentRole,
        ];

        return view('admin/form_management/index', $data);
    }

    /**
     * Update form settings
     */
    public function update()
    {
        // Check if user is admin
        if (!$this->isAdmin()) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        if (!$this->request->isAJAX()) {
            return redirect()->back()->with('error', 'Invalid request');
        }

        $key = $this->request->getPost('setting_key');
        $value = $this->request->getPost('setting_value');

        if (empty($key)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Setting key is required'
            ]);
        }

        $success = $this->formSettingModel->updateSetting($key, $value);

        if ($success) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Setting berhasil diupdate'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengupdate setting'
        ]);
    }

    /**
     * Update multiple settings at once
     */
    public function updateBulk()
    {
        // Check if user is admin
        if (!$this->isAdmin()) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'form_status' => 'required|in_list[0,1]',
            'form_start_date' => 'required|valid_date[Y-m-d]',
            'form_end_date' => 'required|valid_date[Y-m-d]',
            'max_applicants' => 'required|numeric',
            'form_title' => 'required|min_length[5]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors())
                ->with('error', 'Validasi gagal. Periksa input Anda.');
        }

        // Update each setting
        $settings = [
            'form_status' => $this->request->getPost('form_status'),
            'form_start_date' => $this->request->getPost('form_start_date'),
            'form_end_date' => $this->request->getPost('form_end_date'),
            'max_applicants' => $this->request->getPost('max_applicants'),
            'form_title' => $this->request->getPost('form_title'),
            'form_description' => $this->request->getPost('form_description'),
        ];

        $success = true;
        foreach ($settings as $key => $value) {
            if (!$this->formSettingModel->updateSetting($key, $value)) {
                $success = false;
                break;
            }
        }

        if ($success) {
            return redirect()->back()->with('success', 'Pengaturan formulir berhasil diupdate');
        }

        return redirect()->back()->with('error', 'Gagal mengupdate pengaturan formulir');
    }

    /**
     * Update required fields
     */
    public function updateRequiredFields()
    {
        // Check if user is admin
        if (!$this->isAdmin()) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $requiredFields = $this->request->getPost('required_fields');

        if (!is_array($requiredFields)) {
            return redirect()->back()->with('error', 'Field required harus berupa array');
        }

        $success = $this->formSettingModel->updateSetting('required_fields', $requiredFields);

        if ($success) {
            return redirect()->back()->with('success', 'Field required berhasil diupdate');
        }

        return redirect()->back()->with('error', 'Gagal mengupdate field required');
    }

    /**
     * Toggle form status (aktif/nonaktif)
     */
    public function toggleStatus()
    {
        // Check if user is admin
        if (!$this->isAdmin()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Akses ditolak'
            ]);
        }

        $currentStatus = $this->formSettingModel->getSetting('form_status', 0);
        $newStatus = $currentStatus ? 0 : 1;

        $success = $this->formSettingModel->updateSetting('form_status', $newStatus);

        if ($success) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status formulir berhasil diubah',
                'new_status' => $newStatus,
                'status_text' => $newStatus ? 'Aktif' : 'Nonaktif'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengubah status formulir'
        ]);
    }

    /**
     * Get form statistics
     */
    public function statistics()
    {
        // Check if user is admin
        if (!$this->isAdmin()) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Statistik Formulir',
            'totalApplicants' => $this->applicantModel->countAllResults(),
            'pendingApplicants' => $this->applicantModel->where('status', 'pending')->countAllResults(),
            'verifiedApplicants' => $this->applicantModel->where('status', 'verified')->countAllResults(),
            'rejectedApplicants' => $this->applicantModel->where('status', 'rejected')->countAllResults(),
            'maxApplicants' => $this->formSettingModel->getSetting('max_applicants', 0),
            'formStatus' => $this->formSettingModel->isFormActive(),
            'settings' => $this->formSettingModel->getAllSettings(),
        ];

        return view('admin/form_management/statistics', $data);
    }

    /**
     * Check if user is admin
     * 
     * JIKA ROLE ANDA BERBEDA, TAMBAHKAN DI ARRAY INI
     * Contoh: ['admin', 'admin_sekolah', 'panitia', 'role_anda']
     */
    private function isAdmin()
    {
        $session = session();
        $role = $session->get('role');
        
        // EDIT ARRAY INI SESUAI ROLE YANG BOLEH AKSES
        $allowedRoles = ['admin', 'admin_sekolah', 'panitia'];
        
        // Debug log
        log_message('debug', 'isAdmin check - Current role: ' . $role . ', Allowed: ' . json_encode($allowedRoles));
        
        return in_array($role, $allowedRoles);
    }
    
    /**
     * Get dashboard URL by role
     */
    private function getDashboardByRole($role)
    {
        $dashboards = [
            'admin' => '/admin/dashboard',
            'admin_sekolah' => '/admin/dashboard',
            'panitia' => '/panitia/dashboard',
            'bendahara' => '/bendahara/dashboard',
            'sales' => '/sales/dashboard',
            'applicant' => '/applicant/dashboard',
        ];
        
        return $dashboards[$role] ?? '/';
    }
}
