<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Create Majors Table
 * 
 * Tabel untuk menyimpan data jurusan yang tersedia
 * Dikelola oleh Admin
 */
class CreateMajorsTable extends Migration
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
            'kode_jurusan' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
                'comment' => 'Kode jurusan (contoh: TKJ, RPL, AKL)',
            ],
            'nama_jurusan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Nama lengkap jurusan',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Deskripsi jurusan',
            ],
            'kuota' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'Kuota siswa untuk jurusan ini',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
                'default' => 'aktif',
                'comment' => 'Status jurusan (aktif/nonaktif)',
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
        $this->forge->createTable('majors');

        // Insert data jurusan contoh
        $data = [
            [
                'kode_jurusan' => 'TKJ',
                'nama_jurusan' => 'Teknik Komputer dan Jaringan',
                'deskripsi' => 'Program keahlian yang mempelajari tentang cara instalasi PC, instalasi LAN, dan instalasi jaringan.',
                'kuota' => 36,
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_jurusan' => 'RPL',
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'deskripsi' => 'Program keahlian yang mempelajari tentang pemrograman, database, dan pengembangan aplikasi.',
                'kuota' => 36,
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_jurusan' => 'AKL',
                'nama_jurusan' => 'Akuntansi dan Keuangan Lembaga',
                'deskripsi' => 'Program keahlian yang mempelajari tentang akuntansi, pembukuan, dan keuangan.',
                'kuota' => 36,
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_jurusan' => 'OTKP',
                'nama_jurusan' => 'Otomatisasi dan Tata Kelola Perkantoran',
                'deskripsi' => 'Program keahlian yang mempelajari tentang administrasi, kesekretarisan, dan manajemen perkantoran.',
                'kuota' => 36,
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('majors')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('majors');
    }
}
