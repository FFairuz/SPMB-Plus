<?php

namespace App\Controllers;

class CheckSession extends BaseController
{
    public function index()
    {
        $session = session();
        
        echo "<h2>Session Debug Info</h2>";
        echo "<pre>";
        echo "Is Logged In: " . ($session->get('isLoggedIn') ? 'Yes' : 'No') . "\n";
        echo "User ID: " . $session->get('user_id') . "\n";
        echo "Username: " . $session->get('username') . "\n";
        echo "Email: " . $session->get('email') . "\n";
        echo "Role: " . $session->get('role') . "\n";
        echo "\nAll Session Data:\n";
        print_r($session->get());
        echo "</pre>";
        
        // Check role from database
        if ($session->get('user_id')) {
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $user = $builder->where('id', $session->get('user_id'))->get()->getRowArray();
            
            echo "<h3>Database User Info:</h3>";
            echo "<pre>";
            print_r($user);
            echo "</pre>";
        }
    }
}
