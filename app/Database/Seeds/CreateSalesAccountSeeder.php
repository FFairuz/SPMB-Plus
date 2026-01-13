<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CreateSalesAccountSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Check if sales user already exists
        $existingUser = $db->table('users')->where('email', 'sales@ppdb.local')->get()->getRowArray();
        
        if ($existingUser) {
            echo "Sales account already exists. Updating...\n";
            $db->table('users')->where('email', 'sales@ppdb.local')->update([
                'username' => 'sales',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama' => 'Sales Department',
                'role' => 'sales',
                'is_active' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            echo "✓ Sales account updated\n";
        } else {
            echo "Creating new sales account...\n";
            $db->table('users')->insert([
                'username' => 'sales',
                'email' => 'sales@ppdb.local',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama' => 'Sales Department',
                'role' => 'sales',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            echo "✓ Sales account created\n";
        }
        
        // Force update role to ensure it's set
        $db->table('users')->where('email', 'sales@ppdb.local')->update(['role' => 'sales']);
        
        // Verify the account
        $user = $db->table('users')->where('email', 'sales@ppdb.local')->get()->getRowArray();
        
        if ($user) {
            echo "\n" . str_repeat("=", 50) . "\n";
            echo "✓ SALES ACCOUNT READY!\n";
            echo str_repeat("=", 50) . "\n";
            echo "Email:    " . $user['email'] . "\n";
            echo "Username: " . $user['username'] . "\n";
            echo "Name:     " . $user['nama'] . "\n";
            echo "Role:     " . $user['role'] . "\n";
            echo "Active:   " . ($user['is_active'] ? 'Yes' : 'No') . "\n";
            echo "\nLogin Credentials:\n";
            echo "Email:    sales@ppdb.local\n";
            echo "Password: password123\n";
            echo str_repeat("=", 50) . "\n";
            echo "\nNext Steps:\n";
            echo "1. Go to: http://localhost:8080/auth/login\n";
            echo "2. Enter email: sales@ppdb.local\n";
            echo "3. Enter password: password123\n";
            echo "4. You will be redirected to: /sales/dashboard\n";
            echo str_repeat("=", 50) . "\n";
        } else {
            echo "\n✗ ERROR: Could not verify sales account creation!\n";
        }
    }
}
