<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Check if user is logged in
        if (!$session->get('isLoggedIn')) {
            // Redirect to login page
            return redirect()->to('/auth/login')->with('error', 'Anda harus login terlebih dahulu');
        }
        
        // Optional: Check role-based access if $arguments is provided
        if ($arguments) {
            $userRole = $session->get('role');
            
            // If specific roles are required
            if (!in_array($userRole, $arguments)) {
                return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman ini');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after
    }
}
