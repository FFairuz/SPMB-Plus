<?php

namespace App\Controllers;

use App\Models\SettingModel;
use CodeIgniter\HTTP\RedirectResponse;

class SettingsController extends BaseController
{
    protected $settingModel;
    protected $validation;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
        $this->validation = \Config\Services::validation();
    }

    /**
     * Display settings page
     *
     * @return string
     */
    public function index()
    {
        // Check if user is admin
        if (!session()->get('is_logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Anda harus login sebagai admin');
        }

        $data = [
            'title' => 'Pengaturan Aplikasi',
            'settings' => $this->settingModel->getAllSettings(),
        ];

        return view('admin/settings/index', $data);
    }

    /**
     * Update settings
     *
     * @return RedirectResponse
     */
    public function update()
    {
        // Check if user is admin
        if (!session()->get('is_logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Anda harus login sebagai admin');
        }

        // Validation rules
        $rules = [
            'app_name'        => 'required|max_length[100]',
            'app_description' => 'permit_empty|max_length[255]',
            'school_name'     => 'permit_empty|max_length[100]',
            'school_address'  => 'permit_empty|max_length[255]',
            'school_phone'    => 'permit_empty|max_length[20]',
            'school_email'    => 'permit_empty|valid_email',
            'app_logo'        => 'permit_empty|uploaded[app_logo]|max_size[app_logo,2048]|is_image[app_logo]|mime_in[app_logo,image/jpg,image/jpeg,image/png,image/gif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            // Update text settings
            $textSettings = [
                'app_name',
                'app_description',
                'school_name',
                'school_address',
                'school_phone',
                'school_email',
            ];

            foreach ($textSettings as $key) {
                $value = $this->request->getPost($key);
                if ($value !== null) {
                    $this->settingModel->setSetting($key, $value, 'text');
                }
            }

            // Handle logo upload
            $logo = $this->request->getFile('app_logo');
            if ($logo && $logo->isValid() && !$logo->hasMoved()) {
                // Delete old logo if exists
                $oldLogo = $this->settingModel->get('app_logo');
                if ($oldLogo && $oldLogo !== 'default-logo.png') {
                    $oldLogoPath = FCPATH . 'uploads/logo/' . $oldLogo;
                    if (file_exists($oldLogoPath)) {
                        @unlink($oldLogoPath);
                    }
                }

                // Upload new logo
                $logoName = $logo->getRandomName();
                $uploadPath = FCPATH . 'uploads/logo/';
                
                // Create directory if not exists
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $logo->move($uploadPath, $logoName);
                $this->settingModel->setSetting('app_logo', $logoName, 'image');
            }

            return redirect()->to('/admin/settings')->with('success', 'Pengaturan berhasil diperbarui');

        } catch (\Exception $e) {
            log_message('error', 'Error updating settings: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Reset logo to default
     *
     * @return RedirectResponse
     */
    public function resetLogo()
    {
        // Check if user is admin
        if (!session()->get('is_logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Anda harus login sebagai admin');
        }

        try {
            // Delete current logo if exists
            $currentLogo = $this->settingModel->get('app_logo');
            if ($currentLogo && $currentLogo !== 'default-logo.png') {
                $logoPath = FCPATH . 'uploads/logo/' . $currentLogo;
                if (file_exists($logoPath)) {
                    @unlink($logoPath);
                }
            }

            // Reset to default
            $this->settingModel->setSetting('app_logo', 'default-logo.png', 'image');

            return redirect()->to('/admin/settings')->with('success', 'Logo berhasil direset ke default');

        } catch (\Exception $e) {
            log_message('error', 'Error resetting logo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get setting value (API endpoint)
     *
     * @param string $key
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getSetting($key)
    {
        $value = $this->settingModel->get($key);
        
        return $this->response->setJSON([
            'success' => true,
            'key'     => $key,
            'value'   => $value,
        ]);
    }

    /**
     * Get all settings (API endpoint)
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getAllSettings()
    {
        $settings = $this->settingModel->getAllSettings();
        
        return $this->response->setJSON([
            'success'  => true,
            'settings' => $settings,
        ]);
    }
}
