<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CreateSalesUser extends Seeder
{
    public function run()
    {
        // Check if sales user already exists
        $existingSales = $this->db->table('users')->where('email', 'sales@ppdb.local')->countAllResults();
        
        if ($existingSales === 0) {
            $salesData = [
                'username' => 'sales_user',
                'email' => 'sales@ppdb.local',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'sales',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('users')->insert($salesData);
            echo "✓ Akun Sales berhasil dibuat!\n";
            echo "  Email: sales@ppdb.local\n";
            echo "  Username: sales_user\n";
            echo "  Password: password123\n";
        } else {
            echo "⊘ Akun Sales sudah ada (sales@ppdb.local)\n";
        }
    }
}
