<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResetAllUsers extends Seeder
{
    public function run()
    {
        // Disable foreign key checks untuk bisa truncate
        $this->db->disableForeignKeyChecks();
        
        // Hapus semua records dari dependent tables dulu
        $this->db->table('applicants_dapodik')->truncate();
        $this->db->table('documents')->truncate();
        $this->db->table('payments')->truncate();
        
        // Hapus semua users
        $this->db->table('users')->truncate();
        
        // Re-enable foreign key checks
        $this->db->enableForeignKeyChecks();
        echo "✓ Semua akun user dihapus\n\n";

        // Buat akun baru untuk setiap role
        $users = [
            // Admin Role
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
            // Panitia Role
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
            // Bendahara Role
            [
                'username' => 'bendahara',
                'email' => 'bendahara@ppdb.local',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama' => 'Bendahara Utama',
                'role' => 'bendahara',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Sales Role
            [
                'username' => 'sales',
                'email' => 'sales@ppdb.local',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama' => 'Sales Department',
                'role' => 'sales',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Applicant Role - Test Account 1
            [
                'username' => 'siswa1',
                'email' => 'siswa1@ppdb.local',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama' => 'Calon Siswa 1',
                'role' => 'applicant',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Applicant Role - Test Account 2
            [
                'username' => 'siswa2',
                'email' => 'siswa2@ppdb.local',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'nama' => 'Calon Siswa 2',
                'role' => 'applicant',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert akun baru
        foreach ($users as $user) {
            $this->db->table('users')->insert($user);
        }
        
        // Ensure sales role is set (using raw SQL update for extra safety)
        $this->db->query("UPDATE users SET role = 'sales' WHERE email = 'sales@ppdb.local'");
        
        echo "✓ Akun baru berhasil dibuat:\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "Role        │ Email                      │ Password\n";
        echo "━━━━━━━━━━━━│════════════════════════════│═════════════════\n";
        echo "Admin       │ admin@ppdb.local           │ password123\n";
        echo "Panitia     │ panitia@ppdb.local         │ password123\n";
        echo "Bendahara   │ bendahara@ppdb.local       │ password123\n";
        echo "Sales       │ sales@ppdb.local           │ password123\n";
        echo "Applicant 1 │ siswa1@ppdb.local          │ password123\n";
        echo "Applicant 2 │ siswa2@ppdb.local          │ password123\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    }
}
