<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Create Hobbies Table
 * 
 * Tabel untuk menyimpan master data hobi
 * Dikelola oleh Admin
 */
class CreateHobbiesTable extends Migration
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
            'nama_hobi' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
                'comment' => 'Nama hobi',
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'Bootstrap icon class (optional)',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
                'default' => 'aktif',
                'comment' => 'Status hobi (aktif/nonaktif)',
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
        $this->forge->createTable('hobbies');

        // Insert data hobi sample
        $data = [
            ['nama_hobi' => 'Membaca', 'icon' => 'bi-book', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Menulis', 'icon' => 'bi-pencil', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Olahraga', 'icon' => 'bi-trophy', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Musik', 'icon' => 'bi-music-note', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Menyanyi', 'icon' => 'bi-mic', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Menari', 'icon' => 'bi-person-arms-up', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Melukis', 'icon' => 'bi-palette', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Fotografi', 'icon' => 'bi-camera', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Traveling', 'icon' => 'bi-airplane', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Memasak', 'icon' => 'bi-egg-fried', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Gaming', 'icon' => 'bi-controller', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Coding', 'icon' => 'bi-code-slash', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Design Grafis', 'icon' => 'bi-bezier', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Berkebun', 'icon' => 'bi-tree', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Memancing', 'icon' => 'bi-water', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Bermain Alat Musik', 'icon' => 'bi-headphones', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Koleksi', 'icon' => 'bi-collection', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_hobi' => 'Vlogging', 'icon' => 'bi-camera-video', 'status' => 'aktif', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('hobbies')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('hobbies');
    }
}
