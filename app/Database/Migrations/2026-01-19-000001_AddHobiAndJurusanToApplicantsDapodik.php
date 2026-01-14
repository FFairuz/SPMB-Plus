<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Add Hobi and Jurusan fields to applicants_dapodik table
 * 
 * Menambahkan field:
 * - hobi: Hobi siswa (TEXT)
 * - jurusan_id: Foreign key ke tabel majors (INT, NULLABLE)
 */
class AddHobiAndJurusanToApplicantsDapodik extends Migration
{
    public function up()
    {
        // Tambah kolom hobi
        $this->forge->addColumn('applicants_dapodik', [
            'hobi' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'kebutuhan_khusus_lainnya',
            ],
        ]);

        // Tambah kolom jurusan_id
        $this->forge->addColumn('applicants_dapodik', [
            'jurusan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'hobi',
            ],
        ]);

        // Add foreign key ke tabel majors
        $this->forge->addForeignKey('applicants_dapodik', 'jurusan_id', 'majors', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        // Drop foreign key first
        $this->forge->dropForeignKey('applicants_dapodik', 'applicants_dapodik_jurusan_id_foreign');
        
        // Drop columns
        $this->forge->dropColumn('applicants_dapodik', 'jurusan_id');
        $this->forge->dropColumn('applicants_dapodik', 'hobi');
    }
}
