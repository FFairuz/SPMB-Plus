<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAcademicYearsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tahun_ajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'comment' => 'Format: 2026/2027',
            ],
            'tahun_mulai' => [
                'type' => 'YEAR',
                'comment' => 'Tahun mulai (2026)',
            ],
            'tahun_selesai' => [
                'type' => 'YEAR',
                'comment' => 'Tahun selesai (2027)',
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Tanggal mulai tahun ajaran',
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Tanggal selesai tahun ajaran',
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'comment' => 'Tahun ajaran yang sedang aktif',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'nonaktif', 'selesai'],
                'default' => 'aktif',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('academic_years');
    }

    public function down()
    {
        $this->forge->dropTable('academic_years');
    }
}
