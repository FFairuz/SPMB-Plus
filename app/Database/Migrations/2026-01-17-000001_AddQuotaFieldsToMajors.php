<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddQuotaFieldsToMajors extends Migration
{
    public function up()
    {
        // Tambah kolom kuota dan tahun ajaran
        $fields = [
            'tahun_ajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'comment' => 'Tahun ajaran untuk kuota (misal: 2026/2027)',
            ],
            'kuota_total' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'default' => 0,
                'comment' => 'Kuota total untuk tahun ajaran',
            ],
            'kuota_terisi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'default' => 0,
                'comment' => 'Jumlah kuota yang sudah terisi',
            ],
        ];

        $this->forge->addColumn('majors', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('majors', ['tahun_ajaran', 'kuota_total', 'kuota_terisi']);
    }
}
