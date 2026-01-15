<?php

namespace App\Controllers;

use App\Models\FormSettingModel;
use App\Models\Applicant;

class DebugFormManagement extends BaseController
{
    public function checkAccess()
    {
        $session = session();
        
        $debug = [
            'session_data' => [
                'isLoggedIn' => $session->get('isLoggedIn'),
                'role' => $session->get('role'),
                'user_id' => $session->get('user_id'),
                'username' => $session->get('username'),
                'all_data' => $session->get(),
            ],
            'route_info' => [
                'current_url' => current_url(),
                'base_url' => base_url(),
                'uri_string' => uri_string(),
            ],
            'filter_check' => [
                'auth_filter_exists' => class_exists('\App\Filters\AuthFilter'),
                'controller_exists' => class_exists('\App\Controllers\FormManagementController'),
                'model_exists' => class_exists('\App\Models\FormSettingModel'),
            ],
            'routes' => [
                'form_management' => base_url('admin/form-management'),
                'test_form_management' => base_url('test-form-management'),
            ],
            'role_check' => [
                'current_role' => $session->get('role'),
                'allowed_roles' => ['admin', 'admin_sekolah', 'panitia'],
                'is_allowed' => in_array($session->get('role'), ['admin', 'admin_sekolah', 'panitia']),
            ],
        ];
        
        // Try to create model instance
        try {
            $formSettingModel = new FormSettingModel();
            $debug['model_test'] = [
                'can_create' => true,
                'table_name' => $formSettingModel->table,
                'settings_count' => $formSettingModel->countAll(),
            ];
        } catch (\Exception $e) {
            $debug['model_test'] = [
                'can_create' => false,
                'error' => $e->getMessage(),
            ];
        }
        
        // Display as HTML for easier reading
        echo '<!DOCTYPE html><html><head><title>Debug Session</title></head><body>';
        echo '<h1>Debug Info - Session & Access Check</h1>';
        echo '<pre style="background:#f5f5f5;padding:20px;border:1px solid #ddd;">';
        echo json_encode($debug, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        echo '</pre>';
        echo '<hr><a href="'.base_url('admin/form-management').'">Try Access Form Management</a>';
        echo '</body></html>';
    }
    
    public function testDirect()
    {
        $formSettingModel = new FormSettingModel();
        $applicantModel = new Applicant();
        
        $data = [
            'title' => 'DEBUG: Manajemen Formulir',
            'settings' => $formSettingModel->findAll(),
            'allSettings' => $formSettingModel->getAllSettings(),
            'totalApplicants' => $applicantModel->countAllResults(),
            'formStatus' => $formSettingModel->isFormActive(),
        ];
        
        return view('admin/form_management/index', $data);
    }
    
    public function checkUsers()
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT id, username, role FROM users ORDER BY id');
        $users = $query->getResultArray();
        
        echo '<h1>Daftar Users dan Role</h1>';
        echo '<table border="1" cellpadding="10" style="border-collapse:collapse;">';
        echo '<thead><tr><th>ID</th><th>Username</th><th>Role</th><th>Akses Menu?</th></tr></thead>';
        echo '<tbody>';
        
        $allowedRoles = ['admin', 'admin_sekolah', 'panitia'];
        
        foreach ($users as $user) {
            $hasAccess = in_array($user['role'], $allowedRoles);
            $color = $hasAccess ? 'green' : 'red';
            $accessText = $hasAccess ? '✅ Ya' : '❌ Tidak';
            
            echo '<tr>';
            echo '<td>' . $user['id'] . '</td>';
            echo '<td><strong>' . $user['username'] . '</strong></td>';
            echo '<td>' . $user['role'] . '</td>';
            echo '<td style="color:' . $color . ';font-weight:bold;">' . $accessText . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
        
        echo '<h2>Role yang Diizinkan:</h2>';
        echo '<ul>';
        echo '<li><strong>admin</strong></li>';
        echo '<li><strong>admin_sekolah</strong></li>';
        echo '<li><strong>panitia</strong></li>';
        echo '</ul>';
        
        echo '<hr>';
        echo '<p><a href="' . base_url('admin/form-management') . '">Coba Akses Form Management</a></p>';
    }
}
