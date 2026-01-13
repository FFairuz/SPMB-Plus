<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGuestBookTable extends Migration
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
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'school_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => false,
            ],
            'sumber_info' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'comment' => 'Media/sumber tahu tentang sekolah: Teman, Guru, Sosial Media, Iklan, Website, Lainnya',
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('guest_books');
    }

    public function down()
    {
        $this->forge->dropTable('guest_books');
    }
}
