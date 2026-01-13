<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full system access and administration',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'panitia',
                'display_name' => 'Panitia PPDB',
                'description' => 'Manages student registration and verification',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'bendahara',
                'display_name' => 'Bendahara',
                'description' => 'Manages payment verification and receipts',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'sales',
                'display_name' => 'Sales Department',
                'description' => 'Views and manages school information and marketing materials',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'applicant',
                'display_name' => 'Calon Siswa',
                'description' => 'Student applicant access',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Truncate existing roles
        $this->db->table('roles')->truncate();
        
        // Insert roles
        $this->db->table('roles')->insertBatch($data);
        
        echo "✓ Roles seeded successfully!\n\n";
        echo "Available Roles:\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        foreach ($data as $role) {
            echo "• {$role['display_name']} ({$role['name']})\n";
            echo "  {$role['description']}\n\n";
        }
    }
}
