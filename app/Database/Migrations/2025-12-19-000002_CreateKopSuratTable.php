<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKopSuratTable extends Migration
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
            'school_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'npsn' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'logo_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addKey('id', false, true);
        $this->forge->createTable('kop_surat');
    }

    public function down()
    {
        $this->forge->dropTable('kop_surat');
    }
}
