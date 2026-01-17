<?php

namespace App\Controllers;

class FixSession extends BaseController
{
    public function index()
    {
        $session = session();
        
        echo "<h2>Fixing Session...</h2>";
        echo "<pre>";
        
        // Check if user has session but missing isLoggedIn
        if ($session->has('user_id') && $session->has('role')) {
            echo "Found session with user_id but missing proper isLoggedIn flag\n";
            echo "User ID: " . $session->get('user_id') . "\n";
            echo "Role: " . $session->get('role') . "\n";
            
            // Set the isLoggedIn flag
            $session->set('isLoggedIn', true);
            $session->set('is_logged_in', true);
            
            echo "\n✓ Session fixed! isLoggedIn flag set to true\n";
            echo "\nUpdated Session Data:\n";
            print_r($session->get());
            
            echo "\n<a href='" . base_url('admin/form-management') . "' style='display:inline-block;margin-top:20px;padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;'>Go to Form Management</a>";
        } else {
            echo "No session found or session already has proper flags\n";
            echo "\nCurrent Session:\n";
            print_r($session->get());
            
            echo "\n<a href='" . base_url('auth/login') . "' style='display:inline-block;margin-top:20px;padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;'>Login</a>";
        }
        
        echo "</pre>";
    }
}
