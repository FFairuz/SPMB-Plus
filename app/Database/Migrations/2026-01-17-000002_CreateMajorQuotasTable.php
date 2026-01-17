<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMajorQuotasTable extends Migration
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
            'major_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tahun_ajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'comment' => 'Tahun ajaran (misal: 2026/2027)',
            ],
            'kuota_total' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
                'comment' => 'Total kuota untuk tahun ajaran',
            ],
            'kuota_terisi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
                'comment' => 'Jumlah kuota yang sudah terisi',
            ],
            'jalur_reguler' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
                'comment' => 'Kuota jalur reguler',
            ],
            'jalur_prestasi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
                'comment' => 'Kuota jalur prestasi',
            ],
            'jalur_afirmasi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
                'comment' => 'Kuota jalur afirmasi',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
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
        $this->forge->addForeignKey('major_id', 'majors', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addUniqueKey(['major_id', 'tahun_ajaran'], 'unique_major_tahun');
        $this->forge->createTable('major_quotas');
    }

    public function down()
    {
        $this->forge->dropTable('major_quotas');
    }
}
