<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Get current count of applicant users (excluding admin)
        $existingApplicants = $this->db->table('users')->where('role', 'applicant')->countAllResults();
        
        if ($existingApplicants >= 5) {
            echo "Applicant users already seeded, skipping...\n";
            return;
        }

        // Only add the applicant users we need
        $applicantData = [
            [
                'username' => 'john_doe',
                'email' => 'john.doe@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'applicant',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'jane_smith',
                'email' => 'jane.smith@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'applicant',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'michael_johnson',
                'email' => 'michael.johnson@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'applicant',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'sarah_williams',
                'email' => 'sarah.williams@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'applicant',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'thomas_brown',
                'email' => 'thomas.brown@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'applicant',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($applicantData);
        echo "✓ " . count($applicantData) . " applicant users created successfully!\n";

        // Add sales user
        $salesData = [
            [
                'username' => 'sales_user',
                'email' => 'sales@ppdb.local',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'sales',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Check if sales user already exists
        $existingSales = $this->db->table('users')->where('role', 'sales')->where('email', 'sales@ppdb.local')->countAllResults();
        
        if ($existingSales === 0) {
            $this->db->table('users')->insertBatch($salesData);
            echo "✓ Sales user created successfully!\n";
        } else {
            echo "⊘ Sales user already exists\n";
        }
    }
}
