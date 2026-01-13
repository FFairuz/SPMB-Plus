<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\User;

class SampleSeeder extends Seeder
{
    public function run()
    {
        $userModel = new User();

        // Check if data already exists
        $adminExists = $userModel->where('email', 'admin@ppdb.local')->first();
        
        if ($adminExists) {
            echo "Data already seeded, skipping...";
            return;
        }

        // Create admin user
        $adminData = [
            'username' => 'admin',
            'email' => 'admin@ppdb.local',
            'password' => password_hash('password123', PASSWORD_BCRYPT),
            'role' => 'admin',
            'is_active' => 1,
        ];
        $userModel->insert($adminData);
        echo "✓ Admin user created: admin@ppdb.local / password123\n";

        // Create sample applicant users
        $applicants = [
            [
                'username' => 'applicant1',
                'email' => 'applicant@ppdb.local',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'role' => 'applicant',
                'is_active' => 1,
            ],
            [
                'username' => 'applicant2',
                'email' => 'john.doe@example.com',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'role' => 'applicant',
                'is_active' => 1,
            ],
            [
                'username' => 'applicant3',
                'email' => 'jane.smith@example.com',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'role' => 'applicant',
                'is_active' => 1,
            ],
        ];

        foreach ($applicants as $applicant) {
            $userModel->insert($applicant);
        }

        echo "✓ " . count($applicants) . " applicant users created\n";
        echo "\nSeeding completed successfully!\n";
    }
}
