<?php

namespace App\Controllers;

/**
 * Home Controller
 * 
 * Handles homepage routing and user session-based redirection
 * 
 * @package App\Controllers
 */
class Home extends BaseController
{
    /**
     * Display homepage or redirect to dashboard based on user role
     * 
     * If user is authenticated:
     * - Admin users are redirected to admin dashboard
     * - Applicant users are redirected to applicant dashboard
     * 
     * If user is not authenticated:
     * - Display homepage with login/register options
     * 
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function index()
    {
        // Check if user is logged in (authenticated)
        if (session()->has('user_id')) {
            $role = session()->get('role');
            log_message('debug', 'Home::index - User logged in with role: ' . $role);
            
            // Redirect based on user role
            if ($role === 'admin') {
                log_message('debug', 'Home::index - Redirecting admin to /admin/dashboard');
                return redirect()->to('/admin/dashboard');
            } elseif ($role === 'panitia') {
                log_message('debug', 'Home::index - Redirecting panitia to /panitia/dashboard');
                return redirect()->to('/panitia/dashboard');
            } elseif ($role === 'bendahara') {
                log_message('debug', 'Home::index - Redirecting bendahara to /bendahara/dashboard');
                return redirect()->to('/bendahara/dashboard');
            } elseif ($role === 'sales') {
                log_message('debug', 'Home::index - Redirecting sales to /sales/dashboard');
                return redirect()->to('/sales/dashboard');
            }
            
            // Default redirect for applicant role
            log_message('debug', 'Home::index - Redirecting to applicant dashboard (default)');
            return redirect()->to('/applicant/dashboard');
        }

        // Get content from database
        $homeContentModel = new \App\Models\HomeContent();
        $contents = $homeContentModel->where('is_active', 1)
            ->orderBy('display_order', 'ASC')
            ->findAll();
        
        // Organize content by section
        $data = [
            'hero' => [],
            'features' => [],
            'stats' => [],
            'cta' => []
        ];
        
        foreach ($contents as $content) {
            $section = strtolower($content['section']);
            if (array_key_exists($section, $data)) {
                $data[$section][] = $content;
            }
        }
        
        // Show homepage for unauthenticated users
        return view('home_new', $data);
    }
}
