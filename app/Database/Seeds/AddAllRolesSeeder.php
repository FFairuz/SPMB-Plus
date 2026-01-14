<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddAllRolesSeeder extends Seeder
{
    public function run()
    {
        $usersData = [
            // Admin
            [
                'username' => 'admin',
                'email' => 'admin@ppdb.local',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama' => 'Administrator',
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Panitia
            [
                'username' => 'panitia',
                'email' => 'panitia@ppdb.local',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama' => 'Panitia PPDB',
                'role' => 'panitia',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Bendahara
            [
                'username' => 'bendahara',
                'email' => 'bendahara@ppdb.local',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama' => 'Bendahara PPDB',
                'role' => 'bendahara',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Sales
            [
                'username' => 'sales',
                'email' => 'sales@ppdb.local',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama' => 'Sales Team',
                'role' => 'sales',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Applicant
            [
                'username' => 'john_doe',
                'email' => 'john.doe@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama' => 'John Doe',
                'role' => 'applicant',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Check which users already exist and add only new ones
        foreach ($usersData as $userData) {
            $exists = $this->db->table('users')
                ->where('email', $userData['email'])
                ->countAllResults();
            
            if ($exists === 0) {
                $this->db->table('users')->insert($userData);
                echo "✓ User created: {$userData['email']} ({$userData['role']})\n";
            } else {
                echo "⊘ User already exists: {$userData['email']}\n";
            }
        }

        echo "\n✓ All role-based accounts are ready!\n";
    }
}
